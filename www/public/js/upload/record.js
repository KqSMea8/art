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
                <el-form-item label="作品名称" prop="name">\
                  <el-input v-model="attrForm.name" class="w-350" placeholder="修改作品名称"></el-input>\
                </el-form-item>\
                <el-form-item label="作品权限" prop="state">\
                  <el-select class="w-350" v-model="attrForm.state" placeholder="权限选择">\
                    <el-option\
                    v-for="item in stateOptions"\
                    :label="item.value"\
                    :value="item.id"\
                    >\
                    </el-option>\
                  </el-select>\
                </el-form-item>\
                <el-form-item label="画作系列">\
                  <el-select class="w-350" v-model="attrForm.series_id" placeholder="画作选择">\
                    <el-option\
                    v-for="item in seriesOption"\
                    :label="item.name"\
                    :value="item.id"\
                    >\
                    </el-option>\
                  </el-select>\
                  <el-button type="primary" @click="seriesDia = true" class="seriesbtn" style="margin-left: 30px;">新建系列</el-button>\
                </el-form-item>\
                <el-form-item label="作品类型" prop="category">\
                  <el-select  class="w-350"\
                  v-model="attrForm.category"\
                  placeholder="添加类型标签，也可手动输入"\
                  multiple\
                  filterable\
                  allow-create\
                  :multiple-limit=\'5\'\
                  @visible-change="notspace(attrForm.category,\'attrForm.category\')"\
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
                       :style="item.style">\
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
                <el-form-item  v-if="attrForm.shape == \'1\'" label="作品尺寸" class="height36">\
                 <el-col :span="6">\
                   <el-form-item  prop="length">\
                      <el-input v-model.number="attrForm.length" type="text" maxlength="4" class="w120" placeholder="长"></el-input>\
                    </el-form-item>\
                 </el-col>\
                 <el-col class="line tc" :span="2">x</el-col>\
                  <el-col :span="11">\
                    <el-form-item prop="width" >\
                    <el-input v-model.number="attrForm.width" type="text" maxlength="4" class="w120" placeholder="宽"></el-input>\
                    <span class="finished-cm">cm</span>\
                    </el-form-item>\
                  </el-col>\
                </el-form-item>\
                <el-form-item v-if="attrForm.shape == \'2\'" label="作品尺寸" prop="diameter" class="height36">\
                  <el-input v-model.number="attrForm.diameter" type="text" maxlength="4" style="width: 286px" placeholder="直径"></el-input>\
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
                  @visible-change="notspace(attrForm.subject,\'attrForm.subject\')"\
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
                  @visible-change="notspace(attrForm.style,\'attrForm.style\')"\
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
                  <el-input type="textarea" class="w-350" v-model="attrForm.story" :autosize="{ minRows: 10, maxRows: 10}" placeholder="简要描述画作初衷，共鸣者将通过它一眼相中你的画。(150字内)"></el-input>\
                </el-form-item>\
                <el-form-item label="画作封面图" class=\'upload-pic1\'  prop="cover">\
                 <div class="word-tip" v-if="!attrForm.cover">作品封面图<br>上传格式:JPG,JPEG,GIF,PNG</div>\
                  <el-upload\
                    class="avatar-uploader"\
                    :action="ossAction"\
                    :show-file-list="false"\
                    :on-success="handleCoverSuccess"\
                    :before-upload="beforeCoverUpload"\
                    :http-request="uploadCover">\
                    <img v-if="attrForm.cover" :src="attrForm.cover" class="avatar">\
                    <i v-else class="el-icon-plus avatar-uploader-icon self-upload-icon"></i>\
                  </el-upload>\
                  <p class="uploadpictrip" style="bottom:-28px;">注意查看预览图，按照规范去上传作品，这样有助于让您的作品置顶推荐哦~~</p>\
                  <div class="imgExample" @click="showyulan(1)">\
                    <p>预览图</p>\
                  </div>\
                </el-form-item>\
                <el-form-item label="画作全景图" class=\'upload-pic1\'  prop="fileList1">\
                 <div class="word-tip" v-show="beforeuploadShow1">作品全景图<br>上传格式:JPG,JPEG,GIF,PNG</div>\
                  <el-upload\
                    :action="ossAction"\
                    list-type="picture-card"\
                    :multiple=true\
                    :file-list="attrForm.fileList1"\
                    :before-upload = "beforeupload1"\
                    :on-remove = "remove1" \
                    :http-request="uploadImg1"   \
                    >\
                    <i class="el-icon-plus self-upload-icon"></i>\
                  </el-upload>\
                  <p class="uploadpictrip">注意查看预览图，按照规范去上传作品，这样有助于让您的作品置顶推荐哦~~</p>\
                  <div class="imgExample" @click="showyulan(2)">\
                    <p>预览图</p>\
                  </div>\
                </el-form-item>\
                <el-form-item label="画作局部图" class=\'upload-pic2\' style="margin-bottom: 50px;" prop="fileList2">\
                  <div class="word-tip" v-show="beforeuploadShow2">画作局部图<br>作品局部细节，可上传多张<br>上传格式:JPG,JPEG,GIF,PNG</div>\
                  <el-upload\
                    :action="ossAction"\
                    list-type="picture-card"\
                    :multiple=true\
                    :file-list="attrForm.fileList2"\
                    :before-upload = "beforeupload2"\
                    :on-remove = "remove2"\
                    :http-request="uploadImg2"\
                    >\
                    <i class="el-icon-plus self-upload-icon"></i>\
                  </el-upload>\
                  <p class="uploadpictrip">注意查看预览图，按照规范去上传作品，这样有助于让您的作品置顶推荐哦~~</p>\
                  <div class="imgExample" @click="showyulan(3)">\
                    <p>预览图</p>\
                  </div>\
                </el-form-item>\
                <el-form-item>\
                  <el-button type="primary" @click="submitAttrForm(\'attrForm\')" class="btn-24" style="margin-left: 30px;">保存</el-button>\
                </el-form-item>\
              </el-form>   \
            </div> \
          </div>\
        </div>\
      <div class="maskWrap1" v-if="seriesDia">\
        <div class="mask1 alertseen" @click="seriesDia = false"></div>\
        <div class="eyesshowbox">\
          <div class="eyeinfobox">\
            <p>输入画作系列标题</p>\
            <el-input v-model="inputSeries" @blur="checkseries" class="inputseries" placeholder="请输入画作系列"></el-input>\
            <p v-show="seriesflag" style="padding: 0;position: absolute;font-size: 12px;margin-left: 25px;top: 130px;color:#ff4949">长度不大于 20 个字符</p>\
            <el-button type="primary" @click="addSeries">确定</el-button>\
            <el-button type="primary" @click="closeSerires">取消</el-button>\
          </div>\
        </div>\
      </div>\
      <div class="" v-if="yulan">\
        <div class="mask alertseen" @click="yulan = false"></div>\
        <div class="yulanbox">\
          <div class="yulantitlediv">\
            <span class="yulantitle">预览图</span>\
          </div>\
          <div class="clearfix ylcontent">\
            <div class="fl rightdiv">\
              <img :src="yulanimg1" alt="">\
              <p class="trip r">正确的示范</p>\
            </div>\
            <div class="fl rightdiv">\
              <img :src="yulanimg2" alt="">\
              <p class="trip e">错误的示范</p>\
            </div>\
          </div>\
          <el-button type="primary" class="yulanbtn" @click="yulan = false">确定</el-button>\
        </div>\
      </div>\
      </div>\
      ',
  data: function () {
    var checkzj4 = function (rule, value, callback) {
      // if (/^[1-9]\d*$/g.test(value) == false) {
      //   return callback(new Error('请输入0-9999之间数字'));
      // }
      // if (value > 9999 || value < 0) {
      //   return callback(new Error('直径尺寸在9999cm内'));
      // } else {
      //   callback()
      // }
      if(value >10000){
        return callback(new Error('请输入0-10000.0之间数字'));
      }
      value = value.toString();
      if(/^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d{1})$/.test(value) == false){
        return callback(new Error('请输入0-10000.0之间数字'));
      }else{
        value = Number(value)
        callback()
      }
    };
    var checkwh4 = function (rule, value, callback) {
      // if (/^[1-9]\d*$/g.test(value) == false) {
      //   return callback(new Error('请输入0-9999之间数字'));
      // }
      // if (value > 9999 || value < 0) {
      //   return callback(new Error('尺寸在9999cm内'));
      // } else {
      //   callback()
      // }
      if(value >10000){
        return callback(new Error('请输入0-10000.0之间数字'));
      }
      value = value.toString();
      if(/^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d{1})$/.test(value) == false){
        return callback(new Error('请输入0-10000.0之间数字'));
      }else{
        value = Number(value)
        callback()
      }
    };
    var checkstory =function(rule, value, callback){
      if(value.length>150){
        return callback(new Error('长度不大于 150 个字符'));
      }else{
        callback()
      }
    };
    var check20len = function(rule, value, callback) {
      if(value.replace(/(^\s*)|(\s*$)/g, "") ==""){
        return callback(new Error('作品名称不能为空'));
      }
      else if(value.length>20){
        return callback(new Error('作品名称不超过20个字'));
      }else{
        callback()
      }
    };
    return {
      artID:'',//艺术品id
      ossAction: ossInfo.action,
      percent: 0,
      maskseen: false, //预览显示开关
      finishseen: false, //作品属性弹窗显示开关
      beforeuploadShow1: true, //上传全景图文字占位符显示开关
      beforeuploadShow2: true, //上传局部图文字占位符显示开关
      uploadloading: false,
      seriesDia: false,
      inputSeries: '', //输入的画作系列名
      seriesflag: false,
      attrForm: {//规则字段
        name:'', //作品名称
        state:'1',//作品权限
        series_id: '0', //画作系列
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
      stateOptions: [
        {//权限选项
          "id": '1',
          "value": "所有人可见"
        },
        {
          "id": '2',
          "value": "仅自己可见"
        }
      ],
      seriesOption: [ //画作系列
        {
          id: '0',
          name: '无'
        },
      ],
      attrRules: {//字段规则
        name: [
          {
            required: true,
            // message: '请填写画作名称',
            validator: check20len,
            trigger: 'blur'
          }
        ],
        state: [
          {
            required: true,
            message: '请选择作品权限',
            trigger: 'change'
          }
        ],
        category: [
          {
            // required: true,
            type: 'array',
            message: '请选择作品类型',
            trigger: 'change'
          }
        ],
        color: [
          {
            type: 'array',
            message: '请填写画作色调',
            trigger: 'change'
          }
        ],
        length: [
          {
            type: 'string',
            validator: checkwh4,
            trigger: 'change'
          }
        ],
        width: [
          {
            type: 'string',
            validator: checkwh4,
            trigger: 'change'
          }
        ],
        diameter: [
          {
            type: 'string',
            validator: checkzj4,
            trigger: 'change'
          }
        ],
        fileList1: [
          {
            type: 'array',
            message: '请上传画作全景图',
            trigger: 'change'
          }
        ],
        fileList2: [
          {
            type: 'array',
            message: '请上传画作局部图',
            trigger: 'change'
          }
        ],
        desc: [
          {
            message: '请输入画作简介',
            trigger: 'blur'
          },
          { max: 10, message: '长度在 3 到 5 个字符', trigger: 'blur' }
        ],
        story: [
          { validator: checkstory, trigger: 'blur' }
        ]
      },
      colorOptions:[
        {
          "color": "#e51f20",
          "name": "红色",
          "sort": 1,
          "id": "1",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_red.png) no-repeat center center',
            'background-size':'100% 100%',
          }
        },
        {
          "color": "#ec8e2a",
          "name": "橘黄",
          "sort": 2,
          "id": "2",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_orange.png) no-repeat center center',
            'background-size':'100% 100%',
          }
        },
        {
          "color": "#eddb23",
          "name": "黄色",
          "sort": 3,
          "id": "3",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_yellow.png) no-repeat center center',
            'background-size':'100% 100%',

          }
        },
        {
          "color": "#43c956",
          "name": "绿色",
          "sort": 4,
          "id": "4",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_green.png) no-repeat center center',
            'background-size':'100% 100%',
          }
        },
        {
          "color": "#2f76e0",
          "name": "蓝色",
          "sort": 5,
          "id": "5",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_blue.png) no-repeat center center',
            'background-size':'100% 100%',
          }
        },
        {
          "color": "#c949d2",
          "name": "紫色",
          "sort": 6,
          "id": "6",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_purple.png) no-repeat center center',
            'background-size':'100% 100%',
          }
        },
        {
          "color": "#a1a1a1",
          "name": "灰色",
          "sort": 7,
          "id": "7",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_grew.png) no-repeat center center',
            'background-size':'100% 100%',
          }
        },
        {
          "color": "#ffffff,1b1b1b",
          "name": "黑白",
          "sort": 8,
          "id": "8",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_blackwhite.png) no-repeat center center',
            'background-size':'100% 100%',
          }
        },
        {
          "color": "#ac6c25",
          "name": "褐色",
          "sort": 9,
          "id": "9",
          "style":{
            color:'#333',
            'font-size':'12px',
            'background': 'url(/image/color/pic_brownness.png) no-repeat center center',
            'background-size':'100% 100%',
          }
        }
      ],//画作颜色
      shapeOptions: [
        {
          id: '1',
          value: '方形'
        },
        {
          id: '2',
          value: '圆形'
        }
      ],//画作形状
      subjectOptions: [
        {
          value: '人物'
        },
        {
          value: '风景'
        },
        {
          value: '静物'
        },
        {
          value: '动物'
        },
        {
          value: '植物'
        },
        {
          value: '萌化'
        },
        {
          value: '宗教'
        },
        {
          value: '山水'
        },
        {
          value: '花鸟'
        },
        {
          value: '科幻'
        },
        {
          value: '动漫'
        }
      ], //画作题材
      styleOptions: [
        {
          value: '具体'
        },
        {
          value: '抽象'
        },
        {
          value: '古典'
        },
        {
          value: '观念'
        },
        {
          value: '表现'
        }
      ],
      yearOptions: [], //年份选项
      categoryOptions: [
        {
          "id": 1,
          "sort": 0,
          "value": "油画"
        },
        {
          "id": 2,
          "sort": 5,
          "value": "水彩"
        },
        {
          "id": 3,
          "sort": 10,
          "value": "插画"
        },
        {
          "id": 4,
          "sort": 15,
          "value": "素描"
        },
        {
          "id": 5,
          "sort": 20,
          "value": "工笔"
        },
        {
          "id": 6,
          "sort": 25,
          "value": "国画"
        },
        {
          "id": 7,
          "sort": 30,
          "value": "版画"
        },
        {
          "id": 8,
          "sort": 35,
          "value": "漆画"
        },
        {
          "id": 9,
          "sort": 40,
          "value": "丙烯"
        }
      ], //画作类别选项
      yulan: false,
      yulanimg: {
        fengmian: {
          r: '/image/upload/fmright.jpg',
          e: '/image/upload/fmerror.jpg'
        },
        quanjin: {
          r: '/image/upload/qjright.jpg',
          e: '/image/upload/qjerror.jpg'
        },
        jubu: {
          r: '/image/upload/jbright.jpg',
          e: '/image/upload/jberror.jpg'
        }
      },
      yulanimg1: '/image/upload/jbright.jpg',
      yulanimg2: '/image/upload/jberror.jpg',
    };
  },
  created: function() {
    var that = this;
    function initYears() {
      var startYear = 1990;//起始年份
      var endYear = new Date().getUTCFullYear();//结束年份，默认为当前年份
      var yearList = [];
      for (var i = endYear; i >= startYear; i--) {
        yearList.push(i);
      }
      return yearList;
    }
    this.yearOptions = initYears();
    this.getSeries();
  },
  mounted: function() {
    eventBus.$on('showArtworkAttr', function(id, form) {
      this.showmaskSeen(id, form);
      console.log(form)
    }.bind(this));
  },
  methods: {
    notspace: function(v,a){ //2018.05.8
      if(v.length==0) { return }
      //attrForm.category 作品类型
      //attrForm.subject 作品题材
      //attrForm.style 作品风格

      ///^[A-Za-z0-9\u4e00-\u9fa5]+$/ 字母数字，中文
      var narr=[];
        for(var i in v){
          if(v[i].replace(/(^\s*)|(\s*$)/g, "")!=''){
            if(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(v[i])){
                if(v[i].length>5){
                  narr.push(v[i].slice(0,5));
                }else{
                  narr.push(v[i]);
                }
            }
          }
        }
      if(a=='attrForm.category'){

        this.attrForm.category =narr;
      }
      if(a=='attrForm.subject'){

        this.attrForm.subject =narr;
      }
      if(a=='attrForm.style'){

        this.attrForm.style =narr;
      }
    },
    showmaskSeen: function (id, form) {

      var that = this;
      this.artID = id;
      this.attrForm = JSON.parse(JSON.stringify(form));
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
      this.attrForm = {
        name:'', //作品名称
        state:'1',//作品权限
        series_id: '0',
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
      }
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


          if(that.attrForm.shape ==1){ //属性详情-直径
            that.attrForm.diameter = '';
          }else if(that.attrForm.shape ==2){//属性详情-宽高
            that.attrForm.width = '';
            that.attrForm.length = '';
          }

          var data = {
              'artworkId': that.artID,
              'artworkName':that.attrForm.name,
              "state": that.attrForm.state,
              'series_id': that.attrForm.series_id,
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
          artzheAgent.callMP('Artwork/addArtworkAttribute', data, function(response) { //添加画作属性
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
          });
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
    },
    getSeries: function(){
      var that = this;
      artzheAgent.callMP('Artwork/getArtworkSeries', {}, function(res){//画作选项获取
        if(res.code ==30000){
          if(res.data.info.length>0){
            that.seriesOption = that.seriesOption.concat(res.data.info); //画作选项数据
          }
        }
      })
    },
    checkseries: function(){
      if(this.inputSeries.length>20){
        this.seriesflag = true;
      }else{
        this.seriesflag = false;
      }

    },
    addSeries: function(){
      if(this.inputSeries.length>20){
        this.seriesflag = true;
        // this.inputSeries=''
        // this.inputSeries.substr(0,20)
        return false
      }else{
        this.seriesflag = false;
        this.seriesDia = false;
      }

      var that = this;
      var optionlength = that.seriesOption.length;
      var hasval = false; //临时去重flag

      if(that.inputSeries.replace(/(^\s*)|(\s*$)/g, "") ==''){
        return false;
      }
      var nobj = {
        id: optionlength.toString(), //需要字符串id  -.-!
        name: that.inputSeries.replace(/(^\s*)|(\s*$)/g,'') //去除前后空格
      };
      for(var i=0;i<that.seriesOption.length;i++){ //去重
        if(that.inputSeries == that.seriesOption[i].name){
          hasval = true;
          that.attrForm.series_id = that.seriesOption[i].id; //相同直接定位到该项
        }
      };
      if(hasval == false){
        that.seriesOption.push(nobj);
        that.attrForm.series_id = nobj.id;
        var sendobj = {
          series_name: nobj.name
        };
        artzheAgent.callMP('Artwork/addArtworkSeries', sendobj, function(res){
          if(res.code ==30000){

            nobj.id = res.data.series_id;//把真id拿到
            that.attrForm.series_id = nobj.id;//把真id赋值给需要提交的obj
            that.attrForm.series_name = nobj.name;//把画作系列名给attrForm，方便作品属性显示
          }
        })
        this.inputSeries = ''; //完成就清空输入框
      }
    },
    closeSerires: function(){

      this.seriesDia = false;
      this.seriesflag = false;
      this.inputSeries = '';

    },
    pagePrev: function() {
      var that = this;
      if (this.curpage - 1 != 0) {
        this.loading = true;
        this.curpage--;
        this.getList();
      }
    },
    pageNext: function() {
      var that = this;
      if (this.curpage + 1 <= this.totalpage) {
        this.loading = true;
        this.curpage++;
        this.getList();
      }
    },
    gotopage: function() {
      var that = this;
      if (0 < this.inputpage && this.inputpage <= this.totalpage) {
        this.loading = true;
        this.curpage = this.inputpage;
        this.getList();
      }
    },
    showyulan: function(item){
      this.yulan = true;
      switch (item) {
        case 1:
          this.yulanimg1 = this.yulanimg.fengmian.r;
          this.yulanimg2 = this.yulanimg.fengmian.e;
          break;
        case 2:
          this.yulanimg1 = this.yulanimg.quanjin.r;
          this.yulanimg2 = this.yulanimg.quanjin.e;
          break;
        case 3:
          this.yulanimg1 = this.yulanimg.jubu.r;
          this.yulanimg2 = this.yulanimg.jubu.e;
          break;
      }
    },
  }
});




