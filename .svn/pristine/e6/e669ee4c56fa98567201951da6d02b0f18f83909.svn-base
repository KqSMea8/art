var vmAuth = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    list: {
      licenseList: [
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'}
      ],
      idCardList: [
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'}
      ],
      imageList: [
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'},
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'},
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'}
      ]
    },
    uploadloading1: false,
    uploadloading2: false,
    btnText: '提交申请',
    isSubmit: false,
    errorTip: ''
  },
  computed: {
    authInfo: function () {
      var a = {};
      a.adminImages = this.list.idCardList.length > 0 ? this.list.idCardList[0].url : '';
      a.license = this.list.licenseList.length > 0 ? this.list.licenseList[0].url : '';
      return a;
    }
  },
  created: function () {
    this.getLocal();
  },
  methods: {
    getLocal: function () {
      var that = this;
      if (Storage.get('authAgencyInfo')) {
        artzheAgent.call('AuthAgency/getAuthInfo', {}, function(res) {
          function arrFun(arr) {
            var list = arr.map(function (item) {
              var a = {};
              a.url = item;
              return a;
            });
            return list;
          }
          if (res.code == 30000) {
            if (res.data.info) {
              var authInfo = Storage.get('authAgencyInfo');
              // console.log(authInfo);
              var adminImages = authInfo.admin_images ? authInfo.admin_images.split(',') : [];
              var license = authInfo.license ? authInfo.license.split(',') : [];

              that.list = {
                idCardList: arrFun(adminImages),
                licenseList: arrFun(license)
              };
            }
          }
        });
      }
    },
    applyArts: function() {
      // console.log('applyArtist');
      var that = this;
      if (this.authInfo.adminImages == '' || this.authInfo.license == '') {
        if (this.authInfo.license == '') {
          this.errorTip = "请上传营业执照照片";
        } else if (this.authInfo.adminImages == '') {
          this.errorTip = "请上传管理员手持身份证照片";
        } 
        setTimeout(function () {
          that.errorTip = '';
        }, 2000);
        return false;
      }
      if(that.uploadloading1 || that.uploadloading2){
         that.$message({
              message:'图片上传中！'              
          }); 
         return false;
      }
      
      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;
      this.btnText = "提交中...";
      artzheAgent.call('AuthAgency/stepTwo', this.authInfo, function(res) {
        that.isSubmit = false;
        // console.log(res);
        if (res.code == 30000) {
          that.btnText = "跳转中...";
          window.location.href = '/';
        } else if (res.code == 31001){
          that.$message({
            message: res.message              
          });
          window.location.href = '/autharts/first';
        }
      });
    },
    beforeIdCardUpload:function(file) {
      this.uploadloading2 = true;
    },
    beforelicenseUpload:function(file) {
      this.uploadloading1 = true;
    },
    handleIdCardSuccess: function(res, file) {
      if (res.success == true) {
        var a = {};
        a.url = ResHeader + res.path;
        this.list.idCardList = [];
        this.list.idCardList[0] = a;
      }
      this.uploadloading2 = false;
    },
    handlelicenseSuccess: function(res, file) {
      if (res.success == true) {
        var a = {};
        a.url = ResHeader + res.path;
        this.list.licenseList = [];
        this.list.licenseList[0] = a;
      }
      this.uploadloading1 = false;
    }
  }
});