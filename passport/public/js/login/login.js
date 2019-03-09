
var mphone = /^1[34578]{1}\d{9}$/;
var passreg=/^\S{6,16}$/;
var chinese=/^[^\u4e00-\u9fa5]{6,16}$/;

// 点击下一步 btn-next
var loginMobile = new Vue({
  // element to mount to
  el: '#mobile-wrap',
  // initial data
  data: {
  	mobile: '',
    password: '',
    open: false,
    isSubmit: false,
    checkState: true,
    loginState: false
  },
  // methods
  methods: {
    toggle: function() {
      this.open = !this.open;
    },
  	checkPhone: function () {
  		var that = this;
  		this.mobile = trimStr(this.mobile);
  		var data = {
  			mobile: this.mobile
  		};
  		if (this.mobile == "") {
  			TipsShow.showtips({
  				info: "请输入您的手机号"
  			});
  			return false;
  		} else if (!mphone.test(this.mobile)) {
  			TipsShow.showtips({
  				info: "请输入正确的手机号"
  			});
  			return false;
  		}
  	  setCookie("mobile", this.mobile);
  	  // rememberUser.remember(this.mobile);
  	  $.ajax({
  	  	type: "POST",
  	  	url: apiInfo.checkMobile,
  	  	data: data,
  	  	success: function(res){
  	  		console.log("next.res", res);
  	  		if (res.errno == 0) { //用户存在
  	  			that.checkState = false;
            that.loginState = true;
  	  		} else if (res.errno == 30005) { //手机号不存在
            // TipsShow.showtips({
            //   info: "手机号不存在"
            // });

            $.ajax({
              type: "POST",
              url: apiInfo.sendCode,
              data: data,
              success: function(resCode){
                // console.log(resCode);
                window.location.href = "/passport/user/register";
              }
            });
  	  		}
  	  	},
  	  });
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
        url: apiInfo.mobileLogin,
        data: {
          'mobile': this.mobile,
          'password': password
        },
        success: function(res) {
          // rememberUser.remember(that.mobile);
          that.isSubmit = false;
          if (res.errno == 0) {
            TipsShow.showtips({
              info: "登录成功,跳转中..."
            });
            if (res.data.redirect) {
              window.location.href = res.data.redirect;
            } else {
              window.location.href = "/";
            }
          } else {
            TipsShow.showtips({
              info: res.message,
              timer: 1200
            });
          }
        }
      });
    }
  }
}
});