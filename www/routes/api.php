<?php

Route::any('/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['web_token'])?'':$cookie['web_token'];
	}

	$url = config('app.apiurl').'/Api/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});