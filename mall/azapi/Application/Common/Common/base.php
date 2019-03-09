<?php

if(!function_exists('get_time'))
{
    /**
     * 获取一个基于时间的Unix时间戳
     * @param string $type 时间类型，默认为day，可选minute,hour,day,week,month,quarter,year
     * @param int $offset 时间偏移量 默认为0，正数表示当前type之后，负数表示当前type之前
     * @param string $position 时间的开始或结束，默认为begin，可选前(begin,start,first,front)，end
     * @param int $year 基准年，默认为null，即以当前年为基准
     * @param int $month 基准月，默认为null，即以当前月为基准
     * @param int $day 基准天，默认为null，即以当前天为基准
     * @param int $hour 基准小时，默认为null，即以当前年小时基准
     * @param int $minute 基准分钟，默认为null，即以当前分钟为基准
     * @return int 处理后的Unix时间戳
     */
    function get_unixtime($type = 'day', $offset = 0, $position = 'begin', $year = null, $month = null, $day = null, $hour = null, $minute = null)
    {
        $year = is_null($year) ? date('Y') : $year;
        $month = is_null($month) ? date('m') : $month;
        $day = is_null($day) ? date('d') : $day;
        $hour = is_null($hour) ? date('H') : $hour;
        $minute = is_null($minute) ? date('i') : $minute;
        $position = in_array($position, array('begin', 'start', 'first', 'front'));

        switch ($type)
        {
            case 'minute':
                return $position
                        ? mktime($hour, $minute + $offset, 0, $month, $day, $year)
                        : mktime($hour, $minute + $offset, 59, $month, $day, $year);
                break;
            case 'hour':
                return $position
                        ? mktime($hour + $offset, 0 , 0, $month, $day, $year)
                        : mktime($hour + $offset, 59 , 59, $month, $day, $year);
                break;
            case 'day':
                return $position
                        ? mktime(0, 0, 0, $month, $day + $offset, $year)
                        : mktime(23, 59, 59, $month, $day + $offset, $year);
                break;
            case 'week':
                return $position
                        ? mktime(0, 0, 0, $month, $day - date("w", mktime(0, 0, 0, $month, $day, $year)) + 1 - 7 * (-$offset), $year)
                        : mktime(23, 59, 59, $month, $day - date("w", mktime(0, 0, 0, $month, $day, $year)) + 7 - 7 * (-$offset), $year);
                break;
            case 'month':
                return $position
                        ? mktime(0, 0, 0, $month + $offset, 1, $year)
                        : mktime(23, 59, 59, $month + $offset, get_month_days($month+$offset, $year), $year);
                break;
            case 'quarter':
                return $position
                        ? mktime(0, 0, 0, 1 + ((ceil(date('n', mktime(0, 0, 0, $month, $day, $year)) / 3) + $offset) - 1) * 3, 1, $year)
                        : mktime(23, 59, 59, (ceil(date('n', mktime(0, 0, 0, $month, $day, $year)) / 3) + $offset) * 3, get_month_days((ceil(date('n', mktime(0, 0 , 0, $month, $day, $year)) / 3) + $offset) * 3, $year), $year);
                break;
            case 'year':
                return $position
                        ? mktime(0, 0, 0, 1, 1, $year + $offset)
                        : mktime(23, 59, 59, 12, 31, $year + $offset);
                break;
            default:
                return mktime($hour, $minute, 0, $month, $day, $year);
                break;
        }
    }
}

if(!function_exists('get_month_days'))
{
    /**
     * 获取月的天数
     * @param int $month 月份，默认为null，即计算当前月的天数
     * @param int $year 年份，默认为null，即基于当前年
     * @return int
     */
    function get_month_days($month = null, $year = null)
    {
        //也可以使用return cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $year = is_null($year) ? date('Y') : $year;
        $month = is_null($month) ? date('m') : $month;
        return date("t", mktime(0, 0 , 0, $month, 1, $year));
    }
}

