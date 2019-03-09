<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ArtworkView extends Model{

	use ModelHandle;

	protected $table = 'az_artwork_view';
	public $timestamps = false;

}
