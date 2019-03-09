<?php

/**
 * 通用的请求方法
 * @param $paramStr string 加密后的字符串
 * @param $url string 请求的url地址
 * @return $data array 返回的数组
 */
function requireArtzhe($paramStr, $url){

    $curl = curl_init();  //初始化
    curl_setopt($curl,CURLOPT_URL,$url);  //设置url
    curl_setopt($curl,CURLOPT_HTTPAUTH,CURLAUTH_BASIC);  //设置http验证方法
    curl_setopt($curl,CURLOPT_HEADER,0);  //设置头信息
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  //设置curl_exec获取的信息的返回方式
    curl_setopt($curl,CURLOPT_POST,1);  //设置发送方式为post请求
    curl_setopt($curl,CURLOPT_POSTFIELDS,array('param'=>$paramStr));  //设置post的数据

    $result = curl_exec($curl);
    if($result === false){
        echo curl_errno($curl);
        exit();
    }
    curl_close($curl);
    $data = json_decode($result,true);
    return $data;
}

//获取两个时间搓之间的所有星期数组成的数组
 function getWeekNum($dt_start,$dt_end){
            $date_list =[];
            while ($dt_start<=$dt_end){

                array_push($date_list ,date('w',$dt_start));
                $dt_start = strtotime('+1 day',$dt_start);
            }
           	return $date_list;
    }
 /**
  * 获取当前日期的本周到上周的所有日期，返回数组
  */

function getWeekDate(){
	$date=date('Y-m-d');  //当前日期
	$first=0; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期

	$w=date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6 
	$now_start=date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
	$date_arr=[];
	for($i=-7;$i<7;$i++){
		$day=date('Y-m-d',strtotime("$now_start +$i days"));
		array_push($date_arr,$day);
	}
	return $date_arr;	
}



/**
 * [dateBCurrent description] //日期是否大于当前日期 大于放返回true 
 * @param  [type] $date [description]请求的日期
 * @return [type]       [description]
 */
function dateBCurrent($request_time){
    //日期是否大于当前日期
     $currentDate=date("Y-m-d");
     $date=date("Y-m-d",$request_time);
     //获取当前日期
     $cYear=date("Y",strtotime($currentDate));
     $cMonth=date("m",strtotime($currentDate));
     $cDay=date("d",strtotime($currentDate));
     $year=date("Y",strtotime($date));
     $month=date("m",strtotime($date));
     $day=date("d",strtotime($date));
     $currentUnix=mktime(0,0,0,$cMonth,$cDay,$cYear);
     //当前日期的 Unix 时间戳
     $dateUnix=mktime(0,0,0,$month,$day,$year);
     //待比较日期的 Unix 时间戳
         if($dateUnix > $currentUnix){
            return true;
         }else{
            return false;
         }
}

//获取当前时间的星期一
 function mondayTime($timestamp=0,$is_return_timestamp=ture){
      static $cache ;
      $id = $timestamp.$is_return_timestamp;
      if(!isset($cache[$id])){
       if(!$timestamp) $timestamp = time();
       $monday_date = date('Y-m-d',$timestamp-86400*date('w',$timestamp)+(date('w',$timestamp)>0?86400:-/*6*86400*/518400));
       if($is_return_timestamp){
        $cache[$id] = strtotime($monday_date);
       }else{
        $cache[$id] = $monday_date;
       }
      }
      return $cache[$id];
    }

//冒泡排序法  取最大值 
function  bubble_sort($arr){
	//收集键值做比较;
	foreach($arr as $k =>$v){
		$n_arr[]=$v;
	}
	$len=count($n_arr);
	for($k=1;$k<$len;$k++){
			for($j=$len-1,$i=0;$i<$len-$k;$i++,$j--)
			if($n_arr[$j]>$n_arr[$j-1]){
				//如果是从大到小的话，只要在这里的判断改成if($b[$j]>$b[$j-1])就可以了
				 $tmp=$n_arr[$j];
				 $n_arr[$j]=$n_arr[$j-1];
				 $n_arr[$j-1]=$tmp;
		}
	}
    return $n_arr;
}

