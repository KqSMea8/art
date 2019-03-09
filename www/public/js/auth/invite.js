var vmAuth = new Vue({
  el: '#app',
  data: {
    isApplyed: false,
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    errorTip: '',
    btnText: '下一步',
    isSubmit: false,
    ruleForm: {
      inviteCode: ''
    },
    rules: {
      inviteCode: [{
        required: true,
        message: '请输入邀请码',
        trigger: 'blur'
      }]
    },
    hasCode: false
  },
  created: function () {
    this.getLocal();
  },
  methods: {
    getLocal: function () {
      var that = this;
      artzheAgent.call('AuthArtist/getMyApply', {}, function(res) {
        // console.log(res);
        if (res.code == 30000) {
          
          var authInfo = res.data.info;
          if (res.data.info.invite_code) {
            that.ruleForm.inviteCode = res.data.info.invite_code;
            that.hasCode = true;
            window.location.href = '/auth/first';
          }
        }
      });
    },
    submitForm: function (formName) {
      var that = this;
      this.$refs[formName].validate((valid) => {
        if (valid) {
          //避免重复点击提交
          if (this.isSubmit) {
            return false;
          }
          this.isSubmit = true;
          this.btnText = "提交中...";

          artzheAgent.call('AuthArtist/stepOne',this.ruleForm,function(res) {
            that.isSubmit = false;
            console.log(res);
            if (res.code == 30000) {
              that.btnText = '跳转中...';
              window.location.href = '/auth/first';
            } else if (res.code == 30002) {
              that.btnText = '下一步';
              that.errorTip = '您输入的邀请码不存在';
            }
            setTimeout(function () {
              that.errorTip = '';
              }, 2000);
              return false;
            });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
  }
});