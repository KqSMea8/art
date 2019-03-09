<?php
return [
    //URL MODEL
    'DEFAULT_MODULE'=>'App10',
    'URL_MODEL'=>2,
    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'artzhe', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'qqqqqq', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PARAMS' =>  array(), // 数据库连接参数
    'DB_PREFIX' => 'az_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8mb4', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    //缓存使用
    'DATA_CACHE_TYPE' => 'Redis',
   // 'DATA_CACHE_TYPE' => 'file',

    'REDIS_HOST' => '127.0.0.1',
    'REDIS_PORT' => '6379',
    'REDIS_PASSWD' => '',
    'REDIS_DB_INDEX' => '1',

    'm_site' => 'https://127-m.artzhe.com',
    'www_site' => 'https://127-www.artzhe.com',
    'api_site' => 'https://127-api.artzhe.com',

    'ADMIN_NAME'=>'艺术者平台',
    'ADMIN_FACE'=>'https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png',

    //自动加载的命名空间
    'AUTOLOAD_NAMESPACE' => [
      'Custom' => ROOT_PATH.'Custom'
    ],
    'WECHAT_CONFIG'=>[
        'appid'=>'wx22245629713c99d3',
        'appsecret'=>'d74a2942e532d9746f6eac778eb58e16'
    ],
    'HOST_URL'=>'https://www.artzhe.com',
    'HOST_URL_TEST'=>'https://artzhe.shukaiming.com',
    'SHARE_IMG_DEFAULT'=>'https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/shareImg.png',
    'OSS'=>[
      'appKeyId' => 'LTAI3WsDOCMNSZqW',
      'appKeySecret' => 'iVLYZqUQIvy1DeVA8dbOz8Ge7ZKPvu',
      'endPoint' => 'oss-cn-shenzhen.aliyuncs.com',
      'bucket' => 'artzhe'
     ],
    'OSS_STS'=>[
        'AccessKeyID' => 'LTAItBBgiTb0Fqkm',
        'AccessKeySecret' => 'WBZ2J0q64TH0LhrDGq0s9pQqUreo29',
        'RoleArn' => 'acs:ram::1081190602991052:role/app-upload-role',
        'BucketName' => 'artzhe',
        'Endpoint' => 'oss-cn-shenzhen.aliyuncs.com',
        'TokenExpireTime' => '3600',
        'is_test' => 1
    ],
    'WECHAT'=>[
        'debug'  => true,
        'app_id'  => 'wx5a7173d3f038334b',         // AppID
        'secret'  => 'a24c781d98573cf51a40c4abe1a26d3b',     // AppSecret
        'token'   => '',          // Token
        'aes_key' => '',                    // EncodingAESKey
        'log' => [
            'level' => 'debug',
            'file'  =>'./Apps/Runtime/Logs/wechat.log',
        ],
        'oauth' => [
            'scopes'   => 'snsapi_userinfo',
            'callback' => 'https://127-m.artzhe.com/h5/wechat/callback',
        ],
    ],
    'ARTWORK_UPDATE'=>[
        'EDIT_LOCK_ENABLE'=>0,//创作记录可编辑限制开关
        'EDIT_LOCK_TIME'=>86400,//创作记录可编辑时间限制
    ],
	
	 //商城接口地址
    'MALL' => 'https://127-mall.artzhe.com/azapi.php/',
    
    'AppUpgrade_android_channel'=>['yingyongbao','xiaomi','360'],
];
