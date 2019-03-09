<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23
 * Time: 10:50
 */

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Custom\Helper\Crypt3Des;
use Custom\Helper\Util;
use Custom\Define\Code;

class MallController extends ApiBaseController
{

    function OrderList()
    {
        $this->checkLogin();
        $userid = $this->loginUserId;


        $page = I('post.page', '', 'number_int');
        $pagesize = I('post.pagesize', '', 'number_int');

        $type = I('post.type');

        //加密
        $DES = new Crypt3Des();
        $post_data = ['userid' => $userid, 'page' => $page, 'pagesize' => $pagesize, 'type' => $type];
        $param = $DES->encrypt(json_encode($post_data));
        //加密end

        $url_data = ['param' => $param];
        $url = C('Mall_api_url') . 'Orders/userOrders';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $url_data);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);
//        print_r($json);exit;
        if (is_array($arr)) {
            Util::jsonReturn(['status' => Code::SUCCESS, 'info' => $arr]);
        }
    }

    function webllpay()
    {

        require_once(ROOT_PATH . "lib/webllpay/lib/llpay_submit.class.php");

        $order_id = I('get.order_id');
        $userid = $this->loginUserId;

        /* *
         * 配置文件
         * 版本：1.0
         * 日期：2014-06-16
         * 说明：
         * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
         */

//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//商户编号是商户在连连钱包支付平台上开设的商户号码，为18位数字，如：201306081000001016
        $llpay_config['oid_partner'] = '201803300001692013';

//秘钥格式注意不能修改（左对齐，右边有回车符）
        $llpay_config['RSA_PRIVATE_KEY'] = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDX+LfWI9mW4ceAKcn+2ihiWq+yLZfU2oU2qn+nww6xb9F4bBY0
RCFfeqxUDYn9Ib19mwKlLppItlNKIXqWZ8fr6EItVsebuTYhwFJ5hiCgA9JXBCJe
MzuTs1DInqJQchw0Y5Sy74U5bokIXeyQ+Z85ELXTAG2qkoH3smjx9KA/EwIDAQAB
AoGAaOjVjDzv5n4YZeZmy9h3Q4efzyKcnXXkvfBGgFydF44kp6WBh7QMrg+uBEpr
XD32iTwyJcEkiuueO+VVYhhZoRcPzDaiaM+0caIQfZOVDRtA75o/tuktfc5up0/x
MHzU+gXdQq0PkKwBEeKNhI1BeAH4CkMgDvgf/XrgVXXUSfkCQQD11roTEODTqbeg
BaQ5QHbPScHA8JPNYHtXToZLHt9BFnuAYIVNxedlG6wsT0qyidL4HgEaQ6hUlXwy
cqR/sv2fAkEA4OX1sY4gCIK++cGjayN+oJH8FEMP+TZhyWCH/iAJxSJkJdlk0Vvh
weBWftVSm2f9le9ZcdVtiaR7eg+pon3iDQJBAOtytw2xmZI+tqYlIQ7QJboL6uxN
vVDyuc55X3cs3ydoT+o5BxLgmuikIzbgzirGg26s1eOArwQrkyKB1/iRxgMCQCQr
V7RSkzxLKsOoLMwSTU8tq0jm8C64XEmyyKxKIsgdm9WqfNhe2pP/rGmBjWOI+fOf
Jtdz58X3OhSLaFDFxhECQQDcCg4M0HiCXMy41mn4YdKWd6NgZp5jJJwYLYFJslmY
iEgCPQiWjdcIEs7qmvhzI+FUJ6UPnBLVvMzDFvY6Uw8e
-----END RSA PRIVATE KEY-----';

//安全检验码，以数字和字母组成的字符
        $llpay_config['key'] = '201408071000001539_sahdisa_20141205';

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//版本号
        $llpay_config['version'] = '1.0';

//防钓鱼ip 可不传或者传下滑线格式
        $llpay_config['userreq_ip'] = '10_10_246_110';

//证件类型
        $llpay_config['id_type'] = '0';

//签名方式 不需修改
        $llpay_config['sign_type'] = strtoupper('RSA');

//订单有效时间  分钟为单位，默认为10080分钟（7天）
        $llpay_config['valid_order'] = "10080";

//字符编码格式 目前支持 gbk 或 utf-8
        $llpay_config['input_charset'] = strtolower('utf-8');

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $llpay_config['transport'] = 'http';


        //加密
        $DES = new Crypt3Des();
        $post_data = ['userid' => $userid, 'order_id' => $order_id];
        $param = $DES->encrypt(json_encode($post_data));
        //加密end

        $url_data = ['param' => $param];
        $url = C('Mall_api_url') . 'Orders/getOrderData';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $url_data);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($json, 1);
