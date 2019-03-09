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
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/promote.css?v=2.0.0" rel="stylesheet">
  </head>
  <body>
    <div v-cloak id="app">
      <div v-loading.fullscreen.lock="fullscreenLoading"></div>
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
            <div>
              <ysz-upload-nav></ysz-upload-nav>
              <div class="con-wrap">
                <h2 class="tit">申请APP封面推广</h2>
                <div class="sum">
                  <div v-if="promoteInfo.status == '3'" class="applyed">
                    <div class="fl">
                      <h3>APP封面推广</h3>
                      <p><i class="icons icon-applyed"></i>已申请</p>
                    </div>
                    <div class="fr">
                      <input id="btn-edit" @click="rePromote" class="btn btn-166" type="button" :value="reBtnText">
                      <input id="btn-stop" @click="showStop" class="btn btn-b btn-166" type="button" value="停止推广">
                    </div>
                  </div>
                  <div v-if="promoteInfo.status == '1'" class="applyed">
                    <div class="fl">
                      <h3>APP封面推广</h3>
                      <p><i class="icons icon-applyed"></i>已申请</p>
                    </div>
                    <div class="fr">
                      <input class="btn btn-grey btn-166" type="button" value="审核中..." disabled>
                    </div>
                  </div>
                  <div v-if="promoteInfo.status == '2'" class="applyed">
                    <div class="fl">
                      <h3>APP封面推广</h3>
                      <p><i class="icons icon-applyed"></i>已申请</p>
                    </div>
                    <div class="fr">
                      <input id="btn-edit" @click="rePromote" class="btn btn-166" type="button" :value="reBtnText">
                      <input class="btn btn-grey btn-166" type="button" value="审核失败" disabled>
                    </div>
                  </div>
                  <div v-if="!applyed || promoteInfo.status == '4'" class="unapply">
                    <h3>APP封面推广</h3>
                    <p><span>未申请</span></p>
                    <input id="btn-edit" @click="gotoPromote" class="btn btn-250" type="button" :value="applyBtnText">
                  </div>
                </div>
                <div class="detail">
                  <h3>推广形态</h3>
                  <dl>
                    <dt>核心优势</dt>
                    <dd>1.海量覆盖，艺术者每个用户启动一次APP，就是一次宣传</dd>
                    <dd>2.随时随地，更新编辑宣传内容</dd>
                  </dl>
                  <div class="show fl">
                    <img class="app" src="https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png?x-oss-process=image/resize,m_fixed,w_54" alt="">
                    <p>艺术者APP启动页封面</p>
                    <div class="cover">
                      <img v-if="applyed && promoteInfo.status == '3'" :src="promoteInfo.one + '?x-oss-process=image/resize,w_213'" alt="">
                      <img v-else :src="template.btnUrl" alt="">
                    </div>
                  </div>
                  <div class="intro fr">
                    <ul>
                      <li>1.填写完内容，提交平台审核；</li>
                      <li>2.审核通过后，可下载图片个人宣传。</li>
                    </ul>
                    <img v-if="applyed && promoteInfo.status == '3'" :src="promoteInfo.three + '?x-oss-process=image/resize,w_255'">
                    <a v-if="applyed && promoteInfo.status == '3'" id="download-url" :href="promoteInfo.three" :download="myInfo.name + '的艺术画廊.png'" style="display: none;"></a>
                    <img v-else :src="template.codeUrl">
                    <div v-if="applyed && promoteInfo.status == '3'" class="btn-group">
                      <input id="btn-download" @click="downloadPic" class="btn btn-166" type="button" value="下载原图">
                    </div>
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
          <div v-show="stopIsShow" class="thirdLayerIn anim-scale message-box" id="remind">
            <h2>温馨提示<em @click="hideBox" title="关闭" >×</em></h2>
            <div class="content">
              <p class="aboutContent">是否真的停止推广？</p>
            </div>
            <div class="btn-group">
              <input @click="stopPromote" type="button" :value="stopBtnText" class="btn">
              <input @click="hideBox" type="button" value="否" class="btn">
            </div>
          </div>
          <div v-show="remarkIsShow" class="thirdLayerIn anim-scale message-box" id="remind">
            <h2>温馨提示<em @click="hideBox" title="关闭" >×</em></h2>
            <div class="content">
              <p class="aboutContent">至少需要上传一幅作品才能申请APP封面推广哦~</p>
            </div>
            <div class="btn-group">
              <input @click="hideBox" type="button" value="我知道了" class="btn">
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
  <script src="/js/promote/index.js?v=1.2.1"></script>
</html>