<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的邀请</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/invite.css?v=2.0.0" rel="stylesheet">
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
          <div class="main-wrap mb-72 clearfix">
            <ysz-upload-nav></ysz-upload-nav>
            <div class="con-wrap">
              <h2 class="tit">我的邀请</h2>
              <div class="sum">
                <div class="info">
                  <h3>邀请制是什么？</h3>
                  <p>恭喜您已获得艺术者平台邀请资格，您可以邀请好友入驻，申请认证艺术家并填写你的邀请码，提交审核后，工作人员会尽快处理。推荐成功后，将有更多艺术家特权体验权，尽请期待。</p>
                  <h3>邀请者如何使用邀请码？</h3>
                  <p>1.你想邀请的艺术家需要注册并登录艺术者平台；</p>
                  <p>2.个人中心点击认证艺术家，并填写邀请码。</p>
                </div>
              </div>
              <div class="detail">
                <div class="invite-code">
                  <p>邀请码<span>（24小时更换一次）</span></p>
                  <div v-if="myInfo.inviteCode" class="code">@{{myInfo.inviteCode}}</div>
                </div>
                <!-- <dl class="info">
                  <dt>邀请者如何使用邀请码</dt>
                  <dd>1.你想邀请的艺术家需要注册并登录艺术者平台。</dd>
                  <dd>2.个人中心点击认证艺术家，并填写邀请码</dd>
                </dl> -->
              </div>
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
  <script src="/js/invite/index.js?v=2.0.0"></script>
</html>