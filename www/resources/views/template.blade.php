<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者是最专业的">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <!-- <meta name="csrf-token" content="3wOniT3eM1AZx48w3gR6EawM0lDrcQwDSSh1xOOw"> -->
    <meta content="telephone=no,email=no" name="format-detection">
    <title>艺术者</title>
    <script src="{!! config('app.murl') !!}/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="{!! config('app.murl') !!}/css/global.css?v=0.0.4">
    <link rel="stylesheet" type="text/css" href="{!! config('app.murl') !!}/css/artworkUpdate.css?v=2.0.0">
    <link rel="stylesheet" type="text/css" href="{!! config('app.murl') !!}/css/richwap.css?v=0.0.1">
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <style type="text/css">

    </style>
    <!-- <link rel="stylesheet" type="text/css" href="/laravel-ueditor/third-party/video-js/video-js.min.css"/>
    <script type="text/javascript" src="/laravel-ueditor/third-party/video-js/video.js"></script>
    <script src="//cdn.bootcss.com/html5media/1.1.8/html5media.min.js"> </script>  -->
  </head>
  <body>
    <div  id="artwork-update">
      <div class="update-wrap">
        <div id="header">
          <div class="title-wrap">
            <h3 class="title ellipsis" id='iframe-name'>作品名称</h3>
            <i class="icons icon-update"></i>
          </div>
          <div class="art-info">
            <span class="creat-date"><span class="date-tip">创作时间: </span><span id='iframe-date'>2017-08-18</span></span>
            <a class="artist-name" id="artist-name" href="javascript:;">作者:</a>
          </div>
        </div>
        <div class="wrap view" id='wrap'>
        </div>
        <!-- <div class="flags">
          <i class="icons icon-flag"></i>
          <span v-for="(tag, index) in ruleForm.tagValue" :class="['label', 'flag', 'flag-' + index]">@{{tag}}</span>
          <span class="label flag flag-1">sfa</span>
        </div> -->

        <div class="interact">
          <div class="labels fix">
            <div class="label-l">
              <i class="icons icon-time"></i>
              <span id='iframe-date2' class="label">2017-08-18</span>
            </div>
            <!-- <div class="label-l">
              <i class="icons icon-eye"></i>
              <span class="label">6</span>
            </div>
            <div class="label-r">
              <i class="icons icon-com"></i>
              <span class="label">6</span>
            </div>
            <div class="label-r">
              <i class="icons icon-like"></i>
              <span class="label">6</span>
            </div> -->
            <div class="label-r">
              <span class="label">6次浏览</span>
            </div>
          </div>
          <!-- <ul class="comments" id="comments">
            <li class="comment">
              <div class="user-com">
                <div class="icon-r">
                  <i class="icon icon-praise"></i>
                  <span class="label">24</span>
                </div>
                <img class="avatar" src="/Public/image/paintingdetail/avatar.png">
                <a class="name" href="#">Poon</a>
                <div class="time">5分钟前</div>
                <p class="com">好喜欢这种风格的油画</p>
              </div>
              <div class="painter-com fix">
                <a class="name" href="#">白素</a>
                <span>回复：</span>
                <span class="com">谢谢你对作品的肯定！</span>
                <div class="time">5分钟前</div>
              </div>
            </li>
          </ul> -->
        </div>
      </div>
    </div>
  </body>
</html>
