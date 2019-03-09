var vmUserProfile = new Vue({
  // element to mount to
  el: '#user-profile',
  // initial data
  data: {
    boxIsShow: false,
    qrcodeIsShow: false,
    downloadIsShow: false,
    boxMsg: '',
    userInfo: {},
  },
  created: function () {
    this.init();
  },
  // methods
  methods: {
    init: function () {
      var that = this;

      artzheAgent.call('UserCenter/getMyProfile', {}, //获取修改资料页面
        function(res) {
          console.log('获取修改资料页面.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              var userInfo = res.data.info;
              if (userInfo.birthday == '0') {
                userInfo.birthday = '保密';
              } else {
                userInfo.birthday = unixToTime(userInfo.birthday);
              }
              if (userInfo.resume) {
                userInfo.isArtist = true;
              } else {
                userInfo.isArtist = false;
              }
              that.userInfo = userInfo;
              if (that.userInfo.qrCodeUrl) {
                that.$nextTick(function () {
                  new QRCode(document.getElementById("qrcode"), that.userInfo.qrCodeUrl);
                });
              }
            }
          }
        }
      );
    },
    showDownload: function(msg) {
      this.boxMsg = msg;
      this.boxIsShow = true;
      this.downloadIsShow = true;
    },
    showQrcode: function () {
      this.boxIsShow = true;
      this.qrcodeIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.qrcodeIsShow = false;
      this.downloadIsShow = false;
    }
    // getScreenShot: function () {
    //   var url = $('#qrcode img')[0].src;
    //   console.log(url);
    //   var triggerDownload = $("<a>").attr("href", url).attr("download", this.userInfo.nickname+"的艺术画廊.png").appendTo("body");
    //   triggerDownload[0].click();
    //   triggerDownload.remove();
    // }
  }
});