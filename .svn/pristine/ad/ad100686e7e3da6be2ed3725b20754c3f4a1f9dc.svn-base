<?php

namespace Symfony\Polyfill\Mbstring;

final class Mbstring
{
	const MB_CASE_FOLD = PHP_INT_MAX;

	static private $encodingList = array('ASCII', 'UTF-8');
	static private $language = 'neutral';
	static private $internalEncoding = 'UTF-8';
	static private $caseFold = array(
		array('µ', 'ſ', 'ͅ', 'ς', 'ϐ', 'ϑ', 'ϕ', 'ϖ', 'ϰ', 'ϱ', 'ϵ', 'ẛ', 'ι'),
		array('μ', 's', 'ι', 'σ', 'β', 'θ', 'φ', 'π', 'κ', 'ρ', 'ε', 'ṡ', 'ι')
		);

	static public function mb_convert_encoding($s, $toEncoding, $fromEncoding = NULL)
	{
		if (is_array($fromEncoding) || (false !== strpos($fromEncoding, ','))) {
			$fromEncoding = self::mb_detect_encoding($s, $fromEncoding);
		}
		else {
			$fromEncoding = self::getEncoding($fromEncoding);
		}

		$toEncoding = self::getEncoding($toEncoding);

		if ('BASE64' === $fromEncoding) {
			$s = base64_decode($s);
			$fromEncoding = $toEncoding;
		}

		if ('BASE64' === $toEncoding) {
			return base64_encode($s);
		}

		if (('HTML-ENTITIES' === $toEncoding) || ('HTML' === $toEncoding)) {
			if (('HTML-ENTITIES' === $fromEncoding) || ('HTML' === $fromEncoding)) {
				$fromEncoding = 'Windows-1252';
			}

			if ('UTF-8' !== $fromEncoding) {
				$s = iconv($fromEncoding, 'UTF-8//IGNORE', $s);
			}

			return preg_replace_callback('/[\\x80-\\xFF]+/', array('Symfony\\Polyfill\\Mbstring\\Mbstring', 'html_encoding_callback'), $s);
		}

		if ('HTML-ENTITIES' === $fromEncoding) {
			$s = html_entity_decode($s, ENT_COMPAT, 'UTF-8');
			$fromEncoding = 'UTF-8';
		}

		return iconv($fromEncoding, $toEncoding . '//IGNORE', $s);
	}

	static public function mb_convert_variables($toEncoding, $fromEncoding, &$a = NULL, &$b = NULL, &$c = NULL, &$d = NULL, &$e = NULL, &$f = NULL)
	{
		$vars = array(&$a, &$b, &$c, &$d, &$e, &$f);
		$ok = true;
		array_walk_recursive($vars, function(&$v) use(&$ok, $toEncoding, $fromEncoding) {
			if (false === ($v = Mbstring::mb_convert_encoding($v, $toEncoding, $fromEncoding))) {
				$ok = false;
			}
		});
		return $ok ? $fromEncoding : false;
	}

	static public function mb_decode_mimeheader($s)
	{
		return iconv_mime_decode($s, 2, self::$internalEncoding);
	}

	static public function mb_encode_mimeheader($s, $charset = NULL, $transferEncoding = NULL, $linefeed = NULL, $indent = NULL)
	{
		trigger_error('mb_encode_mimeheader() is bugged. Please use iconv_mime_encode() instead', E_USER_WARNING);
	}

	static public function mb_convert_case($s, $mode, $encoding = NULL)
	{
		if ('' === ($s .= '')) {
			return '';
		}

		$encoding = self::getEncoding($encoding);

		if ('UTF-8' === $encoding) {
			$encoding = null;

			if (!preg_match('//u', $s)) {
				$s = @iconv('UTF-8', 'UTF-8//IGNORE', $s);
			}
		}
		else {
			$s = iconv($encoding, 'UTF-8//IGNORE', $s);
		}

		if (MB_CASE_TITLE == $mode) {
			$s = preg_replace_callback('/\\b\\p{Ll}/u', array('Symfony\\Polyfill\\Mbstring\\Mbstring', 'title_case_upper'), $s);
			$s = preg_replace_callback('/\\B[\\p{Lu}\\p{Lt}]+/u', array('Symfony\\Polyfill\\Mbstring\\Mbstring', 'title_case_lower'), $s);
		}
		else {
			if (MB_CASE_UPPER == $mode) {
				static $upper;

				if (null === $upper) {
					$upper = self::getData('upperCase');
				}

				$map = $upper;
			}
			else {
				if (self::MB_CASE_FOLD === $mode) {
					$s = str_replace(self::$caseFold[0], self::$caseFold[1], $s);
				}

				static $lower;

				if (null === $lower) {
					$lower = self::getData('lowerCase');
				}

				$map = $lower;
			}

			static $ulenMask = array("\xc0" => 2, "\xd0" => 2, "\xe0" => 3, "\xf0" => 4);
			$i = 0;
			$len = strlen($s);

			while ($i < $len) {
				$ulen = ($s[$i] < "\x80" ? 1 : $ulenMask[$s[$i] & "\xf0"]);
				$uchr = substr($s, $i, $ulen);
				$i += $ulen;

				if (isset($map[$uchr])) {
					$uchr = $map[$uchr];
					$nlen = strlen($uchr);

					if ($nlen == $ulen) {
						$nlen = $i;

						do {
							$s[--$nlen] = $uchr[--$ulen];
						} while ($ulen);
					}
					else {
						$s = substr_replace($s, $uchr, $i - $ulen, $ulen);
						$len += $nlen - $ulen;
						$i += $nlen - $ulen;
					}
				}
			}
		}

		if (null === $encoding) {
			return $s;
		}

		return iconv('UTF-8', $encoding . '//IGNORE', $s);
	}

