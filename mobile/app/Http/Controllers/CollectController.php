<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CollectController extends CommonController{

	public function __construct(Request $request){
		parent::__construct($request);
		if(self::$userid <=1){
			redirect()->to('passport/loginwx')->send();
		}
	}

	public function getMyLikeData(Request $request){
		$input = $request->except(['s','_token']);
		$where = [];
		$where['like_user_id'] = self::$user['id'];
		$where['is_like'] = 'Y';
		$result = \App\Models\ArtworkLike::getPages($where);
		if($result['total']>0){
			foreach ($result['data'] as $key => $value) {
				$result['data'][$key]['artwork'] = \App\Models\Artwork::getArtworkById($value['artwork_id']);
			}
		}
		
		return ['state'=>2000,'data'=>$result];
	}

	public function like(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['artworkid'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$data = ['type'=>1,'artwork_id'=>$input['artworkid'],'like_user_id'=>self::$user['id']];
		$result = \App\Models\ArtworkLike::insertData($data);
		return ['state'=>2000,'data'=>$result];
	}

	public function unlike(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['artworkid'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$result = \App\Models\ArtworkLike::cancel(self::$user['id'],$input['artworkid'],1);
		return ['state'=>2000,'data'=>$result];
	}

	public function statistics(Request $request){
		$input = $request->except(['s','_token']);
		$where = [];
		if(!empty($input['like_user_id'])){
			$where['like_user_id'] = $input['like_user_id'];
		}
		if(!empty($input['artwork_id'])){
			$where['artwork_id'] = $input['artwork_id'];
		}
		$total = \App\Models\ArtworkLike::getCount($where);
		$collect = \App\Models\ArtworkLike::getCount(array_merge(['is_like'=>'Y'],$where));
		$cancel = $total - $collect;
		return ['state'=>2000,'data'=>['total'=>$total,'collect'=>$collect,'cancel'=>$cancel]];
	}
}