//获取当前日期为星期几
 function  get_week($date){
        //强制转换日期格式
        $date_str=date('Y-m-d',strtotime($date));
        //封装成数组
        $arr=explode("-", $date_str);
        //参数赋值
        //年
        $year=$arr[0];
        //月，输出2位整型，不够2位右对齐
        $month=sprintf('%02d',$arr[1]);
        //日，输出2位整型，不够2位右对齐
        $day=sprintf('%02d',$arr[2]);
        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;   
        //转换成时间戳
        $strap = mktime($hour,$minute,$second,$month,$day,$year);
        //获取数字型星期几
        $number_wk=date("w",$strap);
        //自定义星期数组
        $weekArr=array("0","1","2","3","4","5","6");         
        //获取数字对应的星期
        return $weekArr[$number_wk];
    }

//爱记账调用高搜易接口加密
  function ajz_onpwd($data)
  {
    $iv = 'aijizhanggaosouy';
    $key = 'aijizhanggaosouy';
    $encrypted = strtolower(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv)));
    return rtrim($encrypted);
  }

  //爱记账调用高搜易接口解密
  function ajz_unpwd($pwd)
  {
    $iv = 'aijizhanggaosouy';
    $key = 'aijizhanggaosouy';
    $pwd = hex2bin($pwd);
    $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $pwd, MCRYPT_MODE_CBC, $iv);
    return rtrim($data);
  }

//3DES加密函数 用途::加密会员ID、产品ID，再将密文通过网络传输
function des_encode($str)
{
	$DES = new AZcrypt();
	return $DES->encrypt($str);
}
//3DES解密函数
function des_decode($str)
{
	$DES = new AZcrypt();
	return $DES->decrypt($str);
}

//获取sina接口信息
function get_Sina_APP($type) {
	switch ($type) {
		case 'KEY': $parem = C('THINK_SDK_SINA.APP_KEY'); break;
		case 'SECRET': $parem = C('THINK_SDK_SINA.APP_SECRET'); break;
		case 'CALLBACK': $parem = C('THINK_SDK_SINA.CALLBACK'); break;
	}
	return $parem;
}

//获取qq接口信息
function get_QQ_APP($type) {
	switch ($type) {
		case 'KEY': $parem = C('THINK_SDK_QQ.APP_KEY'); break;
		case 'SECRET': $parem = C('THINK_SDK_QQ.APP_SECRET'); break;
		case 'CALLBACK': $parem = C('THINK_SDK_QQ.CALLBACK'); break;
	}
	return $parem;
}

// 微信互动评论时间格式
function weixin_comment_time( $second )
{
	$str = '';
	if( $second < 60 )
		$str = $second.'秒前';
	else if( $second < ( 60 * 60 ) )
		$str = ceil( $second/60).'分前';
	else if( $second < ( 60 * 60 * 24 ) )
		$str = ceil( $second/3600).'小时前';
	else
		$str = ceil( $second/(24*3600) ).'天前';
	return $str;
}
// 高手帮显示的时间格式
function gsb_time_to_string( $second )
{
	$str = '';
	$temp = time() - $second;
	if( $temp < 60 ){
		$str = $temp.'秒前';
	}else if( $temp < ( 60 * 60 ) ){
		$str = ceil( $temp/60).'分前';
	}else if( $temp < ( 60 * 60 * 24 ) ){
		$str = ceil( $temp/3600).'小时前';
	}else if( $temp < ( 60 * 60 * 24 * 7 ) ){
		$str = ceil( $temp/(24*3600) ).'天前';
	}else{
		$str = date('Y-m-d',$second);
	}
	return $str;
}

/* 获取最高收益率 */
function getMaxRate ($rate) {
	$rate = trim($rate);
	if(strstr($rate,'-')) {   //判断是否包含 -
		$rate = substr($rate, strrpos($rate,'-')+1);
	} else if(strstr($rate,'~')){
		$rate = substr($rate, strrpos($rate,'~')+1);
	}
	return $rate;
}

