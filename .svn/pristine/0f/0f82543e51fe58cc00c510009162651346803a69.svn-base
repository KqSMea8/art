<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>作品编辑</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css" rel="stylesheet">
    <link href="/css/gcommon.css" rel="stylesheet">
    <!-- <link href="/css/iconfont/iconfont.css" rel="stylesheet"> -->
    <link href="/css/edit.css?v=0.0.1" rel="stylesheet">
    <!-- <link href="/css/themes/default/css/ueditor.min.css?v=0.0.1" rel="stylesheet"> -->
    @include('UEditor::head')
    <!-- <script type="text/javascript" charset="utf-8" src="/laravel-ueditor/9fm/9fm.v1.js"></script> -->
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
          <h2 class="edit-title">上传作品 - <span>开始艺术创作</span></h2>
          <div class="edit-wrap clearfix">
              <div class="edit-l">
                 <h2 class="edit-ltitle" >更新状态</h2>
                 <ul class="edit-lUl" v-bind:class="[ isFinished === 'Y' ? 'finished' : '']">  
                       <!-- 新增 -->
                     <li v-if="isFinished !== 'Y'" v-bind:class="[ curli === 'Add'+myInfo.uid ? 'cur' : '']" @click="addPro">
                        <div class="edit-img" :style="bg">
                          <div class="edit-imgTit"> 
                                发布24小时内可修改                      
                          </div>
                           </div>
                        <div class="edit-con">
                            <h2 class="edit-contit">@{{ editTitle }}</h2>
                            <div class="edit-condate">@{{ addDate}}</div>                            
                         </div>
                    </li>
                        <!-- 新增 -->                                 
                   <template v-for="item in updateLists">
                     <template v-for="i in item.list">
                      <!-- <template v-if="(new Date().getTime() - i.last_update_time) > 86400000"> -->
                        <li @click="editPro(i.id)" v-bind:class="[i.id == curli ? 'cur' : '']">
                            <div class="edit-img" :style="{ backgroundImage: 'url(' + i.cover + ')'}">
                               <div class="edit-imgTit"> 
                                 发布24小时内可修改                      
                               </div>
                            </div>
                            <div class="edit-con">
                               <h2 class="edit-contit">@{{proname}}</h2>
                               <div class="edit-condate">@{{i.create_date}}</div>
                               <span :class="['edit-rImgStatu', 'icons', i.number < 10 ? 'icon-status'+ i.number : 'icon-status'+'more']"></span>
                            </div>
                         </li>
                      <!-- </template> -->
                      <!-- <template v-else>
                       <li  class="noclick">
                          <div class="edit-img" :style="{ backgroundImage: 'url(' + i.cover + ')'}">
                             <div class="edit-imgTit"> 
                               已经不能修改                      
                             </div>
                          </div>
                          <div class="edit-con">
                             <h2 class="edit-contit">@{{proname}}</h2>
                             <div class="edit-condate">@{{i.create_date}}</div>
                          </div>
                       </li>
                      </template> -->
                    </template>  
                  </template>                 
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

                         <el-form-item label="创作时间" required  prop="date"> 
                              <el-date-picker type="date" placeholder="选择艺术创作时间" v-model="ruleForm.date"></el-date-picker>
                         </el-form-item>

                        <el-form-item label="" required  class="edit-coverI" prop='cover'> 
                           <p class="edit-coverItip">封面 <span>建议像素：1024*1024</span></p>
                           <div class="edit-coverwrap edit-cover">  
                              <el-upload
                                class="avatar-uploader"
                                action="/public/upload"
                                :headers="{'X-CSRF-TOKEN': '{{csrf_token()}}'}"
                                :show-file-list="false"
                                :on-success="handleAvatarScucess"
                                :before-upload="beforeAvatarUpload"                                                                
                                >
                                <img v-if="ruleForm.cover" :src="ruleForm.cover" class="avatar">
                                <el-button v-else size="small" type="primary">上传</el-button>
                              </el-upload> 
                              <!-- <div class="edit-coverR">
                                 <el-switch
                                   v-model="coverShow"
                                   on-text=""
                                   off-text="">
                                 </el-switch>
                                 <span class="edit-coverTip">在正文中显示封面</span>
                              </div>  -->    
                              <div class="el-loading-mask2" v-show="uploadloading" style="float: left;"><div class="el-loading-spinner"><svg viewBox="25 25 50 50" class="circular"><circle cx="50" cy="50" r="20" fill="none" class="path"></circle></svg><!----></div></div>                         
                           </div>                                            
                         </el-form-item>  


                         <el-form-item label="画作类别" required  prop="class">
                           <el-select v-model="ruleForm.class" placeholder="选择你的画作类别">
                           <!-- <el-option label="区域一" value="shanghai"></el-option>
                           <el-option label="区域二" value="beijing"></el-option> -->
                            <el-option
                                  v-for="item in classOptions"
                                  :label="item.value"
                                  :value="item.id"
                                 >
                                </el-option>
                           </el-select>
                         </el-form-item>
                         
                         <el-form-item label="画作标签" required prop='tagValue'>
                           <template>
                             <el-select v-model="ruleForm.tagValue" multiple placeholder="画的五个标签" :multiple-limit='5' >
                               <el-option
                                 v-for="item in tagOptions"
                                 :label="item.value"
                                 :value="''+item.id">
                               </el-option>
                             </el-select>
                           </template>
                         </el-form-item>

                         <p class="edit-cBottomDescTip">摘要<span> 选填，如果不填写默认抓取正文54个字</span></p>

                         <el-form-item label=""  class="edit-cBottomDesc">
                           <el-input type="textarea" v-model="desc" :autosize="{ minRows: 5, maxRows: 5}"></el-input>
                         </el-form-item>   
                         <div class="editBtnWrap">
                         <el-form-item>
                             <!-- <el-button type="primary" @click="saveForm('ruleForm')">保存</el-button> -->
                             <el-button type="primary" @click="maskSeen()">预览并发布</el-button>
                         </el-form-item>
                         </div>
                     </el-form>
                </div>
              </div>
              <div class="edit-r">
                 <h2 class="edit-rTit">
                   多媒体
                 </h2>
                 <ul class="edit-rUl">
                   <li id="j_upload_img_btn">图片</li>
                   <!-- <li>音乐</li>
                   <li>视频</li> -->
                 </ul>
              </div>
          </div> 
          <!-- 弹出手机面板 -->
           <div class="maskWrap" v-show="maskseen" style="display: none">
              <div class="mask" v-bind:class="{ zIndex: alertseen }" @click="closemaskSeen"></div>
              <div class="phone">
                <iframe src="/template" frameborder="0" id="previewCreative_iframe" name="previewCreative_iframe"></iframe>   
                <el-button type="primary" @click="alertSeen()">发布</el-button>            
              </div>
              <div class="alertSelect" v-show="alertseen" style="display: none">
                 <h2>温馨提示</h2>
                 <div class="alertCon">
                      <p>“@{{editTitle}}”是否全部创作完成，以后不再更新？</p>
                      <el-button type="primary" @click="finishedPro">是</el-button> 
                      <el-button type="primary" @click="updatePro">不，以后还需要更新</el-button>
                 </div>
              </div>               
           </div>
           <!-- 弹出手机面板 -->
           <!-- 弹出选择面板 -->

           <!-- 弹出选择面板 -->
        </div>     
    </div>
    <div id="editor-title" style="display: none;">
     <input type="text" placeholder="为你的作品取个名字" maxlength="11" v-model="editTitle" v-bind:disabled="titleDisable">
     <span id="editor-Titcount">0/20</span>
     <span id="editor-Titip" v-show='isTitleTip'>输入的标题不能多于20字符</span>      
   </div>
   </div>
    <ysz-footer2></ysz-footer2>
   </div>
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/js/service/agent.js"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <!-- 配置文件 -->
  <!-- <script type="text/javascript" src="/js/plugin/ueditor.config.js"></script> -->
  <!-- 编辑器源码文件 -->
  <!-- <script type="text/javascript" src="/js/plugin/ueditor.all.min.js"></script>
  <script type="text/javascript" src="/js/plugin/lang/zh-cn/zh-cn.js"></script> -->
  <script src="/js/upload/edit.js"></script>
  <script>
    //右侧点击
     document.getElementById('j_upload_img_btn').onclick = function () {
         var dialog = ue.getDialog("insertimage");
         dialog.title = '多图上传';
         dialog.render();
         dialog.open();
     };

  </script>
</html>