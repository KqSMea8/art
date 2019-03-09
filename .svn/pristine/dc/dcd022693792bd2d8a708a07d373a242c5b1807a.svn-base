<?php

namespace App\Repositories\Payment;

class PaymentRepository implements \App\Contracts\Repositories\Payment\PaymentRepositoryInterface
{
	public function paymentList()
	{
		$payment = \App\Models\Payment::select('pay_id', 'pay_code', 'pay_name', 'pay_fee', 'pay_desc', 'pay_config', 'is_cod')->where('enabled', 1)->get()->toArray();
		return $payment;
	}
}

?>
