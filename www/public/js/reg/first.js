var vmApp = new Vue({
  el: '#app',
  data: {
    errorTips: {
      mobile: '',
      imgCode: '',
      agree: ''
    },
    isClickgetVerify: false,
    getVerifyCodeText: '获取验证码',
    count: 60,
    errorTip: '',
    formData: {
      mobile: '',
      captcha: ''
    },
    isAgree: true,
    boxIsShow: false,
    isSubmit: false,
    btnText: '下一步'
  },
  mounted: function () {
    $(".imgcode").click(function(){ 
        var myDate = new Date();
        var newtime = myDate.getTime();
        $(this).attr("src", "/captcha?" + newtime);   
    });
  },
  methods: {
    submitForm: function (formName) {
      var that = this;
      var mobile = this.formData.mobile;
      var captcha = this.formData.captcha;
      if (!this.isAgree) {
        this.errorTips.agree = "请勾选《艺术者注册协议》";
        // return false;
      } else if (mobile == "") {
        this.errorTips.mobile = "请输入您的手机号";
        // return false;
      } else if (!validInfo.mobile.test(mobile)) {
        this.errorTips.mobile = "请输入正确的手机号";
        // return false;
      } else if (captcha == "") {
        this.errorTips.imgCode = "请输入验证码";
        // return false;
      }
      if (!this.isAgree || mobile == "" || !validInfo.mobile.test(mobile) || captcha == "") {
        setTimeout(function () {
          that.errorTips = {
            mobile: '',
            imgCode: '',
            agree: ''
          };
        }, 2000);
        return false;
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      this.btnText = '提交中...';

      // TipsShow.showtips({
      //   info: "提交中,请稍后..."
      // });
      $.ajax({
        type: "POST",
        url: "/passport/checkPhoneWithCaptcha",
        data: this.formData,
        success: function(res){
          that.isSubmit = false;
          console.log("next.res", res);
          if (res.state == 2000) {
            setCookie("regMobile", mobile);
            that.isClickgetVerify = true;
            that.getVerifyCode();
            that.btnText = '跳转中...';
            // window.location.href = '/register/second';
          } else if (res.state == 4004) {
            that.btnText = '下一步';
            that.errorTips.imgCode = "请输入正确的验证码";
          } else if (res.state == 4001) {
            that.btnText = '下一步';
            that.errorTips.mobile = "手机号已存在，请直接登录";
          }
          setTimeout(function () {
            that.errorTips = {
              mobile: '',
              imgCode: '',
              agree: ''
            };
          }, 2000);
          $(".imgcode").attr("src", "/captcha?" + new Date().getTime());
        }
      });
    },
    getVerifyCode: function () {
      console.log('getVerifyCode');
      var that = this;
      var data = {
        'to': this.formData.mobile
      };
      // $.ajax({
      //   type: "POST",
      //   url: '/public/sendCode', //获取手机验证码
      //   data: data,
      //   success: function(res) {
      //     that.isClickgetVerify = false;
      //     if (res.state == 2000) {
      //       window.location.href = '/register/second';
      //     }
      //   },
      //   complete: function () {
      //     that.isClickgetVerify = false;
      //   }
      // });

      artzheAgent.call('user/sendVerifyCode', {'mobile': this.formData.mobile},function(res) { //获取手机验证码
        that.isClickgetVerify = false;
        if (res.code == 30000) {
          window.location.href = '/register/second';
        }
      });
    },
    agreeToggle: function () {
      this.isAgree = !this.isAgree;
    },
    showXieyi: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    agreeRule: function () {
      this.isAgree = true;
      this.boxIsShow = false;
    },
    setTime: function (argument) {
      var that = this;
      var count = this.count;
      if (this.count == 0) {
        this.isClickgetVerify = false;
        this.getVerifyCodeText = "重新发送";
        this.count = 60;
        return false;
      } else {
        this.isClickgetVerify = true;
        this.getVerifyCodeText = this.count + "S";
        this.count = --count;
        // console.log(this.count);
      }
      setTimeout(function() {
        that.setTime();
      }, 1000);
    },
    changeImg: function () {
      captcha_src();
    }
  }
});