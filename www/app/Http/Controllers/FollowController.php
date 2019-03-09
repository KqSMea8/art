<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FollowController extends CommonController{

	public function __construct(Request $request){
		parent::__construct($request);
		if(self::$userid <=1){
			redirect()->to('passport/loginwx')->send();
		}
	}
}