<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/6
 * Time: 15:46
 */

namespace Activity\Controller;
use Think\Controller;

class WeChatController extends Controller
{
    public function WechatLoginCallbackOnlyAuthorize(){
        $AppID = C('WECHAT')['AppID'];
        $AppSecret = C('WECHAT')['AppSecret'];


        if ($_GET['state'] != session('wx_state')) {
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
            session('WechatAuthorize',$wechat_userinfo);
            header("Location: " . session('Authorize_gourl'));
            exit;
        }
    }

}