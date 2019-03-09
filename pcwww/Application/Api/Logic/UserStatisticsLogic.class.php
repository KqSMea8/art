<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Api\Logic\UserLogic;
use Api\Logic\ArtistApplyLogic;
use Custom\Define\Cache;
use Custom\Define\Code;
use Custom\Define\Time;
use Custom\Helper\Oss;
use Custom\Define\Image;
use Custom\Helper\Util;

class UserStatisticsLogic extends BaseLogic{
  public function addRow($where=[]){
    $userLogic = new UserLogic();
    $applyLogic = new ArtistApplyLogic();
    $total = $userLogic->total(0);
    $enjoy = $userLogic->total(1);
    $creator = $userLogic->total(3);
    $time = time();
    $stime = empty($where['stime'])?0:$where['stime'];
    $etime = empty($where['etime'])?time():$where['etime'];
    return $this->add([
      'total' => $userLogic->total(0,$etime),
      'enjoy' => $userLogic->total(1,$etime),
      'creator' => $userLogic->total(3,$etime),
      'new_total' => $userLogic->total(0,$etime,$stime),
      'new_enjoy' => $userLogic->total(1,$etime,$stime),
      'new_creator' => $userLogic->total(3,$etime,$stime),
      'logins' => $userLogic->where('is_deleted="N" and last_login_time >='.$stime.' and last_login_time<'.$etime)->count(),
      'applys' => $applyLogic->where('create_time >='.$stime.' and create_time <'.$etime)->count(),
      'time' => $stime,
    ]);
  }
}
