<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术家免费认证">
    <meta name="description" content="艺术者认证服务是针对艺术家的真实性证明，从而曝
    光艺术创作者的作品，认证成功后，艺术者平台将宣传推广个人艺术品牌。">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <!-- <meta name="csrf-token" content="3wOniT3eM1AZx48w3gR6EawM0lDrcQwDSSh1xOOw"> -->
    <meta content="telephone=no,email=no" name="format-detection">
    <title>艺术家免费认证</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/> -->
    <!-- <meta name="viewport" content="width=device-width,user-scalable=no"> -->
    <link rel="stylesheet" type="text/css" href="/Public/css/authenticate.css">
  </head>
  <body>
    <header>
      <h1>艺术家免费认证</h1>
    </header>
    <ul class="content">
      <li>
        <h2>艺术者认证是什么？</h2>
        <p>艺术者认证服务是针对艺术家的真实性证明，从而曝光艺术创作者的作品，认证成功后，艺术者平台将宣传推广个人艺术品牌。</p>
      </li>
      <li>
        <h2>如何通过认证？</h2>
        <p>1.需要已入驻艺术家的邀请码；</p>
        <p>2.艺术家提交资料后，认证是否通过将由艺术者团队手动审核。目前艺术者接受从事绘画创作的艺术家（油画、水粉、插画、素描）。</p>
      </li>
      <li>
        <h2>如何通过认证？</h2>
        <p>1.需要已入驻艺术家的邀请码；</p>
        <p>2.艺术家提交资料后，认证是否通过将由艺术者团队手动审核。目前艺术者接受从事绘画创作的艺术家（油画、水粉、插画、素描）。</p>
      </li>
    </ul>
    <div class="agree-bar" id="check_agree">
      <p class="agree-check"><input type="checkbox" id="agree"><label for="agree" @click="agreeToggle"><i v-bind:class="{cur:iscur}"></i>同意《艺术者认证服务协议》</label></p>
      <p class="agree-btn"><input type="button" v-bind:disabled="!iscur" value="下一步"></p>
    </div>
    <script src="/Public/js/lib/vue.min.js"></script>
    <script src="/Public/js/user/authenticate.js"></script>
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