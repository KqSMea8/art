<?php

Route::any('/V2/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['web_token'])?'':$cookie['web_token'];
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
		$token = empty($cookie['web_token'])?'':$cookie['web_token'];
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
		$token = empty($cookie['web_token'])?'':$cookie['web_token'];
	}

	$url = config('app.apiurl').'/V22/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});

Route::any('/V30/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['web_token'])?'':$cookie['web_token'];
	}

	$url = config('app.apiurl').'/V30/'.$param1.'/'.$param2.'?token='.$token;
	if($param1.'/'.$param2=='Attachments/MyListForUeditor'){//在线编辑器 图片库列表
        $url = config('app.apiurl').'/V30/'.$param1.'/'.$param2.'?token='.$token.'&start='.$_GET['start'].'&size='.$_GET['size'];
    }
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
        $token = empty($cookie['web_token'])?'':$cookie['web_token'];
    }

    $url = config('app.apiurl').'/V31/'.$param1.'/'.$param2.'?token='.$token;
    if($param1.'/'.$param2=='Attachments/MyListForUeditor'){//在线编辑器 图片库列表
        $url = config('app.apiurl').'/V31/'.$param1.'/'.$param2.'?token='.$token.'&start='.$_GET['start'].'&size='.$_GET['size'];
    }
    $result = httpClient($url,$input);
    return $result;
});

Route::any('/mp/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['web_token'])?'':$cookie['web_token'];
	}

	$url = config('app.apiurl').'/mp/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});