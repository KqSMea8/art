
var mphone = /^1[34578]{1}\d{9}$/;
var passreg=/^\S{6,16}$/;
var chinese=/^[^\u4e00-\u9fa5]{6,16}$/;

// 点击下一步 btn-next
var loginMobile = new Vue({
  // element to mount to
  el: '#mobile-wrap',
  // initial data
  data: {
  	mobile: ''
  },
  // methods
  methods: {
  	next: function () {
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
	  // setCookie("mobile", this.mobile);
	  // rememberUser.remember(this.mobile);
	  $.ajax({
	  	headers: {
	  		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	  	},
	  	type: "POST",
	  	url: "/passport/checkPhone",
	  	data: data,
	  	success: function(res){
	  		console.log("next.res", res);
	  		if (res.state == 2000) {
	  			setCookie("mobile", that.mobile);
	  			setTimeout('window.location.href = "/passport/register";',1200);
	  		} else if (res.state == 4001) {
	  			setCookie("mobile", that.mobile);
	  			setTimeout('window.location.href = "/passport/login";',1200);
	  		}
	  	}
	  });
	}
}
});