<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术,美术,美术圈,艺术者,美学,artzhe,art,美术史,青年艺术家,艺术品,美院,arts,美术生,画展,画廊,美术馆,艺术品收藏,艺术电商网,故宫博物院,艺术电商,艺术品鉴,展览,艺术收藏,艺术品电商,博物馆,故宫展览,艺术展,艺术新闻,艺术生活,油画,插画,国画,水粉,水彩,素描,工笔,版画,漆画,丙烯,艺术云图,阿波罗,artand,艺术头条,artsy,雅昌,artpollo,意外艺术,艺术狗,在艺,雅昌兜藏,画家圈,Vart,芭莎艺术,空艺术,藏客,寺库艺术,中国美术馆,掌拍艺术,优家,艺典中国,艺堆,久久视频,在艺,艺厘米,艺堆 - 发现艺术,artstack,葫芦里,VICE MEDIA,imuseum,798,artstack limited,古玩鉴定,雅昌云图,雅昌艺术云图,人物,风景,静物,动物,植物,萌化,宗教,具象,抽象,古典,观念,表现,当代艺术,当代,原始艺术,古典艺术,现代艺术">
    <meta name="description" content="艺术者-遇见你的品味。这里有温度的艺术家，有故事的艺术作品，有品味的社交圈。专注手绘艺术创作，打造青年艺术家品牌。由艺术家记录艺术创作全过程，建立以艺术家、艺术作品为核心的社交网络，帮助艺术家轻松经营粉丝，建立个性互动的长期收藏，完善艺术作品流通。">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>艺术者-创作中心-专注手绘艺术，遇见你的品味</title>
    <link rel="shortcut icon" href="/favicon.ico?v=1.0.1" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/js/plugin/swiper-3.4.1.min.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.5" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.5" rel="stylesheet">
    <link href="/css/index2.css?v=2.0.5" rel="stylesheet">
  </head>
  <body>
   <div v-cloak id="app">
      <ysz-header></ysz-header>
      <div id="main">
        <div class="loginmain">
          <div class="w clearfix">
            <div v-if="!isCheck" class="loginpanel fr">
              <img v-if="isLogin" class="blur" src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/mpBanner.jpg?x-oss-process=image/resize,w_1920,q=50,image/format,jpg">
              <div v-if="!isLogin && !isCheck" class="to-login">
                <p class="errortip">@{{errorTip}}</p>
                <div class="login-item clearfix">
                  <span class="login-l"><i class="icons icon-phone"></i></span>
                  <input v-model="loginInfo.mobile" class="input" type="text" placeholder="请输入手机号码" maxlength="11">
                </div>
                <div class="login-item clearfix">
                  <span class="login-l"><i class="icons icon-pass"></i></span>
                  <input @keyup.enter="accountLogin" v-model="loginInfo.password" class="input" type="password" placeholder="请输入密码" maxlength="16">
                </div>
                <div class="links clearfix">
                  <a href="/register/first" class="link reg fl">立即注册</a>
                  <a href="/forget/first" class="link forget fr">忘记密码？</a>
                </div>
                <div class="btn-group">
                  <input @click="accountLogin" id="btn-login" class="btn" type="button" :value="btnText">
                </div>
              </div>
              <div v-if="isLogin && !isCheck && isAuth == 'N'" class="logined login-1">
                <p>申请认证成为艺术家/机构/策展人</p>
                <a class="btn" href="/auth/index">申请认证</a>
              </div>
              <div v-if="isLogin && !isCheck && isAuth == 'Y' && authInfo.status == '1'" class="logined login-2">
                <i class="icons icon-review"></i>
                <p class="p1">认证@{{authInfo.name}}审核中</p>
                <p class="p2">预计1~2个工作日，请耐心等待，谢谢~</p>
              </div>
              <div v-if="isLogin && !isCheck && isAuth == 'Y' && authInfo.status == '-1'" class="logined login-3">
                <i class="icons icon-unreview"></i>
                <p class="p1">认证@{{authInfo.name}}失败</p>
                <p class="p2">审核不通过</p>
                <p class="p3">@{{authInfo.remark}}</p>
                <a class="btn" :href="authInfo.link1">修改信息重新认证</a>
              </div>
              <div v-if="isLogin && !isCheck && userType > 0" class="logined login-4">
                <div class="info">
                  <img :src="userInfo.faceUrl">
                  <h3><span class="textOverflow1">@{{userInfo.name}}</span></h3>
                  <div class="icon-wrap">
                    <i v-show="userInfo.isArtist == 1" class="icons icon-artist"></i>
                    <i v-show="userInfo.isPlanner == 1" class="icons icon-planner"></i>
                    <i v-show="userInfo.isAgency == 1" class="icons icon-agency"></i>
                  </div>
                  <p :title="userInfo.motto">@{{userInfo.motto}}</p>
                </div>
                <a class="btn" :href="enterHref">进入创作中心</a>
              </div>
            </div>
            <div class="slogan">
            </div>
          </div>
        </div>
        <div class="main-2">
          <div class="w clearfix">
            <div class="mission">
              <h2>你只要负责创作，其他交给我们</h2>
              <ul>
                <li>快捷记录形成创作日志，深度呈现作品灵魂，让有故事的作品打动欣赏者。</li>
                <li>全网内容分发，提供专题、专访，直播宣传，源源不断获得粉丝藏家。</li>
                <li>开放机构入驻，不管是独立艺术家还是已签约艺术家，都能享受更多合作机会。</li>
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
            <h2 class="title">记录你的创作过程</h2>
            <ul class="record-list">
              <li class="record-0">记录创作过程</li>
              <li class="record-1">背后的故事</li>
              <li class="record-2">音/视/图/文</li>
              <li class="record-3">作品灵魂所在</li>
              <li class="record-4">时间轴回忆录</li>
            </ul>
            <div class="record-wrap">
              <img src="/image/index/app-record.png">
            </div>
          </div>
        </div>
        <div class="main-4">
          <div class="w clearfix">
            <h2 class="title">下一个网红艺术家就是你</h2>
            <ul class="wanghong-list clearfix">
              <li><i class="icons icon-xuan0"></i><p>粉丝社交圈</p></li>
              <li><i class="icons icon-xuan1"></i><p>线上线下画展</p></li>
              <li><i class="icons icon-xuan2"></i><p>权威艺术号</p></li>
              <li><i class="icons icon-xuan3"></i><p>自媒体专栏</p></li>
              <li><i class="icons icon-xuan4"></i><p>艺术家专访</p></li>
              <li><i class="icons icon-xuan5"></i><p>海报/APP封面宣传</p></li>
            </ul>
          </div>
        </div>
        <div :class="[bottomCodeShow? 'active': '', 'main-5']">
          <div class="w clearfix">
            <ul class="zhuanfang-list clearfix">
              <li>
                <a target="_blank" href="https://mp.weixin.qq.com/s/IskyZIVpXdMfKjzzrkihyw">
                  <img src="/image/index/artist-0.jpg">
                  <div class="info">
                    <h3>艺访 | 赵樱乔：思行合一的艺术探索者</h3>
                    <p>2017-08-14</p>
                  </div>
                </a>
              </li>
              <li>
                <a target="_blank" href="//mp.weixin.qq.com/s/D7pGfzaFjCTCzRP5I_BuJA">
                  <img src="/image/index/artist-1.jpg">
                  <div class="info">
                    <h3>艺访 | 匡雅明：科学与艺术的结合</h3>
                    <p>2017-07-24</p>
                  </div>
                </a>
              </li>
              <li>
                <a target="_blank" href="//mp.weixin.qq.com/s/x8trdivqTuffVU7XlQ1sMg">
                  <img src="/image/index/artist-2.jpg">
                  <div class="info">
                    <h3>艺访 | 白利：浪漫水彩，至纯至真</h3>
                    <p>2017-07-19</p>
                  </div>
                </a>
              </li>
              <li>
                <a target="_blank" href="//mp.weixin.qq.com/s/ShXaq8wvcs_DYSOFXayXww">
                  <img src="/image/index/artist-3.jpg">
                  <div class="info">
                    <h3>艺访 | 三番：我的作品会呼吸，会在街上行走</h3>
                    <p>2017-08-20</p>
                  </div>
                </a>
              </li>
            </ul>
            <a @click="toggleShowCode" class="goto-app" href="javascript:;">查看更多专访</a>
            <!-- <a target="_blank" class="btn-x goto-app" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">查看更多专访</a> -->
            <div id="bottom-download-wrap" :class="[bottomCodeShow? 'active': '', 'bottom-download-wrap']">
              <div class="title">下载艺术者APP查看更多专访</div>
              <div class="code-wrap">
                <img src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/APP.png">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="fix-wrap">
        <div style="display: none;" class="tool-box">
          <div class="box app">

            <!-- <img class="app-qrcode code" src="/image/index/download-qrcode.png"> -->
            <input class="btn btn-b" type="button" value="下载艺术者APP">
            <div id="download-code2" class="app-qrcode code"></div>
            <div style="display: none;" id="download-code1" class="app-qrcode code"></div>
          </div>
          <!-- <div class="box">
            <input class="btn" type="button" value="关注公众号">
            <img class='wx code' src="/image/index/qrcode.png">
          </div> -->
        </div>
      </div>
      <footer>
        <div class="ysz-footer-www">
          <div class="y-footer-www">
            <div class="w">
              <div class="foot-logo">
                <img src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/logo.png" alt="艺术者">
              </div>
              <div class="com-info">
                <ul class="foot-code">
                  <li>
                    <img class="code-image" src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/wechat.jpg">
                    <p class="txt">微信订阅号</p>
                  </li>
                  <li>
                    <img class="code-image" src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/APP.png">
                    <p class="txt">艺术者APP</p>
                  </li>
                </ul>
                <div class="foot-contact">
                  <h3>联系我们</h3>
                  <p>
                    地址: 深圳市南山区深圳湾科技生态园1期5栋C座<br>
                    联系邮箱：artzhe@artzhe.com<br>
                    官方微博：weibo.cn/artzhe2017
                  </p>
                </div>
              </div>
            </div>
          </div>
          <p class="copyright">Copyright 2017 www.artzhe.com. ALL Rights Reserved&nbsp;&nbsp;粤ICP备17041531号-1</p>
        </div>
      </footer>
    </div>
    <div style="display: none;">
      <input type="hidden" id="userid" name="userid" value="@if(!empty($user['id'])){{$user['id']}}@else 0 @endif">
      <input type="hidden" id="name" name="name" value="@if(!empty($user['name'])){{$user['name']}}@else 0 @endif">
      <input type="hidden" id="face" name="face" value="@if(!empty($user['face'])){{$user['face']}}@else 0 @endif">
    </div>
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/js/service/agent.js?v=2.1.6"></script>
  <script src="/js/plugin/qrcode.min.js"></script>
  <script src="/js/plugin/swiper.jquery.min.js"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <script src="/js/index/index.js?v=2.0.9"></script>
  <script type="text/javascript">
    var mySwiperH = new Swiper("#swiper-container-1", {
      loop: true,
      autoplay: 5000,
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
