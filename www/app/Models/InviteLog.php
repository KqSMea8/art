<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class InviteLog extends Model{

	use ModelHandle;

	protected $table = 'az_invite_log';
	public $timestamps = false;

}
