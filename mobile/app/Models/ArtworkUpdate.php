<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ArtworkUpdate extends Model{

	use ModelHandle;

	protected $table = 'az_artwork_update';
	public $timestamps = false;


	public static function getArtworkUpdateById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getArtworkUpdateById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id','artist', 'artwork_id', 'number', 'wit', 'cover', 'is_cover_show', 'summary', 'is_deleted', 'last_update_time', 'create_date', 'create_time', 'like_total', 'view_total', 'comment_total', 'share_total', 'edit_count')->first();
			if(!empty($info)){
				$info = $info->toArray();
				$info['artwork'] = \App\Models\Artwork::getArtworkById($info['artwork_id']);
			}
			return $info;
		});
	}
}
