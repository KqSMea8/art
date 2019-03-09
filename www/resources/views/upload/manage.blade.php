<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>作品管理</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/upload/manage.css?v=2.0.0" rel="stylesheet">
  </head>
  <body >
    <div id="manage" v-cloak>
      <!-- header-begin -->
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
      <!-- header-end -->
      <!-- main-begin -->
      <div id="main">
        <div class="w">
          <div class="main-wrap mb-72 clearfix" id="upload">
            <ysz-upload-nav></ysz-upload-nav>
            <div class="upload-right" >
              <el-button v-if="activeName == 'first'" type="primary" @click="gotoAdd" class="el-button el-button--primary upload-button addbtn">+ 添加新作品</el-button>
              <!-- <el-button v-else type="primary" @click="addSeries" class="el-button el-button--primary upload-button addbtn">+ 添加新系列</el-button> -->
              <el-tabs v-model="activeName" class="listtabs" @tab-click="getlistTab">
                <el-tab-pane :label="'作品（'+prodCount+'）'" name="first" class="">
                  <!-- <h2 class="upload-rH">作品（@{{prodCount}}）</h2> -->
                  <ul class="upload-rCon clearfix" v-loading.body="loading" customClass="loadclass">
                    <li v-for="(item,index) in prodItems">
                      <a :href="item.isEdit == 'Y'?'/upload/record?id=' + item.artistId: 'javascript:void(0);'">
                        <div class="upload-rImg" :style="{ backgroundImage: 'url(' + item.coverUrl + ')'}">
                          <div v-if="item.state == '2'" class="myself"><i class="icons icon-myself"></i>仅自己可见</div>
                          <h2>
                            <div>@{{ item.name }} </div>
                            <div style="color: red;right: 10px;position: absolute;" v-if="item.updateTimes==0">未完成</div>
                            <!-- <span :class="['upload-rImgStatu', 'icons', item.updateTimes < 10 ? 'icon-status'+ item.updateTimes : 'icon-status'+'more' , item.is_finished == 'Y'? 'finished' : '']"></span> -->
                          </h2>
                          <div class="upload-rImgmask"></div>
                      </div>
                      </a>
                      <!-- <p class="upload-rTxt">@{{ item.story }}</p> -->
                      <div class="upload-rDate">@{{ item.last_update_time }}</div>

                      <div v-if="item.state==1" class="eyesopen" @click="geteyesInfo(item.artistId,item.state)"></div>
                      <div v-else class="eyesclose" @click="geteyesInfo(item.artistId,item.state)"></div>
                      <div class="toping" @click="totoping(item,index)"></div>
                      <a v-if="item.isEdit == 'Y'" :href="'/upload/record?id=' + item.artistId " class="upload-rEdit icons icon-edit"></a>

                    </li>
                  </ul>
                  <!-- <div class="upload-page el-pagination" v-if='prodCount != 0'> -->
                  <div class="upload-page el-pagination" v-if='totalpage > 1'>
                    <button type="button"  :class="[ curpage == 1 ? 'disabled' : '','btn-prev']" @click="pagePrev()" ><</button>
                    <span class="upload-num" >@{{curpage}}/@{{totalpage}}</span>
                    <button type="button" :class="[ curpage == totalpage ? 'disabled' : '','btn-next']" @click="pageNext()" >></button>
                    <span class="el-pagination__jump ">
                      <input type="number" min="1" number="true" v-model='inputpage' class="el-pagination__editor el-pagination__editor2" style="width: 58px;">
                      <a href="javascript:;" @click="gotopage()"  class="el-button el-button--info is-plain upload-jump">
                        <span>跳转</span>
                      </a>
                    </span>
                  </div>
                </el-tab-pane>
              <el-tab-pane :label="'作品系列（'+ prodCount2 +'）'" name="second" class="">
                <ul class="upload-rCon clearfix" v-loading.body="loading2" style="min-height: 300px; height: 100%">
                  <li v-for="(item,index) in prodItems2">
                    <a :href="'/upload/series?id=' + item.id">
                      <div class="upload-rImg" :style="{ backgroundImage: 'url(' + item.cover + ')'}">
                        <!-- <div v-if="item.state == '2'" class="myself"><i class="icons icon-myself"></i>仅自己可见</div> -->
                        <h2>
                          <div>@{{ item.name }} </div>
                        </h2>
                        <div class="upload-rImgmask"></div>
                      </a>
                    </div>
                    <div class="upload-rDate">@{{ item.create_time }}</div>
                    <!-- <div v-if="item.state==1" class="eyesopen" @click="geteyesInfo(item.artistId,item.state)"></div>
                    <div v-else class="eyesclose" @click="geteyesInfo(item.artistId,item.state)"></div>
                    <div class="toping" @click="totoping(item,index)"></div> -->
                    <div title="修改标题" class="upload-rEdit icons icon-edit" @click="newtitle(item.id,item.name)"></div>
                  </li>
                </ul>
                <div class="upload-page el-pagination" v-if='totalpage2 > 1'>
                  <button type="button"  :class="[ curpage2 == 1 ? 'disabled' : '','btn-prev']" @click="pagePrev2()" ><</button>
                  <span class="upload-num" >@{{curpage}}/@{{totalpage}}</span>
                  <button type="button" :class="[ curpage == totalpage2 ? 'disabled' : '','btn-next']" @click="pageNext2()" >></button>
                  <span class="el-pagination__jump">
                    <input type="number" min="1" number="true" v-model='inputpage2' class="el-pagination__editor el-pagination__editor2" style="width: 58px;">
                    <a href="javascript:;" @click="gotopage2()"  class="el-button el-button--info is-plain upload-jump">
                      <span>跳转</span>
                    </a>
                  </span>
                </div>
              </el-tab-pane>
            </el-tabs>
          </div>
        </div>
      </div>
      <!-- main-end -->
      <!-- 弹窗 -->
      <div class="maskWrap" v-show="maskseen" style="display: none">
        <div class="mask" v-bind:class="{ zIndex: alertseen }" @click="closemaskSeen"></div>
        <div class="alertSelect" v-show="alertseen" style="display: none">
          <h2>温馨提示</h2>
          <div class="alertCon">
            <p>您尚未上传画廊封面图</p>
            <el-button type="primary" @click="goUpload">@{{maskTxt}}</el-button>
            <el-button type="primary" @click="closemaskSeen">取消</el-button>
          </div>
        </div>
      </div>
      <!-- 弹窗 -->

      <!-- 是否可见提示 -->
      <div class="maskWrap" v-show="onlyscreen">
        <div class="mask" class="alertseen" @click="handleeyediabled"></div>
        <div class="eyesshowbox">
          <div class="eyeinfobox">
            <p>您确定要修改为@{{clickdInfo.statue==1?'不可见':'可见'}}吗？</p>
            <el-button type="primary" @click="changeOnlySelf">确定</el-button>
            <el-button type="primary" @click="handleeyediabled">取消</el-button>
          </div>
        </div>
      </div>
      <!-- 修改标题 -->
      <div class="maskWrap" v-if="seriesTitleEdit">
        <div class="mask" class="alertseen" @click="handleeyediabled"></div>
        <div class="eyesshowbox">
          <div class="eyeinfobox">
            <p class="ntitle">修改标题</p>
            <el-input v-model="newSeriesTitle" @blur="checktitle" placeholder="修改标题" class="newtitle"></el-input>
            <p v-show="titlelength20" style="padding: 0;position: absolute;font-size: 12px;margin-left: 25px;top: 120px;color:#ff4949">长度不大于 20 个字符</p>
            <el-button size="small" type="primary" @click="changetitle">确定</el-button>
            <el-button size="small" @click="canclechange">取消</el-button>
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
<script src="/js/upload/manage.js?v=1.2.1"></script>
</html>
