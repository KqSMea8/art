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
    <title>性格审美测试</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/activity/reset.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/activity/shenmei.css">
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      wx.config({!! $wechat_json !!});
    </script>
  </head>
  <body>
    <div id="app">
      <!-- 审美活动页 -->
      <div id="shenmei" v-if="shenmeiIsShow">
        <div class="title">选择你喜欢的画作</div>
        <div class="progress">
          <p class="progress-text">@{{curIndex}}/5</p>
          <div class="progress-bar">
            <div class="progress-bar-outer">
              <div class="progress-bar-inter" :style="{ width: progress}"></div>
            </div>
          </div>
        </div>
        <div v-cloak class="swiper-container ani" id="swiper-container-h">
          <div class="swiper-wrapper">
            <div v-for="(images, index) in imageList" :class="['swiper-slide', 'item', 'slide' + (index +1)]">
              <div class="image-wrap">
                <!-- <div v-for="imgItem in images" :style="{backgroundImage: 'url(' + imgItem.arturl +')'}" :class="['image-item', imgItem.active? 'active': '']" @click="addActiveAndNum(imgItem.id , index, imgItem.tagids)"> -->
                <div v-for="imgItem in images" :class="['image-item', imgItem.active? 'active': '']" @click="addActiveAndNum(imgItem.id , index, imgItem.tagids)">
                  <img class="image-art" :src="imgItem.arturl" />
                  <img class="alpha-img" src="/Public/image/activity/pixel.gif" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- 测试结果页 -->
      <div id="result" v-if="resultIsShow">
        <div class="logo">
          <img src="/Public/image/activity/logo.png">
        </div>
        <div class="result">
          <span class="tag tag1 myfont">活雷锋</span>
          <span class="tag tag2 myfont">活雷锋</span>
          <span class="tag tag3 myfont">活雷锋</span>
          <span class="tag tag4 myfont">活雷锋</span>
          <span class="tag tag5 myfont">活雷锋</span>
          <span class="tag tag6 myfont">活雷锋</span>
          <span class="tag tag7 myfont">活雷锋</span>
          <span class="tag tag8 myfont">活雷锋</span>
          <span class="tag tag9 myfont">活雷锋</span>
          <span class="tag tag10 myfont">活雷锋</span>
          <span class="tag tag11 myfont">活雷锋</span>
          <span class="tag tag12 myfont">活雷锋</span>
          <span class="tag tag13 myfont">活雷锋</span>
          <span class="tag tag14 myfont">活雷锋</span>
          <div class="user-info">
            <img class="user-avatar" src="//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_100,w_100">
            <p class="nickname">lalal</p>
          </div>
          <p class="said myfont">该吃药了，良药苦口</p>
        </div>
        <p class="save xxx" @click="hecheng">长按保存图片</p>
        <div class="cover result">
          <!-- <img class="img-result" src="/Public/image/activity/result.png"> -->
          <span class="tag tag1 myfont">活雷锋</span>
          <span class="tag tag2 myfont">活雷锋</span>
          <span class="tag tag3 myfont">活雷锋</span>
          <span class="tag tag4 myfont">活雷锋</span>
          <span class="tag tag5 myfont">活雷锋</span>
          <span class="tag tag6 myfont">活雷锋</span>
          <span class="tag tag7 myfont">活雷锋</span>
          <span class="tag tag8 myfont">活雷锋</span>
          <span class="tag tag9 myfont">活雷锋</span>
          <span class="tag tag10 myfont">活雷锋</span>
          <span class="tag tag11 myfont">活雷锋</span>
          <span class="tag tag12 myfont">活雷锋</span>
          <span class="tag tag13 myfont">活雷锋</span>
          <span class="tag tag14 myfont">活雷锋</span>
          <div class="user-info">
            <img class="user-avatar" src="//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_100,w_100">
            <p class="nickname">lalal</p>
          </div>
          <p class="said myfont">该吃药了，良药苦口</p>
          <div class="img-code"></div>
          <!-- <img class="img-code" src="/Public/image/activity/code.png"> -->
        </div>
        <div class="btn-group">
          <div class="btn btn-primary btn-share" @click="showShare()">测测好友契合度</div>
        </div>
      </div>
      <!-- 分享弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow" style="display: none;">
        <div @click="hideBox" class="layershade"></div>
          <div class="layermain">
          <div @click="hideBox" v-show="shareIsShow" class="share"></div>
        </div>
      </div>
    </div>
  </body>
  <script src="/Public/js/lib/vue.js"></script>
  <script src="/Public/js/plugins/vue-lazyload.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/plugins/html2canvas.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/Public/js/service/agent.js?v=1.0.5"></script>
  <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
  <script src="/Public/js/activity/shenmei.js"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>