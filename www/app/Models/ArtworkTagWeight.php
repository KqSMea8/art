<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ArtworkTagWeight extends Model{

	use ModelHandle;

	protected $table = 'az_artwork_tag_weight';
	public $timestamps = false;

}
