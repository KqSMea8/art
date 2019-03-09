<?php

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Api\Logic\PlannerLogic;
use Custom\Define\Code;
use Custom\Helper\Checker;
use Custom\Helper\Util;
use Custom\Helper\Verify;
use Custom\Define\Image;
use Custom\Manager\Token;
/**
 * 认证策展人
 * @author:xugx
 */
class AuthPlannerController extends ApiBaseController{
  //提交机构信息
  public function stepOne(){
    $all = I('post.');
    Verify::all($all,[
      'trueName' => '!',
      'phone' => '!',
      'email' => '!',
      'resume' => '!'
    ]);
    $all['uid'] = $this->loginUserId;
    $plannerLogic = new PlannerLogic();
    $result = $plannerLogic->stepOne($all);
    Util::jsonReturn([],$result['status'],$result['msg']);
  }
  //提交机构验证图片
  public function stepTwo(){
    $all = I('post.');
    Verify::all($all,[
      'plannerImages' => '!'
    ]);
    $all['uid'] = $this->loginUserId;
    $plannerLogic = new PlannerLogic();
    $result = $plannerLogic->stepTwo($all);
    Util::jsonReturn([],$result['status'],$result['msg']);
  }
  //获取机构验证信息
  public function getMyApply(){
    $uid = $this->loginUserId;
    $plannerLogic = new PlannerLogic();
    $info = $plannerLogic->where(['uid' => $uid])->find();
    Util::jsonReturnSuccess($info);
  }
}
