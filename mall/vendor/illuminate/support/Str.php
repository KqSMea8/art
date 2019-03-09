<?php

namespace Illuminate\Support;

class Str
{
	use Traits\Macroable;

	/**
     * The cache of snake-cased words.
     *
     * @var array
     */
	static protected $snakeCache = array();
	/**
     * The cache of camel-cased words.
     *
     * @var array
     */
	static protected $camelCache = array();
	/**
     * The cache of studly-cased words.
     *
     * @var array
     */
	static protected $studlyCache = array();

	static public function after($subject, $search)
	{
		if ($search == '') {
			return $subject;
		}

		$pos = strpos($subject, $search);

		if ($pos === false) {
			return $subject;
		}

		return substr($subject, $pos + strlen($search));
	}

	static public function ascii($value)
	{
		foreach (static::charsArray() as $key => $val) {
			$value = str_replace($val, $key, $value);
		}

		return preg_replace('/[^\\x20-\\x7E]/u', '', $value);
	}

	static public function camel($value)
	{
		if (isset(static::$camelCache[$value])) {
			return static::$camelCache[$value];
		}

		return static::$camelCache[$value] = lcfirst(static::studly($value));
	}

	static public function contains($haystack, $needles)
	{
		foreach ((array) $needles as $needle) {
			if (($needle != '') && (mb_strpos($haystack, $needle) !== false)) {
				return true;
			}
		}

		return false;
	}

