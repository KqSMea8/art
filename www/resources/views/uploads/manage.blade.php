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
    <link href="/css/global.css" rel="stylesheet">
    <link href="/css/gcommon.css" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/uploads/manage.css?v=0.0.1" rel="stylesheet">
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
              <h2 class="upload-rH">作品（@{{prodCount}}）</h2>
              <el-button type="primary" @click="showNewPro" class="el-button btn-24 el-button--primary upload-button">上传新作品</el-button>
              <el-button type="primary" @click="showEdit" class="el-button btn-24 el-button--primary edit-button">添加新创作纪录</el-button>
              <!-- <a href="/upload/edit" class="el-button btn-24 el-button--primary upload-button"><span>上传新作品</span></a> -->
              <ul class="upload-rCon clearfix" v-loading.body="loading" style="min-height: 300px; height: 100%">
                <li v-for="item in prodItems">
                  <a :href="'/upload/edit?id=' + item.id ">
                    <div class="upload-rImg" :style="{ backgroundImage: 'url(' + item.coverUrl + ')'}"><h2><div>@{{ item.name }} </div>
                    <span :class="['upload-rImgStatu', 'icons', item.updatetimes < 10 ? 'icon-status'+ item.updatetimes : 'icon-status'+'more' , item.isfinished == 'Y'? 'finished' : '']"></span></h2>
                    <div class="upload-rImgmask"></div>
                  </div>
                  <p class="upload-rTxt">@{{ item.story }}</p>
                  <div class="upload-rDate">@{{ item.last_update_time }}</div>
                  <a :href="'/upload/edit?id=' + item.id " class="upload-rEdit icons icon-edit"></a>
                </a>
              </li>
            </ul>
            <div class="upload-page el-pagination" v-if='prodCount != 0'>
              <button type="button"  :class="[ curpage == 1 ? 'disabled' : '','btn-prev']" @click="pagePrev()" ><</button>
              <span class="upload-num" >@{{curpage}}/@{{totalpage}}</span>
              <button type="button" :class="[ curpage == totalpage ? 'disabled' : '','btn-next']" @click="pageNext()" >></button>
              <span class="el-pagination__jump "><input type="number" min="1" number="true" v-model='inputpage' class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="gotopage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>
            </div>
          </div>
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
      <div v-show="newseen" class="pop anim-scale">
        <h2>添加新作品<em @click="closemaskSeen" title="关闭" >×</em></h2>
        <div class="my-form">
          <el-form ref="form1" :model="form1" :rules="rules1"  label-width="120px">
            <el-form-item label="画作名称" prop="name">
            <el-input v-model="form1.name" class="finished-pdr"></el-input>
          </el-form-item>
          <el-form-item label="画作类别" prop="category">
            <el-select v-model="form1.category" placeholder="选择你的画作类别">
              <el-option
              v-for="item in categoryOptions"
              :label="item.value"
              :value="item.id"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="作品权限" prop="permission">
            <el-select v-model="form1.permission" placeholder="权限选择">
              <el-option
              v-for="item in permissionOptions"
              :label="item.value"
              :value="item.id"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm1('form1')" class="btn-166">确定</el-button>
            <el-button type="primary" @click="closemaskSeen" class="btn-166">取消</el-button>
          </el-form-item>
          </el-form>
        </div>
      </div>
      <div v-show="editseen" class="pop anim-scale">
        <h2>添加新创作记录<em @click="closemaskSeen" title="关闭" >×</em></h2>
        <div class="my-form">
          <el-form ref="form1" :model="form1" :rules="rules1"  label-width="120px">
            <el-form-item label="画作名称" prop="name">
            <el-input v-model="form1.name" class="finished-pdr"></el-input>
          </el-form-item>
          <el-form-item label="画作类别" prop="category">
            <el-select v-model="form1.category" placeholder="选择你的画作类别">
              <el-option
              v-for="item in categoryOptions"
              :label="item.value"
              :value="item.id"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="作品权限" prop="permission">
            <el-select v-model="form1.permission" placeholder="权限选择">
              <el-option
              v-for="item in permissionOptions"
              :label="item.value"
              :value="item.id"
              >
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="submitForm1('form1')" class="btn-166">确定</el-button>
            <el-button type="primary" @click="closemaskSeen" class="btn-166">取消</el-button>
          </el-form-item>
          </el-form>
        </div>
      </div>
    </div>
    <!-- 弹窗 -->
    <ysz-footer2></ysz-footer2>
  </div>
</body>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script src="/js/service/agent.js"></script>
<script src="/js/lib/vue.min.js"></script>
<script src="/js/lib/element/index.js"></script>
<script src="/js/common.js?v=3.9.2"></script>
<script src="/js/uploads/manage.js?v=1.0.1"></script>
</html>