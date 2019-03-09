<?php

namespace Api\Logic;


use Api\Base\BaseLogic;
use Api\Logic\ArtworkLogic;
use Api\Logic\ArtworkUpdateLogic;
use Custom\Define\Image;
use Api\Logic\ArtworkLikeLogic;
use Api\Logic\UserFollowerLogic;
use Custom\Helper\Push;

//$messageLogic = new MessageLogic();
//$messageLogic->welcomeMsg($userId);
class MessageLogic extends BaseLogic
{
    public $msg = [
      'welcome' => '欢迎来到艺术者平台，在这里，开启你的艺术之旅，遇见你的品味吧。',
      'authSuccess' => '恭喜您，成为了艺术者平台的认证艺术家，一大波红利向您涌来。',
      'authFailed' => '很遗憾，艺术家认证失败了，艺术者客服将会与您取得联系。',
      'artworkUpdate' => '你喜欢的作品%s有更新了，快来欣赏吧。',
      'artistUpdate' => '我的新作品%s有更新了，快来欣赏吧。',
      'repayComment' => '回复了你对%s的评论：“%s”',
      'repayMessage' => '回复了你对%s的留言：“%s”',
      'message' => '留言了你的作品%s：“%s”',
      'comment' => '评论了你的作品%s：“%s”',
      'like' => '喜欢了你的作品%s'
    ];
    public $type = [
      'welcome' => '8',
      'authSuccess' => '8',
      'authFailed' => '8',
      'artworkUpdate' => '12',
      'artistUpdate' => '12',
      'repayComment' => '13',
      'repayMessage' => '13',
      'message' => '10',
      'comment' => '10',
      'like' => '9'
    ];
    public static $showmsg = 1;
    public static $linkmsg = 2;
    public static $commentmsg = 3;
    public function getMessageTotal($conditionArray)
    {
        $total = $this->model->where(sql_pin_where($conditionArray))->count();
        if (empty($total)) {
            return 0;
        } else {
            return intval($total);
        }
    }
    public function getMessageListByPage($userId, $type,$page, $perPageCount)
    {
        $where['to_user_id'] = $userId;
        if(!empty($type)){
            $arr = explode(',',$type);
            $where['type'] = ['IN',$arr];
        }
        $list = $this->where($where)
            ->page($page, $perPageCount)->order('id DESC')->select();
        if (empty($list)) {
            return [];
        }
        return $list;
    }
    public function addSystemMessage($content, $toUserId)
    {
        $systemField = [
            'content'=>$content,
            'to_user_id'=>$toUserId,
            'type'=> 8,
            'create_time'=>$_SERVER['REQUEST_TIME']
        ];
        return $this->addOne($systemField);
    }
    public function sendSysMessage($to,$content){
      return $this->sendMessage(-1,$to,$content,8,self::$showmsg);
    }
    public function welcomeMsg($to){
      return $this->sendSysMessage($to,$this->msg['welcome']);
    }
    public function authSuccess($to){
      return $this->sendSysMessage($to,$this->msg['authSuccess']);
    }
    public function authFailed($to){
      return $this->sendSysMessage($to,$this->msg['authFailed']);
    }
    public function artworkUpdate($artId){
      $artLogic = new ArtworkLogic();
      $likeLogic = new ArtworkLikeLogic();
      $updateLogic = new ArtworkUpdateLogic();
      $artInfo = $artLogic->where(['id'=>$artId])->find();
      $likeList = $likeLogic->where(['artwork_id' => $artId,'type' => '1','is_like' => 'Y'])->select();
      $lastUp = $updateLogic->where(['artwork_id' => $artId])->order('id desc')->find();
      $lastUpId = $lastUp['id'];

        if(strpos("{$artInfo['name']}","《")!==false){
            $artName = $artInfo['name'];
        }else{
            $artName = '《'.$artInfo['name'].'》';
        }

      foreach ($likeList as $key => $value) {
        $this->sendMessage(
            $artInfo['artist'],
            $value['like_user_id'],
            sprintf($this->msg['artworkUpdate'],$artName),
            $this->type['artworkUpdate'],
            self::$linkmsg,
            $this->createLink($artInfo['name'],$lastUpId,'artUpdateDetail')
          );
      }
    }
    public function artistUpdate($artId){
      $artLogic = new ArtworkLogic();
      $likeLogic = new ArtworkLikeLogic();
      $userFollowerLogic = new UserFollowerLogic();
      $userLogic = new UserLogic();
      $artInfo = $artLogic->where(['id'=>$artId])->find();
      $nickname = $userLogic->where(['id' => $artInfo['artist']])->getField('nickname');
      $followerList = $userFollowerLogic->where(['user_id' => $artInfo['artist'],'is_follow' => 'Y'])->select();

        if(strpos("{$artInfo['name']}","《")!==false){
            $artName = $artInfo['name'];
        }else{
            $artName = '《'.$artInfo['name'].'》';
        }

      foreach ($followerList as $key => $value) {
        $exists = $likeLogic->where(['is_like' => 'Y','artwork_id' => $artId,'type' => '1','like_user_id' => $value['follower']])->find();
        if(empty($exists)){
          $this->sendMessage(
            $artInfo['artist'],
            $value['follower'],
            sprintf($this->msg['artistUpdate'],$artName),
            $this->type['artistUpdate'],
            self::$linkmsg,
            $this->createLink($artInfo['name'],$artId,'artDetail'),
            '',
            true,
            $nickname.'：'.sprintf($this->msg['artistUpdate'],$artInfo['name'])
          );
        }
      }
    }
    public function repayComment($artist,$to,$artId,$content,$commentId,$repayCommentId){
      $artLogic = new ArtworkLogic();
      $userLogic = new UserLogic();
      $nickname = $userLogic->where(['id' => $artist])->getField('nickname');
      $artInfo = $artLogic->where(['id'=>$artId])->find();
      $this->where(['comment_id'=>$repayCommentId])->setField('is_repay','Y');

        if(strpos("{$artInfo['name']}","《")!==false){
            $artName = $artInfo['name'];
        }else{
            $artName = '《'.$artInfo['name'].'》';
        }

      return $this->sendMessage(
        $artist,
        $to,
        sprintf($this->msg['repayComment'],$artName,$content),
        $this->type['repayComment'],
        self::$linkmsg,
        //$this->createLink('我的消息',0,'myMessage'),
          $this->createLink('我的消息',$artId,'artDetail'),
        $commentId,
        true,
        $nickname.sprintf($this->msg['repayComment'],$artInfo['name'],$content)
      );
    }
    public function repayMessage($artist,$to,$artId,$content,$commentId,$repayCommentId){
        $artLogic = new ArtworkLogic();
        $artUpdateLogic = new ArtworkUpdateLogic(); //实例化画作更新模块
        $userLogic = new UserLogic();
        $nickname = $userLogic->where(['id' => $artist])->getField('nickname');
        $artUpdateInfo = $artUpdateLogic->field('artist,artwork_id,number')->find($artId);
        $artInfo = $artLogic->field('name')->find($artUpdateInfo['artwork_id']);
        $this->where(['comment_id'=>$repayCommentId])->setField('is_repay','Y');

        if(strpos("{$artInfo['name']}","《")!==false){
            $artName = $artInfo['name'].'纪录'.$artUpdateInfo['number'];
        }else{
            $artName = '《'.$artInfo['name'].'》'.'纪录'.$artUpdateInfo['number'];
        }

        return $this->sendMessage(
            $artist,
            $to,
            sprintf($this->msg['repayMessage'],$artName,$content),
            $this->type['repayMessage'],
            self::$linkmsg,
            //$this->createLink('我的消息',0,'myMessage'),
            $this->createLink('我的消息',$artId,'artUpdateDetail'),
            $commentId,
            true,
            $nickname.sprintf($this->msg['repayMessage'],$artName,$content)
        );
    }
    public function message($userId,$artId,$content,$commentId){
        $artLogic = new ArtworkLogic();
        $artUpdateLogic = new ArtworkUpdateLogic(); //实例化画作更新模块
        $userLogic = new UserLogic();
        $nickname = $userLogic->where(['id' => $userId])->getField('nickname');
        $artUpdateInfo = $artUpdateLogic->field('artist,artwork_id,number')->find($artId);
        $artInfo = $artLogic->field('name')->find($artUpdateInfo['artwork_id']);

        if(strpos("{$artInfo['name']}","《")!==false){
            $artName = $artInfo['name'].'纪录'.$artUpdateInfo['number'];
        }else{
            $artName = '《'.$artInfo['name'].'》'.'纪录'.$artUpdateInfo['number'];
        }

        return $this->sendMessage(
            $userId,
            $artUpdateInfo['artist'],
            sprintf($this->msg['message'],$artName,$content),
            $this->type['message'],
            self::$linkmsg,
            //$this->createLink('我的消息',0,'myMessage'),
            $this->createLink('我的消息',$artId,'artUpdateDetail'),
            $commentId,
            true,
            $nickname.sprintf($this->msg['message'],$artName,$content)
        );
    }
    public function comment($userId,$artId,$content,$commentId){
        $artLogic = new ArtworkLogic();
        $userLogic = new UserLogic();
        $nickname = $userLogic->where(['id' => $userId])->getField('nickname');
        $artInfo = $artLogic->where(['id'=>$artId])->find();

        if(strpos("{$artInfo['name']}","《")!==false){
            $artName = $artInfo['name'];
        }else{
            $artName = '《'.$artInfo['name'].'》';
        }

        return $this->sendMessage(
            $userId,
            $artInfo['artist'],
            sprintf($this->msg['comment'],$artName,$content),
            $this->type['comment'],
            self::$linkmsg,
            //$this->createLink('我的消息',0,'myMessage'),
            $this->createLink('我的消息',$artId,'artDetail'),
            $commentId,
            true,
            $nickname.sprintf($this->msg['comment'],$artInfo['name'],$content)
        );
    }
    public function like($userId,$artId){
      $artLogic = new ArtworkLogic();
      $artInfo = $artLogic->where(['id'=>$artId])->find();

        if(strpos("{$artInfo['name']}","《")!==false){
            $artName = $artInfo['name'];
        }else{
            $artName = '《'.$artInfo['name'].'》';
        }

        $content = sprintf($this->msg['like'],$artName);
      return $this->sendMessage(
        $userId,
        $artInfo['artist'],
        $content,
        $this->type['like'],
        self::$linkmsg,
        $this->createLink($artInfo['name'],$artId,'artDetail'),
        '',
        false
      );
    }
    public function createLink($title,$id,$action){
        return json_encode([
          'title' => $title,
          'id' => $id,
          'action' => $action
        ]);
    }
    public function getLink($id){
      $link = $this->where(['id' => $id])->getField('link');
      $info = $this->where(['id' => $id])->find();
      if(!empty($link)){
          if($info['create_time'] > 1494410250){
            //new
            $return = json_decode($link,1);
            if($return == null){
              return [];
            }


            //判断链接是否可点（根据画作是否是只是作者可见来判定）Artwork (state=1)链接可点
              //一个个查询数据库效率低，后期优化
            if($return['action']=='artDetail') {
                $Artworkinfo = M('Artwork')->field('state')->where(['id' => intval($return['id'])])->find();
                $return['enabled']=intval($Artworkinfo['state'])==1?1:0;
            }elseif($return['action']=='artUpdateDetail') {
                $ArtworkUpdateinfo = M('ArtworkUpdate')->field('artwork_id')->where(['id' => intval($return['id'])])->find();
                if($ArtworkUpdateinfo){
                    $Artworkinfo = M('Artwork')->field('state')->where(['id' => intval($ArtworkUpdateinfo['artwork_id'])])->find();
                    $return['enabled']=intval($Artworkinfo['state'])==1?1:0;
                }else{
                    $return['enabled']=0;
                }
            }
            //判断链接是否可点 end


              return $return;
          }else{
            //old
            list($action,$id,$title) = explode('-',$link);
            return [
              'title' => $title,
              'action' => $action,
              'id' => $id
            ];
          }
      }else{
        return '';
      }
    }
    public function sendMessage($from,$to,$content,$type,$showType,$link='',$commentId = '',$isSend = true,$sendmsg = ''){
        if ($isSend) {
            if ($type == 12) {//作品添加创作记录时不再马上发生消息推送，先写进数据库，用异步发送
                $data=[
                    'to'=>$to,
                    'title'=>'艺术者',
                    'content'=>$sendmsg,
                    'description'=>'',
                    'params'=>$link,
                    'create_time'=>time(),
                ];
                M('push_background')->add($data);//添加到异步后台推送表
            } else {
                if ($sendmsg) {
                    Push::pushByAlias($to, '艺术者', $sendmsg, '', $link);
                } else {
                    Push::pushByAlias($to, '艺术者', $content, '', $link);
                }
            }
        }
        return $this->add([
            'type' => $type,
            'content' => $content,
            'from_user_id' => $from,
            'to_user_id' => $to,
            'is_deleted' => 'N',
            'delete_time' => '',
            'is_read' => 'N',
            'read_time' => '',
            'show_type' => $showType,
            'link' => $link,
            'create_time' => time(),
            'comment_id' => $commentId
        ]);
    }
}