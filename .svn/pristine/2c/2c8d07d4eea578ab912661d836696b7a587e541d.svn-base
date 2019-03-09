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
    <title>我的关注</title>
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
    <div class="user-follow" id="user-follow">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <div v-cloak v-show="!hasList" class="holder">
        <img  src="/Public/image/user/holder.png">
        <p>数位艺术家都在等待你的关注~</p>
      </div>
      <div v-if="hasList">
        <scroller :on-refresh="refresh"
        :on-infinite="infinite"
        ref="my_scroller">
        <ul v-cloak v-if="hasList" class="follow-list">
          <li class="artist-info" v-for="item in list" :id="item.user_id">
            <img class="avatar" :src="item.faceUrl">
            <div class="detail">
              <span class="nickname">@{{ item.name }}</span>
              <i class="icons icon-artist"></i>
              <span class="desc ellipsis">@{{item.categoryNames}}</span>
              <i v-if="!item.unfollow" @click="showMsgBox(item.user_id)" :class="[item.unfollow ? '' : 'icon-followed', 'icons', 'icon-follow']"></i>
              <i v-else @click="followArtist(item.user_id)" :class="[item.unfollow ? '' : 'icon-followed', 'icons', 'icon-follow']"></i>
            </div>
          </li>
        </ul>
        </scroller>
      </div>
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div v-show="msgBoxIsShow" class="thirdLayerIn anim-scale msg-box" id="j_thirdLayer">
            <h3 class="title">艺术者提示</h3>
            <div class="content">
              确定不再关注此艺术家？
            </div>
            <div class="btns fix">
              <span @click="cancelFollow" class="btn-confirm">确认</span>
              <span @click="hideBox" class="btn-cancel">取消</span>
            </div>
          </div>
        </div>
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
  <script type="text/javascript" src="/Public/js/user/userfollow.js?v=0.0.1"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>