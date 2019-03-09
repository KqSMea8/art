<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ArtworkCategory extends Model{

	use ModelHandle;

	protected $table = 'az_artwork_category';
	public $timestamps = false;

	public static function getCategoryById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getCategoryById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id', 'cn_name', 'en_name', 'sort', 'create_time')->first();
			if(!empty($info)){
				$info = $info->toArray();
			}
			return $info;
		});
	}
}
