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
    <title>艺术者</title>
    <script src="/Public/js/lib/flexible.js"></script>

    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/progressjs.css">
    <script src="/Public/js/plugins/progress.js"></script>

    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.1.1">
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/dropload.css?v=0.0.2">
    <link rel="stylesheet" type="text/css" href="/Public/css/recommend.css?v=0.0.3">
    <!-- <script src="https://jic.talkingdata.com/app/h5/v1?appid=CC91C1C415594DFC9B2DE0776ECA2EA0&vn=4.2.0&vc=artzhe"></script> -->
</head>
<body>
  <div id="recommend">
    <div v-show="isLoading" id="loading">
      <img src="/Public/image/loading.gif?v=0.0.1">
    </div>
    <!-- <div id="header">
      <h1 class="tit">艺术者</h1>
      <i v-cloak v-if="addShow" @click="showDownload('为提高艺术创作质量，请在APP中上传作品。')" class="add icons icon-add"></i>
    </div> -->
    <div v-cloak id="main">
      <ol class="print-list" id="print-list">
        <li class="print-item"  data-id="print-id" v-for="printItem in printList">
          <a :href="['/artwork/detail/' + printItem.id]">
            <img class="print-url" v-lazy="printItem.coverUrl">
            <div class="print-title">
              <h3 class="print-name ellipsis">@{{printItem.name}}</h3>
              <i :class="['icons', 'icon-update', 'icon-update-' + printItem.update_times]"></i>
            </div>
          </a>
        </li>
      </ol>
    </div>
    <!-- 弹窗 -->
      <download-box></download-box>
      <footer-bar></footer-bar>
  </div>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="/Public/js/plugins/vue-lazyload.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/plugins/fastclick.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/Public/js/service/agent.js?v=2.0.1"></script>
  <script src="/Public/js/plugins/dropload.min.js"></script>
  <script src="/Public/js/util.js?v=2.3.0"></script>
  <script type="text/javascript" src="/Public/js/recommend/recommend.js?v=2.2.6"></script>
</body>
</html>
