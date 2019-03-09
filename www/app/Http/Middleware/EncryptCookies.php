<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;

class EncryptCookies extends BaseEncrypter
{
	/**
	 * The names of the cookies that should not be encrypted.
	 *
	 * @var array
	 */
	protected $except = [
		//
	];

	public function __construct(EncrypterContract $encrypter)
	{
		parent::__construct($encrypter);
		$this->disableFor(
			[
				config('app.env').config('app.name').'_userid',
				config('app.env').config('app.name').'_source',
				config('app.env').config('app.name').'_HistoryUrl',
				'token',
				'web_token',
				'userid',
			]
			);
	}
}
