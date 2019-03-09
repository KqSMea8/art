<?php
defined('IN_ECTOUCH') or die('Deny Access');

use App\Extensions\Http;

require_once (BASE_PATH . "Helpers/llpay_core.php");
require_once (BASE_PATH . "Helpers/llpay_md5.php");
require_once (BASE_PATH . "Helpers/llpay_rsa.php");

//连连支付
class llpay
{
    private $payment; // 配置信息
    private $llpay_gateway_new = 'https://wap.lianlianpay.com/payment.htm';//连连认证支付网关地址

    /**
     * 生成支付代码
     * @param   array $order 订单信息
     * @param   array $payment 支付方式信息
     */
    public function get_code($order, $payment)
    {

        include_once(BASE_PATH . 'Helpers/payment_helper.php');

        // 配置参数
        $this->payment = $payment;

        $order_amount = $order['order_amount'];// 总金额

        //商户用户唯一编号
        $user_id = $order['user_id'];
        //支付类型
        $busi_partner = '109001';
        //商户订单号
        $no_order =  $order['order_sn']  . 'O' . $order['log_id'];//商户网站订单系统中唯一订单号，必填
        //付款金额
        $money_order = $order_amount;//必填
        //商品名称
        $goods = dao('order_goods')->field('goods_name')->where(array('order_id' => $order['order_id']))->find();
        $name_goods = $goods['goods_name'];
        //订单描述
        $info_order = $order['order_sn'];
        //卡号
        $card_no = '';
        //姓名
        $acct_name = '';
        //身份证号
        $id_no = '';
        //协议号
        $no_agree = '';

        $userInfo = dao('users')
            ->where(array('user_id' => $order['user_id']))
            ->find();

        $sql = 'SELECT SUM(goods_number) AS num FROM ' . $GLOBALS['ecs']->table('order_goods') . (' WHERE order_id = \'' . $order['order_id'] . '\'');
        $goods_count = $GLOBALS['db']->getOne($sql);

        //风险控制参数
        //$risk_item['frms_ware_category']='4007';//商品类目
       // $risk_item['user_info_mercht_userno']=$order['user_id'];//商户用户唯一标识
       // $risk_item['user_info_dt_register']=date('YmdHis',$userInfo['reg_time']);//商户用户注册时间YYYYMMDDH24MISS
        // $risk_item['user_info_bind_phone']=$userInfo['mobile_phone'];//商户用户绑定手机号
        //实物类风控参数
       // $risk_item['delivery_addr_province']='';//收货地址省级编码
        //$risk_item['delivery_addr_city']='';//收货地址市级编码
        //$risk_item['delivery_phone']=$order['mobile'];//收货人联系手机
       // $risk_item['logistics_mode ']='2';//物流方式 1:邮局平邮；2:普通快递；3:特快专递；4:物流货运公司；5:物流配送公司6:国际快递7:航运快运8:海运
        //$risk_item['delivery_cycle ']='';//发货时间 12h: 12 小时内；24h:24 小时内；48h:48 小时内；72h:72 小时内；Other:3 天后
        //$risk_item['goods_count ']='';//商品数量
        //支付成功才发送消息

        $orderInfo = dao('order_info')
            ->where(array('order_id' => $order['order_id']))
            ->find();
        $privince = dao('region')
            ->where(array('region_id' => $orderInfo['province']))
            ->find();
        $city = dao('region')
            ->where(array('region_id' => $orderInfo['city']))
            ->find();
        $delivery_addr_province='';
        $delivery_addr_city='';
        $risk_item = '{\\"frms_ware_category\\":\\"4007\\",\\"user_info_mercht_userno\\":\\"'.$order['user_id'].'\\",\\"user_info_dt_register\\":\\"'.date('YmdHis',$userInfo['reg_time']).'\\"
        ,\\"user_info_bind_phone\\":\\"'.$userInfo['mobile_phone'].'\\",\\"delivery_addr_province\\":\\"'.$privince['code'].'\\",\\"delivery_addr_city\\":\\"'.$city['code'].'\\"
        ,\\"delivery_phone\\":\\"'.$order['mobile'].'\\",\\"logistics_mode\\":\\"2\\",\\"delivery_cycle\\":\\"72h\\",\\"goods_count\\":\\"'.$goods_count.'\\"}';

