<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>上传作品-添加新创作花絮</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/upload/update.css?v=2.0.0" rel="stylesheet">
  </head>
  <body >
    <div id="app" v-cloak>
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
          <div class="main-wrap mb-60 clearfix">
            <h2 class="title"><a href="/upload/manage">作品管理</a><span>/<span class="now">添加新创作花絮</span></span></h2>
            <div class="form-wrap1 form-wrap2">
              <el-form ref="form1" :model="form1" :rules="rules1"  label-width="227px">
                <el-form-item label="选择作品" prop="artworkId">
                  <el-select class="w-350" v-model="form1.artworkId" filterable placeholder="选择你要添加花絮的作品">
                    <el-option
                    v-for="item in prodItems"
                    :label="item.name"
                    :value="item.id"
                    >
                    </el-option>
                  </el-select>
                  <a href="/upload/addartwork" class="a-link">创建新作品</a>
                </el-form-item>
                <el-form-item class='mt82'>
                  <el-button type="primary" @click="submitForm1('form1')" class="btn-24 ml30">确定</el-button>
                </el-form-item>
              </el-form>
            </div>
          </div>
        </div>
      </div>
    <!-- main-end -->
    <ysz-footer2></ysz-footer2>
  </div>
</body>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script src="/js/service/agent.js?v=2.1.6"></script>
<script src="/js/lib/vue.min.js"></script>
<script src="/js/lib/element/index.js"></script>
<script src="/js/common.js?v=3.9.2"></script>
<script src="/js/upload/addupdate.js?v=2.0.0"></script>
</html>