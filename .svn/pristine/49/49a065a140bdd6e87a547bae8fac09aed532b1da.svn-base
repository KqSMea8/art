<?php

namespace Api\Model;

use Api\Base\BaseModel;

class ArtworkCategoryModel extends BaseModel
{
    protected $tableName = 'artwork_category';

    public function getContent($ids){
      if(!empty($ids)){
        $data = $this->where("id in ({$ids})")->select();
        $map = [];
        foreach ($data as $key => $value) {
          $map[$value['id']] = $value['cn_name'];
        }
        return $map;
      }else{
        return [];
      }
    }
}
