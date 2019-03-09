<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ArtworkTag extends Model{

	use ModelHandle;

	protected $table = 'az_artwork_tag';
	public $timestamps = false;

	public static function getTagById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getTagById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id', 'en_value', 'cn_value', 'create_time')->first();
			if(!empty($info)){
				$info = $info->toArray();
			}
			return $info;
		});
	}
}
