<?php

namespace App10\Controller;

use App10\Base\ApiBaseController;
use App10\Logic\AssetsLogic;
use App10\Logic\ThirdLogic;
use App10\Logic\UserLogic;
use App10\Logic\MessageLogic;
use App10\Logic\InviteLogLogic;
use App10\Logic\FeedbackLogic;
use App10\Model\ThirdModel;
use App10\Model\LoginLogModel;
use Custom\Define\Code;
use Custom\Define\Status;
use Custom\Define\Image;
use Custom\Helper\Checker;
use Custom\Helper\Sms;
use Custom\Helper\Util;
use Custom\Define\Cache;
use Custom\Define\Time;
use Custom\Manager\Token;
use Think\Exception;
use App10\Logic\WxAppGalleryLogic;

class UserController extends ApiBaseController
{


    //微信登录，成功保存第三方信息。未注册用户保存第三方信息，等待绑定
    public function login()
    {
        $device = I('device', '');
        $system = I('system', '');
        $version = I('version', '');
        $code = I('code');

        $loginLogMode = new LoginLogModel();



        $thirdInfoJson = I('post.thirdInfo', '{}');//这里的第三方信息，自定义
        $thirdInfo = html_entity_decode($thirdInfoJson);
        $thirdInfo = json_decode($thirdInfo, true);



        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx9c1b174773d629b8&secret=c3ccedf8ecf6339859c6721d55e94de1&js_code=' . $code . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);

        //获取从微信服务器获得的信息
        $thirdInfo['unionId'] = trim($arr['unionid']);
        $thirdInfo['openId'] = trim($arr['openid']);
        $thirdInfo['session_key'] = trim($arr['session_key']);



        //artzhe服务器从微信服务器获取信息，获取验证失败，则不让登录artzhe
        if (trim($thirdInfo['unionId']) == '') {
            Util::jsonReturn(null, Code::NOT_FOUND, 'error');
        }


        $wxAppGalleryLogic = new WxAppGalleryLogic();
        $Gallery_info = $wxAppGalleryLogic->getOneGalleryByUnionId($thirdInfo['unionId']);


        //没有画廊，自动生成一个
        if (!$Gallery_info) {
            $data = [
                'user_id' => 0,
                'union_id' => $thirdInfo['unionId'],
                'user_face' => $thirdInfo['faceUrl'],
                'user_nickname' => $thirdInfo['nickname'],
                'user_gender' => $thirdInfo['gender'],
                'user_summary' => '',
                'gallery_name' => '',
                'content' => '',
                'creat_time' => time(),
                'status' => 1,
            ];
            $wxAppGalleryLogic->AddGallery($data);

            //生成后取出来
            $Gallery_info = $wxAppGalleryLogic->getOneGalleryByUnionId($thirdInfo['unionId']);
        }


        $GENDER_CN_LIST = [
            1 => '男',
            2 => '女',
            3 => '未知'
        ];

        $userInfo=[
            'unionId'=>$thirdInfo['unionId'],
            'openId'=>$thirdInfo['openId'],
            'session_key'=>$thirdInfo['session_key'],
            'faceUrl' => Util::getFillImage($Gallery_info['user_face'], Image::faceWidth, Image::faceHeight),
            'nickname' => $Gallery_info['user_nickname'],
            'gender' => $GENDER_CN_LIST[$Gallery_info['user_gender']],
        ];


        //开始登录
        $userInfo=$userInfo;
        S(Cache::TOKEN_PREFIX . $this->token,
            ['userInfo' => $userInfo, 'thirdInfo' => $thirdInfo,  'isLogin' => true],
            Time::TOKEN_EXPIRE_1_DAY
        );



        //统计登录信息
        $loginLogMode->addData($device, $system, $version, $this->token, 'User/login');

        Util::jsonReturn(['status' => 1000]);

    }

    public function logout()
    {
        if (!empty($this->token)) {
            S(Cache::TOKEN_PREFIX . $this->token, null);
        }
        Util::jsonReturn();
    }

    public function getToken()
    {
//        $headers = getallheaders();
//        if (empty($headers['X-Artzhe-Time']) || empty($headers['X-Artzhe-Nonce']) || empty($headers['X-Artzhe-Sign'])) {
//            Util::jsonReturn(null, Code::PARAM_ERR, 'Header parameter is Code!', var_export($headers, true));
//        }
//        $time = $headers['X-Artzhe-Time'];//精确到秒(s)
//        $requestTime = (int)$_SERVER['REQUEST_TIME'];
//        if (abs($time - $requestTime) > 5 && !APP_DEBUG) {
//            Util::jsonReturn(null, Code::REQUEST_TIMEOUT, 'Request timeout!', "$time,$requestTime");
//        }
//        $nonce = $headers['X-Artzhe-Nonce'];
//        if (strlen($nonce) < 10) {
//            Util::jsonReturn(null, Code::PARAM_ERR, 'Request parameter is Code!', "$nonce");
//        }
//        $signature = $headers['X-Artzhe-Sign'];
//        //检查签名
//        if (!Util::checkSignature($time, $nonce, null, $signature)) {
//            Util::jsonReturn(null, Code::PARAM_ERR, 'Signature parameter is Code!', "$time, $nonce, $signature");
//        }
        $token = Util::generateUid();
        S(Cache::TOKEN_PREFIX . $token, [], Time::TOKEN_EXPIRE_1_DAY);
        Util::log('test', 'getToken', ['cache' => Cache::TOKEN_PREFIX . $token]);
        Util::jsonReturn(['token' => $token, 'status' => Status::OK]);
    }

}
