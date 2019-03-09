<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public static $device =null;
    public static $syslist=null;

    public function __construct(Request $request){

		self::$device = new \Utils\UserAgent();
    		//获取系统参数
		if(empty(self::$syslist)){
			$syslist = \Cache::get( config('app.env').'_'.config('app.name').'_syslist' );
			if(empty($syslist)){
				$list = \App\Models\Sysparam::get()->toArray();
				foreach($list as $item){
					$syslist[$item['name']] = $item;
				}
				\Cache::put( config('app.env').'_'.config('app.name').'_syslist', $syslist, 120 );
			}
			self::$syslist = $syslist;
		}
		view()->share('syslist',self::$syslist);
	}
}
