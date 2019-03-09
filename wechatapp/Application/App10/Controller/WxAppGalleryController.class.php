<?php
/**
 * Created by PhpStorm.
 * User: gsy
 * Date: 2018/7/26
 * Time: 11:44
 */

namespace App10\Controller;

use App10\Base\ApiBaseController;
use App10\Logic\WxAppGalleryLogic;
use Custom\Define\Code;
use App10\Logic\UserLogic;
use Custom\Helper\Util;
use Custom\Define\Image;
use App10\Model\UserModel;

class WxAppGalleryController extends ApiBaseController
{
    //保存画廊
    public function SaveGalleryProfile()
    {
        $this->checkLogin();

        $gallery_id = intval(I('post.gallery_id'));
        $user_face= trim(I('post.user_face'));
        $user_summary = I('post.user_summary');

        if ($gallery_id <= 0) {
            Util::jsonReturn(null, Code::PARAM_ERR, '参数错误!');
        }
        if (trim($user_face) == '' && trim($user_summary) == '') {
            Util::jsonReturn(null, Code::PARAM_ERR, '不能为空!');
        }
        $wxAppGalleryLogic = new WxAppGalleryLogic();
        $data['user_face'] = $user_face;
        $data['user_summary'] = $user_summary;
        $wxAppGalleryLogic->SaveGalleryByIdUnionId($gallery_id, $this->loginUnionId, $data);
        Util::jsonReturn(['status' => 1000]);
    }


    //保存画廊
    public function SaveGallery()
    {
        $this->checkLogin();

        $gallery_id = intval(I('post.gallery_id'));
        $gallery_name = trim(I('post.gallery_name'));
        $content = I('post.content');

        if ($gallery_id <= 0) {
            Util::jsonReturn(null, Code::PARAM_ERR, '参数错误!');
        }
        if (trim($gallery_name) == '' && trim($content) == '') {
            Util::jsonReturn(null, Code::PARAM_ERR, '不能为空!');//参数错误
        }
        $wxAppGalleryLogic = new WxAppGalleryLogic();

        $data = [];

        if (trim($gallery_name) != '') {
            $data['gallery_name'] = $gallery_name;
        }
        if (trim($content) != '') {
            $data['content'] = $content;
        }

        if (count($data) > 0) {
            $wxAppGalleryLogic->SaveGalleryByIdUnionId($gallery_id, $this->loginUnionId, $data);
        }
        Util::jsonReturn(['status' => 1000]);


    }

    //添加画廊画作 url content post数组  批量添加

