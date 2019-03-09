<?php
namespace app\passport\logic;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:04
 */
use think\Model;
use app\passport\logic\User as UserLogic;
class Third extends Model
{
    //枚举常量的加入和定义
    const TYPE_LIST_REVERSE = [
        'WECHAT'=>1,
        'QQ'=>2,
        'WEIBO'=>3
    ];
    public function isUserBindMobile($type, $unionid,$openId)
    {
        $user_info = $this
            ->where(['type'=>$type,'union_id'=>$unionid, 'state'=>2, 'is_unbind'=>'N'])//只验证union_id
            ->field('bind_user_id')->find();
        return $user_info ? $user_info:false ;
    }

    //bind to user
    public function bindToUser($userInfo, $thirdInfo, $thirdFullInfoJson = '{}')
    {
        //$thirdInfo['nickname'] = Util::emojiStrReplace($thirdInfo['nickname']);
        $thirdData = [
            'bind_user_id' => $userInfo['id'],
            'type' => self::TYPE_LIST_REVERSE[$thirdInfo['partnerCode']],
            'open_id' => $thirdInfo['openId'],
            'union_id' => $thirdInfo['unionId'],
            'nickname' => empty(trim($thirdInfo['nickname'])) ? '艺术者' : $thirdInfo['nickname'],
            'name'     => empty(trim($thirdInfo['nickname'])) ? '艺术者' : $thirdInfo['nickname'],
            'gender' => (int)$thirdInfo['gender'],
            'face_url' => $thirdInfo['faceUrl'],
            'third_full_json' => $thirdFullInfoJson,
            'create_time'=>$_SERVER['REQUEST_TIME'],
            'bind_time' => $_SERVER['REQUEST_TIME'],
        ];

        //process the no face user data.
        if ($userInfo['face'] === '-1' || empty($userInfo['face']))
        {
            if(trim($thirdInfo['faceUrl'])!=''){
                $userLogic = new UserLogic();
                $userLogic->where(['id'=>$userInfo['id']])->update(['face'=>trim($thirdInfo['faceUrl'])]);
            }

        }
        $this->data($thirdData);
        $this->save();
        return $this->id;

    }
}