<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Custom\Helper\Util;

use Api\Model\ArtworkTagModel;
use Api\Logic\UserLogic;
use Api\Logic\ArtworkUpdateLogic;
use Api\Logic\CommentLogic;
use Api\Logic\ArtworkCategoryLogic;
use Custom\Define\Image;
use Api\Logic\RecommendLogic;
use Custom\Define\Code;
use Api\Model\ArtworkCategoryModel;

class ArtworkLogic extends BaseLogic
{
    //获取艺术家标签列表
    public function getArtistCategoryList($artistIdList)
    {
        $list = $this->model->where(['artist' => ['in', $artistIdList], 'is_deleted' => 'N'])
            ->field('DISTINCT artist,category')
            ->select();
        if (empty($list)) {
            return [];
        }
        $result = [];
        foreach ($list as $value) {
            $result[$value['artist']][] = $value['category'];
        }
        return $result;
    }

    //获取最近的$x幅画
    public function getLatestXArtworkList($userIdList, $x)
    {
        $x = (int)$x;
        if ($x < 1) {
            return [];
        }
        $assetsLogic = new AssetsLogic();
        $results = [];
        foreach ($userIdList as $userId) {
            $list = $this->model->where(['artist' => $userId, 'is_deleted' => 'N'])
                ->order('create_time DESC, last_update_time DESC')
                ->limit($x)
                ->getField('id,panorama_ids');
            $panoramaUrlList = $assetsLogic->getUrlList(array_values($list));
            foreach ($list as $id => &$artwork) {
                $artwork['panoramaUrl'] = $panoramaUrlList[$id];
            }
            if (empty($list)) {
                $list = [];
            }
            $results[$userId] = $list;
        }
        return $results;
    }

    public function showArtworkListByPage($artistId, $page = 1, $perPageNumber = 1, $uid = 0)
    {
        $result = $this->getArtworkListByPage($artistId, $page, $perPageNumber, $uid);
        Util::jsonReturn(['status' => 1000, 'info' => $result]);
    }

    public function showArtworkListByPage2($artistId, $page = 1, $perPageNumber = 1)
    {
        $result = $this->getArtworkListByPage2($artistId, $page, $perPageNumber);
        Util::jsonReturn(['status' => 1000, 'info' => $result]);
    }

