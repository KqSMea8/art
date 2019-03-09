<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Custom\Helper\Sms;
use Api\Model\AgencyModel;


class AgencyLogic extends BaseLogic{
	public function stepOne($data){
		$agencyModel = new AgencyModel();
		$uid = $data['uid'];
		$exist = $agencyModel->field('id')->where(['uid' => $uid])->find();
		if(empty($exist)){
			$agencyModel->add([
				'uid' => $uid,
				'type' => $data['type'],
				'name' => $data['name'],
				'admin_name' => $data['adminName'],
				'admin_phone' => $data['adminPhone'],
				'admin_email' => $data['adminEmail'],
				'addtime' => time(),
				//'status' => 0
				]);
			return ['status' => 30000,'msg' => '认证第一步成功，请点击下一步'];
		}else{
			$agencyModel->where(['id' => $exist['id']])->save([
				'type' => $data['type'],
				'name' => $data['name'],
				'admin_name' => $data['adminName'],
				'admin_phone' => $data['adminPhone'],
				'admin_email' => $data['adminEmail'],
				//'status' => 0
				]);
			return ['status' => 30000,'msg' => '认证第一步成功，请点击下一步'];
		}
	}
	public function stepTwo($data){
		$agencyModel = new AgencyModel();
		$uid = $data['uid'];
		$exist = $agencyModel->field('id')->where(['uid' => $uid])->find();
		if(!empty($exist)){
			$agencyModel->where(['uid' => $uid])->save([
				'admin_images' => $data['adminImages'],
				'license' => $data['license'],
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
			$condition['status'] = $state;
		}
		$agencyModel = new AgencyModel();
		$list = $agencyModel
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
		$agencyModel = new AgencyModel();
		$result = $agencyModel->where(['id'=>$id])->save(['status'=>$status]);
		return $result;
	}
}
