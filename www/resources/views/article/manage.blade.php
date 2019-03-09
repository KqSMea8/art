<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>艺术号管理</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/upload/manage.css?v=2.0.0" rel="stylesheet">
    <script type="text/javascript">
      // var targetProtocol = "https:";
      // if (window.location.protocol != targetProtocol) {
      //   window.location.href = targetProtocol + window.location.href.substring(window.location.protocol.length);
      // }
    </script>
  </head>
  <body >
    <div id="manage" v-cloak>
      <!-- header-begin -->
      <header class="ysz-header">
        <div class="y-header">
          <div class="w clearfix">
            <a href="/index">
              <h1 class="y-head fl">
              <img class="logo" src="/image/logo.png" alt="logo">
              <span class="y-title">创作平台</span>
              </h1>
            </a>
            <div class="user fr">
              <div class="info">
                <img :src="myInfo.face">
                <span>@{{myInfo.name}}</span>
                <change-user-btn></change-user-btn>
                <a href="/passport/logout">退出</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <!-- header-end -->
      <!-- main-begin -->
      <div id="main">
        <div class="w">
          <div class="main-wrap mb-72 clearfix" id="upload">
            <ysz-upload-nav></ysz-upload-nav>
            <div class="upload-right" >
              <h2 class="upload-rH">文章（@{{prodCount}}）</h2>
              <el-button type="primary" @click="gotoAdd" class="el-button btn-24 el-button--primary upload-button">+ 发表新文章</el-button>
              <ul class="upload-rCon clearfix" v-loading.body="loading" style="min-height: 300px; height: 100%">
                <li v-for="item in prodItems">
                  <a :href="item.isEdit == 'Y'?'/article/edit?id=' + item.id: 'javascript:void(0);'">
                    <div class="upload-rImg" :style="{ backgroundImage: 'url(' + item.cover + ')'}">
                      <div v-if="item.type == '2'" class="myself"><i class="icons icon-myself"></i>草稿</div>
                      <h2>
                        <div :title="item.title">@{{ item.title }} </div>
                      </h2>
                      <div class="upload-rImgmask"></div>
                  </div>
                  <!-- <p class="upload-rTxt">@{{ item.story }}</p> -->
                  <div class="upload-rDate">@{{ item.publish_time }}</div>
                  <a v-if="item.isEdit == 'Y'" :href="'/article/edit?id=' + item.id " class="upload-rEdit icons icon-edit"></a>
                </a>
              </li>
            </ul>
            <div class="upload-page el-pagination" v-if='totalpage > 1'>
              <button type="button"  :class="[ curpage == 1 ? 'disabled' : '','btn-prev']" @click="pagePrev()" ><</button>
              <span class="upload-num" >@{{curpage}}/@{{totalpage}}</span>
              <button type="button" :class="[ curpage == totalpage ? 'disabled' : '','btn-next']" @click="pageNext()" >></button>
              <span class="el-pagination__jump "><input type="number" min="1" number="true" v-model='inputpage' class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="gotopage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- main-end -->
    <ysz-footer2></ysz-footer2>
  </div>
</body>
<script src="/js/lib/vue.min.js"></script>
<script src="/js/lib/element/index.js"></script>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script src="/js/service/agent.js?v=2.1.0"></script>
<script src="/js/common.js?v=3.9.2"></script>
<script src="/js/article/manage.js?v=2.0.0"></script>
</html>