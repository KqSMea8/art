<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <!-- <link href="/js/plugin/validform/validate.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="/js/lib/element/index.css">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/forget.css?v=2.0.0" rel="stylesheet">
    <title>忘记密码</title>

  </head>
  <body>
    <div id="app">
      <header class="ysz-header">
        <div class="y-header">
          <div class="w clearfix">
            <a href="/index">
              <h1 class="y-head fl">
              <img class="logo" src="/image/logo.png" alt="logo">
              <span class="y-title">创作平台</span>
              </h1>
            </a>
            <p class="login fr">已有账号？<a href="/index">登录</a></p>
          </div>
        </div>
      </header>
      <div id="main">
        <div class="w clearfix">
          <div class="main-wrap mb-60" id="reg">
            <h2 class="title">忘记密码</h2>
            <div class="stage-wrap">
                <!-- <div class="stage-info">
                  <ul class="navul clearfix">
                    <li class="active">
                        <i class="i-num">1</i>输入手机号
                      </li>
                    <li class="active">
                        <i class="i-num">2</i>验证并设置密码
                      </li>
                    <li class="active">
                        <i class="i-num iconfont">&#xe601;</i>注册完成
                      </li>
                  </ul>
                </div> -->
              <div class="forget-wrap">
                <div class="third-wrap">
                  <div class="item">
                    <img src="/image/reg/right.png" alt="">
                  </div>
                  <div class="item">
                    <p class="msg">找回密码成功！</p>
                  </div>
                  <div class="item">
                    <p class="back"><span>@{{num}}</span>S后自动返回至登录页</p>
                  </div>
                  <div class="btn-group next">
                    <input @click="goToHome" class="btn btn-24" type="button" value="完成">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ysz-footer2></ysz-footer2>
    </div>
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <script src="/js/forget/third.js?v=2.0.0"></script>
</html>