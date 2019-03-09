
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>策展人认证</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/auth.css?v=2.0.0" rel="stylesheet">
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
          <div class="main-wrap mb-72" id="auth">
            <h2 class="title">策展人认证</h2>
            <div class="stage-wrap">
              <ul class="step-nav clearfix">
                <li class="active">
                  <span class="curator-info">策展人信息</span><br>
                  <i class="dot"></i>
                </li>
                <li class="active">
                  <span>认证图片</span><br>
                  <i class="dot dot2"></i>
                </li>
              </ul>
              <p class="info"><i class="icons icon-info"></i>以下信息必须真实可信</p>
              <div class="second-wrap form">
                <div class="item clearfix">
                  <div class="tit"><label for="certImageIds">身份证照片</label></div>
                  <div class="con">
                    <div class="box" >
                      <el-upload
                        class="avatar-uploader"
                        action="/public/upload"
                        :headers="{'X-CSRF-TOKEN': '{{csrf_token()}}'}"
                        :show-file-list="false"
                        :before-upload="beforeIdCardUpload"
                        :on-success="handleIdCardSuccess">
                        <input type="button" class="btn-s" value="上传">
                        <div slot="tip" class="el-upload__tip">管理员手持身份证照片</div>
                        <ul v-if="list.idCardList.length > 0" class="img-list clearfix">
                          <li class="img-item"><img :src="list.idCardList[0].url"></li>
                        </ul>
                        <div class="el-loading-mask3" v-show="uploadloading"><div class="el-loading-spinner"><svg viewBox="25 25 50 50" class="circular"><circle cx="50" cy="50" r="20" fill="none" class="path"></circle></svg><!----></div></div>
                      </el-upload>
                      <div class="img-demo">
                        <p>查看示例图</p>
                        <img src="/image/auth/idcard.png">
                      </div>
                    </div>
                    <div class="tip"><div class="Validform_checktip"></div></div>
                  </div>
                </div>
                <div class="btn-group next-2">
                  <p v-cloak class="error-text">@{{errorTip}}</p>
                  <input @click="applyCurator" class="btn btn-24" type="button" :value="btnText">
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="preview">
          <div class="w clearfix">
            <input class="btn-s fr" type="button" value="预览您的画廊封面">
          </div>
        </div> -->
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
  <script src="/js/authcurator/second.js?v=1.2.1"></script>
</html>