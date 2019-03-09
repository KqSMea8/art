<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFollower extends Model{
	
	use ModelHandle;

	protected $table = 'az_user_follower';
	public $timestamps = false;
	
	public static function insertData($input){
		if(isset($input['follower']) && isset($input['artistid'])){
			$data = [
				'follower' => $input['follower'],
				'user_id' => $input['user_id'],
				'follow_time'=>time(),
				'is_follow' => 'Y',
				'unfollow_time'=>0,
			];
			$newid = self::insertGetId($data);
			return ['state'=>2000,'data'=>$newid];
		}else{
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
	}

	public static function checkFollow($userid,$target){
		$info = self::where('follower',$userid)->where('user_id',$target)->first();
		if(empty($info)){
			return false;
		}else{
			return true;
		}
	}
}