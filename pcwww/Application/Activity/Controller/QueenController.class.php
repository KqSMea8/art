<?php

namespace Activity\Controller;

use Activity\Base\ApiBaseController;
use Custom\Helper\Util;
use Custom\Define\Code;
use Custom\Define\Cache;
use Custom\Define\Time;
use Custom\Manager\Token;

//女王节活动
class QueenController extends ApiBaseController
{
    protected $activityId = 1;//活动id

    /**
     * 3.8节活动test  支持（抵扣）
     * 注：
     * 1.同一个商品，一个用户只能购买一次
     * 2.同一个商品，一个用户的同一个好友只能支持一次
     * 3.一个分享（同一商品，同一用户）的好友支持数量最多为50个
     */
    public function bargain()
    {
        $shareId = intval(I('post.share_id', ''));//分享id
        $unionId = addslashes(trim(I('post.union_id', '')));//支持者微信用户union_id
        $wxFace = addslashes(trim(I('post.wx_face', '')));//支持者微信用户头像
        $wxName = addslashes(trim(I('post.wx_name', '')));//支持者微信用户昵称

        if (empty($shareId)) {
            Util::jsonReturn(null, Code::SYS_ERR, '参数错误！');
        }
        if (empty($unionId)) {
            Util::jsonReturn(null, Code::SYS_ERR, '参数错误！');
        }

        //获取分享信息
        $shareInfo = M('shop_activity_share')->where(['id'=>$shareId])->find();
        if(empty($shareInfo)){
            Util::jsonReturn(null, Code::SYS_ERR, '该数据不存在！');
        }
        $shareUserId = 0;//分享者用户id
        //获取分享者信息
        if(!empty($shareInfo['user_id'])){
            $shareUserId = $shareInfo['user_id'];
        }elseif(!empty($shareInfo['union_id'])){
            $shareUserInfo = M('third')
                ->field('bind_user_id')
                ->where(['union_id'=>$shareInfo['union_id']])
                ->find();
            if(empty($shareUserInfo)){//还不是艺术者用户
                $shareUserId = 0;
            }else{
                $shareUserId = $shareUserInfo['bind_user_id'];
            }

        }else{
            Util::jsonReturn(null, Code::SYS_ERR, '记录错误！');
        }

        //1.如果分享用户已经购买过该商品，则不再允许砍价
        $saleRecord = M('shop_activity_sale')
            ->where(['user_id' => $shareUserId, 'goods_id' => $shareInfo['goods_id'], 'activity_id' => $this->activityId])
            ->find();
        if ($saleRecord) {
            Util::jsonReturn(null, Code::SYS_ERR, '您的好友已购买了该商品！');
        }

        //2.如果该用户好友（微信用户）已经支持过该用户该商品，不再允许砍价
        $bargainRecord = M('shop_activity_bargain')
            ->where([ 'activity_id' => $this->activityId,'share_id' => $shareId, 'union_id' => $unionId])
            ->find();
        if ($bargainRecord) {
            Util::jsonReturn(null, Code::SYS_ERR, '您已经支持过咯，不如试试另一个按钮吧。');
        }

        //3.如果该用户该商品的砍价次数已经有50次，不再允许砍价
        $times = M('shop_activity_bargain')
            ->where([ 'activity_id' => $this->activityId,'share_id' => $shareId])->count();
        if ($times >= 50) {
            Util::jsonReturn(null, Code::SYS_ERR, '她的助力好友已经达到上限，您可以尝试其他操作');
        }
        //获取该用户该商品已获得的抵扣金额
        $bargains = M('shop_activity_bargain')
            ->field('bargain_value')
            ->where([ 'activity_id' => $this->activityId,'share_id' => $shareId])
            ->select();
        $bargainArr = array_column($bargains, 'bargain_value');
        //计算抵扣金额
        $level =3;
        $levelArray=[];
        if ($times < 10){
            $level =1;
            $levelArray = [5, 5, 5, 5, 5, 5, 5, 10, 22, 55];//1：0-10
        }elseif($times< 30){
            $level =2;
            $levelArray1 = [5, 5, 5, 5, 5, 5, 5, 10, 22, 55];//1：0-10
            $levelArray2 = [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 10, 10, 18, 18];//2：11-30
            $levelArray = array_merge($levelArray1,$levelArray2);
        }elseif ($times < 50) {
            $level =3;
        }


        $new_arr=$this->getDiffer($levelArray,$bargainArr);
        $money = $this->getDeductibleAmount($level,$new_arr);//抵扣金额

        //获取支持者的userid
        $wxUserInfo = M('third')
            ->field('bind_user_id')
            ->where(['union_id'=>$unionId])
            ->find();
        if(empty($wxUserInfo)){//还不是艺术者用户
            $wxUserId=0;
        }else{
            $wxUserId=$wxUserInfo['bind_user_id'];
        }
        $data = [
            'share_id' => $shareId,
            'goods_id' => $shareInfo['goods_id'],
            'activity_id' => $this->activityId,
            'user_id' => $wxUserId,
            'union_id' => $unionId,
            'wx_face' => $wxFace,
            'wx_name' => $wxName,
            'bargain_value' => $money,
            'create_time' => time(),
            'status' => 1,
        ];
        $insertId = M('shop_activity_bargain')->add($data);
        if ($insertId) {
            $info = M('shop_activity_bargain')->field('wx_face,wx_name,bargain_value')->where(['id' => $insertId])->find();
            Util::jsonReturn(['status' => 1000, 'info' => $info]);
        } else {
            Util::jsonReturn(null, Code::SYS_ERR);
        }
    }

