<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GalleryController extends CommonController{

	public function detail(Request $request,$artistid){
		$artist = \App\Models\User::getUserById($artistid);
		if($artist['type']!=3){
			return '非艺术家';
		}
		$gallery = \App\Models\Gallery::getGalleryByArtist($artistid);
		// var_dump($artist);die();
		// var_dump($gallery);die();
		$isFollow = \App\Models\UserFollower::checkFollow(self::$user['id'],$artistid);
		return view('gallery.detail')->with('gallery',$gallery)->with('artist',$artist)->with('artistid',$artistid)->with('isFollow',$isFollow);
	}

	public function getData(Request $request){
		$input = $request->except(['s','_token']);
		$where = [];

		if(!empty($input['artist'])){
			$where['artist'] = $input['artist'];
		}

		$result = \App\Models\Gallery::getPages($where);
		return ['state'=>2000,'data'=>$result];
	}

	public function getInfo(Request $request){
		$input = $request->except(['s','_token']);
		if(isset($input['id'])){
			$id = $input['id'];
			unset($input['id']);
		}else{
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$result = \App\Models\Gallery::getGalleryById($id);
		if(!empty($result)){
			$result['isFollow'] = false;
			if(self::$user['id']>1){
				$result['isFollow'] = \App\Models\UserFollower::checkFollow(self::$user['id'],$result['artist']['id']);
			}
		}
//		return view('index.index');
		return ['state'=>2000,'data'=>$result];
	}

	public function statistics(Request $request){
		$input = $request->except(['s','_token']);
		$where = [];

		if(!empty($input['artist'])){
			$where['artist'] = $input['artist'];
		}
		$total = \App\Models\Gallery::getCount($where);
		return ['state'=>2000,'data'=>$total];
	}
}