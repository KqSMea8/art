<?php

require_once ROOT_PATH . "vendor/util/AZcrypt.php";


//3DES加密函数 用途::加密会员ID、产品ID，再将密文通过网络传输
function des_encode($str)
{
	$DES = new AZcrypt();
	return $DES->encrypt($str);
}
//3DES解密函数
function des_decode($str)
{
	$DES = new AZcrypt();
	return $DES->decrypt($str);
}
