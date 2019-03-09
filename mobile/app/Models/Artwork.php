<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model{

	use ModelHandle;

	protected $table = 'az_artwork';
	public $timestamps = false;

	public static function getArtworkById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getArtworkById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id', 'artist', 'owner_id', 'category', 'name', 'length', 'width', 'color_ids', 'cover', 'panorama_ids', 'topography_ids', 'story', 'subject_ids', 'style_ids', 'tag_ids', 'create_time', 'last_update_time', 'update_times', 'price', 'state', 'is_finished', 'is_for_sale', 'is_deleted', 'like_total', 'view_total')->first();
			if(!empty($info)){
				$info = $info->toArray();
				$info['publisher'] = \App\Models\User::getArtistById($info['artist']);
				$info['category'] = \App\Models\ArtworkCategory::getCategoryById($info['category']);
				if(!empty($info['category'])){
					if($info['is_finished']=='Y'){
						$info['category_name'] = $info['category']['cn_name'].'/'.$info['length'].'cmX'.$info['width'].'cm';
					}else{
						$info['category_name'] = $info['category']['cn_name'];
					}
				}else{
					$info['category_name'] = '';
				}
				$info['coverList'] = array_merge([$info['cover']],$info['panorama_ids'] ? explode(',',$info['panorama_ids']) : [],$info['topography_ids'] ? explode(',',$info['topography_ids']) : []);
				$info['subjects'] = $info['tags'] = $info['styles'] = [];
				if(!empty($info['subject_ids'])){
					foreach (explode(',', $info['subject_ids']) as $value) {
						$info['subjects'][] = \App\Models\ArtworkSubject::getSubjectById($value);
					}
				}
				if(!empty($info['style_ids'])){
					foreach (explode(',', $info['style_ids']) as $value) {
						$info['styles'][] = \App\Models\ArtworkStyle::getStyleById($value);
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
