<?php

namespace Api\Logic;

use Api\Base\BaseLogic;
use Api\Model\SubjectApplyModel;
use Api\Model\SubjectModel;

class SubjectLogic extends BaseLogic
{
    //获取主题列表
    public function getList($uid,$page,$pagesize){

        $subjectModel = new SubjectModel();  //实例化主题模块
        $sql = <<<SQL
SELECT id,sub_name,sub_title,cover,description,start_time,end_time
FROM az_subject WHERE status = 0
ORDER BY id DESC
LIMIT %s
SQL;

        //分页查询
        $limit = sql_get_limit($page,$pagesize);
        $sql = sprintf($sql,$limit);
        $data =  $subjectModel->query($sql);

        //查找该用户是否申请专题
        $subjectApplyModel = new SubjectApplyModel();

        foreach ($data as $key=>$value){
            $where['uid'] = $uid;
            $where['subid'] = $value['id'];
            $info = $subjectApplyModel->field('status')->where($where)->find();
            $data[$key]['applyStatus'] = empty($info['status'])?0:$info['status'];
        }

        $count = $subjectModel->count();  //总记录数
        $maxpage = $count%$pagesize==0 ? $count/$pagesize : intval($count/$pagesize)+1; //最大页数

        return [
            'list' => empty($data) ? [] : $data,
            'page' => $page,
            'total' => $count,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];

    }

    //我申请通过的主题
    public function getMyApplyList($uid,$page,$pagesize){

        //实例化申请列表模型
        $subjectApplyModel = new SubjectApplyModel();

        $sql = <<<SQL
SELECT at1.id as artistid,su.id as subid,su.sub_name,su.sub_title,su.cover,su.description,at1.name,at1.shape,at1.length,at1.width,at1.diameter,at1.category,sua.status,su.end_time
FROM az_subject_apply sua LEFT JOIN az_subject su on sua.subid=su.id 
LEFT JOIN az_artwork at1 on sua.artid = at1.id WHERE sua.status != 0 AND sua.uid={$uid}
ORDER BY sua.id DESC
LIMIT %s
SQL;
        //分页查询
        $limit = sql_get_limit($page,$pagesize);
        $sql = sprintf($sql,$limit);
        $data =  $subjectApplyModel->query($sql);

        $sql2 = <<<SQL
SELECT su.sub_name,su.cover,su.description,at1.name,at1.length,at1.width,at1.category
FROM az_subject_apply sua LEFT JOIN az_subject su on sua.subid=su.id 
LEFT JOIN az_artwork at1 on sua.artid = at1.id WHERE sua.status != 0 AND sua.uid={$uid}
SQL;
        $count = count($subjectApplyModel->query($sql2));  //总记录数
        $maxpage = intval($count/$pagesize)+1;  //总页数
        foreach ($data as $key=>$v){
            $catid = $v['category'];
            $info = M('ArtworkCategory')->field('cn_name')->find($catid);
            $data[$key]['category_name'] = $info['cn_name'];
        }

        return [
            'list' => empty($data) ? [] : $data,
            'page' => $page,
            'total' => $count,
            'pagesize' => $pagesize,
            'maxpage' => $maxpage
        ];
    }
}