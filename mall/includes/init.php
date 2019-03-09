<?php

function get_adv($type, $id)
{
	$sql = 'select ap.ad_width,ap.ad_height,ad.ad_name,ad.ad_code,ad.ad_link,ad.media_type from ' . $GLOBALS['ecs']->table('ad_position') . ' as ap left join ' . $GLOBALS['ecs']->table('ad') . ' as ad on ad.position_id = ap.position_id where ad.ad_name=\'' . $type . '_' . $id . '\' and (ad.media_type=0 OR ad.media_type=3) and UNIX_TIMESTAMP()>ad.start_time and UNIX_TIMESTAMP()<ad.end_time and ad.enabled=1';
	$row = $GLOBALS['db']->getRow($sql);

	if ($row) {
		if ($row['media_type'] == 0) {
			$src = strpos($row['ad_code'], 'http://') === false && strpos($row['ad_code'], 'https://') === false ? DATA_DIR . ('/afficheimg/' . $row['ad_code']) : $row['ad_code'];
			return '<a href=\'' . $row['ad_link'] . ("'\r\n                target='_blank'><img src='" . $src . '\' width=\'') . $row['ad_width'] . ('\' height=\'' . $row['ad_height'] . "'\r\n                border='0' /></a>");
		}
		else {
			return '<a href=\'' . $row['ad_link'] . "'\r\n                target='_blank'>" . htmlspecialchars($row['ad_code']) . '</a>';
		}
	}
	else {
		return '';
	}
}


if (!defined('IN_ECS')) {
	exit('Hacking attempt');
}

error_reporting(32767);

if (__FILE__ == '') {
	exit('Fatal error code: 0');
}

// 拷贝index文件，过滤pc站点
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$uachar = '/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i';
if (($ua == '' || preg_match($uachar, $ua)) && !strpos(strtolower($_SERVER['REQUEST_URI']), 'wap')) {

}
//else{
////     暂时关闭前台的PC端站点
//    echo '电脑端暂时未开放，请用手机访问本网站！';
//    exit();
//}

define('ROOT_PATH', str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__)));
$GLOBALS['_beginTime'] = microtime(true);
define('MEMORY_LIMIT_ON', function_exists('memory_get_usage'));

if (MEMORY_LIMIT_ON) {
	$GLOBALS['_startUseMems'] = memory_get_usage();
}

