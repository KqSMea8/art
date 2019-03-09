<?php
/**
 * 验证格式。
 * 如：验证手机号码格式是否合法
 */

/**
 * 验证手机号码
 * @param string $mobile
 */
function is_mobile($mobile) {
	if (!is_numeric($mobile) || 11 != strlen($mobile)) {
		return false;
	}
	return true;
}


/**
 * 验证手机验证码
 * @param string $mobileVerifyCode
 */
function is_mobile_verify_code($mobileVerifyCode) {
	if (!is_numeric($mobileVerifyCode)
			|| C('MOBILE_VERIFY_CODE_LEN') != strlen($mobileVerifyCode)) {
		return false;
	}
	return true;
}


/**
 * 验证邮箱验证码
 * @param string $emailVerifyCode
 */
function is_email_verify_code($emailVerifyCode) {
	if (!is_numeric($emailVerifyCode)
			|| C('EMAIL_VERIFY_CODE_LEN') != strlen($emailVerifyCode)) {
		return false;
	}
	return true;
}


/**
 * 验证uid
 * @param number $uid
 */
function is_uid($uid) {
	if (!is_numeric($uid)) {
		return false;
	}
	return true;
}


/**
 * 验证昵称
 * @param string $nickname
 */
function is_nickname($nickname) {
	if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_-]{2,18}+$/u",$nickname)) {
		return false;
	}else{
		return true;
	}

}


/**
 * 验证QQ
 * @param string $qq
 */
function is_qq($qq) {
	if (!is_numeric($qq)) {
		return false;
	}
	return true;
}


/**
 * 验证sex
 * @param string $sex
 */
function is_sex($sex) {
	$sexList = array(0, 1, 2);
	if (!is_numeric($sex)) {
		return false;
	}
	if (!in_array($sex, $sexList)) {
		return false;
	}
	return true;
}


/**
 * 验证Face
 * @param array $face
 */
function is_face($face) {
	if (!is_array($face)) {
		return false;
	}
	return true;
}





/**
 * 验证密码
 * @param string $passwd
 */
function is_login_passwd($passwd) {
	if ( ! trim($passwd) ) {
		return false;
	}
	return true;
}


/**
 * 验证App ID
 * @param string $appId
 */
function is_app_id($appId) {
	$appIdList = array(4001, 4002, 4003, 4004, 4005, 4006);
	if (!is_numeric($appId) || !in_array($appId, $appIdList)) {
		return false;
	}
	return true;
}


/**
 * 验证版本号
 * @param string $verNum
 */
function is_ver_num($verNum) {
	if (!is_string($verNum)) {
		return false;
	}
	return true;
}


/**
 * 验证请求提交时间
 * @param int $submitTime
 */
function is_submit_time($submitTime) {
	if (!is_numeric($submitTime)) {
		return false;
	}
	return true;
}


/**
 * 验证提问内容
 * @param string $content
 */
function is_qstn_content($content) {
	if (!is_string($content)) {
		return false;
	}
	return true;
}


/**
 * 验证回答内容
 * @param string $content
 */
function is_ans_content($content) {
	if (!is_string($content)) {
		return false;
	}
	return true;
}


/**
 * 验证栏目ID
 * @param int $chnlId
 */
function is_chnl_id($chnlId) {
	if (!is_numeric($chnlId)) {
		return false;
	}
	return true;
}


/**
 * 验证问题ID
 * @param int $qstnId
 */
function is_qstn_id($qstnId) {
	if (!is_numeric($qstnId)) {
		return false;
	}
	return true;
}


/**
 * 验证收藏ID
 * @param int $collectId
 */
function is_collect_id($collectId) {
	if (!is_numeric($collectId)) {
		return false;
	}
	return true;
}


/**
 * 验证关键字ID
 * @param int $keywordId
 */
function is_keyword_id($keywordId) {
	if (!is_numeric($keywordId)) {
		return false;
	}
	return true;
}


/**
 * 验证关键字
 * @param string $keyword
 */
function is_keyword($keyword) {
	if (!is_string($keyword)) {
		return false;
	}
	return true;
}


/**
 * 验证开始时间
 * @param number $beginTime
 */
function is_begin_time($beginTime = 0) {
	if (!is_numeric($beginTime)) {
		return false;
	}
	return true;
}


/**
 * 验证结束时间
 * @param number $endTime
 */
function is_end_time($endTime = 0) {
	if (!is_numeric($endTime)) {
		return false;
	}
	return true;
}



