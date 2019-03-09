<?php

namespace Api\Controller;

use Api\Base\ApiBaseController;
use Custom\Helper\Util;
use Custom\Define\Code;


class WebsiteConfigController extends ApiBaseController {
    //获取网站首页配置--图片，艺术家，动态
    public function getWebConfig()
    {
        //$size = I('post.size','5','number_int');
        //获取网站首页轮播图片
        $image = M('website_lunbo_img');
        $images=$image->limit(5)->order("num asc")->select();
        //获取网站首页轮播艺术家
        $author = M('website_lunbo_author');
        $authors=$author->order("num asc")->select();
        //获取网站首页轮播艺术家
        $news = M('website_news');
        $newsLists=$news->field('id,title,news_date,type,url')->limit(5)->order("news_date desc")->select();
        foreach($newsLists as $key => $value){
            if($value['type'] == 1){
                $newsLists[$key]['url']=C('www_site') . '/Artzhe/News/getNewsDetail?id=' . $value['id'];
            }else{
                $newsLists[$key]['url']=$value['url'];
            }
            $newsLists[$key]['news_date'] = date('Y-m-d',$value['news_date']);
        }
        $lists = array(
            'images' => $images,
            'authors' => $authors,
            'news' => $newsLists,
        );
        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$lists]);
    }
    //获取网站首页轮播图片
    public function getImageLunbo()
    {
        $size = I('post.size','5','int');
        $image = M('website_lunbo_img');
        $lists=$image->limit($size)->order("num asc")->select();
        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$lists,'size'=>count($lists)]);
    }

    //获取网站首页轮播艺术家
    public function getAuthorLunbo()
    {
        $size = I('post.size','5','int');
        $author = M('website_lunbo_author');
        $lists=$author->limit($size)->order("num asc")->select();
        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$lists,'size'=>count($lists)]);
    }

    //获取网站最新动态
    public function getNews()
    {
        $page = I('post.page','1','int'); //分页页码
        $pagesize = I('post.pagesize', '5', 'int'); //每页显示条数
        $news = M('website_news');
        $lists=$news->field('id,title,news_date,type,url')->order("news_date desc")->page($page,$pagesize)->select();
       foreach($lists as $key => $value){
           if($value['type'] == 1){
               $lists[$key]['url']=C('www_site') . '/Artzhe/News/getNewsDetail?id=' . $value['id'];
           }else{
               $lists[$key]['url']=$value['url'];
           }
           $lists[$key]['news_date'] = date('Y-m-d',$value['news_date']);
       }
        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$lists,'page'=>$page,'pagesize'=>count($lists)]);
    }

    //获取网站最新动态详情
    public function getNewsDetail()
    {
        $id = I('get.id','','number_int'); //数据id
        $news = M('website_news');
        $where['id'] = $id;
        $lists=$news->field('title,content,createtime,view_total')->where($where)->find();
        $news->where($where)->setInc('view_total');
        $lists['content'] = htmlspecialchars_decode($lists['content']);
        Util::jsonReturn(['status'=>Code::SUCCESS, 'info'=>$lists,'id'=>$id]);
    }

}