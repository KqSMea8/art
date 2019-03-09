<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Config extends Model{

	use ModelHandle;

	protected $table = 'az_config';
	public $timestamps = false;

	public static function getConfigById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getConfigById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id', 'cn_name', 'en_name', 'value', 'create_time', 'update_time', 'creator_id')->first();
			if(!empty($info)){
				$info = $info->toArray();
				$info['value'] = json_decode($info['value'],true);
			}
			return $info;
		});
	}

	public static function getConfigByName($name){
		return \Cache::remember(config('app.env').config('app.name').'_getConfigByName_'.$id, 5, function() use ($id) {
			$info = static::where('en_name',$name)->select('id', 'cn_name', 'en_name', 'value', 'create_time', 'update_time', 'creator_id')->first();
			if(!empty($info)){
				$info = $info->toArray();
				$info['value'] = json_decode($info['value'],true);
			}
			return $info;
		});
	}

}
