<?php

namespace Custom\Helper;

use Common\Model\ThirdModel;
use Custom\Define\Code;
use Custom\Helper\Base as BaseHelper;
use Custom\Define\Cache;
use Custom\Define\Regular;

class Checker extends BaseHelper
{

    public static function mobile($mobile = null)
    {
        if (is_null($mobile) ) {
            $mobile = I('post.mobile', '');
        }
        if(!Validate::isMobile($mobile))
        {
            Util::jsonReturn(null, Code::MOBILE_ERR, 'Mobile format is error!', var_export($mobile, true));
        }
        return $mobile;
    }
    public static function token($token = null)
    {
        if (is_null($token)) {
            $token = I('get.token', '');
        }
        if(!Validate::isMd5In32($token)) {
            Util::jsonReturn(null, Code::TOKEN_ERR, "Token format is error!", $token);
        }

        $tokenInfo = S(Cache::TOKEN_PREFIX.$token);
        if (!is_array($tokenInfo) && empty($tokenInfo)) {
            Util::jsonReturn(null, Code::TOKEN_EXPIRED, "Token is expired!", Cache::TOKEN_PREFIX.$token);
        }
        return $token;
    }

    public static function verifyCode($verifyCode = null)
    {
        if (is_null($verifyCode)) {
            $verifyCode = I('post.verifyCode', '');
        }
        if (!preg_match(Regular::REG_VERIFY_CODE, $verifyCode)) {
            Util::jsonReturn(null, Code::VERIFY_CODE_ERR, 'Verify code format is error!', $verifyCode);
        }
        return $verifyCode;
    }
    public static function gender($gender = null, $extra = [])
    {
        if (is_null($gender)) {
            $gender = I('post.gender', '');
        }
        if (!Validate::isGenderLegal($gender)  ) {
            if (is_array($extra) && in_array($gender, $extra)) {
                return $gender;
            }
            Util::jsonReturn(null, Code::GENDER_ERR, 'Gender format is error!', $gender);
        }
        return $gender;
    }
    public static function nickname($nickname = null)
    {
        if (is_null($nickname)) {
            $nickname = I('post.nickname', '');
        }
        if (!Validate::isNickname($nickname)) {
            Util::jsonReturn(null, Code::NICKNAME_ERR, 'Nickname format is error!', $nickname);
        }
        return $nickname;
    }
    public static function password($password = null)
    {
        if (is_null($password)) {
            $password = I('post.password', '');
        }
        if (!Validate::isPassword($password)) {
            Util::jsonReturn(null, Code::PASSWORD_ERR, 'Password format is error!', $password);
        }
        return $password;
    }
    public static function partnerCode($partnerCode = null)
    {
        if (is_null($partnerCode)) {
            $partnerCode = I('post.partnerCode', ThirdModel::TYPE_LIST_REVERSE['WECHAT']);
        }
        if (!Validate::isPartnerCode($partnerCode)) {
            Util::jsonReturn(null, Code::PARTNER_CODE_ERR, 'PartnerCode format is error!', $partnerCode);
        }
        return $partnerCode;
    }
    public static function numberId($id = null)
    {
        if (is_null($id)) {
            $id = I("post.id", '');
        }
        if (!Validate::isNumberId($id)) {
            Util::jsonReturn(null, Code::ID_ERR, 'Id format is error!', $id);
        }
        return $id;
    }
}
