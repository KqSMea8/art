<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use EasyWeChat\Foundation\Application;

class WechatController extends CommonController{
	protected static $app ;

	public function __construct(Request $request){
		parent::__construct($request);
		self::$app = new Application(config('wechat'));
	}

	public function login(Request $request){
		return self::$app->oauth->scopes(['snsapi_userinfo'])->redirect(config('wechat.oath.callback'))->send();
	}

	public function callback(Request $request){
		$input = $request->except(['s','_token']);
		$cookie = $request->cookie();
		if(!empty($input['token'])){
			$token = $input['token'];
			unset($input['token']);
		}else{
			$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
		}
		$user = self::$app->oauth->user();
		$data = $user->getOriginal();
		// \Log::info(date('Y-m-d H:i:s',time()).'wechat_callback回调请求'.var_export($user,true));
		if(empty($data['unionid'])){
			$where = ['type'=>1,'open_id'=>$data['openid']];
		}else{
			$where = ['type'=>1,'union_id'=>$data['unionid']];
		}
		$info = \App\Models\Third::findOne($where);
		if(empty($info)){
			$newid = \App\Models\Third::insertData($data);
			$info = \App\Models\Third::findOne(['id'=>$newid]);
		}

		// \Log::info(date('Y-m-d H:i:s',time()).'token登录的用户信息'.var_export($info,true));

		\App\Models\User::syncloginWithThird($info,$token);

		if(empty($info['bind_user_id'])){
			$request->session()->put('utype', 'wx');
			$request->session()->put('userid', $info['id']);
			return redirect('passport/bind');
		}else{
			$request->session()->put('utype', 'ph');
			$request->session()->put('userid', $info['bind_user_id']);
			$cookie_key = config('app.env').config('app.name').'_HistoryUrl';
			$historyUrl = empty($cookie[$cookie_key])?'index/recommend':$cookie[$cookie_key];
			return redirect($historyUrl);
		}
	}
}