<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
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
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.1.1">
    <link rel="stylesheet" type="text/css" href="/Public/css/artworkUpdate.css?v=1.1.1">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.1.4">
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <style>
      .update-wrap {
        padding-bottom: 0;
      }
    </style>
  </head>
  <body>
    <div v-cloak id="article-detail">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <div class="update-wrap">
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
      </div>
    </div>
    <script src="/Public/js/lib/vue.min.js"></script>
    <script src="/Public/js/plugins/vue-lazyload.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script src="/Public/js/service/agent.js?v=2.0.0"></script>
    <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
    <script src="/Public/js/util.js?v=2.2.8"></script>
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
