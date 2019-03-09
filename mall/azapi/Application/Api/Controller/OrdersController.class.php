<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23
 * Time: 14:16
 */

namespace Api\Controller;


class OrdersController extends CommonController
{

    //用户订单列表
    function userOrders(){

        $userid = $this->param['userid']?(int)$this->param['userid']:'0';//用户id

        $page = $this->param['page']?(int)$this->param['page']:'1';
        $pagesize = $this->param['pagesize']?(int)$this->param['pagesize']:'10';
        $type = $this->param['type']?$this->param['type']:'';

        $page = $page <= 0 ? 1 : $page;
        $pagesize = $pagesize <= 0 ? 20 : $pagesize;
        $pagesize = $pagesize > 200 ? 20 : $pagesize;


        $order_infoM=M("order_info");
        $order_goodsM=M("order_goods");

        $where['user_id'] = $userid;
        $where['is_delete'] = 0;
        if($type=='toBe_pay'){
            $where['pay_status'] = 0;

            $where['_string'] = 'order_status=0 or order_status=1';


        }elseif($type=='toBe_confirmed'){
            $where['order_status'] = 5;
            $where['shipping_status'] = 1;
            $where['pay_status'] = 2;
        }

        $total = $order_infoM->where($where)->count();
//        echo $order_infoM->getLastSql();exit;
        $list = $order_infoM
            ->field('order_id,order_sn,order_status,shipping_status,pay_status,consignee,country,province,city,street,address,mobile,goods_amount,order_amount,add_time,money_paid')
            ->where($where)
            ->order('order_id desc')
            ->page($page, $pagesize)
            ->select();


        //查询 商品
        $goods_list=[];
        if(count($list)>0) {
            $order_ids = [];
            foreach ($list as $value) {
                array_push($order_ids, $value['order_id']);
            }

            $orders = $order_goodsM
                ->field('order_id,dsc_goods.goods_id,dsc_goods.goods_name,dsc_goods.goods_thumb,dsc_goods.goods_img,dsc_goods.original_img,dsc_order_goods.goods_number,dsc_order_goods.market_price,dsc_order_goods.goods_price')
                ->join('dsc_goods on dsc_order_goods.goods_id=dsc_goods.goods_id')
                ->where('dsc_order_goods.order_id in ('.implode($order_ids,',').')')
                ->order('rec_id')
                ->select();
//          echo $order_goodsM->getLastSql();exit;
            foreach ($orders as $value){
                $goods_list[$value['order_id']][]=$value;
            }
        }

        //查询 商品 end

        $list_new=[];
        foreach ($list as $value) {
            $value['goods_list']=$goods_list[$value['order_id']];
            $list_new[]=$value;
        }


        $maxpage = ceil($total / $pagesize) ;
        $info = [
            'list' => $list_new,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];

        echo json_encode($info);

    }

    //订单统计
    function Statistics(){
        $userid = $this->param['userid']?(int)$this->param['userid']:'0';//用户id
        $order_infoM=M("order_info");

        $where_all['user_id'] = $userid;
        $where_all['is_delete'] = 0;
        $order_all = $order_infoM->where($where_all)->count();

        $where_toBe_pay['user_id'] = $userid;
        $where_toBe_pay['is_delete'] = 0;
        $where_toBe_pay['pay_status'] = 0;
        $where_toBe_pay['_string'] = 'order_status=0 or order_status=1';
        $order_toBe_pay = $order_infoM->where($where_toBe_pay)->count();

        $where_toBe_confirmed['user_id'] = $userid;
        $where_toBe_confirmed['is_delete'] = 0;
        $where_toBe_confirmed['order_status'] = 5;
        $where_toBe_confirmed['shipping_status'] = 1;
        $where_toBe_confirmed['pay_status'] = 2;
        $order_toBe_confirmed = $order_infoM->where($where_toBe_confirmed)->count();
        $info = [
            'order_all' => $order_all,
            'order_toBe_pay' => $order_toBe_pay,
            'order_toBe_confirmed' => $order_toBe_confirmed,
        ];
        echo json_encode($info);
    }

    //订单数据
    function getOrderData(){
        $userid = $this->param['userid']?(int)$this->param['userid']:'0';//用户id
        $order_id = $this->param['order_id']?(int)$this->param['order_id']:'0';
        $order_infoM=M("order_info");
        $users_infoM=M("users");
        $order_goods_infoM=M("order_goods");
        $region_infoM=M("region");


        $order_info = $order_infoM
            ->field('dsc_order_info.user_id,dsc_order_info.order_id,dsc_pay_log.log_id,dsc_order_info.order_amount,dsc_order_info.order_sn,dsc_order_info.province,dsc_order_info.city,dsc_order_info.mobile')
            ->join('dsc_pay_log on dsc_order_info.order_id=dsc_pay_log.order_id ')
            ->where('dsc_order_info.order_id='.$order_id.' and (dsc_order_info.order_status=0 or dsc_order_info.order_status=1) and  dsc_order_info.is_delete=0 and dsc_order_info.user_id='.intval($userid).' and dsc_pay_log.is_paid = 0  ')->find();

       $user_info=$users_infoM
           ->field('user_id,reg_time,mobile_phone')
           ->where(['user_id'=>$userid])
           ->find();

        $order_goods_info=$order_goods_infoM
            ->field('count(goods_number) as goods_count')
            ->where(['order_id'=>$order_id])
            ->find();

        $province_info=$region_infoM
            ->field('code')
            ->where(['region_id'=>(int)$order_info['province']])
            ->find();

        $city_info=$region_infoM
            ->field('code')
            ->where(['region_id'=>(int)$order_info['city']])
            ->find();

        $order_all=[
            'user_id'=>$order_info['user_id'],
            'order_id'=>$order_info['order_id'],
            'log_id'=>$order_info['log_id'],
            'order_amount'=>$order_info['order_amount'],
            'order_sn'=>$order_info['order_sn'],

            'reg_time'=>$user_info['reg_time'],
            'user_info_bind_phone'=>$user_info['mobile_phone'],


            'goods_count'=>$order_goods_info['goods_count'],

            'delivery_addr_province'=>$province_info['code'],
            'delivery_addr_city'=>$city_info['code'],

            'mobile_phone'=>$order_info['mobile'],
        ];

        $info = [
            'order_info' => $order_all,

        ];
        echo json_encode($info);

    }

}