var vmUser = new Vue({
  el: '#nickname',
  data: {
    nickname: '',
    isSubmit: false
  },
  created: function() {
    // body...
    // var nickname = document.getElementById('nick').value;
    // if (nickname == " 0 ") {
    //   this.nickname = '';
    // } else {
    //   this.nickname = nickname;
    // }
    var userInfo = Storage.get('userInfo');
    this.nickname = userInfo.name;

  },
  methods: {
    changeNickname: function() {
      var that = this;
      this.nickname = trimStr(this.nickname);
      var nickname = this.nickname;
      var pattern = /^[a-zA-Z0-9_\-\u4e00-\u9fa5]{1,24}$/;
      var nickLen = zhStrlen(nickname);
      var data = {
        nickname: nickname
      };

      if ((nickLen < 4 && nickLen != 0) || nickLen > 24) {
        TipsShow.showtips({
          info: '昵称只支持4-24位数字，字母，汉字_和—'
        });
        return false;
      }

      if (!pattern.test(nickname)) {
        TipsShow.showtips({
          info: '昵称只支持4-24位数字，字母，汉字_和—'
        });
        return false;
      }

      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      artzheAgent.call('UserCenter/setNickname', data, //修改昵称
        function(res) {
          that.isSubmit = false;
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isSubmit = false;
              that.nickname = '';
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
    }
  }
});