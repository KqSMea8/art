<?php

// 定义当前的环境，加载不同的配置 PRODUCT  TEST   DEV   BETA
define("ENV", "TEST");

$sameArray = array(
    'MOBILE_GOODS_LINK'=>'?m=goods&id=',
    'GET_USERINFO_BYID'=>'user/getInfoById',
);


$envArray = array();
if (ENV == 'TEST'){
    $envArray = array(
        //手机端基础链接
        'MOBILE_LINK'        => 'https://test-mall.artzhe.com/mobile/index.php',
        'USER_CENTER'        => 'https://test-passport.artzhe.com/passport/',
    );
}else{
    $envArray = array(
        'MOBILE_LINK'        => 'https://mall.artzhe.com/mobile/index.php',
        'USER_CENTER'        => 'https://passport.artzhe.com/passport/',
    );
}

return array_merge($sameArray,$envArray);