<?php

class fpd
{
	/**
     * 配置信息
     */
	public $configure;

	public function __construct($cfg = array())
	{
	}

	public function calculate($goods_weight, $goods_amount)
	{
		return 0;
	}

	public function query($invoice_sn)
	{
		return $invoice_sn;
	}

	public function api($invoice_sn = '')
	{
		return false;
	}
}


?>
