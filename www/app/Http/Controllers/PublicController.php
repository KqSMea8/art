<?php

namespace App\Http\Controllers;

use OSS\OssClient;
use OSS\Core\OssException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Utils\AliyunDysms;

class PublicController extends Controller{
    
    public function ossH5uploadjsForm($request){
        $userid = (int)$request->session()->get('userid');
        if($userid<=0){
            exit;
        }
        $to_tag = $request->input('to_tag');
        return view('upload.ossH5uploadjsForm',['to_tag'=>$to_tag]);
    }
    //获取阿里云服务器对应信息 H5 js上传
    public function getOssH5UploadServer($request){
        $userid = (int)$request->session()->get('userid');
        if($userid<=0){
            return response()->json(['success' => false,'data' => []]);
        }
        $user_dir = $this->user_file_dir($userid);
        
        $id= config('services.alioss.appId');
        $key= config('services.alioss.appKey');
        $host = 'https://'.config('services.alioss.bucket').'.'.config('services.alioss.host');
        
        $callbackUrl = env('OssSts_callbackUrl');
        
        $callback_param = array('callbackUrl'=>$callbackUrl,
            'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}&bucket='.config('services.alioss.bucket').'&client_info=web&is_test='.env('OssSts_is_test'),
            'callbackBodyType'=>"application/x-www-form-urlencoded");
        
        $callback_string = json_encode($callback_param);
        $base64_callback_body = base64_encode($callback_string);
        $now = time();
        $expire = 60; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);
        
        //        $dir = 'uploads/'.date('Y-m-d').'/';
        $dir = $user_dir.'/' . date('Y') . '/' . date('m') . '/' . date('d') .'/';
        
        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1024*1024*20);
        $conditions[] = $condition;
        
        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;
        
        
        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));
        
        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64_callback_body;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        
        return response()->json($response);
    }

	//发送短信验证码
	public function sendCode111(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['to'])){
			return ['state'=>3001,'msg'=>'缺失参数'];
		}
		if(empty($input['code'])){
			$code = rand(1000, 9999);
		}else{
			$code = $input['code'];
		}
		$codeinfo = Redis::get('smscode_'.$input['to']);
		if(!empty($codeinfo)){
			$tmp = json_decode($codeinfo,true);
			if(!empty($tmp) && time() < $tmp['time']+60){
				return ['state'=>3002,'msg'=>'短信验证码已经发送，请一分钟之后再试'];
			}
		}

		Redis::set('smscode_'.$input['to'], json_encode(['code'=>$code,'time'=>time()]));
		// $content = '验证码'.$code.'，您正在进行艺术者身份验证，打死不要告诉别人哦！';
		$content = '亲爱的艺术者用户，您的短信验证码是'.$code.'，30分钟内有效，请及时操作！';
		$result = \Utils\Sms::getInstance(config('services.cl'))->send(['to'=>$input['to'],'content'=>$content]);
		// \Log::info(config('app.name').'发送短信：',['input'=>$input,'to'=>$input['to'],'content'=>$content]);
		return $result;
	}

    //发送注册短信验证码
    public function sendCode(Request $request){
        $input = $request->except(['s','_token']);
        if(empty($input['to'])){
            return ['state'=>3001,'msg'=>'缺失参数'];
        }
        if(empty($input['code'])){
            $code = rand(1000, 9999);
        }else{
            $code = $input['code'];
        }
        $codeinfo = Redis::get('smscode_'.$input['to']);
        if(!empty($codeinfo)){
            $tmp = json_decode($codeinfo,true);
            if(!empty($tmp) && time() < $tmp['time']+60){
                return ['state'=>3002,'msg'=>'短信验证码已经发送，请一分钟之后再试'];
            }
        }

        Redis::set('smscode_'.$input['to'], json_encode(['code'=>$code,'time'=>time()]));

        $AliyunDysms = new AliyunDysms();
        $AliyunDysms->sendCode($input['to'], 'reg', $code);

    }

	//发送注册短信验证码  旧版本ali API
    public function sendCode_bak(Request $request){
        $input = $request->except(['s','_token']);
        if(empty($input['to'])){
            return ['state'=>3001,'msg'=>'缺失参数'];
        }
        if(empty($input['code'])){
            $code = rand(1000, 9999);
        }else{
            $code = $input['code'];
        }
        $codeinfo = Redis::get('smscode_'.$input['to']);
        if(!empty($codeinfo)){
            $tmp = json_decode($codeinfo,true);
            if(!empty($tmp) && time() < $tmp['time']+60){
                return ['state'=>3002,'msg'=>'短信验证码已经发送，请一分钟之后再试'];
            }
        }

        Redis::set('smscode_'.$input['to'], json_encode(['code'=>$code,'time'=>time()]));
        $config = config('services.aliyun');
        $sms =new \App\Utils\SMS($config['endPoint'],$config['accessKeyId'],$config['accessKeySecret'],$config['topic'],$config['smssign']);
        $sms->run("{$input['to']}",['code'=>"{$code}"],'SMS_71670187');
    }

	//验证短信验证码
	public function checkCode(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['to']) || empty($input['code'])){
			return ['state'=>3001,'msg'=>'缺失参数'];
		}
		$code = Redis::get('smscode_'.$input['to']);
		if(!empty($code)){
			$tmp = json_decode($code,true);
			if(!empty($tmp) && $input['code']==$tmp['code']){
				return ['state'=>2000,'data'=>$code,'msg'=>'success'];
			}
		}
		return ['state'=>4001,'msg'=>'failed'];
	}

