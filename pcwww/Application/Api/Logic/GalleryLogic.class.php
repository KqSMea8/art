<?php

namespace Api\Logic;

use Api\Logic\ArtworkCategoryLogic;
use Api\Model\ArtworkCategoryModel;
use Api\Model\ArtworkCategoryStatModel;
use Api\Base\BaseLogic;
use Api\Model\ArtworkStyleModel;
use Api\Model\ArtworkSubjectModel;
use Api\Model\UserModel;
use Api\Model\ArtworkModel;
use Api\Model\GalleryModel;
use Api\Model\UserFollowerModel;
use Custom\Define\Cache;
use Custom\Define\Image;
use Custom\Helper\Util;
use Api\Logic\ArtworkLikeLogic;

class GalleryLogic extends BaseLogic
{
    public function showArtworkSubjectAndStyle($forceUpdate = false)
    {
        if ($forceUpdate) {
            $group = $this->getArtworkSubjectAndStyle();
            S(Cache::ARTWORK_SUBJECT_AND_STYLE, $group);
            Util::jsonReturn($group);
        } else {
            if (!empty($cacheResult = S(Cache::ARTWORK_SUBJECT_AND_STYLE))) {
                Util::jsonReturn($cacheResult);
            } else {
                $group = $this->getArtworkSubjectAndStyle();
                S(Cache::ARTWORK_SUBJECT_AND_STYLE, $group);
                Util::jsonReturn($group);
            }
        }
    }

    public function showArtworkCategoryStat($forceUpdate = false)
    {
        if ($forceUpdate) {
            $statGroup = $this->getArtworkCategoryStat();
            S(Cache::ARTWORK_CATEGORY_STAT_RESULTS, $statGroup);
            Util::jsonReturn(['status' => 1000, 'info' => $statGroup]);
        } else {
            if (!empty($cacheResult = S(Cache::ARTWORK_CATEGORY_STAT_RESULTS))) {
                Util::jsonReturn(['status' => 1000, 'info' => $cacheResult]);
            } else {
                $statGroup = $this->getArtworkCategoryStat();
                S(Cache::ARTWORK_CATEGORY_STAT_RESULTS, $statGroup);
                Util::jsonReturn(['status' => 1000, 'info' => $statGroup]);
            }
        }
    }

    public function getArtworkSubjectAndStyle()
    {
        $aStyleModel = new ArtworkStyleModel();
        $aSubjectModel = new ArtworkSubjectModel();
        $styles = $aStyleModel->order('sort ASC, id ASC')->getField('id,cn_name');
        $subjects = $aSubjectModel->order('sort ASC, id ASC')->getField('id,cn_name');
        return ['style' => $styles, 'subject' => $subjects];
    }

    public function getArtworkCategoryStat($gender = '')
    {
        $return = [];
        $artModel = new ArtworkModel();
        $artCateModel = new ArtworkCategoryModel();
        $alltotal = $artModel->where(['is_deleted' => 'N'])->count();
        $categoryListAll = $artCateModel->select();
        $return[] = [
            'category' => '0',
            'categoryName' => '全部',
            'total' => $alltotal
        ];
        foreach ($categoryListAll as $key => $value) {
            $where = sql_pin_where([
                'a.is_deleted' => 'N',
                'a.category' => $value['id'],
                'b.is_deleted' => 'N',
                'b.banned_to' => -1,
                'b.gender' => $gender
            ], 'AND', '');
            $query = <<<SQL
SELECT count(distinct(artist)) as count FROM `az_artwork` a LEFT JOIN `az_user` b ON a.artist = b.id
WHERE $where
SQL;

            $total = $artModel->query($query)[0]['count'];
            if ($total > 0) {
                $return[] = [
                    'category' => $value['id'],
                    'categoryName' => $value['cn_name'],
                    'total' => $total
                ];
            }
        }
        return $return;
    }

    private function switchGenderType2En($type)
    {
        if ($type == '-1') {
            return 'all';
        } else {
            return UserModel::GENDER_EN_LIST[$type];
        }
    }

    private function switchCategoryType2Cn($type)
    {
        $acModel = new ArtworkCategoryModel();
        $categoryResult = $acModel->getField('id,cn_name');
        if ($type == '-1') {
            return '全部';
        } else {
            return $categoryResult[$type];
        }
    }

