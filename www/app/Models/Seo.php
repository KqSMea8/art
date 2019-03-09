<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model{

	use ModelHandle;

	protected $table = 'az_seo';
	public $timestamps = false;
}