	static public function endsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle) {
			if (substr($haystack, 0 - strlen($needle)) === (string) $needle) {
				return true;
			}
		}

		return false;
	}

	static public function finish($value, $cap)
	{
		$quoted = preg_quote($cap, '/');
		return preg_replace('/(?:' . $quoted . ')+$/u', '', $value) . $cap;
	}

	static public function is($pattern, $value)
	{
		if ($pattern == $value) {
			return true;
		}

		$pattern = preg_quote($pattern, '#');
		$pattern = str_replace('\\*', '.*', $pattern);
		return (bool) preg_match('#^' . $pattern . '\\z#u', $value);
	}

	static public function kebab($value)
	{
		return static::snake($value, '-');
	}

	static public function length($value, $encoding = NULL)
	{
		if ($encoding) {
			return mb_strlen($value, $encoding);
		}

		return mb_strlen($value);
	}

	static public function limit($value, $limit = 100, $end = '...')
	{
		if (mb_strwidth($value, 'UTF-8') <= $limit) {
			return $value;
		}

		return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
	}

	static public function lower($value)
	{
		return mb_strtolower($value, 'UTF-8');
	}

	static public function words($value, $words = 100, $end = '...')
	{
		preg_match('/^\\s*+(?:\\S++\\s*+){1,' . $words . '}/u', $value, $matches);
		if (!isset($matches[0]) || (static::length($value) === static::length($matches[0]))) {
			return $value;
		}

		return rtrim($matches[0]) . $end;
	}

	static public function parseCallback($callback, $default = NULL)
	{
		return static::contains($callback, '@') ? explode('@', $callback, 2) : array($callback, $default);
	}

	static public function plural($value, $count = 2)
	{
		return Pluralizer::plural($value, $count);
	}

	static public function random($length = 16)
	{
		$string = '';

		while (($len = strlen($string)) < $length) {
			$size = $length - $len;
			$bytes = random_bytes($size);
			$string .= substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $size);
		}

		return $string;
	}

	static public function quickRandom($length = 16)
	{
		if (5 < PHP_MAJOR_VERSION) {
			return static::random($length);
		}

		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
	}

	static public function replaceArray($search, array $replace, $subject)
	{
		foreach ($replace as $value) {
			$subject = static::replaceFirst($search, $value, $subject);
		}

		return $subject;
	}

	static public function replaceFirst($search, $replace, $subject)
	{
		if ($search == '') {
			return $subject;
		}

		$position = strpos($subject, $search);

		if ($position !== false) {
			return substr_replace($subject, $replace, $position, strlen($search));
		}

		return $subject;
	}

	static public function replaceLast($search, $replace, $subject)
	{
		$position = strrpos($subject, $search);

		if ($position !== false) {
			return substr_replace($subject, $replace, $position, strlen($search));
		}

		return $subject;
	}

	static public function upper($value)
	{
		return mb_strtoupper($value, 'UTF-8');
	}

	static public function title($value)
	{
		return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
	}

	static public function singular($value)
	{
		return Pluralizer::singular($value);
	}

	static public function slug($title, $separator = '-')
	{
		$title = static::ascii($title);
		$flip = ($separator == '-' ? '_' : '-');
		$title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);
		$title = preg_replace('![^' . preg_quote($separator) . '\\pL\\pN\\s]+!u', '', mb_strtolower($title));
		$title = preg_replace('![' . preg_quote($separator) . '\\s]+!u', $separator, $title);
		return trim($title, $separator);
	}

	static public function snake($value, $delimiter = '_')
	{
		$key = $value;

		if (isset(static::$snakeCache[$key][$delimiter])) {
			return static::$snakeCache[$key][$delimiter];
		}

		if (!ctype_lower($value)) {
			$value = preg_replace('/\\s+/u', '', $value);
			$value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
		}

		return static::$snakeCache[$key][$delimiter] = $value;
	}

	static public function startsWith($haystack, $needles)
	{
		foreach ((array) $needles as $needle) {
			if (($needle != '') && (substr($haystack, 0, strlen($needle)) === (string) $needle)) {
				return true;
			}
		}

		return false;
	}

	static public function studly($value)
	{
		$key = $value;

		if (isset(static::$studlyCache[$key])) {
			return static::$studlyCache[$key];
		}

		$value = ucwords(str_replace(array('-', '_'), ' ', $value));
		return static::$studlyCache[$key] = str_replace(' ', '', $value);
	}

	static public function substr($string, $start, $length = NULL)
	{
		return mb_substr($string, $start, $length, 'UTF-8');
	}

	static public function ucfirst($string)
	{
		return static::upper(static::substr($string, 0, 1)) . static::substr($string, 1);
	}

	static protected function charsArray()
	{
		static $charsArray;

		if (isset($charsArray)) {
			return $charsArray;
		}

		return $charsArray = array(
	0      => array('°', '₀', '۰'),
	1      => array('¹', '₁', '۱'),
	2      => array('²', '₂', '۲'),
	3      => array('³', '₃', '۳'),
	4      => array('⁴', '₄', '۴', '٤'),
	5      => array('⁵', '₅', '۵', '٥'),
	6      => array('⁶', '₆', '۶', '٦'),
	7      => array('⁷', '₇', '۷'),
	8      => array('⁸', '₈', '۸'),
	9      => array('⁹', '₉', '۹'),
	'a'    => array('à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا'),
	'b'    => array('б', 'β', 'Ъ', 'Ь', 'ب', 'ဗ', 'ბ'),
	'c'    => array('ç', 'ć', 'č', 'ĉ', 'ċ'),
	'd'    => array('ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ'),
	'e'    => array('é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ'),
	'f'    => array('ф', 'φ', 'ف', 'ƒ', 'ფ'),
	'g'    => array('ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ'),
	'h'    => array('ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ'),
	'i'    => array('í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ'),
	'j'    => array('ĵ', 'ј', 'Ј', 'ჯ', 'ج'),
	'k'    => array('ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک'),
	'l'    => array('ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ'),
	'm'    => array('м', 'μ', 'م', 'မ', 'მ'),
	'n'    => array('ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ'),
	'o'    => array('ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ'),
	'p'    => array('п', 'π', 'ပ', 'პ', 'پ'),
	'q'    => array('ყ'),
	'r'    => array('ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ'),
	's'    => array('ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს'),
	't'    => array('ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ'),
	'u'    => array('ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ'),
	'v'    => array('в', 'ვ', 'ϐ'),
	'w'    => array('ŵ', 'ω', 'ώ', 'ဝ', 'ွ'),
	'x'    => array('χ', 'ξ'),
	'y'    => array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ'),
	'z'    => array('ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ'),
	'aa'   => array('ع', 'आ', 'آ'),
	'ae'   => array('ä', 'æ', 'ǽ'),
	'ai'   => array('ऐ'),
	'at'   => array('@'),
	'ch'   => array('ч', 'ჩ', 'ჭ', 'چ'),
	'dj'   => array('ђ', 'đ'),
	'dz'   => array('џ', 'ძ'),
	'ei'   => array('ऍ'),
	'gh'   => array('غ', 'ღ'),
	'ii'   => array('ई'),
	'ij'   => array('ĳ'),
	'kh'   => array('х', 'خ', 'ხ'),
	'lj'   => array('љ'),
	'nj'   => array('њ'),
	'oe'   => array('ö', 'œ', 'ؤ'),
	'oi'   => array('ऑ'),
	'oii'  => array('ऒ'),
	'ps'   => array('ψ'),
	'sh'   => array('ш', 'შ', 'ش'),
	'shch' => array('щ'),
	'ss'   => array('ß'),
	'sx'   => array('ŝ'),
	'th'   => array('þ', 'ϑ', 'ث', 'ذ', 'ظ'),
	'ts'   => array('ц', 'ც', 'წ'),
	'ue'   => array('ü'),
	'uu'   => array('ऊ'),
	'ya'   => array('я'),
	'yu'   => array('ю'),
	'zh'   => array('ж', 'ჟ', 'ژ'),
	'(c)'  => array('©'),
	'A'    => array('Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ'),
	'B'    => array('Б', 'Β', 'ब'),
	'C'    => array('Ç', 'Ć', 'Č', 'Ĉ', 'Ċ'),
	'D'    => array('Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ'),
	'E'    => array('É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə'),
	'F'    => array('Ф', 'Φ'),
	'G'    => array('Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ'),
	'H'    => array('Η', 'Ή', 'Ħ'),
	'I'    => array('Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ'),
	'K'    => array('К', 'Κ'),
	'L'    => array('Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल'),
	'M'    => array('М', 'Μ'),
	'N'    => array('Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν'),
	'O'    => array('Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ'),
	'P'    => array('П', 'Π'),
	'R'    => array('Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ'),
	'S'    => array('Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ'),
	'T'    => array('Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ'),
	'U'    => array('Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ'),
	'V'    => array('В'),
	'W'    => array('Ω', 'Ώ', 'Ŵ'),
	'X'    => array('Χ', 'Ξ'),
	'Y'    => array('Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ'),
	'Z'    => array('Ź', 'Ž', 'Ż', 'З', 'Ζ'),
	'AE'   => array('Ä', 'Æ', 'Ǽ'),
	'CH'   => array('Ч'),
	'DJ'   => array('Ђ'),
	'DZ'   => array('Џ'),
	'GX'   => array('Ĝ'),
	'HX'   => array('Ĥ'),
	'IJ'   => array('Ĳ'),
	'JX'   => array('Ĵ'),
	'KH'   => array('Х'),
	'LJ'   => array('Љ'),
	'NJ'   => array('Њ'),
	'OE'   => array('Ö', 'Œ'),
	'PS'   => array('Ψ'),
	'SH'   => array('Ш'),
	'SHCH' => array('Щ'),
	'SS'   => array('ẞ'),
	'TH'   => array('Þ'),
	'TS'   => array('Ц'),
	'UE'   => array('Ü'),
	'YA'   => array('Я'),
	'YU'   => array('Ю'),
	'ZH'   => array('Ж'),
	' '    => array(' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', '　')
	);
	}
}

?>
