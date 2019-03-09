<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Api\Logic\ArtworkLogic;
use Api\Logic\UserLogic;
use Api\Logic\ArtworkUpdateLogic;
use Api\Logic\MessageLogic;
use Api\Logic\RecommendLogic;
use Custom\Define\Image;
use Custom\Helper\Util;
use Think\Model;

class ArtworkLikeLogic extends BaseLogic
{
    public function getList($userId, $page, $perPageCount, $type = '1')
    {
        $artLogic = new ArtworkLogic();
        $userLogic = new UserLogic();
        $returns = [];
        //获取喜欢的作品的id
        $data = $this->model
            ->table('az_artwork_like a')
            ->join('az_artwork_update b on a.artwork_id=b.id and a.type=2', 'left')
            ->field('(CASE when a.type=1 THEN a.artwork_id else  b.artwork_id end) as artwork_id')
            ->where("a.`like_user_id` =" . $userId . " AND a.`is_like` = 'Y'")
            //->group('a.artwork_id')
            ->page($page, $perPageCount)
            ->order('a.like_time desc')
            ->select();

        if ($data) {
            $artwork_ids = [];
            foreach ($data as $key => $value) {
                array_push($artwork_ids, $value['artwork_id']);
            }

            //print_r(implode(",", $artwork_ids));
            $data = $artLogic
                //->field('(CASE when a.type=1 THEN a.artwork_id else  b.artwork_id end) as artwork_id')
                ->where(array('id' => array('in', implode(",", $artwork_ids))))
                ->select();
            $list = [];//保存排序
            foreach ($artwork_ids as $key => $value) {//按照第一次查询的排序
                $list["" . $value . ""] = '';
            }

            foreach ($data as $key => $value) {//排序完赋值
                if (trim($value['panorama_ids']) != '') {//有全局图就不显示封面
                    $images = explode(',', $value['panorama_ids']);
                    $img = $images[0];
                } else {
                    $img = $value['cover'];
                }
                $list[$value['id']] = [
                    'state' => $value['state'],
                    'artworkId' => $value['id'],
                    'coverUrl' => empty($img) ? '' : $img,
                    'name' => $value['name'],
                    'updateTimes' => $value['update_times'],
                    'artistName' => $userLogic->getUserField('nickname', $value['artist']),
                    'story' => $value['story']
                ];

            }
            foreach ($list as $key => $value) {//去掉$list的key
                $returns[] = $value;
            }
            return $returns;
        }

        return $returns;
    }

    public function like($data, $type = 1)
    {
        $recommendLogic = new RecommendLogic();
        $messageLogic = new MessageLogic();
        if (empty($this->where(['type' => $type, 'artwork_id' => $data['artwork_id'], 'like_user_id' => $data['like_user_id'], 'is_like' => 'Y'])->find())) {

            if ($type == 1) {
                $artwork = new ArtworkLogic();
                $artworkinfo = $artwork->where(['id' => $data['artwork_id'], 'is_deleted' => 'N'])->find();
                if ($artworkinfo) {
                    $id = $this->add($data);
                    $artwork->where(['id' => $data['artwork_id']])->setInc('like_total', 1);
                    $messageLogic->like($data['like_user_id'], $data['artwork_id']);
                    $recommendLogic->toArtworklike($data['artwork_id'], $data['like_user_id']);
                    return $id;
                } else {
                    return false;
                }
            } elseif ($type == 2) {
                $artwork = new ArtworkUpdateLogic();
                $ArtworkUpdateinfo = $artwork->where(['id' => $data['artwork_id'], 'is_deleted' => 'N'])->find();
                if ($ArtworkUpdateinfo) {
                    $id = $this->add($data);
                    $artwork->where(['id' => $data['artwork_id']])->setInc('like_total', 1);
                    $artId = $artwork->where(['id' => $data['artwork_id']])->getField('artwork_id');
                    $messageLogic->like($data['like_user_id'], $artId);

                    //艺术品更新的喜欢，也增加艺术品的like_totle
                    $artwork = new ArtworkLogic();
                    $artwork->where(['id' => $ArtworkUpdateinfo['artwork_id']])->setInc('like_total', 1);
                    return $id;
                } else {
                    return false;
                }

            }

        } else {
            return false;
        }
    }

    public function saveUnlike($unlikeData, $type = 1)
    {
        $recommendLogic = new RecommendLogic();
        $condition = ['artwork_id' => $unlikeData['artwork_id'], 'like_user_id' => $unlikeData['like_user_id'], 'type' => $type, 'is_like' => 'Y'];
        $likeinfo = $this->where(['type' => $type, 'artwork_id' => $unlikeData['artwork_id'], 'like_user_id' => $unlikeData['like_user_id'], 'is_like' => 'Y'])->find();
        if ($likeinfo) {
            if ($type == 1) {
                $artwork = new ArtworkLogic();
                $artworkinfo = $artwork->where(['id' => $unlikeData['artwork_id'], 'is_deleted' => 'N'])->find();
                if ($artworkinfo) {
                    $like_total = $artworkinfo['like_total'];
                    if ($like_total > 1) {
                        $artwork->where(['id' => $unlikeData['artwork_id']])->setDec('like_total', 1);
                    } else {
                        $artwork->where(['id' => $unlikeData['artwork_id']])->setField('like_total', 0);
                    }
                    $recommendLogic->toArtworkunlike($unlikeData['artwork_id'], $unlikeData['like_user_id']);
                }

            } elseif ($type == 2) {
                $artwork = new ArtworkUpdateLogic();
                $ArtworkUpdateinfo = $artwork->where(['id' => $unlikeData['artwork_id'], 'is_deleted' => 'N'])->find();
                if ($ArtworkUpdateinfo) {
                    $like_total = $ArtworkUpdateinfo['like_total'];
                    if ($like_total > 1) {
                        $artwork->where(['id' => $unlikeData['artwork_id']])->setDec('like_total', 1);
                    } else {
                        $artwork->where(['id' => $unlikeData['artwork_id']])->setField('like_total', 0);
                    }

                    //艺术品更新的取消喜欢，也修改艺术品的like_totle
                    $artwork = new ArtworkLogic();
                    $like_total = $artwork->where(['id' => $ArtworkUpdateinfo['artwork_id']])->getField('like_total');
                    if ($like_total > 1) {
                        $artwork->where(['id' => $ArtworkUpdateinfo['artwork_id']])->setDec('like_total', 1);
                    } else {
                        $artwork->where(['id' => $ArtworkUpdateinfo['artwork_id']])->setField('like_total', 0);
                    }
                }

            }
            return $this->where($condition)->delete();
        } else {
            return false;
        }
    }

