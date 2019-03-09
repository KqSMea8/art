<?php

namespace Api\Model;


use Api\Base\BaseModel;

class PlannerModel extends BaseModel{

    const VERIFY_STATE_CN_LIST = [
        -1=>'未通过',
        1=>"未审核",
        2=>"审核通过"
    ];

    protected $tableName = 'planner';
}
