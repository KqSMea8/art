<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <title>艺术者-专题详情</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.0.1">
    <link rel="stylesheet" type="text/css" href="/Public/css/subject.css?v=1.0.1">
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      wx.config({!! $wechat_json !!});
    </script>
    <style>
      .wrap a{
        display: inline-block;
      }
    
    </style>
  </head>
  <body>
    <div v-cloak id="subject">
      <loading-box></loading-box>
      <!-- <div id="cover" :style="{backgroundImage:'url(' + info.sub_cover +')'}"></div> -->
      <img id="cover" v-lazy="info.sub_cover"/>
      <h1 id="title">@{{info.sub_title}}</h1>
      <div id="wit" class="wrap view" v-html="info.description">
      </div>
      <ul class="artwork-list">
        <li v-for="item in info.data" :key="item.artid" class="artwork-item">
          <div class="artwork-wrap">
            <a :href="'/artwork/detail/' + item.artid">
              <div class="cover-wrap">
                <img v-lazy="item.art_cover" class="cover">
              </div>
              <div class="info-wrap">
                <h3 class="name">@{{item.artname}}</h3>
                <div class="user-wrap">
                  <img v-lazy="item.face" class="face">
                  <span class="nickname">@{{item.author}}</span>
                  <span v-if="item.category" class="tags">@{{item.tags}}</span>
                </div>
                <p class="desc">
                  @{{item.description}}
                </p>
              </div>
            </a>
          </div>
        </li>
      </ul>
    </div>
    <script type="text/javascript" src="/Public/js/lib/vue.min.js"></script>
    <script type="text/javascript" src="/Public/js/plugins/vue-lazyload.js"></script>
    <!-- <script type="text/javascript" src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script> -->
    <script src="/Public/js/lib/jquery.min.js"></script> <!-- //1.11.3 -->
    <script src="/Public/js/plugins/fastclick.js"></script>
    <script type="text/javascript" src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script type="text/javascript" src="/Public/js/service/agent.js?v=2.0.2"></script>
    <script type="text/javascript" src="/Public/js/util.js?v=2.3.0"></script>
    <script type="text/javascript" src="/Public/js/subject/detail.js?v=1.0.1"></script>
    <script>
      // Vue.use(VueLazyload, {
      //   preLoad: 1.3,
      //   error: false,
      //   loading: '/Public/image/holder.png',
      //   attempt: 1
      // });

    </script>
  </body>
</html>
