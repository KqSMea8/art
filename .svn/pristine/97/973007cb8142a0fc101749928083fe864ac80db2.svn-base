<?php
namespace Custom\Helper;
use Common\Model\ThirdModel;
use Common\Model\UserModel;

use Custom\Helper\Base as BaseHelper;
use Custom\Define\Regular;

class Validate extends BaseHelper
{
    public static function isMobile($mobile)
    {
        return preg_match(Regular::REG_MOBILE, $mobile);
    }
    public static function isMd5In32($md5)
    {
        return preg_match(Regular::REG_MD5_32_BIT, $md5);
    }
    public static function isVerifyCode($code)
    {
        return preg_match(Regular::REG_VERIFY_CODE,$code);
    }
    public static function isGenderLegal($gender)
    {
        return in_array($gender, UserModel::GENDER_CN_LIST_REVERSE);
    }
    public static function isNickname($nickname)
    {
        return preg_match(Regular::REG_NICKNAME, $nickname);
    }
    public static function isPassword($password)
    {
        return preg_match(Regular::REG_PASSWORD, $password);
    }
    public static function isPartnerCode($partnerCode)
    {
        return in_array($partnerCode, ThirdModel::TYPE_LIST);
    }
    public static function isNumberId($id)
    {
        return preg_match(Regular::REG_NUMBER_ID, $id);
    }
}