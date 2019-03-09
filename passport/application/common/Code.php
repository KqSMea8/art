<?php

namespace app\common;


class Code
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

    const SUCCESS  = 0;
    const SYS_ERR = 30001;
    const PARAM_ERR = 30002;
    const REQUEST_TIMEOUT = 30003;
    const HAVE_NO_RIGHT = 30004;


    const NOT_FOUND = 30005;
    const VERIF = 30006;


    const MOBILE_ERR = 30101;
    const TOKEN_ERR  = 30102;
    const TOKEN_EXPIRED = 30103;
    const VERIFY_CODE_ERR = 30104;

    const GENDER_ERR = 30105;
    const NICKNAME_ERR = 30106;
    const PASSWORD_ERR = 30107;
    const PARTNER_CODE_ERR = 30108;
    const ID_ERR = 30109;//database id,not the id card number.
    const VERIFY_CODE_NOT_MATCHED = 30110;
    const PASSWORD_NOT_MATCHED = 30111;
    const VERIFY_CODE_EXPIRED = 30112;
    const INVITE_CODE_INVALID = 30113;
}
