<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <title>上传作品-添加新创作花絮</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/css/upload/update.css?v=2.0.0" rel="stylesheet">
    <script type="text/javascript">
      // var targetProtocol = "https:";
      // if (window.location.protocol != targetProtocol) {
      //   window.location.href = targetProtocol + window.location.href.substring(window.location.protocol.length);
      // }
    </script>
    <style media="screen">
      .right-wrap{
        margin-left: 0;
        padding: 0 60px;
      }
      .propertydetails{
        margin: 42px 0 0 0px;
        width: auto;
        border-bottom: 1px solid #E4E4E4;
      }
      .imgherd{

      }
    </style>
  </head>
  <body >
    <div id="app" v-cloak>
      <div v-loading.fullscreen.lock="fullscreenLoading"></div>
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
            <h2 class="title"> <a href="/upload/manage">作品管理</a><span>/<span class="now" style="color:#fbb231;">添加创作花絮</span></span></h2>
            <!-- <div class="left-wrap">
              <h3>作品属性</h3>
              <div class="percent-wrap">
                <div class="con">
                  <p>作品属性完整度：@{{percent}}%</p>
                  <el-progress :stroke-width="8" :percentage="percent"></el-progress>
                </div>
                <p class="mark" style="color:red;">注：作品属性完整度100%时，将获得“作品·集”推荐。</p>
              </div>
              <div class="attr-form">
                <el-form ref="form1" :model="form1" :rules="rules1"  label-width="97px">
                  <el-form-item label="作品名称" prop="name">
                    <el-input :maxlength=20 v-model="form1.name" class="w-315" placeholder="为你的作品取一个名称（可改）"></el-input>
                  </el-form-item>
                  <el-form-item label="作品权限" prop="permission">
                    <el-select class="w-315" v-model="form1.permission" placeholder="选择作品权限">
                      <el-option
                      v-for="item in permissionOptions"
                      :label="item.value"
                      :value="item.id"
                      >
                      </el-option>
                    </el-select>
                  </el-form-item>
                  <el-form-item class='mt60'>
                    <el-button @click="submitForm1('form1')" class="btn-24">填写作品属性&gt;&gt;</el-button>
                  </el-form-item>
                </el-form>
              </div>
            </div> -->

            <div class="right-wrap" style="height: auto;overflow-y: initial;">
              <el-form ref="form1" :model="form1" :rules="rules1">
                <div class="propertydetails clearfix">
                  <div class="fl propertydetailsbox">
                    <img :src="characteristic.cover" alt="" class="imgherd">
                  </div>
                  <div class="fl detailsbox">
                    <h3 class="detailstitle">《@{{characteristic.name}}》</h3>
                    <ul class="clearfix sxul">
                      <li class="fl"><p>作品类型：@{{characteristic.category?characteristic.category:'未填写'}}</p></li>
                      <li class="fl"><p>作品形状：@{{characteristic.shape==1?'方形':'圆形'}}</p></li>
                      <li class="fl"><p>作品权限：@{{characteristic.state==1?'所有人可见':'仅自己可见'}}</p></li>
                      <li class="fl"><p>作品题材：@{{characteristic.subject?characteristic.subject:'未填写'}}</p></li>
                      <li v-if="characteristic.diameter" class="fl"><p>作品尺寸：@{{characteristic.diameter?characteristic.diameter+'cm':'未填写'}}</p></li>
                      <li v-else class="fl">
                        <p v-if="characteristic.width&&characteristic.length">作品尺寸：@{{(characteristic.width)+'x'+(characteristic.length)+'cm'}}</p>
                        <p v-else>作品尺寸：未填写</p>
                      </li>
                      <li class="fl"><p>作品色调：@{{characteristic.color_ids?characteristic.color_ids:'未填写'}}</p></li>
                      <li class="fl"><p>创作年份：@{{characteristic.artwork_date?(characteristic.artwork_date+'年'):'未填写'}}</p></li>
                      <li class="fl"><p>作品风格：@{{characteristic.style?characteristic.style:'未填写'}}</p></li>
                      <li class="fl"><p>作品系列：@{{characteristic.series_name?characteristic.series_name:'无'}}</p></li>
                    </ul>
                    <el-button @click="submitForm1('form1')" size="small" class="addsx">修改属性</el-button>
                     <p class="txt2" style="color:#F00; margin-top:8px;line-height: 18px;">作品属性完整度100%+更行创作花絮，作品才会被推荐在“作品集”中哦~</p>
                  </div>
                </div>
              </el-form>
              <!-- 添加新作品，第一次创作花絮-->
              <div v-if="updateList.length == 0" class="first-time">
                <i class="icons icon-times icon-times-1"></i>
                <el-form :model="form2" :rules="rules2" ref="form2" label-width="200px">
                  <div class="add-date">@{{form2.date}}</div>
                  <!-- <el-form-item label="第1次花絮创作时间" prop="date">
                    <el-date-picker type="date" placeholder="选择艺术创作时间" v-model="form2.date"></el-date-picker>
                  </el-form-item> -->
                  <div @click="submitForm2('form2')" class="btn btn-24">
                    <p class="txt1">添加创作花絮</p>
                    <p class="txt2">+讲述作品故事</p>
                  </div>
                   <p class="txt2" style="color:#F00; margin-top:8px;line-height: 18px; margin-left: 208px;">更新“创作花絮”，作品才会出现在“我的画廊”中，您也会被推荐为人气艺术家哦~</p>
                </el-form>
                <div class="info">
                  <h4>作品背后的故事</h4>
                  <dl>
                    <dt><i class="cir cir-1"></i>选择创作时间</dt>
                    <dd>搭建创作花絮时间轴</dd>
                  </dl>
                  <dl>
                    <dt><i class="cir cir-2"></i>讲述作品故事</dt>
                    <dd>
                      <ul class="fun-list clearfix">
                        <li><i class="icons icon-pic"></i>传图片</li>
                        <li><i class="icons icon-feel"></i>谈感受</li>
                        <li><i class="icons icon-video"></i>拍视频</li>
                        <li><i class="icons icon-heart"></i>聊心情</li>
                      </ul>
                    </dd>
                  </dl>
                </div>
              </div>
              <!-- 更新作品，第N次创作花絮-->
              <div v-else class="update-list">
                
              
              <ol class="update-list">
                <li v-if="isFinished !== 'Y' && !hasDraft" class="item">
                  <div class="time-line"></div>
                  <i :class="['icons', 'icon-times', updateTime < 10 ? 'icon-times-' + updateTime : 'icon-times-more']"></i>
                  <el-form label-position="left" :model="form2" :rules="rules2" ref="form2" label-width="165px">
                    <!-- <el-form-item :label="'第'+ updateTime + '次花絮创作时间'" prop="date">
                      <el-date-picker type="date" placeholder="选择艺术创作时间" v-model="form2.date"></el-date-picker>
                    </el-form-item> -->
                    <div class="add-date">@{{form2.date}}</div>
                    <div @click="submitForm2('form2')" class="btn btn-24">
                      <p class="txt1">添加创作花絮</p>
                      <p class="txt2">+讲述作品故事</p>
                    </div>
                  </el-form>
                </li>
              </ol>
              <ol class="update-list">
                <li v-for="updateItem in updateList" class="item clearfix">
                  <div class="time-line"></div>
                  <i :class="['icons', 'icon-times', updateItem.number < 10 ? 'icon-times-'+ updateItem.number : 'icon-times-more']"></i>
                  <div class="up-info">
                    <!-- <p class="time">第@{{updateItem.number}}次花絮</p> -->
                    <p class="date">@{{updateItem.create_date}}</p>
                  </div>
                  <div class="con-wrap clearfix">
                    <div class="detail fl">
                      <div class="img-wrap clearfix">
                        <img v-if="updateItem.img[0]!=''" v-for="imgItem in updateItem.img" class="img-item" :src="imgItem">
                        <div v-else class="img-item" style="ovflow: hidden;"></div>
                      </div>
                      <p class="desc">@{{updateItem.summary}}</p>
                    </div>
                    <div v-if="updateItem.isEdit == 'Y' && updateItem.flag == '1'" class="edit-btn fl" @click="gotoEdit(updateItem.id, updateItem.flag)">
                      <div class="cont">
                        <i class="icons icon-edit"></i>
                        <p class="draft">草稿，未发布</p>
                      </div>
                    </div>
                    <div v-if="updateItem.isEdit == 'Y' && updateItem.flag == '2'" class="edit-btn fl" @click="gotoEdit(updateItem.id, updateItem.flag)">
                      <div class="cont">
                        <i class="icons icon-edit"></i>
                        <p class="draft">编辑</p>
                        <!-- <p class="mark">（发布后24小时内可编辑）</p> -->
                      </div>
                    </div>
                  </div>
                </li>
              </ol>
                <div class="hxpage">
                  <div class="upload-page el-pagination" v-if='totalpage>1'>
                    <button type="button"  :class="[ curpage == 1 ? 'disabled' : '','btn-prev']" @click="pagePrev" ><</button>
                    <span class="upload-num" >@{{curpage}}/@{{totalpage}}</span>
                    <button type="button" :class="[ curpage == totalpage ? 'disabled' : '','btn-next']" @click="pageNext" >></button>
                    <span class="el-pagination__jump ">
                      <input type="number" min="1" number="true" v-model='inputpage' class="el-pagination__editor el-pagination__editor2" style="width: 58px;">
                      <a href="javascript:;" @click="gotopage"  class="el-button el-button--info is-plain upload-jump">
                        <span>跳转</span>
                      </a>
                    </span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- main-end -->
      <!-- 作品属性弹窗 -->
      <artwork-attr-wrap></artwork-attr-wrap>
      <!-- <div class="maskWrap" v-show="maskseen" style="display: none">
        <div class="mask" @click="closemaskSeen"></div>
        <div v-show="finishseen" class="finish-wrap">
          <div v-show="finishseen" class="finish anim-scale">
            <h2>作品属性<em @click="closemaskSeen" title="关闭" >×</em></h2>
            <div class="finished-box">
              <el-form ref="attrForm" :model="attrForm" :rules="attrRules"  label-width="248px">
                <el-form-item label="作品类型" prop="category">
                  <el-select  class="w-350"
                  v-model="attrForm.category"
                  placeholder="添加类型标签，也可手动输入"
                  multiple
                  filterable
                  allow-create
                  :multiple-limit='5'
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
                  <el-select v-model="attrForm.color"
                  multiple
                  placeholder="画作的色调，最多可选2种" class="w-350"
                  popper-class="change-sel2"
                  :multiple-limit='2'>
                    <el-option
                       v-for="item in colorOptions"
                       :label="item.name"
                       :value="''+item.id"
                       :style="'background-color:'+ item.color +';color:#000'">
                     </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="作品形状" prop="shape">
                  <el-select class="w-350" v-model="attrForm.shape" placeholder="请选择作品形状">
                    <el-option
                    v-for="item in shapeOptions"
                    :label="item.value"
                    :value="item.id"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item v-if="attrForm.shape == '1'" label="作品尺寸" >
                 <el-col :span="6">
                   <el-form-item  prop="length" >
                      <el-input v-model.number="attrForm.length" type="number" class="w120" placeholder="长"></el-input>
                    </el-form-item>
                 </el-col>
                 <el-col class="line tc" :span="2">x</el-col>
                  <el-col :span="11">
                    <el-form-item prop="width" >
                    <el-input v-model.number="attrForm.width" type="number" class="w120" placeholder="宽"></el-input>
                    <span class="finished-cm">cm</span>
                    </el-form-item>
                  </el-col>
                </el-form-item>
                <el-form-item v-if="attrForm.shape == '2'" label="作品尺寸" prop="diameter">
                  <el-input v-model.number="attrForm.diameter" type="number" style="width: 286px" placeholder="直径"></el-input>
                  <span class="finished-cm">cm</span>
                </el-form-item>
                <el-form-item label="创作年份" prop="artwork_date">
                  <el-select class="w-350" v-model="attrForm.artwork_date" placeholder="请选择创作年份">
                    <el-option
                    v-for="item in yearOptions"
                    :label="item"
                    :value="item"
                    >
                    </el-option>
                  </el-select>
                </el-form-item>
                <el-form-item label="作品题材" prop="subject">
                  <el-select class="w-350" v-model="attrForm.subject"
                  multiple
                  filterable
                  allow-create
                  :multiple-limit='5'
                  popper-class="change-sel2"
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
                  <el-select class="w-350" v-model="attrForm.style"
                  multiple
                  filterable
                  allow-create
                  :multiple-limit='5'
                  popper-class="change-sel2"
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
                  <el-input type="textarea" class="w-350" v-model="attrForm.story" :autosize="{ minRows: 10, maxRows: 10}"  placeholder="简要描述画作初衷，不少于150字。共鸣者将通过它一眼相中你的画。"></el-input>
                </el-form-item>
                <el-form-item label="画作封面图" class='upload-pic1'  prop="cover">
                 <div class="word-tip" v-if="!attrForm.cover">作品封面图<br>（像素不低于1024*1024）<br>作品封面图，不含其它内容</div>
                  <el-upload
                    class="avatar-uploader"
                    :action="ossAction"
                    :show-file-list="false"
                    :on-success="handleCoverSuccess"
                    :before-upload="beforeCoverUpload"
                    :http-request="uploadCover">
                    <img v-if="attrForm.cover" :src="attrForm.cover" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                  </el-upload>
                </el-form-item>
                <el-form-item label="画作全景图" class='upload-pic1'  prop="fileList1">
                 <div class="word-tip" v-show="beforeuploadShow1">作品全景图<br>（像素不低于1024*1024）<br>作品主图，不含其它内容</div>
                  <el-upload
                    :action="ossAction"
                    list-type="picture-card"
                    :multiple=true
                    :file-list="attrForm.fileList1"
                    :before-upload = "beforeupload1"
                    :on-remove = "remove1"
                    :http-request="uploadImg1"
                    >
                    <i class="el-icon-plus"></i>
                  </el-upload>
                </el-form-item>
                <el-form-item label="画作局部图" class='upload-pic2'  prop="fileList2">
                  <div class="word-tip" v-show="beforeuploadShow2">画作局部图<br>（像素不低于1024*1024）<br>作品局部细节，可上传多张</div>
                  <el-upload
                    :action="ossAction"
                    list-type="picture-card"
                    :multiple=true
                    :file-list="attrForm.fileList2"
                    :before-upload = "beforeupload2"
                    :on-remove = "remove2"
                    :http-request="uploadImg2"
                    >
                    <i class="el-icon-plus"></i>
                  </el-upload>
                </el-form-item>
                <el-form-item>
                  <el-button type="primary" @click="submitAttrForm('attrForm')" class="btn-24" style="margin-left: 30px;">保存</el-button>
                </el-form-item>
              </el-form>
            </div>
          </div>
        </div>
      </div> -->
      <!-- 作品属性弹窗-end -->
      <ysz-footer2></ysz-footer2>
  </div>
</body>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
<script src="/js/service/agent.js?v=2.1.6"></script>
<script src="/js/lib/vue.min.js"></script>
<!-- <script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script> -->
<script src="/js/lib/element/index.js"></script>
<script src="/js/common.js?v=3.9.2"></script>
<script src="/js/upload/record.js?v=1.2.1"></script>
<script type="text/javascript">
  var scrollTop = -1;
  $('.finish-wrap').mouseenter(function () {
      scrollTop = $(window).scrollTop();
  }).mouseleave(function () {
      scrollTop = -1;
  })//鼠标进入到区域后，则存储当前window滚动条的高度

  $(window).scroll(function () {
      scrollTop !== -1 && $(this).scrollTop(scrollTop);
  });// 鼠标进入到区域后，则强制window滚动条的高度
</script>
</html>
