<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>艺术者</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/js/plugin/swiper-3.4.1.min.css" rel="stylesheet">
    <link href="/css/global.css" rel="stylesheet">
    <link href="/css/gcommon.css" rel="stylesheet">
    <link href="/css/index.css?v=0.0.1" rel="stylesheet">
  </head>
  <body>
    <div v-cloak id="app">
      <header class="ysz-header">
        <div class="y-header">
          <div class="w clearfix">
            <a href="/index">
              <h1 class="y-head fl">
              <img class="logo" src="/image/logo.png" alt="logo">
              <span class="y-title">创作平台</span>
              </h1>
            </a>
          </div>
        </div>
      </header>
      <div id="main">
        <div class="loginmain">
          <div class="w clearfix">
            <!-- <div v-if="!isLogin" class="loginpanel fr">
              <h2>登录</h2>
              <p class="errortip">@{{errorTip}}</p>
              <div class="login-item clearfix">
                <span class="login-l"><i class="icons icon-phone"></i></span>
                <input v-model="userInfo.mobile" class="input" type="text" placeholder="请输入手机号码" maxlength="11">
              </div>
              <div class="login-item clearfix">
                <span class="login-l"><i class="icons icon-pass"></i></span>
                <input v-model="userInfo.password" class="input" type="password" placeholder="请输入密码" maxlength="16">
              </div>
              <div class="btn-group">
                <input @click="accountLogin" id="btn-login" class="btn" type="button" value="登录">
              </div>
              <div class="links clearfix">
                <a href="/register/first" class="link reg fl">立即注册</a>
                <a href="/forget/first" class="link forget fr">忘记密码？</a>
              </div>
            </div>
            <div v-else class="logined fr">
              <p>认证成为艺术家，即可上传作品</p>
              <a class="btn" href="/auth/rule">认证艺术家</a>
            </div> -->
            <div class="slogan">
              <p class="s1">专注手绘艺术创作</p>
              <p class="s2">打造原创个人品牌</p>
            </div>
          </div>
          <!-- <div class="appdownbox fix">
            <div class="appios fl">iPhone下载</div>
            <div class="appandroid fl">Android下载</div>
            <a href="/index/appdown" class="appdown-btn fl">免费下载</a>
          </div> -->
        </div>
        <div class="main-2">
          <div class="w clearfix">
            <div class="mission fr">
              <h2>你只要负责创作，其他交给我们</h2>
              <ul>
                <li><i class="icons icon-yun"></i>快捷记录形成创作日志，深度呈现作品灵魂，让有 故事的作品打动欣赏者。</li>
                <li><i class="icons icon-hua"></i>全网内容分发，提供专题、专访，直播宣传，源源 不断获得粉丝藏家。</li>
                <li><i class="icons icon-wang"></i>开放机构入驻，不管是独立艺术家还是已签约艺术 家，都能享受更多合作机会。</li>
              </ul>
            </div>
            <div class="swipe">
              <div v-cloak class="swiper-container ani" id="swiper-container-1">
                <div class="swiper-wrapper">
                <div v-for="item in swiper1" class="swiper-slide">
                    <div class="inner">
                      <img :src="item.img">
                      <div id="test" class="info">
                        <i class="icons icon-quote1"></i>
                        <h3>@{{item.name}}</h3>
                        <p>@{{item.desc}}</p>
                        <i class="icons icon-quote2"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="swiper-pagination-1"></div>
              </div>
                <!-- <el-carousel :interval="50000" type="card" height="610px" arrow="never">
                  <el-carousel-item v-for="item in swiper1">
                    <img :src="item.img">
                    <h3>@{{item.name}}</h3>
                    <p>@{{item.desc}}</p>
                  </el-carousel-item>
                </el-carousel> -->
            </div>
          </div>
        </div>
        <div class="main-3">
          <div class="w clearfix">
            <div class="art-mobile fl">
              <h2>艺术者<span>手机版<i>V1.0</i></span></h2>
              <div class="clearfix">
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
              <!-- <div class="download">
                <h3>用手机扫描二维码，下载艺术者APP</h3>
                <img src="/image/index/app-download.png">
              </div> -->
            </div>
            <div class="swipe-wrap">
              <div class="swipe-inner">
                <el-carousel :interval="4000" indicator-position="outside" trigger="click" arrow="never">
                  <el-carousel-item v-for="item in swiper2">
                    <img :src="item.img">
                  </el-carousel-item>
                </el-carousel>
              </div>
            </div>
          </div>
        </div>
        <div class="main-4">
          <div class="w clearfix">
          <div class="team">
            <img class="team-pic" src="/image/index/team.png" alt="">
            <div class="team-info">
              <h2>关于【艺术者】团队</h2>
              <p>我们来自于深圳艺者科技有限公司，一群热爱绘画的年轻团队。致力于青年艺术家的品牌建立，为青年艺术家打造可持续发展的互联网平台，对接用户、藏家、机构，连接一切与艺术的可能。</p>
              <div class="address">
                <h3>深圳艺者科技有限公司</h3>
                <p>联系地址：深圳市南山区粤海街道高新南6道航盛科技大厦</p>
                <p>官方邮箱：art@gaosouyi.com</p>
                <p>官方微博：//weibo.cn/artzhe2017</p>
                <p>联系电话：0755-84355709</p>
                <p>联系QQ：1347520646</p>
              </div>
              <!-- <div class="wx-code">
                <img src="/image/index/wx-qrcode.png" alt="">
                <p>关注【艺术者】公众号</p>
              </div> -->
            </div>
          </div>
          </div>
        </div>
      </div>
      <!-- <div class="fix-wrap">
        <div class="tool-box">
          <div class="box app">
            <img class="app-qrcode code" src="/image/index/download-qrcode.png">
            <input class="btn btn-b" type="button" value="下载艺术者APP">
          </div>
          <div class="box">
            <input class="btn" type="button" value="关注公众号">
            <img class='wx code' src="/image/index/qrcode.png">
          </div>
        </div>
      </div> -->
      <footer>
        <div class="y-footer">
          <div class="w clearfix">
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
    </div>
    <div style="display: none;">
      <!-- <input type="hidden" id="artworkid" name="artworkid" value="@if(!empty($artworkid)){{$artworkid}}@else 0 @endif"> -->
      <input type="hidden" id="name" name="name" value="@if(!empty($user['name'])){{$user['name']}} @else 0 @endif">
      <input type="hidden" id="face" name="face" value="@if(!empty($user['face'])){{$user['face']}} @else 0 @endif">
    </div>
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/js/service/agent.js"></script>
  <script src="/js/plugin/swiper.jquery.min.js"></script>
  <script src="/js/common.js"></script>
  <script src="/js/index/index.js"></script>
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
  </script>
</html>