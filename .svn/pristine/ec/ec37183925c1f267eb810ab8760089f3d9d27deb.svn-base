<?php

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Api\Logic\ArtworkCategoryLogic;
use Api\Logic\ArtworkColorLogic;
use Api\Logic\ArtworkLikeLogic;
use Api\Logic\MessageLogic;
use Api\Logic\ArtworkLogic;
use Api\Logic\ArtworkTagLogic;
use Api\Logic\ArtworkUpdateLogic;
use Api\Logic\CommentLogic;
use Api\Logic\AssetsLogic;
use Api\Logic\UserLogic;
use Custom\Define\Code;
use Custom\Helper\Checker;
use Custom\Helper\Util;
use Custom\Define\Image;
use Custom\Manager\Token;
use Custom\Helper\Verify;
use Api\Logic\RecommendLogic;


class ArtworkController extends ApiBaseController
{
    public function like()
    {
        $this->checkLogin();
        $type = I('post.type','1','int');
        $tokenInfo = Token::getTokenInfo($this->token);
        $id = Checker::numberId();//post.id喜欢作品或记录id


        $userLogic = new UserLogic(); //实例化用户模块
        $userInfo = $userLogic->getUserInfoById($tokenInfo['userInfo']['id']); //根据用户id获取用户信息
        $assetsLogic = new AssetsLogic(); //获取用户头像
        $faceUrl = $assetsLogic->getUrl($userInfo['face']);


        $artworkLikeLogic = new ArtworkLikeLogic();
        $likeData = [
            'artwork_id'=>$id,//todo if not exists or deleted.
            'like_user_id'=> $this->loginUserId,
            'like_time'=> time(),
            'is_like' => 'Y',
            'type' => $type
        ];
        $likeId = $artworkLikeLogic->like($likeData,$type);
        if ($likeId) {
            Util::jsonReturn(['status'=>1000, 'faceUrl'=>$faceUrl]);
        } else {
            Util::jsonReturn(null, Code::SYS_ERR, '记录不存在，或者已经喜欢了');
            //Util::jsonReturn(['status'=>1000, 'faceUrl'=>$faceUrl]);
        }
    }
    public function unlike()
    {
        $this->checkLogin();
        $type = I('post.type','0','int');
        $tokenInfo = Token::getTokenInfo($this->token);
        $id = Checker::numberId();

        $userLogic = new UserLogic(); //实例化用户模块
        $userInfo = $userLogic->getUserInfoById($tokenInfo['userInfo']['id']); //根据用户id获取用户信息
        $assetsLogic = new AssetsLogic(); //获取用户头像
        $faceUrl = $assetsLogic->getUrl($userInfo['face']);


        $artworkLikeLogic = new ArtworkLikeLogic();
        $likeData = [
            'artwork_id'=>$id,//todo if not exists or deleted.
            'like_user_id'=>$this->loginUserId,
            'unlike_time'=> time(),
            'is_like'=>'N',
            'type' => $type
        ];
        if($type>0){
            $likeResult = $artworkLikeLogic->saveUnlike($likeData,$type);
        }else{//不喜欢一个艺术品，就是包括了不喜欢该艺术品的更新，艺术品的喜欢和更新的喜欢一起删除
            $likeResult = $artworkLikeLogic->delUserlike_byArtid($likeData);
        }
        if ($likeResult) {
            //Util::jsonReturn();
            Util::jsonReturn(['status'=>1000, 'faceUrl'=>$faceUrl]);
        } else if($likeResult==false){
            //Util::jsonReturn(null, Code::SYS_ERR, '记录不存在，或者已经取消喜欢了');
            Util::jsonReturn(['status'=>1000, 'faceUrl'=>$faceUrl]);
        }
    }
    //获取画作详情页
    public function getArtworkDetail(){
      $artId = I('post.artworkId','','number_int');
      if($artId > 0){
        $artworkModel = new ArtworkLogic();
        $artInfo = $artworkModel->getArtworkDetail($artId,$this->loginUserId);
        if($artInfo===false){
            Util::jsonReturn(null, Code::NOT_FOUND, '该艺术品仅作者可见', var_export($artId, true));
        }elseif(!empty($artInfo)){
          Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$artInfo]);
        }else{
            Util::jsonReturn(null, Code::NOT_FOUND, '未找到对应的艺术品', var_export($artId, true));
        }
      }else{
        Util::jsonReturn(null, Code::VERIF, '[artId]错误', var_export($artId, true));
      }
    }
    //获取单次创作记录
    public function getUpdateDetail(){
      $updateId = I('post.updateId','','number_int');
      //Verify::all($all,['updateId' => '!@']);
      $updateLogic = new ArtworkUpdateLogic();
      $loginUserId = empty($this->loginUserId)?0:$this->loginUserId;
      $detail = $updateLogic->getDetailWithComment($updateId,$loginUserId);
      if($detail==false){
       Util::jsonReturn(null, Code::SYS_ERR, '该艺术品仅作者可见');
      }else{
      Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$detail]);
      }
    }

    /**
     * 获取作品同一艺术家的其他作品及落地页所有作品
     * @param $artworkId 有--作品详情的其他作品  无--落地页所有作品
     * @param int $page
     * @param int $pagesize
     *
     */
    public function getArtworks(){
        $artworkId = I('post.artworkId','','number_int');
        $page = I('post.page', 1, 'int');
        $pagesize = I('post.pagesize', 10, 'int');
        $artworkLogic = new ArtworkLogic();
        $data = $artworkLogic->getArtworks($artworkId,$page,$pagesize);
        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$data]);
    }

    /**
     * 艺术家回复评论
     */
    public function repayMessage(){
        $this->checkLogin();
        $commentId = I('post.commentId','','number_int');
        $repayer = $this->loginUserId;
        $content = I('post.content','');
        $Commentinfo = M('Comment')->where("id=".intval($commentId)." and parent_id=0 and comment_to=".$this->loginUserId)->find();
        if(!$Commentinfo){
            Util::jsonReturn(null, Code::SYS_ERR);
        }

        $commentLogic = new CommentLogic();
        $repayInfo = $commentLogic->repay($commentId,$repayer,$content);
        if(!empty($repayInfo)){
            Util::jsonReturn(['status'=>Code::SUCCESS, 'repayInfo'=>$repayInfo]);
        }else{
            Util::jsonReturn(null, Code::SYS_ERR, '回复失败');
        }
    }

}
