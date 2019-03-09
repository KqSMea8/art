<?php
/**
 * Created by PhpStorm.
 * User: gsy
 * Date: 2018/7/26
 * Time: 11:48
 */

namespace App10\Logic;

use App10\Base\BaseLogic;

class WxAppGalleryLogic extends BaseLogic
{
    protected $tableName = 'wechatapp_gallery';


    public function getOneGalleryByUnionId($union_id)
    {
        $where['union_id'] = $union_id;
        $where['status'] = ['NEQ', 0];
        $Galleryinfo = $this->where($where)->find();
        return $Galleryinfo;
    }

    public function getGalleryById($gallery_id)
    {
        $where['id'] = $gallery_id;
        $where['status'] = ['NEQ', 0];
        $Galleryinfo = $this->where($where)->find();
        return $Galleryinfo;
    }

    public function AddGallery($data)
    {

        $this->add($data);
        return $this->getLastInsID();

    }

    public function SaveGalleryByIdUnionId($id, $union_id, $data)
    {
        $where['id'] = $id;
        $where['union_id'] = $union_id;
        $res = $this->where($where)->save($data);
        return $res;
    }

    public function AddGalleryPicture($data)
    {
        $gallery_picture_M = M('wechatapp_gallery_picture');
        $gallery_picture_M->add($data);
        return $gallery_picture_M->getLastInsID();

    }

    public function GetGalleryPicture_numByGalleryid($gallery_id)
    {
        $gallery_picture_M = M('wechatapp_gallery_picture');
        $where['gallery_id'] = $gallery_id;
        $where['status'] = ['NEQ', 0];
        $num = $gallery_picture_M->where($where)->count('id');
        return $num;

    }

    public function GetGalleryPictureByGalleryid($gallery_id)
    {
        $gallery_picture_M = M('wechatapp_gallery_picture');
        $where['gallery_id'] = $gallery_id;
        $where['status'] = ['NEQ', 0];
        $list = $gallery_picture_M->where($where)->order('order_num desc')->select();
//        echo $gallery_picture_M->getLastSql();
        return $list;

    }

}