        //服务器异步通知页面路径
        //return __URL__ . '/public/notify/' . $code . '.php';
        $notify_url = __URL__ . "/public/notify/llpay_asyn.php";//需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = __URL__ ."/public/notify/llpay_syn.php";//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //构造要请求的参数数组，无需改动
        $parameter = array (
            "oid_partner" => trim($this->payment['oid_partner']),
            "app_request" => trim($this->payment['app_request']),
            "sign_type" => trim($this->payment['sign_type']),
            "valid_order" => trim($this->payment['valid_order']),
            "user_id" => $user_id,
            "busi_partner" => $busi_partner,
            "no_order" => $no_order,
            "dt_order" => local_date('YmdHis', time()),
            "name_goods" => $name_goods,
            "info_order" => $info_order,
            "money_order" => $money_order,
            "notify_url" => $notify_url,
            "url_return" => $return_url,
            "card_no" => $card_no,
            "acct_name" => $acct_name,
            "id_no" => $id_no,
            "no_agree" => $no_agree,
            "risk_item" => $risk_item,
        );

        //建立请求
        $html_text = $this->buildRequestForm($parameter, "post", "连连支付");

        return $html_text;
    }
    /**
     * 同步通知
     * @param $data
     * @return mixed
     */
    public function callback($data)
    {
        include_once(BASE_PATH . 'Helpers/order_helper.php');
        include_once(BASE_PATH . 'Helpers/payment_helper.php');
        require_once(BASE_PATH . 'Helpers/llpay_notify.php');
        require_once (BASE_PATH . 'Helpers/llpay_cls_json.php');


        $payment = get_payment($data['code']);
        $this->payment = $payment;

        //计算得出通知验证结果
        $llpayNotify = new LLpayNotify($this->payment);
        $verify_result = $llpayNotify->verifyReturn();
        if($verify_result) {//验证成功
            //获取连连支付的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            $json = new JSON;
            $res_data = $_POST["res_data"];

            //商户编号
            $oid_partner = $json->decode($res_data)-> {'oid_partner' };
            //商户订单号
            $no_order = $json->decode($res_data)-> {'no_order' };
            //支付结果
            $result_pay =  $json->decode($res_data)-> {'result_pay' };

            $money_order = $json->decode($res_data)-> {'money_order' };
            if($result_pay == 'SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（no_order）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                // 获取log_id
                $out_trade_no = explode('O', $no_order);
                $log_id = $out_trade_no[1]; // 订单号log_id

                //支付成功才发送消息
                $payData = dao('pay_log')
                    ->where(array('log_id' => $log_id))
                    ->find();

                if ($payData && $payData['is_paid'] == 0) {//订单未支付
                    // 修改订单信息(openid，tranid)
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_llpay.txt", 'order_sn:'.json_encode($out_trade_no[0])."\n", FILE_APPEND);
                    order_paid($log_id, 2);

                    //支付成功才发送消息
                    $payInfo = dao('pay_log')
                        ->where(array('log_id' => $log_id))
                        ->find();

                    if ($payInfo && $payInfo['is_paid'] == 1) {
                        $this->send_pay_msg($payInfo['order_id'],$money_order);
                    }
                }

                //跳到待收货
                $this->Config = require ROOT_PATH .'config/app.php';
                $url = $this->Config['MOBILE_ADDR']."/index.php?m=user&c=order&status=2";
                header("Location: ".$url);
                exit;

            }
            else {
                //echo "result_pay=".$result_pay;
            }

           // echo "验证成功<br />";
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            //跳到待付款
            $this->Config = require ROOT_PATH .'config/app.php';
            $url = $this->Config['MOBILE_ADDR']."/index.php?m=user&c=order&status=1";
            header("Location: ".$url);
            exit;
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            //如要调试，请看llpay_notify.php页面的verifyReturn函数
           // echo "验证失败";
            //跳到待付款
            $this->Config = require ROOT_PATH .'config/app.php';
            $url = $this->Config['MOBILE_ADDR']."/index.php?m=user&c=order&status=1";
            header("Location: ".$url);
            exit;

        }


    }


    /**
     * 异步通知
     * @param $data
     * @return mixed
     */
    public function notify($data)
    {
        include_once(BASE_PATH . 'Helpers/order_helper.php');
        include_once(BASE_PATH . 'Helpers/payment_helper.php');
        require_once (BASE_PATH . 'Helpers/llpay_notify.php');

        $payment = get_payment($data['code']);
        $this->payment = $payment;

        //计算得出通知验证结果
        $llpayNotify = new LLpayNotify($this->payment);
        $llpayNotify->verifyNotify();
        if ($llpayNotify->result) { //验证成功
            //获取连连支付的通知返回参数，可参考技术文档中服务器异步通知参数列表
            $no_order = $llpayNotify->notifyResp['no_order'];//商户订单号
            $oid_paybill = $llpayNotify->notifyResp['oid_paybill'];//连连支付单号
            $result_pay = $llpayNotify->notifyResp['result_pay'];//支付结果，SUCCESS：为支付成功
            $money_order = $llpayNotify->notifyResp['money_order'];// 支付金额
            if($result_pay == "SUCCESS"){
                //请在这里加上商户的业务逻辑程序代(更新订单状态、入账业务)
                //——请根据您的业务逻辑来编写程序——

                // 获取log_id
                $out_trade_no = explode('O', $no_order);
                $log_id = $out_trade_no[1]; // 订单号log_id

                //支付成功才发送消息
                $payData = dao('pay_log')
                    ->where(array('log_id' => $log_id))
                    ->find();

                if ($payData && $payData['is_paid'] == 0) {//订单未支付
                    // 修改订单信息(openid，tranid)
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_llpay.txt", 'order_sn:'.json_encode($out_trade_no[0])."\n", FILE_APPEND);
                    order_paid($log_id, 2);

                    //支付成功才发送消息
                    $payInfo = dao('pay_log')
                        ->where(array('log_id' => $log_id))
                        ->find();

                    if ($payInfo && $payInfo['is_paid'] == 1) {
                        $this->send_pay_msg($payInfo['order_id'],$money_order);
                    }
                }


            }
            //file_put_contents("log.txt", "异步通知 验证成功\n", FILE_APPEND);
            die("{'ret_code':'0000','ret_msg':'交易成功'}"); //请不要修改或删除
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_llpay.txt", "异步通知 验证失败\n", FILE_APPEND);
            //验证失败
            die("{'ret_code':'9999','ret_msg':'验签失败'}");
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }


    public function curl_request($url,$post='',$cookie='', $returnCookie=0){
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
          curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
         curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
          if($post) {
             curl_setopt($curl, CURLOPT_POST, 1);
             curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
         if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
         }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         $data = curl_exec($curl);
         if (curl_errno($curl)) {
             return curl_error($curl);
         }
         curl_close($curl);
         if($returnCookie){
             list($header, $body) = explode("\r\n\r\n", $data, 2);
             preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
             $info['cookie']  = substr($matches[1][0], 1);
             $info['content'] = $body;
             return $info;
         }else{
             return $data;
         }
 }

    public function send_pay_msg($order_id,$real_price =0){
        $sql_data = dao('order_info')->field('user_id,order_sn')->where(array('order_id'=>$order_id,'pay_status'=>2))->find();
        $goods_id = dao('order_goods')->field('goods_id,goods_name')->where(array('order_id'=>$order_id))->select();
        if(  isset($goods_id) && !empty($goods_id)){
            foreach($goods_id as $k=>$v){
                $goods_data[] = dao('goods')->field('user_id,goods_name')->where(array('goods_id'=>$v['goods_id']))->find();
            }
        }
        if(!empty($sql_data)){ //给用户
                $url="http://test-api.artzhe.com/mp/ArtworkGoods/sendMessage";
                $postStr=array(
                        'userId'=>$sql_data['user_id'],
                        'content'=>'您的商品货号为:'.$sql_data['order_sn'].',支付已完成！',
                    );
                $post_data=array('param'=>des_encode(json_encode($postStr)));
                $a = $this->curl_request($url,$post_data);
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_llpay.txt", 'a:'.json_encode( $a)."\n", FILE_APPEND);
        }

        if( !empty( $goods_id ) && !empty($goods_data) ){//给作家

            foreach($goods_data as $k=>$v){
                $url="http://test-api.artzhe.com/mp/ArtworkGoods/sendMessage";
                $postStr=array(
                        'userId'=>$v['user_id'],
                        'content'=>'您的画作:'.$v['goods_name'].',已被购买！',
                    );

                $post_data=array('param'=>des_encode(json_encode($postStr)));
                $b = $this->curl_request($url,$post_data);
                file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_llpay.txt", 'b:'.json_encode( $b)."\n", FILE_APPEND);
            }
        }

       /* if(isset($sql_data) && !empty($sql_data) ){
            $url = "https://test-www.artzhe.com/Activity/Queen/sales";
            $cou_ids = dao('coupons_user')->field('cou_id')->where(array('user_id'=>$sql_data['user_id'],'is_use'=>1))->select();
            if(  isset($cou_ids) && !empty($cou_ids)){
                foreach($cou_ids as $k=>$v){
                   $goods_coupons[]= dao('coupons')->field('cou_goods')->where(array('cou_id'=>$v['cou_id']))->find();
                }
            }
            $require_data=array(
                    'user_id'=>$sql_data['user_id'],
                    'goods_id'=>is_array($goods_coupons)?implode(",",$goods_coupons):'0',
                );
            $post_data=array('param'=>des_encode(json_encode($require_data)));
            $c = $this->curl_request($url,$post_data);
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_llpay.txt", 'c:'.json_encode( $c)."\n", FILE_APPEND);
        }*/

    }



    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    function buildRequestMysign($para_sort) {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);
        $mysign = "";
        //PHP5.3 版本以上 风控参数去斜杠
        $prestr =stripslashes($prestr);
       // file_put_contents("log.txt","新的签名:".$prestr."\n", FILE_APPEND);
        switch (strtoupper(trim($this->payment['sign_type']))) {
            case "MD5" :
                $mysign = md5Sign($prestr, $this->payment['key']);
                break;
            case "RSA" :
                $mysign = RsaSign($prestr, $this->payment['RSA_PRIVATE_KEY']);
                break;
            default :
                $mysign = "";
        }
       // file_put_contents("log.txt","签名:".$mysign."\n", FILE_APPEND);
        return $mysign;
    }

    /**
     * 生成要请求给连连支付的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    function buildRequestPara($para_temp) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);
        //对待签名参数数组排序
        $para_sort = argSort($para_filter);
        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort);
        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign'] = $mysign;
        $para_sort['sign_type'] = strtoupper(trim($this->payment['sign_type']));
        foreach ($para_sort as $key => $value) {
            $para_sort[$key] = urlencode($value);
        }
        return urldecode(json_encode($para_sort));
    }

    /**
     * 生成要请求给连连支付的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    function buildRequestParaToString($para_temp) {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);

        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = createLinkstringUrlencode($para);

        return $request_data;
    }

    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本 <a class="box-flex btn-submit" type="button" onclick="callpay()">微信支付</a>
     */
    function buildRequestForm($para_temp, $method, $button_name) {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);
        $sHtml = "<form style='width: 100%;' id='llpaysubmit' name='llpaysubmit' action='" . $this->llpay_gateway_new . "' method='" . $method . "'>";
        $sHtml .= "<input type='hidden' name='req_data' value='" . $para . "'/>";
        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml . "<input class='box-flex btn-submit' type='submit' value='" . $button_name . "'></form>";
       // $sHtml = $sHtml."<script>document.forms['llpaysubmit'].submit();</script>";
        return $sHtml;
    }

    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取连连支付的处理结果
     * @param $para_temp 请求参数数组
     * @return 连连支付处理结果
     */
    function buildRequestHttp($para_temp) {
        $sResult = '';

        //待请求参数数组字符串
        $request_data = $this->buildRequestPara($para_temp);

        //远程获取数据
        $sResult = getHttpResponsePOST($this->llpay_gateway_new, $this->payment['cacert'], $request_data, trim(strtolower($this->payment['input_charset'])));

        return $sResult;
    }

    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取连连支付的处理结果，带文件上传功能
     * @param $para_temp 请求参数数组
     * @param $file_para_name 文件类型的参数名
     * @param $file_name 文件完整绝对路径
     * @return 连连支付返回处理结果
     */
    function buildRequestHttpInFile($para_temp, $file_para_name, $file_name) {

        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);
        $para[$file_para_name] = "@" . $file_name;

        //远程获取数据
        $sResult = getHttpResponsePOST($this->llpay_gateway_new, $this->payment['cacert'], $para, trim(strtolower($this->payment['input_charset'])));

        return $sResult;
    }

    /**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
     * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
     */
    function query_timestamp() {
        $url = $this->llpay_gateway_new . "service=query_timestamp&partner=" . trim(strtolower($this->payment['partner'])) . "&_input_charset=" . trim(strtolower($this->payment['input_charset']));
        $encrypt_key = "";

        $doc = new DOMDocument();
        $doc->load($url);
        $itemEncrypt_key = $doc->getElementsByTagName("encrypt_key");
        $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;

        return $encrypt_key;
    }
}




