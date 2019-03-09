<?php

namespace Custom\Helper;

use Custom\Define\Util;

/**
 * Class WeChat
 * @see https://mp.weixin.qq.com/wiki?action=doc&id=mp1421140842&t=0.10663996034963885
 * @package Custom\Helper
 */
class WeChat extends Base
{
    protected  $config = null;
    protected static $urlList = [
        'authorize'=>'https://open.weixin.qq.com/connect/oauth2/authorize',
        'access_token' => 'https://api.weixin.qq.com/sns/oauth2/access_token',
        'refresh_token' => 'https://api.weixin.qq.com/sns/oauth2/refresh_token',
        'userinfo' => 'https://api.weixin.qq.com/sns/userinfo',
        'auth'=> 'https://api.weixin.qq.com/sns/auth',
    ];
    public static $scopeList = [
        'base'=>'snsapi_base',
        'userinfo'=>'snsapi_userinfo',
    ];
    protected static $_instance = null;
    protected function __construct($config)
    {
        $this->config[$config['appid']] = $config;
    }
    public static function getInstance($config)
    {
        if (isset(self::$_instance)) {
            $ins = self::$_instance;
        } else {
            $ins = new self($config);
        }
        return $ins;
    }
    public function getConfig($appId)
    {
        return self::$_instance->config[$appId];
    }

    public function redirectUri($appId, $redirectUri, $scope, $token)
    {
        $appConfig = $this->getConfig($appId);
        $params = [
            'appid'=> $appConfig['appid'],
            'redirect_uri'=> $redirectUri,
            'response_type'=>'code',
            'scope'=> $scope,
            'state'=> http_build_query(['from'=>Util::FROM_ARTZHE_H5_WECHAT, 'scope'=>$scope, 'token'=>$token]),
        ];
        redirect(self::$urlList['authorize']."?".http_build_query($params)."#wechat_redirect");
    }
    public function getAccessTokenInfo($appId, $code)
    {
        $appConfig = $this->getConfig($appId);
        $params = [
            'appid'=>$appConfig['appid'],
            'secret'=>$appConfig['appsecret'],
            'code'=>$code,
            'grant_type'=>'authorization_code',
        ];
        $accessTokenInfo = json_decode(Http::get(self::$urlList['access_token'], $params), true);
        return $accessTokenInfo;
    }
    public function getRefreshTokenInfo($appId, $refreshToken)
    {
        $appConfig = $this->getConfig($appId);
        $params = [
            'appid'=>$appConfig['appid'],
            'grant_type'=>'refresh_token',
            'refresh_token'=>$refreshToken
        ];
        $accessTokenInfo = json_decode(Http::get(self::$urlList['refresh_token'], $params), true);
        return $accessTokenInfo;
    }
    public function getUserInfo($accessToken, $openId)
    {
        $params = [
            'access_token'=>$accessToken,
            'openid'=>$openId,
            'lang'=>'zh_CN'
        ];
        $userInfo = json_decode(Http::get(self::$urlList['userinfo'],$params), true);
        return $userInfo;
    }
}