<?php
namespace Artzhe\Controller;
use Think\Controller;
class InfoController extends Controller {
    public function index(){
        $this->display();
    }

    //获取seo落地页文章列表页面
    public function info()
    {
        $page = I('get.page','1','int'); //分页页码
        $pagesize = I('get.pagesize', '40', 'int'); //每页显示条数
        $seo = M('seo_article');
        $where['status'] = 1;//审核通过
        $lists = $seo->where($where)->field('id,title,source_time')->order("id desc")->page($page, $pagesize)->select();
        $total = $seo->where($where)->field('id,title,source_time')->count();
        $maxpage = $total % $pagesize == 0 ? $total / $pagesize : intval($total / $pagesize) + 1; //最大页数

        foreach ($lists as $key => $value) {
            $url =  C('www_site') . '/Artzhe/Info/getDetail/?id=' . $value['id'];
            //$url =  U(C('www_site') . '/Artzhe/Seo/getSeoDetail',['id'=>$value['id']]);
            echo '<div><a href="' . $url . '" >' . $value['title'] . '</a></div>';
        }
        echo '<div>';
        if ($page > 1) {
            echo '<a href="info?page=1">首页</a>&nbsp;&nbsp;
            <a href="info?page='.($page-1).'">上一页</a>&nbsp;&nbsp;';
        }
        //显示下一页和尾页的条件
        if ($page < $maxpage) {
            echo '<a href="info?page='.($page+1).'">下一页</a>&nbsp;&nbsp;
            <a href="info?page='.$maxpage.'">尾页</a>';
        }
        echo '</div>';
    }

    //获取seo落地页文章详情
    public function getDetail()
    {
        $id = I('get.id', '', 'number_int'); //数据id
        $seo = M('seo_article');
        $where['id'] = $id;
        $where['status'] = 1;//审核通过
        $lists = $seo->field('title,content,source_site,create_time,view_total')->where($where)->find();
        if(empty($lists)){//跳转到首页
            $this->error('页面不存在','https://www.artzhe.com/Index/index');
        }else{
            $seo->where($where)->setInc('view_total');
            $lists['content'] = htmlspecialchars_decode($lists['content']);
           // $lists['content'] = preg_replace("/<a[^>]*>(.*?)<\/a>/is", "/<span[^>]*>(.*?)<\/span>/is", $lists['content']);
            $lists['content'] = preg_replace("/<a[^>]*>/", "<span>", $lists['content']);
            $lists['content'] = preg_replace("/<\/a>/", "</span>", $lists['content']);
            $lists['source_time'] = date('Y-m-d H:i:s', $lists['create_time']);
            $this->assign('data', $lists);
            $this->display('detail');
        }
    }
}