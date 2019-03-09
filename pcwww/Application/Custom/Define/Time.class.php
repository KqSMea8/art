<?php

namespace Custom\Define;

class Time extends Base
{
    const VERIFY_CODE_EXPIRE_30_MIN = 1800;
    const TOKEN_EXPIRE_1_DAY = 86400;
    const TOKEN_EXPIRE_30_DAY = 86400*30;
    const WECHAT_ACCESS_TOKEN_EXPIRE_7000_SEC = 7000;//微信网页授权的access_token过期时间为7200s

    const INVITE_VALID = 86400 * 3;//邀请码的有效期
}
