<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 14:27
 */

namespace app\passport\controller;

use app\common\PassportController;
use think\Session;
use think\Cache;
use think\Log;
use app\common\AliyunDysms;
use app\passport\logic\Third as ThirdLogic;
use app\passport\logic\User as UserLogic;
use app\common\Util;
use app\common\Code;
use app\common\Crypt3Des;

class User extends PassportController
{


    public function logout()
    {
        if (!is_client_white_list()) {
            Util::jsonReturn(null, Code::SYS_ERR, 'ip不被允许');
        }
        //解密
        $param = trim(input('post.param'));
        $DES = new Crypt3Des();
        $param_decrypt = $DES->decrypt($param);
        $data = json_decode($param_decrypt, true);
        //解密end

        $token = $data['token'];
        $token = strtoupper($token);
        if (preg_match("/^[A-Z0-9]{32}$/", $token)) { //token格式判断

            $userinfo = Cache::get('token.' . $token);
            $userinfo = json_decode($userinfo);
            if (is_object($userinfo)) {
                Cache::set('token.' . $token, null);
                Util::jsonReturn([]);
            } else {
                Util::jsonReturn(null, Code::NOT_FOUND);
            }
        } else {
            Util::jsonReturn(null, Code::PARAM_ERR, 'token格式错误');
        }

    }

    //获取返回地址
    private function get_url_referer_callback($validate_token)
    {

        $passport_url_referer = trim(Session::get('passport_url_REFERER'));
        $back_act = urlencode(Session::get('back_act'));
        if ($passport_url_referer != '') {
            $pos = strpos($passport_url_referer, '?');
            if ($pos > 0) {
                $passport_url_referer = $passport_url_referer . '&back_act=' . $back_act . '&passport_validate_token=' . $validate_token;
            } else {
                $passport_url_referer = $passport_url_referer . '?back_act=' . $back_act . '&passport_validate_token=' . $validate_token;
            }
            return $passport_url_referer;
        } else {
            return '';
        }
    }

    public function getcodeaaaaa()
    {
        $mobile = input('get.mobile');
//        if (isMobile($mobile)) {
//            $code_cache = Cache::get('smscode_' . $mobile);
//            echo $code_cache;
//            exit;
//        }

    }

    public function loginwx()
    {


        return $this->fetch();

    }

    public function register()
    {
        return $this->fetch();
    }

    public function regrule()
    {
        return $this->fetch();
    }

    public function forget()
    {
        return $this->fetch();
    }

    public function test()
    {

        echo '<a href="' . url('user/login') . '">test</a>';

    }

    public function MobileRegSendCode()
    { //手机注册 发验证码
        $mobile = input('post.mobile');
        if (isMobile($mobile)) {
            $smscode_last_sendtime = intval(Session::get('smscode_last_sendtime'));
            if ($smscode_last_sendtime + 60 > time()) {
                Util::jsonReturn(null, Code::PARAM_ERR, '短信验证码已经发送，请一分钟之后再试');
            } else {
                $code = rand(1000, 9999);
                Cache::set('smscode_' . $mobile, $code, 600);
                $AliyunDysms = new AliyunDysms();
                $AliyunDysms->sendCode($mobile, 'reg', $code);

                Session::set('smscode_last_sendtime', time());

                Util::jsonReturn(null, Code::SUCCESS);
            }
        }

        Util::jsonReturn(null, Code::PARAM_ERR);
    }

