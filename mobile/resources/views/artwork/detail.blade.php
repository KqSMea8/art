<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta name ="viewport" content ="initial-scale=1, maximum-scale=1, minimum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <title>艺术者</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.8">
    <link rel="stylesheet" type="text/css" href="/Public/css/paintingdetail.css?v=1.2.8">
    <style type="text/css">
      #swiper-covers {
        height: 10.0rem;
      }
      .imgbg{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
                justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
                align-items: center;
      }
      .imgbg img{
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 100%;
      }
    </style>
    <!-- <script src="https://jic.talkingdata.com/app/h5/v1?appid=CC91C1C415594DFC9B2DE0776ECA2EA0&vn=4.2.0&vc=artzhe"></script> -->
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
    <div v-cloak id="artwork-detail" :style="{ position: 'relative', top: aDInfo.height }">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <div id="header">
        <div class="painting-new">
          <!-- <div class="cover">
            <img :src="artworkNow.coverUrl" @click="showCoverList">
            <i :class="['icons', 'icon-update', 'icon-update-' + artworkNow.update_times]"></i>
          </div> -->

          <div class="swiper-container" id="swiper-covers">
            <div class="swiper-wrapper">
              <div class="swiper-slide imgbg" v-for="item in artworkNow.coverThumbList">
                <img v-lazy="item">
              </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination" id="swiper-covers-pagination"></div>
          </div>

          <!-- <div class="swiper-container">
            <div class="swiper-wrapper">
              <img :src="artworkNow.cover">
            </div>
          </div> -->
          <div class="detail">
            <div class="title">
              <h3 class="ellipsis">@{{artworkNow.category_name}}</h3>
              <!--<div class="icon-r heart">
                <i class="icons icon-heart-grey"></i>
                <span class="label">1026</span>
              </div> -->
              <div class="icon-r eye">
                <i class="icons icon-eye-grey"></i>
                <span class="label">@{{artworkNow.view_total}}</span>
              </div>
            </div>
