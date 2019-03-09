<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>上传作品-添加新作品</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/upload/update.css?v=2.0.0" rel="stylesheet">
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
          <div class="main-wrap mb-60 clearfix">
            <h2 class="title"><a href="/upload/manage">作品管理</a><span>/<span class="now">添加新作品</span></span></h2>
            <div class="form-wrap1">
              <el-form ref="form1" :model="form1" :rules="attrRules"  label-width="227px">
                <el-form-item label="作品名称" prop="artworkName">
                  <el-input v-model="form1.artworkName" class="w-350" placeholder="为你的作品取一个名称（可改）"></el-input>
                </el-form-item>
                <!-- <el-form-item label="作品类型" prop="category">
                  <el-select class="w-350" v-model="form1.category" placeholder="选择你的作品类型" popper-class="change-sel">
                    <el-option
                    v-for="item in categoryOptions"
                    :label="item.value"
                    :value="item.id"
                    >
                    </el-option>
                  </el-select>
                </el-form-item> -->
                <el-form-item label="作品权限" prop="state">
                  <el-select class="w-350" v-model="form1.state" placeholder="权限选择">
                    <el-option
                    v-for="item in stateOptions"
                    :label="item.value"
                    :value="item.id"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="画作系列">
                  <el-select class="w-350" v-model="form1.series_id" placeholder="画作选择">
                    <el-option
                    v-for="item in seriesOption"
                    :label="item.name"
                    :value="item.id"
                    >
                    </el-option>
                  </el-select>
                  <el-button type="primary" @click="seriesDia = true" class="seriesbtn" style="margin-left: 30px;">新建系列</el-button>
                </el-form-item>
                <el-form-item label="作品类型" prop="category">
                  <el-select  class="w-352"
                  v-model="form1.category"
                  placeholder="添加类型标签，也可手动输入"
                  multiple
                  filterable
                  allow-create
                  :multiple-limit='5'
                  @visible-change="notspace(form1.category,'form1.category')"
                  popper-class="change-sel2">
                    <el-option
                    v-for="item in categoryOptions"
                    :label="item.value"
                    :value="item.value"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="作品色调" prop="color">
                  <el-select v-model="form1.color"
                  multiple
                  placeholder="画作的色调，最多可选2种" class="w-350"
                  popper-class="change-sel2"
                  :multiple-limit='2'>
                    <el-option
                       v-for="item in colorOptions"
                       :label="item.name"
                       :value="item.id"
                       :style="item.style"
                       >
                     </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="作品形状" prop="shape">
                  <el-select class="w-350" v-model="form1.shape" placeholder="请选择作品形状">
                    <el-option
                    v-for="item in shapeOptions"
                    :label="item.value"
                    :value="item.id"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item v-if="form1.shape == 1" label="作品尺寸" >
                 <el-col :span="6">
                   <el-form-item  prop="length" >
                      <el-input v-model.number="form1.length" type="text" class="w120" placeholder="长"></el-input>
                    </el-form-item>
                 </el-col>
                 <el-col class="line tc" :span="2">x</el-col>
                  <el-col :span="11">
                    <el-form-item prop="width" >
                    <el-input v-model.number="form1.width" type="text" class="w120" placeholder="宽"></el-input>
                    <span class="finished-cm">cm</span>
                    </el-form-item>
                  </el-col>
                </el-form-item>
                <el-form-item v-if="form1.shape == 2" label="作品尺寸" prop="diameter">
                  <el-input v-model.number="form1.diameter" type="text" style="width: 286px" placeholder="直径"></el-input>
                  <span class="finished-cm">cm</span>
                </el-form-item>
                <el-form-item label="创作年份" prop="">
                  <el-select class="w-350" v-model="form1.artworkDate" placeholder="请选择创作年份">
                    <el-option
                    v-for="item in yearOptions"
                    :label="item"
                    :value="item"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="作品题材" prop="subject">
                  <el-select class="w-352" v-model="form1.subject"
                  multiple
                  filterable
                  allow-create
                  :multiple-limit='5'
                  popper-class="change-sel2"
                  @visible-change="notspace(form1.subject,'form1.subject')"
                  placeholder="添加题材标签，也可手动输入">
                    <el-option
                    v-for="item in subjectOptions"
                    :label="item.value"
                    :value="item.value"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="作品风格" prop="style">
                  <el-select class="w-350" v-model="form1.style"
                  multiple
                  filterable
                  allow-create
                  :multiple-limit='5'
                  popper-class="change-sel2"
                  @visible-change="notspace(form1.style,'form1.style')"
                  placeholder="添加风格标签，也可手动输入">
                    <el-option
                    v-for="item in styleOptions"
                    :label="item.value"
                    :value="item.value"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="画作介绍" prop="story">
                  <el-input type="textarea" class="w-350" v-model="form1.story" :autosize="{ minRows: 10, maxRows: 10}"
                  placeholder="简要描述画作初衷，共鸣者将通过它一眼相中你的画。（150字内）"></el-input>
                </el-form-item>
                <el-form-item label="画作封面图" class='upload-pic1'  prop="cover">
                 <div class="word-tip" v-if="!form1.cover">作品封面图<br>上传格式:JPG,JPEG,GIF,PNG</div>
                  <el-upload
                    class="avatar-uploader"
                    :action="ossAction"
                    :show-file-list="false"
                    :on-success="handleCoverSuccess"
                    :before-upload="beforeCoverUpload"
                    :http-request="uploadCover">
                    <img v-if="form1.cover" :src="form1.cover" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon self-upload-icon"></i>
                  </el-upload>
                  <p class="uploadpictrip" style="bottom:-28px;">注意查看预览图，按照规范去上传作品，这样有助于让您的作品置顶推荐哦~~</p>
                  <div class="imgExample" @click="showyulan(1)">
                    <p>示例图</p>
                  </div>
                </el-form-item>

                <el-form-item label="画作全景图" class='upload-pic1'  prop="fileList1">
                 <div class="word-tip" v-show="beforeuploadShow1">作品全景图<br>上传格式:JPG,JPEG,GIF,PNG</div>
                  <el-upload
                    :action="ossAction"
                    list-type="picture-card"
                    :multiple=true
                    :file-list="form1.panorama"
                    :before-upload = "beforeupload1"
                    :on-remove = "remove1"
                    :http-request="uploadImg1"
                    >
                    <i class="el-icon-plus self-upload-icon"></i>
                  </el-upload>
                  <div class="imgExample" @click="showyulan(2)">
                    <p>示例图</p>
                  </div>
                  <p class="uploadpictrip">注意查看预览图，按照规范去上传作品，这样有助于让您的作品置顶推荐哦~~</p>

                </el-form-item>
                <el-form-item label="画作局部图" class='upload-pic2'  prop="fileList2">
                  <div class="word-tip" v-show="beforeuploadShow2">画作局部图<br>作品局部细节，可上传多张<br>上传格式:JPG,JPEG,GIF,PNG</div>
                  <el-upload
                    :action="ossAction"
                    list-type="picture-card"
                    :multiple=true
                    :file-list="form1.topography"
                    :before-upload = "beforeupload2"
                    :on-remove = "remove2"
                    :http-request="uploadImg2"
                    >
                    <i class="el-icon-plus self-upload-icon"></i>
                  </el-upload>
                  <p class="uploadpictrip">注意查看预览图，按照规范去上传作品，这样有助于让您的作品置顶推荐哦~~</p>
                  <div class="imgExample" @click="showyulan(3)">
                    <p>示例图</p>
                  </div>
                </el-form-item>


                <el-form-item class='mt60'>
                  <el-button type="primary" @click="submitForm1('form1')" class="btn-166" style="margin-left: 30px;">下一步</el-button>
                </el-form-item>
              </el-form>
            </div>
          </div>
        </div>
      </div>

      <!--弹出层  -->
    <div class="maskWrap" v-if="seriesDia">
      <div class="mask alertseen" @click="seriesDia = false"></div>
      <div class="eyesshowbox">
        <div class="eyeinfobox">
          <p>输入画作系列标题</p>
          <el-input v-model="inputSeries" class="inputseries" placeholder="请输入画作系列"></el-input>
          <el-button type="primary" @click="addSeries">确定</el-button>
          <el-button type="primary" @click="seriesDia = false">取消</el-button>
        </div>
      </div>
    </div>


    <div class="" v-if="yulan">
      <div class="mask alertseen" @click="yulan = false"></div>
      <div class="yulanbox">
        <div class="yulantitlediv">
          <span class="yulantitle">预览图</span>
        </div>
        <div class="clearfix ylcontent">
          <div class="fl rightdiv">
            <img :src="yulanimg1" alt="">
            <p class="trip r">正确的示范</p>
          </div>
          <div class="fl rightdiv">
            <img :src="yulanimg2" alt="">
            <p class="trip e">错误的示范</p>
          </div>
        </div>
        <el-button type="primary" class="yulanbtn" @click="yulan = false">确定</el-button>
      </div>
    </div>
    <!-- main-end -->
    <ysz-footer2></ysz-footer2>
  </div>
</body>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script src="/js/service/agent.js?v=2.1.6"></script>
<script src="/js/lib/vue.min.js"></script>
<script src="/js/lib/element/index.js?v=2.0.0"></script>
<script src="/js/common.js?v=3.9.2"></script>
<script src="/js/upload/addartwork.js?v=2.0.3"></script>
</html>
