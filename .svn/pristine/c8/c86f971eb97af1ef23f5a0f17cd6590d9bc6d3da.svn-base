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
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.6">
    <link rel="stylesheet" type="text/css" href="/Public/css/gallerydetail.css?v=1.1.2">
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      wx.config({!! $wechat_json !!});
      wx.ready(function(){
        wx.onMenuShareTimeline({
          title: '{!! strquote($artist["name"]) !!}的艺术画廊',
          link: '{!! config("app.url") !!}/gallery/detail/{{$artist["id"]}}',
          imgUrl: '{{$gallery["cover"]}}'
        });
        wx.onMenuShareAppMessage({
          title: '{!! strquote($artist["name"]) !!}的艺术画廊',
          desc: '{!! strquote($artist["motto"]) !!}',
          link: '{!! config("app.url") !!}/gallery/detail/{{$artist["id"]}}',
          imgUrl: '{{$gallery["cover"]}}',
          type: 'link',
          dataUrl: ''
        });
      });
    </script>
</head>
<body>
  <div class="gallery-detail" id="gallery-detail">
    <img :src="artistInfo.coverUrl" style="position: fixed; width: 100%; max-width: 10.0rem; height: auto;">
    <div v-show="isLoading" id="loading">
      <img src="/Public/image/loading.gif?v=0.0.1">
    </div>
    <div v-cloak class="swiper-container ani" id="swiper-container-h">
      <div class="swiper-wrapper">
        <div class="swiper-slide slide1 resume">
            <div class="intro">
              <div class="painterinfo">
                <img class="painterinfo-avatar" :src="artistInfo.faceUrl">
                <span class="painterinfo-nickname">@{{artistInfo.name}}</span>
                <span class="painterinfo-desc ellipsis">@{{artistInfo.motto}}</span>
              </div>
              <div class="follow-bar-list">
                <div class="follow-bar-item" href="#">
                  <!-- <i class="icons icon-fans"></i> -->
                  <span class="follow-bar-label">@{{artistInfo.followTotal}}</span>
                  <span class="follow-bar-label">粉丝</span>
                </div>
                <div class="follow-bar-item" href="#">
                  <!-- <i class="icons icon-like"></i> -->
                  <span class="follow-bar-label">@{{artistInfo.likeTotal}}</span>
                  <span class="follow-bar-label">喜欢</span>
                </div>
                <div class="follow-bar-item" href="#">
                  <!-- <i class="icons icon-eye"></i> -->
                  <span class="follow-bar-label">@{{artistInfo.viewTotal}}</span>
                  <span class="follow-bar-label">浏览</span>
                </div>
              </div>
            </div>
            <div class="record" v-html="artistInfo.resume"></div>
        </div>
        <div v-for="(artwork, index) in artworkList" :class="['swiper-slide', 'painting', 'slide' + (index +2)]">
          <div class="content">
            <a :href="'/artwork/detail/' + artwork.id">
              <div class="screenshot">
                <img v-lazy="artwork.coverUrl"> <!-- :data-original="artwork.cover" class="lazy" :src="artwork.cover"-->
              </div>
              <div class="painting-desc">
                <div class="title">
                  <h3 class="ellipsis">@{{artwork.name}}</h3>
                  <i :class="['icons', 'icon-update', 'icon-update-grey-' + artwork.updatetimes]"></i>
                  <div class="icon-r heart">
                    <i class="icons icon-heart-grey"></i>
                    <span class="label">@{{artwork.liketotal}}</span>
                  </div>
                  <div class="icon-r eye">
                    <i class="icons icon-eye-grey"></i>
                    <span class="label">@{{artwork.viewtotal}}</span>
                  </div>
                </div>
                <div class="desc" v-html="artwork.story"></div>
              </div>
              <div class="bottom-1"></div>
              <div class="bottom-2"></div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div v-cloak id="btn-painting">@{{artistInfo.artworkTotal}}幅作品</div>
    <div v-cloak id="btn-resume">
      <i class="icons icon-back"></i>
    </div>
    <div id="footer">
      <nav class="share-bar-list">
        <div @click="toggleFollow('感谢您的关注，立即下载APP查看更多作品吧~')" :class="['share-bar-item', artistInfo.isFollowed == 'Y'? 'followed' : '']">
          <i class="icons icon-follow"></i>
          <span v-if="artistInfo.isFollowed == 'Y'" class="label">已关注</span>
          <span v-else class="label">加关注</span>
        </div>
        <div class="share-bar-item" @click="showShare">
          <i class="icons icon-share"></i>
          <span class="label">分享</span>
        </div>
      </nav>
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
  <div style="display:none;">
    <div id="sharecnf" link="{!! url()->full() !!}"></div>
    <input type="hidden" id="artistid" name="artistid" value="@if(!empty($artistid)){{$artistid}}@else 0 @endif">
    <input type="hidden" id="isFollow" name="isFollow" value="@if(!empty($isFollow)){{$isFollow}}@else 0 @endif">
    <input type="hidden" id="id" name="id" value="@if(!empty($user['id'])){{$user['id']}} @else 0 @endif">
  </div>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="/Public/js/plugins/vue-lazyload.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/plugins/fastclick.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/Public/js/service/agent.js?v=2.0.2"></script>
  <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
  <script src="/Public/js/util.js?v=2.3.1"></script>
  <script type="text/javascript" src="/Public/js/gallery/gallerydetail.js?v=2.2.8"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
  </body>
</html>
