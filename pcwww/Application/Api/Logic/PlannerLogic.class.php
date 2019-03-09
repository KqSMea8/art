<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Custom\Helper\Sms;
use Api\Model\PlannerModel;


class PlannerLogic extends BaseLogic{
  public function stepOne($data){
    $plannerModel = new PlannerModel();
    $uid = $data['uid'];
    $exist = $plannerModel->field('id')->where(['uid' => $uid])->find();
    if(empty($exist)){
      $plannerModel->add([
        'uid' => $uid,
        'truename' => $data['trueName'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'resume' => $data['resume'],
        'addtime' => time(),
        //'status' => 0
      ]);
      return ['status' => 30000,'msg' => '认证第一步成功，请点击下一步'];
    }else{
      $plannerModel->where(['id' => $exist['id']])->save([
        'truename' => $data['trueName'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'resume' => $data['resume'],
        //'status' => 0
      ]);
      return ['status' => 30000,'msg' => '认证第一步成功，请点击下一步'];
    }
  }
  public function stepTwo($data){
    $plannerModel = new PlannerModel();
    $uid = $data['uid'];
    $exist = $plannerModel->field('id')->where(['uid' => $uid])->find();
    if(!empty($exist)){
      $plannerModel->where(['uid' => $uid])->save([
        'planner_image' => $data['plannerImages'],
        'status' => 1
      ]);
      return ['status' => 30000,'msg' => '认证成功'];
    }else{
      return ['status' => 31001,'msg' => '您还未完成第一步，请重新提交认证'];
    }
  }
	public function getList($status = null ,$page = 1, $perPageCount = 10)
	{
		$condition = [];
		if (!is_null($status) && in_array($status, [-1,0,1])) {
			$condition['status'] = $status;
		}
		$plannerModel = new PlannerModel();
		$list = $plannerModel
		->where($condition)
		->order('id DESC')
		->page($page, $perPageCount)
		->select();
		$total = $this->model->where($condition)->count();
		if (empty($list)) {
			return ['list'=>[], 'total'=>0];
		} else {
			return ['list'=>$list, 'total'=>$total];
		}
	}

	public function updateData($status ,$id )
	{
		$plannerModel = new PlannerModel();
		$result = $plannerModel->where(['id'=>$id])->save(['status'=>$status]);
		return $result;
	}
}