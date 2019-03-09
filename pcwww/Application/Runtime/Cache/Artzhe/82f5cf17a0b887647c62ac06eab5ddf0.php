<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术,美术,美术圈,艺术者,美学,artzhe,art,美术史,青年艺术家,艺术品,美院,arts,美术生,画展,画廊,美术馆,艺术品收藏,艺术电商网,故宫博物院,艺术电商,艺术品鉴,展览,艺术收藏,艺术品电商,博物馆,故宫展览,艺术展,艺术新闻,艺术生活,油画,插画,国画,水粉,水彩,素描,工笔,版画,漆画,丙烯,艺术云图,阿波罗,artand,艺术头条,artsy,雅昌,artpollo,意外艺术,艺术狗,在艺,雅昌兜藏,画家圈,Vart,芭莎艺术,空艺术,藏客,寺库艺术,中国美术馆,掌拍艺术,优家,艺典中国,艺堆,久久视频,在艺,艺厘米,艺堆 - 发现艺术,artstack,葫芦里,VICE MEDIA,imuseum,798,artstack limited,古玩鉴定,雅昌云图,雅昌艺术云图,人物,风景,静物,动物,植物,萌化,宗教,具象,抽象,古典,观念,表现,当代艺术,当代,原始艺术,古典艺术,现代艺术">
    <meta name="description" content="艺术者-遇见你的品味。这里有温度的艺术家，有故事的艺术作品，有品味的社交圈。专注手绘艺术创作，打造青年艺术家品牌。由艺术家记录艺术创作全过程，建立以艺术家、艺术作品为核心的社交网络，帮助艺术家轻松经营粉丝，建立个性互动的长期收藏，完善艺术作品流通。">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>艺术者</title>
    <link rel="shortcut icon" href="/Public/favicon.ico?v=1.0.1" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="/Public/js/lib/element/index.css">
    <link href="/Public/js/plugin/swiper-3.4.1.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.0">
    <link rel="stylesheet" type="text/css" href="/Public/css/index.css?v=1.0.1">
  </head>
  <body>
    <div v-cloak id="app">
      <ysz-header></ysz-header>
      <div id="main">
        <div class="banner">
          <div class="w">
            <div class="lunbo">
              <div class="carousel">
                <div class="img-list">
                  <a v-for="item in websiteConfig.images" class="img-item" href="javascript:;">
                    <img :src="item.url">
                    <div class="img-modal"></div>
                  </a>
                </div>
                <div class="banner-bg"></div>
                <ol class="img-info">
                  <li v-for="item in websiteConfig.images">{{item.des}}</li>
                </ol>
                <ol class="switch-list">
                  <li v-for="item in websiteConfig.images" class="switch-item"></li>
                </ol>
              </div>
            </div>
            <div class="banner-info">
              <h3>艺术者「遇见你的品味」</h3>
              <img class="app-code" src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/APP.png">
              <ul class="list">
                <li>专注手绘艺术创作</li>
                <li>打造原创青年艺术家品牌</li>
                <li>跟踪创作纪录·感受作品灵魂</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="con-wrap">
          <div class="w clearfix">
            <div class="left-wrap">
              <div class="mission">
                <h2>你只要负责创作，其他交给我们</h2>
                <ul>
                  <li><i class="icons icon-net"></i>全网内容分发，提供专题、专访，直播宣传， 源源不断获得粉丝藏家。</li>
                  <li><i class="icons icon-record"></i>快捷记录形成创作日志，深度呈现作品灵魂， 让有故事的作品打动欣赏者。</li>
                  <li><i class="icons icon-agency"></i>开放机构入驻，不管是独立艺术家还是已签约艺术家， 都能享受更多合作机会。</li>
                </ul>
              </div>
              <p class="creating">TA们正在创作中...</p>
              <ul class="update-list">
                <li v-for='item in recordInfo.data' class="item">
                  <div class="user-info" @click="navTo('gallery/detail', item.artid)">
                    <a :href="'/gallery/detail/' + item.artist" target="_blank">
                      <img class="avatar" v-lazy="item.faceurl + compress.face" alt="">
                      <span class="nickname">{{item.uname}}</span>
                      <i class="icons icon-artist"></i>
                    </a>
                  </div>
                  <div class="content clearfix">
                  <a :href="'/artwork/update/' + item.artupid" target="_blank">
                    <div class="sum">
                      <h3 class="record-title ellipsis">
                        {{item.imgname}}
                      </h3>
                      <p class="record-story">{{item.summary}}</p>
                    </div>
                    <img class="record-pic" v-lazy="item.imgurl  + compress.S">
                  </a>
                  </div>
                </li>
              </ul>
              <ysz-loadmore v-infinite-scroll="getRecord"></ysz-loadmore>
              <div v-show="bottomLoginShow" id="bottom-login-form" class="bottom-login-form">
                <div class="title">注册/登录艺术者以查看更多</div>
                <div class="btns">
                  <div @click="showReg" class="btn btn-sign">注册</div>
                  <div @click="showLogin" class="btn btn-login">登录</div>
                </div>
              </div>
              <div v-show="bottomDownloadShow" id="bottom-download-form" class="bottom-download-form">
                <div class="title">下载艺术者APP查看更多创作纪录</div>
                <div class="img-wrap">
                  <img src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/APP.png">
                </div>
              </div>
            </div>
            <div class="right-wrap">
              <div class="artist-lunbo">
                <div class="swiper-container ani" id="swiper-container-1">
                  <div class="swiper-wrapper">
                    <div v-for='item in websiteConfig.authors' class="swiper-slide">
                      <div class="inner">
                        <div class="img-wrap">
                          <img :src="item.imgurl">
                          <p><span class="artist-name">{{item.name}} </span>/ 青年艺术家</p>
                        </div>
                        <div class="info">
                          <i class="icons icon-quote1"></i>
                          <p>
                            {{item.statement}}
                          </p>
                          <i class="icons icon-quote2"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="swiper-pagination-1"></div>
                </div>
              </div>
              <div class="news">
                <div class="title-wrap clearfix">
                  <h3>最新动态</h3>
                  <!-- <div class="more">更多>></div> -->
                </div>
                <ul class="list">
                  <li v-for="item in websiteConfig.news" class="clearfix">
                    <a :href="item.url" target="_blank">
                      <p :title="item.title" class="desc ellipsis">{{item.title}}</p><div class="time">{{item.news_date}}</div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="stick-wrap">
                <div class="artist-wrap">
                  <h3 class="artist-title">最近加入的艺术家</h3>
                  <p class="desc">专注手绘艺术创作，打造原创艺术家品牌。</p>
                  <ul class="list clearfix">
                    <li v-for="item in artistList">
                      <a :href="'/gallery/detail/' + item.id" target="_blank">
                        <img v-lazy="item.face + compress.face">
                        <p :title="item.name" class="ellipsis">{{item.name}}</p>
                      </a>
                    </li>
                  </ul>
                  <a class="view-all" href="/gallery/index" target="_blank">查看全部</a>
                  <auth-btn1></auth-btn1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <set-user-box></set-user-box>
      <login-box></login-box>
      <ysz-footer></ysz-footer>
    </div>
    <div class="share-wrap">
      <div class="bdsharebuttonbox bdshare-button-style2-32">
        <a href="javascript:;" id="to-top" class="to-top" title="返回顶部"></a>
      </div>
    </div>
    <script src="/Public/js/lib/vue.min.js"></script>
    <script src="/Public/js/lib/element/index.js"></script>
    <script src="/Public/js/plugin/vue-infinite-scroll.js"></script>
    <script src="/Public/js/plugin/vue-lazyload.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="/Public/js/plugin/swiper.jquery.min.js"></script>
    <script src="/Public/js/common.js?v=1.2.0"></script>
    <script src="/Public/js/index/index2.js?v=1.1.1"></script>
  </body>
</html>