<?php

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Api\Logic\AgencyLogic;
use Custom\Define\Code;
use Custom\Helper\Checker;
use Custom\Helper\Util;
use Custom\Helper\Verify;
use Custom\Define\Image;
use Custom\Manager\Token;
/**
 * 认证机构
 * @author:xugx
 */
class AuthAgencyController extends ApiBaseController{
  //提交机构信息
  public function stepOne(){
    $all = I('post.');
    Verify::all($all,[
      'type' => '!@',
      'name' => '!',
      'adminName' => '!',
      'adminPhone' => '!',
      'adminEmail' => '!'
    ]);
    $all['uid'] = $this->loginUserId;
    $agencyLogic = new AgencyLogic();
    $result = $agencyLogic->stepOne($all);
    Util::jsonReturn([],$result['status'],$result['msg']);
  }
  //提交机构验证图片
  public function stepTwo(){
    $all = I('post.');
    Verify::all($all,[
      'adminImages' => '!',
      'license' => '!'
    ]);
    $all['uid'] = $this->loginUserId;
    $agencyLogic = new AgencyLogic();
    $result = $agencyLogic->stepTwo($all);
    Util::jsonReturn([],$result['status'],$result['msg']);
  }
  //获取机构验证信息
  public function getMyApply(){
    $uid = $this->loginUserId;
    $agencyLogic = new AgencyLogic();
    $info = $agencyLogic->where(['uid' => $uid])->find();
    Util::jsonReturnSuccess($info);
  }
}
