<?php

namespace Api\Model;

use Api\Base\BaseModel;

class ArtworkTagModel extends BaseModel
{
    protected $tableName = 'artwork_tag';

    public function getTagContent($ids){
      if(!empty($ids)){
        $data = $this->where("id in ({$ids})")->select();
        $map = [];
        foreach ($data as $key => $value) {
          $map[$value['id']] = $value['cn_value'];
        }
        return $map;
      }else{
        return [];
      }
    }
}
