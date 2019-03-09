<?php
defined('IN_ECTOUCH') or die('Deny Access');

use App\Extensions\Http;


class wxpay
{
    private $parameters; // cft 参数
    private $payment; // 配置信息
    private $result;//用于H5支付 下单之后的链接凭借

    /**
     * 生成支付代码
     * @param   array $order 订单信息
     * @param   array $payment 支付方式信息
     */
    public function get_code($order, $payment)
    {

        include_once(BASE_PATH . 'Helpers/payment_helper.php');
		
		$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        if( !preg_match('/micromessenger/', $ua)){
            $is_h5=true;
        }
        
		
        // 配置参数
        $this->payment = $payment;

        // 网页授权获取用户openid
        $openid = '';
        if (isset($_SESSION['openid']) && !empty($_SESSION['openid'])) {
            $openid = $_SESSION['openid'];
        } elseif (isset($_SESSION['openid_base']) && !empty($_SESSION['openid_base'])) {
            $openid = $_SESSION['openid_base'];
		} elseif (isset($_SESSION['wxpay_jspay_openid']) && !empty($_SESSION['wxpay_jspay_openid'])) {
            $openid = $_SESSION['wxpay_jspay_openid'];	
        } else {
			
        }
		if(!isset($openid) || empty($openid) ){
            if(!$is_h5){
                 return '<div style="text-align:center"><button class="btn btn-primary" type="button" disabled>未得权限</button></div>';
            }
           
        }
        // 设置必填参数
        // 根目录url
        if(!$is_h5){
             $this->setParameter("openid", "$openid"); 
        }
        $order_amount = $order['order_amount'] * 100;
        $this->setParameter("body", $order['order_sn']); // 商品描述
        $this->setParameter("out_trade_no", $order['order_sn'] . $order_amount . 'O' . $order['log_id']); // 商户订单号
        $this->setParameter("total_fee", $order_amount); // 总金额
        $this->setParameter("notify_url", notify_url(basename(__FILE__, '.php'))); // 通知地址
        if($is_h5){
           $this->setParameter("trade_type", "MWEB"); // 交易类型

           if($this->get_device_type =='ios'){
                $this->setParameter('scene_info','{"h5_info": {"type":"IOS","app_name": "艺术者","bundle_id": "com.YiShuZhe.ArtZhe"}}');
           }elseif($this->get_device_type =='android'){
                $this->setParameter('scene_info','{"h5_info": {"type":"Android","app_name": "艺术者","package_name": "com.artzhe"}}'); 
           }else{
                $this->setParameter('scene_info','{"h5_info": {"type":"Wap","wap_url": "test-mall.artzhe.com","wap_name": "艺术者商城"}}'); 
           }
       }else{
           $this->setParameter("trade_type", "JSAPI"); // 交易类型
            
       }
       
        $prepay_id = $this->getPrepayId();
      
        $jsApiParameters = $this->getParameters($prepay_id);
        // wxjsbridge
        $js = '<script language="javascript">
            function jsApiCall(){WeixinJSBridge.invoke("getBrandWCPayRequest",' . $jsApiParameters . ',function(res){if(res.err_msg == "get_brand_wcpay_request:ok"){location.href="' . return_url(basename(__FILE__, '.php')) . '&status=1"}else{location.href="' . return_url(basename(__FILE__, '.php')) . '&status=0"}})};function callpay(){if (typeof WeixinJSBridge == "undefined"){if( document.addEventListener ){document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);}else if (document.attachEvent){document.attachEvent("WeixinJSBridgeReady", jsApiCall);document.attachEvent("onWeixinJSBridgeReady", jsApiCall);}}else{jsApiCall();}}
            </script>';
  
        $button = '<a class="box-flex btn-submit" type="button" onclick="callpay()">微信支付</a>' . $js;
        if($is_h5){

            $href=$this->result["mweb_url"];
            $button = '<a class="box-flex btn-submit" type="button" href='.$href.'&redirect_url='.urlencode(return_url(basename(__FILE__, '.php')).'&a=Wxh5&order_id='.$order['order_id']).'>微信支付</a>';
                
                 // $button = '<a class="box-flex btn-submit" type="button" href='.$href.'&redirect_url='.urlencode(return_url(basename(__FILE__, '.php'))).'>微信支付</a>';

        }

