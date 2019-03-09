var vmUserIntro = new Vue({
  el: '#user-intro',
  data: {
    resume: '',
    isSubmit:false
  },
  created: function() {
    // body...
    var resume = document.getElementById('resume').value;
    if (resume == " 0 ") {
      this.resume = '';
    } else {
      this.resume = resume;
    }
    // var userInfo = Storage.get('userInfo');
    // this.resume = userInfo.resume;
  },
  methods: {
    changeResume: function() {
      // body...
      var that = this;
      this.resume = trimStr(this.resume);
      var resume = this.resume;
      var data = {
        resume: resume
      };
      if (resume.length < 1) {
        TipsShow.showtips({
          info: '请输入您的个人履历'
        });
        return false;
      }

      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      artzheAgent.call('UserCenter/setResume', data, //修改个人履历
        function(res) {
          that.isSubmit = false;
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isSubmit = false;
              that.resume = '';
              TipsShow.showtips({
                info: "修改成功"
              });
              location.href = '/user/index';
              // setTimeout(function() {
              //   location.href = '/user/index';
              // }, 1200);
            }
          } else {
            TipsShow.showtips({
              info: res.message
            });
          }
        },
        function () {
          that.isSubmit = false;
        }
      );

      // $.ajax({
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   },
      //   url: "/user/modify", //修改个人履历
      //   type: 'POST',
      //   dataType: "json",
      //   data: data,
      //   success: function(res) {
      //     console.log("修改个人履历.res", res);
      //     if (res.state == 2000) {
      //       TipsShow.showtips({
      //         info: res.info
      //       });
            
      //       setTimeout(function() {
      //         window.location.href = '/user/index';
      //       }, 1200);
      //     } else {
      //       TipsShow.showtips({
      //         info: res.info
      //       });
      //     }
      //   }
      // });
    }
  }
});