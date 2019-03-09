<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 14:29
 * @todo 1.商品信息真实的拼接 2.管理员注册商家端  3.通知调试
 */
namespace Api\Controller;
use phpDocumentor\Reflection\Types\Object_;
use Think\Log;
use Think\Model;

class IndexController extends CommonController
{

    protected $cateDict = array(
        '1483'=>'版画',
        '1488'=>'原作',
    );

    /**
     * @var array
     * dsc.goods
        review_status 字段
        商家上传：
        1   等待审核
        2   审核未通过
        3   审核通过
        5   平台上传的 不需要审核
     */
    protected $reviewStatusArray = array(
        1=>'等待审核',
        2=>'审核未通过',
        3=>'审核通过',
    );

    /**
     * @var array
     * dsc_merchants_shop_information
        merchants_audit 字段
        商家上传：
        0   审核中
        1   审核通过
        2   审核未通过
     */
    protected $merchantStatusArray = array(
        0=>'审核中',
        1=>'审核通过',
        2=>'审核未通过',
    );

    protected $yesNoArray = array(
        '是'=>1,
        '否'=>0,
    );

    /**
     * 获取商品的部分信息
     * 需要根据商品的特点返回 包括下架 无货等  装裱和证书
     * @param goodsIdStr 商品的id的字符串
     * @param from 位置：画作详情-1  创作中心-2
     * @return ship_price 邮寄费用
     * @return framed 装裱
     * @return certificate 收藏证书
     */
    public function goodsInfo()
    {
        $goodsIdStr = $this->param['goodsIdStr']?$this->param['goodsIdStr']:'';
        $from = $this->param['from']?$this->param['from']:2;

        $goodsIdArray = explode(',',$goodsIdStr);
        if (empty($goodsIdArray)){
            $this->ret['state'] = 400;
            $this->ret['msg'] = '参数不正确';
        }else{
            $map['goods_id'] = array('IN',$goodsIdArray);
            if ($from == 1){
                $map['is_delete'] = 0; // 未删除
                $map['is_on_sale'] = 1; // 正在销售
                $map['review_status'] = array('IN',array(3,5));// 审核已经通过的
            }
            $goodsData = M('goods')->where($map)->select();

            $goodsAttrArray = M('goods_attr')->where(['goods_id'=>['in',$goodsIdArray]])->select();
            $goodsAttrs = array();
            foreach ($goodsAttrArray as $key=>$value){
                if ($value['attr_id'] == 51){// 收藏证书
                    $goodsAttrs[$value['goods_id']]['certificate'] = empty($this->yesNoArray[$value['attr_value']])?0:$this->yesNoArray[$value['attr_value']];
                }

                if ($value['attr_id'] == 50){ // 是否
                    $goodsAttrs[$value['goods_id']]['framed'] = empty($this->yesNoArray[$value['attr_value']])?0:$this->yesNoArray[$value['attr_value']];
                }
            }

            $retData = array();
            $baseLink = C('MOBILE_LINK').C('MOBILE_GOODS_LINK');
            foreach ($goodsData as $k=>$v){

                $goods_id = $item['goods_id'] = $v['goods_id'];
                $item['price'] = $v['shop_price'];//本地售价

                // 涉及到goods三个字段 is_shipping  shipping_fee  freight
                if ($v['is_shipping']){
                    $item['ship_price'] = 0.0;
                }else{
                    $item['ship_price'] = $v['shipping_fee'];
                }

                $item['framed'] = empty($goodsAttrs[$goods_id]['framed'])?0:$goodsAttrs[$goods_id]['framed'];
                $item['certificate'] = empty($goodsAttrs[$goods_id]['certificate'])?0:$goodsAttrs[$goods_id]['certificate'];

                // 返回数据处理
                switch ($from){
                    case 1:
                        if ($v['cat_id'] == 1483){
                            $item['link'] = $baseLink.$v['goods_id'];
                            $retData['prints'] = $item;
                        }elseif ($v['cat_id'] == 1488){
                            $item['link'] = $baseLink.$v['goods_id'];
                            $orderGoods = M('order_goods')
                                ->field('dsc_order_goods.order_id')
                                ->join('dsc_order_info ON dsc_order_goods.order_id = dsc_order_info.order_id')
                                ->where(['dsc_order_goods.goods_id' => $goods_id,'dsc_order_info.pay_status' => 2])
                                ->find();//获取商品的下单信息
                            if ($orderGoods){
                                $item['sold'] = 1;
                                $orderId = $orderGoods['order_id'];
                                $model = M('users');
                                $user =$model->join('dsc_order_info ON dsc_users.user_id = dsc_order_info.user_id')
                                    ->where("dsc_order_info.order_id = $orderId")
                                    ->find();
                                $item['user'] = array(
                                    'user_id'=>$user['user_id'],
                                    'user_face'=>$user['user_picture'],
                                    'user_name'=>$user['nick_name'],
                                );

                            }else{
                                $item['sold'] = 0;
                                //$item['user'] = (object)null;
                            }
                            $retData['raw'] = $item;
                        }
                        break;
                    case 2:
                        $status = $this->reviewStatusArray[$v['review_status']];
                        $item['review_state'] = $status ? $status : '审核中';
                        $item['review_code'] = $v['review_status'];
                        $item['is_shipping'] = $v['is_shipping'];
                        $retData[$v['goods_id']] = $item;
                        break;
                }
            }
            $this->ret['data'] = $retData;
        }
        $this->ajaxReturn($this->ret);
    }