    public function MobileReg()
    { //手机注册  如果有微信登陆信息wx_bind_userinfo，则捆绑一起
        $mobile = input('post.mobile');
        $code = intval(input('post.code'));
        $password = input('post.password');
        if (isMobile($mobile) && $code && $password != '') {
            $code_cache = Cache::get('smscode_' . $mobile);
            if ($code == $code_cache) {
                $userLogic = new UserLogic();
                $userinfo = $userLogic->getUserInfoByMobile($mobile);
                if (!$userinfo) {
                    $uid = $userLogic->addUser([
                        'mobile' => $mobile,
                        'password' => $password,
                        'nickname' => '',
                        'gender' => '1',
                        'from' => 'web/H5',
                        'faceUrl' => config('Artzhe_default_face'),
                    ]);

                    $userLogic->where(['id' => $uid])->update(['nickname' => '艺' . $uid, 'name' => '艺' . $uid]);
                    if ($uid) {


                        $userInfo = $userLogic->where(['id' => $uid])->find();

                        $userInfo_new = [
                            'id' => $userInfo['id'],
                            'name' => $userInfo['name'],
                            'nickname' => $userInfo['nickname'],
                            'face' => $userInfo['face'],
                            'mobile' => $userInfo['mobile'],
                        ];

                        $wx_bind_userinfo = Session::get('wx_bind_userinfo');
                        if (!empty($wx_bind_userinfo)) {
                            $thirdLogic = new ThirdLogic();
                            $bindThirdId = $thirdLogic->bindToUser($userInfo, $wx_bind_userinfo);
                            Session::set('wx_bind_userinfo', '');
                        }

                        $validate_token = strtoupper(md5($_SERVER['REMOTE_ADDR'] . uniqid(rand(), true)));
                        $proxy_real_ip = trim($_SERVER['HTTP_X_FORWARDED_FOR']) != '' ? trim($_SERVER['HTTP_X_FORWARDED_FOR']) : $_SERVER['REMOTE_ADDR'];
                        Cache::set('passport_validate_token_' . $validate_token, ['userInfo' => $userInfo_new, 'ip' => $_SERVER['REMOTE_ADDR'], 'proxy_real_ip' => $proxy_real_ip], 15);

                        $passport_url_referer = $this->get_url_referer_callback($validate_token);
                        if ($passport_url_referer != '') {
                            Util::jsonReturn(['userInfo' => $userInfo_new, 'redirect' => $passport_url_referer]);
                        } else {
                            Util::jsonReturn(['userInfo' => $userInfo_new]);
                        }


                    } else {
                        Util::jsonReturn(null, Code::SYS_ERR);
                    }

                    Cache::set('smscode_' . $mobile, null, 2);//删除验证码
                } else {
                    Util::jsonReturn(null, Code::SYS_ERR, '您输入的手机号已经存在');
                }

            } else {
                Util::jsonReturn(null, Code::VERIFY_CODE_NOT_MATCHED, '验证码错误');
            }
        }
        Util::jsonReturn(null, Code::PARAM_ERR);
    }


    public function login()
    {


//        Session::set('passport_url_REFERER', $_SERVER['HTTP_REFERER']);
//        echo '<a href="' . url('user/MobileLogin') . '">web</a>';
//        echo '&nbsp;';
//        echo '<a href="' . url('user/WechatLogin') . '?az_back=http%3A%2F%2Ftest-passport.artzhe.com%2Fpassport%2Fuser%2Flogin%3Fggg%3D342&back_act=insert">wechat</a>';
    }

    public function MobileLogin()
    {

//        print_r($_SERVER);exit();


        if ($this->request->isPost()) {

            $mobile = trim(input('post.mobile'));
            if (!isMobile($mobile)) {
                Util::jsonReturn(null, Code::PARAM_ERR);
            }
            $userLogic = new UserLogic();
            $userinfo = $userLogic->getUserInfoByMobile($mobile);
            if ($userinfo) {
                Util::jsonReturn([userInfo => ['id' => $userinfo['id']]]);
            } else {
                Util::jsonReturn(null, Code::NOT_FOUND);
            }

        } else {
            //自动登录,初始化返回地址与参数
            $az_back = trim(input('get.az_back'));
            $back_act = trim(input('get.back_act'));
            if ($az_back != '')
                Session::set('passport_url_REFERER', urldecode($az_back));
            if ($back_act != '')
                Session::set('back_act', urldecode($back_act));
        }
        return $this->fetch();

    }

