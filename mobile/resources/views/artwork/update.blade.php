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
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.1">
    <link rel="stylesheet" type="text/css" href="/Public/css/artworkUpdate.css?v=1.1.1">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.1.3">
    <style>
      .view img {
        display: block;
        margin-top: 0.24rem;
        width: 100%;
      }
      .h5-appad,
      .update-wrap {
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
      }
      .h5-appad {
        position: absolute;
      }
      #message-frame2{
        position: fixed;
        bottom: 0;
      }
    </style>
    <!-- <script src="https://jic.talkingdata.com/app/h5/v1?appid=CC91C1C415594DFC9B2DE0776ECA2EA0&vn=4.2.0&vc=artzhe"></script> -->
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
    wx.config({!! $wechat_json !!});
    wx.ready(function(){
      wx.onMenuShareTimeline({
        title: '{!! strquote($artwork["artwork"]["publisher"]["name"]) !!}《{!! strquote($artwork["artwork"]["name"]) !!}》更新{{$artwork["number"]}}',
        link: '{!! config("app.url") !!}/artwork/update/{{$artwork["id"]}}',
        imgUrl: '{{$artwork["cover"]}}'
      });
      wx.onMenuShareAppMessage({
        title: '{!! strquote($artwork["artwork"]["publisher"]["name"]) !!}《{!! strquote($artwork["artwork"]["name"]) !!}》更新{{$artwork["number"]}}',
        desc: '单次更新-{!! strquote($artwork["summary"]) !!}',
        link: '{!! config("app.url") !!}/artwork/update/{{$artwork["id"]}}',
        imgUrl: '{{$artwork["cover"]}}',
        type: 'link',
        dataUrl: ''
      });
    });
    </script>
  </head>
  <body>
    <div v-cloak id="artwork-update">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <div class="update-wrap" :style="{top: aDInfo.height }">
        <div id="header">
          <div class="title-wrap">
            <h3 class="title ellipsis">@{{update.artname}}</h3>
            <i :class="['icons', 'icon-update', 'icon-update-grey-' + update.number]"></i>
            <!-- <i class="icons icon-edit"></i> -->
          </div>
          <div class="art-info">
            <span class="creat-date">创作时间：@{{update.time}}</span>
            <a class="artist-name" :href="'/gallery/detail/' + artistid">@{{update.publisherInfo.name}}</a>
          </div>
        </div>
        <div id="wit" class="wrap view" v-html="update.wit">
        </div>
        <div class="interact">
          <div class="labels fix">
            <div class="label-l">
              <i class="icons icon-time"></i>
              <span class="label">@{{update.create_time}}</span>
            </div>
            <div class="label-r">
              <span class="label">@{{update.view_total}}次浏览</span>
            </div>
            <!-- <div class="label-l">
              <i class="icons icon-eye"></i>
              <span class="label">@{{update.view_total}}</span>
            </div>
            <div class="label-r">
              <i class="icons icon-com"></i>
              <span class="label">@{{update.commentTotal}}</span>
            </div>
            <div class="label-r">
              <i class="icons icon-like"></i>
              <span class="label">@{{update.like_total}}</span>
            </div> -->
          </div>
          <div class="painter">
            <div class="info">
              <a :href="'/gallery/detail/' + update.publisherInfo.id">
                <img class="avatar" v-lazy="update.publisherInfo.faceUrl">
              </a>
              <div class="det">
                <h3 class="name">@{{update.publisherInfo.name}}</h3>
                <span>作品@{{update.publisherInfo.artTotal}}</span>
                <span>粉丝@{{update.publisherInfo.follower_total}}</span>
              </div>
              <div @click="toggleFollow('感谢您的关注，立即下载APP查看更多作品吧~')" :class="['follow', isFollow? 'followed': '']">
                <i class="icons icon-follow"></i>
                <span v-if="isFollow" class="label">已关注</span>
                <span v-else class="label">加关注</span>
              </div>
            </div>
          </div>
          <div class="liker fix">
            <div class="like" @click="toggleLike('感谢您的喜欢，立即下载APP查看更多作品吧~')">
              <i :class="['icons', isLike?'icon-liked': 'icon-like']"></i>
              <span>喜欢</span>
            </div>
            <ul class="likers fix">
              <li v-for="(item, index) in update.likes">
                <img v-lazy="item">
                <p v-if="update.like_total > 6 & index == '5'" class="num">@{{update.like_total}}</p>
              </li>
              <!-- <li>
                <img src="/Public/image/appDown.png">
                <p class="num">10</p>
              </li> -->
            </ul>
          </div>
          <ul v-if="update.commentList.length > 0" class="comments">
            <h2><i class="icons icon-comment"></i>@{{update.commentTotal}}条评论</h2>
            <li class="comment" v-for="commentItem in update.commentList">
              <div class="user-com">
                <div class="icon-r" @click="toggleZan(commentItem.commentId,commentItem.isLike)">
                  <i :class="['icons', commentItem.isLike == 'Y'?'icon-praised': 'icon-praise']"></i>
                  <span class="label" v-if="commentItem.likes > 0">@{{commentItem.likes}}</span>
                </div>
                <img class="avatar" v-lazy="commentItem.faceUrl">
                <a class="name" href="javascript:;">@{{commentItem.nickname}}</a>
                <div class="time">@{{commentItem.time}}</div>
                <p class="com">@{{commentItem.content}}</p>
              </div>
              <div class="painter-com fix" v-if="commentItem.repayContent">
                <a class="name" href="javascript:;">@{{commentItem.repayer}}</a>
                <span>回复：</span>
                <span class="com">@{{commentItem.repayContent}}</span>
                <div class="time">@{{commentItem.repayTime}}</div>
              </div>
            </li>
          </ul>
          <div class="btn-group">
            <a v-if="update.commentTotal > 2" class="btn-download" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">打开艺术者，查看全部评论</a>
            <a v-if="update.commentList.length == 0" class="btn-download" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">打开艺术者，发表评论</a>
          </div>
        </div>
        <div class="rel" v-if="update.related.length > 0">
          <h2>相关内容</h2>
          <ul class="rel-list">
            <li class="rel-item fix" v-for="item in update.related">
              <a :href="'/artwork/update/' + item.id">
                <div class="rel-info">
                  <h3 class="ellipsis">@{{item.name}}@{{item.number}}</h3>
                  <p>发布时间：@{{item.create_date}}</p>
                </div>
                <img v-lazy="item.cover">
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div id="message-frame" class="message-frame">
        <form id="message-form" @submit.prevent="commentUpdate('下载艺术者APP即可点评作品~')">
          <input type="text" @click="stickInput" id="message" :class="{'active':btnShow}" v-model="commentContent" placeholder="此刻写下来的就是艺术">
          <i v-show="!btnShow" class="icons icon-share" @click="showShare"></i>
          <div v-show="!btnShow" class="mess-icon icon_po" style="float: right; position: relative;" @click="toggleLike('感谢您的喜欢，立即下载APP查看更多作品吧~')">
            <i :class="['icons', isLike?'icon-liked': 'icon-like']"></i>
            <span class="num" v-if="update.like_total > 0">@{{update.like_total}}</span>
          </div>
          <!-- <i v-show="!btnShow" class="icons icon-comment"><span class="num" v-if="update.commentTotal > 0">@{{update.commentTotal}}</span></i> -->
          <span v-show="btnShow" @click="commentUpdate('下载艺术者APP即可点评作品~')" class="btn-sm">发送</span>
        </form>
      </div>
      <!-- APP广告浮层 -->
      <div v-show="aDInfo.isShow" class="h5-appad" id="h5-appad">
        <div class="swiper-container" id="swiper-container-t">
          <div class="swiper-wrapper">
            <div v-for="item in H5TopInfo" class="swiper-slide">
              <img v-lazy="item.img">
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
      <input type="hidden" id="artworkid" name="artworkid" value="@if(!empty($artwork['id'])){{$artwork['id']}}@else 0 @endif">
      <input type="hidden" id="artistid" name="artistid" value="@if(!empty($artwork['artwork']['artist'])){{$artwork['artwork']['artist']}}@else 0 @endif">
      <input type="hidden" id="nickname" name="nickname" value="@if(!empty($user['nickname'])){{$user['nickname']}} @else 0 @endif">
      <input type="hidden" id="face" name="face" value="@if(!empty($user['face'])){{$user['face']}} @else 0 @endif">
    </div>
    <script src="/Public/js/lib/vue.min.js"></script>
    <script src="/Public/js/plugins/vue-lazyload.js"></script>
    <script src="/Public/js/plugins/fastclick.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script src="/Public/js/service/agent.js?v=2.0.1"></script>
    <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
    <script src="/Public/js/util.js?v=2.3.1"></script>
    <script type="text/javascript" src="/Public/js/gallery/artworkupdate.js?v=2.3.7"></script>
    <script type="text/javascript">
      // var interval = setInterval(function() {
      //   document.body.scrollTop = document.body.scrollHeight
      // }, 100);
      // Vue.use(VueLazyload, {
      //   preLoad: 1.3,
      //   error: false,
      //   loading: '/Public/image/holder.png',
      //   attempt: 1
      // });

    </script>
  </body>
</html>
