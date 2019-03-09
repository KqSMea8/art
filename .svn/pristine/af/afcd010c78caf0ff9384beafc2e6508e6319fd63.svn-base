<?php

namespace Custom\Helper;

use Custom\Define\Status;
use Custom\Define\Cache;
use Custom\Define\Code;
use Custom\Helper\Base as BaseHelper;
use Custom\Define\Util as DefineUtil;
use Custom\Helper\Http;
use Think\Crypt\Driver\Xxtea;

use Api\Logic\AssetsLogic;

class Util extends BaseHelper
{
    public static function generateUid()
    {
        mt_srand((double)microtime()*10000);
        return  strtoupper(md5($_SERVER['REMOTE_ADDR'].uniqid(rand(), true)));
    }

    public static function jsonReturn($data = null,  $code = 30000, $message = 'success', $debug = false)
    {
        if (is_null($data)) {
            $data = ['status'=>Status::OK];
        }
        $returnBody = ['data'=>$data, 'code'=>$code, 'message'=> $message];
        if (APP_DEBUG || $debug) {
            $returnBody['debug'] = $debug;
        }
        self::ajaxReturn($returnBody);
    }
    public static function jsonReturnSuccess($info = null){
      self::jsonReturn(['status'=>1000,'info'=>$info]);
    }
    public static function jsonReturnError($msg,$status = 1001){
      self::jsonReturn(['status' => $status],30002,$msg);
    }
    public static function ajaxReturn($data,$type='',$json_option=0)
    {
        if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)){
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $data       =   json_encode($data,$json_option);
                break;
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler    =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                $data       =   $handler.'('.json_encode($data,$json_option).');';
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
        $ret['encryptedPassword'] = Xxtea::encrypt($password, $ret['salt'].DefineUtil::ENCODE_KEY);
        $ret['encryptedPassword'] = base64_encode($ret['encryptedPassword']);
        return $ret;
    }
    public static function checkSignature($time, $nonce, $key, $signature)
    {
        $sign =  Util::generateSignature($time, $nonce, $key);
        return ($sign === $signature);
    }
    public static function generateSignature($time, $nonce, $key)
    {
        if ($key === null) {
            $key = 'artzhe_'.date('Ymd');
        }
        return md5(md5($time).md5($key).md5($key.$time.$nonce.$key));
    }
    public static function genInviteCode($userId)
    {
        return 100000+intval($userId);
    }
    public static function inviteCodeToUserId($inviteCode)
    {
        return intval($inviteCode) - 100000;
    }
    public static function checkVerifyCodeResult($mobile, $verifyCode)
    {
        $storeVerifyCode = S(Cache::VERIFY_CODE_PREFIX.$mobile);
        if(empty($storeVerifyCode))
        {
            return ['code'=>Code::VERIFY_CODE_EXPIRED, 'message'=>'Verify code is expired!'];
        }
        if ($verifyCode != $storeVerifyCode)
        {
            return  ['code'=>Code::VERIFY_CODE_NOT_MATCHED, 'message'=>'Verify code not matched!'];
        } else {

            return ['code'=>Code::SYS_OK, 'message'=>'success'];
        }
    }
    public static function isPasswordMatch($password, $encPassword, $encSalt)
    {
        $encInfo = Util::encryptPassword($password, $encSalt);
        return ($encInfo['encryptedPassword'] === $encPassword);
    }
    public static function getImgUrlById($assetId){
      return AssetsLogic::I()->getUrl($assetId);
    }
    public static function log($model,$action,$data){
      return file_put_contents(ROOT_PATH.'Log/'.$model.'-'.$action.'.log',var_export($data,true),FILE_APPEND);
    }
    public static function simpleTimeShow($timestmp){
        $time = time();
        $h = $time - $timestmp;
        if($h > 60){
          if($h > 3600){
            if($h > 3600 * 24){
              if($h > 3600 * 24 * 3){
                return date('Y-m-d',$timestmp);
              }else{
                return  intval($h/(3600*24)).'天前';
              }
            }else{
                return  intval($h/3600).'小时前';
            }
          }else{
            return intval($h/60).'分钟前';
          }
        }else{
          return '刚刚';
        }
    }
    public static function getFillImages($imgs,$width,$height){
      foreach ($imgs as $key => $value) {
        $imgs[$key] = self::getFillImage($value,$width,$height);
      }
      return $imgs;
    }
    public static function getFillImage($img,$width,$height){
      if(empty($img)){
        return $img;
      }
      if($width&&$height){
        $param = "h_{$height},w_{$width}";
      }elseif($width){
        $param = "w_{$width}";
      }elseif($height){
        $param = "h_{$height}";
      }else{
        $param = '';
      }
      if(strpos($img,'?') !== false){
        return $img.",image/resize,m_fixed,{$param}";
      }else{
        return $img."?x-oss-process=image/resize,m_fixed,{$param},P_10";
      }
    }

    /**
     * 图片裁切
     * 2017-05-31
     */
    public static function getImageResize($img,$width,$height){
        return $img."?x-oss-process=image/resize,m_fill,h_{$height},w_{$width},limit_0,image/format,jpg";
    }
    public static function getImageCropCenter($img,$width,$height){
      return $img."?x-oss-process=image/crop,w_{$width},h_{$height},g_center";
    }
    public static function getImageToSq($img,$width = '',$height = ''){
      $info = iconv("utf-8", "GBK//IGNORE",file_get_contents($img.'?x-oss-process=image/info'));
      $info = json_decode($info,1);
      if(!empty($info)){
        $short = '';
        if($info['ImageHeight']['value'] > $info['ImageWidth']['value']){
          $short = $info['ImageWidth']['value'];
        }
        if($info['ImageHeight']['value'] < $info['ImageWidth']['value']){
          $short = $info['ImageHeight']['value'];
        }
        if($info['ImageHeight']['value'] == $info['ImageWidth']['value']){
          $short = $info['ImageHeight']['value'];
        }
        if($width > 0 && $height > 0){
          return self::getFillImage(self::getImageCropCenter($img,$short,$short),$width,$height);
        }else{
          return self::getImageCropCenter($img,$short,$short);
        }
      }else{
        return htmlspecialchars_decode($img);
      }
    }
    public static function getHtmlImgSrc($content){
        $match = [];
        preg_match_all('/&lt;img.*?src=&quot;(.*?)&quot;.*?&gt;/', $content, $match);
        return $match[1];
    }

    public static function replaceHtmlImgSrc($find,$replace,$content){
      foreach ($find as $key => $value) {
        $content = str_replace($value,$replace[$key],$content);
      }
      return $content;
    }
    public static function stripHtmlATag($content){
      return preg_replace('/href=&quot;(.*?)&quot;/','#',$content);
    }
    public static function getImageToSqs($imgs,$width='',$height=''){
      foreach ($imgs as $key => $value) {
        $imgs[$key] = self::getImageToSq($value,$width,$height);
      }
      return $imgs;
    }

    //图片批量裁剪
    public static function getImageResizes($imgs,$width='',$height=''){
        foreach ($imgs as $key => $value) {
            $imgs[$key] = self::getImageResize($value,$width,$height);
        }
        return $imgs;
    }
    public static function getImageListCropCenter($wit,$w = 300,$h = 300){
      $match = [];
      preg_match_all('/img.*?src=&quot;(.*?)&quot;/',$wit,$match);
      //return $match[1];
      $urls = $match[1];
      foreach ($urls as $key => $value) {
        $urls[$key] = $value."?x-oss-process=image/crop,w_{$w},h_{$h},g_center";
      }
      return $urls;
    }
    public static function extractWitImgUrl($wit,$w = 300,$h = 300){
      $match = [];
      preg_match_all('/img.*?src=&quot;(.*?)&quot;/',$wit,$match);
      //return $match[0];
      $urls = $match[1];
      foreach ($urls as $key => $value) {
        if(strpos($value,'https') === false){
          $value = 'https:'.$value;
        }
        if(strpos($value, '?x-oss-process=image/resize,m_fixed,w_702')){
            $value = str_replace('?x-oss-process=image/resize,m_fixed,w_702', '', $value);
        }
        if($w == 'org' && $h == 'org'){
          $urls[$key] = $value;
        }else{
          $urls[$key] = $value."?x-oss-process=image/resize,m_fill,h_{$h},w_{$w}";
        }
      }
      return $urls;
    }

    public static function urlsafe_b64encode($string) {
       $data = base64_encode($string);
       $data = str_replace(array('+','/','='),array('-','_',''),$data);
       return $data;
    }

    public static function urlsafe_b64decode($string) {
     $data = str_replace(array('-','_'),array('+','/'),$string);
     $mod4 = strlen($data) % 4;
     if ($mod4) {
         $data .= substr('====', $mod4);
     }
     return base64_decode($data);
   }

    public static function imageWater($image){
      $obj = self::waterObject($image);
      if($obj){
        return $image.'?x-oss-process=image/watermark,image_'.$obj.',t_50,g_se,x_10,y_10'; //水印透明调整为50%
      }else{
        return $image;
      }
    }

    public static function imageWaterSize($height,$width,$image){
        $obj = self::waterObject2($image);
        if($obj){
            return $image."?x-oss-process=image/resize,m_fill,h_{$height},w_{$width},limit_0,image/watermark,image_{$obj},t_50,g_se,x_10,y_10"; //水印透明调整为50%
        }else{
            return $image;
        }
    }

    public static function waterObject($img){
        //$info = self::getImageInfo($img);
        if(strpos($img,'gsywww') !== false){
            $obj = 'uploads/2017/05/09/1494299645274913.png';
            $obj = self::urlsafe_b64encode($obj.'?x-oss-process=image/resize,P_15');
            return $obj;
        }
        if(strpos($img,'gsy-other') !== false){
            $obj = 'uploads/2017/05/09/1494299597801986.png';
            $obj = self::urlsafe_b64encode($obj.'?x-oss-process=image/resize,P_15');
            return $obj;
        }
        if(strpos($img,'artzhe') !== false){
            $obj = 'uploads/2017/06/14/1497411108629382.png';
            $obj = self::urlsafe_b64encode($obj.'?x-oss-process=image/resize,P_15');
            return $obj;
        }
        return '';
    }
    public static function waterObject_bak20170831($img){
        $info = self::getImageInfo($img);
        if(strpos($img,'gsywww') !== false){
            $obj = 'uploads/2017/05/09/1494299645274913.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj,intval($info['width']/7),''));
            return $obj;
        }
        if(strpos($img,'gsy-other') !== false){
            $obj = 'uploads/2017/05/09/1494299597801986.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj,intval($info['width']/7),''));
            return $obj;
        }
        if(strpos($img,'artzhe') !== false){
            $obj = 'uploads/2017/06/14/1497411108629382.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj,intval($info['width']/7),''));
            return $obj;
        }
        return '';
    }

    public static function waterObject2($img){
      $info = self::getImageInfo($img);
      if(strpos($img,'gsywww') !== false){
        $obj = 'uploads/2017/05/09/1494299645274913.png';
        $obj = self::urlsafe_b64encode(self::getFillImage($obj,75,30));
        return $obj;
      }
      if(strpos($img,'gsy-other') !== false){
        $obj = 'uploads/2017/05/09/1494299597801986.png';
        $obj = self::urlsafe_b64encode(self::getFillImage($obj,75,30));
        return $obj;
      }
        if(strpos($img,'artzhe') !== false){
            $obj = 'uploads/2017/06/14/1497411108629382.png';
            $obj = self::urlsafe_b64encode(self::getFillImage($obj,75,30));
            return $obj;
        }
      return '';
    }

    public static function imageWaters($images){
      foreach ($images as $key => $value) {
          $images[$key] = self::imageWater($value);
      }
      return $images;
    }

    public static function getImageInfo($image){
      $info = iconv("utf-8", "GBK//IGNORE",file_get_contents($image.'?x-oss-process=image/info'));
      $info = json_decode($info,1);
      if(!empty($info)){
        if($info['ImageHeight']['value'] > $info['ImageWidth']['value']){
          $short = $info['ImageWidth']['value'];
        }
        return [
          'width' => $info['ImageWidth']['value'],
          'height' => $info['ImageHeight']['value']
        ];
      }else{
        return [
          'width' => 470,
          'height' => 750
        ];
      }
    }

    public static function emojiStrReplace($str){
      $str = preg_replace_callback(
              '/./u',
              function (array $match) {
                  return strlen($match[0]) >= 4 ? '' : $match[0];
              },
              $str);

       return $str;
    }
    public static function cleanSpecific($str){
      $str = addslashes($str);
      $str = strip_tags($str);
      $str = str_replace('&amp;','&',$str);
      $str = str_replace('&nbsp;',' ',$str);
      $str = str_replace('?x-oss-process=image/resize,m_fixed,w_702','',$str);
      //$str = self::emojiStrReplace($str);
      return $str;
    }



    /*
    * 截取含有 html标签的字符串 ,补全html标签
    * @param (string) $str   待截取字符串
    * @param (int)  $lenth  截取长度
    * @param (string) $repalce 超出的内容用$repalce替换之（该参数可以为带有html标签的字符串）
    * @param (string) $anchor 截取锚点，如果截取过程中遇到这个标记锚点就截至该锚点处
    * @return (string) $result 返回值
    */
    function cut_html_str($str, $lenth, $replace='', $anchor='<!-- break -->'){
        $_lenth = mb_strlen($str, "utf-8"); // 统计字符串长度（中、英文都算一个字符）

        if($_lenth <= $lenth){
            return $str;    // 传入的字符串长度小于截取长度，原样返回
        }
        $strlen_var = strlen($str);     // 统计字符串长度（UTF8编码下-中文算3个字符，英文算一个字符）

        if(strpos($str, '<') === false){
            return mb_substr($str, 0, $lenth);  // 不包含 html 标签 ，直接截取
        }
        if($e = strpos($str, $anchor)){
            return mb_substr($str, 0, $e);  // 包含截断标志，优先
        }
        $html_tag = 0;  // html 代码标记
        $result = '';   // 摘要字符串
        $html_array = array('left' => array(), 'right' => array()); //记录截取后字符串内出现的 html 标签，开始=>left,结束=>right
        $html_array_str = '';
        /*
        * 如字符串为：<h3><p><b>a</b></h3>，假设p未闭合，数组则为：array('left'=>array('h3','p','b'), 'right'=>'b','h3');
        * 仅补全 html 标签，<? <% 等其它语言标记，会产生不可预知结果
        */
        for($i = 0; $i < $strlen_var; ++$i) {
           // if(!$lenth) break;  // 遍历完之后跳出
            if($lenth <=0){
                if($html_tag != 1){
                    break;
                }
            }
            $current_var = substr($str, $i, 1); // 当前字符
            if($current_var == '<'){ // html 代码开始
                $html_tag = 1;
                $html_array_str = '';
            }else if($html_tag == 1){ // 一段 html 代码结束
                if($current_var == '>'){
                    $html_array_str = trim($html_array_str); //去除首尾空格，如 <br / > < img src="" / > 等可能出现首尾空格
                    if(substr($html_array_str, -1) != '/'){ //判断最后一个字符是否为 /，若是，则标签已闭合，不记录
                        // 判断第一个字符是否 /，若是，则放在 right 单元
                        $f = substr($html_array_str, 0, 1);
                        if($f == '/'){
                            $html_array['right'][] = str_replace('/', '', $html_array_str); // 去掉 '/'
                        }else if($f != '?'){ // 若是?，则为 PHP 代码，跳过
                            // 若有半角空格，以空格分割，第一个单元为 html 标签。如：<h2 class="a"> <p class="a">
                            if(strpos($html_array_str, ' ') !== false){
                                // 分割成2个单元，可能有多个空格，如：<h2 class="" id="">
                                $html_array['left'][] = strtolower(current(explode(' ', $html_array_str, 2)));
                            }else{
                                //若没有空格，整个字符串为 html 标签，如：<b> <p> 等，统一转换为小写
                                $html_array['left'][] = strtolower($html_array_str);
                            }
                        }
                    }
                    $html_array_str = ''; // 字符串重置
                    $html_tag = 0;
                }else{
                    $html_array_str .= $current_var; //将< >之间的字符组成一个字符串,用于提取 html 标签
                }
                --$lenth;
            }else{
                --$lenth; // 非 html 代码才记数
            }
            $ord_var_c = ord($str{$i});
            switch (true) {
                case (($ord_var_c & 0xE0) == 0xC0): // 2 字节
                    $result .= substr($str, $i, 2);
                    $i += 1;
                    $lenth -= 1;
                    break;
                case (($ord_var_c & 0xF0) == 0xE0): // 3 字节
                    $result .= substr($str, $i, 3);
                    $i += 2;
                    $lenth -= 2;
                    break;
                case (($ord_var_c & 0xF8) == 0xF0): // 4 字节
                    $result .= substr($str, $i, 4);
                    $i += 3;
                    $lenth -= 3;
                    break;
                case (($ord_var_c & 0xFC) == 0xF8): // 5 字节
                    $result .= substr($str, $i, 5);
                    $i += 4;
                    $lenth -= 4;
                    break;
                case (($ord_var_c & 0xFE) == 0xFC): // 6 字节
                    $result .= substr($str, $i, 6);
                    $i += 5;
                    $lenth -= 5;
                    break;
                default: // 1 字节
                    $result .= $current_var;
            }
        }

        if($html_array['left']){ //比对左右 html 标签，不足则补全
            $html_array['left'] = array_reverse($html_array['left']); //翻转left数组，补充的顺序应与 html 出现的顺序相反
            foreach($html_array['left'] as $index => $tag){
                $key = array_search($tag, $html_array['right']); // 判断该标签是否出现在 right 中
                if($key !== false){ // 出现，从 right 中删除该单元
                    unset($html_array['right'][$key]);
                }else if(!in_array($tag, array('img', 'br'))){ // 没有出现，需要补全
                    $result .= '</'.$tag.'>';
                }
            }
        }
        return $result.$replace;
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
