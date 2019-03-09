<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>申请认证</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/authindex.css?v=2.0.0" rel="stylesheet">
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
      <div id="main">
        <div class="w clearfix">
          <div class="main-wrap mb-60" id="reg">
            <h2 class="title">申请认证</h2>
            <div class="auth-wrap">
              <ul class="list clearfix">
                <li v-for="item in authList" @click="goToAuth(item.type, item.status, item.memo, item.link0, item.link1)" :class="[item.status == '2'? 'no-click' : '']">
                  <div class="auth-info">
                    <i v-if="item.status == '2'" class="icons icon-pass"></i>
                    <div :class="['icons', 'icon-auth'+ item.type]"></div>
                    <h3>@{{item.title}}</h3>
                  </div>
                  <p :class="[item.status== '-1'? 'warn': '' ,'remark']">@{{statusRemark[item.status]}}</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div v-cloak v-show="boxIsShow" class="layerbox">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <!-- 提醒弹窗 -->
          <div v-show="remarkIsShow" class="thirdLayerIn anim-scale remark-box">
            <h3 class="title">温馨提示 <em @click="hideBox" title="关闭" >×</em></h3>
            <div class="content" v-html='remarkInfo.content'>
            </div>
            <div v-if="remarkInfo.status== '-1'" class="btn-group">
              <div @click="hideBox" class="btn-s w110">确 定</div>
              <a :href="remarkInfo.link" class="btn-s primary w110">修改信息</a>
            </div>
            <div v-if="remarkInfo.status== '1'" class="btn-group">
              <div @click="hideBox" class="btn-s primary w220">我知道啦</div>
            </div>
          </div>
          <!-- 提醒弹窗 end -->
        </div>
      </div>
      <ysz-footer2></ysz-footer2>
    </div>
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/js/service/agent.js?v=2.1.6"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <script src="/js/auth/index.js?v=1.2.1"></script>
</html>