    public function AddGalleryPicture()
    {
        $this->checkLogin();

        $gallery_id = intval(I('post.gallery_id'));
        $url = I('post.url');
        $content = I('post.content');




        if ($gallery_id <= 0) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'gallery_id参数错误!');
        }
        if (!is_array($url)) {
            Util::jsonReturn(null, Code::PARAM_ERR, '画作地址不能为空!');
        }
        if (!is_array($content)) {
            Util::jsonReturn(null, Code::PARAM_ERR, '画作简介不能为空!');
        }
        if (count($url)!=count($content)) {
            Util::jsonReturn(null, Code::PARAM_ERR, '参数错误!');
        }

        $wxAppGalleryLogic = new WxAppGalleryLogic();
        $gallery_info = $wxAppGalleryLogic->getGalleryById($gallery_id);

        if ($gallery_info['union_id'] == $this->loginUnionId) {

            $num = $wxAppGalleryLogic->GetGalleryPicture_numByGalleryid($gallery_id);
            $max_num = 100;
            if ($num >= $max_num) {
                Util::jsonReturn(null, Code::PARAM_ERR, '画廊画作不能超过' . $max_num . '!');
            }

//            for ($i = 0; $i < count($url); $i++) {
                foreach ($url as $key=>$value){
                if(trim($url[$key])==''&&trim($content[$key])==''){
                 continue;
                }
                $data = [
                    'union_id' => $this->loginUnionId,
                    'gallery_id' => $gallery_id,
                    'url' => $url[$key],
                    'content' => $content[$key],
                    'creat_time' => time(),
                    'status' => 1,
                ];
                $inserid = $wxAppGalleryLogic->AddGalleryPicture($data);
            }
            Util::jsonReturn(['status' => 1000]);

        }else{
            Util::jsonReturn(null, Code::PARAM_ERR, '错误!');
        }

    }

    //我的画廊
    public function MyGallery()
    {
        $this->checkLogin();


        $wxAppGalleryLogic = new WxAppGalleryLogic();
        $Gallery_info = $wxAppGalleryLogic->getOneGalleryByUnionId($this->loginUnionId);

        $GENDER_CN_LIST = [
            1 => '男',
            2 => '女',
            3 => '未知'
        ];

        $userInfo = [

            'faceUrl' => Util::getFillImage($Gallery_info['user_face'], Image::faceWidth, Image::faceHeight),
            'nickname' => $Gallery_info['user_nickname'],
            'gender' => $GENDER_CN_LIST[$Gallery_info['user_gender']],
            'motto' => html_entity_decode($Gallery_info['user_summary'], ENT_QUOTES),
        ];



        $list = [];
        if ($Gallery_info) {
            $Picture_list = $wxAppGalleryLogic->GetGalleryPictureByGalleryid($Gallery_info['id']);
            foreach ($Picture_list as $key => $value) {
                $Picture = [
                    'id' => $value['id'],
                    'url' => $value['url'],
                    'content' => $value['content'],
                ];
                $list[] = $Picture;
            }
        }

        $galleryinfo['id'] = $Gallery_info['id'];
        $galleryinfo['user_face'] = $Gallery_info['user_face'];
        $galleryinfo['user_summary'] = $Gallery_info['user_summary'];
        $galleryinfo['gallery_name'] = $Gallery_info['gallery_name'];
        $galleryinfo['content'] = $Gallery_info['content'];
        $galleryinfo['creat_time'] = date('Y-m-d', $Gallery_info['creat_time']);
        $galleryinfo['list'] = $list;


        $info = [
            'userinfo' => $userInfo,
            'galleryinfo' => $galleryinfo,

        ];

        Util::jsonReturn(['status' => 1000, 'info' => $info]);

    }

    //删除画廊画作
    public function DeleteGalleryPicture()
    {
        $this->checkLogin();

        $picture_id = intval(I('post.picture_id'));
        if ($picture_id <= 0) {
            Util::jsonReturn(null, Code::PARAM_ERR, '参数错误!');
        }

        $gallery_picture_M = M('wechatapp_gallery_picture');
        $where['id'] = $picture_id;
        $where['status'] = ['NEQ', 0];
        $where['union_id'] = $this->loginUnionId;
        $gallery_picture_M->where($where)->save(['status' => 0]);


        Util::jsonReturn(['status' => 1000]);
    }

    //点赞或者取消点赞
    public function ZanGallery()
    {
        $this->checkLogin();

        $gallery_id = intval(I('post.gallery_id'));
        $type = I('post.type');

        if ($gallery_id <= 0) {
            Util::jsonReturn(null, Code::PARAM_ERR, '参数错误!');
        }

        $wxAppGalleryLogic = new WxAppGalleryLogic();
        $gallery_info = $wxAppGalleryLogic->getGalleryById($gallery_id);
        if (!$gallery_info) {
            Util::jsonReturn(null, Code::NOT_FOUND, '不存在!');
        }

        //点赞/取消点赞
        $status = $type == 'unlike' ? -1 : 1;

        $wechatapp_gallery_like_M = M('wechatapp_gallery_like');

        $where_find['gallery_id'] = $gallery_id;
        $where_find['union_id'] = $this->loginUnionId;
        $where_find['status'] = ['NEQ', 0];
        $wechatapp_gallery_like_info = $wechatapp_gallery_like_M->where($where_find)->find();
        if ($wechatapp_gallery_like_info) { //存在就修改点赞状态
            $data = [
//                'creat_time' => time(),
                'status' => $status,
            ];
            $wechatapp_gallery_like_M->where($where_find)->save($data);

            Util::jsonReturn(['status' => 1000]);
        } else {//插入新记录

            $data = [
                'union_id' => $this->loginUnionId,
                'gallery_id' => $gallery_id,
                'creat_time' => time(),
                'status' => 1,//不存在的记录，默认点赞
            ];
            $wechatapp_gallery_like_M->add($data);
            Util::jsonReturn(['status' => 1000]);
        }


    }



    public function ShowGallery()
    {
        $gallery_id = intval(I('post.gallery_id'));

        if ($gallery_id <= 0) {
            Util::jsonReturn(null, Code::PARAM_ERR, '参数错误!');
        }


        $wxAppGalleryLogic = new WxAppGalleryLogic();

        $Gallery_info = $wxAppGalleryLogic->getGalleryById($gallery_id);
        if (!$Gallery_info) {
            Util::jsonReturn(null, Code::NOT_FOUND, '不存在!');
        }


        $GENDER_CN_LIST = [
            1 => '男',
            2 => '女',
            3 => '未知'
        ];

        $userInfo = [

            'faceUrl' => Util::getFillImage($Gallery_info['user_face'], Image::faceWidth, Image::faceHeight),
            'nickname' => $Gallery_info['user_nickname'],
            'gender' => $GENDER_CN_LIST[$Gallery_info['user_gender']],
            'motto' => html_entity_decode($Gallery_info['user_summary'], ENT_QUOTES),
        ];



        $list = [];
        if ($Gallery_info) {
            $Picture_list = $wxAppGalleryLogic->GetGalleryPictureByGalleryid($Gallery_info['id']);
            foreach ($Picture_list as $key => $value) {
                $Picture = [
                    'id' => $value['id'],
                    'url' => $value['url'],
                    'content' => $value['content'],
                ];
                $list[] = $Picture;
            }
        }

        $galleryinfo['id'] = $Gallery_info['id'];
        $galleryinfo['gallery_name'] = $Gallery_info['gallery_name'];
        $galleryinfo['content'] = $Gallery_info['content'];
        $galleryinfo['creat_time'] = date('Y-m-d', $Gallery_info['creat_time']);
        $galleryinfo['list'] = $list;

        //点赞
        $have_like=0; //登录用户是否已经点赞过
        if($this->loginUnionId!='') {
            $wechatapp_gallery_like_M = M('wechatapp_gallery_like');
            $where_find['gallery_id'] = $gallery_id;
            $where_find['union_id'] = $this->loginUnionId;
            $where_find['status'] = 1;
            $wechatapp_gallery_like_info = $wechatapp_gallery_like_M->where($where_find)->find();
            if($wechatapp_gallery_like_info){
                $have_like=1;
            }
        }


        $info = [
            'userinfo' => $userInfo,
            'galleryinfo' => $galleryinfo,
            'is_like' => $have_like,

        ];

        Util::jsonReturn(['status' => 1000, 'info' => $info]);

    }


    //修改画廊画作简介 批量修改
    public function SaveGalleryPictureContent()
    {
        $this->checkLogin();

        $id = I('post.id');
        $content = I('post.content');

        if (!is_array($id)) {
            Util::jsonReturn(null, Code::PARAM_ERR, 'id不能为空!');
        }
        if (!is_array($content)) {
            Util::jsonReturn(null, Code::PARAM_ERR, '画作简介不能为空!');
        }
        $gallery_picture_M = M('wechatapp_gallery_picture');
//        for ($i = 0; $i < count($id); $i++) {
            foreach ($id as $key=>$value){
            if (trim($id[$key]) == '' && trim($content[$key]) == '') {
                continue;
            }
            $data = [
                'content' => $content[$key],
            ];
            $where['id'] = $id[$key];
            $where['union_id'] = $this->loginUnionId;
            $gallery_picture_M->where($where)->save($data);

        }
        Util::jsonReturn(['status' => 1000]);

    }
}