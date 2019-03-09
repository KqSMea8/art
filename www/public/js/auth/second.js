var vmAuth = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    list: {
      imageList: [
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'},
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'},
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'}
      ]
    },
    ossAction: ossInfo.action,
    isUpload: false,
    btnText: '提交',
    isSubmit: false,
    errorTip: '',
    imgtrip: false,
    htimg: {list:[]}, //艺术家与机构的合同
    htcomp: getCookie('temporaryLogin')>0 && getCookie('userid') > 0 ? true : false,
    // certimgList: [],
    // groupList: []
  },
  computed: {
    authInfo: function () {
      var a = {};
      var arr1 = this.list.imageList.map(function (item) {
        return item.url;
      });
      a.images = arr1.length > 0 ? arr1.join(',') : '';
      return a;
    },
    htInfo: function () { //合同图片拼接
      var a = {};
      var arr1 = this.htimg.list.map(function (item) {
        return item.url;
      });
      a.images = arr1.length > 0 ? arr1.join(',') : '';
      return a;
    },
  },
  created: function () {
    this.getLocal();
  if (getCookie('temporaryLogin')==1) {
    this.imgtrip=true;
  }

  },
  methods: {
    getLocal: function () {
      var that = this;
      artzheAgent.call22('AuthArtist/getMyApply', {}, function(res) {
        console.log(res);
        function arrFun(arr) {
          var list = arr.map(function (item) {
            var a = {};
            a.url = item;
            return a;
          });
          return list;
        }
        if (res.code == 30000) {
          if (res.data.info.images) {
            var authInfo = res.data.info;
            // console.log(authInfo);
            var images = authInfo.images ? authInfo.images.split(',') : [];

            that.list = {
              imageList: arrFun(images),
            };
          }
        }
      });
    },
    applyArtist: function() {
      // console.log('applyArtist');
      var that = this;
      if (this.authInfo.images == '' || this.list.imageList.length < 3 || this.list.imageList.length > 9) {
        if (this.authInfo.images == '') {
          this.errorTip = "请上传认证图片";
        } else if (this.list.imageList.length < 3 || this.list.imageList.length > 9) {
          this.errorTip = "认证图片不少于3张";
        } 
        setTimeout(function () {
          that.errorTip = '';
        }, 2000);
        return false;
      }

      if (that.isUpload) {
        that.$message({
          message: '图片上传中，请稍后！'
        });
        return false;
      }

      //合同图片整合到图片上传obj
      if (this.htcomp){ //普通用户不需要
        if (this.htimg.list.length>0) {
          this.authInfo.contract_img = this.htInfo.images
          
        } else {
          this.$message({
            type: 'info',
            message: '合同图片至少1张'
          })
          return false;
        }
      }
      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;
      this.btnText = "提交中...";
      console.log(this.authInfo)
      artzheAgent.call22('AuthArtist/stepTwo', this.authInfo, function(res) {
        
        that.isSubmit = false;
        // console.log(res);
        if (res.code == 30000) {
          that.btnText = "跳转中...";
          window.location.href = '/';
        } else {
          that.btnText = "提交";
          that.errorTip = res.message;
          setTimeout(function () {
            that.errorTip = '';
          }, 2000);
        }
      });
    },
    handleCertSuccess: function(res, file, fileList) {
      this.list.imageList = fileList.map(function (item) {
        if (item.response) {
          var a = {};
          a.url = ResHeader +  item.response.path;
          return a;
        } else {
          return item;
        }
      });
      if (this.list.imageList.length > 9) {
        this.list.imageList = this.list.imageList.slice(-9);
      }
    },
    handleCertRemove: function(file, fileList) {
      this.list.imageList = fileList;
    },
    beforeupload: function (file) {
      var type = file.type.toUpperCase();
      if (type !== 'IMAGE/JPEG' && type !== 'IMAGE/PNG' && type !== 'IMAGE/JPG' && type !== 'IMAGE/BMP' && type !== 'IMAGE/GIF') {
        this.$message({
          message: '请上传图片'
        });
        return false;
      }
      var that = this;
      this.isUpload = true;
    },
    uploadImg: function(options) {
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
            that.success(options.file, that.list.imageList);
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
    // beforeImgUpload: function(file) {
    //   console.log(file);
    //   var arr =  file.name.split()

    //   return false;
    // },
    // filterArr: function(arr) {
    //   var list = arr.map(function(item, index, list) {
    //     console.log(item.response);
    //     return item['response'].path;
    //   });
    //   return list;
    // },
    // random_string: function(len) {　　
    //   len = len || 32;　　
    //   var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';　　
    //   var maxPos = chars.length;　　
    //   var pwd = '';　　
    //   for (i = 0; i < len; i++) {　　
    //     pwd += chars.charAt(Math.floor(Math.random() * maxPos));
    //   }
    //   return pwd;
    // },
    handleCertSuccess1: function (res, file, fileList) {
      this.htimg.list = fileList.map(function (item) {
        if (item.response) {
          var a = {};
          a.url = ResHeader + item.response.path;
          return a;
        } else {
          return item;
        }
      });
      if (this.htimg.list.length > 9) {
        this.htimg.list = this.htimg.list.slice(-9);
      }
    },
    handleCertRemove1: function (file, fileList) {
      this.htimg.list = fileList;
    },
    beforeupload1: function (file) {
      var type = file.type.toUpperCase();
      if (type !== 'IMAGE/JPEG' && type !== 'IMAGE/PNG' && type !== 'IMAGE/JPG' && type !== 'IMAGE/BMP' && type !== 'IMAGE/GIF') {
        this.$message({
          message: '请上传图片'
        });
        return false;
      }
      var that = this;
      this.isUpload = true;
    },
    uploadImg1: function (options) {
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
        xhr.onload = function () {
          if (xhr.status === 200) {
            that.success1(options.file, that.htimg.list);
          } else {
            console.log('出错了');
          }
        };
        xhr.send(formData);
      }
    },
    success1: function (file, fileList) {
      var that = this;
      this.isUpload = false;
      var item = {};
      item.url = file.url;
      item.uid = file.uid;
      fileList.push(item);
    },
  }
});