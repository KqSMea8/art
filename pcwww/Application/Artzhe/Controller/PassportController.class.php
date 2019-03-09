<?php
namespace Artzhe\Controller;
use Think\Controller;
class PassportController extends Controller {
    public function index(){
        if(empty(session('wx_bind_userinfo'))){
            $this->redirect('/');
        }
        $this->assign('wx_bind_userinfo', session('wx_bind_userinfo'));
        $this->display();
    }
}