    public function showArtworkList($userId, $gender, $category, $page = 1, $perPageNumber = 5, $x = 3)
    {
        $result = $this->getListByFollower($userId, $gender, $category, $page, $perPageNumber, $x);

        Util::jsonReturn($result);
    }

    public function getListByFollower($userId, $gender, $category, $page = 1, $perPageNumber = 5, $x = 3)
    {
        $condition = [
            'is_deleted' => 'N',
            'banned_to' => [['eq', '-1'], ['gt', $_SERVER['REQUEST_TIME']], 'or'],
            'type' => [['in', [3, 7]]]
        ];
        if ($gender != -4) {
            $condition['gender'] = $gender;
        }
        if ($category != -4) {
            $condition['category'] = $category;
        }
        $userModel = new UserModel();
        $artistList = $userModel
            ->where($condition)->order('follower_total DESC, create_time DESC, login_times DESC')
            ->page($page, $perPageNumber)
            ->getField('id,nickname,gender,face,follower_total AS followerTotal');
        if (empty($artistList)) {
            return [];
        }
        $assetsLogic = new AssetsLogic();
        $userFollowerLogic = new UserFollowerLogic();
        $artworkLogic = new ArtworkLogic();
        $artworkStatLogic = new ArtworkStatLogic();

        $artistIdList = array_keys($artistList);
        $faceIdList = array_column($artistList, 'face');
        //获取艺术家头像
        $faceUrlList = $assetsLogic->getUrlList($faceIdList);
        //获取艺术家画廊封面
        $coverUrlList = $this->getCoverUrlList($artistIdList);
        //获取当前用户是否关注情况
        $isFollowedList = $userFollowerLogic->getIsFollowedList($artistIdList, $userId);
        //获取艺术家作品分类列表
        $artistCategoryList = $artworkLogic->getArtistCategoryList($artistIdList);
        //获取最近的x幅画
        $latestXArtworkList = $artworkLogic->getLatestXArtworkList($artistIdList, $x);
        //获取艺术家的作品数量
        $artistArtworkTotal = $artworkStatLogic->getArtworkTotal($artistIdList);
        foreach ($artistIdList as $artistId => &$artist) {
            $artist['faceUrl'] = Util::getFillImage($faceUrlList[$artistId], Image::faceWidth, Image::faceHeight);
            $artist['coverUrl'] = $coverUrlList[$artistId];
            $artist['isFollowedList'] = $isFollowedList[$artistId];
            $artist['categoryList'] = $artistCategoryList[$artistId];
            $artist['latestXArtworkList'] = $latestXArtworkList[$artistId];//todo
            $artist['artworkTotal'] = $artistArtworkTotal[$artistId];
        }
        return $artist;
    }

    public function getCoverUrlList($userIdList)
    {
        $coverList = $this->model
            ->where(['artist' => ['in', $userIdList], 'is_deleted' => 'N'])
            ->getField('cover,artist');
        if (empty($coverList)) {
            return [];
        }
        $assetsLogic = new AssetsLogic();
        $urlList = $assetsLogic->getUrlList(array_values($coverList));
        $coverUrlList = [];
        foreach ($coverList as $coverId => $cover) {
            $coverUrlList[$cover['artist']] = $urlList[$coverId];
        }
        return $coverUrlList;
    }

