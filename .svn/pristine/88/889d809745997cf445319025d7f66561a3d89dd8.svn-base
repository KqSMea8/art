<?php

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Custom\Helper\Util;
use Custom\Define\Code;
use Api\Logic\ThirdLogic;
use Api\Logic\UserLogic;
use Custom\Define\Cache;
use Custom\Define\Time;
use Custom\Manager\Token;
use Api\Logic\MessageLogic;

class WechatController extends ApiBaseController
{

    public function ScanCode()
    {
        $AppID = C('WECHAT')['AppID'];
        $callback = C('WECHAT')['ScanCode_callback']; //回调地址
        //微信登录
        //-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
        session('wx_state', $state);//存到SESSION
        session('wx_url_REFERER',$_SERVER['HTTP_REFERER']);
        $callback = urlencode($callback);
        //$wxurl = "https://open.weixin.qq.com/connect/qrconnect?appid=" . $AppID . "&redirect_uri={$callback}&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
        $wxurl = 'https://open.weixin.qq.com/connect/qrconnect?appid=' . $AppID . '&redirect_uri=' . $callback . '&response_type=code&scope=snsapi_login&state=' . $state ;
        $css_base64='&href=data:text/css;base64,LmltcG93ZXJCb3ggLnFyY29kZSB7d2lkdGg6IDI0MHB4OyBtYXJnaW4tdG9wOiAwcHg7fS5pbXBvd2VyQm94IC50aXRsZSB7ZGlzcGxheTogbm9uZTt9LmltcG93ZXJCb3ggLmluZm8ge3dpZHRoOiAyMDBweDtkaXNwbGF5OiBub25lO30uc3RhdHVzX2ljb24ge2Rpc3BsYXnvvJpub25lfS5pbXBvd2VyQm94IC5zdGF0dXMge3RleHQtYWxpZ246IGNlbnRlcjt9';
        header("Location: $wxurl".$css_base64.'#wechat_redirect');
    }

    public function ScanCodeCallback()
    {
        $userLogic = new UserLogic();
        $thirdLogic = new ThirdLogic();

        if ($_GET['state'] != session('wx_state')) {
            echo 'error';
            exit;
        }

        $wechat_userinfo = [];


        $AppID = C('WECHAT')['AppID'];
        $AppSecret = C('WECHAT')['AppSecret'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $AppID . '&secret=' . $AppSecret . '&code=' . $_GET['code'] . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);
//得到 access_token 与 openid
        //print_r($arr);
        $wechat_userinfo['unionId'] = $arr['unionid'];
        $wechat_userinfo['openId'] = $arr['openid'];

        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $arr['access_token'] . '&openid=' . $arr['openid'] . '&lang=zh_CN';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);

        //print_r($arr);
        $wechat_userinfo['partnerCode']='WECHAT';
        $wechat_userinfo['nickname'] = $arr['nickname'];
        $wechat_userinfo['gender'] = $arr['sex'];
        $wechat_userinfo['city'] = $arr['city'];
        $wechat_userinfo['province'] = $arr['province'];
        $wechat_userinfo['country'] = $arr['country'];
        $wechat_userinfo['faceUrl'] = $arr['headimgurl'];

        $thirdInfo = $wechat_userinfo;
        $thirdFullInfoJson = json_encode($wechat_userinfo);

