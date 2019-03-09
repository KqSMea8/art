<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/6
 * Time: 16:26
 */

namespace Activity\Controller;

use Activity\Base\ApiBaseController;
use Custom\Helper\Util;
use Custom\Define\Code;

class ShopActivityShareController extends ApiBaseController
{
    public function detail()
    {



        $ShopActivityShareM = M('ShopActivityShare');
        $ShopActivityBargainM = M('ShopActivityBargain');
        $ShopActivityM = M('ShopActivity');
        $ShopActivityGoodsM = M('ShopActivityGoods');

        $share_id = I('post.share_id', '', 'number_int');
        $page = I('post.page', '', 'number_int');
        $pagesize = I('post.pagesize', '', 'number_int');


        $page = $page <= 0 ? 1 : $page;
        $pagesize = $pagesize <= 0 ? 20 : $pagesize;
        $pagesize = $pagesize > 200 ? 20 : $pagesize;

        $ShopActivityShare_info = $ShopActivityShareM->where(['id' => intval($share_id), 'status' => 1])->find();

        if (!$ShopActivityShare_info) {
            Util::jsonReturn(null, Code::NOT_FOUND, '分享不存在');
        }

        $ShopActivity_info = $ShopActivityM->where(['activity_id' => intval($ShopActivityShare_info['activity_id']), 'status' => 1])->find();
        if (!$ShopActivity_info) {
            Util::jsonReturn(null, Code::NOT_FOUND, '活动不存在');
        }
        ShopActivityAccess_add($ShopActivityShare_info['activity_id']);

        $ShopActivityGoods_info = $ShopActivityGoodsM->where(['activity_id' => intval($ShopActivityShare_info['activity_id']), 'goods_id' => intval($ShopActivityShare_info['goods_id'])])->find();

        $thistime = time();
        $activity_status = 1;
        if ($thistime < $ShopActivity_info['time_from']) {
            $activity_status = 2;
        }
        if ($thistime > $ShopActivity_info['time_end']) {
            $activity_status = 3;
        }


        $where['share_id'] = intval($share_id);
        $where['status'] = 1;

        $lists = $ShopActivityBargainM
            ->where($where)
            ->order('id desc')
            ->select();


        $lists_return = [];
        foreach ($lists as $value) {

            $list["nickname"] = $value['wx_name'];
            $list["face"] = $value['wx_face'];
            $list["user_id"] = $value['user_id'];
            $list["union_id"] = $value['union_id'];
            $list["bargain_value"] = (float)$value['bargain_value'];

//            $list["create_time"] = date('Y-m-d H:i:s',$value['create_time']);


            $lists_return[] = $list;//添加进articles
        }


        if($this->loginUserId){
            $UserM=M('User');
            $userlogin_info=$UserM->find('nickname,face')->where(['id'=>$this->loginUserId])->find();

            $ThirdM = M('Third');
            $third_row=$ThirdM->where(['bind_user_id'=>$this->loginUserId,'type'=>1,'state'=>2])->find();
        }
        $userinfo = [
            'user_id' => (int)$this->loginUserId,
            'user_nickname'=>trim($userlogin_info['nickname']),
            'user_face'=>trim($userlogin_info['face']),
            'user_union_id'=>trim($userlogin_info['union_id']),
            'WechatAuthorize' => session('WechatAuthorize'),
        ];

        $info = [
            'userinfo' => $userinfo,
            'share_user_id' => $ShopActivityShare_info['user_id'],
            'share_union_id' => $ShopActivityShare_info['union_id'],
            'share_wx_name' => $ShopActivityShare_info['wx_name'],
            'share_wx_face' => $ShopActivityShare_info['wx_face'],
            'share_goods_name' => $ShopActivityGoods_info['goods_name'],
            'share_goods_id' => $ShopActivityGoods_info['goods_id'],
            'share_goods_cover' => $ShopActivityGoods_info['goods_cover'],
            'share_goods_price' => $ShopActivityGoods_info['goods_price'],

            'activity_id' => $ShopActivity_info['activity_id'],
            'activity_name' => $ShopActivity_info['activity_name'],
            'activity_content' => $ShopActivity_info['content'],
            'activity_time_from' => date('Y-m-d H:i:s', $ShopActivity_info['time_from']),
            'activity_time_end' => date('Y-m-d H:i:s', $ShopActivity_info['time_end']),
            'activity_status' => $activity_status,
            'list' => $lists_return,
//            'share_link'=>$this->make_share_signature(),

        ];

        Util::jsonReturn(['status' => Code::SUCCESS, 'info' => $info]);


    }