   /* public function test(){
        $levelArray1 = [5, 5, 5, 5, 5, 5, 5, 10, 22, 55];//1：0-10
        $levelArray2 = [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 10, 10, 18, 18];//2：11-30
        $bargainArr = [];
        $levelArray = array_merge($levelArray1,$levelArray2);
        $new_arr=$this->getDiffer($levelArray1,$bargainArr);
        $money = $this->getDeductibleAmount(1,$new_arr);

        Util::jsonReturn(['status' => 1000, 'arr' =>$new_arr, 'money' =>$money]);

    }*/

    /**
     * 获取两个索引数组差集，
     * @param $arr1
     * @param $arr2
     * 返回存在$arr1 中，不存在$arr2中的值
     */
    private function getDiffer($arr1=[],$arr2=[]){
        for ($i=0; $i<count($arr2); $i++){
            $index = array_search($arr2[$i],$arr1);
            array_splice($arr1,$index,1);
        }

        //Util::jsonReturn(['status' => 1000, 'info' =>$levelArray1]);
        return $arr1;
    }


    /**
     * 获取抵扣金额
     * 1.第一个砍价的人（分享者自己），固定砍价55元
     * @param int $level 1：0-10  2：11-30  3：31-50
     */
    private function getDeductibleAmount($level = 3,$arr = [])
    {
        $money = 5;
        if(!empty($arr)){
            $max = count($arr)-1;
            switch ($level) {
                case 1:
                    if($max==9){//第一个砍价的
                        $money = 55;
                    }else{
                        $randomNum = rand(0, $max);
                        $money = intval($arr[$randomNum]);
                    }
                    break;
                case 2:
                    $randomNum = rand(0, $max);
                    $money = intval($arr[$randomNum]);
                    break;
                case 3:
                    $money = 5;
                    break;
            }
        }else{
            $money = 5;
        }

        return $money;
    }

