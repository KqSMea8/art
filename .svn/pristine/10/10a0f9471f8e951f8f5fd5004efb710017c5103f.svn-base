<?php

namespace Custom\Manager;

use Custom\Define\Cache;
use Custom\Define\Time;

class Token extends Base
{
    protected static $tokenInfo = null;
    //['userInfo'=>['az_user表数据'], 'thirdInfo'=>['az_third表数据'], 'weChatUserInfo'=>['weChat返回的snsapi_userinfo级别用户信息']]
    public static function getTokenInfo($token)
    {
        return  S(Cache::TOKEN_PREFIX.$token);
    }
    //判断用户是否登录，如果登录则返回az_user.id
    public static function isLogin($token)
    {
        $tokenInfo = self::getTokenInfo($token);

        if (is_null($tokenInfo) || empty($tokenInfo['userInfo']['unionId']))
        {
            return false;
        } else {
            return $tokenInfo['userInfo'];
        }
    }
    //刷新指定token的过期时间
    public static function refreshTokenExpire($token)
    {
        $key = Cache::TOKEN_PREFIX.$token;
        return S($key, S($key), ['expire'=>Time::TOKEN_EXPIRE_30_DAY]);
    }
    public static function mergeTokenInfo($token, $newData)
    {
        $key = Cache::TOKEN_PREFIX.$token;
        $newTokenInfo = array_merge(S($key), $newData);
        return S($key, $newTokenInfo, Time::TOKEN_EXPIRE_30_DAY);
    }
    public static function isArtist($token)
    {
        $tokenInfo = Token::getTokenInfo($token);
        if (!empty($tokenInfo) &&
            $tokenInfo['isLogin']&&
            $tokenInfo['isArtist'] )
        {
            return true;
        } else {
            return false;
        }
    }
}
