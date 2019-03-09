<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sysparam extends Model{
	
	use ModelHandle;

	protected $table = 'az_sysparam';
	public $timestamps = false;
}
