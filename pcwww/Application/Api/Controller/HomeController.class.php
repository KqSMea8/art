<?php

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Custom\Define\Image;
use Custom\Helper\Util;
use Custom\Define\Code;
use Think\Controller;
use Custom\Manager\Token;
use Api\Model\UserModel;
use Custom\Define\Cache;

class HomeController extends ApiBaseController {

    //获取首页-创作记录
    public function getRecord(){

        $page = I('post.page','1','int'); //分页页码
        $pagesize = I('post.pagesize', '10', 'int'); //每页显示条数

        $artworkModel = M('Artwork');

        $where['az_artwork.state'] = 1;
        $where['az_artwork.is_deleted']='N';
        $where['awu.is_deleted']='N';
        //获取所有数量
        $total = $artworkModel->field('az_artwork.id as artid,awu.id as artupid,az_artwork.name as artname,awu.number as upnumber,az_artwork.category,au.name as uname,awu.wit,awu.last_update_time')
                ->join('JOIN az_artwork_update awu ON az_artwork.id = awu.artwork_id')
                ->join('JOIN az_user au ON az_artwork.artist = au.id')
                ->where($where)
                ->count();


        $thedate=date('Ymd');
        $artinfo = $artworkModel->field("(case when FROM_UNIXTIME(awu.create_time,'%Y%m%d')= '".$thedate."' then 999999999+awu.create_time else az_artwork_weight.weight end) as the_order,az_artwork.artist,az_artwork.id as artid,awu.id as artupid,az_artwork.name as artname,awu.number as upnumber,az_artwork.category,au.name as uname,awu.cover,awu.wit,awu.last_update_time,au.face,awu.summary,awu.like_total,awu.title")
                ->join('JOIN az_artwork_update awu ON az_artwork.id = awu.artwork_id')
                ->join('JOIN az_user au ON az_artwork.artist = au.id')
                ->join('az_artwork_weight ON az_artwork.id = az_artwork_weight.artwork_id','left')
                ->where($where)
                ->page($page,$pagesize)
                ->order(" FROM_UNIXTIME(awu.create_time,'%Y%m%d') desc,the_order desc,awu.create_time desc")
                ->select();

        $maxpage = $total%$pagesize==0 ? $total/$pagesize : intval($total/$pagesize)+1; //最大页数

        $data = [];
        foreach ($artinfo as $k=>$v) {
            $data[$k]['artist'] = $v['artist']; //艺术家id
            $data[$k]['artid'] = $v['artid']; //作品id
            $data[$k]['artupid'] = $v['artupid'];  //作品更新编号
            //$data[$k]['imgname'] = $v['artname'];  //作品名称

            $artwork_name=trim($v['artname']);
            if(preg_match("/《(.*)》/",$artwork_name)){
                $artwork_name = ' ' .$artwork_name. ' ';//trim($artwork_name,'《》');
            }else{
                $artwork_name = '《' .$artwork_name. '》';
            }
            $data[$k]['imgname'] = empty($v['title'])?$artwork_name.' 花絮':$v['title'];


            $data[$k]['uname'] = $v['uname']; //作者名字
            $data[$k]['faceurl'] = $v['face'];//作者头像
            $data[$k]['summary'] = empty($v['summary'])?html_deconvert_content_cut($v['wit'], 45):$v['summary'];//摘要
            $data[$k]['number'] = $v['upnumber']; //更新次数编号

            $temp = '';
            if($v['category']!=10){
                $arr = explode(',',$v['category']);
                foreach ($arr as $kk=>$vv){
                    $rc = M('ArtworkCategory')->field('cn_name')->find($vv);
                    $temp .= $rc['cn_name'].'/';
                }
                $catName = trim($temp,'/');
            }else{
                $catName = '其他';
            }

            $res = M('ArtzheCustom')->field('cn_name')->where(['type'=>'1','artworkid'=>$v['artid']])->find();
            if(strpos("{$res['cn_name']}","，")!==false){
                $res['cn_name'] = trim($res['cn_name'],'，');
                $catName2 = str_replace('，','/',$res['cn_name']);
            }else{
                $res['cn_name'] = trim($res['cn_name'],',');
                $catName2 = str_replace(',','/',$res['cn_name']);
            }
            $data[$k]['category'] = $v['category']!=10?$catName:$catName2; //分类名称

            //获取更新记录里面的图片
           // preg_match_all('/&lt;img.*?src=&quot;(.*?)&quot;.*?&gt;/is',$v['wit'],$array);
            $array =  Util::getHtmlImgSrc($v['wit']);
           // Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$array]);
            $data[$k]['imgurl'] = empty($array[0])?$v['cover']:$array[0];

            //获取更新记录里面的视频
            //preg_match_all('/&lt;source.*?src=&quot;(.*?)&quot;.*?&gt;/is',$v['wit'],$match);
            preg_match_all('/&lt;video.*?poster=&quot;(.*?)&quot;.*?&gt;/is',$v['wit'],$match);
            $data[$k]['video'] = empty($match[1])?'':$match[1][0];

            $data[$k]['uptime'] = date('Y-m-d H:i:s',$v['last_update_time']); //更新时间
            $data[$k]['like_total'] =$v['like_total'];
            $data[$k]['istop'] = 'N'; //是否置顶
            unset($v['wit']);
            unset($v['category']);

        }

        $my = [
           // 'flag' => $flag,
            'data' => empty($data) ? [] : $data,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];

        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$my]);
    }

    //判断是否登录
    public function isLogin(){
        $info['isLogin']=parent::isLogin();
        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$info]);
    }

    //获取最新加入艺术家
    public function getArtist(){
        $size = I('post.size','','number_int'); //数据数量
        $userModel = new UserModel();
        $where = "  az_user.type = 3 AND az_user.is_deleted = 'N' AND az_user.banned_to = -1 and az_artwork.is_deleted='N' and az_artwork.state=1 and az_artwork.update_times>0";
        if(empty($size)){
            $list = $userModel->field("az_user.id,az_user.nickname as name,az_user.face")
                ->join('az_artwork on az_user.last_add_artupdate_artid =az_artwork.id')
                ->join('az_artist_apply on az_user.id =az_artist_apply.user_id')
                ->order("FROM_UNIXTIME(az_artist_apply.verify_time,'%Y%m%d') desc")
                ->where($where)
                ->select();
        }else{
            $list = $userModel->field("az_user.id,az_user.nickname as name,az_user.face")
                ->join('az_artwork on az_user.last_add_artupdate_artid =az_artwork.id')
                ->join('az_artist_apply on az_user.id =az_artist_apply.user_id')
                ->order("FROM_UNIXTIME(az_artist_apply.verify_time,'%Y%m%d') desc")
                ->where($where)
                ->limit($size)
                ->select();
          }
       foreach ($list as $key => $value) {
            $list[$key]['face'] = empty($value['face']) ? '' : $value['face']; //用户头像
        }

        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$list, 'size'=>count($list)]);
    }

}