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
    <title>推荐</title>
    <script src="/Public/js/lib/flexible.js"></script>

    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/progressjs.css">
    <script src="/Public/js/plugins/progress.js"></script>

    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=0.0.2">
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/dropload.css?v=0.0.2">
    <link rel="stylesheet" type="text/css" href="/Public/css/recommend.css?v=0.0.3">
</head>
<body>
  <div id="recommend">
    <div v-show="isLoading" id="loading">
      <img src="/Public/image/loading.gif?v=0.0.1">
    </div>
    <div id="header">
      <!-- <div class="logo">
        <img src="/Public/image/recommend/logo.png" alt="artzhe" title="艺术者">
      </div> -->
      <h1 class="tit">艺术者</h1>
      <i v-cloak v-if="addShow" @click="showDownload('为提高艺术创作质量，请在APP中上传作品。')" class="add icons icon-add"></i>
    </div>
    <div v-cloak id="main">
      <ol class="print-list" id="print-list">
        <li class="print-item"  data-id="print-id" v-for="printItem in printList">
          <a :href="['/artwork/detail/' + printItem.id]">
            <img class="print-url" v-lazy="printItem.cover">
            <div class="print-title">
              <h3 class="print-name ellipsis">@{{printItem.name}}</h3>
              <i :class="['icons', 'icon-update', 'icon-update-' + printItem.update_times]"></i>
            </div>
          </a>
        </li>
      </ol>
    </div>
    <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div v-show="downloadIsShow" class="thirdLayerIn anim-scale download-box" id="download-app">
            <h3 class="title">艺术者提示 <i @click="hideBox" class="icons icon-close"></i></h3>
            <div class="content">
              @{{ boxMsg }}
            </div>
            <div class="btn-group">
              <input type="button" class="btn2 btn-down" value="立即下载">
            </div>
          </div>
        </div>
      </div>
  </div>
  <div id="tab-bar">
    <nav class="tab-bar-list">
      <a class="tab-bar-item active" href="/index/recommend">
        <i class="icons icon-recommend"></i>
        <span class="tab-label">推荐</span>
      </a>
      <a class="tab-bar-item" href="/gallery/index">
        <i class="icons icon-gallery"></i>
        <span class="tab-label">画廊</span>
      </a>
      <a class="tab-bar-item" href="/user/index">
        <i class="icons icon-user"></i>
        <span class="tab-label">我</span>
      </a>
    </nav>
  </div>

</body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="/Public/js/plugins/vue-lazyload.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/util.js"></script>
  <script src="/Public/js/plugins/dropload.min.js"></script>
  <script type="text/javascript" src="/Public/js/recommend/recommend.js?v=0.0.1"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>