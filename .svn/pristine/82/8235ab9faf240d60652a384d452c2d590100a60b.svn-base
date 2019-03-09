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
    <title>个人资料</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/> -->
    <!-- <meta name="viewport" content="width=device-width,user-scalable=no"> -->
    <link rel="stylesheet" type="text/css" href="/Public/css/user.css">
  </head>
  <body>
    <div v-cloak class="user-profile" id="user-profile">
      <ul class="user-pic">
        <li class="item" @click="showDownload('如需修改头像，请在APP中修改')">
          <a href="javascript:;">
            <span class="title">头像</span>
            <i class="icons icon-arrow"></i>
            <img class="avatar" :src="userInfo.faceUrl">
          </a>
        </li>
        <li v-if="userInfo.isArtist" class="item" @click="showDownload('如需修改个人画廊封面，请在APP中修改')">
          <a href="javascript:;">
            <span class="title">个人画廊封面</span>
            <i class="icons icon-arrow"></i>
            <img class="pic" :src="userInfo.galleryCoverUrl">
          </a>
        </li>
      </ul>
      <ul class="user-info">
        <li class="item">
          <a href="/user/nickname">
            <span class="title">昵称</span>
            <i class="icons icon-arrow"></i>
            <span class="desc ellipsis">@{{userInfo.nickname}}</span>
          </a>
        </li>
        <li v-if="userInfo.isArtist" class="item" @click="showQrcode">
          <span class="title">二维码</span>
          <i class="icons icon-arrow"></i>
          <i class="icons icon-qrcode desc"></i>
        </li>
        <li class="item" @click="showDownload('如需修改性别，请在APP中修改')">
          <span class="title">性别</span>
          <i class="icons icon-arrow"></i>
          <i class="desc">@{{userInfo.gender}}</i>
        </li>
        <li class="item" @click="showDownload('如需修改生日，请在APP中修改')">
          <a href="javascript:;">
            <span class="title">生日</span>
            <i class="icons icon-arrow"></i>
            <!-- <input class="desc" type="date" name="birthday" value="1992/10/10"> -->
            <span class="desc ellipsis">@{{userInfo.birthday}}</span>
          </a>
        </li>
        <li class="item">
          <a href="/user/motto">
            <span class="title">个性签名</span>
            <i class="icons icon-arrow"></i>
            <span class="desc ellipsis">@{{userInfo.motto}}</span>
          </a>
        </li>
        <li v-if="userInfo.isArtist" class="item">
          <a href="/user/intro">
            <span class="title">个人介绍</span>
            <i class="icons icon-arrow"></i>
            <span class="desc ellipsis">@{{userInfo.resume}}</span>
          </a>
        </li>
      </ul>
      <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div v-show="downloadIsShow" class="thirdLayerIn anim-scale download-box" id="download-app">
            <h3 class="title">艺术者提示 <i @click="hideBox" class="icons icon-close"></i></h3>
            <div class="content">
              @{{boxMsg}}
            </div>
            <div class="btn-group">
              <a class="btn2 btn-down" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">下载艺术者APP</a>
              <!-- <input type="button" class="btn2 btn-down" value="立即下载"> -->
            </div>
          </div>
          <div v-show="qrcodeIsShow" class="thirdLayerIn anim-scale qrcode-box" id="qrcode-box">
            <img class="logo" src="/Public/image/logo-b.png">
            <div id="qrcode"></div>
            <p class="info">@{{userInfo.nickname}}的艺术画廊</p>
            <input type="button" class="btn2" value="截图发送给好友">
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/Public/js/service/agent.js?v=2.0.0"></script>
  <script src="/Public/js/lib/jweixin-1.0.0.js"></script>
  <script src="/Public/js/plugins/qrcode.min.js"></script>
  <script src="/Public/js/util.js"></script>
  <script src="/Public/js/user/userprofile.js"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>