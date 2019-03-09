var mphone = /^1[34578]{1}\d{9}$/;
var passreg = /^\S{6,16}$/;
var chinese = /^[^\u4e00-\u9fa5]{6,16}$/;

var mobile = getCookie('mobile');


// 点击注册 btn-reg
var vmReg = new Vue({
  // element to mount to
  el: '#reg-wrap',
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
    },
    isAgree: true
  },
  created: function() {
    var nickname = document.getElementById('nickname').value || '';
    var face = document.getElementById('face').value || '';
    this.userInfo.nickname = nickname;
    this.userInfo.face = face;
  },
  // methods
  methods: {
    toggle: function() {
      this.open = !this.open;
    },
    getVerifyCode: function() {
      var that = this;
      var data = {
        to: this.mobile
      };
      if (this.isClickgetVerify) {
        return false;
      }
      this.setTime();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/public/sendCode', //获取手机验证码
        data: data,
        success: function(res) {
          console.log('获取手机验证码', res);
          if (res.state == 2000) {
            // that.verifycode = 1234;
            // that.verifycode = res.data.verifycode;
          }

        }
      });
    },
    agreeToggle: function () {
      this.isAgree = !this.isAgree;
    },
    reg: function() {
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
      } else if (!chinese.test(password)) {
        TipsShow.showtips({
          info: "密码不能包含空格，汉字"
        });
        return false;
      }
      else if (!this.isAgree) {
        TipsShow.showtips({
          info: "请勾选《艺术者注册协议》"
        });
        return false;
      }
      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      TipsShow.showtips({
        info: "提交中,请稍后..."
      });
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/passport/checkBind", //注册
        data: {
          'to': this.mobile,
          'code': verifycode,
          'passwd': password
        },
        success: function(res) {
          that.isSubmit = false;
          if (res.state == 2000) {
            TipsShow.showtips({
              info: "注册成功,跳转中..."
            });
            var historyUrl = getCookie('localmobile_HistoryUrl') || '/index/recommend';
            window.location.href = historyUrl;
            // setTimeout('window.location.href = "/user/index";', 1200);
          } else {
            TipsShow.showtips({
              info: res.msg
            });
          }
        }
      });

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