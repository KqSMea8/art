var vmApp = new Vue({
  el: '#app',
  data: {
    isClickgetVerify: false,
    getVerifyCodeText: '获取验证码',
    count: 60,
    errorTip: '',
    errorTips: {
      code: '',
      pass1: '',
      pass2: ''
    },
    btnText: '注册',
    formData: {
      mobile: getCookie('regMobile'),
      verifyCode: '',
      password: '',
      password2: '',
      from:'pc'
    }, 
  },
  created: function () {
    this.setTime();
  },
  methods: {
    submitForm: function (formName) {
      var that = this;
      var mobile = this.formData.mobile;
      var verifyCode = this.formData.verifyCode;
      var password = this.formData.password;
      var password2 = this.formData.password2;
      if (verifyCode == "" || !validInfo.verifyCode.test(verifyCode) || password == "" || password.length < 6 || password.length > 16 || !validInfo.password.test(password) || !validInfo.chinese.test(password) || password2 == "" || password != password2) {
        if (verifyCode == "") {
          this.errorTips.code = "请输入短信验证码";
        } else if (!validInfo.verifyCode.test(verifyCode)) {
          this.errorTips.code = "验证码错误，请重新输入";
        } else if (password == "") {
          this.errorTips.pass1 = "请设置6-16位密码";
        } else if (password.length < 6 || password.length > 16) {
          this.errorTips.pass1 = "请输入6-16位密码";
        } else if (!validInfo.password.test(password)) {
          this.errorTips.pass1 = "密码不能包含空格，汉字";
        } else if (!validInfo.chinese.test(password)) {
          this.errorTips.pass1 = "密码不能包含空格，汉字";
        } else if (password2 == "") {
          this.errorTips.pass2 = "请再次输入您的密码";
        } else if (password != password2) {
          this.errorTips.pass2 = "两次输入密码不一致";
        }
        setTimeout(function () {
          that.errorTips = {
            code: '',
            pass1: '',
            pass2: ''
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

      artzheAgent.call('user/accountLogin',this.formData,function(res) {
        that.isSubmit = false;
        that.btnText = '注册';
        console.log(res);
        if (res.code == 30000) {
          that.btnText = "跳转中...";
          window.location.href = '/register/third';
        } else if (res.code == 30110) {
          that.errorTips.code = "验证码错误，请重新输入";
        } else if (res.code == 30111) {
          that.errorTip = "您已注册，请直接登录";
        }
        setTimeout(function () {
          that.errorTip = '';
          that.errorTips = {
            code: '',
            pass1: '',
            pass2: ''
          };
        }, 2000);
        return false;
      });
    },
    getVerifyCode: function () {
      console.log('getVerifyCode');
      var that = this;
      var data = {
        'to': this.formData.mobile
      };
      if (that.isClickgetVerify) {
        return false;
      }
      that.setTime();

      // $.ajax({
      //   type: "POST",
      //   url: '/public/sendCode', //获取手机验证码
      //   data: data,
      //   success: function(res) {
      //     console.log('获取手机验证码', res);
      //     if (res.state == 2000) {
      //     }
      //   }
      // });
      artzheAgent.call('user/sendVerifyCode', {'mobile': this.formData.mobile}, function(res) { //获取手机验证码
        console.log(res);
      });
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
    }
  }
});