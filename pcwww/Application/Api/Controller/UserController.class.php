<?php
namespace Api\Controller;

use Api\Base\ApiBaseController;
use Api\Logic\AssetsLogic;
use Api\Logic\ThirdLogic;
use Api\Logic\UserLogic;
use Api\Logic\MessageLogic;
use Api\Logic\InviteLogLogic;
use Custom\Define\Code;
use Custom\Define\Status;
use Custom\Define\Image;
use Custom\Helper\Checker;
use Custom\Helper\Sms;
use Custom\Helper\Util;
use Custom\Define\Cache;
use Custom\Define\Time;
use Custom\Manager\Token;
use Custom\Helper\Validate;
use Think\Exception;


class UserController extends ApiBaseController
{
    //退出登录
    public function logout()
    {
        if (!empty($this->token)) {
            S(Cache::TOKEN_PREFIX . $this->token, null);
        }
        Util::jsonReturn();
    }

    //帐号密码登录/注册
    public function accountLogin()
    {
        $mobile = I('post.mobile', '');

        $verifyCode = I('post.verifyCode', '');

        $password = I('post.password', '');

        $from = I('post.from', '');

        $userLogic = new UserLogic();
        if (!empty($verifyCode)) {
            //注册
            $checkResult = Util::checkVerifyCodeResult($mobile, $verifyCode);
            if ($checkResult['code'] === Code::SYS_OK) {
                if (!empty($userLogic->getUserInfoByMobile($mobile, $password))) {
                    Util::jsonReturn(null, Code::MOBILE_EXISTED, 'user already exists!(30114)');
                }
                $uid = $userLogic->addUser([
                    'mobile' => $mobile,
                    'password' => $password,
                    'nickname' => '',
                    'gender' => '1',
                    'from' => $from,
                    'faceUrl' => 'https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png',
                ]);

                $userLogic->where(['id' => $uid])->setField('nickname', '艺' . $uid);

                $messageLogic = new MessageLogic();
                $messageLogic->welcomeMsg($uid);
            } else {
                Util::jsonReturn(null, $checkResult['code'], $checkResult['message']);
            }
        }

        if (!$userLogic->checkMobileRegister($mobile, $password)) {
            Util::jsonReturn(null, Code::PASSWORD_NOT_MATCHED, 'password is error!(1003)');
        }

        $userinfo = $userLogic->where(['mobile' => $mobile])->find();


        //黑名单用户验证 start
        $user_blacklist_M=M('user_blacklist');
        $where['status']=1;
        $where['user_id']=$userinfo['id'];
        $blacklist_info=$user_blacklist_M->where($where)->find();
        if($blacklist_info){
            Util::jsonReturn(null, Code::SYS_ERR, '该用户被列入黑名单，被禁止');
            exit;
        }
        //黑名单用户验证 end

        $isArtist = $userinfo['type'] == 3 ? 1 : -1;

        $inviteLogic = new InviteLogLogic();

        $inviteCode = $inviteLogic->getInvite($userinfo['id']);
        $userLogic->saveLoginInfo($userinfo['id']);
        //login
        S(Cache::TOKEN_PREFIX . $this->token,
            ['userInfo' => $userinfo,
                'thirdInfo' => [],
                'thirdFullInfoJson' => [],
                'isLogin' => true,
                'isArtist' => $isArtist
            ],
            Time::TOKEN_EXPIRE_30_DAY
        );
        Util::jsonReturn(['status' => 1000, 'inviteCode' => $inviteCode, 'isArtist' => $isArtist, 'userid' => $userinfo['id']]);
    }

    //发送短信验证码
    public function sendVerifyCode()
    {
        try {
            $mobile = Checker::mobile();
            $randomCode = Sms::generateRandomCode();
            $debug = I('get.debug', 'off');//on or off
            if ($debug === 'on') {
                S(Cache::VERIFY_CODE_PREFIX . $mobile, $randomCode, ['expire' => Time::VERIFY_CODE_EXPIRE_30_MIN]);
                Util::jsonReturn(null, Code::SYS_OK, 'success', "$randomCode");
            }
            $sendState = Sms::sendByRpc($mobile, $randomCode);
            if ($sendState['state'] === 200) {
                S(Cache::VERIFY_CODE_PREFIX . $mobile, $randomCode, ['expire' => Time::VERIFY_CODE_EXPIRE_30_MIN]);
                Util::jsonReturnSuccess();
            } else {
                throw  new Exception(var_export($sendState, true), -1);
            }
        } catch (Exception $e) {
            Util::jsonReturn(null, Code::SYS_ERR, 'Verify code send failed!', $e->getMessage());
        }
    }

    //获取验证码
    public function getVerifyCode()
    {
        $mobile = I('get.mobile');
        if(!Validate::isMobile($mobile))
        {
            Util::jsonReturn(null, Code::MOBILE_ERR, 'Mobile format is error!', var_export($mobile, true));
        }
        var_export(S(Cache::VERIFY_CODE_PREFIX.$mobile));
    }

    public function getToken()
    {
        $headers = getallheaders();
        if (empty($headers['X-Artzhe-Time']) || empty($headers['X-Artzhe-Nonce']) || empty($headers['X-Artzhe-Sign'])) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'Header parameter is Code!', var_export($headers, true));
        }
        $time = $headers['X-Artzhe-Time'];//精确到秒(s)
        $requestTime = (int)$_SERVER['REQUEST_TIME'];
        if (abs($time - $requestTime) > 5 && !APP_DEBUG) {
            Util::jsonReturn(null, Code::REQUEST_TIMEOUT, 'Request timeout!', "$time,$requestTime");
        }
        $nonce = $headers['X-Artzhe-Nonce'];
        if (strlen($nonce) < 10) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'Request parameter is Code!', "$nonce");
        }
        $signature = $headers['X-Artzhe-Sign'];
        //检查签名
        if (!Util::checkSignature($time, $nonce, null, $signature)) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'Signature parameter is Code!', "$time, $nonce, $signature");
        }
        $token = Util::generateUid();
        S(Cache::TOKEN_PREFIX . $token, []);
        Util::log('test', 'getToken', ['cache' => Cache::TOKEN_PREFIX . $token]);
        Util::jsonReturn(['token' => $token, 'status' => Status::OK]);
    }

    //忘记密码-重置密码
    public function resetPasswd()
    {
        $mobile = I('post.mobile', '');
        if (empty($mobile)) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'mobile format is error!(1001)');
        }
        $verifyCode = I('post.verifyCode', '');
        $newPassword = I('post.newPassword', '');
        if (empty($verifyCode) && empty($newPassword)) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'verifyCode or newPassword format is empty at the same time!(1002)');
        }
        $checkResult = Util::checkVerifyCodeResult($mobile, $verifyCode);
        if ($checkResult['code'] === Code::SYS_OK) {
            S(Cache::VERIFY_CODE_PREFIX . $mobile, null);
        }
        $userLogic = new UserLogic();
        $flag = $userLogic->resetPasswd($mobile, $newPassword);


        $userinfo = $userLogic->where(['mobile' => $mobile])->find();

        $isArtist = $userinfo['type'] == 3 ? 1 : -1;
        //login
        S(Cache::TOKEN_PREFIX . $this->token,
            ['userInfo' => $userinfo,
                'thirdInfo' => [],
                'thirdFullInfoJson' => [],
                'isLogin' => true,
                'isArtist' => $isArtist
            ],
            Time::TOKEN_EXPIRE_30_DAY
        );
        Util::jsonReturn(['status' => 1000, 'mobile' => $mobile, 'flag' => $flag]);
    }

}
