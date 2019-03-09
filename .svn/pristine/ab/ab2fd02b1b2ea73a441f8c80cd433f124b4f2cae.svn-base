<?php
return [
    //URL MODEL
    'URL_MODEL'=>2,
    //数据库配置信息
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '10.171.43.234', // 服务器地址
    'DB_NAME'   => 'artzhe', // 数据库名
    'DB_USER'   => 'gsyer', // 用户名
    'DB_PWD'    => 'i1b9v3h0lrhc', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PARAMS' =>  array(), // 数据库连接参数
    'DB_PREFIX' => 'az_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    //缓存使用
    'DATA_CACHE_TYPE' => 'Redis',

    'REDIS_HOST' => '10.171.43.234',
    'REDIS_PORT' => '6379',
    'REDIS_PASSWD' => 'gsy2018',

    'm_site' => 'https://test-m.artzhe.com',

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
    'OSS'=>[

    ],
    'OSS_TEST'=>[
        'bucket'=>'artzhe',
        'endPoint'=>'oss-cn-shenzhen.aliyuncs.com',
        'appKeyId'=>'LTAInAXrJLv2fTgV',
        'appKeySecret'=>'Yud4u8mGXcY6sOHVJCYBit0jxX4K1T',
        'callback'=>json_encode([
            'callbackUrl'=>'artzhe.shukaiming.com/Api/Oss/uploadCallback',
            'callbackHost'=>'oss-cn-shenzhen.aliyuncs.com',
            'callbackBody'=>'bucket=${bucket}&object=${object}&etag=${etag}&size=${size}&mimeType=${mimeType}&imageInfo.height=${imageInfo.height}&imageInfo.width=${imageInfo.width}&imageInfo.format=${imageInfo.format}',
            'callbackBodyType'=>'application/x-www-form-urlencoded'
        ])
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
            'callback' => 'https://test-artzhe.gaosouyi.com/h5/wechat/callback',
        ],
    ],
];
