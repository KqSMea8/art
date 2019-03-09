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
      name: '',
      adminName: '',
      adminPhone: '',
      adminEmail: '',
      type: ''
    },
    isSubmit: false,
    rules: {
      name: [{
        required: true,
        message: '请输入机构名称',
        trigger: 'blur'
      }, {
        pattern: validInfo.notEmply,
        message: '请输入机构名称',
        trigger: 'blur'
      }],
      adminName: [{
        required: true,
        message: '请输入管理员的真实姓名',
        trigger: 'blur'
      }, {
        pattern: validInfo.notEmply,
        message: '请输入管理员的真实姓名',
        trigger: 'blur'
      }],
      adminPhone: [{
        required: true,
        message: '请输入手机号',
        trigger: 'blur'
      }, {
        max: 11,
        pattern: validInfo.mobile,
        message: '请输入正确的手机号',
        trigger: 'blur'
      }],
      adminEmail: [{
        required: true,
        message: '请输入管理员邮箱',
        trigger: 'blur'
      }, {
        pattern: validInfo.email,
        message: '请输入正确的邮箱',
        trigger: 'blur'
      }],
      type: [{
        required: true,
        message: '请选择机构类型',
        trigger: 'change'
      }]
    },
    types: []
  },
  created: function () {
    this.getAgency(this.getLocal());
  },
  methods: {
    getLocal: function (cb) {
      var that = this;
      artzheAgent.call('AuthAgency/getAuthInfo', {}, function(res) {
        // console.log(res);
        if (res.code == 30000) {
          if (res.data.info) {
            Storage.set('authAgencyInfo', res.data.info);
            var authInfo = res.data.info;
            // console.log(authInfo);
            that.ruleForm = {
              name: authInfo.name,
              adminName: authInfo.admin_name,
              adminPhone: authInfo.admin_phone,
              adminEmail: authInfo.admin_email,
              type: authInfo.type
            };
            if (!authInfo.mobile) {
              that.ruleForm.mobile = getCookie('userMobile');
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

          artzheAgent.call('AuthAgency/stepOne',formData,function(res) {
            that.isSubmit = false;
            // console.log(res);
            if (res.code == 30000) {
              that.btnText = '跳转中...';
              window.location.href = '/autharts/second';
            }
          });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    getAgency: function (cb) {
      var that = this;
      artzheAgent.call('Tool/getAgency', {},function(res) {
        // console.log(res);
        if (res.code == 30000) {
          var types = res.data.info.map(function (item) {
            var newItem = {};
            newItem.value = item.id.toString();
            newItem.label = item.value;
            return newItem;
          });
          that.types = types;
          typeof cb == "function" && cb();
        }
      });
    }
  }
});