    public function MobileLoginCheck()
    {

        if ($this->request->isPost()) {
            $mobile = trim(input('post.mobile'));
            $password = input('post.password');
            if (!isMobile($mobile) || trim($password) == '') {
                Util::jsonReturn(null, Code::PARAM_ERR);
            }
            $userLogic = new UserLogic();

            if (!$userLogic->checkMobileRegister($mobile, $password)) {
                Util::jsonReturn(null, Code::PASSWORD_NOT_MATCHED, 'password is error!(1003)');
            }

            $userInfo = $userLogic->where(['mobile' => $mobile])->find();


            $userInfo_new = [
                'id' => $userInfo['id'],
                'name' => $userInfo['name'],
                'nickname' => $userInfo['nickname'],
                'face' => $userInfo['face'],
                'mobile' => $userInfo['mobile'],
                'type' => $userInfo['type'],
                'role' => $userInfo['role'],
            ];
            $validate_token = strtoupper(md5($_SERVER['REMOTE_ADDR'] . uniqid(rand(), true)));
            $proxy_real_ip = trim($_SERVER['HTTP_X_FORWARDED_FOR']) != '' ? trim($_SERVER['HTTP_X_FORWARDED_FOR']) : $_SERVER['REMOTE_ADDR'];
            Cache::set('passport_validate_token_' . $validate_token, ['userInfo' => $userInfo_new, 'ip' => $_SERVER['REMOTE_ADDR'], 'proxy_real_ip' => $proxy_real_ip], 15);

            $passport_url_referer = $this->get_url_referer_callback($validate_token);
            if ($passport_url_referer != '') {
                Util::jsonReturn(['userInfo' => $userInfo_new, 'redirect' => $passport_url_referer]);
            } else {
                Util::jsonReturn(['userInfo' => $userInfo_new]);
            }
        }

    }

    //登陆校验
    public function AccessToken()
    {
        if (!is_client_white_list()) {
            Util::jsonReturn(null, Code::SYS_ERR, 'ip不被允许');
        }

        //解密
        $param = trim(input('post.param'));
        $DES = new Crypt3Des();
        $param_decrypt = $DES->decrypt($param);
        $data = json_decode($param_decrypt, true);
        //解密end

        $passport_validate_token = $data['token'];
        $user_ip = trim($data['user_ip']);
        $proxy_real_ip = trim($data['proxy_real_ip']);

//        Log::write('H5 data:'.$param_decrypt,Log::DEBUG);
        $passport_validate_token = strtoupper($passport_validate_token);
        if (preg_match("/^[A-Z0-9]{32}$/", $passport_validate_token) && $user_ip != '') { //token格式判断
            $passport_validate_token_value = Cache::get('passport_validate_token_' . $passport_validate_token);
//            Log::write(json_encode($passport_validate_token_value), Log::DEBUG);

//            print_r($data);
//            print_r($passport_validate_token_value);
            if ($passport_validate_token_value) {
                if ($passport_validate_token_value['ip'] == $user_ip) {
                    Util::jsonReturn($passport_validate_token_value['userInfo']);
                } elseif ($passport_validate_token_value['proxy_real_ip'] == $proxy_real_ip) {
                    Util::jsonReturn($passport_validate_token_value['userInfo']);
                } else {
                    Util::jsonReturn(null, Code::PARAM_ERR, 'ip地址不匹配');
                }

            }
        }

        Util::jsonReturn(null, Code::PARAM_ERR);

    }


    public function WechatLogin()
    {

        //自动登录,初始化返回地址与参数
        $az_back = trim(input('get.az_back'));
        $back_act = trim(input('get.back_act'));
        if ($az_back != '')
            Session::set('passport_url_REFERER', urldecode($az_back));
        if ($back_act != '')
            Session::set('back_act', urldecode($back_act));


//        $AppID = config('WECHAT')['AppID'];
        $callback = config('WECHAT')['callback'];

        $state = md5(uniqid(rand(), TRUE));
        Session::set('wx_state', $state);
        $callback = urlencode($callback);

        //跳到artzhe授权服务器
        header("Location: " . config('WECHAT_Authorize')['Authorize_server'] . '&auk=' . $callback . '&state=' . $state);
        exit;

        //header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid={$AppID}&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state={$state}#wechat_redirect");
        //exit;
    }

