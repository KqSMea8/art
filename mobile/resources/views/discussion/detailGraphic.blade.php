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
    <link rel="stylesheet" href="/Public/js/lib/mint-ui-2.1.1.css">
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.3">
    <!-- <link rel="stylesheet" type="text/css" href="/Public/css/html32app.css?v=1.4.6"> -->
    <link rel="stylesheet" href="/Public/css/discussion/details.css">
    <style>
        .spaceblock{
           display: none; 
        }
        .videoBox{
            padding: 0.16rem 0.52rem .64rem;
            background: #fff;
        }
        #hasvideo{
            width: 100%;
            height: 6rem /* 450/75 */;
        }
        .nopadding_bottom{
            padding-bottom: 0
        }
        .htmma{
            line-height: normal;
        }
    </style>
</head>
<body>
    <section id="discussion" v-cloak>
    <!-- <section id="discussion"> -->
        <header class="head">
            <div class="painter">
            <div class="info">
              <a class="avatar-wrap">
                <img class="avatar" v-lazy="update.userinfo.faceUrl" >
                <!-- <i :class="['icons', 'icon-gender-'+update.userinfo.gender]"></i> -->
              </a>
              <div class="det">
                <p class="name">
                    <span class="name_rel">@{{update.userinfo.nickname}}</span>
                    <template>
                        <i v-if="update.userinfo.is_artist == 1" class="icons icon-artist center_self"></i>
                    </template>
                </p>
                <span class="ellipsis">@{{update.datetime}}</span>
              </div>
              <div @click="toggleFollow" :class="['follow', update.userinfo.is_follow == 'Y'? 'followed': '']">
                <i class="icons icon-follow"></i>
                <!-- <span v-if="'Y' == 'Y'" class="label"></span>
                <span v-else class="label"></span> -->
              </div>
            </div>
          </div>
        </header>
        <section class="discontent" ref="content">
            <div class="textcontent" v-html="update.content"></div>
            <template>
                <ul class="clerfix imgboxul">
                    <li v-for="(item, index) in update.images_url" :key="index" class="imgitem">
                        <img v-lazy="item" alt="">
                    </li>
                </ul>
            </template>
            <div v-if="update.video_url !='' " class="hasvideo">
                <video :src="update.video_url" id="hasvideo" controls preload></video>
            </div>
            <p @click="golist" class="clearfix htmma">
                <span class="fl htbg"></span>
                <!-- @{{update.topic.title}} -->
                <span class="fl httext">@{{update.topic.title}}</span>
            </p>
        </section>
        <section class="distab">
            <!-- todo\\ -->
            <div class="tabboxdes">
                <ul>
                    <li @click="tabacitve(1)" :class="{active:selected==1}">回复 @{{update.comment_num>0?update.comment_num: ''}}</li>
                    <li @click="tabacitve(2)" :class="{active:selected==2}">点赞 @{{update.like_num>0?update.like_num:''}}</li>
                    <li @click="tabacitve(3)" :class="{active:selected==3}">转发 @{{update.share_num>0?update.share_num:''}}</li>
                </ul>
            </div>
            <!-- tab content -->
            <div>
                <div v-if="selected==1">
                    <div class="loadwapper">
                        <mt-loadmore class="scrollbox"
                            :bottom-method="loadMore"
                            ref="loadmore"
                            :bottom-all-loaded="isnoData1"
                            :bottomDistance="20"
                            :auto-fill="false">
                            <ul class="tlakitem">
                                <li v-for="(item, i) in replaylist.list">
                                    <section class="replyerface">
                                        <img v-lazy="item.userinfo.face" alt="">
                                    </section>
                                    <section class="clearfix ntop">
                                        <p class="fl replynamebox">
                                            <span class="fl replyername">@{{item.userinfo.nickname}}</span>
                                        </p>
                                        <div class="fr replaytime">
                                            <span @click="" class="fr replybtn">...</span>
                                            <span class="fr replytime">@{{item.create_time}}</span>
                                        </div>
                                    </section>
                                    <section class="replaycontent" :class="[item.list.length>0?'':'norepcontent']">@{{item.content}}</section>
                                    <ul v-if="item.list.length>0" class="someonerp">
                                        <li v-for="(child,j) in item.list" class="someonelist">
                                            <section class="replyerface">
                                                <img v-lazy="child.face" alt="">
                                            </section>
                                            <section class="clearfix ntop">
                                                <p class="fl replynamebox">
                                                    <span class="fl replyername">@{{child.nickname}}</span>
                                                </p>
                                                <div class="fr replaytime">
                                                    <span class="fr replybtn">...</span>
                                                    <span class="fr replytime">@{{child.create_time}}</span>
                                                </div>
                                            </section>
                                            <template>
                                                <section v-if="child.comment_to==''" class="replaycontent stosomebody">
                                                    <p>@{{child.content}}</p>
                                                </section>
                                                <section v-else class="replaycontent stosomebody" :class="[item.list.length==1?'norepcontent':'']">
                                                    <template>
                                                        
                                                        <p v-if="child.comment_to.length>0">
                                                            回复@<span class="sbname">@{{child.comment_to}}</span>
                                                            @{{child.content}}
                                                        </p>
                                                        <p v-else>
                                                            @{{child.content}}
                                                        </p>
                                                    </template>
                                                </section>
                                            </template>
                                        </li>
                                        <li v-show="item.comment_num>3" @click="commentUpdate('下载艺术者APP即可查看全部回复~')" class="openall">查看全部@{{item.comment_num}}条</li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </mt-loadmore>
                        <div class="spaceblock"></div>  
                    </div>
                </div>
                <div v-if="selected==2" id="2">
                    <div class="loadwapper" :style="{height:listhieght}">
                        <mt-loadmore class="scrollbox"
                            :bottom-method="loadMore2"
                            ref="loadmore2"
                            :bottom-all-loaded="isnoData2"
                            :bottomDistance="20"
                            :auto-fill="false">
                            <ul class="tlakitem likeitems">
                                <li v-for="(item, i) in likeslist.list">
                                    <section class="replyerface">
                                        <img v-lazy="item.face" alt="">
                                    </section>
                                    <section class="clearfix ntop">
                                        <p class="fl replynamebox">
                                            <span class="fl replyername">@{{item.nickname}}</span>
                                            <!-- <template>
                                                <i v-if="item.userinfo.is_artist == 1" class="icons icon-artist"></i>
                                                <i v-if="update.userinfo.is_agency == 1" :class="['icons', 'icon-agency', 'icon-agency-'+update.userinfo.AgencyType]"></i>
                                                <i v-if="update.userinfo.is_planner == 1" class="icons icon-planner"></i>
                                            </template> -->
                                            <span class="fl replytime">@{{item.create_time}}</span>
                                        </p>
                                    </section>
                                </li>
                            </ul>
                        </mt-loadmore>
                        <div class="spaceblock"></div>
                    </div>
                </div>
                <div v-if="selected==3" id="3" >
                    <div class="loadwapper" :style="{height:listhieght}">
                        <mt-loadmore class="scrollbox"
                            :bottom-method="loadMore3"
                            ref="loadmore3"
                            :bottom-all-loaded="isnoData3"
                            :bottomDistance="20"
                            :auto-fill="false"
                        >
                            <ul class="tlakitem likeitems">
                                <li v-for="(item,i) in zhuanlist.list">
                                    <section class="replyerface">
                                        <img v-lazy="item.face" alt="">
                                    </section>
                                    <section class="clearfix ntop">
                                        <p class="fl replynamebox">
                                            <span class="fl replyername">@{{item.nickname}}</span>
                                            <!-- <i class="fl icons icon-artist"></i> -->
                                            <span class="fl replytime">@{{item.share_time}}</span>
                                        </p>
                                    </section>
                                </li>
                            </ul>
                        </mt-loadmore>
                        <div class="spaceblock"></div>
                    </div>
                </div>
            </div>
        </section>
        <div id="message-frame" class="message-frame">
            <form id="message-form" @submit.prevent="commentUpdate('下载艺术者APP即可点评文章~')">
                <div class="recontext" @click="showinput =true">此刻写下来的就是艺术</div>
                <!-- <input type="text" id="message" :class="{'active':btnShow}" v-model="commentContent" placeholder="此刻写下来的就是艺术"> -->
                <i v-show="!btnShow" class="icons icon-share" @click="showShare"></i>
                <div v-show="!btnShow" class="mess-icon icon_po" style="float: right; position: relative;" @click="toggleLike('感谢您的喜欢，立即下载APP查看更多文章吧~')">
                <i :class="['icons', isLike?'icon-liked': 'icon-like']"></i>
                <span v-if="update.like_count > 0" class="num">@{{update.like_count}}</span>
                </div>
            </form>
        </div>
        <!-- 输入弹窗 -->
        <div v-cloak v-show="showinput" class="layerbox layermshow" id="j_layerShow">
            <div @click="showinput =false" class="layershade"></div>
            <div class="almain">
            <div class="albox">
                <p class="altitle">此刻，你应该想说点什么</p>
                <div class="alinputbox alinput">
                    <textarea name="" id="" class="" cols="30" rows="10"></textarea>
                    <div class="albtnbox">
                        <button class="alsubmit" @click="commentUpdate('下载艺术者APP即可评论文章~')">发表评论</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
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
<script src="/Public/js/lib/mint-ui-2.1.1.js"></script>
<script src="/Public/js/plugins/vue-lazyload.js"></script>
<script src="/Public/js/lib/jquery.min.js"></script>
<script src="/Public/js/plugins/swiper.jquery.min.js"></script>
<script src="/Public/js/plugins/fastclick.js"></script>
<script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script src="/Public/js/service/agent.js?v=2.0.1"></script>
<script src="/Public/js/discussion/detailGraphic.js"></script>
</body>
</html>
