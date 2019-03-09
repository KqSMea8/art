<?php
/**
 * 验证参数函数集
 */


/**
 * 验证App ID
 * @param number $appId
 */
function check_app_id($appId = 0) {
	$ret = 200;
	//验证密码是否为空
	if (!$appId) {
		$ret = 4001001;
		return $ret;
	}
	//验证密码是否合法
	if (!is_app_id($appId)) {
		$ret = 4001002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证版本号
 * @param string $verNum
 */
function check_ver_num($verNum = '') {
	$ret = 200;
	//验证密码是否为空
	if (!$verNum) {
		$ret = 4002001;
		return $ret;
	}
	//验证密码是否合法
	if (!is_ver_num($verNum)) {
		$ret = 4002002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证请求提交时间
 * @param number $submitTime
 */
function check_submit_time($submitTime = 0) {
	$ret = 200;
	//验证请求提交时间是否为空
	if (!$submitTime) {
		$ret = 4003001;
		return $ret;
	}
	//验证请求提交时间是否合法
	if (!is_submit_time($submitTime)) {
		$ret = 4003002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证用户ID
 * @param number $uid
 */
function check_uid($uid = 0) {
	$ret = 200;
	//验证用户ID是否为空
	if (!$uid) {
		$ret = 4004001;
		return $ret;
	}
	//验证用户ID是否合法
	if (!is_uid($uid)) {
		$ret = 4004002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证被关注者ID
 * @param number $uid
 */
function check_be_focus_uid($uid = 0) {
	$ret = 200;
	//验证被关注者ID是否为空
	if (!$uid) {
		$ret = 4005001;
		return $ret;
	}
	//验证被关注者ID是否合法
	if (!is_uid($uid)) {
		$ret = 4005002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证手机号码
 * @param string $mobile
 */
function check_mobile($mobile = '') {
	$ret = 200;
	//判断的手机号是否为空
	if (!$mobile) {
		$ret = 4101001;
		return $ret;
	}
	//判断手机号是否合法
	if (!is_mobile($mobile)) {
		$ret = 4101002;
		return $ret;
	}

// 	$user = D('User');
// 	if(!$user->existMobile($mobile)){
// 		$ret = 4101004;
// 		return $ret;
// 	}

	return $ret;
}


/**
 * 验证昵称
 * @param string $nickname
 */
function check_nickname($nickname = '', $mid= '') {
	$ret = 200;
	//验证昵称是否为空
// 	if (!$nickname) {
// 		$ret = 4105001;
// 		return $ret;
// 	}
	//验证昵称是否合法
	if (!is_nickname($nickname)) {
		$ret = 4105002;
		return $ret;
	}

	//$model = D('Member');
	//验证用户名是否存在
	//if ($model->checkInNickName($nickname, $mid)) {
	//	$ret = 4105003;
	//	return $ret;
	//}

	return $ret;
}

/**
 * 验证邮箱
 * @param string $email
 */
function check_email($email = '') {
	$ret = 200;
	//验证邮箱是否为空
	if (!$email) {
		$ret = 4104005;
		return $ret;
	}
	return $ret;
}

/**
 * 验证手机验证码
 * @param string $mobileVerifyCode
 */
function check_mobile_verify_code($mobileVerifyCode = '') {
	$ret = 200;
	//验证的手机验证码是否为空
	if (!$mobileVerifyCode) {
		$ret = 4103001;
		return $ret;
	}
	//验证手机验证码是否合法
	if (!is_mobile_verify_code($mobileVerifyCode)) {
		$ret = 4103002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证手机验证码
 * @param string $emailVerifyCode
 */
function check_email_verify_code($emailVerifyCode = '') {
	$ret = 200;
	//验证的邮箱验证码是否为空
	if (!$emailVerifyCode) {
		$ret = 4104001;
		return $ret;
	}
	//验证邮箱验证码是否合法
	if (!is_email_verify_code($emailVerifyCode)) {
		$ret = 4104002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证Sex
 * @param number $sex
 */
function check_sex($sex = 0) {
	$ret = 200;
	//验证Sex是否为空
	if (!$sex) {
		$ret = 4110001;
		return $ret;
	}
	//验证Sex是否合法
	if (!is_sex($sex)) {
		$ret = 4110001;
		return $ret;
	}

	return $ret;
}


/**
 * 验证上传头像图片
 * @param array $face
 */
function check_face($face = array()) {
	$ret = 200;
	//验证头像是否为空
	if (!$face) {
		$ret = 4113001;
		return $ret;
	}
	//验证头像是否合法
	if (!is_face($face)) {
		$ret = 4113002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证QQ
 * @param string $qq
 */
function check_qq($qq = '') {
	$ret = 200;
	//验证QQ是否为空
	if (!$qq) {
		$ret = 4109001;
		return $ret;
	}
	//验证QQ是否合法
	if (!is_qq($qq)) {
		$ret = 4109002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证登录密码
 * @param string $passwd
 */
function check_login_passwd($passwd = '') {
	$ret = 200;
	//验证密码是否为空
	if (!$passwd || strpos('a'.$passwd, ' ') ) {
		$ret = 4106001;
		return $ret;
	}
	//验证密码是否合法
	if (!is_login_passwd($passwd)) {
		$ret = 4106002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证登录密码
 * @param string $passwd
 */
function check_new_login_passwd($passwd = '') {
	$ret = 200;
	//验证密码是否为空
	if (!$passwd) {
		$ret = 4112001;
		return $ret;
	}
	//验证密码是否合法
	if (!is_login_passwd($passwd)) {
		$ret = 4112002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证提问内容
 * @param string $content
 */
function check_qstn_content($content = '') {
	$ret = 200;
	//验证提问内容是否为空
	if (!$content) {
		$ret = 4107001;
		return $ret;
	}
	//验证提问内容是否合法
	if (!is_qstn_content($content)) {
		$ret = 4107002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证回答内容
 * @param string $content
 */
function check_ans_content($content = '') {
	$ret = 200;
	//验证回答内容是否为空
	if (!$content) {
		$ret = 4117001;
		return $ret;
	}
	//验证回答内容是否合法
	if (!is_ans_content($content)) {
		$ret = 4117002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证栏目ID
 * @param number $chnlId
 */
function check_chnl_id($chnlId = 0) {
	$ret = 200;
	//验证栏目ID是否为空
	if (!$chnlId) {
		$ret = 4108001;
		return $ret;
	}
	//验证栏目ID是否合法
	if (!is_chnl_id($chnlId)) {
		$ret = 4108002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证问题ID
 * @param number $qstnId
 */
function check_qstn_id($qstnId = 0) {
	$ret = 200;
	//验证栏目ID是否为空
	if (!$qstnId) {
		$ret = 4111001;
		return $ret;
	}
	//验证栏目ID是否合法
	if (!is_qstn_id($qstnId)) {
		$ret = 4111002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证收藏ID
 * @param number $collectId
 */
function check_collect_id($collectId = 0) {
	$ret = 200;
	//验证收藏ID是否为空
	if (!$collectId) {
		$ret = 4114001;
		return $ret;
	}
	//验证收藏ID是否合法
	if (!is_collect_id($collectId)) {
		$ret = 4114002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证关键字ID
 * @param number $keywordId
 */
function check_keyword_id($keywordId = 0) {
	$ret = 200;
	//验证关键字ID是否为空
	if (!$keywordId) {
		$ret = 4116001;
		return $ret;
	}
	//验证关键字ID是否合法
	if (!is_keyword_id($keywordId)) {
		$ret = 4116002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证关键字
 * @param string $keyword
 */
function check_keyword($keyword = '') {
	$ret = 200;
	//验证关键字是否为空
	if (!$keyword) {
		$ret = 4115001;
		return $ret;
	}
	//验证关键字是否合法
	if (!is_keyword($keyword)) {
		$ret = 4115002;
		return $ret;
	}

	return $ret;
}



/**
 * 验证开始时间
 * @param number $beginTime
 */
function check_begin_time($beginTime = 0) {
	$ret = 200;
	//验证开始时间是否为空
	if (!$beginTime) {
		$ret = 4118001;
		return $ret;
	}
	//验证开始时间是否合法
	if (!is_begin_time($beginTime)) {
		$ret = 4118002;
		return $ret;
	}

	return $ret;
}


/**
 * 验证结束时间
 * @param number $endTime
 */
function check_end_time($endTime = 0) {
	$ret = 200;
	//验证结束时间是否为空
	if (!$endTime) {
		$ret = 4119001;
		return $ret;
	}
	//验证结束时间是否合法
	if (!is_end_time($endTime)) {
		$ret = 4119002;
		return $ret;
	}

	return $ret;
}

/**
 * 验证推荐码是否合法
 * @param number $rcmderCode
 * @return number
 */
function check_rcmderCode($rcmderCode = 0) {
	$ret =200;

	//判断是否为数字
	if(!is_numeric($rcmderCode)){
		$ret = 4120002;
		return $ret;
	}

	return $ret;
}


