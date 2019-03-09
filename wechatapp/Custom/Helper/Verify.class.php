<?php
namespace Custom\Helper;
use Apps\Common\Logic\ArtworkCategoryLogic;
use Common\Model\ThirdModel;
use Common\Model\UserModel;
use \Exception;

use Custom\Helper\Base as BaseHelper;
use Custom\Helper\Util;
use Custom\Define\Regular;

/**
 * 验证类
 * @author xugx
 */
class Verify extends BaseHelper{
   /**
  * 验证数据函数
  * @param array $data
  * @param array $rule
  * ! (非空) # (浮点型) @(整形) ~(身份证) %(电话) *(银行卡)
  */
    public static function all($data,$rule){
      try {
        foreach ($rule as $k=>$v){
        $c = $data[$k];
        if(strpos($v, '!') !== false){
            if(empty($c)){
                if(strpos($v, '|') !== false){
                    list($r,$d) = explode('|', $v);
                    throw new Exception($d, 1);
                }else{
                    throw new Exception('非法的参数：'.$k, 1);
                }
            }
        }
        if(strpos($v, '#') !== false){
            if(!self::check_float($c)){
                if(strpos($v, '|') !== false){
                    list($r,$d) = explode('|', $v);
                    throw new Exception($d, 1);
                }else{
                    throw new Exception('非法的参数：'.$k, 1);
                }
            }
        }
        if(strpos($v, '@') !== false){
            if(!self::check_int($c)){
                if(strpos($v, '|') !== false){
                    list($r,$d) = explode('|', $v);
                    throw new Exception($d, 1);
                }else{
                    throw new Exception('非法的参数：'.$k, 1);
                }
            }
        }
        if(strpos($v, '~') !== false){
            if(!self::check_identity($c)){
                if(strpos($v, '|') !== false){
                    list($r,$d) = explode('|', $v);
                    throw new Exception($d, 1);
                }else{
                    throw new Exception('非法的参数：'.$k, 1);
                }
            }
        }
        if(strpos($v, '%') !== false){
            if(!self::check_phone($c)){
                if(strpos($v, '|') !== false){
                    list($r,$d) = explode('|', $v);
                    throw new Exception($d, 1);
                }else{
                    throw new Exception('非法的参数：'.$k, 1);
                }
            }
        }
        if(strpos($v, '*') !== false){
            if(!self::check_card($c)){
                if(strpos($v, '|') !== false){
                    list($r,$d) = explode('|', $v);
                    error($d);
                }else{
                    throw new Exception('非法的参数：'.$k, 1);
                }
            }
        }
      }
    } catch (\Exception $e) {
        Util::jsonReturnError($e->getMessage());
      }
    }
    public static function check_identity($id=''){
      $set = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
      $ver = array('1','0','x','9','8','7','6','5','4','3','2');
      $arr = str_split($id);
      $sum = 0;
      for ($i = 0; $i < 17; $i++)
      {
          if (!is_numeric($arr[$i]))
          {
              return false;
          }
          $sum += $arr[$i] * $set[$i];
      }
      $mod = $sum % 11;
      if (strcasecmp($ver[$mod],$arr[17]) != 0)
      {
          return false;
      }
      return true;
  }
  public static function check_phone($phone){
      if(preg_match("/^1[34578]{1}\d{9}$/",$phone)){
          return true;
      }else{
          return false;
      }
  }
  public static function check_int($int){
      if(preg_match("/^[0-9]*$/", $int)){
          return true;
      }else{
          return false;
      }
  }
  public static function check_float($float){
      if(preg_match("/^[0-9]+(.[0-9]{2})?$/", $float)){
          return true;
      }else{
          return false;
      }
  }
  public static function check_card($s){
      $n = 0;
      for($i=strlen($s)-1; $i>=0; $i--) {
          if($i % 2) $n += $s{$i};
          else {
              $t = $s{$i} * 2;
              if($t > 9) $t = $t{0} + $t{1};
              $n += $t;
          }
      }
      return ($n % 10) == 0;
  }
}