function  get_millisecond()
{
	list( $usec ,  $sec ) =  explode ( " " ,  microtime ());
	return   $sec*1000  + substr($usec,2,3 );
}

function doChangeItem( $arr, $s='//', $r='https:' ) {
	if( is_array($arr) ) {
		foreach($arr as $k => $v ) {
			if( is_array($v) ) {
				$arr[$k] = doChangeItem( $v );
			}
			if( substr($v,0,2) == $s ) {
				$v = $r.$v;
				$arr[$k] = $v;
			}
		}
		return $arr;
	}
	return $arr;
}

// APP端用户密码加密
function encode_member_password($str) {
	return md5( C('SITE_USER_KEY').$str);
}

// 加密
function change_password( $str ) {
	return authcode($str, 'ENCODE', C('SITE_USER_KEY') );
}

// 解密
function unchange_password( $str ) {
	return authcode($str, 'DECODE', C('SITE_USER_KEY') );
}

// 参数解释
// $string： 明文 或 密文
// $operation：DECODE表示解密,其它表示加密
// $key： 密匙
// $expiry：密文有效期
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	// 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
	$ckey_length = 4;
	// 密匙
	$key = md5($key ? $key : C('SITE_USER_KEY') );
	// 密匙a会参与加解密
	$keya = md5(substr($key, 0, 16));
	// 密匙b会用来做数据完整性验证
	$keyb = md5(substr($key, 16, 16));
	// 密匙c用于变化生成的密文
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	//PHP加密解密函数authcode参与运算的密匙
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	// 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
	// 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	//PHP加密解密函数authcode产生密匙簿
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	// 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	//PHP加密解密函数authcode核心加解密部分
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		// PHP加密解密函数authcode从密匙簿得出密匙进行异或，再转成字符
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		// substr($result, 0, 10) == 0 验证数据有效性
		// substr($result, 0, 10) - time() > 0 验证数据有效性
		// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
		// 验证数据有效性，请看未加密明文的格式
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		//PHP加密解密函数authcode把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
		// 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}


/*
 * 系统邮件发送函数
 * @param string $addressee_email    接收邮件者邮箱
 * @param string $addressee_user  接收邮件者名称
 * @param string $email_subject 邮件主题
 * @param string $email_body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
 function think_send_mail($addressee_email, $addressee_user, $email_subject = '', $email_body = '', $attachment = null){
    require_once 'PHPMailer/PHPMailerAutoload.php';
    $config = C('THINK_EMAIL');
    $email             = new PHPMailer(); //PHPMailer对象
    $email->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $email->IsSMTP();  // 设定使用SMTP服务
    $email->SMTPDebug  = 0;                     // 关闭SMTP调试功能
                                               // 1 = errors and messages
                                               // 2 = messages only
    $email->SMTPAuth   = true;                  // 启用 SMTP 验证功能
    $email->Host       = $config['SMTP_HOST'];  // SMTP 服务器
    $email->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
    $email->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
    $email->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
    $email->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
    $replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
    $replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
    $email->AddReplyTo($replyEmail, $replyName);
    $email->Subject    = $email_subject;
    $email->MsgHTML($email_body);
    $email->AddAddress($addressee_email, $addressee_user);
    $email->IsHTML(true);
    if(is_array($attachment)){ // 添加附件
        foreach ($attachment as $file){
            is_file($file) && $email->AddAttachment($file);
        }
    }
    return $email->Send() ? true : $email->ErrorInfo;
}


/*
 * 系统二维码生成函数
 * @param string $str    需要生成二维码的文字
 * @param string $filename  二维码图片最终的文件名
 * @param string $eclevel 二维码纠错级别：L、M、Q、H
 * @param string $pixelPerPoint    每点像素数
 * @param string $outerFrame 外边距宽度
 * @param string $q 最后导出图片品质等级
 */