    /**
     * 获取用户所有商品的对应的抵扣金额
     *
     */
    public function getUserBargains()
    {
        header("Access-Control-Allow-Origin: *");//允许跨域访问
        $postStr = trim(I('post.param', ''));//请求参数json字符串
        $dataStr = Util::des_decode($postStr);
        $data = json_decode($dataStr, true);
        $uid = empty($data['uid']) ? 0 : intval($data['uid']);
        $uid2 = intval(I('post.uid', ''));

        if(empty($uid)){
            if(empty($uid2)){
                Util::jsonReturn(null, Code::SYS_ERR, '参数错误');
            }else{
                $uid = $uid2;
            }
        }


        //活动是否过期
        $activityData = M('shop_activity')->field('time_from,time_end')->where(['activity_id' => $this->activityId])->find();
        if(time() < $activityData['time_from'] && time() > $activityData['time_end']){
            Util::jsonReturn(null, Code::SYS_ERR, '活动已取消');
        }

        //获取用户分享的所有商品
        $shareInfo = M('shop_activity_share')->field('id')
            ->where(['user_id'=>$uid,'activity_id' => $this->activityId])->select();

        $thirdInfo = M('third')
            ->field('union_id')
            ->where(['bind_user_id'=>$uid])
            ->order('id desc')
            ->find();

        if(!empty($thirdInfo)){
            $shareInfo2 = M('shop_activity_share')->field('id')
                ->where(['union_id'=>$thirdInfo['union_id'],'activity_id' => $this->activityId])->select();
            $shareInfo = array_merge($shareInfo,$shareInfo2);
        }

        $shareIds = array_column($shareInfo,'id');
        $shareIds = implode(',',$shareIds);

        $data = M('shop_activity_bargain')
            ->field('goods_id,sum(bargain_value) as money')
            ->where(['share_id' => ['in',$shareIds ],'activity_id' => $this->activityId])
            ->group('goods_id')
            ->select();

        foreach ($data as $k=>$v){
            $data[$k]['money'] = $v['money']>358?'358':$v['money'];
        }

        $info = [
            'uid' => $uid,
            'data' => $data
        ];
        Util::jsonReturn(['status' => 1000, 'info' => $info]);
    }


    /**
     * 添加售卖记录
     *
     */
    public function sales()
    {
        $postStr = trim(I('post.param', ''));//请求参数json字符串
        $dataStr = Util::des_decode($postStr);
        $data = json_decode($dataStr, true);
        $userId = empty($data['user_id']) ? 0 : intval($data['user_id']);//用户id
        $goodsId = empty($data['goods_id']) ? 0 : addslashes(trim($data['goods_id']));//多个商品id，逗号隔开
//        $bargainValue = empty($data['bargain_value']) ? 0 : intval($data['bargain_value']);//砍价金额
//        $originalPrice = empty($data['original_price']) ? 0 : intval($data['original_price']);//商品原价
//        $saleTime = empty($data['sale_time']) ? 0 : intval($data['sale_time']);//商品原价

        if (empty($userId) || empty($goodsId)) {
            Util::jsonReturn(null, Code::SYS_ERR, '参数错误');
        }

        $records = M('shop_activity_sale')
            ->field('goods_id')
            ->where(['user_id' => $userId, 'goods_id' =>['in',$goodsId] , 'activity_id' => $this->activityId])
            ->select();
        $recordsArr = empty($records)?[]:array_column($records,'goods_id');
        $goodsIdArr = explode(',',$goodsId);
        $new_arr=array_diff($goodsIdArr,$recordsArr);
        $new_arr = array_values($new_arr);
        if (empty($new_arr)) {
            Util::jsonReturn(null, Code::SYS_ERR, '该用户已购买该商品');
        }

        foreach ($new_arr as $k=>$v){
            $insertData[] = [
                'goods_id' => intval($v),
                'activity_id' => $this->activityId,
                'user_id' => $userId,
                'bargain_value' => 0,
                'original_price' => 0,
                'sale_time' => time(),
            ];
        }

        $insertId = M('shop_activity_sale')->addAll($insertData);
        M('shop_activity_bargain')
            ->where(['activity_id' => $this->activityId, 'goods_id' => ['in',$goodsId], 'user_id' => $userId, 'status' => 1])
            ->save(['status' => 2]);

        if ($insertId) {
            Util::jsonReturn(['status' => 1000, 'insertId' => $insertId]);
        } else {
            Util::jsonReturn(null, Code::SYS_ERR);
        }
    }

    public function index(){

        $this->check_LoginOrWechatAuthorize();
        $activity_id = (int)I('get.activity_id');



        require_once ROOT_PATH."vendor/jssdk.php";
        $jssdk = new \JSSDK(C('WECHAT')['AppID'], C('WECHAT')['AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->display();
    }
    public function share(){
        $this->check_LoginOrWechatAuthorize();

        require_once ROOT_PATH."vendor/jssdk.php";
        $jssdk = new \JSSDK(C('WECHAT')['AppID'], C('WECHAT')['AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->display();
    }




}