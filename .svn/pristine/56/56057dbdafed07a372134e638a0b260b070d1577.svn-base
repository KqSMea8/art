<?php

namespace Api\Controller;

use Think\Exception;
use Api\Logic\CommentLogic;
use Api\Logic\UserFollowerLogic;
use Api\Logic\ArtworkLogic;
use Api\Logic\GalleryLogic;
use Api\Base\ApiBaseController;
use Api\Model\CommentModel;
use Custom\Define\Code;
use Custom\Helper\Checker;
use Custom\Helper\Util;
use Custom\Manager\Token;
use Custom\Define\Image;

//画廊
class GalleryController extends ApiBaseController
{
    //获取画廊列表页
    public function getGalleryList()
    {
        $gender = I('post.gender','','number_int');
        $category = I('post.category','','number_int');
        $page = I('post.page',1,'int');
        $pagesize = I('post.pagesize', 5, 'int');
        $galleryLogic =  new GalleryLogic();
        $data = $galleryLogic->getGalleryList($gender,$category,$page,$pagesize,$this->loginUserId);
        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$data]);
    }
    //获取画廊详情页信息,艺术家基本信息
    public function getArtistDetail()
    {
        $artistId = I('post.artistId', '','number_int');
        $artistId = Checker::numberId($artistId);
        $galleryLogic =  new GalleryLogic();
        $galleryLogic->showDetail($artistId, $this->loginUserId);
    }

    //获取艺术家创作记录
    public function getArtistRecord(){
        $artistId = I('post.artistId', '','number_int');
        $artistId = Checker::numberId($artistId);
        $page = I('post.page','1','int'); //分页页码
        $pagesize = I('post.pagesize', '10', 'int'); //每页显示条数

        $artworkLogic = new ArtworkLogic();
        $artworkLogic->getArtistRecord($artistId, $page, $pagesize,$this->loginUserId);
    }


    //获取艺术家作品集
    public function getArtistArtworkList()
    {
        $userid = $this->loginUserId; //用户登录ID
        $userid = empty($userid)?0:$userid;
        $artistId = I('post.artistId', '','number_int');
        $artistId = Checker::numberId($artistId);
        $page = I('post.page', 1, 'int');
        $pagesize = I('post.pagesize', 10, 'int');

        $artworkLogic = new ArtworkLogic();
        $artworkLogic->showArtworkListByPage($artistId, $page, $pagesize,$userid);
    }

    //关注画廊、作家
    public function follow()
    {
        $this->checkLogin();
        $artistId = I('post.artistId', '','number_int');
        $artistId = Checker::numberId($artistId);
        $userFollowerLogic = new UserFollowerLogic();
        $followResult = $userFollowerLogic->addFollower($this->loginUserId, $artistId);
        if ($followResult) {
            Util::jsonReturn();
        }
        Util::jsonReturn();
        //Util::jsonReturn(null, Code::SYS_ERR, '您已经关注过!');
    }
    //取消关注画廊、作家
    public function unFollow()
    {
        $this->checkLogin();
        $artistId = I('post.artistId', '','number_int');
        $artistId = Checker::numberId($artistId);
        $userFollowerLogic = new UserFollowerLogic();
        try{//关注不能是负数，执行会出现sql错误，要try
        $followResult = $userFollowerLogic->unFollow($this->loginUserId, $artistId);
        }catch (Exception $e){
            //Util::jsonReturn(null, Code::SYS_ERR, 'Data save error!');
            Util::jsonReturn();
        }
        if ($followResult) {
            Util::jsonReturn();
        }
        Util::jsonReturn();
        //Util::jsonReturn(null, Code::SYS_ERR, 'Data save error!');
    }
}
