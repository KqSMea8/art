<?php

namespace Custom\Helper;

use Custom\Helper\Base as BaseHelper;
use Custom\Helper\Http;

class Sms extends BaseHelper
{
    //template:
    //5000 亲爱的高搜易用户您好，您的短信验证码是{1}，30分钟内有效，请及时操作！
    //5001 亲爱的爱记账用户，您的短信验证码是{1}，30分钟内有效，请及时操作！
    //6001 亲爱的艺术者用户，您的短信验证码是{1}, 30分钟内有效，请及时操作！
    //new：不然会有短信的ip限制
    public static function sendByRpc111($to='',$template='',$param='',$ip='0'){
        // if( empty($to) || empty($template) || empty($param)){
        //     return array('state'=>9,'info'=>'参数错误');
        // }
        // if(empty($ip)){
        //     $ip = get_client_ip(1, true);
        // }
        $url = C('m_site').'/public/sendCode';
        $params = [
          'to' => $to,
          'code' => $param
        ];
        $Snoopy = new \Snoopy\Snoopy();
        $Snoopy->submit($url, $params);
        $result = json_decode($Snoopy->results, 1);
        // $result = Http::get($url,$params);
        return ['state'=>200,'data'=>$result,'url'=>$url,'params'=>$params];
    }

    public static function sendByRpc($to='',$param=''){
        // if( empty($to) || empty($template) || empty($param)){
        //     return array('state'=>9,'info'=>'参数错误');
        // }
        // if(empty($ip)){
        //     $ip = get_client_ip(1, true);
        // }
        $url = C('m_site').'/public/sendCode';
        $params = [
            'to' => $to,
            'code' => $param
        ];
        //var_dump($params);exit;
        //$Snoopy = new \Snoopy\Snoopy();
        //$Snoopy->submit($url, $params);
        //$result = json_decode($Snoopy->results, 1);
         $result = Http::get($url,$params);
         //var_dump($result);exit;
        return ['state'=>200,'data'=>$result,'url'=>$url,'params'=>$params];
    }

    //iphone推送消息
    public function iosSendMessage($uid,$content,$noReadMessage){
      $data = [];
      $data['appkey'] = 'xx';
      $data['timestamp'] = 'xx';
      $data['type'] = 'unicast';//单播
      $data['device_tokens'] = $uid;
      $data['payload'] = [
        'aps' => [
          'alert'  => $content,
          //'badge' => $noReadMessage,
          // 'sound' => 'default',
          // 'content-available' => '',
          // 'category' => ''
        ]
      ];
      $data['description'] = "测试单播消息-iOS";
    }
}