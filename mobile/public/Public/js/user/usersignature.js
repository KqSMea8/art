var vmUserSignature = new Vue({
  el: '#user-signature',
  data: {
    motto: '',
    isSubmit: false
  },
  created: function() {
    // body...
    // var motto = document.getElementById('motto').value;
    // if (motto == " 0 ") {
    //   this.motto = '';
    // } else {
    //   this.motto = motto;
    // }
    var userInfo = Storage.get('userInfo');
    this.motto = userInfo.motto;
  },
  methods: {
    changeMotto: function () {
      // body...
      var that = this;
      this.motto = trimStr(this.motto);
      var motto = this.motto;
      var data = {
        motto: motto
      };

      if (motto.length < 10 ) {
        TipsShow.showtips({
          info: '个性签名字数不能少于10个'
        });
        return false;
      }
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;
      artzheAgent.call('UserCenter/setMotto', data, //修改个性签名
        function(res) {
          that.isSubmit = false;
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isSubmit = false;
              that.motto = '';
              TipsShow.showtips({
                info: "修改成功"
              });
              setTimeout(function() {
                location.href = '/user/index';
              }, 1200);
            }
          }
        },
        function (res) {
          that.isSubmit = false;
        }
      );
    }
  }
});