<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'alioss' => [
        'appId'=>'LTAI3WsDOCMNSZqW',
        'appKey'=>'iVLYZqUQIvy1DeVA8dbOz8Ge7ZKPvu',
        'bucket'=>'artzhe',
        'host'=>'oss-cn-shenzhen.aliyuncs.com',
    ],
   /*'aliyun' => [
       'appid'     => 'LTAIu88F0vudN7cp',
       'secret'    => 'glScYTO8P38hmj1US1dcJvTv50HABg',
       'topic'     => 'easy_msg',
       'pid'       => 'PID_easy_msg',
       'cid'       => 'CID_easy_msg',
   ],*/
    'aliyun' => [
        'accessKeyId'     => 'LTAI3WsDOCMNSZqW',
        'accessKeySecret' => 'iVLYZqUQIvy1DeVA8dbOz8Ge7ZKPvu',
        'endPoint' => '1081190602991052.mns.cn-shenzhen.aliyuncs.com/',
        'smssign'=> '艺术者',
        'topic' => 'sms.topic-cn-shenzhen',
    ],

   'cl' => [
        'account' => 'szsgsy',
        'password' => 'Gsy2J0av1a8',
    ],

    'clyy' => [
        'account' => 'szsgsyyx',
        'password' => 'Tcl123456',
    ],

];
