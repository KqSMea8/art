<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ArtworkSubject extends Model{

	use ModelHandle;

	protected $table = 'az_artwork_subject';
	public $timestamps = false;

	public static function getSubjectById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getSubjectById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id', 'cn_name', 'en_name', 'sort', 'create_time')->first();
			if(!empty($info)){
				$info = $info->toArray();
			}
			return $info;
		});
	}
}
