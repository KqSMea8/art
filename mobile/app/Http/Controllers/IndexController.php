<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller{

	public function getData(Request $request){
		$input = $request->except(['s','_token']);
		$where = [];

		if(!empty($input['artist'])){
			$where['artist'] = $input['artist'];
		}
		if(!empty($input['owner_id'])){
			$where['owner_id'] = $input['owner_id'];
		}
		if(!empty($input['category'])){
			$where['category'] = $input['category'];
		}
		if(!empty($input['name'])){
			$where['topic_id'] = ['like',$input['name']];
		}

		if(!empty($input['is_read'])){
			$where['is_read'] = $input['is_read'];
		}

		$result = \App\Models\Artwork::getPages($where);
		return ['state'=>2000,'data'=>$result];
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
			$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
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
			$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
		}

		$userid = session('userid');
		$third = \App\Models\Third::getThirdByUserId($userid);

		$result = \App\Models\User::syncloginWithThird($third,$token);
		var_dump($result);
	}
}