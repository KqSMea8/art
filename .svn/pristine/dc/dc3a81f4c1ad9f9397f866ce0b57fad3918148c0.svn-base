var mphone = /^1[34578]{1}\d{9}$/;
var passreg = /^\S{6,16}$/;
var chinese = /^[^\u4e00-\u9fa5]{6,16}$/;

var mobile = getCookie('mobile');

// 忘记密码点击登录
var vmReg = new Vue({
  // element to mount to
  el: '#forget-wrap',
  // initial data
  data: {
    open: false,
    mobile: mobile,
    verifycode: '',
    password: '',
    getVerifyCodeText: '获取验证码',
    isClickgetVerify: false,
    count: 60,
    isSubmit: false,
    userInfo: {
      nickname: '',
      face: ''
    }
  },
  created: function() {
    // var nickname = document.getElementById('nickname').value || '';
    // var face = document.getElementById('face').value || '';
    // this.userInfo.nickname = nickname;
    // this.userInfo.face = face;
  },
  // methods
  methods: {
    toggle: function() {
      this.open = !this.open;
    },
    getVerifyCode: function() {
      var that = this;

      if (this.isClickgetVerify) {
        return false;
      }

      this.setTime();

      $.ajax({
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: apiInfo.sendCode, //发送手机验证码
        data: {
          'mobile': this.mobile
        },
        success: function(res) {

        }
      });
    },
    login: function() {
      // body...
      var that = this;
      var verifycode = this.verifycode;
      var password = this.password;
      if (verifycode == "") {
        TipsShow.showtips({
          info: "请输入短信验证码"
        });
        return false;
      } else if (password == "") {
        TipsShow.showtips({
          info: "请输入您的密码"
        });
        return false;
      } else if (password.length < 6 || password.length > 16) {
        TipsShow.showtips({
          info: "请设置6-16位密码"
        });
        return false;
      } else if (!passreg.test(password)) {
        TipsShow.showtips({
          info: "密码不能包含空格，汉字"
        });
        return false;
      } else {
        //避免重复点击提交
        if (this.isSubmit) {
          return false;
        }
        this.isSubmit = true;

        TipsShow.showtips({
          info: "提交中,请稍后"
        });
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: apiInfo.resetPasswd,  //重置密码
          data: {
            'mobile': this.mobile,
            'code': verifycode,
            'newPassword': password
          },
          success: function(res) {
            that.isSubmit = false;
            if (res.errno === 0) {
              // rememberUser.remember(that.mobile);
              // setTimeout('window.location.href = "/user/index";', 1200);
            } else {
              TipsShow.showtips({
                info: res.message
              });
            }
          }
        });
      }
    },
    setTime: function() {
      var that = this;
      var count = this.count;
      if (this.count == 0) {
        this.isClickgetVerify = false;
        this.getVerifyCodeText = "重新发送";
        this.count = 60;
        return false;
      } else {
        this.isClickgetVerify = true;
        this.getVerifyCodeText = this.count + "s";
        this.count = --count;
        // console.log(this.count);
      }

      setTimeout(function() {
        that.setTime();
      }, 1000);
    }
  }
});