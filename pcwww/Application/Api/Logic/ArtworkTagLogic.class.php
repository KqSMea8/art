<?php

namespace Api\Logic;

use Api\Logic\ArtworkLogic;
use Custom\Define\Image;
use Api\Base\BaseLogic;
use Api\Model\ConfigModel;

class ArtworkTagLogic extends BaseLogic
{
    public function getTagList($format = 'json')
    {
        $colorLogic = new ConfigLogic();
        $colorList = $colorLogic->getConfig(ConfigModel::ARTWORK_TAG_LIST, $format);
        return $colorList;
    }
    public function getTagConfigList($tagIdList)
    {
        $tagList = $this->getTagList('array');
        $tagListWithKey = [];
        foreach ($tagList as $tag) {
            $tagListWithKey[$tag['id']] = $tag;
        }
        $tmpList = [];
        foreach ($tagIdList as $tagId) {
            $tmpList[] = $tagListWithKey[$tagId];
        }
        return $tmpList;
    }
    public function useTotal($id){
      $artLogic = new ArtworkLogic();
      return $artLogic->where("is_deleted = 'N' AND find_in_set({$id},tag_ids)")->count();
    }
}