function think_qrcode($str = '', $filename = false, $eclevel = "H", $pixelPerPoint = 3, $outerFrame = 2, $q = 85){
	vendor("Qrcode.Qrcode");

    $code = new Qrcode();
    $image = new \Think\Image();
    $type = pathinfo($filename, PATHINFO_EXTENSION);
    if($type=='jpeg' || $type=='jpg'){
    	$code->jpg($str, $filename, $eclevel, $pixelPerPoint, $outerFrame, $q);
    }else{
    	$code->png($str, $filename, $eclevel, $pixelPerPoint, $outerFrame, $q);
    }

    if(!is_file($filename)){
    	return false;
    }else{
    	$image->open($filename)->water('./Public/Images/qrcode.png',5,100)->save($filename);
    	return true;
    }



}


/**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 */
function friendlyDate($sTime,$type = 'normal',$alt = 'false') {
    if (!$sTime)
        return '';
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime    =   time();
    $dTime    =   $cTime - $sTime;

    $dYear    =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
    if ($dYear ==0) {
        $dDay = intval(date("z",$cTime)) - intval(date("z",$sTime));
    }elseif($dYear==1){
        if(date("L",$sTime)){
            $addDay = 366;
        }else{
            $addDay = 365;
        }
        $dDay = intval(date("z",$cTime)) - intval(date("z",$sTime)) + $addDay;
    }else{
        $dDay = intval($dTime/3600/24);
    }

    //normal：n秒前，n分钟前，n小时前，日期
    if($type=='normal'){
        if( $dTime < 60 ){
            if($dTime < 10){
                return '刚刚';    //by yangjs
            }else{
                return intval(floor($dTime / 10) * 10)."秒前";
            }
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        //今天的数据.年份相同.日期相同.
        }elseif( $dYear==0 && $dDay == 0  ){
            //return intval($dTime/3600)."小时前";
            return '今天'.date('H:i',$sTime);
        }elseif($dYear==0 && $dDay > 0){
            return date("m月d日 H:i",$sTime);
        }else{
            return date("Y-m-d H:i",$sTime);
        }
    }elseif($type=='mohu'){
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif( $dDay > 0 && $dDay<=7 ){
            return intval($dDay)."天前";
        }elseif( $dDay > 7 &&  $dDay <= 30 ){
            return intval($dDay/7) . '周前';
        }elseif( $dDay > 30 ){
            return intval($dDay/30) . '个月前';
        }
    //full: Y-m-d , H:i:s
    }elseif($type=='full'){
        return date("Y-m-d , H:i:s",$sTime);
    }elseif($type=='ymd'){
        return date("Y-m-d",$sTime);
    }else{
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif($dYear==0){
            return date("Y-m-d H:i:s",$sTime);
        }else{
            return date("Y-m-d H:i:s",$sTime);
        }
    }
}


/**
 *  将时间转换为距离现在的精确时间
 * @param     int   $seconds  秒数
 * @param     int   $type  类型1为精确值，类型2为模糊值
 * @return    string
 */
function FloorTime($seconds,$type=1) {
    $times = '';
    $days = floor(($seconds/86400)%30);
    $hours = floor(($seconds/3600)%24);
    $minutes = floor(($seconds/60)%60);
    $second = floor($seconds%60);
    if($type==1){
    	if($seconds >= 1) $times .= $second.'秒';
	    if($minutes >= 1) $times = $minutes.'分钟 '.$times;
	    if($hours >= 1) $times = $hours.'小时 '.$times;
	    if($days >= 1)  $times = $days.'天';
	    if($days > 30) return false;
    }elseif ($type==2) {
    	if($seconds > 30*86400){
    		$times = "1月";
    	}elseif ($seconds >=86400) {
    		$times = $days."天";
    	}elseif($seconds >=3600){
			$times = $hours."小时";
		}elseif ($seconds >=60) {
			$times = $minutes."分钟";
		}else{
			$times = $second.'秒';
		}

    }

    $times .= '前';
    return str_replace(" ", '', $times);
}