//	public function getToken(Request $request){
//		$url = config('app.apiurl').'/Api/user/getToken';
//		$result = httpClient($url);
//		if(isset($result['code'])&& $result['code']==30000 && $result['data']['status']==1000){
//			$token = $result['data']['token'];
//		//	\Cookie::queue('web_token', $token, $minutes = 9999, $path = null, $domain = 'artzhe.com', $secure = false, $httpOnly = true);
//            \Cookie::queue('web_token', $token, $minutes = 0, $path = null, $domain = 'artzhe.com', $secure = false, $httpOnly = true);
//		}
//		return response()->json($result);
//	}

	public function captcha(Request $request){
		$input = $request->except(['s','_token']);
		$result = ['state'=>2000,'data'=>captcha_src()];
		// $result = captcha_img();
		return $result;
	}

	public function verify(Request $request){
		$rules = ['captcha' => 'required|captcha'];
		$result = ['state'=>4004,'msg'=>'failed'];
		$validator = Validator::make(Input::all(), $rules);
		if (!$validator->fails()) {
			$result = ['state'=>2000,'msg'=>'success'];
		}
		return $result;
	}

	public function upload(Request $request){
		$base_url = './uploads/images';
		if ($request->hasFile('file')) {
		    $file = $request->file('file');
		    $extension = $file->extension();
		    $name = time().rand(100,999).'.'.$extension;
		    $path = $file->storeAs($base_url, $name);
			return $this->movetoOSS($name,'../storage/app'.substr($base_url, 1).'/'.$name);
		}else{
			return ['success'=>false,'data'=>$request->all()];
		}
	}

	public function movetoOSS($objectname,$filename){
		try {
			$ossClient = new OssClient(config('services.alioss.appId'), config('services.alioss.appKey'), config('services.alioss.host'));
			try{
				$result =$ossClient->uploadFile(config('services.alioss.bucket'),'uploads/'.date("Y/m/d/",time()).$objectname,$filename);
				$url = '//'.trim(config('services.alioss.bucket'),' ').'.'.config('services.alioss.host').'/uploads/'.date("Y/m/d/",time()).$objectname;
			} catch(OssException $e) {
				return response()->json(['success' => false,'msg' => __FUNCTION__ . ": FAILED\n".$e->getMessage()]);
			}
		} catch (OssException $e) {
			return response()->json(['success' => false,'msg' => __FUNCTION__ . ": FAILED\n".$e->getMessage()]);
		}

		return response()->json(['success' => true,'data' => $filename,'path' => $url]);
	}

	//获取阿里云服务器对应信息
	public function getOSS($request){
        $userid = (int)$request->session()->get('userid');
        if($userid<=0){
            return response()->json(['success' => false,'data' => []]);
        }
        $user_dir = $this->user_file_dir($userid);

        $id= config('services.alioss.appId');
        $key= config('services.alioss.appKey');
        $host = 'https://'.config('services.alioss.bucket').'.'.config('services.alioss.host');

        $callbackUrl = env('OssSts_callbackUrl');

        $callback_param = array('callbackUrl'=>$callbackUrl,
            'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}&bucket='.config('services.alioss.bucket').'&client_info=web&is_test='.env('OssSts_is_test'),
            'callbackBodyType'=>"application/x-www-form-urlencoded");

        $callback_string = json_encode($callback_param);
        $base64_callback_body = base64_encode($callback_string);
        $now = time();
        $expire = 60; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);

//        $dir = 'uploads/'.date('Y-m-d').'/';
        $dir = $user_dir.'/' . date('Y') . '/' . date('m') . '/' . date('d') .'/';

        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;


        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64_callback_body;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;

        return response()->json(['success' => true,'data' => $response]);
    }
    private function user_file_dir($userid)
    {// 类似：用户id:122455返回 user/122/455/files
        $userid = intval($userid);
        $length_fix = 3;
        $return_str = 'user';
        $length = strlen($userid);
        for ($i = 0; $i < $length; $i++) {
            if ($i % 3 == 0)
                $return_str = $return_str . '/' . substr($userid, $i, $length_fix);
        }
        $return_str = $return_str . '/files';
        return $return_str;
    }

    public function getOSSAudio($request){
        $userid = (int)$request->session()->get('userid');
        if($userid<=0){
            return response()->json(['success' => false,'data' => []]);
        }
        $user_dir = $this->user_file_dir($userid);

        $id= config('services.alioss.appId');
        $key= config('services.alioss.appKey');
        $host = 'https://'.config('services.alioss.bucket_audio').'.'.config('services.alioss.host');
//        $host = 'https://artaudio.'.config('services.alioss.host');

        $callbackUrl = env('OssSts_callbackUrl');

        $callback_param = array('callbackUrl'=>$callbackUrl,
            'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}&bucket='.config('services.alioss.bucket_audio').'&client_info=web&is_test='.env('OssSts_is_test'),
            'callbackBodyType'=>"application/x-www-form-urlencoded");

        $callback_string = json_encode($callback_param);
        $base64_callback_body = base64_encode($callback_string);
        $now = time();
        $expire = 60; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);

//        $dir = 'uploads/'.date('Y-m-d').'/';
        $dir = $user_dir.'/' . date('Y') . '/' . date('m') . '/' . date('d') .'/';

        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;


        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64_callback_body;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;

        return response()->json(['success' => true,'data' => $response]);
    }

    function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }

	//测试程序
	public function test(Request $request){
		$input = $request->except(['s','_token']);
		$cookie = $request->cookie();
		$session = $request->session('to');
		$input = $request->except(['s','_token']);
		$str = "Is your\r\n name O'Reilly?";
		$result = strquote($str);
		var_dump($result);die();
		if(empty($input['to'])){
			return ['state'=>3001,'msg'=>'缺失参数'];
		}
		$code = Redis::get('smscode_'.$input['to']);

		return ['state'=>2000,'input'=>$input,'cookie'=>$cookie,'session'=>$session,'code'=>$code];
	}
}