// 过滤html实体标签等特殊字符
function get_specialchars_str($str){
	$str = htmlspecialchars_decode($str);
	$order   = array("\r\n", "\n", "\r");
	$replace = array(" ", " ", " ");
	$str = str_replace($order, $replace, $str);
	return preg_replace('/&.*?;/ism', '', $str );
}

// floor is new 3 version

/* 获取邮箱激活地址 */
function getRegverify($email,$code){
	if($email != '' && $code != '') {
		$url = 'http://www.gaosouyi.com/Home/Passport/activate/param/'.des_encode($email).'/regverify/'.md5($code);
	}
	return $url;
}

/* 判断账户类型 */
function checkAccountType($account){
	$type = '';
	if ( strstr($account,'@') && strstr($account,'.com') ){
		$type = 'mail';
	}else if ( is_numeric($account) && strlen($account) ==11 ) {
		$type = 'mobile';
	}else{
		$type = 'account';
	}
	return $type;
}
//获取行政区域位置
function get_district_item($code) {
	$District = M("District");
	$data = $District->select();
	$info = array();
	$res = false;
	foreach ($data as $key => $value) {
		$info[$value['id']] = $value;
	}
	$tmp = $code;
	while ( is_array($info[$tmp])) {
		$res[] = $info[$tmp];
		$parent_id = $info[$tmp]['parent_id'];
		$tmp = $parent_id;
	}
	$ret = array_reverse($res);
	$result = array();
	$result['region'] = $ret[0]['name'];
	$result['region_id'] = $ret[0]['id'];
	$result['city'] = $ret[1]['name'];
	$result['city_id'] = $ret[1]['id'];


	return $result;
}

/**
   * 生成上传目录
   * @param: $uid  用户id
   * @return: 目录地址
*/
function getUserUrl($uid){
    $result = '/Userup/';
    $groupid = intval($uid/1000);
    $groupid += 1;
    $result .= $groupid.'/';
    if(!is_dir('./Uploads'.$result)){
        mkdir('./Uploads'.$result,0777);
    }
    $result .= $uid.'/';
    if(!is_dir('./Uploads'.$result)){
        mkdir('./Uploads'.$result,0777);
    }
    return $result;
}

/**
	* 生成邮箱激活地址
	* @param  $email
	* @return  返回邮箱地址
*/
function getRegEmailUrl($email){
	$email = trim($email);
    if (strstr($email,'@')) {   //判断是否包含 @
    	$email = substr($email, strrpos($email,'@')+1);
        if (in_array($email, array("qq.com", "sina.com" , "gmail.com" , "126.com" , "163.com" , "souhu.com" , "21cn.com" ,"yeah.com" )))
        	return 'http://mail.'.$email;
        return '';
    }
    return '';
}

 /**
 	 *收益率字符串截取
 	 * @param  $rate
 	 * @return  返回截取后的收益率
 */
function getCutRate($rate,$type){
	$rate = trim($rate);
	if ($type == '1') {
		if (strstr($rate,'.'))   //判断是否包含 .
			return $rate = substr($rate,0,strrpos($rate,'.'));
		else
			return str_replace('%', '', $rate);
	} else if($type == 2) {
		if (strstr($rate,'.'))   //判断是否包含 .
			return substr($rate, strrpos($rate,'.'));
		else
			return '%';

	}
}

 /**
 	 *积分分值判断
 	 * @param  param
 	 * @return  1、增加 2、减少
 */
function ScoreValue($param){
	$value = '';
	switch ($param) {
		case 1: $value = '增加'; break;
		case 2: $value = '减少'; break;
	}
	return $value;
}

