<?php

namespace Custom\Helper;

use OSS\OssClient;
use OSS\Core\OssException;
use Custom\Define\Code;

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
        try {
            $options[OssClient::OSS_CALLBACK] = $ossConfig['callback'];
            $ossClient = new OssClient($ossConfig['appKeyId'], $ossConfig['appKeySecret'],$ossConfig['endPoint'], false);
            $mimeAndContent = self::getMimeTypeAndContent($faceUrl);

            $fileKey = self::genFaceUrlObjectKey($faceUrl, $mimeAndContent['mimeType']);
            $result = $ossClient->putObject($ossConfig['bucket'], $fileKey, $mimeAndContent['content'], $options);
            return ['status' => Code::SUCCESS, 'result' => $result];
        } catch (OssException $e) {
            return ['status' => Code::SYS_ERR, 'result' => $e->getMessage()];
        }
    }

    public static function upload($content,$suxff){
        try{
            $ossConfig = C('OSS');
            $ossClient = new OssClient($ossConfig['appKeyId'], $ossConfig['appKeySecret'],$ossConfig['endPoint']);
            $filename = date('Y').'/'.date('m').'/'.date('d').'/'.date('H').'/'.md5(time().rand(100,999));
            $result = $ossClient->putObject($ossConfig['bucket'], $filename.'.'.$suxff, $content);
            return ['status' => Code::SUCCESS, 'result' => $result];
        } catch(OssException $e) {
            return ['status' => Code::SYS_ERR, 'result' => $e->getMessage()];
        }
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
