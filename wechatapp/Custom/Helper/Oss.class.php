<?php

namespace Custom\Helper;

use OSS\OssClient;

class Oss extends Base
{
    const OBJECT_KEY_PREFIX = 'other/artzhe/user/';
    public static function uploadFaceUrl($faceUrl)
    {
        if (APP_DEBUG){
            $ossConfig = C('OSS_TEST');
        } else {
            $ossConfig = C('OSS');
        }
        $options[OssClient::OSS_CALLBACK] = $ossConfig['callback'];
        $ossClient = new OssClient($ossConfig['appKeyId'], $ossConfig['appKeySecret'],$ossConfig['endPoint'], false);
        $mimeAndContent = self::getMimeTypeAndContent($faceUrl);

        $fileKey = self::genFaceUrlObjectKey($faceUrl, $mimeAndContent['mimeType']);
        return $ossClient->putObject($ossConfig['bucket'], $fileKey, $mimeAndContent['content'], $options);
    }

    public static function upload($content,$suxff){
      $ossConfig = C('OSS');
      $ossClient = new OssClient($ossConfig['appKeyId'], $ossConfig['appKeySecret'],$ossConfig['endPoint']);
      $filename = date('Y').'/'.date('m').'/'.date('d').'/'.date('H').'/'.md5(time().rand(100,999));
      return $ossClient->putObject($ossConfig['bucket'], $filename.'.'.$suxff, $content);
    }

    public static function uploadWithUrl($content,$url){
        $ossConfig = C('OSS');
        $ossClient = new OssClient($ossConfig['appKeyId'], $ossConfig['appKeySecret'],$ossConfig['endPoint']);
        return $ossClient->putObject($ossConfig['bucket'], $url, $content);
    }


    public static function getMimeTypeAndContent($faceUrl)
    {
        $ch = curl_init($faceUrl);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if($errorNo = curl_errno($ch)){
            throw new \Exception(curl_error($ch), $errorNo) ;
        } else {
            $ret['content'] = $result;
            $ret['mimeType'] = curl_getinfo($ch, CURLINFO_CONTENT_TYPE );
            curl_close($ch);
            return $ret;
        }
    }
    public static function genFaceUrlObjectKey($mimeType, $faceUrl)
    {
        switch (strtolower($mimeType)) {

            case 'image/png':
                $imageExt = '.png';
                break;
            case 'image/gif':
                $imageExt = '.gif';
                break;
            case 'image/bmp':
                $imageExt = '.bmp';
                break;
            default :
                $imageExt = '.jpeg';
        }
        return self::OBJECT_KEY_PREFIX.md5($faceUrl).$imageExt;
    }
}
