<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use DB;
use App\Models\Seo;

class IndexController extends Controller{
	public function index()
	{	
		  $result=DB::select("SELECT * FROM az_seo");
		 // // var_dump($result);
	 	  view()->share('result',$result);
	     return view('index/index');
		
	}	
	public function set(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['utype'])){
			if(self::$device->isWechat()){
				$utype = 'wx';
			}else{
				$utype = 'ph';
			}
		}else{
			$utype = $input['utype'];
		}
		$userid = empty($input['userid'])?1:$input['userid'];
		$request->session()->put('utype', $utype);
		$request->session()->put('userid', $userid);

		var_dump("*******redis start***********");
		Redis::set('smscode_'.$input['to'], $input['code']);
		var_dump("*******redis end***********");



//		session('utype',$utype);
//		session('userid',$userid);

		return ['state'=>'2000','msg'=>'success','data'=>['utype'=>$utype,'userid'=>$userid]];
	}

	public function get(Request $request){
		$input = $request->except(['_token','s']);
		$cookie = $request->cookie();
		if(!empty($input['token'])){
			$token = $input['token'];
			unset($input['token']);
		}else{
			$token = empty($cookie['web_token'])?'':$cookie['web_token'];
		}
		var_dump('*********user start***********');
		$utype = session('utype');
		$userid = session('userid');
		var_dump($userid);
		var_dump($utype);
		var_dump('*********user end***********');

		$loginFlag = \App\Models\User::checkLogin($token);
		var_dump($loginFlag);
		var_dump('*********Token start***********');
		var_dump($token);
		var_dump('*********Token end***********');

		var_dump('*********sync start***********');
		$url = config('app.apiurl').'/Api/UserCenter/getMyGalleryDetail?token='.$token;
		$result = httpClient($url,[]);
		var_dump($result);
		var_dump('*********sync end***********');


		$code = Redis::get('smscode_'.$input['to']);
		var_dump($code);

	}

	public function clear(Request $request){
		session('utype',null);
		session('userid',null);
		\Cache::flush();
	}

	public function test(Request $request){
		$input = $request->except(['_token','s']);
		$cookie = $request->cookie();
		if(!empty($input['token'])){
			$token = $input['token'];
			unset($input['token']);
		}else{
			$token = empty($cookie['web_token'])?'':$cookie['web_token'];
		}

		$code = Redis::get('smscode_'.$input['mobile']);
		var_dump($code);
	}
}