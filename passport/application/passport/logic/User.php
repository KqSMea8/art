<?php
namespace app\passport\logic;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:04
 */
use think\Model;
use app\common\Util;
class User extends Model
{

    public function getUserInfoById($userId)
    {
        $data = $this
            ->where(['id'=>$userId])
            ->find();
        return empty($data) ? []: $data;
    }

    public function getUserInfoByMobile($mobile)
    {
        $data = $this
            ->where(['mobile'=>$mobile])
            ->find();
        return empty($data) ? []: $data;
    }
    public function checkMobileRegister($mobile, $password)
    {
        $userInfo = $this->getUserInfoByMobile($mobile);
        $encInfo = Util::encryptPassword($password, $userInfo['enc_salt']);
        return ($encInfo['encryptedPassword'] === $userInfo['enc_password']);
    }

    public function addUser($params)
    {
        $passwordInfo = Util::encryptPassword($params['password']);

        //创建新用户，如果有渠道信息就绑定对应的渠道

        $userData = [
            'mobile' => $params['mobile'],
            'nickname' => empty(trim($params['nickname'])) ? '艺术者' : $params['nickname'],
            'name' => empty(trim($params['nickname'])) ? '艺术者' : $params['nickname'],
            'gender' => $params['gender'],
            'face' => $params['faceUrl'],
            'enc_password' => $passwordInfo['encryptedPassword'],
            'enc_salt' => $passwordInfo['salt'],
            'motto' => '',
            'resume' => '',
            'from' => empty($params['from']) ? '' : $params['from'],
            'device_info_json' => '{}',
            'ip' => get_client_ip(1),
            'login_times' => 1,
            'last_login_time' => time(),//注册好了之后马上返回登录信息
            'update_time' => time(),
            'create_time' => time(),
            'last_update_time' => time()
        ];
        $this->data($userData);
         $this->save();
         return $this->id;

    }

    public function resetPasswd($mobile, $passwd)
    {
        if ($mobile>0) {
            $passwordInfo = Util::encryptPassword($passwd);
            return $this->where(['mobile' => $mobile])->update(['enc_password' => $passwordInfo['encryptedPassword'], 'enc_salt' => $passwordInfo['salt']]);
        } else {
            return false;
        }
    }
}