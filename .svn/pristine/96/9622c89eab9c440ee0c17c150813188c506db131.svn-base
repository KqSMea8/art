<?php
namespace Artzhe\Controller;
use Think\Controller;
class NewsController extends Controller {
    public function index(){
        $this->display();
    }

    //获取网站最新动态详情
    public function getNewsDetail()
    {
        $id = I('get.id','','number_int'); //数据id
        $news = M('website_news');
        $where['id'] = $id;
        $lists=$news->field('title,content,news_date,view_total')->where($where)->find();
        $news->where($where)->setInc('view_total');
        $lists['content'] = htmlspecialchars_decode($lists['content']);
        $lists['news_date'] = date('Y-m-d H:i:s', $lists['news_date']);
        //Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$lists,'id'=>$id]);
        $this->assign('data', $lists);
        $this->display('detail');
    }
}