	static public function mb_internal_encoding($encoding = NULL)
	{
		if (null === $encoding) {
			return self::$internalEncoding;
		}

		$encoding = self::getEncoding($encoding);
		if (('UTF-8' === $encoding) || (false !== @iconv($encoding, $encoding, ' '))) {
			self::$internalEncoding = $encoding;
			return true;
		}

		return false;
	}

	static public function mb_language($lang = NULL)
	{
		if (null === $lang) {
			return self::$language;
		}

		switch ($lang = strtolower($lang)) {
		case 'uni':
		case 'neutral':
			self::$language = $lang;
			return true;
		}

		return false;
	}

	static public function mb_list_encodings()
	{
		return array('UTF-8');
	}

	static public function mb_encoding_aliases($encoding)
	{
		switch (strtoupper($encoding)) {
		case 'UTF8':
		case 'UTF-8':
			return array('utf8');
		}

		return false;
	}

	static public function mb_check_encoding($var = NULL, $encoding = NULL)
	{
		if (null === $encoding) {
			if (null === $var) {
				return false;
			}

			$encoding = self::$internalEncoding;
		}

		return self::mb_detect_encoding($var, array($encoding)) || (false !== @iconv($encoding, $encoding, $var));
	}

	static public function mb_detect_encoding($str, $encodingList = NULL, $strict = false)
	{
		if (null === $encodingList) {
			$encodingList = self::$encodingList;
		}
		else {
			if (!is_array($encodingList)) {
				$encodingList = array_map('trim', explode(',', $encodingList));
			}

			$encodingList = array_map('strtoupper', $encodingList);
		}

		foreach ($encodingList as $enc) {
			switch ($enc) {
			case 'ASCII':
				if (!preg_match('/[\\x80-\\xFF]/', $str)) {
					return $enc;
				}

				break;

			case 'UTF8':
			case 'UTF-8':
				if (preg_match('//u', $str)) {
					return 'UTF-8';
				}

				break;

			default:
				if (0 === strncmp($enc, 'ISO-8859-', 9)) {
					return $enc;
				}
			}
		}

		return false;
	}

	static public function mb_detect_order($encodingList = NULL)
	{
		if (null === $encodingList) {
			return self::$encodingList;
		}

		if (!is_array($encodingList)) {
			$encodingList = array_map('trim', explode(',', $encodingList));
		}

		$encodingList = array_map('strtoupper', $encodingList);

		foreach ($encodingList as $enc) {
			switch ($enc) {
			default:
				if (strncmp($enc, 'ISO-8859-', 9)) {
					return false;
				}
			case 'ASCII':
			case 'UTF8':
			case 'UTF-8':
			}
		}

		self::$encodingList = $encodingList;
		return true;
	}

	static public function mb_strlen($s, $encoding = NULL)
	{
		$encoding = self::getEncoding($encoding);
		if (('CP850' === $encoding) || ('ASCII' === $encoding)) {
			return strlen($s);
		}

		return @iconv_strlen($s, $encoding);
	}

	static public function mb_strpos($haystack, $needle, $offset = 0, $encoding = NULL)
	{
		$encoding = self::getEncoding($encoding);
		if (('CP850' === $encoding) || ('ASCII' === $encoding)) {
			return strpos($haystack, $needle, $offset);
		}

		if ('' === ($needle .= '')) {
			trigger_error('Symfony\\Polyfill\\Mbstring\\Mbstring::mb_strpos' . ': Empty delimiter', E_USER_WARNING);
			return false;
		}

		return iconv_strpos($haystack, $needle, $offset, $encoding);
	}

