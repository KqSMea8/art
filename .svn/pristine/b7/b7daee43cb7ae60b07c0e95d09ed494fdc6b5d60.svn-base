<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>完成作品</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css" rel="stylesheet">
    <link href="/css/gcommon.css" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <!-- <link href="/js/plugin/webuploader.css" rel="stylesheet"> -->
    <link href="/css/finished.css?v=0.0.1" rel="stylesheet">
  </head>
  <body>
  <div id="finished" v-cloak>
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
    <div id="main" class="w">      
        <div class="main-wrap mb-72 clearfix finished" >            
           <h2 class="finished-title">上传作品 - <span>开始艺术创作</span></h2>
           <p class="finished-tip">这一次，为你的作品画上完美的句号吧~</p>
           <div class="finished-box">
                <el-form ref="ruleForm" :model="ruleForm" :rules="rules"  label-width="120px">

                  <el-form-item label="画作名称" required prop="name">
                    <el-input v-model="ruleForm.name" class="finished-pdr"></el-input>
                  </el-form-item>

                  <el-form-item label="画作色调" required  prop="color">
                    <el-select v-model="ruleForm.color" multiple placeholder="画作的色调，最多可选2种" class="finished-pdr" :multiple-limit='2'  >
                      <el-option
                         v-for="item in colorOptions"
                         :label="item.name"
                         :value="''+item.id"
                         :style="'background-color:'+ item.color +';color:#000'">
                       </el-option>
                    </el-select>
                  </el-form-item>

                  <el-form-item label="画作尺寸" >
                   <el-col :span="6">
                     <el-form-item required  prop="width" >
                         <el-input v-model.number="ruleForm.width"  class="w100" placeholder="长"></el-input>
                      </el-form-item>
                   </el-col>
                   <el-col class="line tc" :span="2">x</el-col>
                    <el-col :span="11">
                      <el-form-item required prop="height" >
                     <el-input v-model.number="ruleForm.height" type="number" class="w100" placeholder="宽"></el-input>
                      <span class="finished-cm">cm</span>
                      </el-form-item>
                    </el-col>
                  </el-form-item>

                  <el-form-item label="画作全景图" class='upload-pic1' required  prop="fileList1">
                   <div class="word-tip" v-show="beforeuploadShow1">作品全景图<br>（像素不低于1024*1024）<br>可上传多张</div>
                    <!-- <el-upload
                      action="/public/upload"  
                      :headers="{'X-CSRF-TOKEN': '{{csrf_token()}}'}"                    
                      list-type="picture-card"
                      :multiple=true
                      :file-list="ruleForm.fileList1"                      
                      :on-success="fileList1success"
                      :on-change="fileList1change"
                      :on-preview="handlePictureCardPreview1" 
                      :before-upload = "beforeupload1"
                      :on-remove = "remove1" 
                      :before-upload='beforeUpload1'                                                  
                      >
                      <i class="el-icon-plus"></i>
                    </el-upload> -->
                    <el-upload
                      action="//artzhe.oss-cn-shenzhen.aliyuncs.com"                      
                      list-type="picture-card"
                      :multiple=true
                      :file-list="ruleForm.fileList1"                      
                      :on-success="fileList1success"
                      :on-change="fileList1change"

                      :before-upload = "beforeupload1"
                      :on-remove = "remove1" 
                      :before-upload='beforeUpload1'
                      :on-progress = 'progress1'
                      :http-request="uploadImg1"                                            
                      >
                      <i class="el-icon-plus"></i>
                    </el-upload>
                    <!-- <el-upload
                      action="//artzhe.oss-cn-shenzhen.aliyuncs.com"                      
                      list-type="picture-card"
                      :multiple=true
                      :file-list="ruleForm.fileList1"                      
                      :on-success="fileList1success"
                      :on-change="fileList1change"
                      :on-preview="handlePictureCardPreview1" 
                      :before-upload = "beforeupload1"
                      :on-remove = "remove1" 
                      :before-upload='beforeUpload1'
                      :on-progress = 'progress1'
                      :data="uploadData"                                           
                      >
                      <i class="el-icon-plus"></i>
                    </el-upload> -->
                    <el-dialog v-model="dialogVisible1" size="tiny">
                      <img width="100%" :src="dialogImageUrl1" alt="">
                    </el-dialog>
                  </el-form-item>

                  <el-form-item label="画作局部图" class='upload-pic2' required  prop="fileList2">
                    <div class="word-tip" v-show="beforeuploadShow2">画作局部图<br>（像素不低于1024*1024）<br>可上传多张</div>
                    <el-upload
                      action="/public/upload"
                      :headers="{'X-CSRF-TOKEN': '{{csrf_token()}}'}"
                      list-type="picture-card"
                      :multiple=true
                      :file-list="ruleForm.fileList2"
                      :on-success="fileList2success"   
                      :on-change="fileList2change"
                      :on-preview="handlePictureCardPreview2"  
                      :before-upload = "beforeupload2" 
                      :on-remove = "remove2"                           
                      >
                      <i class="el-icon-plus"></i>
                    </el-upload>

                    <el-dialog v-model="dialogVisible2" size="tiny">
                      <img width="100%" :src="dialogImageUrl2" alt="">
                    </el-dialog>
                  </el-form-item>

                  <el-form-item label="画作介绍" prop="desc" required>
                    <el-input type="textarea" v-model="ruleForm.desc" :autosize="{ minRows: 10, maxRows: 10}"  placeholder="简要描述画作初衷，不少于150字。共鸣者将通过它一眼相中你的话画。"></el-input>
                  </el-form-item>
                  <el-form-item>
                    <el-button type="primary" @click="submitForm('ruleForm')" class="btn-24" style="margin-left: 30px;">完成</el-button>
                  </el-form-item>
                </el-form>              
           </div>            
        </div>        
      </div>
      <ysz-footer2></ysz-footer2>
    </div>

    
    <!-- </div> -->
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/js/service/agent.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <!-- <script src="/js/plugin/webuploader.min.js"></script> -->
  <script src="/js/upload/finished-oss.js"></script>
</html>