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
    <title>密码</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/login.css?v=1.2.0">
  </head>
  <body>
    <div style="display: none;">
      <input type="hidden" id="nickname" name="nickname" value="@if(!empty($user['nickname'])){{$user['nickname']}} @else 0 @endif">
      <input type="hidden" id="face" name="face" value="@if(!empty($user['face_url'])){{$user['face_url']}} @else 0 @endif">
    </div>
    <div class="frame-box">
      <div v-cloak id="pass-wrap">
        <div class="userinfo">
          <img class="userinfo-avatar" :src="userInfo.face">
          <span class="userinfo-nickname">@{{userInfo.nickname}}</span>
        </div>
        <div class="form-item pass-item">
          <i class="icons icon-pass"></i>
          <input v-if="open" v-model="password" type="text" class="input-pass" placeholder="请输入密码" maxlength='16'>
          <input v-else v-model="password" type="password" class="input-pass" placeholder="请输入密码" maxlength='16'>
          <i @click="toggle" :class="['icons', open? 'icon-open': 'icon-close']"></i>
        </div>
        <div class="forget">
          <a href="/passport/forget">忘记密码</a>
        </div>
        <input @click="login" type="button" class="btn btn-login" name="" value="登录">
      </div>
    </div>
  </body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/util.js?v=2.2.0"></script>
  <script type="text/javascript" src="/Public/js/login/login-pass.js?v=1.2.0"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>