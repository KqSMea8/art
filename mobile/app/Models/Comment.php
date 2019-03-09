<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model{

	use ModelHandle;

	protected $table = 'az_comment';
	public $timestamps = false;

	public static function insertData($input){
		if(empty($input['commenter']) || empty($input['commenter_to'])){
			return ['state'=>3001,'msg'=>'缺少参数'];
		}
		$data = [
			'parent_id' => empty($input['parent_id'])?'0':$input['parent_id'],
			'commenter' => $input['commenter'],
			'commenter_to' => $input['commenter_to'],
			'content' => empty($input['content'])?'':$input['content'],
			'create_time' => time(),
			'topic_id'	 => empty($input['topic_id'])?'Y':$input['topic_id'],
			'type' => empty($input['type'])?'1':$input['type'],
			'delete_time' => 0,
			'level' => empty($input['level'])?'1':$input['level'],
			'is_published' => empty($input['is_published'])?'Y':$input['is_published'],
			'publish_time' => time(),
			'is_deleted' => 'N',
			'like_total' => 0,
		];
		return self::insertGetId($data);
	}

	public static function getComment($topic_id,$type=1){
		$result = [];
		$list = self::where('type',$type)->where('topic_id',$topic_id)->get()->toArray();
		foreach($list as $key=>$value){
			$result[] = ['commenter'=>$value['commenter'],'nickname'=>$value['nickname'],'content'=>$value['content']];
		}
		return $result;
	}

	public static function getTotal($topic_id,$type=1){
		$result = self::where('type',$type)->where('topic_id',$topic_id)->count();
		return $result;
	}

	public static function getLastFace($topic_id,$type=1){
		$result = [];
		$list = self::where('type',$type)->where('topic_id',$topic_id)->orderBy('id','desc')->take(4)->get()->toArray();
		if(!empty($list)){
			foreach($list->toArray() as $key=>$value){
				$result[] = ['commenter'=>$value['commenter'],'nickname'=>$value['nickname'],'content'=>$value['content']];
			}
		}

		return $result;
	}

}
