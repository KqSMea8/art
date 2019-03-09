var vmPasswd = new Vue({
  // element to mount to
  el: '#passwd',
  // initial data
  data: {
    oldPass: "",
    newPass: "",
    isSubmit: false
  },
  created: function () {

  },
  // methods
  methods: {
    changePass: function () {
      var that = this;
      var passreg = /^\w{6,16}$/;
      var data = {
        oldPassword: this.oldPass,
        newPassword: this.newPass
      };

      if(this.oldPass === '') {
          TipsShow.showtips({info:"请输入原密码"}); 
          return false;
      } else if(this.newPass === '') { 
          TipsShow.showtips({info:"请输入新密码"});   
          return false;
      } else if(!passreg.test(this.newPass)){
          TipsShow.showtips({info:"密码长度在6~16之间，只能包含字母、数字和下划线"});  
          return false;
      }

      console.log('修改密码.data', data);

      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      artzheAgent.call('UserCenter/setPassword', data, //修改密码
        function(res) { 
          that.isSubmit = false;
          console.log('修改密码.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              TipsShow.showtips({
                info: "修改成功"
              });
              setTimeout(function() {
                location.href = '/user/index';
              }, 1200);
            } else if (res.data.status == 1001) {
              TipsShow.showtips({
                info: "旧密码输入错误"
              });
            }
          }
        },
        function () {
          that.isSubmit = false;
          TipsShow.showtips({
            info: "服务器需要休息了，请稍后再试~"
          });
        }
      );

      // $.ajax({
      //     headers: {
      //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //     },
      //     url: "/api/UserCenter/setPassword",      //修改密码
      //     type: 'POST',
      //     dataType: "json",
      //     data: data,
      //     success:function(res){
      //       console.log('修改密码.res', res);
      //       if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
      //         window.location.href = "/wechat/login";
      //       } else if (res.code == '30000') {
      //         if (res.data.status == 1000) {
      //           TipsShow.showtips({
      //             info: "修改成功"
      //           });
      //           setTimeout(function() {
      //             location.href = '/user/index';
      //           }, 1200);
      //         }
      //       }
      //     }
      // });
    }
  }
});