    public function getArtworkListByPage($artistId, $page = 1, $perPageNumber = 1, $uid = 0)
    {
        //封面图
        //名称
        //更新次数
        //浏览次数
        //被喜欢次数
        //描述
        $artworkLikeLogic = new ArtworkLikeLogic();
        if ($uid > 0 && $artistId == $uid) {
            //艺术家公开和隐藏的作品
            $where = ['artist' => $artistId, 'is_deleted' => 'N', ['update_times' => ['gt', 0]]];
            //获取所有数量
            $total = $this->model->field('id,name,update_times')
                ->where($where)
                ->count();

            $artworkList = $this->model
                ->where($where)
                ->field('id,name,update_times AS updateTimes,shape,length,width,diameter,category,cover,panorama_ids,story,last_update_time,
            is_finished AS isFinished, like_total AS likeTotal, view_total AS viewTotal')
                ->page($page, $perPageNumber)
                ->order('last_update_time DESC')
                ->select();
        } else {
            //艺术家对外公开的作品
            $where = ['artist' => $artistId, 'is_deleted' => 'N', ['update_times' => ['gt', 0]], 'state' => 1];
            //获取所有数量
            $total = $this->model->field('id,name,update_times')
                ->where($where)
                ->count();

            $artworkList = $this->model
                ->where($where)
                ->field('id,name,update_times AS updateTimes,shape,length,width,diameter,category,cover,panorama_ids,story,last_update_time,
            is_finished AS isFinished, like_total AS likeTotal, view_total AS viewTotal')
                ->page($page, $perPageNumber)
                ->order('last_update_time DESC')
                ->select();
        }
        if (empty($artworkList)) {
            return [];
        }
        $assetsLogic = new AssetsLogic();
        foreach ($artworkList as &$artwork) {
            if (trim($artwork['panorama_ids']) != '') {//有全局图就不显示封面
                $images = explode(',', $artwork['panorama_ids']);
                $img = $images[0];
            } else {
                $img = $artwork['cover'];
            }

            $artwork['liketotal'] = $artworkLikeLogic->total($artwork['id'], 1);

            $catid = $artwork['category'];
            unset($artwork['category']);
            $info = M('ArtworkCategory')->field('cn_name')->find($catid);
            $artwork['category_name'] = empty($info['cn_name']) ? "" : $info['cn_name'];
            $artwork['coverUrl'] = $img;
            unset($artwork['cover']);
            unset($artwork['panorama_ids']);
            $artwork['last_update_time'] = date('Y-m-d H:i', $artwork['last_update_time']);
            $artwork['is_like'] = $artworkLikeLogic->isLike($artwork['id'], 1, $uid);
        }
        $maxpage = $total % $perPageNumber == 0 ? $total / $perPageNumber : intval($total / $perPageNumber) + 1; //最大页数
        $list = [
            // 'flag' => $flag,
            'data' => empty($artworkList) ? [] : $artworkList,
            'page' => $page,
            'total' => $total,
            'pagesize' => $perPageNumber,
            'maxpage' => $maxpage
        ];
        return $list;
    }

    public function getArtworkListByPage2($artistId, $page = 1, $perPageNumber = 1)
    {
        //封面图
        //名称
        //更新次数
        //浏览次数
        //被喜欢次数
        //描述
        $artworkList = $this->model
            ->where(['artist' => $artistId, 'is_deleted' => 'N', ['update_times' => ['gt', 0]], 'state' => 1])
            ->field('id,name,update_times AS updateTimes,shape,length,width,diameter,category,cover,story,last_update_time,
            is_finished AS isFinished, like_total AS likeTotal, view_total AS viewTotal')
            ->page($page, $perPageNumber)
            ->order('last_update_time DESC')
            ->select();
        if (empty($artworkList)) {
            return [];
        }
        $assetsLogic = new AssetsLogic();
        foreach ($artworkList as &$artwork) {
            $catid = $artwork['category'];
            unset($artwork['category']);
            $info = M('ArtworkCategory')->field('cn_name')->find($catid);
            $artwork['category_name'] = $info['cn_name'];
            $artwork['coverUrl'] = Util::getImageResize($artwork['cover'], Image::artworkDetailListWidth, Image::artworkDetailListHeight);
            unset($artwork['cover']);
            $artwork['last_update_time'] = date('Y-m-d H:i', $artwork['last_update_time']);
        }

        return $artworkList;
    }

    //获取所有完成的艺术品
    public function getFinishedList($artistId)
    {
        $artworkList = $this->model
            ->where(['artist' => $artistId, 'is_deleted' => 'N', 'is_finished' => 'Y', 'state' => 1])
            ->field('id,name,update_times AS updateTimes,shape,length,width,diameter,category,panorama_ids,story,last_update_time,
            is_finished AS isFinished, like_total AS likeTotal, view_total AS viewTotal')
            ->order('create_time DESC, last_update_time DESC')
            ->select();
        if (empty($artworkList)) {
            return [];
        }
        $assetsLogic = new AssetsLogic();
        foreach ($artworkList as &$artwork) {
            $catid = $artwork['category'];
            unset($artwork['category']);
            $info = M('ArtworkCategory')->field('cn_name')->find($catid);
            $artwork['category_name'] = $info['cn_name'];
            $arrimg = explode(',', $artwork['panorama_ids']);
            $artwork['panorama'] = Util::getImageToSq($arrimg[0], Image::artworkDetailListWidth, Image::artworkDetailListHeight);
            unset($artwork['panorama_ids']);
            $artwork['last_update_time'] = date('Y-m-d H:i', $artwork['last_update_time']);
        }

        $result = $artworkList;
        Util::jsonReturn(['status' => 1000, 'info' => $result]);

    }

    public function getArtworkList($artistIdList)
    {
        $artworkList = $this->model
            ->where(['artist' => $artistIdList, 'is_deleted' => 'N', 'update_times' => ['gt', 0]])
            ->order('create_time DESC, last_update_time DESC')
            ->select();
        if (empty($artworkList)) {
            return [];
        }
        return $artworkList;
    }

    //get not finished artwork list by artist id && page && perPageCount
    public function getUnFinishedArtworkList($artistId, $page = 1, $perPageCount = 10, $field = 'id, tag_ids,name, artist AS artistId,update_times AS updateTimes')
    {
        $artworkList = $this->model
            ->where(['artist' => $artistId, 'is_deleted' => 'N', 'update_times' => ['gt', 0]])
            ->field($field)
            ->order('last_update_time DESC,create_time DESC')
            ->page($page, $perPageCount)
            ->select();
        return empty($artworkList) ? [] : $artworkList;
    }

    public function getUpdateNumber($artworkId)
    {
        $data = $this->model->where(['id' => $artworkId])->getField('update_times');
        if (empty($data)) {
            return false;
        } else {
            return intval($data);
        }
    }

    public function getMore($id)
    {
        $data = $this->model->where(['id' => $id])->find();
        if (empty($data)) {
            return false;
        } else {
            return $data;
        }
    }

    public function getArtworkDetail($artworkId, $loginUserId = '')
    {
        $data = $this->model->where(['id' => $artworkId, 'is_deleted' => 'N'])->find();
        if ($data['state'] == 2 && $data['artist'] != $loginUserId) {//画作仅自己看的时候，不是作者就隐藏
            return false;
        }
        if (empty($data)) {
            return [];
        } else {
            $artUpdateLogic = new ArtworkUpdateLogic();
            $tagModel = new ArtworkTagModel();
            $userLogic = new UserLogic();
            $cateModel = new ArtworkCategoryModel();
            $categoryLogic = new ArtworkCategoryLogic();
            $artworkLikeLogic = new ArtworkLikeLogic();
            //题材
            $a_subject = M('ArtzheCustom')->field('cn_name')->where(['type' => 2, 'artworkid' => $artworkId])->find();
            //风格
            $a_style = M('ArtzheCustom')->field('cn_name')->where(['type' => 3, 'artworkid' => $artworkId])->find();
            if ($a_subject['cn_name'] == '' && $a_style['cn_name'] == '') {
                //标签
                $a = M('ArtzheCustom')->field('cn_name')->where(['type' => 4, 'artworkid' => $artworkId])->find();
                //$data['tags'] = array_values($tagModel->getTagContent($data['tag_ids']));
                if (strpos("{$a['cn_name']}", "，") !== false) {
                    $a['cn_name'] = str_replace("，", ",", $a['cn_name']);
                }

                if(strpos("{$a['cn_name']}", ",") !== false){
                    $a['cn_name'] = trim($a['cn_name'], ',');
                    $catTag = explode(',', $a['cn_name']);
                } else {
                    $catTag = empty($a['cn_name'])?[]:['0' => $a['cn_name']];
                }
            } else {
                $cat_list_str = $a_subject['cn_name'] . ',' . $a_style['cn_name'];
                $cat_tag = explode(',', $cat_list_str);
                $cat_tag = array_filter($cat_tag);
                //$cat_tag_str=implode(',',$cat_tag);
                $cat_tag = array_values($cat_tag);
                $catTag = $cat_tag;
            }
            $catTag = empty($catTag) ? [] : $catTag;
            $data['tags'] = empty(trim($data['tag_ids'])) ? $catTag : array_values($tagModel->getTagContent($data['tag_ids']));

            $tempcat = '';
            if ($data['category'] != 10) {
                $arr = explode(',', $data['category']);
                foreach ($arr as $kk => $vv) {
                    $rc = M('ArtworkCategory')->field('cn_name')->find($vv);
                    $tempcat .= $rc['cn_name'] . '|';
                }
                $catName = trim($tempcat, '|');
            } else {
                $catName = '其他';
            }

            $artwork_size = '';
            if ($data['shape'] == 1) {
                $artwork_size = $data['length'] > 0 && $data['width'] > 0 ? $data['length'] . 'cm×' . $data['width'] . 'cm' : '';
            } else if ($data['shape'] == 2) {
                $artwork_size = $data['diameter'] > 0 ? 'D=' . $data['diameter'] . 'cm' : '';
            }
            if ($catName == '') {
                $data['category_name'] = $artwork_size;
            } else {
                $data['category_name'] = $artwork_size == '' ? $catName : $catName . '|' . $artwork_size;
            }
            $data['is_like'] = $artworkLikeLogic->isLike($data['id'], 1, $loginUserId);
            $artUpdateList = $artUpdateLogic->field('id,title,artwork_id,number,wit,cover,summary,last_update_time,create_date,create_time')->where("`artwork_id` = {$artworkId} AND `is_deleted` = 'N'")->order('create_date DESC,create_time DESC')->select();
            $lastUpdateId = '';
            $updateCover = [];//作品所有创作记录封面图
            foreach ($artUpdateList as $key => $value) {
                $artwork_name=trim($data['name']);
                if(preg_match("/《(.*)》/",$artwork_name)){
                    $artwork_name = ' ' .$artwork_name. ' ';//trim($artwork_name,'《》');
                }else{
                    $artwork_name = '《' .$artwork_name. '》';
                }
                $artUpdateList[$key]['title'] = empty($value['title'])?$artwork_name.' 花絮':$value['title'];

                if(!empty($value['cover'])){
                    $updateCover[] = $value['cover'];
                }
                $incoverList = Util::extractWitImgUrl($value['wit'], 'org', 'org');
                if (count($incoverList) == 0) {
                    $incoverList = [$value['cover']];
                } else {
                    $incoverList = array_slice($incoverList, 0, 9);
                }
                $artUpdateList[$key]['imageUrl'] = $incoverList;

                if (empty($value['summary'])) {
                    $artUpdateList[$key]['summary'] = html_deconvert_content_cut($value['wit'], 54);
                } else {
                    $artUpdateList[$key]['summary'] = html_deconvert_content_cut($value['summary'], 54);
                }
                $artUpdateList[$key]['is_like'] = $artworkLikeLogic->isLike($data['id'], 2, $loginUserId);
                unset($artUpdateList[$key]['wit']);
                if (!$lastUpdateId) {
                    $lastUpdateId = $value['id'];
                }
            }
            $data['updateList'] = $artUpdateList;

            //作品图片（封面图，全景图，局部图，所有创作记录封面图）
            $coverList = array_merge($data['panorama_ids'] ? explode(',', $data['panorama_ids']) : [], $data['topography_ids'] ? explode(',', $data['topography_ids']) : [], [$data['cover']], $updateCover);
            $data['coverThumbList'] = $coverList;
            //water
            $coverList = Util::imageWaters($coverList);
            $data['coverList'] = $coverList;

            if (empty($data['story'])) {
                $info = $artUpdateLogic->where([
                    'number' => $data['update_times'],
                    'artwork_id' => $data['id']
                ])->find();
                $data['story'] =  html_deconvert_content_cut($info['wit'], 54);
            } else {
                $data['story'] = html_deconvert_content_cut($data['story'], 54);
            }

            $data['story'] = str_replace("\\`", "'", $data['story']);
            $publisher = $userLogic->getUserDesc($data['artist'], $loginUserId);
            $category = $categoryLogic->getCategoryByUser($data['artist']);
            if ($category != '') {
                $publisher['category_name'] = $category;
            } else {
                if (!empty($publisher['category_name'])) {
                    $publisher['category_name'] = str_replace(',', '|', implode(',', $cateModel->getContent($category['category'])));
                } else {
                    $publisher['category_name'] = '';
                }
            }
            unset($publisher['category']);
            //获取喜欢作品的人的头像
            $data['like_images'] = $artworkLikeLogic->getLikesByArtUpdate($artworkId, 'face', 1);
            //喜欢作品总数
            $data['like_total'] = $artworkLikeLogic->total($artworkId, 1);
            $data['publisher'] = $publisher;
            $data['lastUpdateId'] = $lastUpdateId;
            $data['is_edit'] = $data['artist'] == $loginUserId ? 'Y' : 'N';
            $this->where(['id' => $artworkId])->setInc('view_total', 1);

            if (strpos("{$data['name']}}", "《") !== false) {
                $artName = $data['name'];
            } else {
                $artName = '《' . $data['name'] . '》';
            }

            $data['shareTitle'] = "{$publisher['nickname']}{$artName}";
            $data['shareDesc'] = $data['story'];
            $data['shareImg'] = Util::getImgUrlById($data['cover']);
            $data['shareLink'] = C('m_site') . '/artwork/detail/' . $artworkId;
            $data['shareInfo'] = [
                'cover' => $data['cover'],
                'face' => $publisher['face'],
                'name' => $publisher['nickname'],
                'motto' => $publisher['motto'],
                'category' => $categoryLogic->getCategoryByUser($data['artist']),
                'link' => $data['shareLink']
            ];
            return $data;
        }
    }

    public function ArtUpdate($data, $id)
    {
        return $this->where(['id' => $id])->save($data);
    }

    public function getRecommendList($ids, $page = 1, $pagesize = 10)
    {
        $where = ['is_deleted' => 'N'];
        $list = $this->model
            ->field('id,artist,name,cover,update_times,is_finished')
            ->where($where)->order('last_update_time DESC')->page($page, $pagesize)->select();
        foreach ($list as $key => $value) {
            $list[$key]['coverUrl'] = Util::getImageToSq($value['cover'], Image::recommendListWidth, Image::recommendListHeight);
        }
        $total = $this->model->where($where)->count();
        $maxpage = intval($total / $pagesize) + 1;
        return [
            'list' => empty($list) ? [] : $list,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];
    }

    public function getDesc($artId)
    {
        $info = $this->field('id,cover,panorama_ids,is_finished,topography_ids,name,shape,length,width,diameter,color_ids,category,artist,story')->where(['id' => $artId, 'is_deleted' => 'N'])->find();
        if (!empty($info['panorama_ids'])) {
            $info['panorama_ids'] = explode(',', $info['panorama_ids']);
        }
        if (!empty($info['topography_ids'])) {
            $info['topography_ids'] = explode(',', $info['topography_ids']);
        }
        return $info;
    }

    /**
     *获取艺术家创作记录
     */
    public function getArtistRecord($artistId, $page = 1, $pagesize = 1, $uid = 0)
    {
        $artworkModel = M('Artwork');

        $where['az_artwork.artist'] = $artistId;
        if($uid <= 0 || $artistId != $uid){
            $where['az_artwork.state'] = '1';
        }
        $where['az_artwork.is_deleted'] = 'N';
        $where['awu.is_deleted'] = 'N';
        //获取所有数量
        $total = $artworkModel->field('az_artwork.id as artid,awu.id as artupid,az_artwork.name as artname,awu.number as upnumber,az_artwork.category,au.name as uname,awu.wit,awu.last_update_time')
            ->join('JOIN az_artwork_update awu ON az_artwork.id = awu.artwork_id')
            ->join('JOIN az_user au ON az_artwork.artist = au.id')
            ->where($where)
            ->count();


        $thedate = date('Ymd');
        $artinfo = $artworkModel->field("(case when FROM_UNIXTIME(awu.create_time,'%Y%m%d')= '" . $thedate . "' then 999999999+awu.create_time else az_artwork_weight.weight end) as the_order,az_artwork.id as artid,awu.id as artupid,az_artwork.name as artname,awu.number as number,az_artwork.category,au.name as uname,awu.cover,awu.wit,awu.last_update_time,au.face,awu.summary,awu.like_total,awu.view_total,awu.comment_total,awu.title")
            ->join('JOIN az_artwork_update awu ON az_artwork.id = awu.artwork_id')
            ->join('JOIN az_user au ON az_artwork.artist = au.id')
            ->join('az_artwork_weight ON az_artwork.id = az_artwork_weight.artwork_id', 'left')
            ->where($where)
            ->page($page, $pagesize)
            ->order(" FROM_UNIXTIME(awu.create_time,'%Y%m%d') desc,the_order desc,awu.create_time desc")
            ->select();

        $maxpage = $total % $pagesize == 0 ? $total / $pagesize : intval($total / $pagesize) + 1; //最大页数

        $data = [];
        foreach ($artinfo as $k => $v) {
            $data[$k]['artid'] = $v['artid']; //作品id
            $data[$k]['artupid'] = $v['artupid'];  //作品更新id
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
            $data[$k]['number'] = $v['number']; //更新次数编号

            $temp = '';
            if ($v['category'] != 10) {
                $arr = explode(',', $v['category']);
                foreach ($arr as $kk => $vv) {
                    $rc = M('ArtworkCategory')->field('cn_name')->find($vv);
                    $temp .= $rc['cn_name'] . '/';
                }
                $catName = trim($temp, '/');
            } else {
                $catName = '其他';
            }

            $res = M('ArtzheCustom')->field('cn_name')->where(['type' => '1', 'artworkid' => $v['artid']])->find();
            if (strpos("{$res['cn_name']}", "，") !== false) {
                $res['cn_name'] = trim($res['cn_name'], '，');
                $catName2 = str_replace('，', '/', $res['cn_name']);
            } else {
                $res['cn_name'] = trim($res['cn_name'], ',');
                $catName2 = str_replace(',', '/', $res['cn_name']);
            }
            $data[$k]['category'] = $v['category'] != 10 ? $catName : $catName2; //分类名称

            //获取更新记录里面的图片
            preg_match_all('/&lt;img.*?src=&quot;(.*?)&quot;.*?&gt;/is', $v['wit'], $array);
            $data[$k]['imgurl'] = empty($array[1]) ? $v['cover'] : $array[1][0];

            //获取更新记录里面的视频
            //preg_match_all('/&lt;source.*?src=&quot;(.*?)&quot;.*?&gt;/is',$v['wit'],$match);
            preg_match_all('/&lt;video.*?poster=&quot;(.*?)&quot;.*?&gt;/is', $v['wit'], $match);
            $data[$k]['video'] = empty($match[1]) ? '' : $match[1][0];

            $data[$k]['uptime'] = date('Y-m-d H:i:s', $v['last_update_time']); //更新时间
            $data[$k]['like_total'] = $v['like_total'];
            $data[$k]['view_total'] = $v['view_total'];
            $data[$k]['comment_total'] = $v['comment_total'];
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

        Util::jsonReturn(['status' => Code::SUCCESS, 'info' => $my]);
    }

    /**
     * 获取作品同一艺术家的其他作品及落地页所有作品
     * @param $artworkId 有--作品详情的其他作品  无--落地页所有作品
     * @param int $page
     * @param int $pagesize
     *
     */
    public function getArtworks($artworkId, $page = 1, $pagesize = 10)
    {
        //获取所有作品数量
        $total = $this->model->field('id,name')
            ->where(['is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0]])
            ->count();
        if (empty($artworkId)) {//所有
            $allArtwork = $this->model
                ->field('id,name,cover,panorama_ids')
                ->where(['is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0]])
                ->order('last_update_time DESC')
                ->page($page, $pagesize)
                ->select();
            foreach ($allArtwork as $k => $v) {
                if (trim($v['panorama_ids']) != '') {//有全局图就不显示封面
                    $covers = explode(',', $v['panorama_ids']);
                    $cover = $covers[0];
                } else {
                    $cover = Util::getImgUrlById($v['cover']);
                }
                if ($cover) {
                    $allArtwork[$k]['cover'] = empty($v['cover']) && empty($v['panorama_ids']) ? '' : $cover;
                    if (strpos($v['name'], "《") !== false) {
                        $artName = $v['name'];
                    } else {
                        $artName = '《' . $v['name'] . '》';
                    }
                    $allArtwork[$k]['name'] = $artName;
                    unset($allArtwork[$k]['panorama_ids']);
                }
            }
            $data = $allArtwork;
        } else {
            $total--;
            //获取同一艺术家其他作品
            $artworkData = $this->model->field('id,artist')->where(['id' => $artworkId, 'is_deleted' => 'N'])->find();

            $artistArtwork = $this->model
                ->field('id,name,cover,panorama_ids')
                ->where(['artist' => $artworkData['artist'], 'is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0], 'id' => ['neq', $artworkData['id']]])
                ->order('last_update_time DESC')
                ->page($page, $pagesize)
                ->select();
            $artistArtworkCount = $this->model
                ->field('id,name,cover,panorama_ids')
                ->where(['artist' => $artworkData['artist'], 'is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0], 'id' => ['neq', $artworkData['id']]])
                ->count();
            $artistArtworkpage=$artistArtworkCount % $pagesize == 0 ? $artistArtworkCount / $pagesize : intval($artistArtworkCount / $pagesize)+1;

            if ($artistArtworkCount % $pagesize == 0) {
                if($page<=$artistArtworkpage){
                    $data = $artistArtwork;
                }else{
                    //其他艺术家作品
                    $otherArtwork = $this->model
                        ->field('id,name,cover,panorama_ids')
                        ->where(['artist' => ['neq', $artworkData['artist']], 'is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0]])
                        ->order('last_update_time DESC')
                        ->page($page-$artistArtworkpage, $pagesize)
                        ->select();
                    $data = $otherArtwork;
                }
            }else{
                if($page<$artistArtworkpage){
                    $data = $artistArtwork;
                }else if($page==$artistArtworkpage){
                    //其他艺术家作品
                    $otherArtwork = $this->model
                        ->field('id,name,cover,panorama_ids')
                        ->where(['artist' => ['neq', $artworkData['artist']], 'is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0]])
                        ->order('last_update_time DESC')
                        ->page($page-$artistArtworkpage+1, $pagesize - count($artistArtwork))
                        ->select();

                    $data = array_merge($artistArtwork, $otherArtwork);
                }else{
                    //其他艺术家作品
                    $start = $pagesize-$artistArtworkCount % $pagesize;
                    $otherArtwork = $this->model
                        ->field('id,name,cover,panorama_ids')
                        ->where(['artist' => ['neq', $artworkData['artist']], 'is_deleted' => 'N', 'state' => 1, 'update_times' => ['gt', 0]])
                        ->order('last_update_time DESC')
                        ->limit($start+($page-$artistArtworkpage-1)*$pagesize, $pagesize)
                        ->select();
                    $data = $otherArtwork;
                }
            }

            foreach ($data as $k => $v) {
                if (trim($v['panorama_ids']) != '') {//有全局图就不显示封面
                    $covers = explode(',', $v['panorama_ids']);
                    $cover = $covers[0];
                } else {
                    $cover = Util::getImgUrlById($v['cover']);
                }
                if ($cover) {
                    $data[$k]['cover'] = empty($v['cover']) && empty($v['panorama_ids']) ? '' : $cover;
                    if (strpos($v['name'], "《") !== false) {
                        $artName = $v['name'];
                    } else {
                        $artName = '《' . $v['name'] . '》';
                    }
                    $data[$k]['name'] = $artName;
                    unset($data[$k]['panorama_ids']);
                }
            }
        }
        $maxpage = $total % $pagesize == 0 ? $total / $pagesize : intval($total / $pagesize) + 1; //最大页数
        return [
            'data' => empty($data) ? [] : $data,
            'page' => $page,
            'total' => $total,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];

    }
}