    public function showDetail($artistId, $loginUserId)
    {
        $artworkStatLogic = new ArtworkStatLogic();
        $artworkCateogoryLogic = new ArtworkCategoryLogic();
        $artLogic = new ArtworkLogic();
        $assetsLogic = new AssetsLogic();
        $userLogic = new UserLogic();
        $userFollowerLogic = new UserFollowerLogic();
        $galleryModel = new GalleryModel();
        $artModel = new ArtworkModel();
        $ret = [];

        if($artistId > 0 && $loginUserId == $artistId){
            //用户是否是艺术家本人
            $isSelf = 'Y';
            //画作数量$ret['artworkTotal'] = $artModel->where("artist = $artistId AND update_times > 0 AND state = 1 and is_deleted='N' ")->count();
            $ret['artworkTotal'] = $artModel->where(['artist' => $artistId, 'is_deleted' => 'N'])->count();
        }else{
            //用户是否是艺术家本人
            $isSelf = 'N';
            //画作数量
            $ret['artworkTotal'] = $artModel->where(['artist' => $artistId, 'is_deleted' => 'N', 'state' => '1','update_times' => ['gt', 0]])->count();
        }

        $ret['isSelf'] = $isSelf;
        //封面图片
        $cover = $galleryModel->where("artist = {$artistId}")->getField('cover');
        $ret['coverUrl'] = trim($cover) == '' ? '' : $cover;

        //头像
        $assetsInfo = $assetsLogic->getDetailById($artistId);
        //姓名
        $artistInfo = $userLogic->getUserInfoById($artistId);
        $ret['faceUrl'] = $artistInfo['face'];
        $ret['name'] = $artistInfo['name'];
        //个性签名
        $ret['motto'] = $artistInfo['motto'];
        //艺术家履历
        $ret['resume'] = $artistInfo['resume'];
        //画作被喜欢总数
        $ret['likeTotal'] = intval($artLogic->where(['is_deleted' => 'N', 'artist' => $artistId])->sum('like_total'));
        //画作被浏览总数
        $ret['viewTotal'] = intval($artLogic->where(['is_deleted' => 'N', 'artist' => $artistId])->sum('view_total'));
        //艺术者被关注总数
        $ret['followTotal'] = $userFollowerLogic->where(['user_id' => $artistId, 'is_follow' => 'Y'])->count();
        //是否关注
        $userFollowerModel = new UserFollowerModel();
        $ret['isFollowed'] = $userFollowerModel->isFollow($artistId, $loginUserId);

        //分享画廊相关信息
        $ret['shareTitle'] = $artistInfo['nickname'] . '的艺术画廊';
        $ret['shareDesc'] = $artistInfo['motto'];
        $ret['shareImg'] = $cover;
        $ret['shareLink'] = C('www_site') . '/gallery/detail/' . $artistId;
        $ret['shareInfo'] = [
            'cover' => $ret['coverUrl'],
            'face' => $ret['faceUrl'],
            'name' => $artistInfo['nickname'],
            'category' => $artworkCateogoryLogic->getCategoryByUser($artistInfo['id']),
            'motto' => $artistInfo['motto'],
            'link' => $ret['shareLink']
        ];

        Util::jsonReturn(['status' => 1000, 'info' => $ret]);
    }

    public function getDetailById($id)
    {
        $data = $this->model->where(['id' => $id])->find();
        if (empty($data)) {
            return [];
        } else {
            return $data;
        }
    }

    public function getDetailByArtist($artistId)
    {
        $artLogic = new ArtworkLogic();
        //画作被喜欢总数
        $likeTotal = intval($artLogic->where(['is_deleted' => 'N', 'artist' => $artistId])->sum('like_total'));
        //画作被浏览总数
        $viewTotal = intval($artLogic->where(['is_deleted' => 'N', 'artist' => $artistId])->sum('view_total'));
        return [
            'like_total' => $likeTotal,
            'view_total' => $viewTotal
        ];
    }

    public function setFieldByArtistId($artistId, $fieldInfo)
    {
        return $this->model->where(['artist' => $artistId])->setField($fieldInfo);
    }

    //get gallery category name  list by artist id
    public function getGalleryCateNameList($artistId)
    {
        $categoryIds = $this->model->where(['artist' => $artistId, 'is_deleted' => 'N'])->getField('category_ids');
        if (empty($categoryIds)) {
            return [];
        }
        $categoryIdList = explode(',', $categoryIds);
        $artworkCategoryLogic = new ArtworkCategoryLogic();
        $categoryIdNamePairs = $artworkCategoryLogic->getList();
        $galleryCateNameList = [];
        foreach ($categoryIdList as $categoryId) {
            $galleryCateNameList[] = $categoryIdNamePairs[$categoryId];
        }
        return $galleryCateNameList;
    }

    public function getArtistTotal()
    {
        $userModel = new UserModel();
        $where = "  type = 3 AND is_deleted = 'N' AND banned_to = -1 AND art_total > 0  ";
        return $total = $userModel->where($where)->count();
    }

