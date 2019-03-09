var vmAuth = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    list: {
      idCardList: [
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'}
      ],
      imageList: [
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'},
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'},
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'}
      ]
    },
    btnText: '提交申请',
    uploadloading: false,
    isSubmit: false,
    errorTip: ''
    // certimgList: [],
    // groupList: []
  },
  computed: {
    authInfo: function () {
      var a = {};
      a.plannerImages = this.list.idCardList.length > 0 ? this.list.idCardList[0].url : '';
      return a;
    }
  },
  created: function () {
    this.getLocal();
  },
  methods: {
    getLocal: function () {
      var that = this;
      if (Storage.get('authPlannerInfo')) {
        artzheAgent.call('AuthPlanner/getAuthInfo', {}, function(res) {
          // console.log(res);
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
              var authInfo = Storage.get('authPlannerInfo');
              // console.log(authInfo);
              var image = authInfo.planner_image ? authInfo.planner_image.split(',') : [];

              that.list = {
                idCardList: arrFun(image),
              };
            }
          }
        });
      }
    },
    applyCurator: function() {
      var that = this;
      if (this.authInfo.plannerImages == '') {
        this.errorTip = "请上传您手持身份证的照片";
        setTimeout(function () {
          that.errorTip = '';
        }, 2000);
        return false;
      }
      if (this.authInfo.plannerImages.indexOf('undefined') > -1) {
        this.$message({
          message: '图片上传失败，请重试'
        });
        return false;
      }
      if(that.uploadloading){
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
      artzheAgent.call('AuthPlanner/stepTwo', this.authInfo, function(res) {
        that.isSubmit = false;
        // console.log(res);
        if (res.code == 30000) {
          that.btnText = "跳转中...";
          window.location.href = '/';
        } else if (res.code == 31001){
          that.$message({
            message: res.message              
          });
          window.location.href = '/authcurator/first';
        }
      });
    },
    beforeIdCardUpload:function(file) {
      this.uploadloading = true;
    },
    handleIdCardSuccess: function(res, file) {
      if (res.success == true) {
        var a = {};
        a.url = ResHeader + res.path;
        this.list.idCardList = [];
        this.list.idCardList[0] = a;
      }
      this.uploadloading = false;
    }
  }
});