<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23
 * Time: 16:05
 */

namespace app\passport\controller;

use app\common\PassportController;


class Wechatauthorize extends PassportController
{
    public function getcode(){
        $appId = config('WECHAT')['AppID'];
        $authorize = new \app\common\WechatAuthorize($appId);
        $website_list_allow = config('WECHAT_Authorize')['website_list_allow'];
        $authorize->authorizeCodeToUrl($website_list_allow);
        exit();
    }

}