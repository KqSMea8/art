<?php
/**
 * Created by PhpStorm.
 * User: gsy
 * Date: 2018/8/22
 * Time: 16:30
 */

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Custom\Helper\Util;
use Custom\Define\Code;
use Custom\Define\Cache;
use Custom\Define\Time;

class AgencyController extends ApiBaseController
{

    // 切换回旧身份 (机构身份)
    public function ChangeLoginToRealIdentity()
    {
        // 校验权限
        $this->checkLogin(); // 登陆验证

        $_real_identity = S(Cache::TOKEN_PREFIX . $this->token . '_real_identity'); // 旧身份
        $_current_identity = S(Cache::TOKEN_PREFIX . $this->token); // 当前身份

        if ($_real_identity && $_current_identity['temporary_login'] == 1) {
            S(Cache::TOKEN_PREFIX . $this->token, $_real_identity, Time::TOKEN_EXPIRE_30_DAY);
            S(Cache::TOKEN_PREFIX . $this->token . '_real_identity', null);
            Util::jsonReturn([
                'status' => 1000
            ]);
        }
    }

}