<?php
namespace app\common;
use think\Controller;
use think\Request;
use app\common\Code;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16
 * Time: 14:47
 */
class PassportController  extends Controller
{
    function __construct(Request $request = null)
    {
//        0:系统正常返回
//30001:系统错误
//30002:客户端请求参数错误
//30003:系统处理超时
//30004:客户端没有权限执行此请求
//30101:Mobile format is error!(手机号码格式错误)
//30102:Token format is error!(token的格式错误)
//30103:Token is expired!(token已经过期)
//30104:Verify code format is error!(手机验证码格式错误)
//30105:Gender format is error!(性别格式错误)
//30106:Nickname format is error!(昵称格式错误)
//30107:Password format is error!(密码格式错误)
//30108:PartnerCode format is error!(合作伙伴代码的格式错误)
//30109:Id format is error!（id的格式错误）
//30110:Verify code not matched!（验证码不匹配）
//30111:Password not matched!（密码不匹配）
//30112:Verify code is expired!（验证码过期）
//30113:Invite code is invalid!(邀请码无效)

        $no_verify=[
          'passport/user/login',
	  'passport/user/loginwx',
            'passport/user/getinfo',
            'passport/user/test',
            'passport/user/wechatlogin',
            'passport/user/accesstoken',
            'passport/user/mobilelogincheck',
            'passport/user/mobilelogin',
            'passport/user/wechatlogincallback',
        ];

        $route_url=request()->module().'/'.request()->controller().'/'.request()->action();
//        if(!in_array(strtolower($route_url),$no_verify)){
//            Util::jsonReturn('',Code::HAVE_NO_RIGHT,'没有权限');
//        }

        parent::__construct($request);
    }



}