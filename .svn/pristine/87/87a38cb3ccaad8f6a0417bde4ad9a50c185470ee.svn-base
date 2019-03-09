<?php

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Api\Logic\InviteLogLogic;
use Api\Logic\ArtistApplyLogic;
use Custom\Define\Code;
use Custom\Helper\Checker;
use Custom\Helper\Util;
use Api\Model\AreaModel;
use Custom\Helper\Verify;
use Custom\Define\Image;
use Custom\Manager\Token;
/**
 * 认证艺术家
 * @author:xugx
 */
class AuthArtistController extends ApiBaseController{
  /**
   * 第一步，验证邀请码
   * @return json
   */
  public function stepOne(){
    $all = I('post.');
    $InviteLogLogic = new InviteLogLogic();
    $ArtistApplyLogic = new ArtistApplyLogic();
    $yrn = $InviteLogLogic->checkInvite($all['inviteCode']);
    if($yrn){
      $result = $ArtistApplyLogic->applyStepOne($all,$this->loginUserId);
      if($result){
        Util::jsonReturnSuccess();
      }else{
        Util::jsonReturnError('邀请码不存在或已过期');
      }
    }else{
        Util::jsonReturn(null, Code::INVITE_CODE_INVALID,'邀请码不存在或已过期');
    }
  }
  /**
   * 第二步，提交个人信息
   * @return json
   */
  public function stepTwo(){
    $all = I('post.');
    Verify::all($all,[
      'trueName' => '!',
      'mobile' => '!%',
      'province' => '!@',
      'city' => '!@',
      'area' => '!@',
      'school' => '!',
      'resume' => '!'
    ]);
    $ArtistApplyLogic = new ArtistApplyLogic();
    $result = $ArtistApplyLogic->applyStepTwo($all,$this->loginUserId);
    if($result){
      Util::jsonReturnSuccess();
    }else{
      Util::jsonReturnError('服务器异常，请稍后再试');
    }
  }
  /**
   * 第三步，提交认证图片
   * @return json
   */
  public function stepThree(){
    $all = I('post.');
    Verify::all($all,[
      'images' => '!',
    ]);
    $ArtistApplyLogic = new ArtistApplyLogic();
    $result = $ArtistApplyLogic->applyStepThree($all,$this->loginUserId);
    if($result){
      Util::jsonReturnSuccess();
    }else{
      Util::jsonReturnError('服务器异常，请稍后再试');
    }
  }
  /**
   * 获取当前用户的认证信息
   * @return json
   */
  public function getMyApply(){
    $ArtistApplyLogic = new ArtistApplyLogic();
    $AreaModel = new AreaModel();
    $info = $ArtistApplyLogic->getMyApply($this->loginUserId);
    if(!empty($info)){
      $info['provinceName'] = $AreaModel->where(['id' => $info['province']])->getField('aname');
      $info['cityName'] = $AreaModel->where(['id' => $info['city']])->getField('aname');
      $info['areaName'] = $AreaModel->where(['id' => $info['area']])->getField('aname');
      Util::jsonReturnSuccess($info);
    }else{
      Util::jsonReturnError('尚未申请认证艺术家');
    }
  }
}