        if($is_h5){
            $callback = urlencode(return_url(basename(__FILE__, '.php')).'&a=Wxh5&order_id='.$order['order_id']);
             file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_testttttttttt.txt", '$callback:'.$callback."\n", FILE_APPEND);
            $trade_type = 'MWEB';
            if($this->get_device_type =='ios'){
               $from= 'IOS';
            }elseif($this->get_device_type =='android'){
                $from= 'Android';
            }else{
                $from ='H5';
            }
        }else{
            $callback='';
            $trade_type = 'JSAPI';
        }
        //记录回调信息
        $data = array(
            'payment_callback' => $callback,
            'from' => $from,
            'trade_type' => $trade_type,
            'order_num' => $order['order_sn'] . $order_amount . 'O' . $order['log_id'],
        );
        dao('weixin_payment')->add($data);

        return $button;
    }
    /**
     * 同步通知
     * @param $data
     * @return mixed
     */
    public function callback($data)
    {
        if ($_GET['status'] == 1) {
            return true;
        } else {
            return false;
        }
    }

   public function curl_request($url,$post='',$cookie='', $returnCookie=0){
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
          curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
         curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
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
                        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_testttttttttt.txt", 'a:'.json_encode( $a)."\n", FILE_APPEND);
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
                        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_testttttttttt.txt", 'b:'.json_encode( $b)."\n", FILE_APPEND);
                    }
                }

                if(isset($sql_data) && !empty($sql_data) ){
                    $url = "https://test-www.artzhe.com/Activity/Queen/sales";
                    $cou_ids = dao('coupons_user')->field('cou_id')->where(array('user_id'=>$sql_data['user_id'],'is_use'=>1))->select();
                    if(  isset($cou_ids) && !empty($cou_ids)){
                        foreach($coun_ids as $k=>$v){
                           $goods_coupons[]= dao('coupons')->field('cou_goods')->where(array('cou_id'=>$v['cou_id']))->find();
                        }
                    }
                    $require_data=array(
                            'user_id'=>$sql_data['user_id'],
                            'goods_id'=>is_array($goods_coupons)?implode(",",$goods_coupons):'0',
                        );
                    $post_data=array('param'=>des_encode(json_encode($require_data)));
                    $c = $this->curl_request($url,$post_data);
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_testttttttttt.txt", 'c:'.json_encode( $c)."\n", FILE_APPEND);
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
        include_once(BASE_PATH . "Helpers/AZcrypt.php.php");
        $_POST['postStr'] = file_get_contents("php://input");       
           
        if (!empty($_POST['postStr'])) {
            $payment = get_payment($data['code']);
          
            $postdata = json_decode(json_encode(simplexml_load_string($_POST['postStr'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            /* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
            // 微信端签名
            $wxsign = $postdata['sign'];
            unset($postdata['sign']);

            foreach ($postdata as $k => $v) {
                $Parameters[$k] = $v;
            }
            // 签名步骤一：按字典序排序参数
            ksort($Parameters);

            $buff = "";
            foreach ($Parameters as $k => $v) {
                $buff .= $k . "=" . $v . "&";
            }
            $String = '';
            if (strlen($buff) > 0) {
                $String = substr($buff, 0, strlen($buff) - 1);
            }
            // 签名步骤二：在string后加入KEY
            $String = $String . "&key=" . $payment['wxpay_key'];
            // 签名步骤三：MD5加密
            $String = md5($String);
            // 签名步骤四：所有字符转为大写
            $sign = strtoupper($String);
            // 验证成功
            if ($wxsign == $sign) {
                // 交易成功
                if ($postdata['result_code'] == 'SUCCESS') {
                    // 获取log_id
                    $out_trade_no = explode('O', $postdata['out_trade_no']);
                    $order_sn = $out_trade_no[1]; // 订单号log_id

                    // 修改订单信息(openid，tranid)
                    dao('pay_log')
                        ->data(array('openid' => $postdata['openid'], 'transid' => $postdata['transaction_id']))
                        ->where(array('log_id' => $order_sn))
                        ->save();
    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log_testttttttttt.txt", 'order_sn:'.json_encode( $order_sn)."\n", FILE_APPEND);
                    order_paid($order_sn, 2);

                    //支付成功才发送消息
                    $payData = dao('pay_log')
                        ->where(array('log_id' => $order_sn))
                        ->find();

                    if ($payData && $payData['is_paid'] == 1) {
                        $this->send_pay_msg($payData['order_id'],$postdata['total_fee']*100);
                    }
                  
                    // 改变订单状态
                   
                  
                    
                  
                    
                    /*if(method_exists('WechatController', 'do_oauth')){
                        // 如果需要，微信通知 wanglu
                        $order_id = model('Base')->model->table('order_info')
                            ->field('order_id')
                            ->where('order_sn = "' . $out_trade_no[0] . '"')
                            ->getOne();
                        $order_url = __HOST__ . url('user/order_detail', array(
                            'order_id' => $order_id
                        ));
                        $order_url = urlencode(base64_encode($order_url));
                        send_wechat_message('pay_remind', '', $out_trade_no[0] . ' 订单已支付', $order_url, $out_trade_no[0]);
                    }*/

                 
                }
                $returndata['return_code'] = 'SUCCESS';
            } else {
                $returndata['return_code'] = 'FAIL';
                $returndata['return_msg'] = '签名失败';
            }
        } else {
            $returndata['return_code'] = 'FAIL';
            $returndata['return_msg'] = '无数据返回';
        }
        // 数组转化为xml
        $xml = "<xml>";
        foreach ($returndata as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";

        exit($xml);
    }

    function trimString($value)
    {
        $ret = null;
        if (null != $value) {
            $ret = $value;
            if (strlen($ret) == 0) {
                $ret = null;
            }
        }
        return $ret;
    }

    function get_device_type()
    {
     //全部变成小写字母
     $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
     $type = 'other';
     //分别进行判断
     if(strpos($agent, 'iphone') || strpos($agent, 'ipad'))
    {
        $type = 'ios';
     } 
      
     if(strpos($agent, 'android'))
    {
        $type = 'android';
     }
     return $type;
    }

    /**
     * 作用：产生随机字符串，不长于32位
     */
    public function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 作用：设置请求参数
     */
    function setParameter($parameter, $parameterValue)
    {
        $this->parameters[$this->trimString($parameter)] = $this->trimString($parameterValue);
    }

    /**
     * 作用：生成签名
     */
    public function getSign($Obj)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);

        $buff = "";
        foreach ($Parameters as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }
        $String;
        if (strlen($buff) > 0) {
            $String = substr($buff, 0, strlen($buff) - 1);
        }
        // echo '【string1】'.$String.'</br>';
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->payment['wxpay_key'];
        // echo "【string2】".$String."</br>";
        // 签名步骤三：MD5加密
        $String = md5($String);
        // echo "【string3】 ".$String."</br>";
        // 签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        // echo "【result】 ".$result_."</br>";
        return $result_;
    }

    /**
     * 作用：以post方式提交xml到对应的接口url
     */
    public function postXmlCurl($xml, $url, $second = 30)
    {
        // 初始化curl
        $ch = curl_init();
        // 设置超时
        curl_setopt($ch, CURLOP_TIMEOUT, $second);
        // 这里设置代理，如果有的话
        // curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        // curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        // 运行curl
        $data = curl_exec($ch);
        curl_close($ch);
        // 返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
            echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
            curl_close($ch);
            return false;
        }
    }

    /**
     * 同一下单
     * 获取prepay_id
     */
    function getPrepayId()
    {
        // 设置接口链接
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        try {
            // 检测必填参数
            if ($this->parameters["out_trade_no"] == null) {
                throw new Exception("缺少统一支付接口必填参数out_trade_no！" . "<br>");
            } elseif ($this->parameters["body"] == null) {
                throw new Exception("缺少统一支付接口必填参数body！" . "<br>");
            } elseif ($this->parameters["total_fee"] == null) {
                throw new Exception("缺少统一支付接口必填参数total_fee！" . "<br>");
            } elseif ($this->parameters["notify_url"] == null) {
                throw new Exception("缺少统一支付接口必填参数notify_url！" . "<br>");
            } elseif ($this->parameters["trade_type"] == null) {
                throw new Exception("缺少统一支付接口必填参数trade_type！" . "<br>");
            } elseif ($this->parameters["trade_type"] == "JSAPI" && $this->parameters["openid"] == NULL) {
                throw new Exception("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！" . "<br>");
            }
            $this->parameters["appid"] = $this->payment['wxpay_appid']; // 公众账号ID
            $this->parameters["mch_id"] = $this->payment['wxpay_mchid']; // 商户号
            $this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR']; // 终端ip
            $this->parameters["nonce_str"] = $this->createNoncestr(); // 随机字符串
            $this->parameters["sign"] = $this->getSign($this->parameters); // 签名
            $xml = "<xml>";
        
            foreach ($this->parameters as $key => $val) {
                if (is_numeric($val)) {
                    $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
                } else {
                    $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
                }
            }
            $xml .= "</xml>";
        } catch (Exception $e) {
            die($e->getMessage());
        }
  
        // $response = $this->postXmlCurl($xml, $url, 30);
      
        $response = Http::doPost($url, $xml, 30);
      
        $result = json_decode(json_encode(simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $this->result =$result;
        $prepay_id = $result["prepay_id"];
        return $prepay_id;
    }

    /**
     * 作用：设置jsapi的参数
     */
    public function getParameters($prepay_id)
    {
        $jsApiObj["appId"] = $this->payment['wxpay_appid'];
        $timeStamp = time();
        $jsApiObj["timeStamp"] = "$timeStamp";
        $jsApiObj["nonceStr"] = $this->createNoncestr();
        $jsApiObj["package"] = "prepay_id=$prepay_id";
        $jsApiObj["signType"] = "MD5";
        $jsApiObj["paySign"] = $this->getSign($jsApiObj);
        $this->parameters = json_encode($jsApiObj);

        return $this->parameters;
    }

    /**
     * 订单查询
     * @return mixed
     */
    public function query($order, $payment)
    {

    }

    /**
     * 获取openid
     */
    public function getOpenid($payment)
    {
        $this->payment = $payment;
	
		if(isset($_GET['state']) && $_GET['state']=="getOpenid"){
            
			 $code = $_GET['code'];
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->payment['wxpay_appid'] . '&secret=' . $this->payment['wxpay_appsecret'] . '&code=' . $code . '&grant_type=authorization_code';
			
			$wxJsonUrl="https://api.weixin.qq.com/sns/oauth2/access_token?";
			$wxJsonUrl.='appid='.$payment['wxpay_appid'];
			$wxJsonUrl.='&secret='.$payment['wxpay_appsecret'];
			$wxJsonUrl.='&code='.$code;
			$wxJsonUrl.='&grant_type=authorization_code';

			if (extension_loaded('curl') && function_exists('curl_init') && function_exists('curl_exec')){
				$result=$this->curl_https($wxJsonUrl);
			}elseif(extension_loaded  ('openssl')){
				$result = file_get_contents ( $wxJsonUrl );
			}else{
				//return false;
				//$this->logResult("error::getOpenId::curl或openssl未开启");
			}
			
	           // $result = \Http::doGet($url);
            if ($result) {
                $json = json_decode($result,true);
	
                if (isset($json['errCode']) && $json['errCode']) {
                    return false;
                }
                $_SESSION['openid_base'] = $json['openid'];
                return $json['openid'];
            }
			unset($_GET['code']);
            return false;
			
        } else {
			$redirectUrl = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . $_SERVER['QUERY_STRING']);
			$redirectUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $payment['wxpay_appid'] . '&redirect_uri=' . $redirectUrl . '&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
			
            $wxUrl='https://open.weixin.qq.com/connect/oauth2/authorize?';
            $wxUrl.='appid='.$payment['wxpay_appid'];
            $wxUrl.='&redirect_uri='.urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $wxUrl.='&response_type=code&scope=snsapi_base';
            $wxUrl.='&state=getOpenid';
            $wxUrl.='#wechat_redirect';

            ob_end_clean();
			exit;
            header("Location: $wxUrl");
            exit;
		
           
        }
    }

    function logResult($word = '',$var=array()) {
        if( true || !WXPAY_DEBUG){
            return true;
        }
        $output= strftime("%Y%m%d %H:%M:%S", time()) . "\n" ;
        $output .= $word."\n" ;
        if(!empty($var)){
            $output .= print_r($var, true)."\n";
        }
        $output.="\n";
        file_put_contents(ROOT_PATH . "/data/log.txt", $output, FILE_APPEND | LOCK_EX);
    }
	
	
    function curl_https($url, $header=array(), $timeout=30){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $response = curl_exec($ch);
        if(!$response){
            $error=curl_error($ch);
            $this->logResult("error::curl_https::error_code".$error);
        }
        curl_close($ch);

        return $response;

    }
	
}

