<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;

class PassportController extends CommonController{

	public function logout(Request $request){
		$input = $request->except(['_token','s']);
		$cookie = $request->cookie();
		if(!empty($input['token'])){
			$token = $input['token'];
			unset($input['token']);
		}else{
			$token = empty($cookie['web_token'])?'':$cookie['web_token'];
		}
		$request->session()->put('utype', 'ph');
		$request->session()->put('userid', null);

		\App\Models\User::synclogout([],$token);

		//更新token
		//app('App\Http\Controllers\PublicController')->getToken($request);

		$cookie_key = config('app.env').config('app.name').'_HistoryUrl';
		// $historyUrl = empty($cookie[$cookie_key])?'index/index':$cookie[$cookie_key];
		$historyUrl = 'index/index';
		$cookie = Cookie::forget('userid');
		Cookie::forget('userType');
		Cookie::forget('userid');
		Cookie::forget('userMobile');
		// foreach ($_COOKIE as $key => $value) {
  //       setcookie($key, null);
  //   }
		return redirect($historyUrl)->withCookie($cookie);
	}

	public function checkPhone(Request $request){
		$input = $request->except(['s','_token']);

		if(isset($input['mobile'])){
			$mobile = $input['mobile'];
		}else{
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$data = \App\Models\User::getUserByMobile($mobile);
		if(empty($data)){
			return ['state'=>2000,'msg'=>'手机号不存在'];
		}else{
			return ['state'=>4001,'msg'=>'手机号已存在','data'=>$data];
		}
	}

	public function checkPhoneWithCaptcha(Request $request){
		$input = $request->except(['s','_token']);
		$rules = ['captcha' => 'required|captcha'];
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return ['state'=>4004,'msg'=>'图片验证码错误'];
		}

		if(isset($input['mobile'])){
			$mobile = $input['mobile'];
		}else{
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$data = \App\Models\User::getUserByMobile($mobile);
		if(empty($data)){
			return ['state'=>2000,'msg'=>'手机号不存在'];
		}else{
			return ['state'=>4001,'msg'=>'手机号已存在','data'=>$data];
		}
	}

	public function checkPhoneWithCode(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['mobile']) || empty($input['code'])){
			return ['state'=>3001,'msg'=>'缺失参数'];
		}
		$code = Redis::get('smscode_'.$input['mobile']);
		if(!empty($code)){
			$tmp = json_decode($code,true);
			if(!empty($tmp) && $input['code']==$tmp['code']){
				$data = \App\Models\User::getUserByMobile($input['mobile']);
				if(empty($data)){
					return ['state'=>2000,'msg'=>'手机号不存在'];
				}else{
					return ['state'=>4002,'msg'=>'手机号已存在','data'=>$data];
				}
				return ['state'=>2000,'data'=>$code,'msg'=>'success'];
			}
		}
		return ['state'=>4001,'msg'=>'failed'];
	}

	public function checkBind(Request $request){
		$input = $request->except(['_token','s']);
		$cookie = $request->cookie();
		if(!empty($input['token'])){
			$token = $input['token'];
			unset($input['token']);
		}else{
			$token = empty($cookie['web_token'])?'':$cookie['web_token'];
		}

		if(empty($input['to']) || empty($input['code'])){
			return ['state'=>3001,'msg'=>'缺失参数'];
		}
		if(empty($token)){
			return ['state'=>3002,'msg'=>'token为空'];
		}
		$code = Redis::get('smscode_'.$input['to']);
		if(!empty($code)){
			$tmp = json_decode($code,true);
			if(!empty($tmp) && $input['code']==$tmp['code']){
				$userid = session('userid');
				$olduser = \App\Models\Third::findOne(['id'=>$userid]);
				$encInfo = encryptPassword($input['passwd']);
				$data = [
					'name' => $olduser['name'],
					'nickname' => $olduser['name'],
					'mobile' => $input['to'],
					'gender' => $olduser['gender'],
					'face' => $olduser['face_url'],
					'enc_password' => $encInfo['encryptedPassword'],
					'enc_salt' => $encInfo['salt'],
					'device_info_json' => '{}',
				];
				$newuserid = \App\Models\User::addUser($data);
				if(!empty($newuserid)){
					$flag = \App\Models\Third::modify(['id'=>$olduser['id']],['bind_user_id'=>$newuserid,'bind_time'=>time()]);
					if(empty($flag)){
						return ['state'=>4005,'msg'=>'绑定手机号出错'];
					}

				$result['ext'] = \App\Models\User::synclogin($olduser,$token);

					$request->session()->put('utype', 'ph');
					$request->session()->put('userid', $newuserid);
				}

				return ['state'=>2000,'data'=>$newuserid];
			}
		}
		return ['state'=>4001,'msg'=>'验证码错误'];
	}

	public function checkLogin(Request $request){
		$input = $request->except(['_token','s']);
		$cookie = $request->cookie();
		if(!empty($input['token'])){
			$token = $input['token'];
			unset($input['token']);
		}else{
			$token = empty($cookie['web_token'])?'':$cookie['web_token'];
		}
		if(empty($input['mobile']) || empty($input['passwd'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		if(empty($token)){
			return ['state'=>3002,'msg'=>'token为空'];
		}
		$result = \App\Models\User::checkPassword($input['mobile'],$input['passwd']);
		if($result['state']==2000){
			$user = \App\Models\User::getUserByMobile($input['mobile']);
			$third = \App\Models\Third::getThirdByUserId($user['id']);
			$result['ext'] = \App\Models\User::synclogin($third,$token);

			$request->session()->put('utype', 'ph');
			$request->session()->put('userid', $user['id']);
		}

		return $result;
	}

	public function resetPasswd(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['to']) || empty($input['code']) || empty($input['passwd'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}

		$code = Redis::get('smscode_'.$input['to']);
		if(!empty($code)){
			$tmp = json_decode($code,true);
			if(!empty($tmp) && $input['code']==$tmp['code']){
				$encInfo = encryptPassword($input['passwd']);
				$flag = \App\Models\User::modify(['mobile'=>$input['to']],['enc_password'=>$encInfo['encryptedPassword'],'enc_salt'=>$encInfo['salt']]);
				return ['state'=>2000,'data'=>$flag];
			}
		}
		return ['state'=>4001,'msg'=>'验证码错误'];
	}
}