<?php

namespace App\Http\Controllers;

use Log;
use Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CommonController extends Controller{
	protected static $user = null;
	protected static $utype = null;
	protected static $userid = null;

	public function __construct(Request $request){
		parent::__construct($request);
		$this->_init($request);
	}

	public function _init(Request $request){
		$input = $request->except(['_token','s']);
		$cookie = $request->cookie();
		$third = $user = [];
		if(!empty($input['token'])){
			$token = $input['token'];
			unset($input['token']);
		}else{
			$token = empty($cookie['web_token'])?'':$cookie['web_token'];
		}
		self::$userid = session('userid');
		self::$utype = 'ph';
		self::$userid = empty(self::$userid)?1:self::$userid;
		$loginFlag = \App\Models\User::checkLogin($token);
		if(!$loginFlag){
			if(self::$userid > 1){
				$user = \App\Models\User::getUserById(self::$userid);
				$third = \App\Models\Third::getThirdByUserId(self::$userid);
				\App\Models\User::synclogin($third,$token);
			}
		}else{
			$res = \App\Models\User::getUserAsync($token);
			if(isset($res['code'])&&$res['code']==30000&&isset($res['data']['status']) && $res['data']['status']==1000){
				self::$utype = 'ph';
				self::$userid = $res['data']['info']['artist'];
				$request->session()->put('utype', self::$utype);
				$request->session()->put('userid', self::$userid);
				$user = \App\Models\User::getUserById(self::$userid);
				$third = \App\Models\Third::getThirdByUserId(self::$userid);
			}
		}
		
		$user_data = \Cache::get( config('app.env').'_'.config('app.name').'_user_'.self::$utype.'_'.self::$userid);
		if(empty($user_data) && !empty($user)) {
			$user_data = $user;
			\Cache::put( config('app.env').'_'.config('app.name').'_user_'.self::$utype.'_'.self::$userid,$user_data);
		}
		self::$user = $user_data;
		view()->share('user',self::$user);
	}
}