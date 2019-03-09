<?php

namespace Custom\Manager;

use Custom\Define\Cache;
use Custom\Define\Time;
use Custom\Helper\Util;
use Custom\Define\Code;

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


        //黑名单用户验证 start
        $user_id=intval($tokenInfo['userInfo']['id']);
        if($user_id>0){
            $UserBlacklist_for_check=S('UserBlacklist_for_check');
            if(!$UserBlacklist_for_check){
                $user_blacklist_M=M('user_blacklist');
                $where['status']=1;
                $list=$user_blacklist_M->where($where)->select();
                $UserBlacklist_for_check=array_column($list,'user_id');
                S('UserBlacklist_for_check',$UserBlacklist_for_check,600);
            }
            if(in_array($user_id,$UserBlacklist_for_check)){
                S(Cache::TOKEN_PREFIX . $token, null, 3600);
                Util::jsonReturn(null,Code::HAVE_NO_RIGHT,'User in the blacklist!');exit;
            }
        }
        //黑名单用户验证 end


        if (is_null($tokenInfo) || empty($tokenInfo['userInfo']['id']))
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
