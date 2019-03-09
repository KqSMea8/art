// 作品属性弹窗
/*jshint multistr: true */
Vue.component('artwork-attr-wrap', {
  template: '\
      <div class="maskWrap" v-show="maskseen" style="display: none">\
        <div class="mask" @click="closemaskSeen"></div>\
        <div v-show="finishseen" class="finish-wrap">\
          <div v-show="finishseen" class="finish anim-scale">\
            <h2>作品属性<em @click="closemaskSeen" title="关闭" >×</em></h2>\
            <div class="finished-box">\
              <el-form ref="attrForm" :model="attrForm" :rules="attrRules"  label-width="248px">\
                <el-form-item label="作品类型" prop="category">\
                  <el-select  class="w-350"\
                  v-model="attrForm.category"\
                  placeholder="添加类型标签，也可手动输入"\
                  multiple\
                  filterable\
                  allow-create\
                  :multiple-limit=\'5\'\
                  popper-class="change-sel2">\
                    <el-option\
                    v-for="item in categoryOptions"\
                    :label="item.value"\
                    :value="item.value"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item label="作品色调" prop="color">\
                  <el-select v-model="attrForm.color"\
                  multiple\
                  placeholder="画作的色调，最多可选2种" class="w-350"\
                  popper-class="change-sel2"\
                  :multiple-limit=\'2\'>\
                    <el-option\
                       v-for="item in colorOptions"\
                       :label="item.name"\
                       :value="\'\'+item.id"\
                       :style="\'background-color:\'+ item.color +\';color:#000\'">\
                     </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item label="作品形状" prop="shape">\
                  <el-select class="w-350" v-model="attrForm.shape" placeholder="请选择作品形状">\
                    <el-option\
                    v-for="item in shapeOptions"\
                    :label="item.value"\
                    :value="item.id"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item v-if="attrForm.shape == \'1\'" label="作品尺寸" >\
                 <el-col :span="6">\
                   <el-form-item  prop="length" >\
                      <el-input v-model="attrForm.length" class="w120" placeholder="长"></el-input>\
                    </el-form-item>\
                 </el-col>\
                 <el-col class="line tc" :span="2">x</el-col>\
                  <el-col :span="11">\
                    <el-form-item prop="width" >\
                    <el-input v-model="attrForm.width" class="w120" placeholder="宽"></el-input>\
                    <span class="finished-cm">cm</span>\
                    </el-form-item>\
                  </el-col>\
                </el-form-item>\
                <el-form-item v-if="attrForm.shape == \'2\'" label="作品尺寸" prop="diameter">\
                  <el-input v-model="attrForm.diameter" style="width: 286px" placeholder="直径"></el-input>\
                  <span class="finished-cm">cm</span>\
                </el-form-item>\
                <el-form-item label="创作年份" prop="artwork_date">\
                  <el-select class="w-350" v-model="attrForm.artwork_date" placeholder="请选择创作年份">\
                    <el-option\
                    v-for="item in yearOptions"\
                    :label="item"\
                    :value="item"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item label="作品题材" prop="subject">\
                  <el-select class="w-350" v-model="attrForm.subject"\
                  multiple\
                  filterable\
                  allow-create\
                  :multiple-limit=\'5\'\
                  popper-class="change-sel2"\
                  placeholder="添加题材标签，也可手动输入">\
                    <el-option\
                    v-for="item in subjectOptions"\
                    :label="item.value"\
                    :value="item.value"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item label="作品风格" prop="style">\
                  <el-select class="w-350" v-model="attrForm.style"\
                  multiple\
                  filterable\
                  allow-create\
                  :multiple-limit=\'5\'\
                  popper-class="change-sel2"\
                  placeholder="添加风格标签，也可手动输入">\
                    <el-option\
                    v-for="item in styleOptions"\
                    :label="item.value"\
                    :value="item.value"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item label="画作介绍" prop="story">\
                  <el-input type="textarea" class="w-350" v-model="attrForm.story" :autosize="{ minRows: 10, maxRows: 10}"  placeholder="简要描述画作初衷，不少于150字。共鸣者将通过它一眼相中你的画。"></el-input>\
                </el-form-item>\
                <el-form-item label="画作封面图" class=\'upload-pic1\'  prop="cover">\
                 <div class="word-tip" v-if="!attrForm.cover">作品封面图<br>（像素不低于1024*1024）<br>作品封面图，不含其它内容</div>\
                  <el-upload\
                    class="avatar-uploader"\
                    :action="ossAction"\
                    :show-file-list="false"\
                    :on-success="handleCoverSuccess"\
                    :before-upload="beforeCoverUpload"\
                    :http-request="uploadCover">\
                    <img v-if="attrForm.cover" :src="attrForm.cover" class="avatar">\
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>\
                  </el-upload>\
                </el-form-item>\
                <el-form-item label="画作全景图" class=\'upload-pic1\'  prop="fileList1">\
                 <div class="word-tip" v-show="beforeuploadShow1">作品全景图<br>（像素不低于1024*1024）<br>作品主图，不含其它内容</div>\
                  <el-upload\
                    :action="ossAction"\
                    list-type="picture-card"\
                    :multiple=true\
                    :file-list="attrForm.fileList1"\
                    :before-upload = "beforeupload1"\
                    :on-remove = "remove1" \
                    :http-request="uploadImg1"   \
                    >\
                    <i class="el-icon-plus"></i>\
                  </el-upload>\
                </el-form-item>\
                <el-form-item label="画作局部图" class=\'upload-pic2\'  prop="fileList2">\
                  <div class="word-tip" v-show="beforeuploadShow2">画作局部图<br>（像素不低于1024*1024）<br>作品局部细节，可上传多张</div>\
                  <el-upload\
                    :action="ossAction"\
                    list-type="picture-card"\
                    :multiple=true\
                    :file-list="attrForm.fileList2"\
                    :before-upload = "beforeupload2"\
                    :on-remove = "remove2"\
                    :http-request="uploadImg2"\
                    >\
                    <i class="el-icon-plus"></i>\
                  </el-upload>\
                </el-form-item>\
                <el-form-item>\
                  <el-button type="primary" @click="submitAttrForm(\'attrForm\')" class="btn-24" style="margin-left: 30px;">保存</el-button>\
                </el-form-item>\
              </el-form>   \
            </div> \
          </div>\
        </div>\
      </div>\
      ',
  data: function () {
    return {
      artID:'',//艺术品id
      ossAction: ossInfo.action,
      percent: 0,
      isSubmit: false,
      maskseen: false, //预览显示开关
      finishseen: false, //作品属性弹窗显示开关
      beforeuploadShow1: true, //上传全景图文字占位符显示开关
      beforeuploadShow2: true, //上传局部图文字占位符显示开关
      uploadloading: false,
      attrForm: {//规则字段
        category: [], //画作类型
        color: [], //画作色调
        shape: '', //形状        
        length:0,//画作长度
        width:0,//画作宽度
        diameter: 0, //直径
        artwork_date: '', //创作年份
        subject: '', //题材
        style: '', //风格
        story: '', //画作介绍
        cover: '', //画作封面图
        fileList1:[],//画作全景图
        fileList2:[]//画作局部图     
      },
      attrRules: {//字段规则
        category: [{
          // required: true,
          type: 'array',
          message: '请选择作品类型',
          trigger: 'change'
        }],
        color: [{   
          type: 'array',     
          message: '请填写画作色调',
          trigger: 'change'
        }],
        length: [
          // {
          //   required: false,
          //   type: 'number',
          //   message: '请输入长度值',
          //   trigger: 'blur'
          // },
          {
            pattern: /^[0-9]+\d*\.{0,1}(\d{1,2})?$/,
            message: '长度值输入有误'
          }
        ],
        width: [
          // {
          //   required: false,
          //   type: 'number',
          //   message: '请输入宽度值',
          //   trigger: 'blur'
          // },
          {
            pattern: /^[0-9]+\d*\.{0,1}(\d{1,2})?$/,
            message: '宽度值输入有误'
          }
        ],
        diameter: [
          // {
          //   required: false,
          //   type: 'number',
          //   message: '请输入画作直径',
          //   trigger: 'blur'
          // },
          {
            pattern: /^[0-9]+\d*\.{0,1}(\d{1,2})?$/,
            message: '画作直径输入有误'
          }
        ],
        fileList1: [{
          type: 'array',
          message: '请上传画作全景图', 
          trigger: 'change'      
        }],
        fileList2: [{
          type: 'array',
          message: '请上传画作局部图',   
          trigger: 'change'     
        }],
        desc: [{       
          message: '请输入画作简介',
          trigger: 'blur'
        }],
      },
      colorOptions:[{
          "color": "#e51f20",
          "name": "红色",
          "sort": 1,
          "id": "1"
        },
        {
          "color": "#ec8e2a",
          "name": "橘黄",
          "sort": 2,
          "id": "2"
        },
        {
          "color": "#eddb23",
          "name": "黄色",
          "sort": 3,
          "id": "3"
        },
        {
          "color": "#43c956",
          "name": "绿色",
          "sort": 4,
          "id": "4"
        },
        {
          "color": "#2f76e0",
          "name": "蓝色",
          "sort": 5,
          "id": "5"
        },
        {
          "color": "#c949d2",
          "name": "紫色",
          "sort": 6,
          "id": "6"
        },
        {
          "color": "#a1a1a1",
          "name": "灰色",
          "sort": 7,
          "id": "7"
        },
        {
          "color": "#ffffff,1b1b1b",
          "name": "黑白",
          "sort": 8,
          "id": "8"
        },
        {
          "color": "#ac6c25",
          "name": "褐色",
          "sort": 9,
          "id": "9"
        }

      ],//画作颜色
      shapeOptions: [{
        id: '1',
        value: '方形'
      },{
        id: '2',
        value: '圆形'
      }],//画作形状
      subjectOptions: [{
        value: '人物'
      },{
        value: '风景'
      },{
        value: '静物'
      },{
        value: '动物'
      },{
        value: '植物'
      },{
        value: '萌化'
      },{
        value: '宗教'
      },{
        value: '山水'
      },{
        value: '花鸟'
      },{
        value: '科幻'
      },{
        value: '动漫'
      }], //画作题材
      styleOptions: [{
        value: '具体'
      },{
        value: '抽象'
      },{
        value: '古典'
      },{
        value: '观念'
      },{
        value: '表现'
      }],
      yearOptions: [], //年份选项
      categoryOptions: [{
        "id": 1,
        "sort": 0,
        "value": "油画"
      }, {
        "id": 2,
        "sort": 5,
        "value": "水彩"
      }, {
        "id": 3,
        "sort": 10,
        "value": "插画"
      }, {
        "id": 4,
        "sort": 15,
        "value": "素描"
      }, {
        "id": 5,
        "sort": 20,
        "value": "工笔"
      }, {
        "id": 6,
        "sort": 25,
        "value": "国画"
      }, {
        "id": 7,
        "sort": 30,
        "value": "版画"
      }, {
        "id": 8,
        "sort": 35,
        "value": "漆画"
      }, {
        "id": 9,
        "sort": 40,
        "value": "丙烯"
      }], //画作类别选项
    };
  },
  created: function() {
    var that = this;
    //获取作品列表
    // 获取作品颜色分类
    // artzheAgent.call('Artwork/getArtworkColorConfig', {}, function(response) {
    //   if (response.data.status == 1000 && response.code == 30000) {
    //     that.colorOptions = response.data.info;
    //   } else {
    //     that.$message.error(response.code + ' : ' + response.message);
    //   }
    // });

    function initYears() {
      var startYear = 1990;//起始年份
      var endYear = new Date().getUTCFullYear();//结束年份，默认为当前年份
      var yearList = [];
      for (var i = startYear; i <= endYear; i++) {
        yearList.push(i);
      }
      return yearList;
    }
    this.yearOptions = initYears();
  },
  mounted: function() {
    eventBus.$on('showArtworkAttr', function(id, form) {
      this.showmaskSeen(id, form);
    }.bind(this));
  },
  methods: {
    showmaskSeen: function (id, form) {
      var that = this;
      this.artID = id;
      if (form.length) {
        form.length = form.length * 1;
      }
      if (form.width) {
        form.width = form.width * 1;
      }
      if (form.diameter) {
        form.diameter = form.diameter * 1;
      }
      this.attrForm = form;

      if (that.attrForm.fileList1.length > 0) {
        that.beforeuploadShow1 = false;
      }
      if (that.attrForm.fileList2.length > 0) {
        that.beforeuploadShow2 = false;
      }
      this.maskseen = true;
      this.finishseen = true;
    },
    closemaskSeen: function () {
      this.maskseen = false;
      this.finishseen = false;
    },
    submitAttrForm: function(formName) {
      var that = this;
      this.$refs[formName].validate(function(valid) {
        if (valid) {
          if (that.isUpload1 || that.isUpload2) {
            that.$message({
              message: '图片上传中，请稍后！'
            });
            return false;
          }
          var arr1 = [], arr2 = [];
          for (var i = 0; i < that.attrForm.fileList1.length; i++) {
            arr1[i] = that.attrForm.fileList1[i].url;
          }
          for (var i = 0; i < that.attrForm.fileList2.length; i++) {
            arr2[i] = that.attrForm.fileList2[i].url;
          }
          var data = {
              'artworkId': that.artID,
              // 'artworkName':that.form1.name,
              // "state": that.form1.permission,
              'category': that.attrForm.category.join(','),
              'color': that.attrForm.color.join(','),
              'shape': that.attrForm.shape,
              'subject': that.attrForm.subject.join(','),
              'style': that.attrForm.style.join(','),
              'story': that.attrForm.story,
              'cover': that.attrForm.cover,
              'panorama': arr1.join(','),
              'topography': arr2.join(','),
              'artwork_date': that.attrForm.artwork_date
          };
          if (that.attrForm.shape == '1') { //1.方形
            data.length =  that.attrForm.length;
            data.width =  that.attrForm.width;
          } else if (that.attrForm.shape == '2') {//2.圆形
            data.diameter = that.attrForm.diameter;
          }
          if (that.isSubmit) {
            return false;
          }
          that.isSubmit = true;

          artzheAgent.callMP('Artwork/addArtworkAttribute', data, 
            function(response) { //添加画作属性 
              that.isSubmit = false;
              if (response.data.status == 1000 && response.code == 30000) {
                that.$message({
                  message: '更新成功！',
                  type: 'success'
                });
                that.percent = response.data.percent;
                eventBus.$emit('updateAttr', that.percent, that.attrForm, that.artID);
                that.closemaskSeen();
              } else {
                that.$message.error(response.code + ' : ' + response.message);
              }
            },
            function() {
              that.isSubmit = false;
            }
          );
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    handlePictureCardPreview1: function(file) {
      this.dialogImageUrl1 = file.url;
      this.dialogVisible1 = true;
    },
    beforeCoverUpload: function(file) {
      var type = file.type.toUpperCase();
      if (type !== 'IMAGE/JPEG' && type !== 'IMAGE/PNG' && type !== 'IMAGE/JPG' && type !== 'IMAGE/BMP' && type !== 'IMAGE/GIF') {
        this.$message({
          message: '请上传图片'
        });
        return false;
      }
      this.uploadloading = true;
    },
    handleCoverSuccess: function(res, file) {
      if (res.success) {
        this.$message({
          message: '封面图片上传成功！',
          type: 'success'
        });
        this.attrForm.cover = ResHeader + res.path;
        this.$refs.attrForm.validateField('cover');
      } else {
        this.$message({
          message: '上传失败'
        });
      }
      this.uploadloading = false;
    },
    coverSuccess: function(file) {
      // body...
      this.$message({
        message: '封面图片上传成功！',
        type: 'success'
      });
      this.attrForm.cover = file.url;
      this.uploadloading = false;
    },
    uploadCover: function(options) {
      var that = this;
      var reData = ossObj.set_upload_param(options.file.name);
      options.data = reData;
      options.file.url = options.action + '/' + options.data.key;
      // 检查是否支持FormData　
      if (window.FormData) {　　　　　
        var formData = new FormData();　　　　 // 建立一个upload表单项，值为上传的文件
        for (var i in options.data) {
          formData.append(i, options.data[i]);
        }　　　　
        formData.append('file', options.file);　　　
        var xhr = new XMLHttpRequest();　
        xhr.open('POST', options.action);　　　　 // 定义上传完成后的回调函数　　　
        xhr.onload = function() {　　　　　　
          if (xhr.status === 200) {　　　　　　　　
            that.coverSuccess(options.file);
          } else {　　　　　　　　
            that.$message({
              message: '上传失败'
            });　　　　　　
          }　　　　
        };　　　　
        xhr.send(formData);　　
      }
    },
    handlePictureCardPreview2: function(file) {
      this.dialogImageUrl2 = file.url;
      this.dialogVisible2 = true;
    },
    beforeupload1: function(file) {
      var type = file.type.toUpperCase();
      if (type !== 'IMAGE/JPEG' && type !== 'IMAGE/PNG' && type !== 'IMAGE/JPG' && type !== 'IMAGE/BMP' && type !== 'IMAGE/GIF') {
        this.$message({
          message: '请上传图片'
        });
        return false;
      }
      var that = this;
      this.isUpload = true;
      this.beforeuploadShow1 = false;
    },
    beforeupload2: function(file) {
      var type = file.type.toUpperCase();
      if (type !== 'IMAGE/JPEG' && type !== 'IMAGE/PNG' && type !== 'IMAGE/JPG' && type !== 'IMAGE/BMP' && type !== 'IMAGE/GIF') {
        this.$message({
          message: '请上传图片'
        });
        return false;
      }
      var that = this;
      this.isUpload = true;
      this.beforeuploadShow2 = false;
      // // set_upload_param(file.name);
      // var reData = ossObj.set_upload_param(file.name);
      // return new Promise(function (resolve, reject) {//解决beforeUpload中修改data和action不会在请求中生效
      //   that.uploadData = reData;         
      //   resolve(true)
      // })
    },
    uploadImg1: function(options) {
      var that = this;
      var reData = ossObj.set_upload_param(options.file.name);
      options.data = reData;
      options.file.url = options.action + '/' + options.data.key;
      // 检查是否支持FormData　
      if (window.FormData) {　　　　　
        var formData = new FormData();　　　　 // 建立一个upload表单项，值为上传的文件
        for (var i in options.data) {
          formData.append(i, options.data[i]);
        }　　　　
        formData.append('file', options.file);
        console.log(formData);　　　　
        var xhr = new XMLHttpRequest();

        if (xhr.upload) {
          xhr.upload.onprogress = function progress(e) {
            if (e.total > 0) {
              e.percent = e.loaded / e.total * 100;
            }
            options.onProgress(e);
          };
        }　
        xhr.open('POST', options.action);　　　　 // 定义上传完成后的回调函数　　　
        xhr.onload = function() {　　　　　　
          if (xhr.status === 200) {　　　　　　　　
            that.success(options.file, that.attrForm.fileList1);
          } else {　　　　　　　　
            console.log('出错了');　　　　　　
          }　　　　
        };　　　　
        xhr.send(formData);　　
      }
    },
    uploadImg2: function(options) {
      var that = this;
      var reData = ossObj.set_upload_param(options.file.name);
      options.data = reData;
      options.file.url = options.action + '/' + options.data.key;
      // 检查是否支持FormData　
      if (window.FormData) {　　　　　
        var formData = new FormData();　　　　 // 建立一个upload表单项，值为上传的文件
        for (var i in options.data) {
          formData.append(i, options.data[i]);
        }　　　　
        formData.append('file', options.file);
        console.log(formData);　　　　
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {
          xhr.upload.onprogress = function progress(e) {
            if (e.total > 0) {
              e.percent = e.loaded / e.total * 100;
            }
            options.onProgress(e);
          };
        }　
        xhr.open('POST', options.action);　　　　 // 定义上传完成后的回调函数　　　
        xhr.onload = function() {　　　　　　
          if (xhr.status === 200) {　　　　　　　　
            that.success(options.file, that.attrForm.fileList2);
          } else {　　　　　　　　
            console.log('出错了');　　　　　　
          }　　　　
        };　　　　
        xhr.send(formData);　　
      }
    },
    success: function(file,fileList) {
      var that = this;
      this.isUpload = false;
      var item = {};
      item.url = file.url;
      item.uid = file.uid;
      fileList.push(item);
    },
    remove1: function(file, fileList) {
      var that = this;
      this.attrForm.fileList1 = fileList.map(function(item) {
        if (item.response) {
          var a = {};
          a.url = ResHeader + item.response.path;
          that.$refs.attrForm.validateField('fileList1');
          return a;
        } else {
          return item;
        }
      });
      if (this.attrForm.fileList1.length == 0) {
        setTimeout(function() {
          that.beforeuploadShow1 = true;
        }, 700);
      }
    },
    remove2: function(file, fileList) {
      var that = this;
      if (fileList.length == 0) {
        setTimeout(function() {
          that.beforeuploadShow2 = true;
        }, 700);
      }
      this.attrForm.fileList2 = fileList.map(function(item) {
        if (item.response) {
          var a = {};
          a.url = ResHeader + item.response.path;
          return a;
        } else {
          return item;
        }
      });
    }
  }
});

// 提醒完善作品属性弹窗
Vue.component('goto-attr-wrap', {
  template: '\
      <div v-cloak v-show="maskseen" class="layerbox layermshow">\
        <div @click="closeGoodsSeen" class="layershade"></div>\
        <div class="layermain">\
          <div class="thirdLayerIn anim-scale message-box" id="remind">\
            <h2>温馨提示<em @click="closeGoodsSeen" title="关闭" >×</em></h2>\
            <div class="content">\
              <p class="aboutContent">作品属性完整度100%，才可加入原作交易。</p>\
            </div>\
            <div class="btn-group">\
              <a class="btn" @click="showArtworkAttr" href="javascript:;">完善作品属性</a>\
            </div>\
          </div>\
        </div>\
      </div>\
      ',
  data: function () {
    return {
      id: '', //画作id
      attrForm: {//规则字段
        category: [], //画作类型
        color: [], //画作色调
        shape: '', //形状        
        length:'',//画作长度
        width:'',//画作宽度
        diameter: '', //直径
        artwork_date: '', //创作年份
        subject: '', //题材
        style: '', //风格
        story: '', //画作介绍
        cover: '', //画作封面图
        fileList1:[],//画作全景图
        fileList2:[]//画作局部图     
      },
      maskseen: false,
    };
  },
  created: function() {
    
  },
  mounted: function() {
    eventBus.$on('gotoAddAttr', function(id) {
      this.showGoodsSeen(id);
    }.bind(this));
  },
  methods: {
    showGoodsSeen: function (id) {
      this.maskseen = true;
      this.id = id;
      this.getArtworkAttr();
    },
    closeGoodsSeen: function () {
      this.maskseen = false;
    },
    getArtworkAttr: function () {
      var that = this;
      artzheAgent.callMP('Artwork/getAttributePercent',{"artworkId":that.id}, function (res2) {
        var resInfo = res2.data.info;
        that.attrForm.artwork_date = resInfo.artwork_date ? resInfo.artwork_date : new Date().getUTCFullYear();
        that.attrForm.category = resInfo.category ? resInfo.category.split(",") : [];
        that.attrForm.subject = resInfo.subject ? resInfo.subject.split(",") : [];
        that.attrForm.style = resInfo.style ? resInfo.style.split(",") : [];
        that.attrForm.story = resInfo.story;
        that.attrForm.cover = resInfo.cover;

        if (resInfo.shape == '1') { //方形
          that.attrForm.shape = '1';
          that.attrForm.length =  resInfo.length != '0' ? resInfo.length : '';
          that.attrForm.width =  resInfo.width != '0' ? resInfo.width : '';
        } else if (resInfo.shape == '2') { //圆形
          that.attrForm.shape = '2';
          that.attrForm.diameter =  resInfo.diameter != '0' ? resInfo.diameter : '';
        } else { //未选择作品形状
          that.attrForm.shape = '';
        }
        that.attrForm.color = resInfo.color_ids.map(function (item) {
          return item.id;
        });
        that.attrForm.story = resInfo.story;

        function arrFun(arr) {
          var list = arr.map(function (item) {
            var a = {};
            a.url = item;
            return a;
          });
          return list;
        }
        that.attrForm.fileList1 = arrFun(resInfo.panorama_ids); //全景图
        that.attrForm.fileList2 = arrFun(resInfo.topography_ids); //局部图
      });
    },
    showArtworkAttr: function () {
      this.closeGoodsSeen();
      eventBus.$emit('showArtworkAttr', this.id, this.attrForm);
    }
  }
});

// 完善作品属性弹窗

// 编辑商品属性弹窗
Vue.component('goods-attr-wrap', {
  template: '\
      <div class="maskWrap" v-show="maskseen" style="display: none">\
        <div class="mask" @click="closeGoodsSeen"></div>\
        <div v-show="maskseen" class="finish-wrap">\
          <div v-show="maskseen" class="finish anim-scale">\
            <h2>交易属性<em @click="closeGoodsSeen" title="关闭" >×</em></h2>\
            <div class="finished-box">\
              <el-form ref="attrForm" :model="attrForm" :rules="attrRules"  label-width="248px">\
                <el-form-item label="作品价格" prop="price">\
                  <el-input v-model.number="attrForm.price" type="number" class="w-350" placeholder="请输入作品价格"></el-input>\
                  <span class="finished-cm">元</span>\
                </el-form-item>\
                <el-form-item label="作品包装" prop="is_mount">\
                  <el-select class="w-350" v-model="attrForm.is_mount" placeholder="是否装裱">\
                    <el-option\
                    v-for="item in mountOptions"\
                    :label="item.value"\
                    :value="item.id"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item label="收藏证书" prop="is_collect">\
                  <el-select class="w-350" v-model="attrForm.is_collect" placeholder="是否有收藏证书">\
                    <el-option\
                    v-for="item in collectOptions"\
                    :label="item.value"\
                    :value="item.id"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item label="是否包邮" prop="is_shipping">\
                  <el-select class="w-350" v-model="attrForm.is_shipping" placeholder="是否包邮">\
                    <el-option\
                    v-for="item in shippingOptions"\
                    :label="item.value"\
                    :value="item.id"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item v-if="attrForm.is_shipping == \'0\'" label="快递费用" prop="shipping_fee">\
                  <el-input class="w-350" v-model.number="attrForm.shipping_fee" type="number" placeholder="请输入快递费用"></el-input>\
                  <span class="finished-cm">元</span>\
                </el-form-item>\
                <el-form-item>\
                  <div class="btn-group">\
                    <button type="button" @click="submitAttrForm(\'attrForm\')" class="btn-submit">保存</button>\
                  </div>\
                </el-form-item>\
              </el-form>\
            </div> \
          </div>\
        </div>\
      </div>\
      ',
  data: function () {
    return {
      maskseen: false,
      id: '', //artwork_id
      attrForm: {//属性表
        price: '', //价格 
        is_mount: '', //是否装裱
        is_collect: '', //是否收藏    
        is_shipping: '', //是否包邮
        shipping_fee: '', //运费
        fileList1:[],//画作全景图
        fileList2:[]//画作局部图     
      },
      attrRules: {//字段规则
        price: [{
          required: true,
          type: 'number',
          message: '请输入作品价格'
          // trigger: 'blur'
        }, {
            pattern: /^[0-9]+\d*\.{0,1}(\d{1,2})?$/,
            message: '作品价格输入有误'
        }],
        is_mount: [{   
          required: true,     
          message: '请选择作品包装',
          // trigger: 'change'
        }],
        is_collect: [{   
          required: true,     
          message: '请选择是否有收藏证书',
          // trigger: 'change'
        }],
        is_shipping: [{   
          required: true,     
          message: '请选择是否包邮',
          // trigger: 'change'
        }],
        shipping_fee: [{
          type: 'number',
          message: '请输入运费金额',
          // trigger: 'blur'
        }, {
            // pattern: /^[1-9]+\d*$/,
            pattern: /^[0-9]+\d*\.{0,1}(\d{1,2})?$/,
            message: '作品价格输入有误'
        }]
        // fileList1: [{
        //   type: 'array',
        //   message: '请上传画作全景图', 
        //   trigger: 'change'      
        // }],
        // fileList2: [{
        //   type: 'array',
        //   message: '请上传画作局部图',   
        //   trigger: 'change'     
        // }],
      },
      mountOptions: [
        {id: '1',value: '已装裱'},
        {id: '0',value: '未装裱'}
      ],
      collectOptions: [
        {id: '1',value: '有收藏证书'},
        {id: '0',value: '无收藏证书'}
      ],
      shippingOptions: [
        {id: '1',value: '包邮'},
        {id: '0',value: '不包邮'}
      ],
      isSubmit: false
    };
  },
  created: function() {
    
  },
  mounted: function() {
    eventBus.$on('addGoodAttr', function(id) {
      this.showGoodsSeen(id);
    }.bind(this));
  },
  methods: {
    submitAttrForm: function(formName) {
      var that = this;
      this.$refs[formName].validate(function(valid) {
        if (valid) {
          var data = {
              artwork_id: that.id,
              price: that.attrForm.price, //价格 
              is_mount: that.attrForm.is_mount, //是否装裱
              is_collect: that.attrForm.is_collect, //是否收藏    
              is_shipping: that.attrForm.is_shipping, //是否包邮
          };
          if (that.attrForm.is_shipping == '1') { //包邮

          } else if (that.attrForm.is_shipping == '0') { //不包邮
            data.shipping_fee = that.attrForm.shipping_fee;
          }

          if (that.isSubmit) {
            return false;
          }
          that.isSubmit = true;

          artzheAgent.callMP('Artwork/AddToMall', data, 
            function(response) { //添加画作属性 
              that.isSubmit = false;
              that.closeGoodsSeen();
              if (response.data.status == 1000 && response.code == 30000) {
                that.$message({
                  message: '更新成功！',
                  type: 'success'
                });
                eventBus.$emit('updateGoodsList', data);

              } else {
                that.$message.error(response.code + ' : ' + response.message);
              }
            },
            function() {
              that.isSubmit = false;
            }
          );
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    showGoodsSeen: function (id) {
      this.resetForm('attrForm');
      this.maskseen = true;
      this.id = id;
    },
    closeGoodsSeen: function () {
      this.maskseen = false;
    },
    resetForm: function(formName) {
      this.$refs[formName].resetFields();
    },
    clearNoNum: function (val){
      val = val.toString();
      val = val.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符   
      val = val.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的   
      val = val.replace(".","$#$").replace(/\./g,"").replace("$#$","."); 

      // val = val.replace(/^(\d\d\d\d\d\d\d).(\d\d)*$/,'$1.$2');//小数点前最多7位 
      val = val.replace(/^(\d{7}).(\d\d)*$/,'$1.$2');//小数点前最多7位 

      val = val.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数   

      if(val.indexOf(".")< 0 && val !=""){ //以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额  
        val= parseFloat(val); 
      }
      return val;
    }
  }
});

// 作品列表
Vue.component('artwork-list', {
  template: '\
      <div class="artwork-wrap">\
        <ul class="artwork-list" v-if="artworkInfo.list.length >= 1" v-loading.body="isLoading">\
          <li v-for="item in artworkInfo.list" class="artwork-item">\
            <div class="art-info">\
              <img :src="item.cover ? item.cover: \'https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/bgadd.png?x-oss-process=image/resize,m_fill,h_80,w_80\'" class="cover">\
              <div class="detail">\
                <h3>{{item.name}}</h3>\
                <p>更新{{item.update_times}}次创作花絮</p>\
                <p>{{item.finish_percent}}%作品属性完整度</p>\
              </div>\
            </div>\
            <div class="sell-wrap">\
              <div v-if="item.is_mall_sale == 1" class="sell-info-wrap">\
                <div class="sell-info">\
                  <h3>￥{{item.price}}</h3>\
                  <ul>\
                    <li>\
                      <i :class="[\'icons\', item.is_mount == \'1\' ? \'icon-yes\':\'icon-no\']"></i>\
                      <span v-if="item.is_mount == \'1\'">已装裱</span>\
                      <span v-else>未装裱</span>\
                    </li>\
                    <li>\
                      <i :class="[\'icons\', item.is_collect == \'1\' ? \'icon-yes\':\'icon-no\']"></i>\
                      <span v-if="item.is_collect == \'1\'">有收藏证书</span>\
                      <span v-else>无收藏证书</span>\
                    </li>\
                    <li>\
                      <i :class="[\'icons\', item.is_shipping == \'1\'? \'icon-yes\':\'icon-no\']"></i>\
                      <span v-if="item.is_shipping == \'1\'">包邮</span>\
                      <span v-else>快递：{{item.shipping_fee}}元</span>\
                    </li>\
                  </ul>\
                </div>\
                <div v-if="item.review_code == 3" class="to-edit">\
                  <a target="_blank" :href=item.href class="icons icon-edit"></a>\
                </div>\
                <div v-if="item.review_code == 2" class="to-edit">\
                  <p class="err">审核失败</p>\
                  <a target="_blank" :href=item.href class="btn-edit">重新编辑</a>\
                </div>\
                <div v-if="item.review_code == 1" class="to-edit">\
                  <p class="remark">审核中...</p>\
                </div>\
              </div>\
              <div v-else class="btn-group">\
                <div @click="showGoodsSeen(item.id, item.finish_percent)" class="btn-add">加入原作交易</div>\
              </div>\
            </div>\
          </li>\
        </ul>\
        <div class="artwork-holder" v-if="!isLoading && artworkInfo.total == 0">\
          <img class="holder" src="https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/ico_holder.png">\
          <p>您还未添加过新作品，快来试试吧！</p>\
          <div class="btn-group">\
            <a class="btn btn-edit" href="/upload/addartwork">添加新作品</a>\
          </div>\
        </div>\
        <div class="upload-page el-pagination" v-if="artworkInfo.maxpage > 1">\
          <button type="button"  :class="[ artworkInfo.page == 1 ? \'disabled\' : \'\',\'btn-prev\']" @click="pagePrev()" >&lt;</button>\
          <span class="upload-num" >{{artworkInfo.page}}/{{artworkInfo.maxpage}}</span>\
          <button type="button" :class="[ artworkInfo.page == artworkInfo.maxpage ? \'disabled\' : \'\',\'btn-next\']" @click="pageNext()" >&gt;</button>\
          <span class="el-pagination__jump "><input type="number" min="1" number="true" v-model="inputpage" class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="gotoPage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>\
        </div>\
      </div>\
      ',
  data: function () {
    return {
      isLoading: false,
      artworkInfo: {
        list: [
        ],
        page: 1,
        pagesize:5,
        maxpage:1,
        total: -1
      },
      inputpage: ''
    };
  },
  created: function() {
    this.getData();
  },
  mounted: function() {
    eventBus.$on('updateGoodsList', function(data) {
      this.updateGoodsList(data);
    }.bind(this));
    eventBus.$on('updateAttr', function(percent, form, id) {
      this.updateAttr(percent, form, id);
    }.bind(this));
  },
  methods: {
    pagePrev: function () {
      if (this.artworkInfo.page <= 1) return;
      this.getData(--this.artworkInfo.page);
    },
    pageNext: function () {
      if (this.artworkInfo.page >= this.artworkInfo.maxpage) return;
      this.getData(++this.artworkInfo.page);
    },
    gotoPage: function () { 
      if (this.inputpage > this.artworkInfo.maxpage || this.inputpage < 1) {
        this.$message({
          message: '请输入正确的页码'
        });
        return false;
      }
      this.getData(this.inputpage);
    },
    getData: function (page) {
      var that = this;
      var data = {
        page: page ? page : 1,
        pagesize: 5
      };
      that.isLoading = true;
      artzheAgent.callMP('Artwork/MallArtworkList', data, function(response) {
        that.isLoading = false;
        var resInfo = response.data.info;
        if (response.data.status == 1000 && response.code == 30000) {
          if (resInfo.page == 1 && resInfo.list.length == 0) {
            
          }
          resInfo.list.forEach(function(item) {
            item.href = switchDomin('mall') + '/seller/relocation.php?redirect=' + encodeURIComponent(switchDomin('mall') + '/seller/goods_simple_edit.php?act=edit&goods_id=' + item.goods_id + '&extension_code=');
            // item.href = 'http://test-mall.artzhe.com/seller/relocation.php?redirect=' + switchDomin('mall') + '/seller/goods_simple_edit.php?act=edit&goods_id=' + item.goods_id + '&extension_code='
            // item.href = 'http://test-mp.artzhe.com/test.php?goods_id=' + item.goods_id;
          });

          that.artworkInfo = resInfo;
        }
      }, function(res) {
        that.isLoading = false;
      });
    },
    showGoodsSeen: function (id, percent) {
      if (percent >= 100) {
        eventBus.$emit('addGoodAttr', id);
      } else {
        eventBus.$emit('gotoAddAttr', id);
      }
    },
    updateGoodsList: function (data) {
      for (var i = 0; i < this.artworkInfo.list.length; i++) {
        if (this.artworkInfo.list[i].id == data.artwork_id) {
          Vue.set(this.artworkInfo.list[i], "price", data.price);
          Vue.set(this.artworkInfo.list[i], "is_mount", data.is_mount);
          Vue.set(this.artworkInfo.list[i], "is_collect", data.is_collect);
          Vue.set(this.artworkInfo.list[i], "is_shipping", data.is_shipping);
          Vue.set(this.artworkInfo.list[i], "shipping_fee", data.shipping_fee);
          Vue.set(this.artworkInfo.list[i], "review_code", "1");
          Vue.set(this.artworkInfo.list[i], "is_mall_sale", 1);
          break;
        }
      }
    },
    updateAttr: function (percent, form, id) {
      for (var i = 0; i < this.artworkInfo.list.length; i++) {
        if (this.artworkInfo.list[i].id == id) {
          Vue.set(this.artworkInfo.list[i], "finish_percent", percent);
          break;
        }
      }
    }
  }
});

// 通过作品列表
Vue.component('pass-list', {
  template: '\
      <div class="artwork-wrap">\
        <ul class="artwork-list" v-loading.body="isLoading">\
          <li v-if="artworkInfo.list.length >= 1" v-for="item in artworkInfo.list" class="artwork-item">\
            <div class="art-info">\
              <img :src="item.cover ? item.cover: \'https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/bgadd.png?x-oss-process=image/resize,m_fill,h_80,w_80\'" class="cover">\
              <div class="detail">\
                <h3>{{item.name}}</h3>\
                <p>更新{{item.update_times}}次创作花絮</p>\
                <p>{{item.finish_percent}}%作品属性完整度</p>\
              </div>\
            </div>\
            <div class="sell-wrap">\
              <div v-if="item.is_mall_sale == 1" class="sell-info-wrap">\
                <div class="sell-info">\
                  <h3>￥{{item.price}}</h3>\
                  <ul>\
                    <li>\
                      <i :class="[\'icons\', item.is_mount == \'1\' ? \'icon-yes\':\'icon-no\']"></i>\
                      <span v-if="item.is_mount == \'1\'">已装裱</span>\
                      <span v-else>未装裱</span>\
                    </li>\
                    <li>\
                      <i :class="[\'icons\', item.is_collect == \'1\' ? \'icon-yes\':\'icon-no\']"></i>\
                      <span v-if="item.is_collect == \'1\'">有收藏证书</span>\
                      <span v-else>无收藏证书</span>\
                    </li>\
                    <li>\
                      <i :class="[\'icons\', item.is_shipping == \'1\'? \'icon-yes\':\'icon-no\']"></i>\
                      <span v-if="item.is_shipping == \'1\'">包邮</span>\
                      <span v-else>快递：{{item.shipping_fee}}元</span>\
                    </li>\
                  </ul>\
                </div>\
                <div v-if="item.review_code == 3" class="to-edit">\
                  <a target="_blank" :href=item.href class="icons icon-edit"></a>\
                </div>\
                <div v-if="item.review_code == 2" class="to-edit">\
                  <p class="err">审核失败</p>\
                  <a target="_blank" :href=item.href class="btn-edit">重新编辑</a>\
                </div>\
                <div v-if="item.review_code == 1" class="to-edit">\
                  <p class="remark">审核中...</p>\
                </div>\
              </div>\
              <div v-else class="btn-group">\
                <div @click="showGoodsSeen(item.id, item.finish_percent)" class="btn-add">加入原作交易</div>\
              </div>\
            </div>\
          </li>\
        </ul>\
        <div class="upload-page el-pagination" v-if="artworkInfo.maxpage > 1">\
          <button type="button"  :class="[ artworkInfo.page == 1 ? \'disabled\' : \'\',\'btn-prev\']" @click="pagePrev()" >&lt;</button>\
          <span class="upload-num" >{{artworkInfo.page}}/{{artworkInfo.maxpage}}</span>\
          <button type="button" :class="[ artworkInfo.page == artworkInfo.maxpage ? \'disabled\' : \'\',\'btn-next\']" @click="pageNext()" >&gt;</button>\
          <span class="el-pagination__jump "><input type="number" min="1" number="true" v-model="inputpage" class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="gotoPage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>\
        </div>\
      </div>\
      ',
  data: function () {
    return {
      isLoading: false,
      artworkInfo: {
        list: [
        ],
        page: 1,
        pagesize:5,
        maxpage:1
      },
      inputpage: '',
      
      
    };
  },
  created: function() {
    this.getData();
  },
  mounted: function() {
    
    eventBus.$on('updateGoodsList', function(data) {
      this.updateGoodsList(data);
    }.bind(this));
    eventBus.$on('updateAttr', function(percent, form, id) {
      this.updateAttr(percent, form, id);
    }.bind(this));
  },
  methods: {
    pagePrev: function () {
      if (this.artworkInfo.page <= 1) return;
      this.getData(--this.artworkInfo.page);
    },
    pageNext: function () {
      if (this.artworkInfo.page >= this.artworkInfo.maxpage) return;
      this.getData(++this.artworkInfo.page);
    },
    gotoPage: function () { 
      if (this.inputpage > this.artworkInfo.maxpage || this.inputpage < 1) {
        this.$message({
          message: '请输入正确的页码'
        });
        return false;
      }
      this.getData(this.inputpage);
    },
    getData: function (page) {
      var that = this;
      var data = {
        page: page ? page : 1,
        pagesize: 5,
        type: 'pass'
      };
      that.isLoading = true;
      artzheAgent.callMP('Artwork/MallArtworkList', data, function(response) {
        that.isLoading = false;
        var resInfo = response.data.info;
        if (response.data.status == 1000 && response.code == 30000) {
          if (resInfo.page == 1 && resInfo.list.length == 0) {
            
          }
          resInfo.list.forEach(function(item) {
            item.href = switchDomin('mall') + '/seller/relocation.php?redirect=' + encodeURIComponent(switchDomin('mall') + '/seller/goods_simple_edit.php?act=edit&goods_id=' + item.goods_id + '&extension_code=');
            // item.href = 'http://test-mall.artzhe.com/seller/relocation.php?redirect=' + switchDomin('mall') + '/seller/goods_simple_edit.php?act=edit&goods_id=' + item.goods_id + '&extension_code='
            // item.href = 'http://test-mp.artzhe.com/test.php?goods_id=' + item.goods_id;
          });

          that.artworkInfo = resInfo;
        }
      }, function(res) {
        that.isLoading = false;
      });
    },
    showGoodsSeen: function (id, percent) {
      if (percent >= 100) {
        eventBus.$emit('addGoodAttr', id);
      } else {
        eventBus.$emit('gotoAddAttr', id);
      }
    },
    updateGoodsList: function (data) {
      for (var i = 0; i < this.artworkInfo.list.length; i++) {
        if (this.artworkInfo.list[i].id == data.artwork_id) {
          Vue.set(this.artworkInfo.list[i], "price", data.price);
          Vue.set(this.artworkInfo.list[i], "is_mount", data.is_mount);
          Vue.set(this.artworkInfo.list[i], "is_collect", data.is_collect);
          Vue.set(this.artworkInfo.list[i], "is_shipping", data.is_shipping);
          Vue.set(this.artworkInfo.list[i], "shipping_fee", data.shipping_fee);
          Vue.set(this.artworkInfo.list[i], "review_code", "1");
          Vue.set(this.artworkInfo.list[i], "is_mall_sale", 1);
          break;
        }
      }
    },
    updateAttr: function (percent, form, id) {
      for (var i = 0; i < this.artworkInfo.list.length; i++) {
        if (this.artworkInfo.list[i].id == id) {
          Vue.set(this.artworkInfo.list[i], "finish_percent", percent);
          break;
        }
      }
    }
  }
});


var vmApp = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    active: 0,
    currentView: 'artwork-list',
    tabs: [{
      type: '全部作品',
      view: 'artwork-list'
    }, {
      type: '已加入交易',
      view: 'pass-list'
    }],
    activeId: '',
    artworkInfo: {
      list: [
      ],
      page: 1,
      pagesize:5,
      maxpage:1
    },
    inputpage: '',
    goodsInfo: {
      list: [],
      page: 1,
      pagesize:5,
      maxpage:1
    }
  },
  created: function() {
    
  },
  mounted: function () {
    this.getsyc();
  },
  methods: {
    toggle: function (index, view) {
      this.active = index;
      this.currentView = view;
    },
    getsyc:function(){
      $.ajax({
        url:switchDomin('mall') + '/seller/relocation.php?redirect=' + encodeURIComponent(switchDomin('mall') + '/seller/privilege.php?act=signin&az_from=mpartzhe'),
        type:'get',
        dataType:'html',
        success:function(data){},
        error:function(err){}
      })
    }
  }
});