<?php

namespace App\Servers;


class Des
{
	// 高搜易加密，高搜易所有项目统一使用这里一致的key和iv，以便于交付
	// 外部接口使用的加密，由对象实例化的时候传递过来
	protected static $instance = null;
	public static $key = "p~s$1I@v^l!s0osi2t#s`5s1";
	public static $iv  = '26882018';


	/**
	 * 构造函数
	 * @param string $key：3DES的密钥
	 * @param string $iv：3DES的初始向量
	 */
	public function __construct($key, $iv) {
		if( $key )
			self::$key = $key;
		if( $iv )
			self::$iv  = $iv;
	}

	public static function getInstance($key, $iv){
        if (is_null(static::$instance)) {
            return static::$instance = new static($key, $iv);
        }
        return static::$instance;
    }


	/**
	 * 明码补位
	 * @param string $text：要加密的明码
	 * @param int $blocksize：缺少的字节数
	 * @return string：补位后的明码
	 */
	static private function pkcs5Pad($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}


	/**
	 * 从明码中删除所补的位
	 * @param string $text，已经补位过的明码
	 * @return false | string，删除所补的位的明码，即获得的原始明码
	 */
	static private function pkcs5Unpad($text) {
		$textLen = strlen($text);
		$pad = ord($text[strlen($text)-1]);
		if ($pad > strlen($text)) return false;
		if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
		return substr($text, 0, -1 * $pad);
	}


	/**
	 * 3DES-CBC加密
	 * @param string $text：明码
	 * @return string：密码
	 */
	public static function encrypt($text) {
		$padded = self::pkcs5Pad($text, mcrypt_get_block_size(MCRYPT_TRIPLEDES, MCRYPT_MODE_CBC));
		$enstr  = base64_encode(mcrypt_encrypt(MCRYPT_TRIPLEDES, self::$key, $padded, MCRYPT_MODE_CBC, self::$iv));
		//return urlencode( urlencode( trim($enstr,'=')) );
		return str_replace(array('+','/','='),array('-','_',''),$enstr);
	}


	/**
	 * 3DES-CBC解密
	 * @param string $text：密码
	 * @return string：删除所补的位的明码，即获得的原始明码
	 */
	public static function decrypt($text) {
		$text = str_replace(array('-','_'),array('+','/'),$text);
		$text = base64_decode($text);
		$plain_text = mcrypt_decrypt(MCRYPT_TRIPLEDES, self::$key, $text, MCRYPT_MODE_CBC, self::$iv);
		return self::pkcs5Unpad($plain_text);
	}
}

