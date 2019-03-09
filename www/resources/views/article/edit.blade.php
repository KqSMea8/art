<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>文章编辑</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <!-- <link href="/css/iconfont/iconfont.css" rel="stylesheet"> -->
    <link href="/css/upload/edit.css?v=2.2.5" rel="stylesheet">

    <!-- <link href="/css/themes/default/css/ueditor.min.css?v=0.0.1" rel="stylesheet"> -->

    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!-- 载入Ueditor -->
    <script src="/laravel-ueditor/ueditor_article.config.js"></script>
    <!-- <script src="/laravel-ueditor/ueditor.all.min.js?v=2.0.1"></script> -->
    <script src="/laravel-ueditor/ueditor.all.min.js?v=2.0.1"></script>
    <script src="/laravel-ueditor/lang/zh-cn/zh-cn.js"></script>
    <!-- <script type="text/javascript" charset="utf-8" src="/laravel-ueditor/9fm/9fm.v1.js"></script> -->
    <script type="text/javascript">
      var targetProtocol = "http:";
      if (window.location.protocol != targetProtocol) {
        window.location.href = targetProtocol + window.location.href.substring(window.location.protocol.length);
      }
    </script>
    <style type="text/css">

    .el-date-picker	*{
      box-sizing: content-box;
    }
    .el-input__inner,.el-time-panel,.el-date-picker__time-header{
      box-sizing: border-box;
    }
    a.el-picker-panel__link-btn{
      display: none;
    }
    </style>
  </head>
  <body>
  <div id="edit"  v-cloak >
    <!-- header-begin -->
    <header class="ysz-header">
      <div class="y-header">
        <div class="w clearfix">
          <a href="/index">
          <h1 class="y-head fl"><img src="/image/logo.png" alt="logo" class="logo"> <span class="y-title">创作平台</span></h1>
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
   <div>
   <div id="main" class="w">
        <div class="main-wrap mb-72 clearfix" >
          <h2 class="edit-title"><a href="/article/manage">艺术号管理</a><span>/</span><span class="now">发表新文章</span></h2>
          <div class="edit-wrap clearfix">
              <div class="edit-l">
                 <h2 class="edit-ltitle" >更新状态</h2>
                 <ul class="edit-lUl">
                     <li v-bind:class="[ curli === 'Add' + myInfo.uid ? 'cur' : '']">
                        <div class="edit-img" :style="bg">
                          <div :title="editTitle" class="edit-imgTit">
                          @{{ editTitle }}
                          </div>
                        </div>
                        <div class="edit-con">
                            <h2 class="edit-contit">发布24小时内可修改</h2>
                            <div class="edit-condate">@{{ addDate}}</div>
                         </div>
                    </li>
                 </ul>
                 <div v-loading.body="loading" v-show="loading" style="min-height: 200px;"></div>
              </div>

              <div class="edit-c" >
                <!-- <script id="editor" type="text/plain" style="width:714px;height:523px;">
                </script> -->
                <script id="editor" name="content" type="text/plain" style="width:714px;height:523px;">
                </script>
                <div class="edit-cBottom">
                     <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">
                       <el-form-item class="edit-target">
                          <p class="edit-coverItip fl">内容标签 </p>
                           <el-select v-model="selectdTarget" class="sel-target" :disabled="selectflag" multiple :multiple-limit="5" @change="checknull" placeholder="请选择内容标签">
                             <el-option
                               v-for="item in contentTarget"
                               :label="item"
                               :value="item">
                             </el-option>
                           </el-select>
                         </el-form-item>
                        <el-form-item class="edit-coverI" prop='cover'>
                           <p class="edit-coverItip fl">封面图片 </p>
                           <div class="edit-coverwrap edit-cover">
                              <el-upload
                                class="avatar-uploader"
                                :action="ossAction"
                                :show-file-list="false"
                                :on-success="handleAvatarSuccess"
                                :before-upload="beforeAvatarUpload"
                                :http-request="uploadAvatar"
                                >
                                <div class="btn-wrap">
                                  <el-button size="small" type="primary">上传</el-button>
                                  <span class="upload-tips">上传格式为JPG,JPEG,GIF,PNG</span>
                                </div>
                                <img :src="ruleForm.cover?ruleForm.cover + '?x-oss-process=image/resize,m_fill,h_90,w_90,limit_0,image/format,jpg': '//artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/updateCover.png'" class="avatar">
                              </el-upload>
                              <div class="el-loading-mask2" v-show="uploadloading"><div class="el-loading-spinner"><svg viewBox="25 25 50 50" class="circular"><circle cx="50" cy="50" r="20" fill="none" class="path"></circle></svg><!----></div></div>
                           </div>
                         </el-form-item>

                         <el-form-item label=""  class="edit-cBottomDesc">
                           <p class="edit-cBottomDescTip">摘要内容</p>
                           <el-input placeholder="文章摘要" type="textarea" v-model="desc" :autosize="{ minRows: 5, maxRows: 5}"></el-input>
                         </el-form-item>


                         <el-form-item label=""  class="hangup">
                           <p class="hangupTip">定时发布时间</p>
                           <el-date-picker :editable="false" v-model="hangupval" :picker-options="futuretimeLines" @change="gethangupval" type="datetime" placeholder="选择日期时间" format="yyyy-MM-dd HH:mm:ss">
                          </el-date-picker>
                          <p style="color:red">注意1：选择时间应大于当前时间30分钟以上</p>
                          <p style="color:red">注意：不选则立即发布！</p>
                         </el-form-item>
                         <div class="agree-bar">
                           <p class="agree-check agreequan" @click="agreeToggle"><input type="checkbox"><label class="text_h" for="agree"><i :class="['icons', isAgree? 'icon-agreed': 'icon-agree']"></i>同时分享至艺术圈</label></p>
                         </div>
                         <div class="editBtnWrap">
                         <el-form-item>
                             <!-- <el-button type="primary" @click="maskSeen()">预览并发布</el-button> -->
                             <el-button type="primary" @click="maskSeen()">预览</el-button>
                             <el-button type="primary" @click="updatePro">发布</el-button>
                             <el-button type="primary" v-if="type != '1'" @click="saveDraft()">保存草稿</el-button>
                         </el-form-item>
                         </div>
                     </el-form>
                </div>
              </div>
              <div class="edit-r">
                <div id="right-nav">
                  <h2 class="edit-rTit">
                    插入多媒体
                  </h2>
                 <ul class="edit-rUl">
                  <li id="j_upload_img_btn">图片</li>
                  <insert-video-btn></insert-video-btn>
                  <upload-audio-btn></upload-audio-btn>
                  <insert-artzhe-btn></insert-artzhe-btn>
                 </ul>
                </div>
              </div>
          </div>
          <!-- 弹出手机面板 -->
           <div class="maskWrap" v-show="maskseen" style="display: none">
              <div class="mask" v-bind:class="{ zIndex: alertseen }" @click="closemaskSeen"></div>
              <div class="phone">
                <iframe src="/index/template2?v=1.2.3" frameborder="0" id="previewCreative_iframe" name="previewCreative_iframe"></iframe>
                <!-- <div class="agree-bar">
                  <p class="agree-check" @click="agreeToggle"><input type="checkbox"><label for="agree"><i :class="['icons', isAgree? 'icon-agreed': 'icon-agree']"></i>同时分享至艺术圈</label></p>
                </div> -->
                <el-button type="primary" @click="closemaskSeen">关闭</el-button>
              </div>
           </div>
           <!-- 弹出手机面板 -->
           <!-- 弹窗提示 -->
           <div class="maskWrap" v-show="alertseen" style="display: none">
              <div class="mask" v-bind:class="{ zIndex: alertseen }" @click="closemaskSeen"></div>
              <div class="alertSelect" v-show="alertseen" style="display: none">
                <h2>温馨提示 <em @click="closemaskSeen" title="关闭" >×</em></h2>
                <div class="alertCon">
                  <p v-html="alertInfo.text"></p>
                  <el-button type="primary" @click="closemaskSeen">确定</el-button>
                </div>
              </div>
            </div>
           <!-- 弹窗提示 -->

           <!-- 搜索艺术者内容弹窗 -->
           <insert-artzhe-box></insert-artzhe-box>
           <!-- 搜索艺术者内容弹窗 end -->

           <!-- 插入视频弹窗 -->
           <insert-video-box></insert-video-box>
           <!-- 插入视频弹窗 end -->
        </div>
    </div>
    <div id="editor-title" style="display: none;">
     <input type="text" placeholder="请在这里输入标题" maxlength="64" v-model="editTitle" v-bind:disabled="titleDisable">
     <span id="editor-Titcount">0/64</span>
     <span id="editor-Titip" v-show='isTitleTip'>文章名字不超过64字哦~</span>
    </div>
       </div>
      <ysz-footer2></ysz-footer2>
      <!-- 上传音频弹层 -->
      <audio-upload-comp></audio-upload-comp>
    </div>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.6/vue.js"></script> -->
    <script src="/js/lib/vue.min.js"></script>
    <script src="/js/lib/element/index.js"></script>
    <!-- <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script> -->
    <script src="/js/service/agent.js?v=2.1.8"></script>
    <script src="/js/common.js?v=3.9.4"></script>
    <script src="/laravel-ueditor/ueditor.plugins.dumpimage.js?v=1.0.2"></script>
    <script src="/laravel-ueditor/addButton.js?v=1.0.0"></script>
    <script src="/js/article/edit.js?v=2.2.8"></script>
    <script>
      //右侧点击
       document.getElementById('j_upload_img_btn').onclick = function () {
           var dialog = ue.getDialog("insertimage");
           dialog.title = '多图上传';
           dialog.render();
           dialog.open();
       };

       function banBackSpace(e){
         var ev = e || window.event;
         //各种浏览器下获取事件对象
         var obj = ev.relatedTarget || ev.srcElement || ev.target ||ev.currentTarget;
         //按下Backspace键
         if(ev.keyCode == 8){
           var tagName = obj.nodeName //标签名称
           //如果标签不是input或者textarea则阻止Backspace
           if(tagName!='INPUT' && tagName!='TEXTAREA'){
             return stopIt(ev);
           }
           var tagType = obj.type.toUpperCase();//标签类型
           //input标签除了下面几种类型，全部阻止Backspace
           if(tagName=='INPUT' && (tagType!='TEXT' && tagType!='TEXTAREA' && tagType!='PASSWORD')){
             return stopIt(ev);
           }
           //input或者textarea输入框如果不可编辑则阻止Backspace
           if((tagName=='INPUT' || tagName=='TEXTAREA') && (obj.readOnly==true || obj.disabled ==true)){
             return stopIt(ev);
           }
         }
       }
       function stopIt(ev){
         if(ev.preventDefault ){
           //preventDefault()方法阻止元素发生默认的行为
           ev.preventDefault();
         }
         if(ev.returnValue){
           //IE浏览器下用window.event.returnValue = false;实现阻止元素发生默认的行为
           ev.returnValue = false;
         }
         return false;
       }
       $(function(){
         //实现对字符码的截获，keypress中屏蔽了这些功能按键
         document.onkeypress = banBackSpace;
         //对功能按键的获取
         document.onkeydown = banBackSpace;
       })
    </script>
  </body>
</html>
