<?php

/* *
 * 配置文件
 * 版本：1.0
 * 日期：2014-06-16
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//商户编号是商户在连连钱包支付平台上开设的商户号码，为18位数字，如：201306081000001016
$llpay_config['oid_partner'] = '201803300001692013';

//秘钥格式注意不能修改（左对齐，右边有回车符）
$llpay_config['RSA_PRIVATE_KEY'] ='-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDX+LfWI9mW4ceAKcn+2ihiWq+yLZfU2oU2qn+nww6xb9F4bBY0
RCFfeqxUDYn9Ib19mwKlLppItlNKIXqWZ8fr6EItVsebuTYhwFJ5hiCgA9JXBCJe
MzuTs1DInqJQchw0Y5Sy74U5bokIXeyQ+Z85ELXTAG2qkoH3smjx9KA/EwIDAQAB
AoGAaOjVjDzv5n4YZeZmy9h3Q4efzyKcnXXkvfBGgFydF44kp6WBh7QMrg+uBEpr
XD32iTwyJcEkiuueO+VVYhhZoRcPzDaiaM+0caIQfZOVDRtA75o/tuktfc5up0/x
MHzU+gXdQq0PkKwBEeKNhI1BeAH4CkMgDvgf/XrgVXXUSfkCQQD11roTEODTqbeg
BaQ5QHbPScHA8JPNYHtXToZLHt9BFnuAYIVNxedlG6wsT0qyidL4HgEaQ6hUlXwy
cqR/sv2fAkEA4OX1sY4gCIK++cGjayN+oJH8FEMP+TZhyWCH/iAJxSJkJdlk0Vvh
weBWftVSm2f9le9ZcdVtiaR7eg+pon3iDQJBAOtytw2xmZI+tqYlIQ7QJboL6uxN
vVDyuc55X3cs3ydoT+o5BxLgmuikIzbgzirGg26s1eOArwQrkyKB1/iRxgMCQCQr
V7RSkzxLKsOoLMwSTU8tq0jm8C64XEmyyKxKIsgdm9WqfNhe2pP/rGmBjWOI+fOf
Jtdz58X3OhSLaFDFxhECQQDcCg4M0HiCXMy41mn4YdKWd6NgZp5jJJwYLYFJslmY
iEgCPQiWjdcIEs7qmvhzI+FUJ6UPnBLVvMzDFvY6Uw8e
-----END RSA PRIVATE KEY-----';

//安全检验码，以数字和字母组成的字符
$llpay_config['key'] ='201408071000001539_sahdisa_20141205';

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//版本号
$llpay_config['version'] = '1.0';

//防钓鱼ip 可不传或者传下滑线格式 
$llpay_config['userreq_ip'] = '10_10_246_110';

//证件类型
$llpay_config['id_type'] = '0';

//签名方式 不需修改
$llpay_config['sign_type'] = strtoupper('RSA');

//订单有效时间  分钟为单位，默认为10080分钟（7天） 
$llpay_config['valid_order'] ="10080";

//字符编码格式 目前支持 gbk 或 utf-8
$llpay_config['input_charset'] = strtolower('utf-8');

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$llpay_config['transport'] = 'http';
?>