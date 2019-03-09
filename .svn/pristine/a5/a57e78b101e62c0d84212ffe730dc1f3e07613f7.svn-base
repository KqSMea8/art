<?php
namespace Api\Controller;

use Think\Controller;
use Think\Log;


/**
 * decode from app by des
 * @author los_gsy
 *
 */
class DealController extends Controller {

    /**
     * 处理文章临时修改，之后更改一下数据库的名字和表前缀，删除本文件就可以
     */
    public function index()
    {
        $content = M("content_weixin"); // 实例化User对象
        $data = $content->where("site_name = '月雅书画' and need_post = 0")->select();

        foreach ($data as $k=>$v){
            // 摘要
            if(empty($v['excerpt'])){
                $data[$k]['excerpt'] = $v['title'];
            }

            // 内容
            $cot = $v['content'];
            $regImg = '/<img.*?(\/>)/i';

            // 概艺处理
//            if (preg_match($regImg,$cot)){ // 去掉开头
//                $cot = preg_replace($regImg,'',$cot,1);
//            }
//            $tailReg = '<strong>往期回顾'; //去掉结尾
//            $pos = strpos($cot, $tailReg);
//            if($pos !== false){
//                $cot = substr($cot,0,$pos);
//            }

            // 月雅书画 处理
            $section = '<section';
            $tail = '月雅书画中国网';
//            $posS = strpos($cot, $section);
//            $posT = strpos($cot,$tail);
//            if ($posS !== false){
//                $cot = substr($cot,$posS,$posT);
//            }
            $cot = $this->cut($section,$tail,$cot);
            $data[$k]['content'] = $cot;

            // 封面
            if(empty($v['cover'])){
                $ma = array();
                if(preg_match($regImg,$cot,$ma)){
                    $imgSrc = $this->get_img_thumb_url($ma[0]);
                    $data[$k]['cover'] = $imgSrc;
                }
            }
        }

        // 更新数据 逐条保存
//        $i = 0;
        foreach ($data as $key=>$value){
//            $content->save($value);
//            echo $value['content'];
//            echo PHP_EOL;
//            $i = $i + 1;
//            if($i>50) exit();
        }
    }

    function get_img_thumb_url($content="")
    {
        $pattern ='<img.*?src="(.*?)">';
        $html = $content;
        preg_match($pattern,$html,$matches);
        return $matches[1];
    }

    /**
     * php截取指定两个字符之间字符串，默认字符集为utf-8 Power by 大耳朵图图
     * @param string $begin  开始字符串
     * @param string $end    结束字符串
     * @param string $str    需要截取的字符串
     * @return string
     */
    function cut($begin,$end,$str)
    {
        $b = mb_strpos($str,$begin);
        $e = mb_strpos($str,$end) - $b;
        return mb_substr($str,$b,$e);
    }


}