function getNearFinancials($param, $p=1,$size=10) {
	vendor("mongo.HMongodb");
	$mongo = new HMongodb( C('MONGO_HOST').':'.C('MONGO_PORT'));
	$mongo->selectDb('gaosouyi');
	$args = array(
				'geoNear'	=> 'financial_gps',
				'near'		=> $param['gps'],
				'spherical' => true,
				'maxDistance'			=> 2, //最大范围
				'distanceMultiplier'	=> 6378000,
				'num'		=> 100,
			);
	$nears = $mongo->command( $args );
	$count = count($nears['results']);
	$start = ($p-1) * $size;
	$end   = $p * $size;
	if( $end > $count )
		$end = $count;
	$ret   = array();
	for($i=$start; $i< $end; $i++) {
		$ret[$i] = array(
					'dis' => $nears['results'][$i]['dis'],
					'uid' => (int)$nears['results'][$i]['obj']['mid'], //APP接口定义的是uid,故转换
					'time'=> (int)$nears['results'][$i]['obj']['time'],
					'longitude' => $nears['results'][$i]['obj']['gps'][0],
					'latitude'	=> $nears['results'][$i]['obj']['gps'][1],
					);
	}
	return $ret;
}




// 更新最新的理财师GPS信息
function replaceInsert($param){
	vendor("mongo.HMongodb");
	$mongo = new HMongodb( C('MONGO_HOST').':'.C('MONGO_PORT'));
	$mongo->selectDb('gaosouyi');

	$condition = array('mid'=>$param['mid']);
	$info  = $mongo->findOne('financial_gps', $condition );
	if( $info && $info['mid'] ) {
		$ret = $mongo->update('financial_gps', $condition, $param );
	} else {
		$ret = $mongo->insert('financial_gps', $param);
	}
	return $ret;
}

function getGpsInfoByMid($mid)
{
	vendor("mongo.HMongodb");
	$mongo = new HMongodb( C('MONGO_HOST').':'.C('MONGO_PORT'));
	$mongo->selectDb('gaosouyi');
	$condition = array('mid'=>$mid);
	return $mongo->findOne('financial_gps', $condition );
}


define('EARTH_RADIUS', 6378.137);    // 地球半径
// 根据两组经纬度，计算两点间距离
function getDistance($lat1, $lng1, $lat2, $lng2) {
  $radLat1 = deg2rad($lat1);
  $radLat2 = deg2rad($lat2);
  $a = $radLat1 - $radLat2;
  $r = deg2rad($lng1) - deg2rad($lng2);
  $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($r / 2), 2)));
  $s = $s * EARTH_RADIUS;
  //$s = round($s * 10000) / 10000;
  return substr( $s * 1000, 0,3); //单位: m
}

function unit_converter( $value,$uint="万"){
	if($uint=="万"){
		$result = $value/10000;
		if($result >= 10000){
			$result = $result/10000;
			$uint = "亿";
		}
	}elseif ($uint=="月") {
		if($value>30){
			$result = $value/30;
			$uint = "月";
		}
	}elseif ($uint=="个月") {
		if($value>=30){
			$result = $value/30;
			$uint = "";
		}
	}

	return $result.$uint;
}

// @desc: 获取随机数字
// @param: $n:指要返回的随机数长度
function get_rand_number($n=6) {
	$string = '12356789';
	$r = '';
	$max = strlen($string)-1;
	for($i=0; $i<$n; $i++) {
		$r .= $string[mt_rand(0,$max)];
	}
	return $r;
}

// 下发短信： $phone:手机号， $param:变量值， $templateId:模板ID(调用的模板ID)
function sms_send_phone_message($phone, $param, $templateId) {
	import('Common.Util.Ucpaas');
	//dump( C('UCPAAS') );exit;
	$ucpass = new Ucpaas( C('UCPAAS') );
	$r = $ucpass->templateSMS( C('UCPAAS.appId'),$phone,$templateId,$param);
	return $r;
}

// 下发语音短信： $phone:手机号， $param:变量值， $templateId:模板ID(调用的模板ID)
function callsms_send_phone_message($phone, $param) {
	import('Common.Util.Ucpaas');

	$ucpass = new Ucpaas( C('UCPAAS') );
	$r = $ucpass->voiceCode( C('UCPAAS.appId'),$param,$phone);
	return $r;
}

