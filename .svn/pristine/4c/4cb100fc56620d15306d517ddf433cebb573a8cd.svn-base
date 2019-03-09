
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
      this.mobile = trimStr(this.mobile);
      if (this.mobile == "") {
        TipsShow.showtips({
          info: "请输入手机号"
        });
        return false;
      } else if (!mphone.test(this.mobile)) {
        TipsShow.showtips({
          info: "请输入正确的手机号"
        });
        return false;
      }
      rememberUser.remember(this.mobile);
      // $.ajax({
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   },
      //   type: "POST",
      //   url: "/Passport/checkPhone",  //检查手机号是否存在
      //   data: {'mobile': this.mobile},
      //   success: function(result){
      //     rememberUser.remember(this.mobile);
      //     window.location.href = result.url;
      //     that.isSubmit = false;
      //   }
      // });
    }
  }
});

// 点击下一步 btn-next
var vmReg = new Vue({
  // element to mount to
  el: '#reg-wrap',
  // initial data
  data: {
    mobile: ''
  },
  // methods
  methods: {
    getVerifyCode: function () {
      // body...
    },
    reg: function () {
      // body...
    }
  }
});