<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Api\Model\ThirdModel;
use Api\Model\UserModel;
use Custom\Helper\Oss;
use Custom\Define\Image;
use Custom\Helper\Util;

class ThirdLogic extends BaseLogic
{
    //判定用户是否绑定手机
    public function isUserBindMobile($type, $unionid,$openId)
    {
        $userId = $this->model
            //->where(['type'=>$type,'union_id'=>$unionid, 'open_id'=>$openId, 'state'=>2, 'is_unbind'=>'N'])
            ->where(['type'=>$type,'union_id'=>$unionid, 'state'=>2, 'is_unbind'=>'N'])//只验证union_id
            ->getField('bind_user_id');
        return empty($userId) ? false : $userId;
    }
    public function isBind($type, $userId)
    {
        $id = (int)$this->where(['type'=>$type, 'bind_user_id'=>$userId])->getField('id');
        return empty($id) ? false : $id;
    }
    /*
     * $userId来自az_user.id,
     * $thirdInfo的数据结构：
      {
      "partnerCode":"合作方编码。WECHAT：微信；QQ：QQ；WEIBO：新浪微博",
      "openId":"合作方登录账号开放ID",
      "unionId":"合作方登录账号联合ID",
      "nickname":"昵称，为空值时，从合作方用户信息里取相应的nickname",
      "gender":"性别。1：男；2：女；3：保密",
      "faceUrl":"头像Url "
      }
     */

    //bind to user
    public function bindToUser($userId, $thirdInfo, $thirdFullInfoJson = '{}')
    {
        //$thirdInfo['nickname'] = Util::emojiStrReplace($thirdInfo['nickname']);
        $thirdData = [
            'bind_user_id' => $userId,
            'type' => ThirdModel::TYPE_LIST_REVERSE[$thirdInfo['partnerCode']],
            'open_id' => htmlentities($thirdInfo['openId'],ENT_QUOTES),
            'union_id' => htmlentities($thirdInfo['unionId'],ENT_QUOTES),
            'nickname' => empty(trim($thirdInfo['nickname'])) ? '艺术者' : htmlentities($thirdInfo['nickname'],ENT_QUOTES),
            'name'     => empty(trim($thirdInfo['nickname'])) ? '艺术者' : htmlentities($thirdInfo['nickname'],ENT_QUOTES),
            'gender' => (int)$thirdInfo['gender'],
            'face_url' => htmlentities($thirdInfo['faceUrl'],ENT_QUOTES),
            'third_full_json' => $thirdFullInfoJson,
            'create_time'=>$_SERVER['REQUEST_TIME'],
            'bind_time' => $_SERVER['REQUEST_TIME'],
        ];
        $userLogic = new UserLogic();
        $userInfo = $userLogic->getUserInfoById($userId);
        //process the no face user data.
        if ($userInfo['face'] === '-1' || empty($userInfo['face']))
        {
            $uploadResult = Oss::uploadFaceUrl($thirdInfo['faceUrl']);
            $bodyJson = $uploadResult['body'];
            $bodyArray = json_decode($bodyJson, true);
            $assetsId = $bodyArray['data']['assetsId'];
            $userLogic->setUserField($userId, ['face'=>$assetsId]);
        }
        return $this->model->add($thirdData);
    }
    //把微信的sex（用户的性别，值为1时是男性，值为2时是女性，值为0时是未知）,转化为
    public static function weChatSex2Gender($gender)
    {
        if (in_array($gender, UserModel::GENDER_CN_LIST_REVERSE)) {
            if ($gender === 0 ) {
                return 3;
            } else {
                return intval($gender);
            }
        } else {
            return false;
        }
    }
}
