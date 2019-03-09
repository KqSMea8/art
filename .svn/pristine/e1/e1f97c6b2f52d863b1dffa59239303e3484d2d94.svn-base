<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model{

	use ModelHandle;

	protected $table = 'az_gallery';
	public $timestamps = false;

	public static function getGalleryById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getGalleryById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id', 'artist', 'tag_ids', 'category_ids', 'cover', 'view_total', 'share_total', 'like_total', 'is_deleted', 'delete_time')->first();
			if(!empty($info)){
				$info = $info->toArray();
				$info['artist'] = \App\Models\User::getUserById($info['artist']);
				$info['tags'] = $info['categorys'] = [];
				if(!empty($info['category_ids'])){
					foreach (explode(',', $info['category_ids']) as $value) {
						$info['categorys'][] = \App\Models\ArtworkCategory::getCategoryById($value);
					}
				}
				if(!empty($info['tag_ids'])){
					foreach (explode(',', $info['tag_ids']) as $value) {
						$info['tags'][] = \App\Models\ArtworkTag::getTagById($value);
					}
				}
			}
			return $info;
		});
	}

	public static function getGalleryByArtist($artist){
		return \Cache::remember(config('app.env').config('app.name').'_getGalleryByArtist_'.$artist, 5, function() use ($artist) {
			$info = static::where('artist',$artist)->select('id', 'artist', 'tag_ids', 'category_ids', 'cover', 'view_total', 'share_total', 'like_total', 'is_deleted', 'delete_time')->first();
			if(!empty($info)){
				$info = $info->toArray();
				$info['artist'] = \App\Models\User::getUserById($info['artist']);
				$info['tags'] = $info['categorys'] = [];
				if(!empty($info['category_ids'])){
					foreach (explode(',', $info['category_ids']) as $value) {
						$info['categorys'][] = \App\Models\ArtworkCategory::getCategoryById($value);
					}
				}
				if(!empty($info['tag_ids'])){
					foreach (explode(',', $info['tag_ids']) as $value) {
						$info['tags'][] = \App\Models\ArtworkTag::getTagById($value);
					}
				}
			}
			return $info;
		});
	}
}
