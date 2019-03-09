<?php

Route::get('discussion/details', 'DiscussionController@details');
Route::get('discussion/details2app', 'DiscussionController@details2app');
Route::get('discussion/detailGraphic', 'DiscussionController@detailGraphic');
Route::get('discussion/discussionList', 'DiscussionController@discussionList');
Route::get('discussion/discussionList2app', 'DiscussionController@discussionList2app');

Route::any('/{param1?}/{param2?}', function(Illuminate\Http\Request $request,$param1='index',$param2='index'){
	$result = [];
	$input = $request->except(['_token','s']);
	$cookie = $request->cookie();
	if(!empty($input['token'])){
		$token = $input['token'];
		unset($input['token']);
	}else{
		$token = empty($cookie['apiToken'])?'':$cookie['apiToken'];
	}

	$url = config('app.apiurl').'/Api/'.$param1.'/'.$param2.'?token='.$token;
	$result = httpClient($url,$input);
	return $result;
});
