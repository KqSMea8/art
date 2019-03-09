<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Assets extends Model{

	use ModelHandle;

	protected $table = 'az_assets';
	public $timestamps = false;


	public static function getURLById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getURLById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->first();
			if(!empty($info)){
				$info = $info->toArray();
				$result = 'https://'.$info['bucket'].'.oss-cn-shenzhen.aliyuncs.com/'.$info['object'];
				return $result;
			}else{
				return '';
			}
		});
	}

}