    public function getGalleryList($gender, $category, $page, $pagesize, $loginUserId)
    {
        $userModel = new UserModel();
        $artModel = new ArtworkModel();
        $cateModel = new ArtworkCategoryModel();
        $galleryModel = new GalleryModel();
        $userFollowerModel = new UserFollowerModel();
        $artworkLikeLogic = new ArtworkLikeLogic();


        $where = "  az_user.type = 3 AND az_user.is_deleted = 'N' AND az_user.banned_to = -1 and az_artwork.is_deleted='N' and az_artwork.update_times>0 and az_artwork.state=1 ";
        if ($gender) {
            $where .= " AND az_user.gender = {$gender}  ";
        }
        if ($category) {
            $where .= " AND find_in_set({$category},az_user.category)  ";
        }
        $thedate = date('Ymd');
        $list = $userModel->
        field("(case when FROM_UNIXTIME(az_user.last_add_artupdate_time,'%Y%m%d')= '" . $thedate . "' then 999999999+az_user.last_add_artupdate_time else az_artwork_weight.weight end) as the_order,az_user.id,az_user.nickname as name,az_user.category,az_user.follower_total,az_user.gender,az_user.face")
            ->join('az_artwork on az_user.last_add_artupdate_artid =az_artwork.id')
            ->join('az_artwork_weight on az_artwork.id=az_artwork_weight.artwork_id', 'left')
            ->where($where)->page($page, $pagesize)
            ->order("FROM_UNIXTIME(az_user.last_add_artupdate_time,'%Y%m%d') desc,the_order desc,az_user.last_add_artupdate_time desc")
            ->select();
//echo $userModel->getLastSql();exit;

        $total = $userModel->join('az_artwork on az_user.id=az_artwork.artist')
            ->where($where)
            ->count();
        foreach ($list as $key => $value) {
            $list[$key]['the_order'] = empty($value['the_order'])?'0':$value['the_order'];
            $artistInfo = M('ArtistApply')->field('city')->where(['user_id' => $value['id']])->find(); //获取艺术家城市编码
            $areaInfo = M('Area')->field('sname')->find($artistInfo['city']);
            $list[$key]['city'] = $areaInfo['sname'];
            $list[$key]['total_art'] = $artModel->where(['artist' => $value['id'], 'is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0]])->count();//艺术家的作品数量
            $category_content = $cateModel->getContent(implode(',', $artModel->getFields(['artist' => $value['id']], 'category')));
            //$list[$key]['category_content'] = $category_content;
            $list[$key]['category_names'] = implode('/', array_values($category_content));
            //$list[$key]['faceUrl'] = Util::getFillImage($value['face'],Image::faceWidth,Image::faceHeight);
            //$cover = $galleryModel->where("artist = {$value['id']}")->getField('cover');
            //$list[$key]['cover'] = Util::getImageResize($cover,Image::galleryWidth,Image::galleryHeight);
            //$list[$key]['coverUrl'] = Util::getImageResize($cover,Image::galleryWidth,Image::galleryHeight);
            //$list[$key]['arts'] = Util::getImageResizes($artModel->getThumbListByUid($value['id']),450,450);
            //获取艺术家的作品信息
            $map['update_times'] = ['gt', 0];
            $map['artist'] = $value['id'];
            $map['state'] = 1;
            $map['is_deleted'] = 'N';
            $map['cover'] = ['neq',''];
            $imglist = $artModel->field('id,name,cover,panorama_ids,update_times')->where($map)->limit(4)->order('last_update_time DESC')->select();//作品列表
            $temp = [];
            foreach ($imglist as $k => $v) {
                if (trim($v['panorama_ids']) != '') {//有全局图就不显示封面
                    $images = explode(',', $v['panorama_ids']);
                    $img = $images[0];
                } else {
                    $img = Util::getImgUrlById($v['cover']);
                }
                if ($img) {
                    $pic['imgid'] = $v['id'];
                    $pic['imgname'] = $v['name'];
                    $pic['imgurl'] = empty($v['cover']) && empty($v['panorama_ids']) ? '' : $img;
                    $pic['update_times'] = $v['update_times'];
                    //是否喜欢
                    $pic['islike'] = $artworkLikeLogic->isLike($v['id'], 1, $loginUserId);
                    $temp[] = $pic;
                }
            }
            $list[$key]['imginfo'] = $temp;
            $list[$key]['follow'] = $userFollowerModel->isFollow($value['id'], $loginUserId);
        }

        //var_dump($list);exit;
        $maxpage = intval($total / $pagesize) + 1;
        return [
            'list' => empty($list) ? [] : $list,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];
    }

    public function getGalleryList_20170802($gender, $category, $page, $pagesize, $loginUserId)
    {
        $userModel = new UserModel();
        $artModel = new ArtworkModel();
        $cateModel = new ArtworkCategoryModel();
        $galleryModel = new GalleryModel();
        $userFollowerModel = new UserFollowerModel();
        $artistInfo = $artModel->field('artist')->where(['is_deleted' => 'N', 'update_times' => ['gt', 0], 'state' => 1])->select();
        $temp = [];
        foreach ($artistInfo as $k => $v) {
            $temp[$k] = $v['artist'];
        }
        $temp = array_unique($temp);
        $artids = implode(',', $temp);

        $where = "  type = 3 AND is_deleted = 'N' AND banned_to = -1 AND id in ({$artids})  ";
        if ($gender) {
            $where .= " AND gender = {$gender}  ";
        }
        if ($category) {
            $where .= " AND find_in_set({$category},category)  ";
        }
        $list = $userModel->
        field('id,nickname as name,category,follower_total,gender,face')->
        where($where)->page($page, $pagesize)->order('last_add_artupdate_time desc,last_update_time Desc')->select();

        $total = $userModel->where($where)->count();
        foreach ($list as $key => $value) {
            $artistInfo = M('ArtistApply')->field('city')->where(['user_id' => $value['id']])->find(); //获取艺术家城市编码
            $areaInfo = M('Area')->field('sname')->find($artistInfo['city']);
            $list[$key]['city'] = $areaInfo['sname'];
            $list[$key]['total_art'] = $artModel->where(['artist' => $value['id'], 'is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0]])->count();
            $category_content = $cateModel->getContent(implode(',', $artModel->getFields(['artist' => $value['id']], 'category')));
            //$list[$key]['category_content'] = $category_content;
            $list[$key]['category_names'] = implode('/', array_values($category_content));
            //$list[$key]['faceUrl'] = Util::getFillImage($value['face'],Image::faceWidth,Image::faceHeight);
            //$cover = $galleryModel->where("artist = {$value['id']}")->getField('cover');
            //$list[$key]['cover'] = Util::getImageResize($cover,Image::galleryWidth,Image::galleryHeight);
            //$list[$key]['coverUrl'] = Util::getImageResize($cover,Image::galleryWidth,Image::galleryHeight);
            //$list[$key]['arts'] = Util::getImageResizes($artModel->getThumbListByUid($value['id']),450,450);
            $map['update_times'] = ['gt', 0];
            $map['artist'] = $value['id'];
            $map['state'] = 1;
            $imglist = $artModel->field('id,name,cover,panorama_ids,update_times')->where($map)->limit(3)->order('last_update_time DESC')->select();
            $temp = [];
            foreach ($imglist as $k => $v) {
                if (trim($v['panorama_ids']) != '') {//有全局图就不显示封面
                    $images = explode(',', $v['panorama_ids']);
                    $img = $images[0];
                } else {
                    $img = Util::getImgUrlById($v['cover']);
                }
                if ($img) {
                    $temp[$k]['imgid'] = $v['id'];
                    $temp[$k]['imgname'] = $v['name'];
                    $temp[$k]['imgurl'] = empty($v['cover']) && empty($v['panorama_ids']) ? '' : Util::getImageResize($img, 450, 450);
                    $temp[$k]['update_times'] = $v['update_times'];
                }
            }
            $list[$key]['imginfo'] = $temp;
            $list[$key]['follow'] = $userFollowerModel->isFollow($value['id'], $loginUserId);
        }

        //var_dump($list);exit;
        $maxpage = intval($total / $pagesize) + 1;
        return [
            'list' => empty($list) ? [] : $list,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];
    }
}
