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
    <title>画廊</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.1">
    <link rel="stylesheet" type="text/css" href="/Public/js/plugins/dropload.css?v=0.0.1">
    <link rel="stylesheet" type="text/css" href="/Public/css/gallery.css?v=1.1.1">
  </head>
  <body>
    <div id="gallery">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <!-- <div v-cloak id="header">
        <div class="gallery-nav" :class="{ active: isActive }">
          <div class="title" @click="toggle">
            <span class="all">全部</span>
            <i class="icon icon-arrow"></i>
          </div>
          <div class="gallery-tab">
            <nav class="gallery-tab-list">
              <a class="gallery-tab-item" :class="{ current: current == 0 }" @click="choosePrinter(0)">
                <i class="icons icon-printer-man"></i>
                <span class="gallery-tab-label">男画家</span>
              </a>
              <a class="gallery-tab-item" :class="{ current: current == 1 }" @click="choosePrinter(1)">
                <i class="icons icon-printer"></i>
                <span class="gallery-tab-label">看全部</span>
              </a>
              <a class="gallery-tab-item" :class="{ current: current == 2 }" @click="choosePrinter(2)">
                <i class="icons icon-printer-woman"></i>
                <span class="gallery-tab-label">女画家</span>
              </a>
            </nav>
            <div class="gallery-tab-content">
              <a class="gallery-tab-content-item" v-for="(item, index) in curCateList" @click=chooseCate(item.category)>
                <span class="gallery-tab-cate">@{{item.categoryName}}</span>
                <span class="gallery-tab-num">@{{item.total}}</span>
              </a>
            </div>
          </div>
        </div>
      </div> -->
      <div v-cloak id="main" style="margin-top: 0;">
        <ol class="gallery-list">
          <li class="gallery-item"  data-id="printer-id" v-for="(galleryItem, index) in galleryList" :key="galleryItem.id">
            <a :href="'/gallery/detail/' + galleryItem.id">
              <div class="wrap-info">
                <div class="userinfo">
                  <img class="userinfo-avatar" v-lazy="galleryItem.faceUrl">
                  <div class="userinfo-detail">
                    <p class="userinfo-nickname">
                      <span>@{{galleryItem.name}}</span>
                      <i :class="['icons', 'icon-sex', 'icon-sex-' + galleryItem.gender]"></i>
                    </p>
                    <p class="userinfo-flag">@{{galleryItem.category_names}}</p>
                  </div>
                </div>
                <div @click.prevent="toggleFollow(galleryItem.id, index, '感谢您的关注，立即下载APP查看更多作品吧~')" :class="['follow', galleryItem.follow == 'Y'? 'followed' : '']">
                  <i class="icons icon-follow"></i>
                  <span class="follow-number">@{{galleryItem.follower_total}}</span>
                </div>
              </div>
              <img class="best-print" v-lazy="galleryItem.coverUrl">
              <ol class="print-list">
                <li class="print-item" v-for="artItem in galleryItem.otherArt">
                  <img v-lazy="artItem">
                </li>
                <div class="print-list-info">
                  <span class="print-list-num">@{{galleryItem.total_art}}</span>
                  <i class="icons icon-more"></i>
                </div>
              </ol>
            </a>
          </li>
        </ol>
      </div>

      <!-- 下载APP弹窗 -->
      <download-box></download-box>
      <footer-bar></footer-bar>
    </div>

    <!-- <div id="tab-bar">
      <nav class="tab-bar-list">
        <a class="tab-bar-item" href="/index/recommend">
          <i class="icons icon-recommend"></i>
          <span class="tab-label">推荐</span>
        </a>
        <a class="tab-bar-item active" href="/gallery/index">
          <i class="icons icon-gallery"></i>
          <span class="tab-label">画廊</span>
        </a>
        <a class="tab-bar-item" @click="showDownloadBox()" href="/user/index">
          <i class="icons icon-user"></i>
          <span class="tab-label">我</span>
        </a>
      </nav>
    </div> -->

    <script type="text/javascript" src="/Public/js/lib/vue.min.js"></script>
    <script type="text/javascript" src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="/Public/js/plugins/fastclick.js"></script>
    <script type="text/javascript" src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script type="text/javascript" src="/Public/js/plugins/vue-lazyload.js"></script>
    <script type="text/javascript" src="/Public/js/plugins/dropload.min.js"></script>
    <script type="text/javascript" src="/Public/js/service/agent.js?v=2.0.1"></script>
    <script type="text/javascript" src="/Public/js/util.js?v=2.3.1"></script>
    <script type="text/javascript" src="/Public/js/gallery/gallery.js?v=2.3.0"></script>
  </body>
</html>
