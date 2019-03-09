<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppController extends CommonController{

	public function index(Request $request){
		// var_dump($users);
		return view('app.index');
	}

	public function download(Request $request){
		if(self::$device->isAndroidOS()){
			header('Location:https://a.app.qq.com/o/simple.jsp?pkgname=com.artzhe');
		}else{
			header('Location:https://itunes.apple.com/cn/app/id1225490675?mt=8');
		}
	}
}