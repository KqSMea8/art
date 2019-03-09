<?php

namespace Custom\Helper;
require_once ROOT_PATH."SDK/aliyun-mts/aliyun-php-sdk-core/Config.php";
use Mts\Request\V20140618 as Mts;

class AliyunMts extends Base
{


    public function screenshot($video_url,$screenshot_url,$width=750,$height='-1'){
        $region = 'mts-cn-shenzhen';
        $accessKeyId = C('OSS')['appKeyId'];
        $accessKeySecret = C('OSS')['appKeySecret'];
        //$pipeline_id = '<pipeline_id>';
        $oss_location='oss-cn-shenzhen';
        $input_bucket=C('OSS')['bucket'];
        $input_object=$video_url;//'2017/08/21/13/2994888147bdb2eda501b78cb3ec8de3.MP4'
        $output_bucket=C('OSS')['bucket'];
        $output_object=$screenshot_url;//'2017/08/21/13/2994888147bdb2eda501b78cb3ec8de3.jpg'
        $time='5000';
        // $interval='<interval>';
        //$num='<num>';
        $frame_type='intra';
        //$width='750';
        //$height='350';
        $input=array(
            'Location'=>$oss_location,
            'Bucket' =>$input_bucket,
            'Object' =>$input_object
        );
        $output=array(
            'Location' =>$oss_location,
            'Bucket'  => $output_bucket,
            'Object'  => $output_object
        );
        $snapshot_config = array(
            'OutputFile' => $output,
            'Time' => $time,
            //'Interval'=> $interval,
            //'Num'=> $num,
            'FrameType'=> $frame_type,
            //"Width"=> $width,
            //"Height"=> $height
        );
        if($width>0){
            $snapshot_config['Width']=$width;
        }
        if($height>0){
            $snapshot_config['Height']=$height;
        }
        $profile = \DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        $client = new \DefaultAcsClient($profile);
        $request = new Mts\SubmitSnapshotJobRequest();
        //$request->setPipelineId($pipelineId);
        $request->setInput(json_encode($input));
        $request->setSnapshotConfig(json_encode($snapshot_config));
        // 如果出错，可能会抛出ClientException或ServerException异常
        $response = $client->getAcsResponse($request);
        $snapshotJob = $response->SnapshotJob;
        return $snapshotJob;
        //if(trim($snapshotJob->Id)!=''){
           // return true;
        //}
    }
}


?>
