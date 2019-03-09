<?php

namespace Api\Model;


use Api\Base\BaseModel;

class ThirdModel extends BaseModel
{
    protected $tableName = 'third';
    //枚举常量的加入和定义
    const TYPE_LIST = [
        1=>'WECHAT',
        2=>'QQ',
        3=>'WEIBO'
    ];
    const TYPE_LIST_REVERSE = [
        'WECHAT'=>1,
        'QQ'=>2,
        'WEIBO'=>3
    ];
}