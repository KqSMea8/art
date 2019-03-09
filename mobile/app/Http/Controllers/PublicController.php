<?php

namespace App\Http\Controllers;

use OSS\OssClient;
use OSS\Core\OssException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Utils\Sms;
use App\Utils\AliyunDysms;

class PublicController extends Controller{

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
        //$config = config('services.aliyun');
        //$sms =new \App\Utils\SMS($config['endPoint'],$config['accessKeyId'],$config['accessKeySecret'],$config['topic'],$config['smssign']);
        //$sms->run("{$input['to']}",['yzm'=>"{$code}"],'SMS_71340090');
		// \Log::info(config('app.name').'发送短信：',['input'=>$input,'to'=>$input['to'],'content'=>$content,'result'=>$result]);
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

	//发送通知信息
	public function sendInformation(Request $request){
		$input = $request->except(['s','_token']);
		if(empty($input['to'])){
			return ['state'=>3001,'msg'=>'缺失参数'];
		}
		if(empty($input['code'])){
			$code = '';
		}else{
			$code = $input['code'];
		}

		$AliyunDysms = new AliyunDysms();
		$AliyunDysms->sendCode($input['to'], 'information', $code);

	}

	//发送注册短信验证码
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

	public function getToken(Request $request){
		$url = config('app.apiurl').'/Api/user/getToken';
		$result = httpClient($url);
		if(isset($result['code'])&& $result['code']==30000 && $result['data']['status']==1000){
			$token = $result['data']['token'];
// 			\Cookie::queue('apiToken', $token, $minutes = 9999, $path = null, $domain = null, $secure = false, $httpOnly = false);
			\Cookie::queue('apiToken', $token, $minutes = 9999, $path = null, $domain = null, $secure = false, $httpOnly = true);
		}
		return response()->json($result);
	}

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
			return ['success'=>'false'];
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

	//测试程序
	public function test(Request $request){
		$input = $request->except(['s','_token']);
		$cookie = $request->cookie();
		$session = $request->session('to');
		return ['state'=>2000,'input'=>$input,'cookie'=>$cookie,'session'=>$session];
	}

	/*
	public function ceshi (Request $request){
		//$sms=new \Aliware\Sms(config('services.aliyun'));
		//$result = $sms->singleSendSms(15814058249,['code'=>12345,'product'=>'艺术者'],'SMS_70145013','艺术者');

		//return $result;
        $config = config('services.aliyun');
        $sms =new \App\Utils\SMS($config['endPoint'],$config['accessKeyId'],$config['accessKeySecret'],$config['topic'],$config['smssign']);
        $sms->run('17150311623',['yzm'=>'888'],'SMS_71340090');
	}
	*/
}