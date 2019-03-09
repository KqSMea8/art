<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Api\Logic\ArtworkLogic;
use Api\Logic\CommentLogic;
use Api\Logic\UserLogic;
use Api\Logic\ArtworkLikeLogic;
use Api\Logic\ArtworkCategoryLogic;
use Custom\Define\Image;
use Custom\Helper\Util;
use Api\Model\ArtworkCategoryModel;

class ArtworkUpdateLogic extends BaseLogic
{
    public function getLastUpdateCover($artworkId)
    {
        return $this->model->where(['artwork_id' => $artworkId])->order('id DESC')->getField('cover');
    }

    public function getLastUpdateDetail($artworkId)
    {
        $data = $this->model->where(['artwork_id' => $artworkId])->order('id DESC')->find();
        if (empty($data)) {
            return [];
        } else {
            return $data;
        }
    }

    //单次创作记录相关推荐
    public function related($upId)
    {
        $artLogic = new ArtworkLogic();
        $categoryLogic = new ArtworkCategoryLogic();
        $userLogic = new UserLogic();
        $cateModel = new ArtworkCategoryModel();
        $info = $this->where(['id' => $upId])->find();
        $artInfo = $artLogic->where(['id' => $info['artwork_id']])->find();
        //获取单次创作记录同一作品的其他创作记录
        $list = $this->field('id,title,artist,artwork_id,number,wit,summary,create_date,cover,like_total,view_total,comment_total,share_total')->where("artwork_id = {$info['artwork_id']} AND id != {$upId} and is_deleted='N'")->order('create_date asc,create_time asc')->select();

        if (empty($list)) {
            //获取同一艺术家的创作记录，
            $my = $this->field('id,artist,artwork_id,number,wit,summary,create_date,cover,like_total,view_total,comment_total,share_total')->where("artist = {$artInfo['artist']} AND id!= {$upId}  and is_deleted='N'")->order('create_date desc,create_time desc')->limit(5)->select();
            if (!$my) {//没有数据，就显示同类型的艺术品更新 ,随机查询用缓存
                $my_cache_key = 'artzhe_updateDetail_related' . intval($artInfo['category']);
                $my = S($my_cache_key);
                if (!$my) {
                    $my = $this
                        ->join('az_artwork B ON B.id=az_artwork_update.artwork_id')
                        ->field('B.cover,az_artwork_update.artist,az_artwork_update.id,az_artwork_update.artwork_id,az_artwork_update.number,az_artwork_update.wit,az_artwork_update.summary,az_artwork_update.create_date,az_artwork_update.like_total,az_artwork_update.view_total,az_artwork_update.comment_total,az_artwork_update.share_total')
                        ->where(" B.category=" . intval($artInfo['category']) . " and B.state=1 and B.is_deleted='N' and az_artwork_update.is_deleted='N' AND az_artwork_update.id!= {$upId}")
                        ->order("RAND()")->limit(5)->select();
                    S($my_cache_key, $my, 1800);
                }
                //S($my_cache_key, null);
            }
            foreach ($my as $k => $v) {
                $images = Util::getHtmlImgSrc($v['wit']);
                $coverImg = $images[0] == '' ? $v['cover'] : $images[0];
                $my[$k]['cover'] = $coverImg;
                $res = $artLogic->field('name,category')->find($v['artwork_id']);

                $artwork_name=trim($res['name']);
                if(preg_match("/《(.*)》/",$artwork_name)){
                    $artwork_name = ' ' .$artwork_name. ' ';//trim($artwork_name,'《》');
                }else{
                    $artwork_name = '《' .$artwork_name. '》';
                }
                $my[$k]['name'] = empty($v['title'])?$artwork_name.' 花絮':$v['title'];

                //艺术家信息
                $artistInfo = $userLogic->getUserInfo($v['artist'],$field='id,name,face,category');
                $my[$k]['artist_info'] = $artistInfo;
                //分类信息
                if($res['category'] == 10){
                    //艺术家自定义分类
                    $res2 = M('ArtzheCustom')->field('cn_name')->where(['artworkid' => $v['artwork_id'], 'type' => 1])->find();
                    if (strpos("{$res2['cn_name']}", "，") !== false) {
                        $res2['cn_name'] = trim($res2['cn_name'], '，');
                        $catName2 = str_replace('，', '/', $res2['cn_name']);
                    } else {
                        $res2['cn_name'] = trim($res2['cn_name'], ',');
                        $catName2 = str_replace(',', '/', $res2['cn_name']);
                    }
                    $category = ($catName2 == '') ? $categoryLogic->getCategoryByUser($v['artist']) : $catName2;
                }else if($res['category'] == -1){
                    $category = $categoryLogic->getCategoryByUser($v['artist']);
                }else{
                    $category = str_replace(',', '/', implode(',',$cateModel->getContent($artInfo['category'])));
                }
                $my[$k]['category'] = $category;
                $my[$k]['summary'] = empty($v['summary'])?html_deconvert_content_cut($v['wit'], 45):$v['summary'];
                unset($my[$k]['artwork_id']);
                unset($my[$k]['wit']);
            }
            return $my;
        } else {
            foreach ($list as $key => $value) {
                $images = Util::getHtmlImgSrc($value['wit']);
                $coverImg = $images[0] == '' ? $value['cover'] : $images[0];
                $coverImg = trim($coverImg) == '' ? $artInfo['cover'] : $coverImg;
                $list[$key]['cover'] = $coverImg;

                $artwork_name=trim($artInfo['name']);
                if(preg_match("/《(.*)》/",$artwork_name)){
                    $artwork_name = ' ' .$artwork_name. ' ';//trim($artwork_name,'《》');
                }else{
                    $artwork_name = '《' .$artwork_name. '》';
                }
                $list[$key]['name'] = empty($value['title'])?$artwork_name.' 花絮':$value['title'];


                //艺术家信息
                $artistInfo = $userLogic->getUserInfo($value['artist'],$field='id,name,face,category');
                $list[$key]['artist_info'] = $artistInfo;
                //分类信息
                if($artInfo['category'] == 10){
                    //艺术家自定义分类
                    $res2 = M('ArtzheCustom')->field('cn_name')->where(['artworkid' => $artInfo['artwork_id'], 'type' => 1])->find();
                    if (strpos("{$res2['cn_name']}", "，") !== false) {
                        $res2['cn_name'] = trim($res2['cn_name'], '，');
                        $catName2 = str_replace('，', '/', $res2['cn_name']);
                    } else {
                        $res2['cn_name'] = trim($res2['cn_name'], ',');
                        $catName2 = str_replace(',', '/', $res2['cn_name']);
                    }
                    $category = ($catName2 == '') ? $categoryLogic->getCategoryByUser($value['artist']) : $catName2;
                }else if($artInfo['category'] == -1){
                    $category = $categoryLogic->getCategoryByUser($value['artist']);
                }else{
                    $category = str_replace(',', '/', implode(',',$cateModel->getContent($artInfo['category'])));
                }
                $list[$key]['category'] = $category;
                $list[$key]['summary'] = empty($value['summary'])?html_deconvert_content_cut($value['wit'], 45):$value['summary'];
                unset($list[$key]['wit']);
            }
            return $list;
        }
    }