    public function GetShare(){




        $activity_goods_id = (int)I('post.activity_goods_id');

        $ShopActivityGoodsM = M('ShopActivityGoods');
        $ShopActivityM = M('ShopActivity');
        $ShopActivityShareM = M('ShopActivityShare');

        $ShopActivityGoods_info = $ShopActivityGoodsM->where(['id' => $activity_goods_id,'status'=>1])->find();
        if (!$ShopActivityGoods_info) {
            Util::jsonReturn(null, Code::NOT_FOUND, '商品不存在');
        }

        $ShopActivity_info = $ShopActivityM->where(['activity_id' => intval($ShopActivityGoods_info['activity_id']), 'status' => 1])->find();
        if (!$ShopActivity_info) {
            Util::jsonReturn(null, Code::NOT_FOUND, '活动不存在');
        }

        $thistime=time();
        if ($thistime < $ShopActivity_info['time_from']) {
            Util::jsonReturn(null, Code::NOT_FOUND, '活动还未开始，不能分享');
        }
        if ($thistime > $ShopActivity_info['time_end']) {
            Util::jsonReturn(null, Code::NOT_FOUND, '活动已经结束，不能分享');
        }

        $user_id=$this->loginUserId;
        $WechatAuthorize=session('WechatAuthorize');
        if($user_id>0||$WechatAuthorize!=''){
            ShopActivityAccess_add($ShopActivityGoods_info['activity_id']);




            if ($user_id > 0) {
                $UserM = M('User');
                $userinfo = $UserM->field('nickname,face')->where(['id' => $user_id])->find();
                $face = $userinfo['face'];
                $nickname = $userinfo['nickname'];

                $ThirdM = M('Third');
                $third_row=$ThirdM->where(['bind_user_id'=>$this->loginUserId,'type'=>1,'state'=>2])->order('id desc')->find();
                $union_id=trim($third_row['union_id']);

            } elseif ($WechatAuthorize != '') {
                $face = $WechatAuthorize['faceUrl'];
                $nickname = $WechatAuthorize['nickname'];
                $union_id=trim($WechatAuthorize['unionId']);
            }

            $ShopActivityShare_info=$ShopActivityShareM->where([
                'goods_id' => $ShopActivityGoods_info['goods_id'],
                'activity_id' => $ShopActivityGoods_info['activity_id'],
                'user_id' => (int)$user_id,
                'union_id' => $union_id,
            ])->find();

            if(!$ShopActivityShare_info) {


                $data = [
                    'goods_id' => $ShopActivityGoods_info['goods_id'],
                    'activity_id' => $ShopActivityGoods_info['activity_id'],
                    'user_id' => (int)$user_id,
                    'union_id' => $union_id,
                    'wx_face' => $face,
                    'wx_name' => $nickname,
                    'create_time' => time(),
                ];
//                print_r($data);
                $share_id = $ShopActivityShareM->add($data);
                Util::jsonReturn(['status' => Code::SUCCESS, 'info' => ['share_id'=>$share_id,'nickname'=>$nickname]]);
            }else{
                $share_id=$ShopActivityShare_info['id'];
                Util::jsonReturn(['status' => 1001, 'info' => ['share_id'=>$share_id,'nickname'=>$nickname]]);

            }




        }else{
            Util::jsonReturn(null, Code::SYS_ERR, '请在微信或者app中打开');
        }


    }


    private function make_share_signature()
    {
        require_once ROOT_PATH."vendor/jssdk.php";
        $jssdk = new \JSSDK(C('WECHAT')['AppID'], C('WECHAT')['AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        return [
            'appId' => $signPackage["appId"],
            'timestamp' => $signPackage["timestamp"],
            'nonceStr' => $signPackage["nonceStr"],
            'signature' => $signPackage["signature"],

        ];
    }

}