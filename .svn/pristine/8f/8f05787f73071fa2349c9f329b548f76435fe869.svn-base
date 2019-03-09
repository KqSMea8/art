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
    <title>留言板</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.6">
    <link rel="stylesheet" type="text/css" href="/Public/css/messageboard.css?v=1.1.1">
    <style type="text/css">
      ._v-container {
        top: 1.14667rem !important;
      }
    </style>
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      wx.config({!! $wechat_json !!});
      wx.ready(function(){
        wx.onMenuShareTimeline({
          title: '{!! strquote($artwork["publisher"]["name"]) !!}《{!! strquote($artwork["name"]) !!}》',
          link: '{!! config("app.url") !!}/artwork/detail/{{$artwork["id"]}}',
          imgUrl: '{{$artwork["cover"]}}'
        });
        wx.onMenuShareAppMessage({
          title: '{!! strquote($artwork["publisher"]["name"]) !!}《{!! strquote($artwork["name"]) !!}》',
          desc: '{!! strquote($artwork["story"]) !!}' ,
          link: '{!! config("app.url") !!}/artwork/detail/{{$artwork["id"]}}',
          imgUrl: '{{$artwork["cover"]}}',
          type: 'link',
          dataUrl: ''
        });
      });
    </script>
  </head>
  <body>
    <div class="comments" id="comments">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <div v-cloak v-show="!hasList" class="holder">
        <img class="mess" src="/Public/image/paintingdetail/mess_holder.png">
      </div>
      <div v-if="hasList" class="board-wrap" :style="{top: aDInfo.height }">
        <h3 class="tit">留言板</h3>
        <scroller :on-refresh="refresh"
        :on-infinite="infinite"
        ref="my_scroller">
          <ul class="comment-list">
            <li class="comment" v-for="commentItem in comInfoList">
              <div class="user-com">
                <div class="icon-r" @click="toggleZan(commentItem.commentId,commentItem.isLike)">
                  <i :class="['icons', commentItem.isLike == 'Y'?'icon-praised': 'icon-praise']"></i>
                  <span class="label" v-if="commentItem.likes > 0">@{{commentItem.likes}}</span>
                </div>
                <img class="avatar" :src="commentItem.faceUrl">
                <a class="name" href="javascript:;">@{{commentItem.nickname}}</a>
                <div class="time">@{{commentItem.time}}</div>
                <p class="com">@{{commentItem.content}}</p>
              </div>
              <div v-if="commentItem.repayer" class="painter-com fix">
                <a class="name" href="javascript:;">@{{commentItem.repayer}}</a>
                <span>回复：</span>
                <span class="com">@{{commentItem.repayContent}}</span>
                <div class="time">@{{commentItem.repayTime}}</div>
              </div>
            </li>
          </ul>
        </scroller>
      </div>
      <div id="message-frame" class="message-frame">
        <form id="message-form" @submit.prevent="commentUpdate('立即下载即可点评作品~')">
          <input type="text" id="message" v-model="commentContent" placeholder="此刻写下来的就是艺术">
          <span @click="commentUpdate('立即下载即可点评作品~')" class="btn-sm">发送</span>
        </form>
      </div>
      <!-- APP广告浮层 -->
      <div v-show="aDInfo.isShow" class="h5-appad" id="h5-appad">
        <div class="swiper-container" id="swiper-container-t">
          <div class="swiper-wrapper">
            <div v-for="item in H5TopInfo" class="swiper-slide">
              <img :src="item.img">
              <div  class="info">
                <p class="title ellipsis">@{{item.title}}</p>
                <p class="desc ellipsis">@{{item.desc}}</p>
              </div>
            </div>
          </div>
          <div id="swiper-pagination-t"></div>
        </div>
        <a class="btn-open" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">打开</a>
        <i @click="closeAD" class="icons icon-close"></i>
      </div>
      <!-- APP广告浮层 end -->

      <!-- 分享弹窗 -->
      <share-box></share-box>

      <!-- 下载APP弹窗 -->
      <download-box></download-box>

    </div>
    <div style="display: none;">
      <input type="hidden" id="artworkid" name="artworkid" value="@if(!empty($artworkid)){{$artworkid}}@else 0 @endif">
      <input type="hidden" id="nickname" name="nickname" value="@if(!empty($user['nickname'])){{$user['nickname']}} @else 0 @endif">
      <input type="hidden" id="face" name="face" value="@if(!empty($user['face'])){{$user['face']}} @else 0 @endif">
    </div>
    <script src="/Public/js/lib/vue.min.js"></script>
    <script src="/Public/js/plugins/vue-scroller.min.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="/Public/js/plugins/fastclick.js"></script>
    <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script src="/Public/js/service/agent.js?v=2.0.0"></script>
    <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
    <script src="/Public/js/util.js?v=2.3.1"></script>
    <script src="/Public/js/plugins/dropload.min.js"></script>
    <script type="text/javascript" src="/Public/js/gallery/messageboard.js?v=2.2.6"></script>
    <script type="text/javascript">
      // var interval = setInterval(function() {
      //   document.body.scrollTop = document.body.scrollHeight
      // }, 100);

      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-96560910-1', 'auto');
      ga('send', 'pageview');
    </script>
  </body>
</html>
