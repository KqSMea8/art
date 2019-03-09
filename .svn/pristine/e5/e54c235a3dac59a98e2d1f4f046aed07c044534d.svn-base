
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>艺术家免费认证</title>
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
            <h2 class="title">艺术家免费认证</h2>
            <div class="stage-wrap">
              <ul class="step-nav clearfix">
                <li class="active">
                  <span>个人信息</span><br>
                  <i class="dot"></i>
                </li>
                <li class="active">
                  <span>认证图片</span><br>
                  <i class="dot dot2"></i>
                </li>
              </ul>
              <p class="info"><i class="icons icon-info"></i>以下信息必须真实可信</p>
              <p class="pic-tip">可上传荣誉证书，画廊照片，参展照片，艺术家与创作作品的合影，不少于3张。</p>

              <div class="second-wrap form">
                <div class="item clearfix">
                  <div class="tit"><label for="certImageIds">图片上传</label></div>
                  <div class="con conhtdiv">
                    <div class="box" id="htdiv">
                      <div class="placehold"></div>
                      <el-upload
                        class="up-imglist"
                        :action="ossAction"
                        :multiple="true"
                        list-type="picture-card"
                        :file-list="list.imageList"
                        :before-upload = "beforeupload"
                        :on-remove="handleCertRemove"
                        :http-request="uploadImg">
                        <input type="button" class="btn-s" value="上传">
                        <div slot="tip" class="el-upload__tip">建议像素:1024*1024</div>
                      </el-upload>

                      <!-- <input id="certImageIds" name="certImageIds" type="button" class="btn-s" value="上传">
                      <span class="mark">个人荣誉证书或奖杯图片</span> -->
                    </div>
                    <div class="tip"><div class="Validform_checktip"></div></div>
                  </div>
                </div>
                <p v-if="imgtrip" class="pic-tip">请上传艺术家与机构的合同（必须）</p>
                <div v-if="htcomp" class="item clearfix">
                  <div class="item clearfix">
                    <div class="tit"><label for="certImageIds">合同上传</label></div>
                    <div class="con conhtdiv">
                      <div class="box" id="htdiv">
                        <div class="placehold"></div>
                        <el-upload
                          class="up-imglist"
                          :action="ossAction"
                          :multiple="true"
                          list-type="picture-card"
                          :file-list="htimg.list"
                          :before-upload = "beforeupload1"
                          :on-remove="handleCertRemove1"
                          :http-request="uploadImg1">
                          <input type="button" class="btn-s" value="上传">
                        </el-upload>
                      </div>
                      <div class="tip"><div class="Validform_checktip"></div></div>
                    </div>
                  </div>
                </div>
                <div class="btn-group next-2">
                  <p v-cloak class="error-text">@{{errorTip}}</p>
                  <input @click="applyArtist" class="btn btn-24" type="button" :value="btnText">
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
  <script src="/js/auth/second.js?v=2.1.5"></script>
</html>
