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
              <h3 class="title-info">艺术家邀请制</h3>
              <form class="yszform">
                <div class="invite-wrap form">
                  <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="457px" class="demo-ruleForm">
                    <el-form-item v-if="!hasCode" label="邀请码" prop="inviteCode">
                      <el-input class="w-350" v-model="ruleForm.inviteCode" placeholder="已入驻艺术家的邀请码" :maxlength="11"></el-input>
                    </el-form-item>
                    <div class="tips">
                      <h4>邀请码如何获取？</h4>
                      <p>每一位成功入驻艺术者平台的艺术家都有邀请码赶紧找到邀请你入 驻的艺术家，让TA提供邀请码吧~ </p>
                    </div>
                    <div class="btn-group next">
                      <p class="error-text">@{{errorTip}}</p>
                      <el-button class="btn-24" type="primary" @click="submitForm('ruleForm')">@{{btnText}}</el-button>
                    </div>
                  </el-form>
                </div>
              </form>
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
  <script src="/js/auth/invite.js?v=2.0.5"></script>
</html>