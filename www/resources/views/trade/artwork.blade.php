<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>原作交易</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/trade/artwork.css?v=2.0.0" rel="stylesheet">
  </head>
  <body>
    <div v-cloak id="app">
      <header class="ysz-header">
        <div class="y-header">
          <div class="w clearfix">
            <a href="/index">
              <h1 class="y-head fl">
              <img class="logo" src="/image/logo.png" alt="logo">
              <span class="y-title">创作平台</span>
              </h1>
            </a>
            <div class="user fr">
              <div class="info">
                <img :src="myInfo.face">
                <span>@{{myInfo.name}}</span>
                <change-user-btn></change-user-btn>
                <a href="/passport/logout">退出</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div id="main">
        <div class="w">
          <div class="main-wrap mb-72 clearfix">
            <ysz-upload-nav></ysz-upload-nav>
            <div class="con-wrap">
              <ul class="tab-nav clearfix">
                <li v-for="(tab, index) in tabs" @click="toggle(index ,tab.view)" :class="{active:active == index}">
                  @{{tab.type}}
                </li>
              </ul>
              <keep-alive>
                <component :is="currentView"></component>
              </keep-alive>
            </div>
          </div>
        </div>
      </div>
      <!-- 编辑商品属性弹窗 -->
      <goods-attr-wrap></goods-attr-wrap>
      <!-- 提醒属性弹窗 -->
      <goto-attr-wrap></goto-attr-wrap>
      <!-- 作品属性弹窗 -->
      <artwork-attr-wrap></artwork-attr-wrap>
      <ysz-footer2></ysz-footer2>
    </div>
    <script src="/js/lib/vue.min.js"></script>
    <script src="/js/lib/element/index.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script src="/js/service/agent.js?v=2.1.6"></script>
    <script src="/js/common.js?v=3.9.2"></script>
    <script src="/js/trade/artwork.js?v=2.0.2"></script>
  </body>
</html>