var vmAuth = new Vue({
  el: '#app',
  data: function(){
    return {
      myInfo: {
        uid: getCookie('userid'),
        name: getCookie('userName'),
        face: getCookie('userFace')
      },
      percent: 0,
      form1: { //规则字段
        name: '', //画作名称
        permission: '1' //作品权限
      },
      form2: { //更新日期
        date: getCurentDate()
      },
      characteristic: {}, //作品属性
      rules2: {//字段验证规则
        date: [
          {
          type: 'date',
          required: true,
          message: '请填写创作时间',
          trigger: 'blur'
          }
        ]
      },
      rules1: { //字段规则
        name: [
          {
          required: true,
          message: '请填写画作名称',
          trigger: 'blur'
          }
        ],
        permission: [
          {
          required: true,
          message: '请选择作品权限',
          trigger: 'change'
          }
        ]
      },
      attrForm: {//规则字段
        name:'', //作品名
        state:'', //作品权限
        series_id: '0',
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
      permissionOptions: [
        {
          "id": '1',
          "value": "所有人可见"
        },
        {
          "id": '2',
          "value": "仅自己可见"
        }
      ],//权限选项
      colorOptions:[
        {
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
      artID:'',//艺术品id
      fullscreenLoading: true, //全屏加载动画是否显示
      updateList: [
        // {
        //   "id": "1", //草稿箱ID
        //   "create_date": "2017-5-30", //创建日期
        //   "number": "2", //记录编号
        //   "summary": "hhjjjjj", //摘要
        //   "isEdit": "Y", //是否可编辑 N不可编辑 Y可编辑
        //   "img": [
        //     "http:http://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1491988391459158" //记录里面的图片
        //   ],
        //   "flag": 1 //1.草稿箱 2.更新记录里面的创作记录
        // }
      ],
      updateTime: '',// 当前是第几次更新(阿拉伯)
      updateTimeC: '',// 当前是第几次更新(汉字)
      isFinished: '',
      hasDraft: false,
      loading: true, //数据加载开关
      curpage: 1, //当前页
      totalpage: '', //总页数
      inputpage: '', //输入页码
    }
  },
  created: function() {
    var that = this;
    that.artID = GetRequest().id; //地址栏中获取艺术品id
    //获取艺术品状态更新列表(放这里要在加载编辑器后调用editPro导致报错的问题)
    if(!that.artID){
      that.loading = false;
    }
    if(that.artID){
        // 获取作品更新列表
        artzheAgent.callMP('Artwork/getRecordList',{"artId":that.artID},function(response){
          if(response.code == 30000 && response.data.status == 1000){
            var updateList = response.data.info;

            if(updateList.length > 0) {
              //有更新
              updateList.forEach(function (item) {
                var arr = item.create_date.split('-');
                item.create_date = arr[0]+'年'+arr[1]+'月'+arr[2]+'日';
                if (item.img.length > 3) {
                item.img = item.img.slice(0, 3);
              }
              });
              that.hasDraft = that.checkHasDraft(updateList);
              that.updateList = updateList;
              that.updateTime = updateList.length + 1;
              that.updateTimeC = new NumToChinese(updateList.length + 1).change();
            } else {
              //新作品
              that.updateList = updateList;
              that.updateTime = updateList.length + 1;
              that.updateTimeC = new NumToChinese(updateList.length + 1).change();
            }
            artzheAgent.callMP('Artwork/getAttributePercent',{"artworkId":that.artID}, function (res2) {
              that.percent = res2.data.percent;
              var resInfo = res2.data.info;

              //作品属性显示
              // var reslist = $.extend(true, {}, res2.data.info); //jq方法深拷贝
              var reslist = JSON.parse(JSON.stringify(res2.data.info)); //深拷贝对象，不然数据照成干扰
              that.characteristic = reslist;
              var color = []; //临时数组
              reslist.color_ids.map(function(value,index){ //对象转数组
                color.push(value.cn_name);
              });
              that.characteristic.color_ids = color.join(','); //显示时需要转为字符串
              //作品属性显示end

              that.form1 = {
                name: resInfo.name, //画作名称
                permission: resInfo.state //作品权限
              };
              that.attrForm.name = resInfo.name;
              that.attrForm.state = resInfo.state;
              that.attrForm.series_id = resInfo.series_id;//画作系列
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
              // if (that.attrForm.fileList1.length > 0) {
              //   that.beforeuploadShow1 = false;
              // }
              // if (that.attrForm.fileList2.length > 0) {
              //   that.beforeuploadShow2 = false;
              // }

              that.fullscreenLoading = false;
            });
           }else if (response.code == 30109) {
              window.location.href = '/';
           } else {
             that.$message.error(response.code + ' : ' + response.message);
           }
        });
      }
  },
  mounted: function() {
    eventBus.$on('updateAttr', function(percent, form) {
      this.updateAttr(percent, form);
    }.bind(this));
  },
  methods: {
    submitForm1: function(formName) {
      var that = this;
      this.$refs[formName].validate(function(valid) {
        if (valid) {
          var data = {
            "artworkId":that.artID,
            "artworkName":that.form1.name,
            "state": that.form1.permission
          };
          // that.showmaskSeen();
          artzheAgent.callMP('Artwork/saveArtistBaseInfo',data,
            function (response) {
              if(response.code == 30000 && response.data.status == 1000){
                that.showmaskSeen();
              } else {
                that.$message.error(response.message);
              }
          });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    submitForm2: function(formName) {
      var that = this;
      window.location.href = '/upload/edit' + '?id=' + that.artID;
      // this.$refs[formName].validate(function(valid) {
      //   if (valid) {
      //     Storage.set('updateDate', that.form2.date);
      //     window.location.href = '/upload/edit' + '?id=' + that.artID;
      //   } else {
      //     console.log('error submit!!');
      //     return false;
      //   }

      // });
    },
    showmaskSeen: function () {
      eventBus.$emit('showArtworkAttr', this.artID, this.attrForm); //传值给弹出层
    },
    getAttribute: function () { //获取画作属性，并关闭弹窗
      var that = this;
      artzheAgent.callMP('Artwork/getAttributePercent',{"artworkId":that.artID}, function (res2) {
        that.percent = res2.data.percent;
        that.isFinished = res2.data.info.is_finished;
        var resInfo = res2.data.info;
        that.form1 = {
          name: resInfo.name, //画作名称
          permission: resInfo.state //作品权限
        };
        that.closemaskSeen();
      });
    },

    gotoEdit: function (updateId, flag) {
      // console.log(updateId);
      // console.log(flag);
      // console.log('/upload/edit' + '?id=' + this.artID + '&updateId=' + updateId  + '&flag='  + flag);
      window.location.href = '/upload/edit' + '?id=' + this.artID + '&itemID=' + updateId  + '&flag='  + flag;
    },
    updateAttr: function (percent, form) { //
      this.percent = percent;
      this.attrForm = form;

      this.characteristic = JSON.parse(JSON.stringify(form)); //深拷贝，不然数据有干扰
      this.characteristic.category = form.category.join(','); //数组转成字符串显示
      this.characteristic.subject = form.subject.join(','); //数组转成字符串显示
      this.characteristic.style = form.style.join(','); //数组转成字符串显示

      var color = []; //临时数组
      var colorlen = form.color.length; //获取到颜色数组长度
      this.colorOptions.map(function(value,index){ //对象转数组
        for(var i=0;i<colorlen;i++){
          if(form.color[i] == value.id){
            color.push(value.name);
          }
        }
      });
      this.characteristic.color_ids = color.join(',');
    },
    checkHasDraft: function (arr) {
      for (var i = 0; i < arr.length; i++) {
        if (arr[i].flag == 1) {
          return true;
          break;
        }
      }
    },
    pagePrev: function() {
      var that = this;
      if (this.curpage - 1 != 0) {
        this.loading = true;
        this.curpage--;
        this.getList();
      }
    },
    pageNext: function() {
      var that = this;
      if (this.curpage + 1 <= this.totalpage) {
        this.loading = true;
        this.curpage++;
        this.getList();
      }
    },
    gotopage: function() {
      var that = this;
      if (0 < this.inputpage && this.inputpage <= this.totalpage) {
        this.loading = true;
        this.curpage = this.inputpage;
        this.getList();
      }
    },
  }
});
