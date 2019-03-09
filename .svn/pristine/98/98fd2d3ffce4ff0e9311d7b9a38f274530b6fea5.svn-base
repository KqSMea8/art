<?php

namespace Api\Base;

use Custom\Helper\Checker;
use Custom\Manager\Token;
use Think\Controller;
use Think\Hook;
use Custom\Helper\Util;
use Custom\Define\Code;
use Custom\Define\Cache;
use Custom\Define\Time;
use Custom\Helper\Validate;

class ApiBaseController extends Controller
{
    protected $logic = null;
    protected $userInfo = null;
    protected $loginUserId = null;
    protected $emptyObject = null;
    protected $token = null;

    protected static $allowNoTokenMethodList = ['getToken','getVerifyCode','test','uploadTest', 'uploadCallback' ];
    public function __construct()
    {


        Util::log(CONTROLLER_NAME ,ACTION_NAME ,array_merge($_GET,$_POST));


        //Hook::listen('action_begin',$this->config);

        //控制器初始化
        if(method_exists($this,'_initialize'))
        {
            $this->_initialize();
        }
        $this->userInfo = Token::isLogin($this->token);

        if (!empty($this->userInfo)) {
            $this->loginUserId = $this->userInfo['id'];
        }
    }
    public function _empty()
    {
        exit('404 Not Found!');
    }
    protected function isLogin()
    {
        if (empty($this->userInfo)) {
            return false;
        } else {
            $this->loginUserId = $this->userInfo['id'];
            return true;
        }
    }

    protected function checkLogin(){
      if(!$this->isLogin()){
        Util::jsonReturn(null,Code::HAVE_NO_RIGHT);exit;
      }
    }

    protected function _initialize()
    {
        $this->emptyObject = new \stdClass();

        //$token = I('get.token', null);

        $token=cookie('web_token');

        //自动获取token
        if (trim($token)=='') {
            $token = Util::generateUid();
            S(Cache::TOKEN_PREFIX.$token, [],Time::TOKEN_EXPIRE_1_DAY);
            //cookie('web_token',$token,'expire=86400&httponly=1&domain=artzhe.com');
            cookie('web_token',$token,'httponly=1&domain=artzhe.com');
            //setcookie('web_token',$token,time()+99999,'/','127-mp.artzhe.com');
        }else{
            if(!Validate::isMd5In32($token)) {
                $token = Util::generateUid();
                S(Cache::TOKEN_PREFIX.$token, [],Time::TOKEN_EXPIRE_1_DAY);
                //cookie('web_token',$token,'expire=86400&httponly=1&domain=artzhe.com');
                cookie('web_token',$token,'httponly=1&domain=artzhe.com');
            }else {
                $tokenInfo = S(Cache::TOKEN_PREFIX . $token);
                if (!is_array($tokenInfo) && empty($tokenInfo)) {
                    $token = Util::generateUid();
                    S(Cache::TOKEN_PREFIX . $token, [],Time::TOKEN_EXPIRE_1_DAY);
                    //cookie('web_token',$token,'expire=86400&httponly=1&domain=artzhe.com');
                    cookie('web_token',$token,'httponly=1&domain=artzhe.com');
                }
            }
        }
        $this->token = $token;


        /*
         if(!in_array(ACTION_NAME, self::$allowNoTokenMethodList))
        {
            $this->token = Checker::token($token);
        } else {
            if (!is_null($token)) {
                $this->token = $token;
            }
        }
         */
    }
    //_initialize_bak20170915
    protected function _initialize2()
    {
        $this->emptyObject = new \stdClass();

        $token = I('get.token', null);

        if(!in_array(ACTION_NAME, self::$allowNoTokenMethodList))
        {
            $this->token = Checker::token($token);
        } else {
            if (!is_null($token)) {
                $this->token = $token;
            }
        }
    }
}
