<?php

namespace App\Repositories\Payment;

class PayLogRepository implements \App\Contracts\Repositories\Payment\PayLogRepositoryInterface
{
	public function insert_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0)
	{
		$payLog = new \App\Models\PayLog();
		$payLog->order_id = $id;
		$payLog->order_amount = $amount;
		$payLog->order_type = $type;
		$payLog->is_paid = $is_paid;
		$payLog->save();
		return $payLog->log_id;
	}
}

?>
