<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdLog extends Model{
	
	use ModelHandle;

	protected $table = 'az_third_login_log';
	public $timestamps = false;
	
}