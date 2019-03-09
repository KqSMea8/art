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
    <link rel="stylesheet" type="text/css" href="/laravel-ueditor/themes/iframe.css?v=0.0.1">
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/topic.css?v=1.2.1" rel="stylesheet">
    <style type="text/css">
      .el-loading-mask {
        /*margin-top: 42px;*/
        height: 200px !important;
        background-color: #fff;
        opacity: 1;
      }
    </style>
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
        <div class="w">
          <div class="main-wrap mb-60 clearfix">
            <div>
              <ysz-upload-nav></ysz-upload-nav>
              <div class="con-wrap">
                <h2 class="tit">申请参加艺术专题</h2>
                <el-tabs v-model="activeName" @tab-click="handleTabClick">
                  <el-tab-pane label="专题推荐" name="first">
                    <ul v-loading.body="topicLoading" class="recom-list">
                      <li v-cloak v-for="subjectItem in subjectList" :class="[subjectItem.active ? 'active' : '', 'recom-item']"  @click="addActive(subjectItem)">
                        <div class="recom-detail clearfix">
                          <div class="fl">
                            <img :src="subjectItem.cover + '?x-oss-process=image/resize,m_fixed,h_72,w_72'">
                            <h3>@{{subjectItem.sub_name}}</h3>
                            <p>@{{subjectItem.sub_title}}</p>
                          </div>
                          <div class="fr">
                            <div v-if="Date.parse(new Date())/1000 < subjectItem.end_time "> <!-- 专题未结束 -->
                              <input v-if="subjectItem.applyStatus == '0'" @click.stop="gotoApply(subjectItem)" class="btn btn-166" type="button" value="申请">
                              <input v-if="subjectItem.applyStatus == '1'" class="disabled btn btn-166" type="button" value="申请中" disabled="disabled">
                              <div v-if="subjectItem.applyStatus == '-1'">
                                <span class="apply-p3">申请失败</span>
                                <input @click.stop="gotoApply(subjectItem)" class="btn btn-166" type="button" value="再次申请">
                              </div>
                              <p class="apply-2" v-if="subjectItem.applyStatus == '2'">专题推荐中</p>
                            </div>
                            <div v-else> <!-- 专题已结束 -->
                              <p class="apply-2">专题推荐已结束</p>
                            </div>
                            <div class="end-date">@{{subjectItem.end_time | timeFormat}}结束</div>
                          </div>
                        </div>
                        <div class="recom-desc">
                          <h4>专题推荐语：</h4>
                          <!-- <p>@{{subjectItem.description}}</p> -->
                          <p class="view" v-html="subjectItem.description"></p>
                        </div>
                      </li>
                    </ul>
                    <div class="upload-page el-pagination" v-if='topicPageInfo.max > 1'>
                     <button type="button"  :class="[ topicPageInfo.cur == 1 ? 'disabled' : '','btn-prev']" @click="topicPagePrev()" ><</button>
                     <span class="upload-num" >@{{topicPageInfo.cur}}/@{{topicPageInfo.max}}</span>
                     <button type="button" :class="[ topicPageInfo.cur == topicPageInfo.max ? 'disabled' : '','btn-next']" @click="topicPageNext()" >></button>
                     <span class="el-pagination__jump "><input type="number" min="1" number="true" v-model='topicPageInfo.input' class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="topicGotoPage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>
                   </div>
                  </el-tab-pane>
                  <el-tab-pane label="我的申请" name="second">
                    <ul v-loading.body="myLoading" class="recom-list">
                      <li :class="[myItem.active ? 'active' : '', 'recom-item']" v-for="myItem in myList" @click="addActive(myItem)">
                        <div class="my-detail recom-detail clearfix">
                          <div class="fl">
                            <img :src="myItem.cover + '?x-oss-process=image/resize,m_fixed,h_72,w_72'">
                            <h3>@{{myItem.sub_name}}</h3>
                            <p>@{{myItem.sub_title}}</p>
                          </div>
                          <div class="fr">
                            <div v-if="myItem.status == '2'">
                              <p class="p1">我的作品</p>
                              <h3>@{{myItem.name}}</h3>
                              <p class="p2">
                                <span>@{{myItem.size}}</span>@{{myItem.category_name}}
                              </p>
                            </div>
                            <div v-else> <!-- 专题未结束 -->
                              <input v-if="myItem.status == '0'" @click.stop="gotoApply(myItem)" class="btn btn-166" type="button" value="申请">
                              <input v-if="myItem.status == '1'" class="disabled btn btn-166" type="button" value="申请中" disabled="disabled">
                              <div v-if="myItem.status == '-1'">
                                <span class="apply-p3">申请失败</span>
                                <input @click.stop="gotoApply(myItem)" class="btn btn-166" type="button" value="再次申请">
                              </div>
                              <div class="end-date">@{{myItem.end_time | timeFormat}}结束</div>
                            </div>

                          </div>
                        </div>
                        <div class="recom-desc">
                          <h4>专题推荐语：</h4>
                          <!-- <p>@{{myItem.description}}</p> -->
                          <p class="view" v-html="myItem.description"></p>
                        </div>
                      </li>
                    </ul>
                    <div class="upload-page el-pagination" v-if='myPageInfo.max > 1'>
                     <button type="button"  :class="[ myPageInfo.cur == 1 ? 'disabled' : '','btn-prev']" @click="myPagePrev()" ><</button>
                     <span class="upload-num" >@{{myPageInfo.cur}}/@{{myPageInfo.max}}</span>
                     <button type="button" :class="[ myPageInfo.cur == myPageInfo.max ? 'disabled' : '','btn-next']" @click="myPageNext()" >></button>
                     <span class="el-pagination__jump "><input type="number" min="1" number="true" v-model='myPageInfo.input' class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="myGotoPage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>
                   </div>
                  </el-tab-pane>
                </el-tabs>
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div v-show="remarkIsShow" class="thirdLayerIn anim-scale message-box" id="remind">
            <h2>温馨提示<em @click="hideBox" title="关闭" >×</em></h2>
            <div class="content">
              <p class="aboutContent">至少需要上传一幅作品才能申请专题推广哦~</p>
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
  <script src="/js/topic/index.js?v=1.2.2"></script>
</html>