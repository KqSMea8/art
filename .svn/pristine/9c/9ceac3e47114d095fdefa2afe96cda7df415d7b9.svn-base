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
    <title>测测你的审美性格</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/activity/reset.css?v=1.0.8">
    <link rel="stylesheet" type="text/css" href="/Public/css/activity/shenmei.css?v=1.0.8">
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      wx.config({!! $wechat_json !!});
    </script>
  </head>
  <body>
    <div id="app" v-cloak>
      <!-- 进度条页 -->
      <!-- <div id="loading" v-show="isLoading">
        <div class="wrap">
          <div class="box">
            <div class="progress-bar-min">
              <div class="progress-bar-outer">
                <div class="progress-bar-inter" :style="{ width: loadProgress+ '%'}"></div>
              </div>
            </div>
          </div>
          <p>开始你的审美性格测试</p>
        </div>
      </div> -->
      <!-- 介绍页 -->
      <div id="intro" v-if="introIsShow">
        <p class="p1">
          想知道你的审美性格特点吗？<br>
          想了解你和好友的审美性格契合度吗？
        </p>
        <p class="p2">
          选择心动的画作<br>
          99%的人说这是一次心灵之旅
        </p>
        <div class="btn btn-primary" @click="gotoShenmei">我要测测</div>
      </div>

      <!-- 审美活动页 -->
      <div id="shenmei" v-show="shenmeiIsShow">
        <div class="title">选择你更喜欢的画作？</div>
        <div class="progress">
          <div class="progress-bar">
            <div class="progress-bar-outer">
              <div class="progress-bar-inter" :style="{ width: progress}"></div>
            </div>
          </div>
          <p class="progress-text">@{{curIndex}}/5</p>
        </div>
        <div v-cloak class="swiper-container ani" id="swiper-container-h">
          <div class="swiper-wrapper">
            <div v-for="(images, index) in imageList" :class="['swiper-slide', 'item', 'slide' + (index +1)]">
              <div class="image-wrap">
                <div v-for="imgItem in images" :class="['image-item', imgItem.active? 'active': '']" @click="addActiveAndNum(imgItem.id , index, imgItem.tagids)">
                  <!-- <div class="image-art" v-lazy:background-image="imgItem.arturl"> -->
                  <div class="image-art" :style="{backgroundImage: 'url(' + imgItem.arturl +')'}">
                  </div>
                  <div class="artinfo">
                    <span class="artname">《@{{imgItem.artname}}》</span>
                    <span class="author">@{{imgItem.author}}</span>
                  </div>
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
          <img class="result-img" :src="resultImg">
        </div>
        <p class="save">长按保存图片发朋友圈</p>
        <div class="btn-group">
          <div class="btn btn-primary btn-share" @click="showShare()">分享好友测默契度</div>
        </div>
        <div class="friend-wrap" v-if="friendList.length > 0">
          <h3 class="friend-title">趣味相投的好友列表<span>@{{total}}</span>位</h3>
          <ul class="friend-list fix">
            <li v-for="item in friendList" class="friend-item">
              <div class="friend-per">
                <span>审美契合度</span><span class="per" :style="{ color: item.color }">@{{item.percent}}%</span>
              </div>
              <div class="friend-info">
                <img class="avatar" :src="item.faceimg" :alt="item.nickname">
                <p>
                  <div class="name">@{{item.nickname}}</div>
                  <div class="label" :style="{ color: item.color }">@{{item.remark}}</div>
                </p>
              </div>
            </li>
          </ul>
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
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="/Public/js/plugins/vue-lazyload-v1.0.5.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
  <script src="/Public/js/activity/shenmei.js?v=1.2.5"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
  <script language="javascript">
        //防止页面后退
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
  </script>
</html>