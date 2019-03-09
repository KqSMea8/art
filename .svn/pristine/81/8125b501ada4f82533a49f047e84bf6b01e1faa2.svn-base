<?php

namespace Api\Base;

//todo useless
class BaseService
{
    protected $logic = null;
    public function __construct()
    {
        $logicFullName = $this->getLogicFullName();
        $this->logic = new $logicFullName();
    }
    protected function getLogicFullName()
    {
        $exp = explode('\\',__CLASS__);
        return 'Common\\Logic\\'.substr(end($exp), 0, -1*strlen('Service')).'Logic';
    }
}