<?php

if (! function_exists('toDate')) {
	function toDate($time,$format='Y-m-d H:i:s'){
		if( empty($time)){
			return '';
		}

		$format = str_replace('#',':',$format);
		return date($format,$time);
	}
}

if (! function_exists('del0')) {
	function del0($s){
		$s = trim(strval($s));
		if (preg_match('#^-?\d+?\.0+$#', $s)) {
			return preg_replace('#^(-?\d+?)\.0+$#','$1',$s);
		}
		if (preg_match('#^-?\d+?\.[0-9]+?0+$#', $s)) {
			return preg_replace('#^(-?\d+\.[0-9]+?)0+$#','$1',$s);
		}
		return $s;
	}
}

if (! function_exists('deldir')) {
	function deldir($dir) {
		if ($handle = opendir("$dir")) {
			while (false !== ($item = readdir($handle))) {
				if ($item != "." && $item != "..") {
					if (is_dir("$dir/$item")) {
						deldir("$dir/$item");
					} else {
						@unlink("$dir/$item");
					}
				}
			}
			closedir($handle);
			@rmdir($dir);
		}
	}
}




if (! function_exists('getUser')) {
	function getUser($mid) {
		$user = \Cache::get( config('app.env').'_'.config('app.name').'_user_'.$mid );
		if(empty($user)){
			$user = \App\Models\Member::where('mid',$mid)->first();
			if(!empty($user)){
				$user = $user->toArray();
			}
			\Cache::put( config('app.env').'_'.config('app.name').'_user_'.$mid, $user, 120 );
		}
		return $user;
	}
}

if(! function_exists('handle')){
	function handle($action, $params=null) {
		$model = $controller = $method = '';
		if(!empty($action)){
			list($model,$controller,$method) = explode('@',$action);
		}

		//记录log日志
		$log_data = ['action'=>$action,'parm'=>json_encode($params),'time'=>time(),'flag'=>'1','state'=>'1','status'=>'1'];
		$Log = new \App\Models\Log();
		$Log->checkTable('Ym');
		$Log->insertGetId($log_data);


		if(empty($model) || empty($controller) || empty($method)){
			return ['state'=>8001,'msg'=>'参数为空'];
		}
		if ($model==config('app.name')){
			if(strpos($controller,'Http')!==false){
				$class = $controller;
			}else{
				$class = 'App\\Http\\Controllers\\'.ucfirst(strtolower($controller)).'Controller';
			}
			if (class_exists($class)) {
				$model = new $class();
				if(method_exists($class, $method)){
					if(is_null($params)){
						$result = $model->$method();
					}else{
						$result = $model->$method($params);
					}

					if( $result instanceof \Illuminate\View\View){
						return $result;
					}
				}
			}

		}else{
			$url = "/{$controller}/{$method}";
			$res = request_get($model,$url,$params,$request);
			if(!empty($res)){
				if(strpos($res,'{')===0 && strpos($res,'}')!==false){
					$result = json_decode($res,true);
				}else{
					$result = $res;
				}
			}else{
				$result = [];
			}
		}

		return $result;
	}
}

if (! function_exists('request_get')) {
	function request_get($module,$url,$param=null){
		$model = new \App\Servers\Transport('user');
		if(strpos($url,'http')===false){
			$target = config('app.'.$module.'api').$url;
		}else{
			$target = $url;
		}
		if(!is_null($param)){
			$params = ArrayToString($param);
			$params['token'] = des_encode(json_encode($params));
			$str = http_build_query($params);
			if(strpos($target,'?')!==false){
				$target = $target.'&'.$str;
			}else{
				$target = $target.'?'.$str;
			}
		}
		$target = str_replace('https://', 'http://', $target);
		// \Log::info(config('app.name').'请求request_get外部：'.date('Y-m-d H:i:s',time()).';请求：'.url()->full(),$request->all());
		return $model->getUrl($target);
	}
}

if (! function_exists('ArrayToString')) {
	function ArrayToString($req=array()){
		array_walk($req, function (&$value, $key) {
			if(is_array($value)){
				$value = ArrayToString($value);
			}else{
				$value = strval($value);
			}
		});
		return $req;
	}
}

