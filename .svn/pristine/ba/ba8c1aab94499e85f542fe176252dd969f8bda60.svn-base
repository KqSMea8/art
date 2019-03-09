<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Custom\Helper\Sms;


class AdLogic extends BaseLogic{
  public function getAd($pos){
    return $this->where(['pos' => $pos,'status' => 1])->select();
  }
  public function t(){
  	Sms::sendByRpc();
  }
}
