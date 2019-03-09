<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model{

	use ModelHandle;

	protected $table = 'az_comment_like';
	public $timestamps = false;

}
