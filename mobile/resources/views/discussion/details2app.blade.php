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
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.3">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.0.1">
    <!-- <link rel="stylesheet" type="text/css" href="/Public/css/html32app.css?v=1.4.6"> -->
    <link rel="stylesheet" href="/Public/css/discussion/details.css">
    <style>
        #discussion{
             -webkit-overflow-scrolling: touch;
        }
        img{
            max-width: 100%!important;
            height: auto!important;
        }
    </style>
</head>
<body>
    <section id="discussion" v-cloak>
    <!-- <section id="discussion"> -->
        <header class="head">
            <h3 v-if="update.title!=''" class="title">@{{update.title}}</h3>
            <div class="painter">
            <div class="info">
              <a class="avatar-wrap">
                <img class="avatar" v-lazy="update.userinfo.faceUrl" >
                <!-- <i :class="['icons', 'icon-gender-'+update.userinfo.gender]"></i> -->
              </a>
              <div class="det">
                <p class="name">
                    @{{update.userinfo.nickname}}
                    <template>
                        <i v-if="update.userinfo.is_artist == 1" class="icons icon-artist"></i>
                        <!-- <i v-if="update.userinfo.is_agency == 1" :class="['icons', 'icon-agency', 'icon-agency-'+update.userinfo.AgencyType]"></i>
                        <i v-if="update.userinfo.is_planner == 1" class="icons icon-planner"></i> -->
                    </template>
                </p>
                <span class="ellipsis">@{{update.datetime}}</span>
              </div>
              <div @click="toggleFollow" :class="['follow', update.userinfo.is_follow == 'Y'? 'followed': '']">
                <i class="icons icon-follow"></i>
                <!-- <span v-if="update.publisherInfo.isFollow == 'Y'" class="label">已关注</span>
                <span v-else class="label">加关注</span> -->
              </div>
            </div>
          </div>
        </header>
        <section class="discontent" ref="content" v-html="update.content"></section>
        <!-- <div v-if="update.images_url!=''" class="imgbox_img">
            <img v-for="imgsrc in update.images_url"  v-lazy="imgsrc" alt="" class="img">
        </div> -->
        <div v-if="update.video_url!=''" class="videoBox">
            <video :src="update.video_url" id="hasvideo" controls preload></video>
        </div>
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
                                <li v-for="(item, i) in replaylist.list" :key="i">
                                    <section class="replyerface">
                                        <img v-lazy="item.userinfo.face" alt="">
                                    </section>
                                    <section class="clearfix ntop">
                                        <p class="fl replynamebox">
                                            <span class="fl replyername">@{{item.userinfo.nickname}}</span>
                                        </p>
                                        <div class="fr replaytime">
                                            <span @click="commentClick(item.id,item.isAllowDelete)" class="fr replybtn">...</span>
                                            <span class="fr replytime">@{{item.create_time}}</span>
                                        </div>
                                    </section>
                                    <section class="replaycontent" :class="[item.list.length>0?'':'norepcontent']">@{{item.content}}</section>
                                    <ul v-if="item.list.length>0" class="someonerp">
                                        <li v-for="(child,j) in item.list" class="someonelist" :key="j">
                                            <section class="replyerface">
                                                <img v-lazy="child.face" alt="">
                                            </section>
                                            <section class="clearfix ntop">
                                                <p class="fl replynamebox">
                                                    <span class="fl replyername">@{{child.nickname}}</span>
                                                </p>
                                                <div class="fr replaytime">
                                                    <span @click="replyClick(child.id,child.isAllowDelete)" class="fr replybtn">...</span>
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
                                        <li v-show="item.comment_num>3" :data-id="item.id" @click="getmorerep(item.id)" class="openall">查看全部@{{item.comment_num}}条</li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </mt-loadmore>
                        <div class="spaceblock"></div>  
                    </div>
                </div>
                <div v-if="selected==2" id="2">
                    <div class="loadwapper">
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
                    <div class="loadwapper">
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
    </section>
<!-- <script src="/Public/js/lib/vue.js"></script> -->
<script src="/Public/js/lib/vue.min.js"></script>
<script src="/Public/js/lib/mint-ui-2.1.1.js"></script>
<script src="/Public/js/plugins/vue-lazyload.js"></script>
<script src="/Public/js/lib/jquery.min.js"></script>
<script src="/Public/js/plugins/jquery.lazyload.min.js"></script>
<script src="/Public/js/plugins/fastclick.js"></script>
<script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script src="/Public/js/service/agent.js?v=2.0.1"></script>
<script src="/Public/js/discussion/details2app.js"></script>
</body>
</html>
