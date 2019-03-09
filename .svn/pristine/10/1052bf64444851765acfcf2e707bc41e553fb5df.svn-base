<?php

namespace App\Modules\Respond\Controllers;

class IndexController extends \App\Modules\Base\Controllers\FrontendController
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->data = array('code' => I('get.code'));
		if (isset($_GET['code'])) {
			unset($_GET['code']);
		}
	}

	public function actionIndex()
	{

		
		$msg_type = 2;
		$payment = $this->getPayment();

		if ($payment === false) {
			$msg = L('pay_disabled');
		}
		else if ($payment->callback($this->data)) {
			$msg = L('pay_success');
			$msg_type = 0;
		}
		else {
			$msg = L('pay_fail');
			$msg_type = 1;
		}
	
		$this->assign('message', $msg);
		$this->assign('msg_type', $msg_type);
		$this->assign('page_title', L('pay_status'));
		$this->display();
	}

	public function actionNotify()
	{

		$payment = $this->getPayment();
		if ($payment === false) {
			exit('plugin load fail');
		}

		$payment->notify($this->data);
	}

	private function getPayment()
	{
		$condition = array('pay_code' => $this->data['code'], 'enabled' => 1);
		$enabled = $this->db->table('payment')->where($condition)->count();
		$plugin = ADDONS_PATH . 'payment/' . $this->data['code'] . '.php';
		if (!is_file($plugin) || ($enabled == 0)) {
			return false;
		}

		require_cache($plugin);
		$payment = new $this->data['code']();
		return $payment;
	}

	public function actionWxh5()
	{
		
		if (isset($_GET) && isset($_GET['order_id'])) {
			$order = array();
			$order['order_id'] = intval($_GET['order_id']);
			// $order_url = url('user/order/detail', array('order_id' => $order['order_id']));
			$order_url ="https://test-mall.artzhe.com/mobile/index.php?m=user&c=order&a=detail&order_id=".$order['order_id'];
			//$repond_url = __URL__ . '/respond.php?code=' . $this->data['code'] . '&status=1&order_id=' . $order['order_id'];
			$repond_url = __URL__ . '/index.php?m=user&c=order&status=2';
		}
		else {
			//$repond_url = __URL__ . '/respond.php?code=' . $this->data['code'] . '&status=0';
			$repond_url = __URL__ . '/index.php?m=user&c=order&status=2';
		}

		$is_wxh5 = (($this->data['code'] == 'wxpay') && !is_wechat_browser() ? 1 : 0);
		$this->assign('is_wxh5', $is_wxh5);
		$this->assign('repond_url', $repond_url);
		$this->assign('order_url', $order_url);
		$this->assign('page_title', '确认支付');
		$this->display();
	}
}

?>
