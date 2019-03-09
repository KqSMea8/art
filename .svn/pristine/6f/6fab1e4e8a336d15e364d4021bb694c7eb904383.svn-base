<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!--2018.05.07 add-->
    <meta name="viewport" content="width=device-width,height=device-height,user-scalable=no,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" />
    <!--2018.05.07 end-->
    <meta name="keywords" content="艺术者">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <!-- <meta name="csrf-token" content="3wOniT3eM1AZx48w3gR6EawM0lDrcQwDSSh1xOOw"> -->
    <meta content="telephone=no,email=no" name="format-detection">
    <title>艺术号-艺术者</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.5">
    <link rel="stylesheet" type="text/css" href="/Public/css/artworkUpdate.css?v=1.2.5">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.1.5">
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <style>
      .view p{
        white-space: normal;
      }
      .user-type{
        font-weight: 100;
      }
      .search-user {
        width: 92%!important;
        padding: 0.267rem;
        box-sizing: content-box!important;
        background: #f2f2f2!important;
      }
      .search-user .search-user-info {
        float: left;
        padding-left: .27rem;
      }
      .wrap img{
        margin: 0 auto;
        display: block;
        width: auto!important;
        max-width: 100%;
        height: auto!important;
        max-height: 100%;
      }
    </style>
  </head>
  <body>
    <div v-cloak id="article-detail">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <div class="update-wrap" :style="{top: aDInfo.height }">
        <div id="header">
          <div class="title-wrap">
            <h3 class="title ellipsis">@{{update.title}}</h3>
          </div>
          <div class="art-info">
            <span class="creat-date">@{{update.create_time}}</span>
            <a class="artist-name" :href="update.userinfo.is_artist == 1?'/gallery/detail/' + update.userinfo.id: 'javascript:;'">@{{update.userinfo.nickname}}</a>
          </div>
        </div>
        <div id="content" class="wrap view" v-html="update.content">
        </div>
        <div class="interact">
          <div class="labels fix">
            <div class="label-l">
              <i class="icons icon-time"></i>
              <span class="label">@{{update.create_time}}</span>
            </div>
            <div class="label-r">
              <i class="icons icon-eye"></i>
              <span class="label">@{{update.views}}次浏览</span>
            </div>
          </div>
          <!-- <div class="painter">
            <div class="info">
              <a :href="'/gallery/detail/' + update.userinfo.id">
                <img class="avatar" v-lazy="update.userinfo.faceUrl"></img>
              </a>
              <div class="det">
                <h3 class="name">@{{update.userinfo.nickname}}</h3>
                <span>文章@{{update.userinfo.artTotal}}</span>
                <span>粉丝@{{update.userinfo.follower_total}}</span>
              </div>
              <div @click="toggleFollow('感谢您的关注，立即下载APP查看更多文章吧~')" :class="['follow', isFollow? 'followed': '']">
                <i class="icons icon-follow"></i>
                <span v-if="isFollow" class="label">已关注</span>
                <span v-else class="label">加关注</span>
              </div>
            </div>
          </div> -->
          <div class="liker fix">
            <div class="like" @click="toggleLike('感谢您的喜欢，立即下载APP查看更多文章吧~')">
              <i :class="['icons', isLike?'icon-liked': 'icon-like']"></i>
              <span>喜欢</span>
            </div>
            <ul class="likers fix">
              <li v-for="(item, index) in update.like_users">
                <img :src="item">
                <p v-if="update.like_count > 6 & index == '5'" class="num">@{{update.like_count}}</p>
              </li>
            </ul>
          </div>
          <ul v-if="update.comments.commentlist.length > 0" class="comments">
            <h2><i class="icons icon-comment"></i>@{{update.comments.total}}条评论</h2>
            <li class="comment" v-for="commentItem in update.comments.commentlist">
              <div class="user-com">
                <div class="icon-r" @click="toggleZan(commentItem.commentId,commentItem.is_like)">
                  <i :class="['icons', commentItem.is_like == '1'?'icon-praised': 'icon-praise']"></i>
                  <span class="label">@{{commentItem.likes}}</span>
                </div>
                <img class="avatar" v-lazy="commentItem.faceUrl">
                <a class="name" href="javascript:;">@{{commentItem.nickname}}</a>
                <div class="time">@{{commentItem.time}}</div>
                <p class="com">@{{commentItem.content}}</p>
              </div>
              <div class="painter-com fix" v-if="commentItem.repayContent">
                <a class="name" href="javascript:;">@{{commentItem.repayer}}</a>
                <span>回复：</span>
                <span class="com">@{{commentItem.repayContent}}</span>
                <div class="time">@{{commentItem.repayTime}}</div>
              </div>
            </li>
          </ul>
          <div class="btn-group">
            <a v-if="update.comments.total > 2" class="btn-download" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">打开艺术者，查看全部评论</a>
            <a v-if="update.comments.commentlist.length == 0" class="btn-download" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">打开艺术者，发表评论</a>
          </div>
        </div>
        <div class="rel" v-if="update.related.length > 0">
          <h2>可能感兴趣的内容</h2>
          <ul class="rel-list">
            <li class="rel-item fix" v-for="item in update.related">
              <a :href="'/article/detail/' + item.id" class="mabelike fix">
                <div class="rel-info">
                  <h3 class="ellipsis">@{{item.title}}</h3>
                  <p class="ellipsis">@{{item.content}}</p>
                </div>
                <img v-lazy="item.cover">
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div id="message-frame" class="message-frame">
        <form id="message-form" @submit.prevent="commentUpdate('下载艺术者APP即可点评文章~')">
          <input type="text" id="message" :class="{'active':btnShow}" v-model="commentContent" placeholder="此刻写下来的就是艺术">
          <i v-show="!btnShow" class="icons icon-share" @click="showShare"></i>
          <div v-show="!btnShow" class="mess-icon icon_po" style="float: right; position: relative;" @click="toggleLike('感谢您的喜欢，立即下载APP查看更多文章吧~')">
            <i :class="['icons', isLike?'icon-liked': 'icon-like']"></i>
            <span v-if="update.like_count > 0" class="num">@{{update.like_count}}</span>
          </div>
          <!-- <i v-show="!btnShow" class="icons icon-comment"><span v-if="update.comments.total > 0" class="num">@{{update.comments.total}}</span></i> -->
          <span v-show="btnShow" @click="commentUpdate('下载艺术者APP即可点评文章~')" class="btn-sm">发送</span>
        </form>
      </div>
      <!-- APP广告浮层 -->
      <div v-show="aDInfo.isShow" class="h5-appad" id="h5-appad">
        <div class="swiper-container" id="swiper-container-t">
          <div class="swiper-wrapper">
            <div v-for="item in H5TopInfo" class="swiper-slide">
              <img v-lazy="item.img">
              <div  class="info">
                <p class="title ellipsis">@{{item.title}}</p>
                <p class="desc ellipsis">@{{item.desc}}</p>
              </div>
            </div>
          </div>
          <div id="swiper-pagination-t"></div>
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
    </div>
    <script src="/Public/js/lib/vue.min.js"></script>
    <script src="/Public/js/plugins/vue-lazyload.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="/Public/js/plugins/fastclick.js"></script>
    <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script src="/Public/js/service/agent.js?v=2.0.1"></script>
    <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
  <!--   <script src="/Public/js/plugins/jquery.lazyload.min.js"></script>
    <script src="/Public/js/plugins/jquery.scrollstop.min.js"></script> -->
    <script src="/Public/js/util.js?v=2.3.1"></script>
    <script type="text/javascript" src="/Public/js/article/detail.js?v=1.2.8"></script>
    <script type="text/javascript">
      if (checkUA().isWeChat) {
        wx.config({!! $wechat_json !!});
      }
      var interval = setInterval(function() {
        document.body.scrollTop = document.body.scrollHeight
      }, 100);
    </script>
  </body>
</html>
