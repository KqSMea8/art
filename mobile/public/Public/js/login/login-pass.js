var mphone = /^1[34578]{1}\d{9}$/;
var passreg = /^\S{6,16}$/;
var chinese = /^[^\u4e00-\u9fa5]{6,16}$/;

var mobile = getCookie('mobile');

// 点击登录
var vmPass = new Vue({
  // element to mount to
  el: '#pass-wrap',
  // initial data
  data: {
    open: false,
    mobile: mobile,
    password: '',
    isSubmit: false,
    userInfo: {
      nickname: '',
      face: ''
    }
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
    login: function() {
      // body...
      var that = this;
      var password = this.password;
      if (password == "") {
        TipsShow.showtips({
          info: "请填写密码"
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
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: "/Passport/checkLogin",
          data: {
            'mobile': this.mobile,
            'passwd': password
          },
          success: function(res) {
            rememberUser.remember(that.mobile);
            that.isSubmit = false;
            if (res.state == 2000) {
              setCookie("mobile", that.mobile);
              TipsShow.showtips({
                info: "登录成功,跳转中..."
              });
              // setTimeout('window.location.href = "/index/recommend";', 1200);
              var historyUrl = getCookie('localmobile_HistoryUrl') || '/index/recommend';
              window.location.href = historyUrl;
            } else {
              TipsShow.showtips({
                info: res.msg,
                timer: 1200
              });
            }
          }
        });
      }
    }
  }
});