    public function delUserlike_byArtid($unlikeData)
    {//我的喜欢页面，取消喜欢时，删除艺术品和所有更新的喜欢
        $Model = new Model();

        /*$artwork_update_list=$Model->query(" SELECT artwork_id as artwork_update_id FROM `az_artwork_like` WHERE
 artwork_id in(select id from az_artwork_update where artwork_id=".intval($unlikeData['artwork_id']).")
 and type=2 and like_user_id=".intval($unlikeData['like_user_id']));*/

        $artwork_update_list = $Model->query(" SELECT id as artwork_update_id  from az_artwork_update where artwork_id=" . intval($unlikeData['artwork_id']));


        $Model->execute("delete FROM `az_artwork_like` WHERE 
 artwork_id in(select id from az_artwork_update where artwork_id=" . intval($unlikeData['artwork_id']) . ")
 and type=2 and like_user_id=" . intval($unlikeData['like_user_id']));
        $Model->execute("delete FROM `az_artwork_like` WHERE artwork_id=" . intval($unlikeData['artwork_id']) . "
         and type=1  and like_user_id=" . intval($unlikeData['like_user_id']));


        $artwork_likes = M("ArtworkLike")->where("artwork_id=" . intval($unlikeData['artwork_id']) . " and type=1")->count("id");

        if ($artwork_update_list) {
            foreach ($artwork_update_list as $artwork_update) {
                // echo $artwork_update['artwork_update_id'];
                $artwork_update_likes = M("ArtworkLike")->where("artwork_id=" . intval($artwork_update['artwork_update_id']) . " and type=2")->count("id");
                $Model->execute("update az_artwork_update set like_total=" . $artwork_update_likes . " where id=" . intval($artwork_update['artwork_update_id']));
                $artwork_likes = $artwork_likes + $artwork_update_likes;
            }
        }
        $Model->execute("update az_artwork set like_total=" . $artwork_likes . " where id=" . $unlikeData['artwork_id']);

    }

    public function isLike($id, $type, $uid)
    {
        $info = $this->where(['artwork_id' => $id, 'like_user_id' => $uid, 'is_like' => 'Y', 'type' => $type])->find();
        return !empty($info) ? 'Y' : 'N';
    }

    /**
     * 喜欢作品或单次更新的数量
     * @param $id 作品或单次更新的id
     * @param $type 1、作品，2、更新
     * @return mixed 喜欢数量
     */
    public function total($id, $type)
    {
        return $this->where(['type' => $type, 'is_like' => 'Y', 'artwork_id' => $id])->count();
    }

    /**
     * 用户喜欢的作品或单次更新数量
     * @param $uid 用户的id
     * @param $type 1、作品，2、更新
     * @return mixed 喜欢数量
     */
    public function totalByUser($uid, $type)
    {
        return $this->where(['type' => $type, 'is_like' => 'Y', 'like_user_id' => $uid])->count();
    }

    /**
     * 我的喜欢的数量，
     * 喜欢单次更新数量也算过，过滤重复的作品
     * @param $uid 用户的id
     */
    public function myLikeTotal($uid){
         $data = $this
            ->join('az_artwork_update b on az_artwork_like.artwork_id=b.id and az_artwork_like.type=2', 'left')
            ->field('DISTINCT (CASE when az_artwork_like.type=1 THEN az_artwork_like.artwork_id else  b.artwork_id end) as artwork_id')
            ->where("az_artwork_like.`like_user_id` =" . $uid . " AND az_artwork_like.`is_like` = 'Y'")
            ->select();
        return count($data);
    }

    /**
     * 获取作品或创作记录的喜欢人头像
     * @param $upId 作品或单次更新的id
     * @param $field 获取的字段
     * @param $type 1、作品，2、更新
     *
     */
    public function getLikesByArtUpdate($upId, $field = '', $type = 2)
    {
        $userLogic = new UserLogic();
        $size = 10;
        if($type == 1){//作品最多14张
            $size = 14;
        }else{//单次更新最多19张
            $size = 19;
        }
        if (empty($field)) {
            return $this->where(['type' => $type, 'is_like' => 'Y', 'artwork_id' => $upId])->order('like_time DESC')->limit($size)->select();
        } else {
            $list = $this->where(['type' => $type, 'is_like' => 'Y', 'artwork_id' => $upId])->order('like_time DESC')->limit($size)->select();
            $fields = [];
            foreach ($list as $key => $value) {
                $userInfo = $userLogic->where(['id' => $value['like_user_id']])->find();
                $fields[] = $userInfo[$field];
            }
            return $fields;
        }
    }
}
