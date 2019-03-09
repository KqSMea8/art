<?php

namespace Api\Model;

use Api\Base\BaseModel;

class ConfigModel extends BaseModel
{
    protected $tableName = 'config';
    const ARTWORK_COLOR_LIST = 'ARTWORK_COLOR_LIST';
    const ARTWORK_TAG_LIST = 'ARTWORK_TAG_LIST';
    const ARTWORK_CATEGORY_LIST = 'ARTWORK_CATEGORY_LIST';
}