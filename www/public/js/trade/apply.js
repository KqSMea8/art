var vmApp = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    isAgree: false, //是否同意协议
    loading: true, //页面是否在加载中
    isSubmit: false, //是否提交申请
    isApplyed: false, //是否申请过
    Mallstatus: -3, //申请状态 1通过，0审核中，2不通过
    btnText: "提交申请",
    applyMallInfo: {
      isApplyed: false,
      Mallstatus: -3, //申请状态 1通过，0审核中，2不通过
      checkMsg: ''
    },
    uploadloading: false, //图片上传中
    list: {
      idCardList: [
        // {url: '//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/13/cover.png'}
      ]
    },
  },
  created: function() {
    
  },
  mounted: function () {
    eventBus.$on('setMallStatus', function(info) {
      this.applyMallInfo = info;
      if (this.applyMallInfo.Mallstatus == 1) {
        window.location.href = "/trade/artwork";
      }
      this.$nextTick(function () {
        
      });
    }.bind(this));
  },
  methods: {
    agree: function () {
      var that = this;
      this.isAgree = true;
      
    },
    applySeller: function () {

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
    },
    joinMall: function () {
      var that = this;
      if (this.list.idCardList.length === 0) {
        that.$message({
          message: '请上传手持身份证照片'
        });
      }
      if (this.isSubmit) {
        return false;
      }
      var data = {
        id_card_image: this.list.idCardList[0].url
      };
      that.isSubmit = true;
      that.btnText = "提交中...";
      artzheAgent.callMP('User/ArtistJoinMall', data, function(response) {
        that.isSubmit = false;
        that.btnText = "提交成功";
        if (response.data.status == 1000 && response.code == 30000) {
          that.applyMallInfo.isApplyed = true;
          that.applyMallInfo.Mallstatus = 0;
        }
      }, function(res) {
        that.isSubmit = false;
      });
    }
  }
});