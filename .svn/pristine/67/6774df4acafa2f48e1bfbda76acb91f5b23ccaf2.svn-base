<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends CommonController{

	public function __construct(Request $request){
		parent::__construct($request);
		if(self::$userid <=1){
			return redirect()->to('passport/loginwx')->send();
		}
	}

	public function index(Request $request){
		// var_dump(self::$user);
		return view('user.index');
	}

	public  function getArtist(Request $request){
		$input = $request->except(['s','_token']);
		if(isset($input['artistid'])){
			$id = $input['artistid'];
		}else{
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$data = \App\Models\User::getUserById($id);
		$data['view_total'] = 123;
		$data['like_total'] = 134;
		$data['follower_total'] = 789;
		$data['artwork_total'] = 345;
		$data['cover'] = config('app.murl').'/Public/image/gallerydetail/bg.jpg';
		return ['state'=>2000,'data'=>$data];
	}


	public function getInfo(Request $request){
		$input = $request->except(['s','_token']);
		$data = \App\Models\User::getUserById(self::$userid);
		return ['state'=>2000,'data'=>$data];
	}

	public function addUser(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['mobile'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$result = \App\Models\User::addUser($input);
		return ['state'=>2000,'data'=>$result];
	}

	public function modify(Request $request){
		$input = $request->except(['s','_token']);
		$data = \App\Models\User::modify(['id'=>self::$userid],$input);
		return ['state'=>2000,'data'=>$data];
	}

	public function checkPasswd(Request $request){
		$input = $request->except(['s','_token']);
		if( empty($input['passwd'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}

		return \App\Models\User::checkPassword(self::$userid,$input['passwd']);
	}

	public function resetpasswd(Request $request){
		$input = $request->except(['s','_token']);
		$data = \App\Models\User::modify(['id'=>self::$userid],$input);
		return ['state'=>2000,'data'=>$data];
	}
}