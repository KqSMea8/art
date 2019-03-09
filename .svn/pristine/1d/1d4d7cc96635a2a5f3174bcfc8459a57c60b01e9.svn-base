<?php

namespace Custom\Helper;

use Custom\Define\Status;
use Custom\Define\Cache;
use Custom\Define\Code;
use Custom\Helper\Base as BaseHelper;
use Custom\Define\Util as DefineUtil;
use Custom\Helper\Http;
use Think\Crypt\Driver\Xxtea;

use Common\Logic\AssetsLogic;

class Util extends BaseHelper
{
    public static function generateUid()
    {
        mt_srand((double)microtime() * 10000);
        return strtoupper(md5($_SERVER['REMOTE_ADDR'] . uniqid(rand(), true)));
    }

    public static function jsonReturn($data = null, $code = 30000, $message = 'success', $debug = false)
    {
        if (is_null($data)) {
            $data = ['status' => Status::OK];
        }
        $returnBody = ['data' => $data, 'code' => $code, 'message' => $message];
        if (APP_DEBUG || $debug) {
            $returnBody['debug'] = $debug;
        }
        self::ajaxReturn($returnBody);
    }

    public static function jsonReturnSuccess($info = null)
    {
        self::jsonReturn(['status' => 1000, 'info' => $info]);
    }

    public static function jsonReturnError($msg, $status = 1001)
    {
        self::jsonReturn(['status' => $status], 30002, $msg);
    }

