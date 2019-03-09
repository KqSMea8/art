<?php

namespace app\passport\controller;

use app\passport\logic\User as UserLogic;
require_once $_SERVER['DOCUMENT_ROOT'] . '/../aliyun/aliyun-oss-php-sdk/autoload.php';

use OSS\OssClient;
use OSS\Core\OssException;

class Index
{

    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1>用户中心';
    }


public function test(){
    $userLogic = new UserLogic();
    $flag = $userLogic->resetPasswd(54354345, 2222);

}

}