    /**
     * 艺术家申请入驻的接口
     */
    public function merchantApply()
    {
        //入驻流程信息
        $userId = $this->param['userId']?$this->param['userId']:'';//用户id

        // 判断用户是否存在于用户的表单,如果用户不存在,表内添加
        $user = M('users')->where("user_id = $userId")->find();
        if (!$user){
            $getUserUrl = C('USER_CENTER').C('GET_USERINFO_BYID');
            $postStr = des_encode(json_encode(array('user_id'=>$userId)));
            $data = requireArtzhe($postStr, $getUserUrl);


            // 插入数据库
            if (!$this->insertUser($data['data'])){
                $this->ret['state'] = 402;
                $this->ret['msg'] = '用户信息缺失，添加错误';
            }
        }

        $agreement = $this->param['agreement']?$this->param['agreement']:1;//同意入驻协议
        $contactXinbie = $this->param['contactXinbie']?$this->param['contactXinbie']:'男';//联系人性别
        $contactName = $this->param['contactName']?$this->param['contactName']:'';//联系人姓名
        $contactPhone = $this->param['contactPhone']?$this->param['contactPhone']:'';//联系人手机
        $contactEmail = $this->param['contactEmail']?$this->param['contactEmail']:'';//联系人电子邮箱
        $accountNumber = $this->param['accountNumber']?$this->param['accountNumber']:'';//银行帐号
        $bankName = $this->param['bankName']?$this->param['bankName']:'';//开户银行名称
        $personFileImg = $this->param['personFileImg']?$this->param['personFileImg']:'';//开户银行名称
        //商铺信息
        $shopName = $this->param['shopName']?$this->param['shopName']:'';//期望店铺名称
        $hopeLoginName = $this->param['hopeLoginName']?$this->param['hopeLoginName']:'';//期望店铺登陆用户名

        if(empty($userId) || empty($shopName) || empty($hopeLoginName)){
            $this->ret['state'] = 400;
            $this->ret['msg'] = '参数不正确';
        }else{
            //入驻流程信息
            $setpData=[
                'user_id'=>$userId,
                'agreement'=>$agreement,
                'steps_site'=>'merchants_steps.php?step=stepSubmit&pid_key=0',
                'site_process'=>'merchants_steps.php?step=stepSubmit&pid_key=0',
                'contactName'=>$contactName,
                'contactPhone'=>$contactPhone,
                'contactEmail'=>$contactEmail,
                'contactXinbie'=>$contactXinbie,
                'organization_code'=>'',
                'organization_fileImg'=>'',
                'companyName'=>'',
                'business_license_id'=>'',
                'legal_person'=>'',
                'personalNo'=>'',
                'legal_person_fileImg'=>$personFileImg,
                'license_comp_adress'=>'',
                'license_adress'=>'',
                'establish_date'=>'',
                'business_term'=>'',
                'busines_scope'=>'',
                'license_fileImg'=>'',
                'company_located'=>'',
                'company_adress'=>'',
                'company_contactTel'=>'',
                'company_tentactr'=>'',
                'company_phone'=>'',
                'taxpayer_id'=>'',
                'taxs_type'=>'',
                'taxs_num'=>'',
                'tax_fileImg'=>'',
                'status_tax_fileImg'=>'',
                'company_name'=>'',
                'account_number'=>$accountNumber,
                'bank_name'=>$bankName,
                'linked_bank_number'=>'',
                'linked_bank_address'=>'',
                'linked_bank_fileImg'=>'',
                'company_type'=>'',
                'company_website'=>'',
                'company_sale'=>'',
                'shop_seller_have_experience'=>'',
                'shop_website'=>'',
                'shop_employee_num'=>'',
                'shop_sale_num'=>'',
                'shop_average_price'=>'',
                'shop_warehouse_condition'=>'',
                'shop_warehouse_address'=>'',
                'shop_delicery_company'=>'',
                'shop_erp_type'=>'',
                'shop_operating_company'=>'',
                'shop_buy_ecmoban_store'=>'',
                'shop_buy_delivery'=>'',
                'preVendorId'=>'',
                'preVendorId_fileImg'=>'',
                'shop_vertical'=>'',
                'registered_capital'=>'',
            ];

            //商铺信息
            $shopData=[
                'user_id'=>$userId,
                'shoprz_type'=>0,
                'subShoprz_type'=>0,
                'shop_expireDateStart'=>'',
                'shop_expireDateEnd'=>'',
                'shop_permanent'=>0,
                'authorizeFile'=>'',
                'shop_hypermarketFile'=>'',
                'shop_categoryMain'=>0,
                'user_shopMain_category'=>'',
                'shoprz_brandName'=>$shopName,
                'shop_class_keyWords'=>'',
                'shopNameSuffix'=>'',
                'rz_shopName'=>$shopName,
                'hopeLoginName'=>$hopeLoginName,
                'merchants_message'=>'',
                'steps_audit'=>1,
                'merchants_audit'=>0,
            ];

            $where['user_id'] = $userId;
            $userStep = M('merchants_steps_fields')->field('fid')->where($where)->find();
            $userShop = M('merchants_shop_information')->field('shop_id')->where($where)->find();
            if(!empty($userStep)){
                $stepId = M('merchants_steps_fields')->where($where)->save($setpData);
            }else{
                $stepId = M('merchants_steps_fields')->add($setpData);
            }
            if(!empty($userShop)) {
                $shopId = M('merchants_shop_information')->where($where)->save($shopData);
            }else{
                $shopId = M('merchants_shop_information')->add($shopData);
            }

            $shop_info = M('merchants_shop_information')->field('rz_shopName,hopeLoginName,merchants_audit')->where($where)->find();
            $this->ret['data'] = empty($shop_info)?'':$shop_info;
        }
        $this->ajaxReturn($this->ret);
    }