    public static function ajaxReturn($data, $type = '', $json_option = 0)
    {
        if (empty($type)) $type = C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)) {
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $data = json_encode($data, $json_option);
                break;
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler = isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                $data = $handler . '(' . json_encode($data, $json_option) . ');';
                break;
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                break;
        }
        exit($data);
    }

    public static function encryptPassword($password, $salt = null)
    {
        if (empty($salt)) {
            $ret['salt'] = self::generateRandomCode(12, null);
        } else {
            $ret['salt'] = $salt;
        }
        $ret['encryptedPassword'] = Xxtea::encrypt($password, $ret['salt'] . DefineUtil::ENCODE_KEY);
        $ret['encryptedPassword'] = base64_encode($ret['encryptedPassword']);
        return $ret;
    }

    public static function checkSignature($time, $nonce, $key, $signature)
    {
        $sign = Util::generateSignature($time, $nonce, $key);
        return ($sign === $signature);
    }

    public static function generateSignature($time, $nonce, $key)
    {
        if ($key === null) {
            $key = 'artzhe_' . date('Ymd');
        }
        return md5(md5($time) . md5($key) . md5($key . $time . $nonce . $key));
    }

    public static function genInviteCode($userId)
    {
        return 100000 + intval($userId);
    }

    public static function inviteCodeToUserId($inviteCode)
    {
        return intval($inviteCode) - 100000;
    }

    public static function checkVerifyCodeResult($mobile, $verifyCode)
    {
        $storeVerifyCode = S(Cache::VERIFY_CODE_PREFIX . $mobile);
        if (empty($storeVerifyCode)) {
            return ['code' => Code::VERIFY_CODE_EXPIRED, 'message' => 'Verify code is expired!'];
        }
        if ($verifyCode != $storeVerifyCode) {
            return ['code' => Code::VERIFY_CODE_NOT_MATCHED, 'message' => 'Verify code not matched!'];
        } else {

            return ['code' => Code::SYS_OK, 'message' => 'success'];
        }
    }

    public static function isPasswordMatch($password, $encPassword, $encSalt)
    {
        $encInfo = Util::encryptPassword($password, $encSalt);
        return ($encInfo['encryptedPassword'] === $encPassword);
    }

    public static function getImgUrlById($assetId)
    {
        return AssetsLogic::I()->getUrl($assetId);
    }

    public static function log($model, $action, $data)
    {
        return file_put_contents(ROOT_PATH . 'Log/' . $model . '-' . $action . '.log', var_export($data, true), FILE_APPEND);
    }

    public static function simpleTimeShow($timestmp)
    {
        $time = time();
        $h = $time - $timestmp;
        if ($h > 60) {
            if ($h > 3600) {
                if ($h > 3600 * 24) {
                    if ($h > 3600 * 24 * 3) {
                        return date('Y-m-d', $timestmp);
                    } else {
                        return intval($h / (3600 * 24)) . '天前';
                    }
                } else {
                    return intval($h / 3600) . '小时前';
                }
            } else {
                return intval($h / 60) . '分钟前';
            }
        } else {
            return '刚刚';
        }
    }

    public static function getFillImages($imgs, $width, $height)
    {
        foreach ($imgs as $key => $value) {
            $imgs[$key] = self::getFillImage($value, $width, $height);
        }
        return $imgs;
    }

    public static function getFillImage($img, $width, $height)
    {
        if (empty($img)) {
            return $img;
        }
        if ($width && $height) {
            $param = "h_{$height},w_{$width}";
        } elseif ($width) {
            $param = "w_{$width}";
        } elseif ($height) {
            $param = "h_{$height}";
        } else {
            $param = '';
        }
        if (strpos($img, '?') !== false) {
            return $img . ",image/resize,m_fixed,{$param}";
        } else {
            return $img . "?x-oss-process=image/resize,m_fixed,{$param},P_10";
        }
    }
    /**
     * 图片裁切
     * 2017-05-31
     */
    public static function getImageResize($img, $width, $height)
    {
        if (trim($img) == '') {
            return '';
        }
        return $img . "?x-oss-process=image/resize,m_fill,h_{$height},w_{$width},limit_0,image/format,jpg";
    }

    //图片批量裁剪,等比例，其中长宽其中一个设置设置大于0，另一个设置0或者以下即可
    public static function getImageResize_oldProportion($img, $width, $height)
    {
        if (trim($img) == '') {
            return '';
        }
        if ($width > 0 && $height > 0) {
            return $img . "?x-oss-process=image/resize,m_fill,h_{$height},w_{$width},limit_0,image/format,jpg";
        } elseif ($width > 0) {
            return $img . "?x-oss-process=image/resize,w_{$width},limit_0,image/format,jpg";
        } elseif ($height > 0) {
            return $img . "?x-oss-process=image/resize,h_{$height},limit_0,image/format,jpg";
        }
    }

    public static function getImageCropCenter($img, $width, $height)
    {
        return $img . "?x-oss-process=image/crop,w_{$width},h_{$height},g_center";
    }

    public static function getImageToSq($img, $width = '', $height = '')
    {
        $info = iconv("utf-8", "GBK//IGNORE", file_get_contents($img . '?x-oss-process=image/info'));
        $info = json_decode($info, 1);
        if (!empty($info)) {
            $short = '';
            if ($info['ImageHeight']['value'] > $info['ImageWidth']['value']) {
                $short = $info['ImageWidth']['value'];
            }
            if ($info['ImageHeight']['value'] < $info['ImageWidth']['value']) {
                $short = $info['ImageHeight']['value'];
            }
            if ($info['ImageHeight']['value'] == $info['ImageWidth']['value']) {
                $short = $info['ImageHeight']['value'];
            }
            if ($width > 0 && $height > 0) {
                return self::getFillImage(self::getImageCropCenter($img, $short, $short), $width, $height);
            } else {
                return self::getImageCropCenter($img, $short, $short);
            }
        } else {
            return htmlspecialchars_decode($img);
        }
    }

    public static function getHtmlImgSrc($content)
    {
        $match = [];
        preg_match_all('/&lt;img.*?src=&quot;(.*?)&quot;.*?&gt;/', $content, $match);
        return $match[1];
    }

    public static function replaceHtmlImgSrcContent($find,$content){
        foreach ($find as $key => $value) {
            $content = str_replace($value,$value.'?x-oss-process=image/resize,m_fixed,w_702,q=50,image/format,jpg',$content);
        }
        return $content;
    }

    public static function replaceHtmlImgSrc($find, $replace, $content)
    {
        foreach ($find as $key => $value) {
            $content = str_replace($value, $replace[$key], $content);
        }
        return $content;
    }

    //去除a标签
    public static function stripHtmlATag($content)
    {
        return preg_replace('/href=&quot;(.*?)&quot;/', '#', $content);
    }

    public static function getImageToSqs($imgs, $width = '', $height = '')
    {
        foreach ($imgs as $key => $value) {
            $imgs[$key] = self::getImageToSq($value, $width, $height);
        }
        return $imgs;
    }

    //图片批量裁剪
    public static function getImageResizes($imgs, $width = '', $height = '')
    {
        foreach ($imgs as $key => $value) {
            $imgs[$key] = self::getImageResize($value, $width, $height);
        }
        return $imgs;
    }

    //图片批量裁剪,等比例，其中长宽其中一个设置设置大于0，另一个设置0或者以下即可
    public static function getImageResizes_oldProportion($imgs, $width = '', $height = '')
    {
        foreach ($imgs as $key => $value) {
            $imgs[$key] = self::getImageResize_oldProportion($value, $width, $height);
        }
        return $imgs;
    }

    public static function getImageListCropCenter($wit, $w = 300, $h = 300)
    {
        $match = [];
        preg_match_all('/img.*?src=&quot;(.*?)&quot;/', $wit, $match);
        //return $match[1];
        $urls = $match[1];
        foreach ($urls as $key => $value) {
            $urls[$key] = $value . "?x-oss-process=image/crop,w_{$w},h_{$h},g_center";
        }
        return $urls;
    }

    public static function extractWitImgUrl($wit, $w = 300, $h = 300)
    {
        $match = [];
        preg_match_all('/img.*?src=&quot;(.*?)&quot;/', $wit, $match);
        //return $match[1];
        $urls = $match[1];
        foreach ($urls as $key => $value) {
            if (strpos($value, 'http') === false) {
                $value = 'http:' . $value;
            }
            if (strpos($value, '?x-oss-process=image/resize,m_fixed,w_702')) {
                $value = str_replace('?x-oss-process=image/resize,m_fixed,w_702', '', $value);
            }
            if ($w == 'org' && $h == 'org') {
                $urls[$key] = $value;
            } else {
                $urls[$key] = $value . "?x-oss-process=image/resize,m_fill,h_{$h},w_{$w}";
            }
        }
        return $urls;
    }

    public static function urlsafe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public static function urlsafe_b64decode($string)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public static function imageWater($image)
    {
        $obj = self::waterObject($image);
        if ($obj) {
            return $image . '?x-oss-process=image/auto-orient,1/watermark,image_' . $obj . ',t_50,g_se,x_10,y_10'; //水印透明调整为50%
        } else {
            return $image;
        }
    }

    public static function imageWaterSize($height, $width, $image)
    {
        $obj = self::waterObject2($image);
        if ($obj) {
            return $image . "?x-oss-process=image/auto-orient,1/resize,m_fill,h_{$height},w_{$width},limit_0,image/watermark,image_{$obj},t_50,g_se,x_10,y_10"; //水印透明调整为50%
        } else {
            return $image;
        }
    }

    public static function waterObject($img)
    {
        //$info = self::getImageInfo($img);
        if (strpos($img, 'gsywww') !== false) {
            $obj = 'uploads/2017/05/09/1494299645274913.png';
            $obj = self::urlsafe_b64encode($obj . '?x-oss-process=image/resize,P_15');
            return $obj;
        }
        if (strpos($img, 'gsy-other') !== false) {
            $obj = 'uploads/2017/05/09/1494299597801986.png';
            $obj = self::urlsafe_b64encode($obj . '?x-oss-process=image/resize,P_15');
            return $obj;
        }
        if (strpos($img, 'artzhe') !== false) {
            $obj = 'uploads/2017/06/14/1497411108629382.png';
            $obj = self::urlsafe_b64encode($obj . '?x-oss-process=image/resize,P_15');
            return $obj;
        }
        return '';
    }

    public static function waterObject_bak20170831($img)
    {
        $info = self::getImageInfo($img);
        if (strpos($img, 'gsywww') !== false) {
            $obj = 'uploads/2017/05/09/1494299645274913.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj, intval($info['width'] / 7), ''));
            return $obj;
        }
        if (strpos($img, 'gsy-other') !== false) {
            $obj = 'uploads/2017/05/09/1494299597801986.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj, intval($info['width'] / 7), ''));
            return $obj;
        }
        if (strpos($img, 'artzhe') !== false) {
            $obj = 'uploads/2017/06/14/1497411108629382.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj, intval($info['width'] / 7), ''));
            return $obj;
        }
        return '';
    }

    public static function waterObject2($img)
    {
        $info = self::getImageInfo($img);
        if (strpos($img, 'gsywww') !== false) {
            $obj = 'uploads/2017/05/09/1494299645274913.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj, 75, 30));
            return $obj;
        }
        if (strpos($img, 'gsy-other') !== false) {
            $obj = 'uploads/2017/05/09/1494299597801986.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj, 75, 30));
            return $obj;
        }
        if (strpos($img, 'artzhe') !== false) {
            $obj = 'uploads/2017/06/14/1497411108629382.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj, 75, 30));
            return $obj;
        }
        return '';
    }

    public static function imageWaters($images)
    {
        foreach ($images as $key => $value) {
            $images[$key] = self::imageWater($value);
        }
        return $images;
    }

    public static function getImageInfo($image)
    {
        $info = iconv("utf-8", "GBK//IGNORE", file_get_contents($image . '?x-oss-process=image/info'));
        $info = json_decode($info, 1);
        if (!empty($info)) {
            if ($info['ImageHeight']['value'] > $info['ImageWidth']['value']) {
                $short = $info['ImageWidth']['value'];
            }
            return [
                'width' => $info['ImageWidth']['value'],
                'height' => $info['ImageHeight']['value']
            ];
        } else {
            return [
                'width' => 470,
                'height' => 750
            ];
        }
    }

    public static function emojiStrReplace($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }

    public static function cleanSpecific($str)
    {
        $str = addslashes($str);
        $str = strip_tags($str);
        $str = str_replace('&amp;', '&', $str);
        $str = str_replace('&nbsp;', ' ', $str);
        $str = str_replace('?x-oss-process=image/resize,m_fixed,w_702', '', $str);
        //$str = self::emojiStrReplace($str);
        return $str;
    }

    //去除img标签
    public static function stripHtmlImageTag($content)
    {
        ///img.*?src=&quot;(.*?)&quot;/
        return preg_replace('/&lt;img.*?&gt;/', '', $content);
    }

    //3DES加密函数 用途::加密会员ID、产品ID，再将密文通过网络传输
    public static function des_encode($str)
    {
        $DES = new Crypt3Des();
        return $DES->encrypt($str);
    }

    //3DES解密函数
    public static function des_decode($str)
    {
        $DES = new Crypt3Des();
        return $DES->decrypt($str);
    }

}
