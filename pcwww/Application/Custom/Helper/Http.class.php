<?php
namespace Custom\Helper;

class Http extends Base
{
    public static function get($baseUrl, $params){
        $url = $baseUrl.'?'.http_build_query($params);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if($errorNo = curl_errno($ch)){
            throw new \Exception(curl_error($ch), $errorNo) ;
        } else {
            curl_close($ch);
            return $result;
        }
    }
    public static function post($url, $param = array(), $header = array()) {
        if (!$header) {
          $header = array('Accept-Charset: utf-8');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	//设置该选项，表示函数curl_exec执行成功时会返回执行的结果，失败时返回 FALSE
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, 1);	//POST请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_VERBOSE, 1 );	//启用时会汇报所有的信息
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
  }
}
