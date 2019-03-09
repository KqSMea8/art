<?php

function jsonReturn($data ='', $code = 0, $message = 'success', $status = 'pass')
{
    exit(json_encode(['data'=>$data, 'code'=>$code, 'status'=>$status, 'message'=>$message]));
}

function cmp($a,$b){
	if( $a['money'] == $b['money'] ) return 0;
	return ( $a['money'] < $b['money'] ) ? 1 : -1;
}

function get_float_val($val) {
	$r_val = 0.00;
	if( $val )
		$r_val = floatval(sprintf('%01.3f',$val));
	return $r_val;
}

// 邮件发送接口
function rest_sendmail_rpc($to='', $subject='', $cc='', $headers='' ){
	if( empty($to) || empty($subject) || empty($cc)){
		return array('state'=>9,'info'=>'参数错误');
	}
	$url = "http://cs.ajzhan.com/test.php";
	$client = new \yar_client( $url );
	return $client->sendmail($to, $subject, $cc, $headers );
}


// 自定义加密算法
function md5s($data, $len = 16)
{
    $data = md5($data);
    $data = strtoupper($data);
    $data = strrev($data);
    return substr(md5($data), 0, $len);
}

/**
 * 截取定长的字符串
 * @param string $str: 字符串
 * @param int $len: 截取长度
 * @param string $ext: 补充字符
 * @return string
 */
function get_len_str($str, $len, $ext='...') {
	$result = '';
	$extLen = mb_strlen($ext);
	$strLen = mb_strlen($str);
	if( $strLen <= $len ) {
		$result = $str;
	} else {
		$result = mb_substr($str, 0, $len - $extLen);
		$result .= $ext;
	}
	return $result;
}

/**
 * 将模板中的变量标识符，替换为相应的内容
 * @param string $tpl
 * @param array $replace
 * @return string
 */
function replace_tpl($tpl = '', $replace = array()) {
	foreach ($replace as $k => $v) {
		$tpl = str_replace("#{$k}#", $v, $tpl);
	}
	return $tpl;
}


/**
 * 排序数组，按数组里的属性createTime（Unix时间戳）从大到小排列
 * @param array $a
 * @param array $b
 */
function cmpArrByCreateTime($a = array(), $b = array()) {
	if ($a['createTime'] == $b['createTime']) {
		return 0;
	}
	return $a['createTime'] > $b['createTime'] ? -1 : 1;
}

// 新版短信接口::

function rest_sms_rpc($to='',$template='',$param='',$ip='0'){
	if( empty($to) || empty($template) || empty($param)){
		return array('state'=>9,'info'=>'参数错误');
	}
	if(empty($ip)){
		$ip = get_ip();
		$ip = sprintf('%u',ip2long($ip));
	}
	$url = "http://sms.service.gaosouyi.com/sms.php";
	$client = new \yar_client( $url );
	return $client->send($to, $template, $param, $ip);
}

function get_number_from_ip() {
	return sprintf('%u',ip2long( get_ip() ));
}

function get_ip(){
	return $_SERVER['REMOTE_ADDR'];
}

/* 实时数据反馈给APP分发合作渠道方
 * phone: 手机号码;  op: 步骤序列;  last_act: 是否为最后一个动作
*/
function push_info_to_app_promoter( $phone, $op, $last_act=false ) {
	$array = array(
			'1001' => 'http://www.zb598.com:8060/callback_gaosouyi?',

	);
	// 判断当前手机号是否为  渠道推广而来的
	$AppPromoter = M('AppPromoter');
	$one = $AppPromoter->where('phone='.$phone)->find();
	if( $one && $one['ret_state']==1 ) {
		// 封装反馈值并push
		$url = $array[$one['promoter']];
		if( $one['promoter']==1001 ) {
			// imei={imei}&imsi={imsi}&op={op}&md5={$md5};
			$url_str = 'imei='.$one['imei'].'&imsi='.$one['imsi'].'&op='.$op.'&md5='.md5($one['imei'].$one['imsi'].$op.'gsy1001');
		}
		$url = $url.$url_str;
		curl_request_get($url);

		// 如果是最后一步，则更新  ret_state
		if( $last_act ) {
			$AppPromoter->where('phone='.$phone)->save(array('ret_state'=>2,'last_time'=>$_SERVER['REQUEST_TIME']));
		}
	}
}

// Curl提交
function curl_request_get($url,$data) {
    $url =  $url . (empty($data) ? '' : '?' . http_build_query($data, '', '&'));
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url); 
//    curl_setopt($ch, CURLOPT_HEADER, TRUE);
//	curl_setopt($ch, CURLOPT_NOBODY, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
//	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $result;
}

// @desc: 获取随机编码
// @param: $n:指要返回的编码长度
function get_rang_string($n=6) {
    $string = '12356789abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLNMOPQRSTUVWXYZ';
    $r = '';
    $max = strlen($string)-1;
    for($i=0; $i<$n; $i++) {
        $r .= $string[mt_rand(0,$max)];
    }
    return $r;
}

