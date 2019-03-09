<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArtworkController extends CommonController{

	public function detail(Request $request,$artworkid){
		$artwork = \App\Models\Artwork::getArtworkById($artworkid);
		// var_dump($artwork);die();
		return view('artwork.detail')->with('artwork_json',json_encode($artwork))->with('artwork',$artwork)->with('artworkid',$artworkid);
	}
	public function update(Request $request,$updateid){
		$artwork = \App\Models\ArtworkUpdate::getArtworkUpdateById($updateid);
		// var_dump($artwork);die();
		return view('artwork.update')->with('artwork_json',json_encode($artwork))->with('artwork',$artwork)->with('$updateid',$updateid);
	}

	public function messageboard(Request $request,$artworkid){
		$artwork = \App\Models\Artwork::getArtworkById($artworkid);
		return view('artwork.messageboard')->with('artwork_json',json_encode($artwork))->with('artwork',$artwork)->with('artworkid',$artworkid);
	}

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
		if($result['total']>0){
			foreach ($result['data'] as $key => $value) {
				$result['data'][$key]['artist'] = \App\Models\User::getArtistById($value['artist']);
				$result['data'][$key]['owner'] = \App\Models\User::getUserById($value['owner_id']);
			}
		}
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
		$result = \App\Models\Artwork::getArtworkById($id);
		return ['state'=>2000,'data'=>$result];
	}

	public function getArtworkDetail(Request $request){
		$input = $request->except(['s','_token']);
		$result = [];
		if(empty($input['artworkid'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$info = \App\Models\Artwork::getArtworkById($input['artworkid']);
		if(!empty($info)){
			$info['comment_total'] = \App\Models\Comment::getTotal($input['artworkid']);
			$info['comment_faces'] = \App\Models\Comment::getLastFace($input['artworkid']);
			$info['updateList'] = \App\Models\ArtworkUpdate::getList(['artwork_id'=>$input['artworkid']]);
			if(self::$user['id']>1){
				$info['publisher']['isFollow'] = \App\Models\UserFollower::checkFollow(self::$user['id'],$input['artworkid']);
			}else{
				$info['publisher']['isFollow'] = false;
			}
			$info['isLike'] = \App\Models\ArtworkLike::checkLike(self::$user['id'],$input['artworkid'],1);
		}
		$result = $info;
		return ['state'=>2000,'data'=>$result];
	}

	public function getUpdates(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['artworkid'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$where = ['artwork_id'=>$input['artworkid']];
		$result = \App\Models\ArtworkUpdate::getPages($where);
		return ['state'=>2000,'data'=>$result];
	}
}