<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <!-- <meta name="csrf-token" content="3wOniT3eM1AZx48w3gR6EawM0lDrcQwDSSh1xOOw"> -->
    <meta content="telephone=no,email=no" name="format-detection">
    <title>我的喜欢</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css">
    <!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/> -->
    <!-- <meta name="viewport" content="width=device-width,user-scalable=no"> -->
    <link rel="stylesheet" type="text/css" href="/Public/css/user.css">
  </head>
  <body>
    <div style="display: none;">
      <input type="hidden" id="id" name="id" value="@if(!empty($user['id'])){{$user['id']}} @else 0 @endif">
    </div>
    <div class="user-like" id="user-like">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <div v-cloak v-show="!hasList" class="holder">
        <img  src="/Public/image/user/holder.png" alt="">
        <p>你收获的艺术品空空如也</p>
      </div>
      <div v-if="hasList">
        <scroller :on-refresh="refresh"
        :on-infinite="infinite"
        ref="my_scroller">
        <ul v-cloak v-if="hasList" class="list">
          <li class="item fix" v-for="item in list" :id="item.artworkId">
            <div class="info fix">
              <i @click="toggleLike(item.artworkId, item.unlike)" :class="[item.unlike ? '' : 'icon-liked', 'icons', 'icon-like']"></i>
              <!-- <i v-if="!item.unlike" @click="cancelLike(item.artworkId)" :class="[item.unlike ? '' : 'icon-liked', 'icons', 'icon-like']"></i>
              <i v-else @click="likeArt(item.artworkId)" :class="[item.unlike ? '' : 'icon-liked', 'icons', 'icon-like']"></i> -->
              <img class="pic" :src="item.coverUrl">
              <div class="group">
                <div class="title-row">
                  <h3 class="title ellipsis">@{{item.name}}</h3>
                  <i :class="['icons', 'icon-update', 'icon-update-grey-' + item.updateTimes]"></i>
                </div>
                <div class="name-row">
                  <a class="name" href="javascript:;">@{{item.artistName}}</a>
                  <i class="icons icon-artist"></i>
                </div>
              </div>
            </div>
            <div class="desc">@{{item.story}}</div>
          </li>
        </ul>
        </scroller>
      </div>
    </div>
  </body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="//cdn.bootcss.com/vue-resource/1.2.1/vue-resource.min.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/Public/js/service/agent.js?v=2.0.0"></script>
  <script src="/Public/js/util.js"></script>
  <script src="/Public/js/plugins/vue-scroller.min.js"></script>
  <script type="text/javascript" src="/Public/js/user/userlike.js?v=1.0.1"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>