    public function getDetailWithComment($id, $loginUid)
    {
        $artLogic = new ArtworkLogic();
        $commentLogic = new CommentLogic();
        $userLogic = new UserLogic();
        $artLikeLogic = new ArtworkLikeLogic();
        $cateModel = new ArtworkCategoryModel();
        $categoryLogic = new ArtworkCategoryLogic();
        $updateInfo = $this->where(['id' => $id, 'is_deleted' => 'N'])->find();

        if (!$updateInfo) {
            return false;
        }
        $artInfo = $artLogic->where(['id' => $updateInfo['artwork_id'], 'is_deleted' => 'N'])->find();
        if ($artInfo['state'] == 2 && $artInfo['artist'] != $loginUid) {//画作仅自己看的时候，不是作者就隐藏
            return false;
        }
        $max = 1000000;
        $commentList = $commentLogic->getList($updateInfo['id'], 2, 1, $max, $loginUid);

        //去掉音频
        $cutAudioWit = $this->cutAudioPlayBox($updateInfo['wit']);
        //获取创作心路中的一半内容
        $updateInfo['wit'] = htmlspecialchars_decode($cutAudioWit);

        $witLenth = mb_strlen($updateInfo['wit'], "utf-8");
        $updateInfo['wit'] = Util::cut_html_str($updateInfo['wit'], $witLenth / 2, '');
        //获取创作心路中的图片链接
        //$orgImgs = Util::extractWitImgUrl($updateInfo['wit'], 'org', 'org');
        preg_match_all('/img.*?src="(.*?)"/',$updateInfo['wit'],$match);
        $imgUrls = $match[1];//Util::getHtmlImgSrc($updateInfo['wit']);
       // return ['img'=>$imgUrls];
        $fillImgUrls = $imgUrls;
        //替换创作心路中的imagurl
        $updateInfo['wit'] = $this->replaceHtmlImgSrc($imgUrls, $updateInfo['wit']);
        $this->where(['is_deleted' => 'N', 'id' => $updateInfo['id']])->setInc('view_total');

        $publisher = $userLogic->getUserField('id,nickname,face', $artInfo['artist']);
        $artistid = key($publisher);
        $artistname = $publisher[$artistid];

        //获取喜欢创作记录的人的头像
        $likes = $artLikeLogic->getLikesByArtUpdate($updateInfo['id'], 'face', 2);
        $publisherInfo = $userLogic->getUserDesc($artInfo['artist'], $loginUid);
        $category = $categoryLogic->getCategoryByUser($artInfo['artist']);
        if($category != ''){
            $publisherInfo['category_name'] = $category;
        }else {
            if (!empty($publisher['category_name'])) {
                $publisherInfo['category_name'] = str_replace(',', '|', implode(',', $cateModel->getContent($category['category'])));
            } else {
                $publisherInfo['category_name'] = '';
            }
        }
        unset($publisherInfo['category']);


        //艺术家自定义标签
        $res = M('ArtzheCustom')->field('cn_name')->where(['artworkid' => $updateInfo['artwork_id'], 'type' => 4])->find();
        //艺术家自定义分类
        $res2 = M('ArtzheCustom')->field('cn_name')->where(['artworkid' => $updateInfo['artwork_id'], 'type' => 1])->find();
        if (strpos("{$res2['cn_name']}", "，") !== false) {
            $res2['cn_name'] = trim($res2['cn_name'], '，');
            $catName2 = str_replace('，', '/', $res2['cn_name']);
        } else {
            $res2['cn_name'] = trim($res2['cn_name'], ',');
            $catName2 = str_replace(',', '/', $res2['cn_name']);
        }

        if (strpos("{$artInfo['name']}", "《") !== false) {
            $artName = $artInfo['name'];
        } else {
            $artName = '《' . $artInfo['name'] . '》';
        }

        if (strpos("{$res['cn_name']}", "，") !== false) {
            $res['cn_name'] = str_replace("，", ",", $res['cn_name']);
            $res['cn_name'] = trim($res['cn_name'], ',');
            $catTag = explode(',', $res['cn_name']);
        } elseif (strpos("{$res['cn_name']}", ",") !== false) {
            $res['cn_name'] = str_replace("，", ",", $res['cn_name']);
            $res['cn_name'] = trim($res['cn_name'], ',');
            $catTag = explode(',', $res['cn_name']);
        } else {
            $catTag = ['0' => $res['cn_name']];
        }
        $catTag = empty($catTag) ? [] : $catTag;

        $artwork_name=trim($artInfo['name']);
        if(preg_match("/《(.*)》/",$artwork_name)){
            $artwork_name = ' ' .$artwork_name. ' ';//trim($artwork_name,'《》');
        }else{
            $artwork_name = '《' .$artwork_name. '》';
        }
        $title = empty($updateInfo['title'])?$artwork_name.' 花絮':$updateInfo['title'];
        //water
        return [
            'id' => $updateInfo['id'],
            'artwork_id' => $updateInfo['artwork_id'],
            'artname' => $title,
            //'orgImages' => Util::imageWaters($orgImgs),
            'orgImages' => self::thumbnails($imgUrls),
            //'thumbnail' => self::thumbnails($orgImgs),
            'time' => $updateInfo['create_date'],
            'artistid' => $artistid,
            'publisher' => $publisherInfo['nickname'],
            'wit' => $updateInfo['wit'],
            'cover' => $updateInfo['cover'],
            'tags' => empty($res['cn_name']) ? [] : $catTag,
            'commentList' => $commentList['list'],
            'commentTotal' => $commentList['total'],
            'is_repay' => $loginUid == $artInfo['artist'] ? 'Y' : 'N',
            'is_edit' => $loginUid == $artInfo['artist'] ? 'Y' : 'N',
            'is_finished' => $artInfo['is_finished'],
            'is_like' => $artLikeLogic->islike($updateInfo['id'], '2', $loginUid),
            'likes' => $likes,
            'number' => $updateInfo['number'],
            //'like_total' => $artLikeLogic->total($updateInfo['id'],2),
            'like_total' => $updateInfo['like_total'],
            'view_total' => $updateInfo['view_total'],
            'create_time' => date('Y-m-d', $updateInfo['create_time']),
            'publisherInfo' => $publisherInfo,
            'shareTitle' => "{$publisherInfo['nickname']}{$artName}更新 {$updateInfo['number']}",
            'shareDesc' => empty($updateInfo['summary'])?html_deconvert_content_cut($updateInfo['wit'], 45):$updateInfo['summary'],
            'shareImg' => Util::getImgUrlById($artInfo['cover']),
            'shareLink' => C('www_site') . '/artwork/update/' . $id,
            'related' => $this->related($updateInfo['id']),
            'shareInfo' => [
                'cover' => $updateInfo['cover'],
                'face' => $publisherInfo['face'],
                'name' => $publisherInfo['nickname'],
                'motto' => $publisherInfo['motto'],
                'category' => $artInfo['category'] != 10 || ($artInfo['category'] == 10 && $catName2 == '') ? $categoryLogic->getCategoryByUser($artInfo['artist']) : $catName2,
                'link' => C('www_site') . '/artwork/update/' . $id
            ]
        ];
    }

    private static function thumbnails($images)
    {//加水印，质量压缩

        foreach ($images as $key => $image) {
            $obj = Util::waterObject($image);
            $images[$key] = $image . '?x-oss-process=image/watermark,image_' . $obj . ',t_50,g_se,x_10,y_10/quality,q_50';
        }
        return $images;
    }

    public static function replaceHtmlImgSrc($find, $content)
    {
        foreach ($find as $key => $value) {
            $content = str_replace($value, $value . '?x-oss-process=image/resize,m_fixed,w_702,q=50,image/format,jpg', $content);
        }
        return $content;
    }

    /**
     *去掉<p contenteditable="false" class="audioPlayBox">。。。 </p>
     * @param $content
     * @return mixed
     */
    public static function cutAudioPlayBox($content)
    {
        $match = [];
        preg_match_all('/(&lt;\bp\b\scontenteditable=&quot;false&quot;.*?class=&quot;audioPlayBox&quot;.*?\bp\b&gt;)/', $content, $match);
        foreach ($match[1] as $key => $value) {
            $content = str_replace($value, '', $content);
        }
        return $content;
    }



}