// 高手帮显示的时间格式
function html5_time_to_string( $second )
{
	$str = '';
	$second = $second - time();
	if( $second <= 0 )
		$str = '<em>销售截止</em>';
	else if( $second < 60 )
		$str = '<em>'.$second.'</em>秒';
	else if( $second < ( 60 * 60 ) ) {
		$second = ceil( $second / 60 );
		$str = '<em>'.$second.'</em>分';
	}
	else if( $second < ( 60 * 60 * 24 ) ) {
		$second = ceil( $second / 60*60 );
		$str = '<em>'.$second.'</em>小时';
	}
	else {
		$second = ceil( $second / 60*60*24 );
		$str = '<em>'.$second.'</em>天';
	}
	return $str;
}

function timetoendhour($time1,$time2)
{
	$time = $time2 - $time1;
	if($time <= 0)
	{
		return '未开始';
	}
	else if($time < 60 && $time > 0)
	{
		return '1分钟内';
	}
	else if($time >= 60 && $time < 3600)
	{
		return intval($time/60).'分钟';
	}
	else if($time >= 3600 && $time < 86400)
	{
		return intval($time/3600).'小时'.intval(($time%3600)/60).'分钟';
	}
	else if($time >= 86400)
	{
		return intval($time/86400).'天'.intval(($time%86400)/3600).'小时'.intval(($time%3600)/60).'分钟';
	}
}

// 截取定长的字符串
// str:字符串; length:截取长度; ext:补充字符
function get_length_string($str, $length, $ext='...') {
	$len = mb_strlen($str,'utf-8');
	if( $len <= $length )
		return $str;
	else {
		$str = mb_substr($str, 0, $length, 'utf-8');
	}
	return $str.$ext;
}

/*
* @desc 转换时间
* @param   $s 时间戳
* @return 返回时间
*/
function get_time_string($s,$format='Y-m-d H:i') {
	$str = '--';

	$time = intval(trim($s));
	if($time > 10000){
		$str = date($format, $time);
	}

	return $str;
}

/**
 * 以get的方式发送https请求，并返回请求的结果
 * @param string $url
 * @param array $param
 * @return mixed|boolean（这里为false）：只返回文件内容，不包括http header
 */
function curl_get($url, $header = array()) {
	if (!$header) {
		$header = array('Accept-Charset: utf-8');
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// 	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}

/**
 * 以post的方式发送http请求，并返回请求的结果
 * @param string $url
 * @param array $param
 * @return mixed|boolean（这里为false）：只返回文件内容，不包括http header
 */
function curl_post($url, $param = array(), $header = array()) {
	if (!$header) {
		$header = array('Accept-Charset: utf-8');
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	//设置该选项，表示函数curl_exec执行成功时会返回执行的结果，失败时返回 FALSE
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_POST, 1);	//POST请求
	curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	curl_setopt($ch, CURLOPT_VERBOSE, 1 );	//启用时会汇报所有的信息
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}

//金额截取字符串
function getCutMoney($rate,$type){
	$rate = trim($rate);
	if ($type == '1') {
		if (strstr($rate,'.'))   //判断是否包含 .
			return $rate = substr($rate,0,strrpos($rate,'.'));
		else
			return str_replace('%', '', $rate);
	} else if($type == 2) {
		if (strstr($rate,'.')){   //判断是否包含 .
			$cut = substr($rate, strrpos($rate,'.'));
			if ($cut == '0000'){
				return '.00';
			}else{
				return substr($cut,0,3);
			}
		}
	}
}

function Sec2Time($time){
  if(is_numeric($time)){
    $value = array(
      "years" => 0, "days" => 0, "hours" => 0,
      "minutes" => 0, "seconds" => 0,
    );
    if($time >= 31556926){
      $value["years"] = floor($time/31556926);
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $value["days"] = floor($time/86400);
      $time = ($time%86400);
    }
    if($time >= 3600){
      $value["hours"] = floor($time/3600);
      $time = ($time%3600);
    }
    if($time >= 60){
      $value["minutes"] = floor($time/60);
      $time = ($time%60);
    }
    $value["seconds"] = floor($time);
    return (array) $value;
  }else{
    return (bool) FALSE;
  }
}

