<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
	
	use ModelHandle;

	protected $table = 'az_user';
	public $timestamps = false;

	public static function getArtistById($id){
		$info = self::getUserById($id);
		$result = [];
		$result['id'] = $info['id'];
		$result['name'] = $info['name'];
		$result['face'] = $info['face'];
		$result['follower_total'] = $info['follower_total'];
		$result['art_total'] = $info['art_total'];
		$result['motto'] = $info['motto'];
		return $result;
	}

	public static function getUserByMobile($phone){
		return \Cache::remember(config('app.env').config('app.name').'_getUserByPhone_'.$phone, 5, function() use ($phone) {
			$info = static::where('mobile',$phone)->select('id', 'name', 'en_name', 'nickname', 'account', 'motto', 'resume', 'birthday', 'age', 'category', 'gender', 'face', 'email', 'id_card_no', 'qq', 'wechat', 'mobile', 'telephone', 'level', 'ip', 'longitude', 'latitude', 'mp', 'is_deleted', 'login_times', 'banned_to', 'from', 'type', 'device_info_json', 'last_login_time', 'update_time', 'create_time', 'follower_total', 'follow_total', 'art_total', 'last_update_time', 'invite_total', 'cover')->first();
			if(!empty($info)){
				$info = $info->toArray();
			}
			return $info;
		});
	}

	public static function getUserById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getUserById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('id', 'name', 'en_name', 'nickname', 'account', 'motto', 'resume', 'birthday', 'age', 'category', 'gender', 'face', 'email', 'id_card_no', 'qq', 'wechat', 'mobile', 'telephone', 'level', 'ip', 'longitude', 'latitude', 'mp', 'is_deleted', 'login_times', 'banned_to', 'from', 'type', 'device_info_json', 'last_login_time', 'update_time', 'create_time', 'follower_total', 'follow_total', 'art_total', 'last_update_time', 'invite_total', 'cover')->first();
			if(!empty($info)){
				$info = $info->toArray();
			}
			return $info;
		});
	}

	public function getFaceById($id){
		return \Cache::remember(config('app.env').config('app.name').'_getFaceById_'.$id, 5, function() use ($id) {
			$info = static::where('id',$id)->select('face')->first();
			if(!empty($info)){
				$info = $info->toArray();
			}
			return $info['face'];
		});
	}


	public static function checkPassword($mobile, $password){
		$info = self::where('mobile',$mobile)->first();
		if(empty($info)){
			return ['state'=>4001,'msg'=>'手机号不存在'];
		}else{
			$info = $info->toArray();
			if($info['is_deleted']=='Y'){
				return ['state'=>4002,'msg'=>'用户已经注销'];
			}
			$encInfo = encryptPassword($password, $info['enc_salt']);
			if ($info['enc_password'] == $encInfo['encryptedPassword']){
				return ['state'=>2000,'msg'=>'success'];
			}else{
				return ['state'=>4003,'msg'=>'密码错误'];
			}
		}
	}

	public static function addUser($input){
		$data = [
            'name' => empty($input['name'])?'':$input['name'],
            'nickname' => empty($input['nickname'])?'':$input['nickname'],
            'mobile' => empty($input['mobile'])?'':$input['mobile'],
            'motto'=>empty($input['motto'])?'':$input['motto'],
            'resume'=>empty($input['resume'])?'':$input['resume'],
            'gender' => empty($input['gender'])?'3':$input['gender'],
            'face' => empty($input['face'])?'':$input['face'],
            'category'=>'',
            'enc_password' => empty($input['enc_password'])?'':$input['enc_password'],
            'enc_salt' => empty($input['enc_salt'])?'':$input['enc_salt'],
            'email'=>empty($input['email'])?'':$input['email'],
            'qq'=>empty($input['qq'])?'':$input['qq'],
            'level'=>empty($input['level'])?'1':$input['level'],
            'mp'=>empty($input['mp'])?'0':$input['mp'],
			'cover'=>'',
            'device_info_json' => empty($input['device_info_json'])?'{}':$input['device_info_json'],
            'ip' => get_client_ip(1),
            'login_times' => 1,
            'from' => 'h5',
            'last_login_time' => $_SERVER['REQUEST_TIME'],
			'last_update_time' => $_SERVER['REQUEST_TIME'],
            'update_time' => $_SERVER['REQUEST_TIME'],
            'create_time' => $_SERVER['REQUEST_TIME'],
        ];
        $newid = self::insertGetId($data);
        return $newid;
	}

	public static function syncloginWithThird($third,$token){
		$url = config('app.apiurl').'/Api/user/login?token='.$token;
		$temp = [
			'partnerCode'=>'WECHAT',
			'openId'=>$third['open_id'],
			'unionId'=>"",
			'nickname'=>$third['nickname'],
			'gender'=>$third['gender'],
			'faceUrl'=>$third['face_url'],
		];
		$data = ['thirdInfo'=>json_encode($temp)];
		return httpClient($url,$data);
	}

	public static function syncloginWithPasswd($mobile,$password,$token){
		$url = config('app.apiurl').'/Api/user/accountLogin?from=h5&token='.$token;
		$data = [
			'mobile'=>$mobile,
			'password'=>$password,
		];
		return httpClient($url,$data);
	}

	public static function getUserAsync($token){
		$url = config('app.apiurl').'/Api/UserCenter/getMyGalleryDetail?token='.$token;
		return httpClient($url,[]);
	}

	public static function checkLogin($token){
		$url = config('app.apiurl').'/Api/user/isLoging?token='.$token;
		$data = [];
		$result = false;
		$res = httpClient($url,$data);
		if(isset($res['code'])&& $res['code']==30000&&$res['data']['status']==1000){
			$result = true;
		}

		return $result;
	}

	public static function synclogout($data,$token){
		$url = config('app.apiurl').'/Api/user/logout?token='.$token;
		return httpClient($url,$data);
	}
	
}