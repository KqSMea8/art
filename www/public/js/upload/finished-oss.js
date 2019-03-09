var vmAuth = new Vue({
  el: '#finished',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    ruleForm: { //规则字段
      name: '', //画作名称
      color: [], //画作色调         
      width: '', //画作长度
      height: '', //画作宽度
      fileList1: [], //画作全景图
      fileList2: [], //画作局部图
      desc: '' //画作介绍      
    },
    rules: { //字段规则
      name: [{
        required: true,
        message: '请填写画作名称',
        trigger: 'blur'
      }],
      color: [{
        type: 'array',
        required: true,
        message: '请填写画作色调',
        trigger: 'change'
      }],
      width: [{
        type: 'number',
        message: '请输入长度值',
        trigger: 'blur'
      }],
      height: [{
        type: 'number',
        message: '请输入宽度值',
        trigger: 'blur'
      }],
      fileList1: [{
        required: true,
        type: 'array',
        message: '请上传画作全景图',
        trigger: 'change'
      }],
      fileList2: [{
        required: true,
        type: 'array',
        message: '请上传画作局部图',
        trigger: 'change'
      }],
      desc: [{
        required: true,
        message: '请输入画作简介',
        trigger: 'blur'
      }],
    },
    colorOptions: [], //画作颜色  
    dialogVisible1: false,
    dialogVisible2: false,
    dialogImageUrl1: '',
    dialogImageUrl2: '',
    beforeuploadShow1: true,
    beforeuploadShow2: true,
    editID: '',
    artID: '',
    isUpload1: false,
    isUpload2: false,
    uploadData: {}
    // fileList1: [], //画作全景图列表  
    // fileList2: [], //画作局部图    
  },
  created: function() {
    var that = this;
    this.editID = Storage.get('editID');
    var st = Storage.get('editor' + that.editID);
    // 获取作品颜色分类
    artzheAgent.call('Artwork/getArtworkColorConfig', {}, function(response) {
        if (response.data.status == 1000 && response.code == 30000) {
          that.colorOptions = response.data.info;
        } else {
          that.$message.error(response.code + ' : ' + response.message);
        }
      })
      //获取产品信息
    this.artID = Storage.get('artID');
    var st = Storage.get('artID');
    if (st) {
      artzheAgent.call('Artwork/getArtworkDesc', {
        'artId': that.artID
      }, function(response) {
        if (response.data.status == 1000 && response.code == 30000) {
          var arr1 = [],
            arr2 = [];
          for (var i = 0; i < response.data.info.panorama_ids.length; i++) {
            arr1[i] = {
              url: response.data.info.panorama_ids[i]
            };
          }
          for (var i = 0; i < response.data.info.topography_ids.length; i++) {
            arr2[i] = {
              url: response.data.info.topography_ids[i]
            };
          }
          that.ruleForm.name = response.data.info.name;
          that.ruleForm.desc = response.data.info.story;
          if (response.data.info.is_finished == 'Y') { //完成的作品才有加载信息
            that.ruleForm.color = response.data.info.color_ids.split(',');
            that.ruleForm.width = Number(response.data.info.width);
            that.ruleForm.height = Number(response.data.info.length);
            that.ruleForm.fileList1 = arr1;
            that.ruleForm.fileList2 = arr2;
            if (that.ruleForm.fileList1.length > 0) {
              that.beforeuploadShow1 = false;
            }
            if (that.ruleForm.fileList2.length > 0) {
              that.beforeuploadShow2 = false;
            }
          }
        } else {
          that.$message.error(response.code + ' : ' + response.message);
        }
      })
    }
  },
  methods: {
    submitForm: function(formName) {
      var that = this;
      this.$refs[formName].validate(function(valid) {
        if (valid) {
          if (that.isUpload1 || that.isUpload2) {
            that.$message({
              message: '图片上传中，请稍后！'
            });
            return false;
          }
          var st = Storage.get('editor' + that.editID);
          var dateformat = formatDate(st.date);
          var arr1 = [],
            arr2 = [];
          for (var i = 0; i < that.ruleForm.fileList1.length; i++) {
            arr1[i] = that.ruleForm.fileList1[i].url;
          }
          for (var i = 0; i < that.ruleForm.fileList2.length; i++) {
            arr2[i] = that.ruleForm.fileList2[i].url;
          }
          var obj = {
            'artworkName': that.ruleForm.name,
            'categoryId': st.class,
            'artworkTagIds': st.tag.join(','),
            'story': that.ruleForm.desc,
            'wit': st.wit,
            'createDate': dateformat,
            'coverId': st.cover,
            'colorIds': that.ruleForm.color.join(','),
            'artworkLength': that.ruleForm.width,
            'artworkWidth': that.ruleForm.height,
            'panoramaIds': arr1.join(','),
            'topographyIds': arr2.join(',')
          };
          if (that.editID === 'Add' + that.myInfo.uid) {
            obj.artworkId = st.artId;
            artzheAgent.call('Artwork/finishArtwork', obj, function(response) { //新增完成画作 
              console.log(response);
              if (response.data.status == 1000 && response.code == 30000) {
                that.$message({
                  message: '更新成功！',
                  type: 'success'
                });
                // Storage.del('editorAdd'+ that.myInfo.uid);
                window.localStorage.clear();
                window.location.href = '/upload/manage'
              } else {
                that.$message.error(response.code + ' : ' + response.message);
              }

            })
          } else {
            obj.artworkUpdateId = that.editID;
            artzheAgent.call('Artwork/edit', obj, function(response) { //单次更新的完成画作 
              console.log(response);
              if (response.data.status == 1000 && response.code == 30000) {
                that.$message({
                  message: '更新成功！',
                  type: 'success'
                });
                // Storage.del('editorAdd'+ that.myInfo.uid);
                window.localStorage.clear();
                window.location.href = '/upload/manage'
              } else {
                that.$message.error(response.code + ' : ' + response.message);
              }

            })
          }
        } else {
          console.log('error submit!!');
          return false;
        }

      });
    },
    fileList1success: function(response, file, fileList) {
      var that = this;
      this.isUpload1 = false;

      console.log(response);
      console.log(file);
      console.log(fileList);
      // this.ruleForm.fileList1 = fileList.map(function (item) {
      //         if (item.response) {
      //           var a = {};
      //           a.url = ResHeader + item.response.path;
      //            that.$refs.ruleForm.validateField('fileList1');
      //           return a;                 
      //         } else {
      //           return item;
      //         }
      //   });                        
    },
    fileList1change: function(file, fileList) {
      this.$refs.ruleForm.validateField('fileList1');
    },
    progress1: function(event, file, fileList) {
      this.isUpload1 = true;
    },
    progress2: function(event, file, fileList) {
      this.isUpload2 = true;
    },
    fileList2success: function(response, file, fileList) {
      var that = this;
      this.isUpload2 = false;
      this.ruleForm.fileList2 = fileList.map(function(item) {
        if (item.response) {
          var a = {};
          a.url = ResHeader + item.response.path;
          return a;
        } else {
          return item;
        }
      });
    },
    fileList2change: function(file, fileList) {
      this.$refs.ruleForm.validateField('fileList2');
    },
    handlePictureCardPreview1: function(file) {
      this.dialogImageUrl1 = file.url;
      this.dialogVisible1 = true;
    },
    handlePictureCardPreview2: function(file) {
      this.dialogImageUrl2 = file.url;
      this.dialogVisible2 = true;
    },
    beforeupload1: function(file) {
      console.log(file);
      var that = this;
      this.isUpload1 = true;
      this.beforeuploadShow1 = false;

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
        xhr.open('POST', options.action);　　　　 // 定义上传完成后的回调函数
        　　　　
        xhr.onload = function() {　　　　　　
          if (xhr.status === 200) {　　　　　　　　
            that.success1(options.file);
          } else {　　　　　　　　
            console.log('出错了');　　　　　　
          }　　　　
        };　　　　
        xhr.send(formData);　　
      }

      // return new Promise(function (resolve, reject) {//解决beforeUpload中修改data和action不会在请求中生效
      //   options.data = reData;
      //   resolve(true)
      // })
      // options.onProgress = function () {
      //   that.progress1();
      // };
      // options.onSuccess = function (res) {
      //   that.fileList1success(res, rawFile);
      // };
      console.log(options);
    },
    success1: function(file) {
      var that = this;
      console.log(file);
      var item = {};
      item.url = file.url;
      item.uid = file.uid;
      this.ruleForm.fileList1.push(item);
      // this.ruleForm.fileList1 = fileList.map(function (item) {
      //         if (item.response) {
      //           var a = {};
      //           a.url = ResHeader + item.response.path;
      //            that.$refs.ruleForm.validateField('fileList1');
      //           return a;                 
      //         } else {
      //           return item;
      //         }
      //   }); 
    },
    beforeupload2: function(file) {
      this.isUpload2 = true;
      this.beforeuploadShow2 = false;
      // // set_upload_param(file.name);
      // var reData = ossObj.set_upload_param(file.name);
      // return new Promise(function (resolve, reject) {//解决beforeUpload中修改data和action不会在请求中生效
      //   that.uploadData = reData;         
      //   resolve(true)
      // })
    },
    remove1: function(file, fileList) {
      var that = this;
      this.ruleForm.fileList1 = fileList.map(function(item) {
        if (item.response) {
          var a = {};
          a.url = ResHeader + item.response.path;
          that.$refs.ruleForm.validateField('fileList1');
          return a;
        } else {
          return item;
        }
      });
      if (fileList.length == 0) {
        setTimeout(function() {
          that.beforeuploadShow1 = true;
        }, 700)
      }
    },
    remove2: function(file, fileList) {
      var that = this;
      if (fileList.length == 0) {
        setTimeout(function() {
          that.beforeuploadShow2 = true;
        }, 700)
      }
      this.ruleForm.fileList2 = fileList.map(function(item) {
        if (item.response) {
          var a = {};
          a.url = ResHeader + item.response.path;
          return a;
        } else {
          return item;
        }
      });
    },
  }
});