    // 新插入一个用户
    private function insertUser($data){
        $row = $data;
        $mobile = $row['mobile'];
        $user_id = $row['id'];
        $randNum = substr($mobile,strlen($mobile)- 3,3).substr(strval($user_id),strlen(strval($user_id))- 3,3);
        $user_name = $row['name'].$randNum;
        $nick_name = $row['nickname']?$row['nickname']:$user_name;
        $user_picture = $row['face'];
        $reg_time = time();
        $passwd = md5('artzhe2018');
        $time = time();
        $rand = rand(10,99);
        $uc_sn = "$time"."$rand";

        $s1 = "INSERT INTO `dsc_users` (user_id,nick_name,user_name,password,mobile_phone,reg_time,user_picture) VALUES ($user_id,'$nick_name','$user_name','$passwd','$mobile',$reg_time,'$user_picture');";
        $s2 = "INSERT INTO `dsc_coupons_user` VALUES (NULL,$user_id,'1',0,$uc_sn,0,0)";

        $model = new Model(); // 实例化一个model对象 没有对应任何数据表
        $model->execute($s1);
        $result = $model->getLastInsID();
        $model->execute($s2);
        return $result;
    }

    /**
     * 商家的申请状态
     * @param 商家的id
     */
    public function merchantApplyState()
    {
        $merchantId = $this->param['user_id']?$this->param['user_id']:'';
        if (empty($merchantId)){
            $this->ret['state'] = 400;
            $this->ret['msg'] = '参数不正确';
        }else{
            $merchantData = M('merchants_shop_information')->where("user_id = $merchantId")->find();
            $retData = array();
            if ($merchantData){
                $retData['checkCode'] = $merchantData['merchants_audit'];
                $retData['checkState'] = $this->merchantStatusArray[$merchantData['merchants_audit']];
                $retData['checkMsg'] = $merchantData['merchants_message'];
            }else{
                $this->ret['state'] = 401;
                $this->ret['msg'] = '无入驻信息';
            }
            $this->ret['data'] = $retData;
        }
        $this->ajaxReturn($this->ret);
    }
}