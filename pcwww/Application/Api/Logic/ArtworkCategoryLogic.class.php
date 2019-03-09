<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Api\Model\ConfigModel;
use Api\Model\ArtworkModel;
use Api\Logic\ArtworkLogic;
use Api\Model\ArtworkCategoryModel;
use Custom\Define\Image;
use Custom\Define\Cache;

class ArtworkCategoryLogic extends BaseLogic
{
    public function getName($category){
      return $this->where(['id' => $category])->getField('cn_name');
    }
    public function getCategoryList($format = 'json')
    {
        $configLogic = new ConfigLogic();
        return $configLogic->getConfig(ConfigModel::ARTWORK_CATEGORY_LIST, $format);
    }
    public  function getList($forceUpdate = false)
    {
        if ($forceUpdate) {
            $ret = $this->model->getField('id,cn_name');
            S(Cache::ARTWORK_CATEGORY_CN_LIST, $ret);
        } else {
            $ret = S(Cache::ARTWORK_CATEGORY_CN_LIST);
            if (is_null($ret) ) {
                $result = $this->model->getField('id,cn_name');
                S(Cache::ARTWORK_CATEGORY_CN_LIST, $result);
                $ret = $result;
            }
        }
        if (!is_array($ret)) {
            $ret = [];
        }
        return $ret;
    }

    //获取艺术家分类
    public function getCategoryByUser($userid,$im = '|',$mode = '1'){
      $artModel = new ArtworkModel();
      $cateModel = new ArtworkCategoryModel();
      $category_content = $cateModel->getContent(implode(',',$artModel->getFields(['artist' => $userid],'category')));
      if($mode == '1'){
        return implode($im,array_values($category_content));
      }else{
        return $category_content;
      }
    }
    public function useTotal($id){
      $artLogic = new ArtworkLogic();
      return $artLogic->where(['is_deleted' => 'N' , 'category' => $id])->count();
    }
}