<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>讨论详情</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="/Public/js/lib/mescroll/mescroll.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.3">
    <link rel="stylesheet" href="/Public/css/discussion/details.css">
</head>
<body>
    <section id="discussionList" v-cloak>
        <!-- TODO: 话题详情列表 -->
        <section id="mescrollup" class="mescroll listbox">
            <div class="toptalk">
                <p @click="linkto" class="t_title">@{{topHot.title}}</p>
                <p class="ellipsis t_seenum">@{{topHot.view_num}}人浏览</p>
                <p @click="linkto" class="t_content">@{{topHot.content}}</p>
                <section class="t_talkinfo">
                    <div class="info">
                        <img class="avatar" :src="topHot.face" >
                        <div class="namebox">
                            <span class="ellipsis name">
                                @{{topHot.nickname}}
                            </span>
                            <span> 发起</span>
                        </div>
                    </div>
                </section>
                <div @click="toggleFollow" class="followbox" :class="['follow', topHot.is_follow == 'Y'? 'followed': '']">
                    <span v-if="topHot.is_follow =='N'" class="followssd">+关注</span>
                    <span v-else class="followeded">已关注</span>
                </div>
            </div>
            <ul class="tabfordiscussion">
                <li @click="tabfordisc(0)" :class="{active:tabactive==0}">按热门</li>
                <li @click="tabfordisc(1)" :class="{active:tabactive==1}">按时间</li>
            </ul>
            <div class="discusslistbox">
                <div id="mescroll1" v-show="tabactive==0" class="mescrollhot msbox">
                    <ul id="dataList" class="clearfix  data-list">
                        <li class="othlist" v-for="item in list">
                            <div class="info">
                                    <img class="avatar" :src="item.userinfo.faceUrl" >
                                <div class="clearfix det">
                                    <p class="fl name">
                                        @{{item.userinfo.nickname}}
                                        <template>
                                            <i v-if="item.userinfo.is_artist == 1" class="icons icon-artist"></i>
                                            <i v-if="item.userinfo.is_agency == 1" :class="['icons', 'icon-agency', 'icon-agency-'+item.userinfo.AgencyType]"></i>
                                            <i v-if="item.userinfo.is_planner == 1" class="icons icon-planner"></i>
                                        </template>
                                    </p>
                                    <span class="fr time">@{{item.datetime}}</span>
                                </div>
                            </div>
                            <p @click="linkto(item.id)" class="othercontent">@{{item.content}}</p>
                            <template>
                                <div v-if="item.images_url.length>0" @click="linkto(item.id)" class="otherimgbox">
                                    <img v-for="img in item.images_url" class="otherimg" :src="img" alt="">
                                </div>
                                <div v-else @click="linkto(item.id)" class="otherimgbox">
                                    <div class="othervideo" :style="{backgroundImage:'url('+item.video_poster+')'}"></div>
                                </div>
                            </template>
                            <div class="shownum">
                                <div @click="linkto(item.id)" class="likebox">
                                    <i class="icon-likebtn"></i>
                                    <i class="num">@{{item.like_count}}</i>
                                        
                                </div>
                                <div @click="linkto(item.id)" class="relpaynumbox">
                                    <i class="icon-comment"></i>
                                    <i class="num">@{{item.comment_count}}</i>
                                </div>
                                <div @click="linkto(item.id)" class="forwardbox">
                                    <i class="icon-sharebtn"></i>
                                    <i class="num">@{{item.share_count}}</i>
                                </div>
                            </div>
                        </li>
                        <div v-show="1" class="getmorebox">
                            <span class="getmorebtn">查看更多内容</span>
                        </div>
                    </ul>
                </div>
                <div id="mescroll2" v-show="tabactive==1" class="msbox">
                    <ul id="dataList2"class="clearfix data-list">
                        <li v-for="dlist in list2" class="othlist">
                            <div class="info">
                                    <img class="avatar" :src="dlist.userinfo.faceUrl" >
                                <div class="clearfix det">
                                    <p class="fl name">
                                        @{{dlist.userinfo.nickname}}
                                    <i class=" icons icon-artist"></i>
                                    </p>
                                    <span class="fr time">@{{dlist.datetime}}</span>
                                </div>
                            </div>
                            <p @click="linkto(item.id)" class="othercontent">@{{dlist.content}}</p>
                            <template>
                                <div v-if="dlist.images_url.length>0" @click="linkto(item.id)" class="otherimgbox">
                                    <img v-for="img in dlist.images_url" class="otherimg" :src="img" alt="">
                                </div>
                                <div v-else-if="dlist.video_url !=''" @click="linkto(item.id)" class="otherimgbox">
                                    <div class="othervideo" :style="{backgroundImage:'url('+dlist.video_poster+')'}"></div>
                                </div>
                                <div v-else></div>
                            </template>
                            <div class="shownum">
                                <div @click="linkto(item.id)" class="likebox">
                                    <i class="icon-likebtn"></i>
                                    <i class="num">33</i>
                                        
                                </div>
                                <div @click="linkto(item.id)" class="relpaynumbox">
                                    <i class="icon-comment"></i>
                                    <i class="num">33</i>
                                </div>
                                <div @click="linkto(item.id)" class="forwardbox">
                                    <i class="icon-sharebtn"></i>
                                    <i class="num">33</i>
                                </div>
                            </div>
                        </li>
                        <div v-show="list2.total>1" class="getmorebox">
                            <span class="getmorebtn">查看更多内容</span>
                        </div>
                    </ul>
                </div>
            </div>
        </section>
        <!-- <div id="message-frame" class="message-frame">
        <form id="message-form" @submit.prevent="commentUpdate('下载艺术者APP即可点评文章~')">
          <input type="text" id="message" :class="{'active':btnShow}" v-model="commentContent" placeholder="此刻写下来的就是艺术">
          <i v-show="!btnShow" class="icons icon-share" @click="showShare"></i>
          <div v-show="!btnShow" class="mess-icon icon_po" style="float: right; position: relative;" @click="toggleLike('感谢您的喜欢，立即下载APP查看更多文章吧~')">
            <i :class="['icons', isLike?'icon-liked': 'icon-like']"></i>
            <span v-if="update.like_count > 0" class="num">@{{update.like_count}}</span>
          </div>
          <span v-show="btnShow" @click="commentUpdate('下载艺术者APP即可点评文章~')" class="btn-sm">发送</span>
        </form>
      </div> -->
        <!-- APP广告浮层 -->
      <div v-show="aDInfo.isShow" class="h5-appad" id="h5-appad">
        <div class="swiper-container" id="swiper-container-t">
          <div class="swiper-wrapper">
            <div v-for="item in H5TopInfo" class="swiper-slide">
              <img :src="item.img">
              <div  class="info">
                <p class="title ellipsis">@{{item.title}}</p>
                <p class="desc ellipsis">@{{item.desc}}</p>
              </div>
            </div>
          </div>
          <!-- <div id="swiper-pagination-t"></div> -->
        </div>
        <a class="btn-open" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">打开</a>
        <i @click="closeAD" class="icons icon-close"></i>
      </div>
      <!-- APP广告浮层 end -->
      <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div @click="hideBox" v-show="shareIsShow" class="share"></div>
          <div v-show="downloadIsShow" class="thirdLayerIn anim-scale download-box" id="download-app">
            <h3 class="title">艺术者提示 <i @click="hideBox" class="icons icon-close"></i></h3>
            <div class="content">
              @{{ boxMsg }}
            </div>
            <div class="btn-group">
              <a class="btn2 btn-down" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">下载艺术者APP</a>
            </div>
          </div>
        </div>
      </div>
    </section>
<script src="/Public/js/lib/vue.min.js"></script>
<script src="/Public/js/lib/mescroll/mescroll.min.js"></script>
<!-- <script src="/Public/js/plugins/vue-lazyload.js"></script> -->
<script src="/Public/js/lib/jquery.min.js"></script>
<script src="/Public/js/plugins/swiper.jquery.min.js"></script>
<script src="/Public/js/plugins/fastclick.js"></script>
<script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script src="/Public/js/service/agent.js?v=2.0.1"></script>
<script src="/Public/js/discussion/discussionList.js"></script>
</body>
</html>