function changeChinese($value)
{
	$str = mb_strlen($value,'utf-8');
	if(2 >= $str)
	{
		return mb_substr($value,0,1,'utf-8').'***';
	}
	else
	{
		return mb_substr($value,0,1,'utf-8').'***'.mb_substr($value,-1,1,'utf-8');
	}
}

function handle($user,$action,$params){
	$model = $controller = $method = '';
	if(!empty($action)){
		list($model,$controller,$method) = explode('@',$action);
	}
	
	if(empty($model) || empty($controller) || empty($method)){
		return ['state'=>8001,'msg'=>'参数为空'];
	}
	
	if ($model==APP_NAME){
		$class = ucfirst(strtolower($controller)) . "Ctrl";
		if (class_exists($class)) {
			$model = new $class();
		}else{
			return ['state'=>8003,'msg'=>'控制器不存在','model'=>$model,'controller'=>$controller,'method'=>$method];
		}
		if(method_exists($class, $method)){
			$result = $model->$method($user,$params);
		}else{
			return ['state'=>8004,'msg'=>'方法不存在','model'=>$model,'controller'=>$controller,'method'=>$method];
		}
	}elseif (in_array($model, ['hd','home','lc','user'])) {
		$url = "/{$controller}/{$method}";
		$target = '';
		switch ($model) {
			case 'hd':
				$target = C('HD_DNS').$url;
				break;
			case 'home':
				$target = C('HOME_DNS').$url;
				break;
			case 'lc':
				$target = C('LC_DNS').$url;
				break;
			default:
				$target = C('USER3_DNS').$url;
				break;
		}
		if(!isset($params['mid'])){
			$params['mid'] = $user['mid'];
		}

		$params = ArrayToString($params);
		$params['token'] = encrypt_3des(json_encode($params));
		$str = http_build_query($params);

		if(strpos($target,'?')!==false){
			$target = $target.'&'.$str;
		}else{
			$target = $target.'?'.$str;
		}
		$res = curl_get($target);
		if(!empty($res)){
			$result = json_decode($res,true);
		}else{
			$result = [];
		}
	}else{
		$result = httpClient($model,$controller)->$method($user,$params);
	}

	return $result;
}

function ArrayToString($req=array()){
	array_walk($req, function (&$value, $key) {
		if(is_array($value)){
			$value = ArrayToString($value);
		}else{
			$value = strval($value);
		}
	});
	return $req;
}

/** 3des加密函数
 * @param $text string 需要加密的字符串
 * @return string  已经加密的字符串
 */
function encrypt_3des($text){
    $crypt3Des = new \Common\Util\Crypt3Des('p~s$1I@v^l!s0osi2t#s`5s1', '26882018');
    return  $crypt3Des->encrypt($text);
}

function trimall($str)//删除空格
{
    $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
    return str_replace($qian,$hou,$str);    
}

