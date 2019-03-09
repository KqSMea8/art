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
    <title>注册</title>

    <script src="/Public/js/lib/flexible.js"></script>
    <script src="/Public/js/lib/vue.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="/Public/js/util.js"></script>

    <link rel="stylesheet" type="text/css" href="/Public/css/login.css">
  </head>
  <body>
    <div style="display: none;">
      <input type="hidden" id="nickname" name="nickname" value="@if(!empty($user['nickname'])){{$user['nickname']}} @else 0 @endif">
      <input type="hidden" id="face" name="face" value="@if(!empty($user['face_url'])){{$user['face_url']}} @else 0 @endif">
    </div>
    <div class="container">
      <div class="frame-box">
        <div v-cloak id="reg-wrap">
          <div class="userinfo">
            <img class="userinfo-avatar" :src="userInfo.face">
            <span class="userinfo-nickname">@{{userInfo.nickname}}</span>
          </div>
          <div class="form-item verify-item">
            <i class="icons icon-verify"></i>
            <input v-model="verifycode" class="input-verify" type="number" id="verifycode" name="verifycode" placeholder="请输入验证码" maxlength='6'>
            <span @click="getVerifyCode" :class="[isClickgetVerify ? 'clicked' : '', 'btn-sm', 'btn-verify']">@{{getVerifyCodeText}}</span>
          </div>
          <div class="form-item setpass-item">
            <i class="icons icon-pass"></i>
            <input v-if="open" v-model="password" type="text" class="input-pass" placeholder="请设置登录密码" maxlength='16'>
            <input v-else v-model="password" type="password" class="input-pass" placeholder="请设置登录密码" maxlength='16'>
            <i @click="toggle" :class="['icons', open? 'icon-open': 'icon-close']"></i>
          </div>
          <p class="agree-check" @click="agreeToggle"><input type="checkbox"><label for="agree"><i :class="['icons', isAgree? 'icon-agreed': 'icon-agree']"></i>同意<a @click.stop href="/Passport/regrule">《艺术者注册协议》</a></label></p>
          <input @click="reg" type="button" class="btn btn-reg" name="" value="注册">
        </div>
      </div>
    </div>
  </body>
  <script type="text/javascript" src="/Public/js/login/login-reg.js?v=1.2.0"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>