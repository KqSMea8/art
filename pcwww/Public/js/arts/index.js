var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin:false, //是否登陆
    boxIsShow: false,
    isRemember: true,
    userInfo: {
      mobile: '',
      password: '',
      from:'pc'
    },
    authHref: switchDomin('mp')
  },
  created: function() {

  },
  mounted: function() {
    
  },
  methods: {
    checkLogin: function (cb) {
      var that = this;
      artzheAgent.call('UserCenter/getMyGalleryDetail',{},function(res) {
        if (res.code == 30000) {
          that.myInfo = {
            uid: res.data.info.artist,
            name: res.data.info.name,
            face: res.data.info.faceUrl
          };
          setCookie('userid', res.data.info.artist);
          setCookie('userName', res.data.info.name);
          setCookie('userFace', res.data.info.faceUrl);
          setCookie('userMobile', res.data.info.mobile);

          that.applyStatus = res.data.info.applyStatus;
          if (res.data.info.isArtist == '1') {
            that.artistInfo = {
              faceUrl : res.data.info.faceUrl,
              name: res.data.info.name,
              motto: res.data.info.motto
            }
            // window.location.href = '/upload/manage';
          } else {
            that.applyRemark = res.data.info.applyRemark;
            typeof cb == "function" && cb();
          }
          that.$nextTick(function () {
            that.isLogin = true;
          });
        } else {
          deleteCookie('userid');
          deleteCookie('userName');
          deleteCookie('userFace');
          deleteCookie('userMobile');
          that.isLogin = false;
        }
        that.isCheck = false;
      });
    },
    accountLogin: function () {
      var that = this;
      var mobile = this.userInfo.mobile;
      var password = this.userInfo.password;
      if (mobile == "" || !validInfo.mobile.test(mobile) || password == "" || password.length < 6 || password.length > 16 || !validInfo.password.test(password) || !validInfo.chinese.test(password)) {
        if (mobile == "") {
          this.errorTip = "请输入您的手机号";
          // return false;
        } else if (!validInfo.mobile.test(mobile)) {
          this.errorTip = "请输入正确的手机号";
          // return false;
        } else if (password == "") {
          this.errorTip = "请输入您的密码";
          // return false;
        } else if (password.length < 6 || password.length > 16) {
          this.errorTip = "请输入6-16位密码";
          // return false;
        } else if (!validInfo.password.test(password)) {
          this.errorTip = "密码不能包含空格，汉字";
          // return false;
        } else if (!validInfo.chinese.test(password)) {
          this.errorTip = "密码不能包含空格，汉字";
          // return false;
        } 
        setTimeout(function () {
          that.errorTip = '';
        }, 2000);
        return false;
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;
      this.btnText = "登录中...";

      artzheAgent.call('user/accountLogin',this.userInfo,function(res) {
        that.isSubmit = false;
        that.btnText = "登录";
        // console.log(res);
        if (res.code == 30000) {
          setCookie('userid', res.data.userid);
          setCookie('userMobile', that.userInfo.mobile);
          // window.location.href = '/';
          that.checkLogin();
          // if (res.data.isArtist == '1') {
          //   window.location.href = '/upload/manage';
          // } else {
          //   that.checkLogin();
          //   // that.applyInfo.tips = '认证成为艺术家，即可上传作品';
          //   // that.applyInfo.btnText = '认证艺术家';
          //   // that.isLogin = true;
          // }
        } else if (res.code == 30111) {
          that.errorTip = "您输入的帐号或者密码不正确，请重新输入";
          setTimeout(function () {
            that.errorTip = '';
          }, 2000);
          return false;
        }
      });
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    toggleRemember: function () {
      this.isRemember = !this.isRemember;
    }
  }
});