/*function get_type_string($typeid,$childtypeid = 0){
	switch($typeid){
		case '1':
			return '投资';
			break;
		case '2':
			return '回款本金';
			break;
		case '3':
			return '充值';
			break;
		case '4':
			return '提现';
			break;
		case '5':
			return '回款利息';
			break;
		case '7':
			if('11' == $childtypeid) return '一度人脉赏金';
			else if('12' == $childtypeid) return '二度人脉赏金';
			else if('13' == $childtypeid) return '人脉赏金';
			else if('20' == $childtypeid) return '活动收益--新手有礼红包';
			else if('31' == $childtypeid) return '活动收益--理财金赠送收益';
			else if('41' == $childtypeid) return '活动收益--春节红包';
			else if('51' == $childtypeid) return '活动收益--白色情人节红包';
			else if('52' == $childtypeid) return '活动收益--白色情人节邀请有礼';
			else if('61' == $childtypeid) return '活动收益--理财金赠送收益';
			else if('82' == $childtypeid) return '活动收益--迁移奖励';
			else if('101' == $childtypeid) return '活动收益--现金券';
			else if('111' == $childtypeid) return '代发工资';
			else return '活动收益';
			break;
		case '8':
			return '托管账户升级';
		default:
			return NULL;
	}
}

//各大银行提示语
function banklist_tips($flag='') {
	switch ($flag) {
		case 'ICBC': 	$str = '工商银行单笔限额5万，每日限额5万'; break;
		case 'CIB':  	$str = '兴业银行单笔限额5万，每日限额5万'; break;
		case 'CMBC': 	$str = '民生银行单笔限额5万，每日限额5万'; break;
		case 'CEB':  	$str = '光大银行单笔限额10万，每日限额20万'; break;
		case 'GDB':  	$str = '广发银行单笔限额10万，每日限额20万'; break;
		case 'CITIC':  	$str = '中信银行单笔限额10万，每日限额20万'; break;
		case 'PINGAN':  $str = '平安银行单笔限额10万，每日限额20万'; break;
		case 'SPDB':  	$str = '浦发银行单笔限额5万，每日限额5万'; break;
		case 'COMM':  	$str = '交通银行单笔限额5万，每日限额5万'; break;
		case 'ABC':  	$str = '农业银行单笔限额5万，每日限额5万'; break;
		case 'BOC':  	$str = '中国银行单笔限额10万，每日限额20万'; break;
		case 'CMB':  	$str = '招商银行单笔限额1千，每日限额1千'; break;
		case 'CCB':  	$str = '建设银行单笔限额5万，每日限额5万'; break;
		case 'HXB':  	$str = '由于第三方系统维护，该银行卡暂不支持快捷充值，请到电脑版官网选择网银充值！'; break;
		case 'PSBC':  	$str = '由于第三方系统维护，该银行卡暂不支持快捷充值，请到电脑版官网选择网银充值！'; break;
		// case 'HXB':  	$str = '华夏银行单笔限额5万，每日限额5万'; break;
		// case 'PSBC':  	$str = '邮政储蓄单笔限额5万，每日限额5万'; break;
		default:$str = ''; break;
	}
}

//快捷银行图标
function bankIcon($flag = '') {
	$icon = 'UNION';
	$bank_array = C('QUICK_BANK_LIST');
	if(in_array($flag, $bank_array)) {
		$icon = $flag;
	}
	return $icon;
}

function bankName($bank) {
	$banklist = array(
		'ICBC'=>'中国工商银行',
		'ABC'=>'中国农业银行',
		'BOC'=>'中国银行',
		'CCB'=>'中国建设银行',
		'CIB'=>'兴业银行',
		'GDB'=>'广发银行',
		'CMBC'=>'中国民生银行',
		'PSBC'=>'中国邮政储蓄银行',
		'CMB'=>'招商银行',
		'CEB'=>'中国光大银行',
		'SPDB'=>'浦发银行',
		'HXB'=>'华夏银行',
		'COMM'=>'交通银行',
		'BJB'=>'北京银行',
		'BEA'=>'东亚银行',
		'SRCB'=>'上海农商银行',
		'CITIC'=>'中信银行',
		'SDB'=>'深圳发展银行',
		'HSB'=>'徽商银行',
		'BHB'=>'河北银行',
		'TCCB'=>'天津银行',
		'NBB'=>'宁波银行',
		'PINGAN'=>'平安银行'
	);

	return $banklist[$bank];
}

//收益率显示
function tofixed($mun)
{
	$mun = sprintf("%.2f",$mun);
	if(mb_substr($mun, -1) == 0)
	{
		$mun=substr($mun,0,-1);
	}
	return $mun;
}*/
//
//
///**
// * 生成文章的URL
// * @param number $articleId
// */
//function gen_article_url($articleId = 0) {
//	//http://dev.gsb.gaosouyi.com/Author/view/id/105871/uid/IY5Q3fo4xZE.html
//	$articleUrl = 'http://' . $_SERVER['SERVER_NAME'] . U('/Author/view/id/' . $articleId);
//	return $articleUrl;
//}
//
//
///**
// * 生成问题的URL
// * @param number $qstnId
// */
//function gen_qstn_url($qstnId = 0) {
//	//http://dev.gsb.gaosouyi.com/Question/view/id/3512/uid/IY5Q3fo4xZE.html
//	$qstnUrl = 'http://' . $_SERVER['SERVER_NAME'] . U('/Question/view/id/' . $qstnId);
//	return $qstnUrl;
//}
//
//
///**
// * 生成产品的URL
// * @param number $prodId
// */
//function gen_prod_url($prodId = 0) {
//	//http://dev.gsb.gaosouyi.com/Xintuobao/view/id/107054/uid/IY5Q3fo4xZE.html
//	$prodUrl = 'http://' . $_SERVER['SERVER_NAME'] . U('/Xintuobao/view/id/' . $prodId);
//	return $prodUrl;
//}
//
//
///**
// * 生成机构的URL
// * @param number $orgId
// */
//function gen_org_url($orgId = 0) {
//	$orgUrl = 'http://' . $_SERVER['SERVER_NAME'] . U('/Org/showOrg/id/' . $orgId);
//	return $orgUrl;
//}
//
//
///**
// * 生成用户的URL
// * @param number $uid
// */
//function gen_user_url($uid = 0) {
//	//http://dev.gsb.gaosouyi.com/Question/userinfo/uid/IY5Q3fo4xZE/ruid/118001.html
//	$userUrl = 'http://' . $_SERVER['SERVER_NAME'] . U('/Question/userinfo/ruid/' . $uid);
//	return $userUrl;
//}
//
///**
// * 生成高手的主页URL
// * @param number $uid
// */
//function gen_author_url($uid = 0) {
//	//http://dev.gsb.gaosouyi.com/Question/userinfo/uid/IY5Q3fo4xZE/ruid/118001.html
//	$userUrl = 'http://' . $_SERVER['SERVER_NAME'] . U('/Author/info/mid/' . $uid);
//	return $userUrl;
//}