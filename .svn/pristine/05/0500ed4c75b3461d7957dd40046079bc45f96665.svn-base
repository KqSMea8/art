<?php

namespace App\Servers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ServiceProxy {
	protected static $_instance = null;
	protected $transport = null;

	protected $project;
	protected $control;
	protected $input;

	public function __construct($project, $control,$input){
		if(empty(self::$_instance)){
			self::$_instance = new \Snoopy\Snoopy();
		}

		$this->project = $project;
		$this->control = $control;
		$this->input = $input;

		$this->initTransport($this->project);
	}

	public function initTransport($project){
		$this->transport = new Transport($project) ;
	}

	public function __call($method, $args){
		return $this->transport->request($this->control,$method,$args,$this->input);
	}
}

class Transport {
	protected static $snoopy = null;
	protected $endPoint;

	public function __construct($project){
		$this->endPoint = Config::get('app.'.$project.'.url', false);
//		var_dump($this->endPoint);die();
		//$this->endPoint = str_replace('https://', 'http://', $this->endPoint);
	}


	public function request($serviceName, $method, $args, $input){
		$snoopy = $this->getSnoopy();

		$param = array();
		$param["method"] = "app." . $serviceName . "." . $method;
		if($args){
			$paramLength = count($args);
			for($i = 0; $i < $paramLength; $i++){
				$param["_param" . $i] = json_encode($this->_do_urlencode_args($args[$i]));
			}
		}
		$param["authCode"] = $this->getAuthCode($input);
		if( !empty(Config::get('app.webservice_key', '')) ) $this ->getSign( $param );
		$snoopy->submit($this->endPoint, $param);
		return $result = json_decode($snoopy->results, 1);
	}

	public function getURL($url){
		$this->getSnoopy()->fetch($url);
		return $this->getSnoopy()->results;
	}
    //如果定义了WEBSERVICE_KEY，组装一个sign
	public function getSign( &$param ){
		ksort( $param );
		$keyStr = '';
		foreach( $param as $key =>$val ){
			$keyStr .= $val;
		}
		$keyStr .= Config::get('app.webservice_key', '');
		$param['sign'] = substr( md5( $keyStr ) ,0,24 );
		return true;
	}
	public function getAuthCode($input){
		return isset($input['tokenKey'])&&!empty($input['tokenKey'])? $input['tokenKey']:false;
	}
	public static function getSnoopy(){
		if(self::$snoopy === NULL){
			self::$snoopy = new \Snoopy\Snoopy();
		}
		return self::$snoopy;
	}
	private function _do_urlencode_args($args){
		if(is_array($args)){
			foreach ($args as $key => $val){
				$args[$key] = $this->_do_urlencode_args($val);
			}
			return $args;
		}elseif (is_string($args)){
			return urlencode($args);
		}else{
			return $args;
		}
	}
}