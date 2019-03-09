<?php
return array(
	/* 默认设定 */
	//Los2：逗号（,）两边，不能有空格
	'DEFAULT_FILTER'        => 'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...

	/* URL设置 */
	// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
	'URL_MODEL'             =>  2,

	/* Cookie设置 */
	'COOKIE_EXPIRE'         =>  86400,       // Cookie有效期

	/* 网站基础信息设置  */
	'SITE_USER_KEY'			=> '@io1^oO0#O~(sv)s%n*xxx',	//用户信息加密密钥
	'SITE_SYNC_KEY'			=> 'IO0&#!HOO0~0p!le^r',		//系统通信密钥

    'MODULE_ALLOW_LIST'     =>   ['Api_v1'],

    'DEFAULT_MODULE'        =>   'Api',

    /* 数据库设置 */
    'DB_TYPE'               =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'mall_test',          // 数据库名
    'DB_USER'               =>  'artzhe_test',      // 用户名
    'DB_PWD'                =>  'gfd543*^y87i342gfd',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'dsc_',    // 数据库表前缀
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志

    '3DESOn'                =>  TRUE,  // 接口是口开启加密
    'CHECK_IP'              =>  FALSE,  // 接口是口开启加密
    'ARTZHR_IP_ARRAY'       =>  array('120.79.0.132'), // 正式环境需要更改ip地址
);