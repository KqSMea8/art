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

    <!-- <link rel="stylesheet" type="text/css" href="/Public/js/plugins/progressjs.css">
    <script src="/Public/js/plugins/progress.js"></script> -->
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.0.2">
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/swiper-3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="/Public/css/home.css?v=1.0.4">
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
      wx.config({!! $wechat_json !!});
      wx.ready(function(){
        wx.onMenuShareTimeline({
          title: '艺术者',
          link: '{!! config("app.url") !!}/',
          imgUrl: '{!! config("app.url") !!}/Public/image/appDown.png'
        });
        wx.onMenuShareAppMessage({
          title: '艺术者',
          desc: '专注手绘艺术，遇见你的品味',
          link: '{!! config("app.url") !!}/',
          imgUrl: '{!! config("app.url") !!}/Public/image/appDown.png',
          type: 'link',
          dataUrl: ''
        });
      });
    </script>
</head>
<body>
    <div v-cloak id="app" :style="{ position: 'relative', top: aDInfo.height }">
      <header class="ysz-header">
        <div class="y-header">
          <div class="fix">
            <h1 class="y-head fl">
            <img class="logo" src="/Public/image/home/logo.png" alt="logo">
            <span class="y-title">创作平台</span>
            </h1>
          </div>
        </div>
      </header>
      <div id="main">
        <div class="main-1">
          <a class="gotohome" href="/index/recommend"></a>
          <!-- <div class="fix">
            <div class="slogan">
              <p class="s1">专注手绘艺术创作</p>
              <p class="s2">打造原创个人品牌</p>
            </div>
          </div> -->
        </div>
        <div class="main-2">
          <div class="fix">
            <div class="swipe">
              <div v-cloak class="swiper-container ani" id="swiper-container-1">
                <div class="swiper-wrapper">
                <div v-for="item in swiper1" class="swiper-slide">
                    <div class="inner">
                      <img :src="item.img">
                      <div id="test" class="info">
                        <i class="icons icon-quote1"></i>
                        <h3>@{{item.name}}：</h3>
                        <p>@{{item.desc}}</p>
                        <i class="icons icon-quote2"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="swiper-pagination-1"></div>
              </div>
            </div>
            <div class="mission">
              <h2>你只要负责创作，其他交给我们</h2>
              <ul>
                <li><i class="icons icon-yun"></i>快捷记录形成创作日志，深度呈现作品灵魂，让有 故事的作品打动欣赏者。</li>
                <li><i class="icons icon-hua"></i>全网内容分发，提供专题、专访，直播宣传，源源 不断获得粉丝藏家。</li>
                <li><i class="icons icon-wang"></i>开放机构入驻，不管是独立艺术家还是已签约艺术 家，都能享受更多合作机会。</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="main-3">
          <div class="fix">
            <div class="art-mobile">
              <h2>艺术者<span>手机版<i>V1.0</i></span></h2>
              <div class="fix">
                <dl>
                  <dt><h4>艺术欣赏者</h4></dt>
                  <dd>• 遇见最优秀的青年艺术家</dd>
                  <dd>• 了解每幅作品背后的故事</dd>
                  <dd>• 与艺术家交流互动</dd>
                  <dd>• 收获有品味的艺术社交圈</dd>
                </dl>
                <dl>
                  <dt><h4>艺术创作者</h4></dt>
                  <dd>• 随手一拍快速记录过程</dd>
                  <dd>• 云端发布永久保存创作历史</dd>
                  <dd>• 个人画廊永久展示、传播</dd>
                  <dd>• 随时与粉丝互动交流</dd>
                </dl>
              </div>
            </div>
            <!-- <div class="btn-group">
              <a class="btn" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">下载艺术者APP</a>
            </div> -->
          </div>
        </div>
        <div class="main-4">
          <div class="fix">
          <div class="team">
            <div class="team-info">
              <h2>关于【艺术者】团队</h2>
              <p>我们来自于深圳艺者科技有限公司，一群热爱绘画的年轻团队。致力于青年艺术家的品牌建立，为青年艺术家打造可持续发展的互联网平台，对接用户、藏家、机构，连接一切与艺术的可能。</p>
              <div class="address">
                <h3>深圳艺者科技有限公司</h3>
                <p>联系地址：深圳市南山区深圳湾科技生态园1期5栋C座</p>
                <p>官方邮箱：art@gaosouyi.com</p>
                <p>官方微博：https://weibo.cn/artzhe2017</p>
                <p>联系电话：0755-84355709</p>
                <p>联系QQ：1347520646</p>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
      <footer>
        <div class="y-footer">
          <div class="fix">
            <!-- <p class="mail">联系邮箱：art@gaosouyi.com</p>
            <p class="qrcode">
              <img src="/image/qrcode-wx.png">
              <img src="/image/qrcode-app.png">
            </p> -->
            <p>
              Copyright 2017 www.artzhe.com. All Rights Reserved<br>
              粤ICP备17041531号-1
            </p>
          </div>
        </div>
      </footer>
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
    </div>
    <!-- 下载APP浮层 -->
    <!-- <div class="appDown" id="j_appDown">
      <div class="appDown-in fix">
        <div class="appDown-logo"></div>
        <a href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">
          <div class="appDown-txt">
            <h3>艺术者APP</h3>
            <p>专注手绘艺术，遇见你的品味</p>
          </div>
          <div class="btn btn-down"><i class="icons icon-downloadapp-s"></i>立即下载</div>
        </a>
      </div>
    </div> -->
    <!-- 下载APP浮层 -->
</body>
  <script src="/Public/js/lib/vue.min.js"></script>
  <script src="/Public/js/plugins/vue-lazyload.js"></script>
  <script src="/Public/js/plugins/fastclick.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/Public/js/service/agent.js?v=2.0.0"></script>
  <script src="/Public/js/util.js?v=2.3.0"></script>
  <script src="/Public/js/plugins/swiper.jquery.min.js"></script>
  <script type="text/javascript" src="/Public/js/index/home.js?v=1.0.4"></script>
  <script type="text/javascript">
    var mySwiperH = new Swiper("#swiper-container-1", {
      loop: true,
      autoplay: 4000,
      speed:1000,
      slidesPerView: "auto",
      pagination : '#swiper-pagination-1',
      paginationClickable: true,
      centeredSlides: !0,
      observer:true,         //修改swiper自己或子元素时，自动初始化swiper
      observeParents:true,   //修改swiper的父元素时，自动初始化swiper
    });

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>
