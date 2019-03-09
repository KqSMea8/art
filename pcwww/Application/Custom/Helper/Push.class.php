<?php

namespace Custom\Helper;

use Custom\Helper\Base as BaseHelper;
use Custom\Helper\Http;
use Api\Model\PushLogModel;
/**
 * APP推送类（友盟）
 * @author xugx
 */
class Push extends BaseHelper{
    private static $ios_appkey = '58eb366e65b6d65bc4001b1d';
    private static $ios_app_master_sercret = 'hbixws96aifuydrn9lojup2obo6bwqoe';
    private static $android_appkey = '58eb548ef29d980b6300183f';
    private static $android_app_master_sercret = 'r5dj8nkjnuck0afm5iqlc9zelsnemu0z';
    private static $method = 'POST';
    private static $sendurl = 'https://msgapi.umeng.com/api/send';//'http://msg.umeng.com/api/send'
    private static $production_mode = 'false';
    /**
     * 基于Alias推送
     */
    public static function pushByAlias($alias,$title,$content,$description = '',$params = []){
      if(!empty($alias)){
        if(!empty($params)){
          if(VERSION < 1.1){
            $params = ['param' => $params];
          }else{
            $params = json_decode($params,1);
          }
        }
        self::iosSendMessage($alias,$title,$content,$description,$params);
        self::androidSendMessage($alias,$title,$content,$description,$params);
      }else{
        throw new \Exception('alias不能为空');
      }
    }
    //iphone别名推送消息
    public static function iosSendMessage($alias,$title,$content,$description,$params){
      $data = [];
      $data['appkey'] = self::$ios_appkey;
      $data['timestamp'] = self::getTimestamp();
      $data['type'] = 'customizedcast';
      $data['alias'] = $alias;
      $data['alias_type'] = 'kUMessageAliasTypeArtZhe';
      $payload = [];
      $payload['aps'] = ['alert' => $content];
      if(!empty($params) && is_array($params)){
        foreach ($params as $k => $v) {
          $payload[$k] = $v;
        }
      }
      $data['payload'] = $payload;
      $data['production_mode'] = self::$production_mode;
      self::push(self::$sendurl,$data,$alias,1);
    }
    //android别名推送消息
    public static function androidSendMessage($alias,$title,$content,$description,$params){
      $data = [];
      $data['appkey'] = self::$android_appkey;
      $data['timestamp'] = self::getTimestamp();
      $data['type'] = 'customizedcast';
      $data['alias'] = $alias;
      $data['alias_type'] = 'kUMessageAliasTypeArtZhe';
      $payload = [];
      $payload['display_type'] = 'notification';
      $payload['body'] = [];
      $payload['body']['ticker'] = '艺术者通知';
      $payload['body']['title'] = $title;
      $payload['body']['text'] = $content;
      if(!empty($params) && is_array($params)){
        $payload['body']['after_open'] = 'go_custom';
        $payload['body']['custom'] = json_encode($params);
      }else{
        $payload['body']['after_open'] = 'go_app';
      }
      $data['payload'] = $payload;
      $data['production_mode'] = self::$production_mode;
      self::push(self::$sendurl,$data,$alias,2);
    }
    /**
     * 签名
     */
    private static function sign($url,$data,$type){
      $app_master_sercret = $type == '1' ? self::$ios_app_master_sercret : self::$android_app_master_sercret;
      $json = json_encode($data);
      $sign = md5(sprintf('%s%s%s%s',self::$method,$url,$json,$app_master_sercret));
      return $sign;
    }
    /**
     * 时间戳
     */
    private static function getTimestamp(){
      return time();
    }
    /**
     * 推送
     */
    private static function push($url,$data,$alias,$type){
      $sign = self::sign($url,$data,$type);
      $url = $url.'?sign='.$sign;
      $json = json_encode($data);
      self::post($url,$json,$alias,$sign,$type);
    }
    /**
     * POST 提交推送
     */
    private static function post($url,$body,$alias = '',$sign = '',$type = ''){
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $body );
      $result = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $curlErrNo = curl_errno($ch);
      $curlErr = curl_error($ch);
      curl_close($ch);
      $pushLogModel = new PushLogModel();
      $pushLogModel->add([
        'alias' => $alias,
        'type' => $type,
        'body' => $body,
        'result' => $result,
        'httpcode' => $httpCode,
        'curlerrno' => $curlErrNo,
        'curlerrmsg' => $curlErr,
        'sign' => $sign,
        'time' => time()
      ]);
    }
}
