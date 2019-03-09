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
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      wx.config({!! $wechat_json !!});
    </script>
  </head>
  <body>
    <div id="app" v-cloak>
      <!-- 分享出去别人看到的结果页 -->
      <div id="share">
        <div class="logo">
          <img src="/Public/image/activity/logo.png">
        </div>
        <div class="result">
          <img class="result-img" :src="resultImg">
        </div>
        <div class="btns">
          <div class="btn-group">
            <p>可以提高你的审美品位哦</p>
            <a class="btn btn-primary" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">下载艺术者</a>
          </div>
          <div class="btn-group">
            <a v-if="istest == '0'" class="btn" @click="showCode">我也测测</a>
            <a v-if="istest == '1'" class="btn" :href="testLink">我的性格审美</a>
          </div>
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
      <!-- 二维码弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow" style="display: none;">
        <div @click="hideBox" class="layershade"></div>
          <div class="layermain">
            <div v-show="codeIsShow" class="qrcode">
              <i @click="hideBox" title="关闭"></i>
              <p>长按二维码关注公众号<br>
              即可测试你的审美性格</p>
              <img class="code-img" src="/Public/image/activity/qrcode.png?v=1.0.1">
            </div>
        </div>
      </div>
    </div>
  </body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/activity/result.js?v=1.1.6"></script>
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