<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>机构认证</title>
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
            <h2 class="title">机构认证</h2>
            <div class="stage-wrap">
              <ul class="step-nav clearfix">
                <li class="active">
                  <span>机构信息</span><br>
                  <i class="dot"></i>
                </li>
                <li>
                  <span>认证图片</span><br>
                  <i class="dot dot2"></i>
                </li>
              </ul>
              <p class="info"><i class="icons icon-info"></i>以下信息必须真实可信</p>
              <div class="first-wrap form">
                  <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="457px" class="demo-ruleForm">
                    <el-form-item label="机构类型" prop="type">
                      <el-select class="w-350" v-model="ruleForm.type" placeholder="请选择机构类型">
                        <el-option 
                        v-for="item in types"
                        :label="item.label" 
                        :value="item.value"></el-option>
                      </el-select>
                    </el-form-item>
                    <el-form-item label="机构全名" prop="name">
                      <el-input class="w-350" v-model="ruleForm.name" placeholder="请输入机构全名"></el-input>
                    </el-form-item>
                    <el-form-item label="管理员姓名" prop="adminName">
                      <el-input class="w-350" v-model="ruleForm.adminName" placeholder="请输入管理员真实姓名"></el-input>
                    </el-form-item>
                    <el-form-item label="手机号码" prop="adminPhone">
                      <el-input class="w-350" v-model="ruleForm.adminPhone" placeholder="请输入管理员手机号码" :maxlength="11"></el-input>
                    </el-form-item>
                    <el-form-item label="常用邮箱" prop="adminEmail">
                      <el-input class="w-350" v-model="ruleForm.adminEmail" placeholder="请输入常用邮箱"></el-input>
                    </el-form-item>
                    
                    <div class="btn-group next">
                      <p class="error-text">@{{errorTip}}</p>
                      <el-button class="btn-24" type="primary" @click="submitForm('ruleForm')">@{{btnText}}</el-button>
                    </div>
                  </el-form>
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
  <script src="/js/plugin/area-json.js"></script>
  <script src="/js/autharts/first.js?v=1.2.1"></script>
</html>