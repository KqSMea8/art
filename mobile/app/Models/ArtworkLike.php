<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ArtworkLike extends Model{

	use ModelHandle;

	protected $table = 'az_artwork_like';
	public $timestamps = false;

	public static function insertData($input){
		if(isset($input['type']) && isset($input['artwork_id']) && isset($input['like_user_id'])){
			$data = [
				'type'=>$input['type'],
				'artwork_id' => $input['artwork_id'],
				'like_user_id' => $input['like_user_id'],
				'like_time'=>time(),
				'is_like' => 'Y',
				'unlike_time'=>0,
			];
			$newid = self::insertGetId($data);
			return ['state'=>2000,'data'=>$newid];
		}else{
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
	}

	public static function checkLike($userid,$artworkid,$type=1){
		$info = self::where('artwork_id',$artworkid)->where('type',$type)->where('like_user_id',$userid)->first();
		if(empty($info)){
			return false;
		}else{
			return true;
		}
	}

	public static function cancel($userid,$artworkid,$type=1){
		$info = self::where('artwork_id',$artworkid)->where('type',$type)->where('like_user_id',$userid)->update(['is_like'=>'N','unlike_time'=>time()]);
		if(empty($info)){
			return false;
		}else{
			return true;
		}
	}
}
