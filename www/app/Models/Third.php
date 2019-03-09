<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Third extends Model{
	
	use ModelHandle;

	protected $table = 'az_third';
	public $timestamps = false;
	
	public static function insertData($input){
		$data = [
			'type' => 1,
			'open_id' => $input['openid'],
			'union_id' => empty($input['unionid'])?'':$input['unionid'],
			'bind_user_id' => 0,
			'nickname' => $input['nickname'],
			'name'	 => $input['nickname'],
			'gender' => $input['sex'],
			'face_url' => $input['headimgurl'],
			'country' => $input['country'],
			'province' => $input['province'],
			'city' => $input['city'],
			'third_full_json' => json_encode($input),
			'state' => empty($input['state'])?2:$input['state'],
			'create_time'=>$_SERVER['REQUEST_TIME'],
			'bind_time' => 0,
		];
		return self::insertGetId($data);
	}

	public static function getThirdByUserId($userid){
		$result = self::where('bind_user_id',$userid)->where('is_unbind','N')->where('state',2)->first();
		if(!empty($result)){
			$result = $result->toArray();
		}
		return $result;
	}
}