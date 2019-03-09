<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>推广-艺术专题</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/topic.css?v=2.0.0" rel="stylesheet">
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
          <div v-cloak class="main-wrap mb-60 clearfix">
            <div class="apply">
              <div class="second clearfix">
                <h2 class="title"><a href="/topic/index">申请艺术专题</a>-<span>@{{subjectInfo.sub_name}}</span></h2>
                <div class="temp-wrap">
                  <div class="template">
                    <div v-cloak class="inner">
                      <img class="temp-url" src="/image/promote/topic_blank.png">
                      <div class="topic-apply">
                        <h3>@{{subjectInfo.sub_name}}</h3>
                        <div class="apply-info">
                          <img class="cover" :src="selectArt.coverUrl">
                          <div class="infos clearfix">
                            <div class="art-info">
                              <h4>《@{{selectArt.name}}》</h4>
                              <p>@{{selectArt.category_name}}@{{selectArt.size}}</p>
                            </div>
                            <div class="artist-info">
                              <img :src="myInfo.face">
                              <p>@{{myInfo.name}}</p>
                            </div> 
                          </div>
                          <p class="desc">
                            @{{ruleForm.description}}
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form">
                  <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="85px">
                    <el-form-item label="选择作品" prop="artid">
                      <el-select class="w-350" v-model="ruleForm.artid" placeholder="请选择参加专题的作品" @change="handleChange">
                        <el-option 
                        v-for="item in artworkList"
                        :label="item.name" 
                        :value="item.id"></el-option>
                      </el-select>
                    </el-form-item>
                    <el-form-item label="作品寄语" prop="description">
                      <el-input class="w-350" v-model="ruleForm.description" placeholder="描绘作品与专题之间的故事~"></el-input>
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
      </div>
      <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div class="thirdLayerIn anim-scale message-box" id="remind">
            <h2>温馨提示<em @click="hideBox" title="关闭" >×</em></h2>
            <div class="content">
              <p class="aboutContent">你的专题申请已提交，艺术者将在1-2个工作日审核~</p>
            </div>
            <div class="btn-group">
              <input @click="goToList" type="button" value="我知道了" class="btn">
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
  <script src="/js/topic/apply.js?v=2.0.0"></script>
</html>