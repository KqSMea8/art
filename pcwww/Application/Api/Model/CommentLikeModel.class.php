<?php

namespace Api\Model;


use Api\Base\BaseModel;

class CommentLikeModel extends BaseModel{
    protected $tableName = 'comment_like';
    public function isLike($commentId,$uid){
      $exist = $this->where(['comment_id' => $commentId,'liker' => $uid,'is_deleted' => 'N'])->find();
      if(!empty($exist)){
        return true;
      }else{
        return false;
      }
    }
    public function likes($commentId){
      return $this->where(['comment_id' => $commentId,'is_deleted' => 'N'])->count();
    }
}