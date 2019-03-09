<?php

namespace App10\Base;

use Custom\Helper\Checker;
use Custom\Manager\Token;
use Think\Controller;
use Think\Hook;
use Custom\Helper\Util;
use Custom\Define\Code;

class ApiBaseController extends Controller
{
    protected $logic = null;
    protected $userInfo = null;
    protected $loginUnionId = null;
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
            $this->loginUnionId = $this->userInfo['unionId'];
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
            $this->loginUnionId = $this->userInfo['unionId'];
            return true;
        }
    }

    protected function checkLogin(){
      if(!$this->isLogin()){
        Util::jsonReturn(null,Code::HAVE_NO_RIGHT,'have no right!');exit;
      }
    }

    protected function _initialize()
    {
        $this->emptyObject = new \stdClass();

       // $token = I('get.token', null);
        $token = cookie('token');
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
