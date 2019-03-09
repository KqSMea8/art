<?php
/**
 * Created by PhpStorm.
 * User: gsy
 * Date: 2018/8/7
 * Time: 17:29
 */

namespace App10\Controller;
use App10\Base\ApiBaseController;
use Custom\Helper\Util;
use Custom\Define\Code;
class SignatureImageController extends ApiBaseController
{

    public function getCurrentSignatureImage(){
        $date=date('Y-m-d');

        $signature_image = M('signature_image');
        $where['status'] = 1;
        $where['date'] = $date;
        $signature_image_info=$signature_image->where($where)->find();
        if(!$signature_image_info){
            $where_nofind['status'] = 1;
            $signature_image_info=$signature_image->where($where_nofind)->order('date desc')->find();
        }
        if($signature_image_info){
            $info = [
                'url' => $signature_image_info['url'],
            ];

            Util::jsonReturn(['status' => 1000, 'info' => $info]);
        }else{
            Util::jsonReturn(null, Code::NOT_FOUND, '不存在!');
        }
    }

}