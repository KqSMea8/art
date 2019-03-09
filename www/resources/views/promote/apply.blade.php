<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>推广-APP封面</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/promote.css?v=2.0.0" rel="stylesheet">
  </head>
  <body>
    <div id="app">
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
        <div class="w">
          <div class="main-wrap mb-60 clearfix">
            <div class="apply">
              <div class="second clearfix">
                <h2 class="title"><a href="/promote/index">APP封面推广</a>-<span>填写个人信息</span></h2>
                <div class="temp-wrap">
                  <div class="template">
                    <div v-cloak class="inner">
                      <img class="temp-url" :src="templateInfo.curUrl">
                      <img  :src="uploadImg + '?x-oss-process=image/resize,w_750,limit_0,image/format,jpg'">
                      <div class="info">
                        <h3 class="name"><span>@{{userInfo.name}}</span></h3>
                        <p class="tags">@{{userInfo.category}}</p>
                        <p v-if="applyInfo.desc" class="desc">“@{{applyInfo.desc}}”</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form">
                  <div class="item clearfix">
                    <div class="tit">上传头像</div>
                    <div class="con">
                      <div class="box" >
                        <el-upload
                          class="avatar-uploader"
                          action="/public/upload"
                          :headers="{'X-CSRF-TOKEN': '{{csrf_token()}}'}"
                          :show-file-list="false"
                          :before-upload = "beforeAvatarUpload"
                          :on-success="handleAvatarSuccess">
                          <input type="button" class="btn-s" value="上传">
                          <ul v-if="uploadImg" class="img-list clearfix">
                            <li class="img-item"><img :src="uploadImg + '?x-oss-process=image/resize,w_750,limit_0,image/format,jpg'">
                          </ul>
                        </el-upload>
                      </div>
                    </div>
                  </div>
                  <div class="item clearfix">
                    <div class="tit">个人名句</div>
                    <div class="con">
                      <div class="box" >
                        <input v-model="applyInfo.desc" class="input" type="text" placeholder="个人对艺术的观点（20字以内）" maxlength="20">
                      </div>
                    </div>
                  </div>
                  <div class="btn-group">
                    <p v-cloak class="error-text">@{{errorTip}}</p>
                    <input @click="submitApply" class="btn btn-24" type="button" :value="btnText">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div class="thirdLayerIn anim-scale message-box" id="remind">
            <h2>温馨提示<em @click="hideBox" title="关闭" >×</em></h2>
            <div class="content">
              <p class="aboutContent">你的APP启动页推广申请已提交，艺术者将在1-2个工作日审核~</p>
            </div>
            <div class="btn-group">
              <!-- <input @click="stopPromote" type="button" :value="stopBtnText" class="btn"> -->
              <input @click="gotoPromoteIndex" type="button" value="我知道了" class="btn">
            </div>
          </div>
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
  <script src="/js/promote/apply.js?v=1.2.2"></script>
</html>