<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DiscussionController extends CommonController{


	public function details()
	{
		return view('discussion.details');
	}

	public function details2app()
	{
		return view('discussion.details2app');
	}

	public function detailGraphic()
	{
		return view('discussion.detailGraphic');
	}

	public function discussionList()
	{
		return view('discussion.discussionList');
	}

	public function discussionList2app()
	{
		return view('discussion.discussionList2app');
	}

}
