<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者免费注册">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <!-- <meta name="csrf-token" content="3wOniT3eM1AZx48w3gR6EawM0lDrcQwDSSh1xOOw"> -->
    <meta content="telephone=no,email=no" name="format-detection">
    <title>认证艺术家</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/> -->
    <!-- <meta name="viewport" content="width=device-width,user-scalable=no"> -->
    <link rel="stylesheet" type="text/css" href="/Public/css/authenticatemsg.css">
  </head>
  <body>
    <header>
      <h1>信息填写</h1>
      <p>以下信息必须真实可信</p>
    </header>
    <fieldset>
      <form action="" method="">
        <ul class="form-list">
          <li class="photo"><input type="file" name="photo"><div class="photo-info"><i></i><p>个人个性照，个人画廊封面</p></div></li>
          <li><input type="text" placeholder="请填写您的真实姓名" name="password"></li>
          <li><input type="text" placeholder="请填写您的身份证号码" name="identity"></li>
          <li><input type="text" placeholder="请输入您的手机号码，便于回访" name="phone"></li>
          <li class="verification"><input type="text" placeholder="请输入验证码" name="verification"><span>获取验证码</span></li>
          <li><input type="text" placeholder="已入驻艺术家的邀请码" name="invite"></li>
          <li><input type="text" placeholder="个人个性签名，不少于10个字符~" name="signature"></li>
          <li class="introduce"><textarea cols="30" rows="10" placeholder="个人介绍以及近5年内你的获奖，展览，以及相关荣誉情况" name="introduce"></textarea></li>
          <li class="finish"><input type="submit" value="完成"></li>
        </ul>
      </form>
    </fieldset>
  </body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>