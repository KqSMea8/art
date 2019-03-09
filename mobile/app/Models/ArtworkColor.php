<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ArtworkColor extends Model{

	use ModelHandle;

	protected $table = 'az_artwork_color';
	public $timestamps = false;

	public static function getColorById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getColorById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id', 'cn_name', 'en_name', 'value')->first();
			if(!empty($info)){
				$info = $info->toArray();
			}
			return $info;
		});
	}
}
