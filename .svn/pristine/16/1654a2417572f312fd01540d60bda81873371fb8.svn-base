var vmApp = new Vue({
  el: '#app',
  data: {
    errorTip: '',
    isSubmit: false,
    rePassword: '',
    errorTips: {
      pass1: '',
      pass2: ''
    },
    btnText: '完成',
    formData: {
      mobile: getCookie('forgetMobile'),
      verifyCode: getCookie('forgetCode'),
      newPassword: ''
    }
  },
  methods: {
    submitForm: function () {
      var that = this;
      var mobile = this.formData.mobile;
      var verifyCode = this.formData.verifyCode;
      var newPassword = this.formData.newPassword;
      var password2 = this.rePassword;
      if (newPassword == "" || newPassword.length < 6 || newPassword.length > 16 || !validInfo.password.test(newPassword) || !validInfo.chinese.test(newPassword) || password2 == "" || newPassword != password2) {
        if (newPassword == "") {
          this.errorTips.pass1 = "请设置6-16位密码";
        } else if (newPassword.length < 6 || newPassword.length > 16) {
          this.errorTips.pass1 = "请输入6-16位密码";
        } else if (!validInfo.password.test(newPassword)) {
          this.errorTips.pass1 = "密码不能包含空格，汉字";
        } else if (!validInfo.chinese.test(newPassword)) {
          this.errorTips.pass1 = "密码不能包含空格，汉字";
        } else if (password2 == "") {
          this.errorTips.pass2 = "请再次输入您的密码";
        } else if (newPassword != password2) {
          this.errorTips.pass2 = "两次输入密码不一致";
        }
        setTimeout(function () {
          that.errorTips = {
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
      this.btnText = "提交中...";

      artzheAgent.call('user/resetPasswd',this.formData,function(res) {
        that.isSubmit = false;
        console.log(res);
        if (res.code == 30000) {
          that.btnText = "跳转中...";
          window.location.href = '/forget/third';
        } else if (res.code == 30110) {
          that.btnText = '完成';
          // that.errorTip = "验证码错误，请重新输入";
        } else if (res.code == 30111) {
          that.btnText = '完成';
          // that.errorTip = "您已注册，请直接登录";
        }
      });

      // window.location.href = '/forget/third';
    }
  }
});