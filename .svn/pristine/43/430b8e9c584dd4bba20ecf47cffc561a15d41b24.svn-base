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
//微信网页授权
class WechatLicenseController extends ApiBaseController
{
    /**
     * 获取微信授权
     */
    public function ScanCode()
    {
        $AppID = C('WECHAT_PUBLIC')['AppID'];
        $callback = C('WECHAT_PUBLIC')['ScanCode_callback'];//"http://local-www.artzhe.com/Api/WechatLicense/CodeCallback"; //回调地址
        //微信登录
        //-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
        //session('wx_state', $state);//存到SESSION
        S(Cache::WX_STATE,
            ['state' => $state],
            Time::VERIFY_CODE_EXPIRE_30_MIN
        );

        $callback = urlencode($callback);
        //获取微信用户信息
        $wxurl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $AppID . '&redirect_uri=' . $callback . '&response_type=code&scope=snsapi_userinfo&state=' . $state;
        // $css_base64='&href=data:text/css;base64,LmltcG93ZXJCb3ggLnFyY29kZSB7d2lkdGg6IDI0MHB4OyBtYXJnaW4tdG9wOiAwcHg7fS5pbXBvd2VyQm94IC50aXRsZSB7ZGlzcGxheTogbm9uZTt9LmltcG93ZXJCb3ggLmluZm8ge3dpZHRoOiAyMDBweDtkaXNwbGF5OiBub25lO30uc3RhdHVzX2ljb24ge2Rpc3BsYXnvvJpub25lfS5pbXBvd2VyQm94IC5zdGF0dXMge3RleHQtYWxpZ246IGNlbnRlcjt9';
        header("Location: $wxurl".'#wechat_redirect');
        // Util::jsonReturn(['status' => 1001,'userinfo' => $wxurl]);
    }


    /**
     * 微信用户授权回调
     */
    public function CodeCallback()
    {
        if ($_GET['state'] !=  S(Cache::WX_STATE)['state']) {
            echo 'error';
            exit;
        }
        $wechat_userinfo = [];
        $wechat_userinfo['code'] = $_GET['code'];
        //获取access_token
        $AppID = C('WECHAT_PUBLIC')['AppID'];
        $AppSecret = C('WECHAT_PUBLIC')['AppSecret'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $AppID . '&secret=' . $AppSecret . '&code=' . $_GET['code'] . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);
        $wechat_userinfo['openid'] = $arr['openid'];
        $wechat_userinfo['access_token'] = $arr['access_token'];
        $wechat_userinfo['refresh_token'] = $arr['refresh_token'];

        //刷新access_token
       /* $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=' . $AppID . '&refresh_token=' . $wechat_userinfo['refresh_token'] . '&grant_type=refresh_token';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);
        $wechat_userinfo['openId2'] = $arr['openid'];
        $wechat_userinfo['access_token2'] = $arr['access_token'];
        $wechat_userinfo['refresh_token2'] = $arr['refresh_token'];*/

        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $arr['access_token'] . '&openid=' . $arr['openid'] . '&lang=zh_CN';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);
        $wechat_userinfo['userinfo'] = $arr;

        if (trim($arr['openid']) != '') {
            //跳转至活动页面
            $activurl = C('WECHAT_PUBLIC')['Activurl'];
            header("Location: $activurl?headimgurl={$arr['headimgurl']}");
            //Util::jsonReturn(['status' => Code.SUCCESS,'userinfo' => $arr]);
        }
    }

}