    public function WechatLoginCallback()
    {
        $AppID = config('WECHAT')['AppID'];
        $AppSecret = config('WECHAT')['AppSecret'];


        if ($_GET['state'] != Session::get('wx_state')) {
            echo 'error';
            exit;
        }

        $wechat_userinfo = [];


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
        $wechat_userinfo['unionId'] = trim($arr['unionid']);
        $wechat_userinfo['openId'] = trim($arr['openid']);

        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $arr['access_token'] . '&openid=' . $arr['openid'] . '&lang=zh_CN';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);

        //print_r($arr);
        $wechat_userinfo['partnerCode'] = 'WECHAT';
        $wechat_userinfo['nickname'] = $arr['nickname'];
        $wechat_userinfo['gender'] = $arr['sex'];
        $wechat_userinfo['city'] = $arr['city'];
        $wechat_userinfo['province'] = $arr['province'];
        $wechat_userinfo['country'] = $arr['country'];
        $wechat_userinfo['faceUrl'] = $arr['headimgurl'];

//        print_r($wechat_userinfo);
        if (trim($wechat_userinfo['unionId']) != '') {
            $thirdLogic = new ThirdLogic();
            $userLogic = new UserLogic();
            if ($user_info = $thirdLogic->isUserBindMobile(1, $wechat_userinfo['unionId'], $wechat_userinfo['openId'])) {//微信已经绑定账号，直接登陆
                $userInfo = $userLogic->getUserInfoById($user_info['bind_user_id']);
                $userInfo_new = [
                    'id' => $userInfo['id'],
                    'name' => $userInfo['name'],
                    'nickname' => $userInfo['nickname'],
                    'email' => $userInfo['email'],
                    'face' => $userInfo['face'],
                    'mobile' => $userInfo['mobile'],
                    'create_time' => $userInfo['create_time'],
                    'wechat_unionId' => $wechat_userinfo['unionId'],
                    'wechat_openId' => $wechat_userinfo['openId'],
                    'type' => $userInfo['type'],
                    'role' => $userInfo['role'],
                ];
                $validate_token = strtoupper(md5($_SERVER['REMOTE_ADDR'] . uniqid(rand(), true)));
                $proxy_real_ip = trim($_SERVER['HTTP_X_FORWARDED_FOR']) != '' ? trim($_SERVER['HTTP_X_FORWARDED_FOR']) : $_SERVER['REMOTE_ADDR'];
                Cache::set('passport_validate_token_' . $validate_token, ['userInfo' => $userInfo_new, 'ip' => $_SERVER['REMOTE_ADDR'], 'proxy_real_ip' => $proxy_real_ip], 15);

                $passport_url_referer = $this->get_url_referer_callback($validate_token);
                if ($passport_url_referer != '') {
                    header("Location: " . $passport_url_referer);
                    exit;
                } else {
                    header("Location: /");
                    exit;
                }


            } else {//wechat 还未捆绑手机
                Session::set('wx_bind_userinfo', $wechat_userinfo);
                header("Location: " . url('user/WechatBindMobileLogin'));
                exit;
            }


        }


    }

    //微信登陆后，没有绑定账号时，进行绑定的第一步
    public function WechatBindMobileLogin()
    {
        if ($this->request->isPost()) {

            $mobile = trim(input('post.mobile'));
            if (!isMobile($mobile)) {
                Util::jsonReturn(null, Code::PARAM_ERR);
            }
            $userLogic = new UserLogic();
            $userinfo = $userLogic->getUserInfoByMobile($mobile);
            if ($userinfo) {

                Util::jsonReturn([userInfo => ['id' => $userinfo['id']]]);
            } else {
                Util::jsonReturn(null, Code::NOT_FOUND);
            }

        }
        $wx_bind_userinfo = Session::get('wx_bind_userinfo');
        $this->assign('wx_bind_userinfo', $wx_bind_userinfo);
        return $this->fetch();
    }

    //微信登陆后，对于没有绑定的，输入手机和密码，进行绑定
    public function WechatBindMobileLoginCheck()
    {

        if ($this->request->isPost()) {
            $mobile = trim(input('post.mobile'));
            $password = input('post.password');
            if (!isMobile($mobile) || trim($password) == '' || empty(Session::get('wx_bind_userinfo'))) {
                Util::jsonReturn(null, Code::PARAM_ERR);
            }
            $userLogic = new UserLogic();

            if (!$userLogic->checkMobileRegister($mobile, $password)) {
                Util::jsonReturn(null, Code::PASSWORD_NOT_MATCHED, 'password is error!(1003)');
            }

            $userInfo = $userLogic->where(['mobile' => $mobile])->find();

            $userInfo_new = [
                'id' => $userInfo['id'],
                'name' => $userInfo['name'],
                'nickname' => $userInfo['nickname'],
                'face' => $userInfo['face'],
                'mobile' => $userInfo['mobile'],
            ];

            //用户捆绑wechat
            $thirdLogic = new ThirdLogic();
            $wx_bind_userinfo = Session::get('wx_bind_userinfo');
            $bindThirdId = $thirdLogic->bindToUser($userInfo, $wx_bind_userinfo);
            Session::set('wx_bind_userinfo', '');

            $validate_token = strtoupper(md5($_SERVER['REMOTE_ADDR'] . uniqid(rand(), true)));
            $proxy_real_ip = trim($_SERVER['HTTP_X_FORWARDED_FOR']) != '' ? trim($_SERVER['HTTP_X_FORWARDED_FOR']) : $_SERVER['REMOTE_ADDR'];
            Cache::set('passport_validate_token_' . $validate_token, ['userInfo' => $userInfo_new, 'ip' => $_SERVER['REMOTE_ADDR'], 'proxy_real_ip' => $proxy_real_ip], 15);

            $passport_url_referer = $this->get_url_referer_callback($validate_token);
            if ($passport_url_referer != '') {
                Util::jsonReturn(['userInfo' => $userInfo_new, 'redirect' => $passport_url_referer]);
            } else {
                Util::jsonReturn(['userInfo' => $userInfo_new]);
            }
        }

    }

    //根据token获取用户信息
    public function getInfo()
    {
        if (!is_client_white_list()) {
            Util::jsonReturn(null, Code::SYS_ERR, 'ip不被允许');
        }
        //解密
        $param = trim(input('post.param'));
        $DES = new Crypt3Des();
        $param_decrypt = $DES->decrypt($param);
        $data = json_decode($param_decrypt, true);
        //解密end

        $token = $data['token'];
        $token = strtoupper($token);
        if (preg_match("/^[A-Z0-9]{32}$/", $token)) { //token格式判断

            $userinfo = Cache::get('token.' . $token);
            $userinfo = json_decode($userinfo);
            if (is_object($userinfo)) {
                $userInfo_new = [
                    'id' => (int)$userinfo->userInfo->id,
                    'name' => $userinfo->userInfo->name,
                    'nickname' => $userinfo->userInfo->nickname,
                    'email' => $userinfo->userInfo->email,
                    'face' => $userinfo->userInfo->face,
                    'mobile' => $userinfo->userInfo->mobile,
                    'create_time' => $userinfo->userInfo->create_time,


                ];
                Util::jsonReturn($userInfo_new);
            } else {
                Util::jsonReturn(null, Code::NOT_FOUND);
            }
        } else {
            Util::jsonReturn(null, Code::PARAM_ERR, 'token格式错误');
        }


    }

    //根据token获取用户信息
    public function getInfoById()
    {
        if (!is_client_white_list()) {
            Util::jsonReturn(null, Code::SYS_ERR, 'ip不被允许');
        }
        //解密
        $param = trim(input('post.param'));
        $DES = new Crypt3Des();
        $param_decrypt = $DES->decrypt($param);
        $data = json_decode($param_decrypt, true);
        //解密end

        $user_id = (int)$data['user_id'];

        if ($user_id > 0) { //token格式判断
            $userLogic = new UserLogic();
            $userinfo = $userLogic->where(['id' => $user_id])->find();

            if ($userinfo) {
                $userInfo_new = [
                    'id' => (int)$userinfo['id'],
                    'name' => $userinfo['name'],
                    'nickname' => $userinfo['nickname'],
                    'email' => $userinfo['email'],
                    'face' => $userinfo['face'],
                    'mobile' => $userinfo['mobile'],
                    'create_time' => $userinfo['create_time'],

                ];
                Util::jsonReturn($userInfo_new);
            } else {
                Util::jsonReturn(null, Code::NOT_FOUND, '用户不存在');
            }
        } else {
            Util::jsonReturn(null, Code::PARAM_ERR, 'user_id格式错误');
        }


    }

    //修改密码
    public function resetPasswd()
    {
        $mobile = input('post.mobile');
        $code = intval(input('post.code'));
        $newPassword = input('post.newPassword');
        if (isMobile($mobile) && $code && $newPassword != '') {
            $code_cache = Cache::get('smscode_' . $mobile);
            if ($code == $code_cache) {
                $userLogic = new UserLogic();
                $flag = $userLogic->resetPasswd($mobile, $newPassword);
                Cache::set('smscode_' . $mobile, null, 2);//删除验证码


                //改完密码，直接登陆
                $password = $newPassword;
                $userLogic = new UserLogic();

                if (!$userLogic->checkMobileRegister($mobile, $password)) {
                    Util::jsonReturn(null, Code::PASSWORD_NOT_MATCHED, 'password is error!(1003)');
                }

                $userInfo = $userLogic->where(['mobile' => $mobile])->find();

                $userInfo_new = [
                    'id' => $userInfo['id'],
                    'name' => $userInfo['name'],
                    'nickname' => $userInfo['nickname'],
                    'face' => $userInfo['face'],
                    'mobile' => $userInfo['mobile'],
                ];

                $wx_bind_userinfo = Session::get('wx_bind_userinfo');
                if (!empty($wx_bind_userinfo)) {
                    $thirdLogic = new ThirdLogic();
                    $bindThirdId = $thirdLogic->bindToUser($userInfo, $wx_bind_userinfo);
                    Session::set('wx_bind_userinfo', '');
                }

                $validate_token = strtoupper(md5($_SERVER['REMOTE_ADDR'] . uniqid(rand(), true)));
                $proxy_real_ip = trim($_SERVER['HTTP_X_FORWARDED_FOR']) != '' ? trim($_SERVER['HTTP_X_FORWARDED_FOR']) : $_SERVER['REMOTE_ADDR'];
                Cache::set('passport_validate_token_' . $validate_token, ['userInfo' => $userInfo_new, 'ip' => $_SERVER['REMOTE_ADDR'], 'proxy_real_ip' => $proxy_real_ip], 15);

                $passport_url_referer = $this->get_url_referer_callback($validate_token);
                if ($passport_url_referer != '') {
                    Util::jsonReturn(['userInfo' => $userInfo_new, 'redirect' => $passport_url_referer]);
                } else {
                    Util::jsonReturn(['userInfo' => $userInfo_new]);
                }
                //改完密码，直接登陆 end


            } else {
                Util::jsonReturn(null, Code::NOT_FOUND, '验证码错误');
            }
        } else {
            Util::jsonReturn(null, Code::PARAM_ERR, '验证码和密码不能为空');
        }

        Util::jsonReturn(null, Code::PARAM_ERR);

    }

}