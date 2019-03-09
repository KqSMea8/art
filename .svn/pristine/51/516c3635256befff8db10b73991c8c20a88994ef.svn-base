<?php

namespace App10\Model;


use App10\Base\BaseModel;
use Custom\Manager\Token;

//登录信息统计
class LoginLogModel extends BaseModel
{
    protected $tableName = 'login_log';

    /**
     * @param $device 设备信息
     * @param $system 系统信息
     * @param $version APP版本
     * @param $token
     * @param $interface 接口信息
     * @return int|mixed
     */
    public function addData($device,$system,$version,$token,$interface){
        $data['device'] = $device;
        $data['system'] = $system;
        $data['app_version'] = $version;
        $data['interface'] = $interface;
        $data['login_time'] = time();
        $data['token'] = $token;

            $data['user_id'] = -1;

        $id = $this->add($data);
        return $id;
    }
}
