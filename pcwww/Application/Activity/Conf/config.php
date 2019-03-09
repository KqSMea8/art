<?php
return [
    'WECHAT'=>[
        'AppID'=>'wxe6848131226a497b',
        'AppSecret'=>'8d0b1102205369a318a7ebb8cca38810',
        'callback'=>'https://test-passport.artzhe.com/passport/user/WechatLoginCallback',
        'callback_only_Authorize'=>'https://test-www.artzhe.com/Activity/WeChat/WechatLoginCallbackOnlyAuthorize',
        'Authorize_server'=>'https://passport.artzhe.com/passport/wechatauthorize/getcode?scope=snsapi_userinfo',//授权服务器
    ],
    'passport_mobilelogin'=>'http://test-passport.artzhe.com/passport/user/MobileLogin',
    'login_callback'=>'http://test-www.artzhe.com/Activity/User/loginCallback',
    'Mall_url'=>'http://test-mall.artzhe.com',
    'Mall_login_url'=>'http://test-mall.artzhe.com/mobile/index.php?m=user&c=login',
];