//       print_r($json);exit;
        if (is_array($arr)) {

            $order_info = $arr['order_info'];
            if (count($order_info) == 0) {
                echo 'error';
                exit;
            }


            /**************************请求参数**************************/

//商户用户唯一编号
            $user_id = $order_info['user_id'];

//支付类型
            $busi_partner = 109001;

//商户订单号
            $no_order = $order_info['order_sn'] . 'O' . $order_info['log_id'];
//商户网站订单系统中唯一订单号，必填

//付款金额
            $money_order = $order_info['order_amount'];
//必填

//商品名称
            $name_goods = '艺术者商城原作/版画';

//订单地址
            $url_order = '';

//订单描述
            $info_order = $order_info['order_sn'];

//银行网银编码
            $bank_code = '';

//支付方式
            $pay_type = '';

//卡号
            $card_no = '';

//姓名
            $acct_name = '';

//身份证号
            $id_no = '';

//协议号
            $no_agree = '';

//修改标记
            $flag_modify = '';

//风险控制参数
//            $frms_ware_category=>4007; //商品类目传
//            $user_info_mercht_userno=>$user_id;
//            $user_info_dt_register=>$user_info_dt_register;//注册时间
//            $user_info_bind_phone=>$user_info_bind_phone;//绑定的手机号
//            $delivery_addr_province=>$delivery_addr_province;//收货地址省级编码
//            $delivery_addr_city=>$delivery_addr_city,//收货地址市级编码
//            $delivery_phone=>$delivery_phone;//收货人联系手机
//            $logistics_mode=>2;//物流方式 1:邮局平邮； 2:普通快递； 3:特快专递； 4:物流货运公司； 5:物流配送公司 6:国际快递 7:航运快运 8:海运
//            $delivery_cycle=>'48h';//发货时间 12h: 12小时内； 24h:24小时内； 48h:48小时内； 72h:72小时内； Other:3天后
//            $goods_count=>$goods_count;//商品数量

            $risk_item = '{"frms_ware_category":"4007","user_info_mercht_userno":"' . $user_id . '","user_info_dt_register":"' . date('YmdHis', $order_info['reg_time']) . '"
        ,"user_info_bind_phone":"' . $order_info['user_info_bind_phone'] . '","delivery_addr_province":"' . $order_info['delivery_addr_province'] . '","delivery_addr_city":"' . $order_info['delivery_addr_city'] . '"
        ,"delivery_phone":"' . $order_info['mobile_phone'] . '","logistics_mode":"2","delivery_cycle":"72h","goods_count":"' . $order_info['goods_count'] . '"}';
//echo $risk_item;exit;

//分账信息数据
            $shareing_data = '';

//返回修改信息地址
            $back_url = '';

//订单有效期
            $valid_order = '';

//服务器异步通知页面路径
            $notify_url = C('Mall_webllpay_asyn');
//需http://格式的完整路径，不能加?id=123这类自定义参数

//页面跳转同步通知页面路径
            $return_url = C('Mall_webllpay_syn');
//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

            /************************************************************/
            date_default_timezone_set('PRC');
//构造要请求的参数数组，无需改动
            $parameter = array(
                "version" => trim($llpay_config['version']),
                "oid_partner" => trim($llpay_config['oid_partner']),
                "sign_type" => trim($llpay_config['sign_type']),
                "userreq_ip" => trim($llpay_config['userreq_ip']),
                "id_type" => trim($llpay_config['id_type']),
                "valid_order" => trim($llpay_config['valid_order']),
                "user_id" => $user_id,
                "timestamp" => local_date('YmdHis', time()),
                "busi_partner" => $busi_partner,
                "no_order" => $no_order,
                "dt_order" => local_date('YmdHis', time()),
                "name_goods" => $name_goods,
                "info_order" => $info_order,
                "money_order" => $money_order,
                "notify_url" => $notify_url,
                "url_return" => $return_url,
                "url_order" => $url_order,
                "bank_code" => $bank_code,
                "pay_type" => $pay_type,
                "no_agree" => $no_agree,
                "shareing_data" => $shareing_data,
                "risk_item" => $risk_item,
                "id_no" => $id_no,
                "acct_name" => $acct_name,
                "flag_modify" => $flag_modify,
                "card_no" => $card_no,
                "back_url" => $back_url,


            );
//建立请求
            $llpaySubmit = new \LLpaySubmit($llpay_config);
            $html_text = $llpaySubmit->buildRequestForm($parameter, "post", "付款跳转中......");
            echo $html_text;
        }
    }
}