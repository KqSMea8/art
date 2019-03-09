<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="遇见你的品味">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <!-- <meta name="csrf-token" content="3wOniT3eM1AZx48w3gR6EawM0lDrcQwDSSh1xOOw"> -->
    <meta content="telephone=no,email=no" name="format-detection">
    <title>艺术者</title>
    <script src="/js/lib/flexible.js"></script>
    <!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/> -->
    <!-- <meta name="viewport" content="width=device-width,user-scalable=no"> -->
    <link rel="stylesheet" type="text/css" href="/css/download.css">
  </head>
  <body>
    <header>
      <img src="/image/download/logo.png">
    </header>
    <div id="main">
      <h2>艺术者能为你做什么？</h2>
      <ul>
        <li>建立个人网络画廊</li>
        <li>艺术家能轻松经营</li>
        <li>创作故事持续传播</li>
        <li>艺术作品多次流通</li>
      </ul>
    </div>
    <div id="footer">
      <a id="btn-download" class="btn" href="/app/download"><img src="/image/download/icon-app.png"><span>下载艺术者APP</span></a>
    </div>
    <!-- 弹窗 -->
    <div class="layerbox layermshow" id="j_layerShow">
      <div class="layershade"></div>
        <div class="layermain">
          <div class="download"></div>
          <a style="display:none;" href="/app/download" id="download">下载</a>
        </div>
      </div>
    </div>
  </body>
  <script src="/js/lib/zepto.min.js"></script>
  <script src="/js/lib/zepto.touch.js"></script>
  <script type="text/javascript">
    $('#btn-download').on("tap",function(e){
      function is_weixin() {
          var ua = navigator.userAgent.toLowerCase();
          if (ua.match(/MicroMessenger/i) == "micromessenger") {
              return true;
          } else {
              return false;
          }
      }
      var isWeixin = is_weixin();
      if(isWeixin){
        $(".layerbox").show();
      } else {
        //window.location.href = ;    //APP下载链接
        $('#download').click();
      }
    })
    $('.layershade').on("tap",function(e){
      $(".layerbox").hide();
    })
  </script>
</html>