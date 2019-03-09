<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/6
 * Time: 10:38
 */

namespace Activity\Controller;

use Activity\Base\ApiBaseController;
use Custom\Helper\Util;
use Custom\Define\Code;

class ShopActivityGoodsController extends ApiBaseController
{
    public function goods()
    {
        $ShopActivityM = M('ShopActivity');
        $ShopActivityGoodsM = M('ShopActivityGoods');


        $activity_id = I('post.activity_id', '', 'number_int');
        $page = I('post.page', '', 'number_int');
        $pagesize = I('post.pagesize', '', 'number_int');

        $user_isBind_WX=0;
        if($this->loginUserId){
            $ThirdM = M('Third');
            $third_row=$ThirdM->where(['bind_user_id'=>$this->loginUserId,'type'=>1,'state'=>2])->find();
            if(trim($third_row['union_id'])!=''){
                $user_isBind_WX=1;
            }

        }


        $page = $page <= 0 ? 1 : $page;
        $pagesize = $pagesize <= 0 ? 100 : $pagesize;
        $pagesize = $pagesize > 200 ? 20 : $pagesize;

        $ShopActivity_info=$ShopActivityM->where(['activity_id'=>intval($activity_id),'status'=>1])->find();
        if(!$ShopActivity_info){
            Util::jsonReturn(null, Code::NOT_FOUND, '活动不存在');
        }
        ShopActivityAccess_add($activity_id);

        $thistime=time();
        $activity_status=1;
        if($thistime<$ShopActivity_info['time_from']){
            $activity_status=2;
        }
        if($thistime>$ShopActivity_info['time_end']){
            $activity_status=3;
        }


        $where['activity_id'] = intval($activity_id);
        $total = $ShopActivityGoodsM->where($where)->count();
        $lists = $ShopActivityGoodsM
            ->where($where)
            ->order('id desc')
            ->page($page, $pagesize)
            ->select();



        $lists_return = [];
        foreach ($lists as $value) {
            $list['id'] = $value['id'];
            $list['activity_id'] = $value['activity_id'];
            $list['activity_name'] = $ShopActivity_info['activity_name'];
            $list['activity_status'] =$activity_status;
            $list["goods_id"] = $value['goods_id'];
            $list["goods_name"] = $value['goods_name'];
            $list["goods_cover"] = $value['goods_cover'];
            $list["goods_price"] = $value['goods_price'];
//            $list["create_time"] = date('Y-m-d H:i:s',$value['create_time']);


            $lists_return[] = $list;//添加进articles
        }

        $maxpage = ceil($total / $pagesize) ;


        if($this->loginUserId){
            $UserM=M('User');
            $userlogin_info=$UserM->field('nickname,face')->where(['id'=>$this->loginUserId])->find();

            $ThirdM = M('Third');
            $third_row=$ThirdM->where(['bind_user_id'=>$this->loginUserId,'type'=>1,'state'=>2])->order('id desc')->find();
        }
        $userinfo = [
            'user_id' => (int)$this->loginUserId,
            'user_nickname'=>trim($userlogin_info['nickname']),
            'user_face'=>trim($userlogin_info['face']),
            'user_union_id'=>trim($third_row['union_id']),
            'WechatAuthorize' => session('WechatAuthorize'),
        ];

        $info = [
            'userinfo' => $userinfo,
            'is_login'=>$this->loginUserId>0?1:0,
            'user_isBind_WX'=>$user_isBind_WX,
            'activity_id'=>$ShopActivity_info['activity_id'],
            'activity_name'=>$ShopActivity_info['activity_name'],
            'activity_content'=>$ShopActivity_info['content'],
            'activity_time_from'=>date('Y-m-d H:i:s',$ShopActivity_info['time_from']),
            'activity_time_end'=>date('Y-m-d H:i:s',$ShopActivity_info['time_end']),
            'activity_status'=>$activity_status,
            'list' => $lists_return,
            'share_link'=>$this->make_share_signature(),
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];

        Util::jsonReturn(['status' => Code::SUCCESS, 'info' => $info]);
    }
    private function make_share_signature()
    {
        return [
            'appId' => C('WECHAT')['AppID'],
            'timestamp' => time(),
            'nonceStr' => md5(microtime() . rand(1, 999999)),
            'signature' => sha1(microtime() . rand(1, 999999)),
            //'url'=>$url,
        ];
    }
}