        if (trim($wechat_userinfo['unionId']) != '' && trim($wechat_userinfo['openId']) != '') {
            if ($bindUserId = $thirdLogic->isUserBindMobile(1, $wechat_userinfo['unionId'], $wechat_userinfo['openId'])) {//微信已经绑定账号，直接登陆
                //2.if user has bound mobile then login success and return the inviteCode
                $userInfo = $userLogic->getUserInfoById($bindUserId);

                //黑名单用户验证 start
                $user_blacklist_M=M('user_blacklist');
                $where['status']=1;
                $where['user_id']=$userInfo['id'];
                $blacklist_info=$user_blacklist_M->where($where)->find();
                if($blacklist_info){
                    echo '该用户('.$userInfo['id'].')被列入黑名单，被禁止';
                    exit;
                }
                //黑名单用户验证 end


                if ($userInfo['type'] == 3 || $userInfo['type'] == 7) {
                    $isArtist = 1;
                } else {
                    $isArtist = -1;
                }
                S(Cache::TOKEN_PREFIX . $this->token,
                    ['userInfo' => $userInfo, 'thirdInfo' => $thirdInfo, 'thirdFullInfoJson' => $thirdFullInfoJson, 'isLogin' => true, 'isArtist' => $isArtist],
                    Time::TOKEN_EXPIRE_30_DAY
                );
                $userLogic->saveLoginInfo($bindUserId);
                $inviteCode = Util::genInviteCode($bindUserId);
                session('wx_bind_userinfo', null);
                header("Location: ".session('wx_url_REFERER'));
                // Util::jsonReturn(['status' => 1000, 'inviteCode' => $inviteCode, 'isArtist' => $isArtist, 'userid' => $userInfo['id']]);
            } else {//还未bind账号，提示bind
                //3.if current weChat user has not bound the mobile
                S(Cache::TOKEN_PREFIX . $this->token,
                    ['thirdInfo' => $thirdInfo, 'thirdFullInfoJson' => $thirdFullInfoJson],
                    Time::TOKEN_EXPIRE_30_DAY
                );
                session('wx_bind_userinfo', $wechat_userinfo);
                header("Location: /passport/index");
                // Util::jsonReturn(['status' => 1001,'no bind']);
            }
        }
    }



    //bind new weChat account to the specified mobile, include forget the password and fill in the verify code.
    public function bindNewWeChat()
    {
        if(empty(session('wx_bind_userinfo'))){
            echo 'error';
            exit;
        }
        $mobile = I('post.mobile', '');
        if (empty($mobile)) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'mobile format is error!(1001)');
        }
        $verifyCode = I('post.verifyCode', '');
        $newPassword = I('post.newPassword', '');

        $password = I('post.password', '');
        if (empty($verifyCode) && empty($password)) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'verifyCode or password format is empty at the same time!(1002)');
        }
        $tokenInfo = Token::getTokenInfo($this->token);
        $userLogic = new UserLogic();

        if (!empty($password)) {
            if ($userLogic->checkMobileRegister($mobile, $password))
            {
                $thirdLogic = new ThirdLogic();
                $userInfo = $userLogic->getUserInfoByMobile($mobile);

                $bindThirdId = $thirdLogic->bindToUser($userInfo['id'], $tokenInfo['thirdInfo'], $tokenInfo['thirdFullInfoJson']);
                if ($bindThirdId) {
                    $inviteCode = Util::genInviteCode($userInfo['id']);
                    //login success then add userInfo to token info cache.
                    Token::mergeTokenInfo($this->token, ['userInfo'=>$userInfo]);
                    if ($userInfo['type'] == 3 || $userInfo['type'] == 7) {
                        $isArtist = 1;
                    } else {
                        $isArtist = -1;
                    }
                    session('wx_bind_userinfo', null);
                    Util::jsonReturn(['status'=>1000, 'inviteCode'=>$inviteCode, 'isArtist'=>$isArtist,'userid'=>$userInfo['id'],'go_url'=>session('wx_url_REFERER')]);
                } else {
                    Util::jsonReturn(null, Code::SYS_ERR);
                }
            } else {
                //password cannot match the mobile.
                Util::jsonReturn(null, Code::PASSWORD_NOT_MATCHED, 'password is error!(1003)');
            }
        }
        //forget password,input the mobile verify code.
        if (!empty($verifyCode)) {
            if (empty($newPassword)) {
                Util::jsonReturn(null, Code::PARAM_ERR, 'newPassword is error!(1004)');
            }
            $checkResult = Util::checkVerifyCodeResult($mobile,$verifyCode);
            if ($checkResult['code'] === Code::SYS_OK) {
                //the verify code matched, then remove the verify code cache.
                S(Cache::VERIFY_CODE_PREFIX.$mobile, null);
                $from = I('post.from','');
                $thirdLogic = new ThirdLogic();
                $userInfo = $userLogic->getUserInfoByMobile($mobile);
                //if the user is the newcomer.
                if (empty($userInfo)) {
                    $params = [
                        'mobile'=>$mobile,
                        'nickname'=>htmlentities($tokenInfo['thirdInfo']['nickname'],ENT_QUOTES),
                        'password'=>$newPassword,
                        'from' => $from,
                        'gender'=>(int)$tokenInfo['thirdInfo']['gender'],
                        'faceUrl'=>htmlentities($tokenInfo['thirdInfo']['faceUrl'],ENT_QUOTES)
                    ];
                    $userId = $userLogic->addUser($params);
                    $messageLogic = new MessageLogic();
                    $messageLogic->welcomeMsg($userId);
                } else {
                    //input the password to login.
                    //$userId = $userInfo['id'];//20171013
                    Util::jsonReturn(null, Code::MOBILE_EXISTED,'该号码已经注册了');//该接口不再提供忘记密码登陆功能
                }
                //forget the password
                if (empty($userInfo)) {
                    $userInfo = $userLogic->getUserInfoById($userId);
                }
                $bindThirdId = $thirdLogic->bindToUser($userId, $tokenInfo['thirdInfo'], $tokenInfo['thirdFullInfoJson']);
                if ($bindThirdId) {
                    $inviteCode = Util::genInviteCode($userId);
                    //login success then add userInfo to token info cache.
                    Token::mergeTokenInfo($this->token, ['userInfo'=>$userInfo]);
                    if ($userInfo['type'] == 3 || $userInfo['type'] == 7) {
                        $isArtist = 1;
                    } else {
                        $isArtist = -1;
                    }
                    session('wx_bind_userinfo', null);
                    Util::jsonReturn(['status'=>1000, 'inviteCode'=>$inviteCode, 'isArtist'=>$isArtist,'userid'=>$userId,'go_url'=>session('wx_url_REFERER')]);
                } else {
                    Util::jsonReturn(null, Code::SYS_ERR);
                }
            } else {
                Util::jsonReturn(null, $checkResult['code'], $checkResult['message']);
            }
        }
        //todo the rest case.
    }



    public function dddd()
    {
        $mobile=I('get.mobile', '');

        //echo Crypt::
        echo  S(Cache::VERIFY_CODE_PREFIX . $mobile);
    }

}