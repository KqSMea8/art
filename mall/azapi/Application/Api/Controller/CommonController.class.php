<?php
namespace Api\Controller;

use Think\Controller;
use Think\Log;


/**
 * decode from app by des
 * @author los_gsy
 *
 */
class CommonController extends Controller {
	protected $param = array();
	protected $ret = array();

	/**
	 * decode request
	 */
	public function __construct() {
		parent::__construct();

        // 初始化返回数据
        $this->ret['state'] = 200;
        $this->ret['msg'] = 'success';
        $this->ret['data'] = array();

        // ip 检测
//        if(!(C('CHECK_IP') && in_array($_SERVER['REMOTE_ADDR'],C('ARTZHR_IP_ARRAY')))){
//            $this->ret['state'] = 403;
//            $this->ret['msg'] = '非法请求，禁止访问';
//            $this->ajaxReturn($this->ret);
//        }

		//获取参数
		if (C('3DESOn')){
		    // 接口模式
            $param = I('param');
            $this->param = json_decode(des_decode($param), true);
        }else{
		    // 测试模式
            $this->param = I('post.');
        }
        Log::record('Client Data: ' . json_encode($this->param), Log::DEBUG);
	}
}