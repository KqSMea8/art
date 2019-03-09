var vmApp = new Vue({
  el: '#app',
  data: {
    isClickgetVerify: false,
    isSubmit: false,
    getVerifyCodeText: '获取验证码',
    count: 60,
    errorTip: '',
    errorTips: {
      mobile: '',
      code: ''
    },
    btnText: '下一步',
    formData: {
      mobile: '',
      verifyCode: ''
    },
  },
  methods: {
    submitForm: function (formName) {
      var that = this;
      var mobile = this.formData.mobile;
      var verifyCode = this.formData.verifyCode;
      if (mobile == "" || !validInfo.mobile.test(mobile) || verifyCode == "" || !validInfo.verifyCode.test(verifyCode)) {
        if (mobile == "") {
          this.errorTips.mobile = "请输入您的手机号";
        } else if (!validInfo.mobile.test(mobile)) {
          this.errorTips.mobile = "请输入正确的手机号";
        } else if (verifyCode == "") {
          this.errorTips.code = "请输入短信验证码";
        } else if (!validInfo.verifyCode.test(verifyCode)) {
          this.errorTips.code = "验证码错误，请重新输入";
        }
        setTimeout(function () {
          that.errorTips = {
            mobile: '',
            code: ''
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
      $.ajax({
        type: "POST",
        url: "/passport/checkPhoneWithCode",
        data: {
          mobile: mobile,
          code: verifyCode
        },
        success: function(res){
          that.isSubmit = false;
          console.log("next.res", res);
          if (res.state == 2000) {
            that.errorTips.mobile = "手机号不存在，请先注册";
            that.btnText = '下一步';
            // setTimeout('window.location.href = "/passport/register";',1200);
          } else if (res.state == 4001) {
            that.errorTips.code = "请输入正确的验证码";
            that.btnText = '下一步';
            // setTimeout('window.location.href = "/passport/login";',1200);
          } else if (res.state == 4002) {
            that.btnText = "跳转中...";
            setCookie("forgetMobile", mobile);
            setCookie("forgetCode", verifyCode);
            window.location.href = "/forget/second";
          }
          setTimeout(function () {
            that.errorTips = {
              mobile: '',
              code: ''
            };
          }, 2000);
        }
      });
    },
    getVerifyCode: function () {
      console.log('getVerifyCode');
      var that = this;
      var mobile = this.formData.mobile;
      var data = {
        to: this.formData.mobile
      };
      if (mobile == "" || !validInfo.mobile.test(mobile)) {
        if (mobile == "") {
          this.errorTips.mobile = "请输入您的手机号";
        } else if (!validInfo.mobile.test(mobile)) {
          this.errorTips.mobile = "请输入正确的手机号";
        } 
        setTimeout(function () {
          that.errorTips = {
            mobile: '',
            code: ''
          };
        }, 2000);
        return false;
      }
      $.ajax({
        type: "POST",
        url: "/passport/checkPhone",
        data: {mobile: mobile},
        success: function(res){
          that.isSubmit = false;
          console.log("checkPhone.res", res);
          if (res.state == 2000) {

            that.errorTips.mobile = "手机号不存在，请先注册";
            setTimeout(function () {
              that.errorTips = {
                mobile: '',
                code: ''
              };
            }, 3000);
            return false;
          } else if (res.state == 4001) {
            if (that.isClickgetVerify) {
              return false;
            }
            that.setTime();
            $.ajax({
              type: "POST",
              url: "/public/sendCode", //发送验证码
              data: data,
              success: function(res){
                that.isSubmit = false;
                console.log("sendCode.res", res);
                if (res.state == 2000) {
                  
                  // that.btnText = '下一步';
                  // setTimeout('window.location.href = "/passport/register";',1200);
                } 
              }
            });
          }
        }
      });



      // artzheAgent.call('user/sendVerifyCode',this.formData,function(res) {
      //   console.log(res);
      //   if (res.code == 30000) {
      //   } else if (res.code == 30111) {
      //   }
      // });
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