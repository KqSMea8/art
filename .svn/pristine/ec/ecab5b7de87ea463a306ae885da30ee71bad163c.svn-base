<?php
/**
 * Created by PhpStorm.
 * User: gsy
 * Date: 2018/7/25
 * Time: 16:01
 */

namespace App10\Controller;

use App10\Base\ApiBaseController;
use Custom\Define\Code;
use Custom\Define\Status;
use Custom\Define\Image;
use Custom\Helper\Checker;
use Custom\Helper\Sms;
use Custom\Helper\Util;
use Custom\Define\Cache;
use Custom\Define\Time;
use Custom\Helper\Oss;
use App10\Logic\WxAppGalleryLogic;
class WechatUploadController extends ApiBaseController
{
    private function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
    //用户上传目录
    private function user_file_dir($userid)
    {// 类似：用户id:122455返回 user/122/455/files
        $userid = intval($userid);
        $length_fix = 3;
        $return_str = 'wechatapp_gallery';
        $length = strlen($userid);
        for ($i = 0; $i < $length; $i++) {
            if ($i % 3 == 0)
                $return_str = $return_str . '/' . substr($userid, $i, $length_fix);
        }
        $return_str = $return_str . '/files';
        return $return_str;
    }


    //阿里oss js直传图片签名授权
    public function UploadPicAuthorization()
    {

        $this->checkLogin();

        $wxAppGalleryLogic = new WxAppGalleryLogic();
        $Gallery_info = $wxAppGalleryLogic->getOneGalleryByUnionId($this->loginUnionId);


        $user_dir = $this->user_file_dir($Gallery_info['id']);

        $id= C('OSS')['appKeyId'];
        $key= C('OSS')['appKeySecret'];
        $host = 'https://artzhe.oss-cn-shenzhen.aliyuncs.com';

        $now = time();
        $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);

        $dir = $user_dir.'/'.date('Y/m/d/H/', time());

        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1024*1024*20);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;


        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        echo json_encode($response);
    }

}