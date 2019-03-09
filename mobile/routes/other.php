<?php

Route::any('/V2/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V2/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V20/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V20/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V22/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V22/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V31/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V31/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V32/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V32/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V40/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V40/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V42/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V42/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V43/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V43/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V44/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V44/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V50/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/V50/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/M/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/M/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

