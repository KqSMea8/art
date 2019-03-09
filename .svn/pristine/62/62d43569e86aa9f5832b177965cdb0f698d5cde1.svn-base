$(function() {
  var today = new Date();

  function showDate(objD) {
    var str, colorhead, colorfoot;
    var yy = objD.getYear();
    if (yy < 1900) yy = yy + 1900;
    var MM = objD.getMonth() + 1;
    var dd = objD.getDate();
    str = "本协议自" + yy + "年" + MM + "月" + dd + "日（北京时间）起生效。";
    return (str);
  }
  document.getElementById("today").innerHTML = showDate(today);

  //注册协议弹窗
  var oXieyiclick = $('#j_xieyiclick'),
    oXieyibox = $('#j_xieyibox'),
    oXieyimask = $('.reg_bg');
  oXieyiclick.click(function() {
    $('html,body').css({
      'height': '100%',
      'overflow': 'hidden'
    });
    oXieyimask.show();
    oXieyibox.show();
  });
  $("#j_xieyibox em,.reg_bg,#btn_agreen").click(function() {
    if ($(this).attr('id') == 'btn_agreen') {
      $("#j_checkbox").addClass('cur');
    }
    $('html,body').css({
      'height': 'auto',
      'overflow': 'auto'
    });
    oXieyimask.hide();
    oXieyibox.hide();
  });
});

var vmApp = new Vue({
  el: '#app',
  data: {
    loginForm: {
      mobile: '',
      password: '',
      from: 'pc'
    },
    regForm: {
      mobile: '',
      verifyCode: '',
      newPassword: '',
      from: 'pc'
    },
    // 注册登录相关
    isSubmit: false,
    isClickgetVerify:false,
    count: 60,
    getVerifyCodeText: '获取验证码'
  },
  created: function() {

  },
  mounted: function() {

  },
  methods: {
    toLogin: function () {
      var that = this;
      var api = '/Api/Wechat/bindNewWeChat';
      var mobile = this.loginForm.mobile;
      var password = this.loginForm.password;
      var data = this.loginForm;

      if (mobile == "" || !validInfo.mobile.test(mobile) || password == "" || password.length < 6 || password.length > 16 || !validInfo.password.test(password) || !validInfo.chinese.test(password)) {
        if (mobile == "") {
          new Toast({message: '请输入您的手机号'});
        } else if (!validInfo.mobile.test(mobile)) {
          new Toast({message: '请输入正确的手机号'});
        } else if (password == "") {
          new Toast({message: '请输入您的密码'});
        } else if (password.length < 6 || password.length > 16) {
          new Toast({message: '请输入6-16位密码'});
        } else if (!validInfo.password.test(password)) {
          new Toast({message: '密码不能包含空格，汉字'});
        } else if (!validInfo.chinese.test(password)) {
          new Toast({message: '密码不能包含空格，汉字'});
        } 
        return false;
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == 30000 && res.data.status == 1000) {
            window.location.href = res.data.go_url;
          } else if (res.code == 30111) {
            new Toast({message: '您输入的帐号或者密码不正确，请重新输入'});
          }
        }, 
        complete: function (res) {
          that.isSubmit = false;
        }
      });
    },
    toReg: function () {
      var that = this;
      var api = '/Api/Wechat/bindNewWeChat';
      var mobile = this.regForm.mobile;
      var password = this.regForm.newPassword;
      var verifyCode = this.regForm.verifyCode;
      var data = this.regForm;

      if (mobile == "" || !validInfo.mobile.test(mobile) || password == "" || password.length < 6 || password.length > 16 || !validInfo.password.test(password) || !validInfo.chinese.test(password) || verifyCode == "" || !validInfo.verifyCode.test(verifyCode)) {
        if (mobile == "") {
          new Toast({message: '请输入您的手机号'});
        } else if (!validInfo.mobile.test(mobile)) {
          new Toast({message: '请输入正确的手机号'});
        } else if (password == "") {
          new Toast({message: '请输入您的密码'});
        } else if (password.length < 6 || password.length > 16) {
          new Toast({message: '请输入6-16位密码'});
        } else if (!validInfo.password.test(password)) {
          new Toast({message: '密码不能包含空格，汉字'});
        } else if (!validInfo.chinese.test(password)) {
          new Toast({message: '密码不能包含空格，汉字'});
        } else if (verifyCode == "") {
          new Toast({message: '请输入短信验证码'});
        } else if (!validInfo.verifyCode.test(verifyCode)) {
          new Toast({message: '验证码错误，请重新输入'});
        }
        return false;
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == 30000 && res.data.status == 1000) {
            window.location.href = res.data.go_url;
          } else if (res.code == 30110) {
            new Toast({message: '验证码错误，请重新输入'});
          } else if (res.code == 30112) {
            new Toast({message: '验证码过期，请重新获取'});
          } else if (res.code == 30114) {
            new Toast({message: '您已注册，请直接登录'});
          }
        }, 
        complete: function (res) {
          that.isSubmit = false;
        }
      });
    },
    getVerifyCode: function () {
      var that = this;
      var mobile = this.regForm.mobile;
      var data = {
        'mobile': this.regForm.mobile,
      };

      if (mobile == "" || !validInfo.mobile.test(mobile)) {
        if (mobile == "") {
          new Toast({message: '请输入您的手机号'});
        } else if (!validInfo.mobile.test(mobile)) {
          new Toast({message: '请输入正确的手机号'});
        }
        return false;
      }

      if (that.isClickgetVerify) {
        return false;
      }
      that.setTime();

      $.ajax({
        type: "POST",
        url: '/Api/User/sendVerifyCode', //获取手机验证码
        data: data,
        success: function(res) {
          // console.log('获取手机验证码', res);
          if (res.code == 30000 && res.data.status == 1000) {

          }
        }
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
  },
  filters: {
    timeFormat: function(value) {
      value = value * 1000;
      var dateTime = new Date(value);
      // console.log(dateTime);
      var year = dateTime.getFullYear();
      var month = dateTime.getMonth() + 1;
      var day = dateTime.getDate();
      var hour = dateTime.getHours();
      var minute = dateTime.getMinutes();
      var second = dateTime.getSeconds();
      var now = new Date();
      var now_new = now.getTime(); //js毫秒数

      var milliseconds = 0;
      var timeSpanStr;

      timeSpanStr = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;

      return timeSpanStr;
    }
  }
});