if (! function_exists('generateRandomCode')) {
	function generateRandomCode($length = 4, $type= 'number'){
		$code = '';
		if ($type === 'number') {
			$code = mt_rand(pow(10, $length - 1), pow(10, $length) - 1);
		} else {
			$list = [];
			for ($i = 0; $i <= 9; $i++) {
				$list[] = $i;
			}
			for ($j = ord('a'); $j <= ord('z'); $j++) {
				$list[] = chr($j);
			}
			for ($j = ord('A'); $j <= ord('Z'); $j++) {
				$list[] = chr($j);
			}
			$listLength = count($list);
			for ($i = 0; $i < $length; $i++) {
				$code .= $list[mt_rand(0, $listLength - 1)];
			}
		}
		return $code;
	}
}

if (! function_exists('encryptPassword')) {
	function encryptPassword($password, $salt = null){
		if (empty($salt)) {
			$ret['salt'] = generateRandomCode(12, null);
		} else {
			$ret['salt'] = $salt;
		}
		$ret['encryptedPassword'] = \App\Servers\Xxtea::encrypt($password, $ret['salt'].config('app.encode_key'));
		$ret['encryptedPassword'] = base64_encode($ret['encryptedPassword']);
		return $ret;
	}
}
if (! function_exists('get_client_ip')) {
	function get_client_ip($type = 0,$adv=false) {
		$type       =  $type ? 1 : 0;
		static $ip  =   NULL;
		if ($ip !== NULL) return $ip[$type];
		if($adv){
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				$pos    =   array_search('unknown',$arr);
				if(false !== $pos) unset($arr[$pos]);
				$ip     =   trim($arr[0]);
			}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$ip     =   $_SERVER['HTTP_CLIENT_IP'];
			}elseif (isset($_SERVER['REMOTE_ADDR'])) {
				$ip     =   $_SERVER['REMOTE_ADDR'];
			}
		}elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$ip     =   $_SERVER['REMOTE_ADDR'];
		}
	    // IP地址合法验证
		$long = sprintf("%u",ip2long($ip));
		$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
		return $ip[$type];
	}
}

if (! function_exists('generateSignature')) {
	function generateSignature($time, $nonce, $key){
		if ($key === null) {
			$key = 'artzhe_'.date('Ymd');
		}
		return md5(md5($time).md5($key).md5($key.$time.$nonce.$key));
	}
}

if (! function_exists('checkSignature')) {
	function checkSignature($time, $nonce, $key, $signature){
		$sign =  Util::generateSignature($time, $nonce, $key);
		return ($sign === $signature);
	}
}


if (! function_exists('httpClient')) {
	function httpClient($url,$data=[],$header=[]){
		$snoopy=new \Snoopy\Snoopy();
		$time = empty($header["X-Artzhe-Time"])?time():$header["X-Artzhe-Time"];
		$nonce = empty($header["X-Artzhe-Time"])?date('YmdHis',time()):$header["X-Artzhe-Time"];
		if(empty($header["X-Artzhe-Time"])&&empty($header["X-Artzhe-Time"])){
			$sign = generateSignature($time,$nonce,null);
		}else{
			$sign = $header["X-Artzhe-Sign"];
		}
		$snoopy->rawheaders["X-Artzhe-Time"] = $time;
		$snoopy->rawheaders["X-Artzhe-Nonce"] = $nonce;
		$snoopy->rawheaders["X-Artzhe-Sign"] = $sign;
		$result = $snoopy->submit($url,$data);
		// \Log::info(date('Y-m-d H:i:s',time()).'请求外部接口：'.$url.';请求数据：'.var_export($data,true).';请求结果：'.var_export($snoopy->results,true));
		//// \Log::info(config('app.name').'请求request_get外部：'.date('Y-m-d H:i:s',time()).';请求：'.url()->full(),$request->all());
		$result = $snoopy->results;
		$temp = json_decode($result,true);
		if(!empty($temp) && is_array($temp)){
			$result = $temp;
		}
		return $result;
	}
}

if (! function_exists('strquote')) {
	function strquote($string){
		$string = addslashes($string);
		$string = str_replace("\r\n", " ", $string);
		$string = str_replace("\r", " ", $string);
		$string = str_replace("\n", " ", $string);
		return $string;
	}
}

function generateUid()
{
    mt_srand((double)microtime()*10000);
    return  strtoupper(md5($_SERVER['REMOTE_ADDR'].uniqid(rand(), true)));
}