<!--             <a v-if="artworkNow.prints.is_for_sale" :href="artworkNow.prints.sale_url" class="buy-link">
              <i class="icons icon-buy"></i>收藏版画
            </a> -->
            <div class="flags">
              <i class="icons icon-flag"></i>
              <span v-for="(tag, index) in artworkNow.tags" :class="['label', 'flag', 'flag-' + index]">@{{tag}}</span>
            </div>
          </div>
          <div class="sellinfo" v-if="sellInfo && (sellInfo.raw || sellInfo.prints)">
            <div class="yuanzuosell" v-if="sellInfo.raw&&sellInfo.raw.goods_id">
              <h3 class="yuanzuosellTitle">原作<span>￥@{{sellInfo.raw.price}}</span></h3>
              <span class="ysp1">
                <span class="hassomething" v-if="sellInfo.raw.framed"></span>
                <span class="hasnothing" v-else></span>
                装裱
              </span>
              <span class="ysp2">
                <span class="hassomething" v-if="sellInfo.raw.certificate"></span>
                <span class="hasnothing" v-else></span>
                收藏证书
              </span>
              <span class="ysp3">
                快递费:￥@{{sellInfo.raw.ship_price}}
              </span>
              <template>
                <a class="yhsellbtn" href="javascript:;" @click="sellRaw" v-if="sellInfo.raw.sold==0">购买原作</a>
                <a class="yhselldbtn" href="javascript:;" v-else>已售出</a>
              </template>
            </div>

            <div class="banhuasell" v-if = "sellInfo.prints&&sellInfo.prints.goods_id">
                <h3 class="bhsellTitle">版画<span>￥@{{sellInfo.prints.price}}</span></h3>
                <a class="bhsellbtn" href="javascript:;" @click="sellPainting">购买版画</a>
            </div>
          </div>
          <div class="painter">
            <div class="desc">
              <h3>创作心路</h3>
              <p v-html="artworkNow.story"></p>
            </div>
            <div class="info">
              <a :href="'/gallery/detail/' + artist.id">
                <img class="avatar" :src="artist.face">
              </a>
              <div class="det">
                <h3 class="name">@{{artist.name}}</h3>
                <span>作品@{{artist.artTotal}}</span>
                <span>粉丝@{{artist.follower_total}}</span>
              </div>
              <div @click="toggleFollow('感谢您的关注，立即下载APP查看更多作品吧~', $event)" :class="['follow', isFollow? 'followed': '']">
                <i class="icons icon-follow"></i>
                <span v-if="isFollow" class="label">已关注</span>
                <span v-else class="label">加关注</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <a class="message-board" :href="'/artwork/messageboard/' + artworkNow.id">
        <div class="user-list">
          <img v-for="face in artworkNow.commentFace" class="avatar" :src="face">
          <!-- <img class="avatar" src="/Public/image/paintingdetail/avatar.png"> -->
        </div>
        <div class="title">留言板<span v-if="artworkNow.comment_total > 0">(@{{artworkNow.comment_total}})</span></div>
        <i class="icons icon-arrow"></i>
      </a>
      <div class="updates" v-if="updateList.length > 0">
        <h3 class="title">创作纪录</h3>
        <ul class="update-list">
          <li class="update-year-item" v-for="updateItem in updateList">
            <h3 class="year">@{{updateItem.year}}年</h3>
            <ul class="update-detail-list">
              <li class="update-detail-item" v-for="detailItem in updateItem.list">
                <i class="icons icon-timeline"></i>
                <div class="info">
                  <div class="update-num">
                    <span class="label">纪录</span>
                    <i :class="['icons', 'icon-update', 'icon-update-grey-' + detailItem.number]"></i>
                  </div>
                  <div class="date">
                    <span class="day">@{{detailItem.day}}</span>
                    <span class="month">@{{detailItem.month}}月</span>
                  </div>
                </div>
                <div class="detail">
                  <i class="icons icon-smallarrow"></i>
                  <a :href="'/artwork/update/' + detailItem.id">
                    <div class="img-wrap">
                      <img v-for="cover in detailItem.coverUrl" class="img-item-3" v-lazy="cover">
                    </div>
                    <div class="desc" v-html="detailItem.summary + '……'"></div>
                  </a>
                  <div class="mess">
                    <ul class="mess-list">
                      <li class="mess-item fix" v-for="comItem in detailItem.comment">
                        <a class="username" href="javascript:;">@{{comItem.nickname}}:</a>
                        <p class="con">@{{comItem.content}}</p>
                      </li>
                    </ul>
                    <a v-if="detailItem.comment_total > 3" class="more" :href="'/artwork/update/' + detailItem.id + '#comments'">
                      <span>查看@{{detailItem.comment_total}}条评论</span>
                      <i class="icons icon-arrow"></i>
                    </a>
                  </div>
                </div>
              </li>
            </ul>
          </li>
          <!-- <li v-for="updateItem in updateList" class="update">
            <i class="icons icon-ring"></i>
            <div class="info">
              <div class="update-num">
                <span class="label">更新</span>
                <i :class="['icons', 'icon-update', 'icon-update-grey-' + updateItem.number]"></i>
              </div>
              <div class="date">@{{updateItem.create_date}}</div>
            </div>
            <a class="img-wrap" :href="'/artwork/update/' + updateItem.id">
              <img v-for="cover in updateItem.coverUrl" :class="['img-item-' + updateItem.coverUrl.length]" v-lazy="cover">
            </a>
            <div class="desc" v-html="updateItem.summary"></div>
            <div class="mess">
              <ul class="mess-list">
                <li class="mess-item fix" v-for="comItem in updateItem.comment">
                  <a class="username" href="javascript:;">@{{comItem.nickname}}:</a>
                  <p class="con">：@{{comItem.content}}</p>
                </li>
              </ul>
              <a v-if="updateItem.comment.length > 3" class="more" :href="'/artwork/update/' + updateItem.id + '#comments'">
                <span>查看@{{updateItem.comment.length}}条评论</span>
                <i class="icon icon-arrow"></i>
              </a>
            </div>
          </li> -->
        </ul>
      </div>
      <ul class="interact-bar-list">
        <li @click="toggleLike('感谢您的喜欢，立即下载APP查看更多作品吧~')" :class="[isLike? 'active': '', 'interact-bar-item']">
          <i class="icons icon-like"></i>
          <span class="label" v-if="artworkNow.like_total > 0">@{{artworkNow.like_total}}</span>
        </li>
        <li class="interact-bar-item">
          <a @click="showMsg('下载艺术者APP即可点评作品~')" href="javascript:;">
            <i class="icons icon-com"></i>
            <span class="label" v-if="artworkNow.comment_total > 0">@{{artworkNow.comment_total}}</span>
          </a>
        </li>
        <li @click="showShare" class="interact-bar-item share">
          <i class="icons icon-share"></i>
        </li>
      </ul>
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

      <!-- /预付定金弹窗 -->
      <div class="downPaymentbox">
        <div class="downPayment">

        </div>
      </div>

    <div style="display:none;">
      <input type="hidden" id="artworkid" name="artworkid" value="@if(!empty($artworkid)){{$artworkid}}@else 0 @endif">
      <input type="hidden" id="id" name="id" value="@if(!empty($user['id'])){{$user['id']}} @else 0 @endif">
    </div>
    <script src="/Public/js/lib/vue.min.js"></script>
    <script src="/Public/js/plugins/vue-lazyload.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="/Public/js/plugins/fastclick.js"></script>
    <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script src="/Public/js/service/agent.js?v=2.0.1"></script>
    <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
    <script src="/Public/js/util.js?v=2.3.1"></script>
    <script type="text/javascript" src="/Public/js/gallery/paintingdetail.js?v=2.3.0"></script>
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
