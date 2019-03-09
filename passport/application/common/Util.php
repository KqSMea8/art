<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 16:11
 */

namespace app\common;
use app\common\Xxtea;

class Util
{
       const ENCODE_KEY = "artzhe_for_gsy2020";
    public static function jsonReturn($data = null, $errno = 0, $message = 'success')
    {

        $returnBody = [
            'errno' => $errno,
            'message' => $message,
            'data' => $data,
            'timestamp'=>time(),
        ];
        header('Content-Type:application/json; charset=utf-8');
        $data = json_encode($returnBody);
        echo $data;
        exit();
    }

    public static function encryptPassword($password, $salt = null)
    {
        if (empty($salt)) {
            $ret['salt'] = self::generateRandomCode(12, null);
        } else {
            $ret['salt'] = $salt;
        }
        $ret['encryptedPassword'] = Xxtea::encrypt($password, $ret['salt'].self::ENCODE_KEY);
        $ret['encryptedPassword'] = base64_encode($ret['encryptedPassword']);
        return $ret;
    }

    public static function generateRandomCode($length = 4, $type= 'number')
    {
        $code = '';
        if ($type === 'number') {
            $code = mt_rand(pow(10, $length - 1), pow(10, $length) - 1);
        } else {
            $list = [];
            for ($i = 0; $i <= 9; $i++) {
                $list[] = $i;
            }
            for ($j = ord('a'); $j <= ord('z'); $j++) {
                $list[] = chr($j);
            }
            for ($j = ord('A'); $j <= ord('Z'); $j++) {
                $list[] = chr($j);
            }
            $listLength = count($list);
            for ($i = 0; $i < $length; $i++) {
                $code .= $list[mt_rand(0, $listLength - 1)];
            }
        }
        return $code;
    }

}