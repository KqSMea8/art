<?php
Route::get('WechatLicense/callback', 'WechatLicenseController@callback');


Route::any('/{param1?}/{param2?}/{param3?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index',$param3=null){
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();

	if(!in_array(strtolower($param1),['public','passport','wechat'])){
		cookie()->queue(config('app.env').config('app.name').'_HistoryUrl',url()->full(),99999,null,config('app.domain'),false,false);
		// \Log::info(date('Y-m-d H:i:s',time()).'当前请求记录cookie：'.url()->full(),$input);
	}else{
		// \Log::info(date('Y-m-d H:i:s',time()).'当前请求记录cookie：'.url()->full(),$input);
	}

	
	// app h5请求
	//直接覆盖apiToken
	if (! empty($input['h5_token'])) {
	    $h5_token = $input['h5_token'];
	    if (preg_match("/^[A-Z0-9]{32}$/", $h5_token)) { // token格式判断
	        \Cookie::queue('apiToken', $h5_token, $minutes = 9999, $path = null, $domain = null, $secure = false, $httpOnly = true);
	    }
	}
	// app h5请求 end



	//获取系统参数
	$syslist = \Cache::get( config('app.env').'_'.config('app.name').'_syslist' );
	if(empty($syslist)){
		$list = \App\Models\Sysparam::get()->toArray();
		foreach($list as $item){
			$syslist[$item['name']] = $item;
		}
		\Cache::put( config('app.env').'_'.config('app.name').'_syslist', $syslist, 120 );
	}
	view()->share('syslist',$syslist);


    $device = new Mobile_Detect();//  包"mobiledetect/mobiledetectlib" Mobile_Detect

    /*if(!$device->isMobile()){//不是手机跳转www
        $url = config('app.wwwurl').'/';
        header('Location:'.$url);
        exit;
    }*/

	//获取用户信息

	$third = $user = [];
		if(!empty($input['token'])){
			$token = $input['token'];
			unset($input['token']);
		}else{
			$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
		}
		$utype = session('utype');
		$userid = session('userid');
		$device = new \Utils\UserAgent();
		if(empty($utype)){
			if($device->isWechat()){
				$utype = 'wx';
			}else{
				$utype = 'ph';
			}
		}
		$userid = empty($userid)?1:$userid;
		$loginFlag = \App\Models\User::checkLogin($token);
		if(!$loginFlag){
		    //取消自动判断登陆
// 			if($userid > 1){
// 				if ($utype=='wx') {
// 					$third = \App\Models\Third::findOne(['id'=>$userid]);
// 					$user = $third;
// 				}elseif($utype=='ph'){
// 					$user = \App\Models\User::getUserById($userid);
// 					$third = \App\Models\Third::getThirdByUserId($userid);
// 				}
// 				\App\Models\User::syncloginWithThird($third,$token);
// 			}
		}else{
			$res = \App\Models\User::getUserAsync($token);
			if(isset($res['code'])&&$res['code']==30000&&isset($res['data']['status']) && $res['data']['status']==1000){
				$utype = 'ph';
				$userid = $res['data']['info']['artist'];
				$request->session()->put('utype', $utype);
				$request->session()->put('userid', $userid);
				$user = \App\Models\User::getUserById($userid);
				$third = \App\Models\Third::getThirdByUserId($userid);
			}
		}
		
		$user_data = \Cache::get( config('app.env').'_'.config('app.name').'_user_'.$utype.'_'.$userid);
		if(empty($user_data) && !empty($user)) {
			$user_data = $user;
			\Cache::put( config('app.env').'_'.config('app.name').'_user_'.$utype.'_'.$userid,$user_data);
		}
		$user = $user_data;
		

	view()->share('user',$user);

	//获取微信分享
	$app = new \EasyWeChat\Foundation\Application(config('wechat'));
	$apilist = ['onMenuShareQQ','onMenuShareTimeline','onMenuShareAppMessage','previewImage'];
	$wechat_array = $app->js->getConfigArray($apilist, $debug = false, $beta = false);
	$wechat_json = $app->js->config($apilist, $debug = false, $beta = false, $json = true);
	// var_dump($wechat_json);die();
	// $wechat_array = [];
	// $wechat_json = '';
	view()->share('wechat_array',$wechat_array);
	view()->share('wechat_json',$wechat_json);

	$class = 'App\\Http\\Controllers\\'.ucfirst(strtolower($param1)).'Controller';
	if(class_exists($class)){
		$classObject = new $class($request);
		if(method_exists($classObject, $param2)){
			if(is_null($param3)){
				return $classObject->$param2($request);
			}else{
				return $classObject->$param2($request,$param3);
			}
		}
	}else{
		$class = 'App\\Http\\Controllers\\Controller';
		$classObject = new $class($request);
	}

	if(\View::exists($param1.'.'.$param2)){
		return view($param1.'.'.$param2);
	}

	return abort(404);
});