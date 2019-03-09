<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Custom\Define\Image;
class AssetsLogic extends BaseLogic
{
    public static $I = null;
    public static function I(){
      if(empty($I)){
        self::$I = new AssetsLogic();
      }
      return self::$I;
    }
    public function getDetailById($id)
    {
        $data = $this->model->where(['id'=>$id])->find();
        if (empty($data)) {
            return [];
        } else {
            return $data;
        }
    }
    public  function getUrlList($idList, $process = null)
    {
        if (empty($idList)) {
            return [];
        }
        // $assetsList = $this->model
        //     ->where(['id'=>['in', $idList], 'is_deleted'=>'N'])
        //     ->getField('id,object,bucket');
        // if (empty($assetsList)) {
        //     return [];
        // }
        // $urlList = [];
        // foreach ($assetsList as $id => $assets) {
        //     $url = self::convert2Url($assets['object'], $process);
        //     $urlList[$id] =$url;
        // }
        return $idList;
    }
    public function getUrl($id, $process = null)
    {
        if (empty($id)) {
            return '';
        }
        return $id;
        // $data = $this->model->where(['id'=>$id])->find();
        // if (empty($data) || empty($data['object'])) {
        //     return '';
        // }
        // return self::convert2Url($data['object'], $process);
    }
    public static function convert2Url($ossKey, $process= null ,$cnName = null ,$httpProtocol = 'https://')
    {
        if (APP_DEBUG) {
            $oss = C('OSS_TEST');
        } else {
            $oss = C('OSS');
        }
        if (is_null($cnName)) {
            $url = $httpProtocol.$oss['bucket'].".".$oss['endPoint']."/".$ossKey;
        } else {
            $url =  $httpProtocol.$oss['bucket'].".".$cnName."/".$ossKey;
        }
        if (!is_null($process)) {
            $url = $url."?x-oss-process=".$process;
        }
        return $url;
    }
    public static function processImage($imageUrl, $process)
    {
        return $imageUrl."?x-oss-process=".$process;
    }
    /**
     * @param $data
     * @return mixed  return the insert id
     */
    public function addOne($data)
    {
        return $this->model->add($data);
    }
}
