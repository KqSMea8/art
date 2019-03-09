<?php

namespace Api\Logic;


use Api\Base\BaseLogic;
use Api\Model\ConfigModel;
use Custom\Define\Image;

class ArtworkColorLogic extends BaseLogic
{
    public function getColorList($format = 'json')
    {
        $colorLogic = new ConfigLogic();
        $colorList = $colorLogic->getConfig(ConfigModel::ARTWORK_COLOR_LIST, $format);
        return $colorList;
    }
    public function getColorConfigByIdList($colorIdList)
    {
        $colorListWithKey = [];
        $colorList = $this->getColorList('array');
        foreach ($colorList as $color) {
            $colorListWithKey[$color['id']] = $color;
        }
        $ret = [];
        foreach ($colorIdList as $colorId)
        {
            //['id'=>'', 'color'=>'', 'sort'=>'']
            $ret[] = $colorListWithKey[$colorId];
        }
        return $ret;
    }
}
