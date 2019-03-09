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
    <title>微信登录</title>

    <script src="/Public/js/lib/flexible.js"></script>
    <script src="/Public/js/lib/vue.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="/Public/js/util.js"></script>

    <link rel="stylesheet" type="text/css" href="/Public/css/login.css">
  </head>
  <body>
    <div class="frame-box">
      <div class="logo"></div>
      <div class="line"></div>
      <a class="btn wx-login-btn" href="/wechat/login"><i class="icons icon-wx"></i>微信直接登录</a>
    </div>
    <!-- <script type="text/javascript" src="/Public/js/wx-login.js"></script> -->
  </body>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>