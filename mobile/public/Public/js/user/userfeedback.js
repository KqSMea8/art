var vmUserFeedback = new Vue({
  el: '#app',
  data: {
    content: '',
    isSubmit: false
  },
  created: function() {
    // body...

  },
  methods: {
    submitFeedback: function() {
      // body...
      this.content = trimStr(this.content);
      var that = this;
      var content = this.content;
      var data = {
        content: content
      };


      if (content.length < 1) {
        TipsShow.showtips({
          info: '请输入您的反馈内容'
        });
        return false;
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;
      artzheAgent.call('User/feedback', data, 
        function(res) { //反馈
          that.isSubmit = false;
          if (res.code == '30000') {
            if (res.data.status == 1000) {
              TipsShow.showtips({
                info: "提交成功"
              });
              that.content = '';
              setTimeout(function() {
                location.href = '/user/index';
              }, 1000);
            }
          }
        },
        function () {
          that.isSubmit = false;
        }
      );
    }
  }
});