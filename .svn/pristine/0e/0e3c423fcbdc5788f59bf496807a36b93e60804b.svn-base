var vmAuth = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    btnText: '下一步',
    errorTip: '',
    ruleForm: {
      trueName: '',
      phone: getCookie('userMobile'),
      email: '',
      resume: ''
    },
    isSubmit: false,
    rules: {
      trueName: [{
        required: true,
        message: '请输入您的真实姓名',
        trigger: 'blur'
      }, {
        pattern: validInfo.notEmply,
        message: '请输入您的真实姓名',
        trigger: 'blur'
      }],
      phone: [{
        required: true,
        message: '请输入手机号',
        trigger: 'blur'
      }, {
        max: 11,
        pattern: validInfo.mobile,
        message: '请输入正确的手机号',
        trigger: 'blur'
      }],
      email: [{
        required: true,
        message: '请输入常用邮箱',
        trigger: 'blur'
      }, {
        pattern: validInfo.email,
        message: '请输入正确的邮箱',
        trigger: 'blur'
      }],
      resume: [{
        required: true,
        message: '请输入您的个人履历',
        trigger: 'blur'
      }, {
        pattern: validInfo.notEmply,
        message: '请输入您的个人履历',
        trigger: 'blur'
      }]
    },
    otherIsActive: false
  },
  created: function () {
     this.getLocal();
  },
  methods: {
    getLocal: function (cb) {
      var that = this;
      artzheAgent.call('AuthPlanner/getAuthInfo', {}, function(res) {
        // console.log(res);
        if (res.code == 30000) {
          if (res.data.info) {
            Storage.set('authPlannerInfo', res.data.info);
            var authInfo = res.data.info;
            that.ruleForm = {
              trueName: authInfo.truename,
              phone: authInfo.phone, //
              email: authInfo.email,
              resume: authInfo.resume
            };
            if (!authInfo.phone) {
              that.ruleForm.phone = getCookie('userMobile');
            }
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
          var formData = this.ruleForm;
          
          for (var prop in formData) {
            formData[prop] = trimStr(formData[prop]);
          }
          // console.log(formData);
          // return false;

          artzheAgent.call('AuthPlanner/stepOne',formData,
            function(res) {
              that.isSubmit = false;
              // console.log(res);
              if (res.code == 30000) {
                that.btnText = '跳转中...';
                window.location.href = '/authcurator/second';
              }
            },
            function (res) {
              that.isSubmit = false;
            }
          );
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    toggleActive: function () {
      this.otherIsActive = !this.otherIsActive;
    }
  }
});