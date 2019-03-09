<?php
return array(
	//'配置项'=>'配置值'
    //URL MODEL
    'URL_MODEL'=>2,

    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'artzhe_test', // 数据库名
    'DB_USER'   => 'artzhe_test', // 用户名
    'DB_PWD'    => 'gfd543*^y87i342gfd', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PARAMS' =>  array(), // 数据库连接参数
    'DB_PREFIX' => 'az_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8mb4', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    //缓存使用
    'DATA_CACHE_TYPE' => 'Redis',
   // 'DATA_CACHE_TYPE' => 'file',

    'REDIS_HOST' => '127.0.0.1',
    'REDIS_PORT' => '6380',
    'REDIS_PASSWD' => '4f&el4fGUre563gke&Jfg$g',
    'REDIS_DB_INDEX' => '1',

    'm_site' => 'https://test-m.artzhe.com',
    'www_site' => 'https://test-www.artzhe.com',
    'api_site' => 'https://test-api.artzhe.com',

    // 允许访问的模块列表
    'MODULE_ALLOW_LIST'    =>    array('Api','Artzhe','Activity'),
    'DEFAULT_MODULE'       =>    'Artzhe',  // 默认模块

    'OSS'=>[
        'appKeyId' => 'LTAI3WsDOCMNSZqW',
        'appKeySecret' => 'iVLYZqUQIvy1DeVA8dbOz8Ge7ZKPvu',
        'endPoint' => 'oss-cn-shenzhen.aliyuncs.com',
        'bucket' => 'artzhe'
    ],
);