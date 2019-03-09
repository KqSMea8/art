<?php

namespace App10\Base;

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
        return 'App10\\Logic\\'.substr(end($exp), 0, -1*strlen('Service')).'Logic';
    }
}