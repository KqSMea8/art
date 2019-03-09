<?php

namespace App\Models;

trait  ModelHandle {

	public static function findOne($where,$order='id desc'){
		$model = self::whereNotNull('id');
		$model = self::where_clause($model,$where);
		$model = self::orderby_clause($model,$order);
		$result = $model->first();
		if(!empty($result)){
			$result = $result->toArray();
		}
		return $result;
	}

	public static function getList($where=[],$order='id desc',$limit=0){
		$model = self::whereNotNull('id');
		$list = self::getListWithModel($model,$where,$order,$limit)->get();
		if(!empty($list)){
			$list = $list->toArray();
		}
		return $list;
	}

	public static function getPages($where=[],$order='id desc',$limit=0,$size=8){
		$model = self::whereNotNull('id');
		return self::getListWithModel($model,$where,$order,$limit)->paginate($size)->toArray();
	}
	
	public static function getCount($where,$field='id'){
		// \DB::connection()->enableQueryLog();
		$model = self::whereNotNull('id');
		$result = $result = self::where_clause($model,$where)->count();
		// var_dump(\DB::getQueryLog());die();
		return $result;
	}

	public static function getTotal($where,$field='quantity'){
		// \DB::connection()->enableQueryLog();
		$model = self::whereNotNull('id');
		$result = $result = self::where_clause($model,$where)->sum($field);
		// var_dump(\DB::getQueryLog());die();
		return $result;
	}

	public static function getListWithModel(\Illuminate\Database\Eloquent\Builder $model,$where=[],$order='id desc',$limit=0){
		$model = self::where_clause($model,$where);
		$model = self::orderby_clause($model,$order);
		$model = self::limit_clause($model,$limit);
		return $model;
	}

	public static function modify($where,$data){
		// \DB::connection()->enableQueryLog();
		$model = self::whereNotNull('id');
		$result = self::where_clause($model,$where)->update($data);
		// var_dump(\DB::getQueryLog());die();
		return $result;
	}

	protected static function where_clause(\Illuminate\Database\Eloquent\Builder $model,$where=[]){
		if(!empty($where) && is_array($where)){
			foreach ($where as $k1 => $v1) {
				if(is_array($v1)){
					switch ($v1['operator']) {
						case 'in':
							$model = $model->whereIn($k1,explode(',', $v1['value']));
							break;
						case 'between':
							$model = $model->whereBetween($k1,$v1['value']);
							break;
						case 'like':
							$model = $model->where($k1,'like','%'.$v1['value'].'%');
							break;
						default:
							$model = $model->where($k1,$v1['operator'],$v1['value']);
							break;
					}
				}else{
					if(in_array($k1, ['name','subject','option','label','title'])){
						$model = $model->where($k1,'like','%'.$v1.'%');
					}else{
						$model = $model->where($k1,$v1);
					}
				}
			}
		}

		return $model;
	}

	protected static function orderby_clause(\Illuminate\Database\Eloquent\Builder $model,$order){
		if(!empty($order)){
			if(is_string($order)){
				$temp = explode(',', $order);
				$tmp = [];
				foreach ($temp as $k2 => $v2) {
					list($order,$sort) = explode(' ', $v2);
					$tmp[] = ['order'=>$order,'sort'=>$sort];
				}
				$order = $tmp;
			}
			if(is_array($order)){
				foreach ($order as $k3 => $v3) {
					$model = $model->orderBy($v3['order'],$v3['sort']);
				}
			}
		}else{
			$model = $model->orderBy('id','desc');
		}
		return $model;
	}

	protected static function limit_clause(\Illuminate\Database\Eloquent\Builder $model,$limit){
		if(!empty($limit)){
			if(is_string($limit) && strpos($limit, ',')!==false){
				$limit = explode(',', $limit);
			}
			if(is_numeric($limit)){
				$limit = [0,$limit];
			}
			if(is_array($limit)){
				list($skip,$take) = $limit;
				$model = $model->skip($skip)->take($take);
			}
		}
		return $model;
	}

	protected static function getunid($object){
		$result = '';
		if(is_array($object)){
			$result = md5(json_encode($object));
		}elseif (is_object($object)) {
			$result = md5($object->toString());
		}else{
			$result = md5($object);
		}
		return $result;
	}
}