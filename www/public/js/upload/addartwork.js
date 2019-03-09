var vmAuth = new Vue({
  el: '#manage',
  data: function(){
    var checkzj4 = function(rule, value, callback){
      // if (/^[1-9]\d*$/g.test(value) == false){
      //   return callback(new Error('请输入0-9999之间数字'));
      // }
      // if(value>9999 || value<0){
      //   return callback(new Error('直径尺寸在9999cm内'));
      // }else{
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
    var checkwh4 = function(rule, value, callback){
      // if (/^[1-9]\d*$/g.test(value) == false){
      //   return callback(new Error('请输入0-9999之间数字'));
      // }
      // if(value>9999 || value<0){
      //   return callback(new Error('尺寸在9999cm内'));
      // }else{
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
      myInfo: {
        uid: getCookie('userid'),
        name: getCookie('userName'),
        face: getCookie('userFace')
      },
      ossAction: ossInfo.action,
      beforeuploadShow1: true, //上传全景图文字占位符显示开关
      beforeuploadShow2: true, //上传局部图文字占位符显示开关
      uploadloading: false,
      seriesDia: false,
      inputSeries: '', //输入的画作系列名
      form1: { //规则字段
        artworkName: '', //画作名称
        state: '1', //作品权限
        series_id: '0', //画作系列
        category: [], //作品类型
        color: [], //作品色调
        shape: '', //形状
        length: '', //作品长度
        width: '', //作品宽度
        diameter: '', //作品直径
        artworkDate: '', //创作年份
        subject: [], //题材
        style: [], //风格
        story: '', //画作介绍
        cover: '', //画作封面图
        panorama: [],//画作全景图
        topography:[], //局部图
      },
      attrRules: {//字段规则
        artworkName: [
          {
            required: true,
            // message: '请填写画作名称',
            validator :check20len,
            trigger: 'blur'
          }
        ],
        state: [
          {
            required: true,
            message: '请选择作品权限',
            trigger: 'blur'
          }
        ],
        category: [
          {
            min: 1,
            max:5,
            // required: true,
            type: 'array',
            message: '请选择作品类型',
            trigger: 'blur'
          }
        ],
        color: [
          {
            // required: true,
            min: 1,
            max:2,
            type: 'array',
            message: '请填写画作色调',
            trigger: 'blur'
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
        shape: [
          {
            // required: true,
            min: 1,
            max:2,
            type: 'string',
            message: '请填选择作品形状',
            trigger: 'blur'
          }
        ],
        artworkDate: [
          {
            // required: true,
            type:'number',
            message: '请填选择创作年份',
            trigger: 'blur'
          }
        ],
        subject: [
          {
            min: 1,
            max: 5,
            // required: true,
            type: 'array',
            message: '请填选择作品标签',
            trigger: 'blur'
          }
        ],
        style: [
          {
            min: 1,
            max: 5,
            // required: true,
            type: 'array',
            message: '请填选择作品风格',
            trigger: 'blur'
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
          }
        ],
      },
      isSubmit: false,
      stateOptions: [
        {
          "id": '1',
          "value": "所有人可见"
        },
        {
          "id": '2',
          "value": "仅自己可见"
        }
      ],//权限选项
      seriesOption: [ //画作系列
        {
          id: '0',
          name: '无'
        },
      ],
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
    }
  },
  created: function() {
    this.form1.series_id = GetRequest().id ? GetRequest().id : '0';
    this.yearOptions = this.initYears();
    this.getSeries();
  },
  methods: {
    notspace: function(v,a){ //2018.05.8
      if(v.length==0) { return }
      //attrForm.category 作品类型
      //attrForm.subject 作品题材
      //attrForm.style 作品风格

      // /^[A-Za-z0-9\u4e00-\u9fa5]+$/
      var narr=[];
        for(var i in v){
          if(v[i].replace(/(^\s*)|(\s*$)/g, "")!=''){
            if(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(v[i])){
                if(v[i].length>=5){
                  narr.push(v[i].slice(0,5));
                }else{
                  narr.push(v[i]);
                }
            }
          }
        }

      if(a=='form1.category'){

        this.form1.category =narr
      }
      if(a=='form1.subject'){

        this.form1.subject =narr
      }
      if(a=='form1.style'){

        this.form1.style =narr
      }
    },
    initYears: function() {
      var startYear = 1990;//起始年份
      var endYear = new Date().getUTCFullYear();//结束年份，默认为当前年份
      var yearList = [];
      for (var i = endYear; i >= startYear; i--) {
        yearList.push(i);
      }
      return yearList;
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
        this.form1.cover = ResHeader + res.path;
        this.$refs.form1.validateField('cover');
      } else {
        this.$message({
          message: '上传失败'
        });
      }
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
    coverSuccess: function(file) {
      this.$message({
        message: '封面图片上传成功！',
        type: 'success'
      });
      this.form1.cover = file.url;
      this.uploadloading = false;
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
    remove1: function(file, fileList) {
      var that = this;
      this.form1.panorama = fileList.map(function(item) {
        if (item.response) {
          var a = {};
          a.url = ResHeader + item.response.path;
          that.$refs.form1.validateField('panorama');
          return a;
        } else {
          return item;
        }
      });
      if (this.form1.panorama.length == 0) {
        setTimeout(function() {
          that.beforeuploadShow1 = true;
        }, 700);
      }
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
            that.success(options.file, that.form1.panorama);
          } else {　　　　　　　　
            console.log('出错了');　　　　　　
          }　　　　
        };　　　　
        xhr.send(formData);　　
      }
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
    },
    remove2: function(file, fileList) {
      var that = this;
      if (fileList.length == 0) {
        setTimeout(function() {
          that.beforeuploadShow2 = true;
        }, 700);
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
            that.success(options.file, that.form1.topography);
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
    submitForm1: function(formName) {
      var that = this;
      this.$refs[formName].validate(function(valid) {
        if (valid) {
          if (that.isSubmit == true) {
            return;
          }
          if(that.form1.shape ==1){
            that.form1.diameter = '';
          }else if(that.form1.shape ==2){
            that.form1.width = '';
            that.form1.length = '';
          }

            var arr1 = [], arr2 = [];
            for (var i = 0; i < that.form1.panorama.length; i++) {
                arr1[i] = that.form1.panorama[i].url;
            }
            for (var i = 0; i < that.form1.topography.length; i++) {
                arr2[i] = that.form1.topography[i].url;
            }

          var fobj = { //将6个数组转为字符串
            artworkName: that.form1.artworkName, //画作名称
            state: that.form1.state, //作品权限
            series_id: that.form1.series_id,//系列作品
            category: that.form1.category.join(','), //作品类型[]
            color: that.form1.color.join(','), //作品色调[]
            shape: that.form1.shape, //形状
            length: that.form1.length, //作品长度
            width: that.form1.width, //作品宽度
            diameter: that.form1.diameter, //作品直径
            artworkDate: that.form1.artworkDate, //创作年份
            subject: that.form1.subject.join(','), //题材[]
            style: that.form1.style.join(','), //风格[]
            story: that.form1.story, //画作介绍
            cover: that.form1.cover, //画作封面图
            panorama: arr1.join(','),//画作全景图[]
            topography: arr2.join(','), //局部图[]
          };
          that.isSubmit = true;
          artzheAgent.callMP('Artwork/addArtworkInfo', fobj, function(response) { //新增完成画作
            if (response.data.status == 1000 && response.code == 30000) {
              window.location.href = '/upload/edit' + '?id=' + response.data.id;
            } else {
              that.$message.error(response.code + ' : ' + response.message);
            }
          }, function () {
            that.isSubmit = false;
          });
        } else {
          that.$message({
            type:'error',
            message:'填写错误'
          })
          return false;
        }

      });
    },
    getSeries: function(){
      var that = this;
      artzheAgent.callMP('Artwork/getArtworkSeries', {}, function(res){
        if(res.code ==30000){
          if(res.data.info.length>0){
            that.seriesOption = that.seriesOption.concat(res.data.info);
          }
        }
      })
    },
    addSeries: function(){
      this.seriesDia = false;

      var that = this;
      var optionlength = that.seriesOption.length;
      var hasval = false; //临时去重flag

      if(that.inputSeries.replace(/(^\s*)|(\s*$)/g, "") ==''){
        return false;
      }
      if(that.inputSeries.length>20){
        this.$message({
          type:'error',
          message:'画作系列名不能超过20个字'
        })
        return false
      }
      var nobj = {
        id: optionlength.toString(), //需要字符串id  -.-!
        name: that.inputSeries.replace(/(^\s*)|(\s*$)/g,'') //去除前后空格
      };
      console.log(nobj)
      for(var i=0;i<that.seriesOption.length;i++){ //去重
        if(that.inputSeries == that.seriesOption[i].name){
          hasval = true;
          that.form1.series_id = that.seriesOption[i].id; //相同直接定位到该项
        }
      };
      if(hasval == false){
        that.seriesOption.push(nobj);
        // that.form1 = JSON.parse(JSON.srtify())
        that.form1.series_id = nobj.id;
        var sendobj = {
          series_name: nobj.name
        };
        
        artzheAgent.callMP('Artwork/addArtworkSeries', sendobj, function(res){
          if(res.code ==30000){
            nobj.id = res.data.series_id;//把真id拿到
            that.form1.series_id = nobj.id;//把真id赋值给需要提交的obj
          }
        })
        this.inputSeries = ''; //完成就清空输入框
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