	static public function mb_strrpos($haystack, $needle, $offset = 0, $encoding = NULL)
	{
		$encoding = self::getEncoding($encoding);
		if (('CP850' === $encoding) || ('ASCII' === $encoding)) {
			return strrpos($haystack, $needle, $offset);
		}

		if ($offset != (int) $offset) {
			$offset = 0;
		}
		else if ($offset = (int) $offset) {
			if ($offset < 0) {
				$haystack = self::mb_substr($haystack, 0, $offset, $encoding);
				$offset = 0;
			}
			else {
				$haystack = self::mb_substr($haystack, $offset, 2147483647, $encoding);
			}
		}

		$pos = iconv_strrpos($haystack, $needle, $encoding);
		return false !== $pos ? $offset + $pos : false;
	}

	static public function mb_strtolower($s, $encoding = NULL)
	{
		return self::mb_convert_case($s, MB_CASE_LOWER, $encoding);
	}

	static public function mb_strtoupper($s, $encoding = NULL)
	{
		return self::mb_convert_case($s, MB_CASE_UPPER, $encoding);
	}

	static public function mb_substitute_character($c = NULL)
	{
		if (0 === strcasecmp($c, 'none')) {
			return true;
		}

		return null !== $c ? false : 'none';
	}

	static public function mb_substr($s, $start, $length = NULL, $encoding = NULL)
	{
		$encoding = self::getEncoding($encoding);
		if (('CP850' === $encoding) || ('ASCII' === $encoding)) {
			return substr($s, $start, null === $length ? 2147483647 : $length);
		}

		if ($start < 0) {
			$start = iconv_strlen($s, $encoding) + $start;

			if ($start < 0) {
				$start = 0;
			}
		}

		if (null === $length) {
			$length = 2147483647;
		}
		else if ($length < 0) {
			$length = (iconv_strlen($s, $encoding) + $length) - $start;

			if ($length < 0) {
				return '';
			}
		}

		return iconv_substr($s, $start, $length, $encoding) . '';
	}

	static public function mb_stripos($haystack, $needle, $offset = 0, $encoding = NULL)
	{
		$haystack = self::mb_convert_case($haystack, self::MB_CASE_FOLD, $encoding);
		$needle = self::mb_convert_case($needle, self::MB_CASE_FOLD, $encoding);
		return self::mb_strpos($haystack, $needle, $offset, $encoding);
	}

	static public function mb_stristr($haystack, $needle, $part = false, $encoding = NULL)
	{
		$pos = self::mb_stripos($haystack, $needle, 0, $encoding);
		return self::getSubpart($pos, $part, $haystack, $encoding);
	}

	static public function mb_strrchr($haystack, $needle, $part = false, $encoding = NULL)
	{
		$encoding = self::getEncoding($encoding);
		if (('CP850' === $encoding) || ('ASCII' === $encoding)) {
			return strrchr($haystack, $needle, $part);
		}

		$needle = self::mb_substr($needle, 0, 1, $encoding);
		$pos = iconv_strrpos($haystack, $needle, $encoding);
		return self::getSubpart($pos, $part, $haystack, $encoding);
	}

	static public function mb_strrichr($haystack, $needle, $part = false, $encoding = NULL)
	{
		$needle = self::mb_substr($needle, 0, 1, $encoding);
		$pos = self::mb_strripos($haystack, $needle, $encoding);
		return self::getSubpart($pos, $part, $haystack, $encoding);
	}

	static public function mb_strripos($haystack, $needle, $offset = 0, $encoding = NULL)
	{
		$haystack = self::mb_convert_case($haystack, self::MB_CASE_FOLD, $encoding);
		$needle = self::mb_convert_case($needle, self::MB_CASE_FOLD, $encoding);
		return self::mb_strrpos($haystack, $needle, $offset, $encoding);
	}

	static public function mb_strstr($haystack, $needle, $part = false, $encoding = NULL)
	{
		$pos = strpos($haystack, $needle);

		if (false === $pos) {
			return false;
		}

		if ($part) {
			return substr($haystack, 0, $pos);
		}

		return substr($haystack, $pos);
	}

	static public function mb_get_info($type = 'all')
	{
		$info = array('internal_encoding' => self::$internalEncoding, 'http_output' => 'pass', 'http_output_conv_mimetypes' => '^(text/|application/xhtml\\+xml)', 'func_overload' => 0, 'func_overload_list' => 'no overload', 'mail_charset' => 'UTF-8', 'mail_header_encoding' => 'BASE64', 'mail_body_encoding' => 'BASE64', 'illegal_chars' => 0, 'encoding_translation' => 'Off', 'language' => self::$language, 'detect_order' => self::$encodingList, 'substitute_character' => 'none', 'strict_detection' => 'Off');

		if ('all' === $type) {
			return $info;
		}

		if (isset($info[$type])) {
			return $info[$type];
		}

		return false;
	}

	static public function mb_http_input($type = '')
	{
		return false;
	}

	static public function mb_http_output($encoding = NULL)
	{
		return null !== $encoding ? 'pass' === $encoding : 'pass';
	}