@ini_set('memory_limit', '512M');
@ini_set('session.cache_expire', 180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies', 1);
@ini_set('session.auto_start', 0);
@ini_set('display_errors', 1);

if (DIRECTORY_SEPARATOR == '\\') {
	@ini_set('include_path', '.;' . ROOT_PATH);
}
else {
	@ini_set('include_path', '.:' . ROOT_PATH);
}

require ROOT_PATH . 'vendor/autoload.php';
require ROOT_PATH . 'data/config.php';
require ROOT_PATH . 'data/database.php';

if (defined('DEBUG_MODE') == false) {
	define('DEBUG_MODE', 0);
}

if ('5.1' <= PHP_VERSION && !empty($timezone)) {
	date_default_timezone_set($timezone);
}

$php_self = isset($_SERVER['PHP_SELF']) && !empty($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];

if ('/' == substr($php_self, -1)) {
	$php_self .= 'index.php';
}

define('PHP_SELF', $php_self);
require ROOT_PATH . 'data/template_config.php';
require ROOT_PATH . 'includes/Http.class.php';
require ROOT_PATH . 'includes/cls_pinyin.php';
require ROOT_PATH . 'includes/inc_constant.php';
require ROOT_PATH . 'includes/cls_ecshop.php';
require ROOT_PATH . 'includes/cls_error.php';
require ROOT_PATH . 'includes/lib_time.php';
require ROOT_PATH . 'includes/lib_base.php';
require ROOT_PATH . 'includes/lib_common.php';
require ROOT_PATH . 'includes/lib_main.php';
require ROOT_PATH . 'includes/lib_insert.php';
require ROOT_PATH . 'includes/lib_goods.php';
require ROOT_PATH . 'includes/lib_article.php';
require ROOT_PATH . 'includes/lib_input.php';
require ROOT_PATH . '/includes/cls_captcha_verify.php';
require ROOT_PATH . 'includes/lib_scws.php';
require ROOT_PATH . 'includes/lib_ecmoban.php';
require ROOT_PATH . 'includes/lib_ecmobanFunc.php';
require ROOT_PATH . 'includes/lib_seller_store.php';
require ROOT_PATH . 'includes/lib_ipCity.php';
require ROOT_PATH . 'includes/cls_ecmac.php';
require ROOT_PATH . 'includes/lib_oss.php';
require ROOT_PATH . 'vendor/crypt.php';
if (!file_exists(ROOT_PATH . 'data/install.lock.php') && !defined('NO_CHECK_INSTALL')) {
	header("Location: ./install/index.php\n");
	exit();
}

if (!get_magic_quotes_gpc()) {
	if (!empty($_GET)) {
		$_GET = addslashes_deep($_GET);
	}

	if (!empty($_POST)) {
		$_POST = addslashes_deep($_POST);
	}

	$_COOKIE = addslashes_deep($_COOKIE);
	$_REQUEST = addslashes_deep($_REQUEST);
}

$ecs = new ECS($db_name, $prefix);
define('DATA_DIR', $ecs->data_dir());
define('IMAGE_DIR', $ecs->image_dir());
require ROOT_PATH . 'includes/cls_mysql.php';
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db->set_disable_cache_tables(array($ecs->table('sessions'), $ecs->table('sessions_data'), $ecs->table('cart')));
$db_host = $db_user = $db_pass = $db_name = NULL;
$err = new ecs_error('message.dwt');
$sel_config = get_shop_config_val('open_memcached');

if ($sel_config['open_memcached'] == 1) {
	require ROOT_PATH . 'includes/cls_cache.php';
	require ROOT_PATH . 'data/cache_config.php';
	$cache = new cls_cache($cache_config);
}

$_CFG = load_config();

//自动清除所有的缓存数据



if (is_temps($_CFG))
{
    clear_all_files();
    $sql="update ".$ecs->table('shop_config') ."set value=".time()." where code='"."last_clear_time '";
     $db->query($sql);
}


function is_temps($_CFG)
{
    if(time()-$_CFG['last_clear_time']<1)
    {
        return false;
    }
    else
    {
        return true;
    }
}

if(!function_exists('curl_request')){
	function curl_request($url,$post='',$cookie='', $returnCookie=0){
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
          curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
          curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
         curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
          if($post) {
             curl_setopt($curl, CURLOPT_POST, 1);
             curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
         if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
         }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         $data = curl_exec($curl);
         if (curl_errno($curl)) {
             return curl_error($curl);
         }
         curl_close($curl);
         if($returnCookie){
             list($header, $body) = explode("\r\n\r\n", $data, 2);
             preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
             $info['cookie']  = substr($matches[1][0], 1);
             $info['content'] = $body;
             return $info;
         }else{
             return $data;
         }
 }
}
//添加过滤方法 暂定一部分功能
$limit_function =explode('|',$_CFG['limit_function']);
$request_self=pathinfo($_SERVER['PHP_SELF']);
if(isset($request_self['filename']) && isset($limit_function )){
	if(in_array($request_self['filename'],$limit_function)){//请求限制功能文件
		exit('您请求的功能未开放');
	};
}
require ROOT_PATH . 'data/sms_config.php';
require ROOT_PATH . 'languages/' . $_CFG['lang'] . '/common.php';
require ROOT_PATH . 'languages/' . $_CFG['lang'] . '/js_languages.php';

if (file_exists(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/' . basename(PHP_SELF))) {
	include ROOT_PATH . 'languages/' . $_CFG['lang'] . '/' . basename(PHP_SELF);
}

if ($_CFG['shop_closed'] == 1) {
	header('Content-type: text/html; charset=' . EC_CHARSET);
	exit($_CFG['close_comment']);
}

if (is_spider()) {
	if (!defined('INIT_NO_USERS')) {
		define('INIT_NO_USERS', true);

		if ($_CFG['integrate_code'] == 'ucenter') {
			$user = &init_users();
		}
	}

	$_SESSION = array();
	$_SESSION['user_id'] = 0;
	$_SESSION['user_name'] = '';
	$_SESSION['email'] = '';
	$_SESSION['user_rank'] = 0;
	$_SESSION['discount'] = 1;
}

if (!defined('INIT_NO_USERS')) {
	if ($GLOBALS['_CFG']['open_memcached'] == 1) {
		$sessionDriver = 'cls_session_memcached';
	}
	else {
		$sessionDriver = 'cls_session';
	}

	include ROOT_PATH . 'includes/' . $sessionDriver . '.php';
	$sess = new $sessionDriver($db, $ecs->table('sessions'), $ecs->table('sessions_data'));
	define('SESS_ID', $sess->get_session_id());
}

if (isset($_SERVER['PHP_SELF'])) {
	$_SERVER['PHP_SELF'] = htmlspecialchars($_SERVER['PHP_SELF']);
}

if (!defined('INIT_NO_SMARTY')) {
	header('Cache-control: private');
	header('Content-type: text/html; charset=' . EC_CHARSET);
	require ROOT_PATH . 'includes/cls_template.php';
	$smarty = new cls_template();
	$smarty->cache_lifetime = $_CFG['cache_time'];
	$smarty->template_dir = ROOT_PATH . 'themes/' . $_CFG['template'];
	$smarty->cache_dir = ROOT_PATH . 'temp/caches';
	$smarty->compile_dir = ROOT_PATH . 'temp/compiled';

	if ((DEBUG_MODE & 2) == 2) {
		$smarty->direct_output = true;
		$smarty->force_compile = true;
	}
	else {
		$smarty->direct_output = false;
		$smarty->force_compile = false;
	}

	$smarty->assign('lang', $_LANG);
	$smarty->assign('ecs_charset', EC_CHARSET);

	if (!empty($_CFG['stylename'])) {
		$smarty->assign('ecs_css_path', 'themes/' . $_CFG['template'] . '/style_' . $_CFG['stylename'] . '.css');
	}
	else {
		$smarty->assign('ecs_css_path', 'themes/' . $_CFG['template'] . '/style.css');
	}

	$smarty->assign('ecs_css_suggest', 'themes/' . $_CFG['template'] . '/suggest.css');
	$kf_im_switch = $GLOBALS['db']->getOne('SELECT kf_im_switch FROM ' . $GLOBALS['ecs']->table('seller_shopinfo') . 'WHERE ru_id=0');
	$smarty->assign('kf_im_switch', $kf_im_switch);
}

if (!defined('INIT_NO_USERS')) {
	$user = &init_users();

	if (!isset($_SESSION['user_id'])) {
		$site_name = isset($_GET['from']) ? htmlspecialchars($_GET['from']) : addslashes($_LANG['self_site']);
		$from_ad = !empty($_GET['ad_id']) ? intval($_GET['ad_id']) : 0;
		$_SESSION['from_ad'] = $from_ad;
		$_SESSION['referer'] = stripslashes($site_name);
		unset($site_name);

		if (!defined('INGORE_VISIT_STATS')) {
			visit_stats();
		}
	}

	if (empty($_SESSION['user_id'])) {
		if ($user->get_cookie()) {
			if (0 < $_SESSION['user_id']) {
				update_user_info();
			}
		}
		else {
			$_SESSION['user_id'] = 0;
			$_SESSION['user_name'] = '';
			$_SESSION['email'] = '';
			$_SESSION['user_rank'] = 0;
			$_SESSION['discount'] = 1;

			if (!isset($_SESSION['login_fail'])) {
				$_SESSION['login_fail'] = 0;
			}
		}
	}

	if (isset($_GET['u'])) {
		set_affiliate();
	}

	if (!empty($_COOKIE['ECS']['user_id']) && !empty($_COOKIE['ECS']['password'])) {
		$sql = 'SELECT user_id, user_name, password ' . ' FROM ' . $ecs->table('users') . ' WHERE user_id = \'' . intval($_COOKIE['ECS']['user_id']) . '\' AND password = \'' . $_COOKIE['ECS']['password'] . '\'';
		$row = $db->GetRow($sql);

		if (!$row) {
			$time = time() - 3600;
			setcookie('ECS[user_id]', '', $time, '/', $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
			setcookie('ECS[password]', '', $time, '/', $GLOBALS['cookie_path'], $GLOBALS['cookie_domain']);
		}
		else {
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['user_name'] = $row['user_name'];
			update_user_info();
		}
	}

	if (isset($smarty)) {
		$smarty->assign('ecs_session', $_SESSION);
	}
}

if ((DEBUG_MODE & 1) == 1) {
	error_reporting(32767);
}
else {
	error_reporting(32767 ^ (8 | 2));
}

if ((DEBUG_MODE & 4) == 4) {
	include ROOT_PATH . 'includes/lib.debug.php';
}

if (isset($GLOBALS['_CFG']['template']) && in_array($GLOBALS['_CFG']['template'], $template_array)) {
	define('THEME_EXTENSION', true);
}

if (isset($smarty)) {
	$filename = str_replace('.php', '', basename(PHP_SELF));
	$file_languages = is_array($_LANG['js_languages'][$filename]) ? $_LANG['js_languages'][$filename] : array();
	$merge_js_languages = array_merge($_LANG['js_languages']['common'], $file_languages);
	$json_languages = json_encode($merge_js_languages);
	$smarty->assign('json_languages', $json_languages);
	$smarty->assign('rs_enabled', $_CFG['region_store_enabled']);
}

if(!function_exists('send_pay_msg')){
	function send_pay_msg($order_id){
			$sql_user= 'SELECT user_id,order_sn FROM ' . $GLOBALS['ecs']->table('order_info') . (' WHERE order_id = \'' . $order_id. '\'');
			$sql_data= $GLOBALS['db']->getRow($sql_user);
				if(!empty($sql_data) && $sql_data['pay_status'] !=2){
						$url="https://test-api.artzhe.com/mp/ArtworkGoods/sendMessage";
						$postStr=array(
								'userId'=>$sql_data['user_id'],
								'content'=>'您的商品货号为:'.$sql_data['order_sn'].',支付已完成',
							);
						$post_data=array('param'=>des_encode(json_encode($postStr)));
						curl_request($url,$post_data);
				
				}
	}
}

?>