	static public function mb_strwidth($s, $encoding = NULL)
	{
		$encoding = self::getEncoding($encoding);

		if ('UTF-8' !== $encoding) {
			$s = iconv($encoding, 'UTF-8//IGNORE', $s);
		}

		$s = preg_replace('/[\\x{1100}-\\x{115F}\\x{2329}\\x{232A}\\x{2E80}-\\x{303E}\\x{3040}-\\x{A4CF}\\x{AC00}-\\x{D7A3}\\x{F900}-\\x{FAFF}\\x{FE10}-\\x{FE19}\\x{FE30}-\\x{FE6F}\\x{FF00}-\\x{FF60}\\x{FFE0}-\\x{FFE6}\\x{20000}-\\x{2FFFD}\\x{30000}-\\x{3FFFD}]/u', '', $s, -1, $wide);
		return ($wide << 1) + iconv_strlen($s, 'UTF-8');
	}

	static public function mb_substr_count($haystack, $needle, $encoding = NULL)
	{
		return substr_count($haystack, $needle);
	}

	static public function mb_output_handler($contents, $status)
	{
		return $contents;
	}

	static public function mb_chr($code, $encoding = NULL)
	{
		if (($code %= 2097152) < 128) {
			$s = chr($code);
		}
		else if ($code < 2048) {
			$s = chr(192 | ($code >> 6)) . chr(128 | ($code & 63));
		}
		else if ($code < 65536) {
			$s = chr(224 | ($code >> 12)) . chr(128 | (($code >> 6) & 63)) . chr(128 | ($code & 63));
		}
		else {
			$s = chr(240 | ($code >> 18)) . chr(128 | (($code >> 12) & 63)) . chr(128 | (($code >> 6) & 63)) . chr(128 | ($code & 63));
		}

		if ('UTF-8' !== ($encoding = self::getEncoding($encoding))) {
			$s = mb_convert_encoding($s, $encoding, 'UTF-8');
		}

		return $s;
	}

	static public function mb_ord($s, $encoding = NULL)
	{
		if ('UTF-8' !== ($encoding = self::getEncoding($encoding))) {
			$s = mb_convert_encoding($s, 'UTF-8', $encoding);
		}

		$code = ($s = unpack('C*', substr($s, 0, 4)) ? $s[1] : 0);

		if (240 <= $code) {
			return ((($code - 240) << 18) + (($s[2] - 128) << 12) + (($s[3] - 128) << 6) + $s[4]) - 128;
		}

		if (224 <= $code) {
			return ((($code - 224) << 12) + (($s[2] - 128) << 6) + $s[3]) - 128;
		}

		if (192 <= $code) {
			return ((($code - 192) << 6) + $s[2]) - 128;
		}

		return $code;
	}

	static private function getSubpart($pos, $part, $haystack, $encoding)
	{
		if (false === $pos) {
			return false;
		}

		if ($part) {
			return self::mb_substr($haystack, 0, $pos, $encoding);
		}

		return self::mb_substr($haystack, $pos, null, $encoding);
	}

	static private function html_encoding_callback($m)
	{
		$i = 1;
		$entities = '';
		$m = unpack('C*', htmlentities($m[0], ENT_COMPAT, 'UTF-8'));

		while (isset($m[$i])) {
			if ($m[$i] < 128) {
				$entities .= chr($m[$i++]);
				continue;
			}

			if (240 <= $m[$i]) {
				$c = ((($m[$i++] - 240) << 18) + (($m[$i++] - 128) << 12) + (($m[$i++] - 128) << 6) + $m[$i++]) - 128;
			}
			else if (224 <= $m[$i]) {
				$c = ((($m[$i++] - 224) << 12) + (($m[$i++] - 128) << 6) + $m[$i++]) - 128;
			}
			else {
				$c = ((($m[$i++] - 192) << 6) + $m[$i++]) - 128;
			}

			$entities .= '&#' . $c . ';';
		}

		return $entities;
	}

	static private function title_case_lower($s)
	{
		return self::mb_convert_case($s[0], MB_CASE_LOWER, 'UTF-8');
	}

	static private function title_case_upper($s)
	{
		return self::mb_convert_case($s[0], MB_CASE_UPPER, 'UTF-8');
	}

	static private function getData($file)
	{
		if (file_exists($file = __DIR__ . '/Resources/unidata/' . $file . '.php')) {
			return require $file;
		}

		return false;
	}

	static private function getEncoding($encoding)
	{
		if (null === $encoding) {
			return self::$internalEncoding;
		}

		$encoding = strtoupper($encoding);
		if (('8BIT' === $encoding) || ('BINARY' === $encoding)) {
			return 'CP850';
		}

		if ('UTF8' === $encoding) {
			return 'UTF-8';
		}

		return $encoding;
	}
}


?>
