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
      mobile: getCookie('userMobile'), //
      pos: [],
      college: '',
      inputCollege: '',
      resume: '',
      inviteCode: ''
      // memo: '',
      // idCardNo: '',
      // motto: '',
      
    },
    isSubmit: false,
    rules: {
      name: [{
        required: true,
        message: '请输入您的真实姓名',
        trigger: 'blur'
      }, {
        pattern: validInfo.notEmply,
        message: '请输入您的真实姓名',
        trigger: 'blur'
      }],
      mobile: [{
        required: true,
        message: '请输入手机号',
        trigger: 'blur'
      }, {
        max: 11,
        pattern: validInfo.mobile,
        message: '请输入正确的手机号',
        trigger: 'blur'
      }],
      pos: [{
        type: 'array',
        required: true,
        message: '请选择您的地址',
        trigger: 'change'
      }],
      college: [{
        required: true,
        message: '请选择您的毕业院校',
        trigger: 'change'
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
      // idCardNo: [{
      //   required: true,
      //   message: '请输入您的身份证号码',
      //   trigger: 'blur'
      // }, {
      //   pattern: validInfo.idCardNo,
      //   message: '身份证号码格式错误',
      //   trigger: 'blur'
      // }],
      // motto: [{
      //   required: true,
      //   message: '请输入您的个性签名',
      //   trigger: 'blur'
      // }, {
      //   pattern: validInfo.notEmply,
      //   message: '请输入您的个性签名',
      //   trigger: 'blur'
      // }],

      // memo: [{
      //   required: true,
      //   message: '请输入您的个人信息',
      //   trigger: 'blur'
      // }, {
      //   pattern: validInfo.notEmply,
      //   message: '请输入您的个人信息',
      //   trigger: 'blur'
      // }]
    },
    cityProps: {
      value: 'value',
      children: 'children'
    },
    colleges: [
    ],
    schools: [],
    positions: _Area,
    otherIsActive: false,
    hasInvite: false
  },
  created: function () {
    this.getSchool(this.getLocal());
  },
  methods: {
    getLocal: function (cb) {
      var that = this;
      artzheAgent.call22('AuthArtist/getMyApply', {}, function(res) {
        console.log(res);
        if (res.code == 30000) {
          // Storage.set('authInfo', res.data.info);
          var authInfo = res.data.info;
          // console.log(authInfo);
          var pos = [authInfo.province, authInfo.city,authInfo.area];
          function isInList(arr, item) {  
              var i = arr.length;  
              while (i--) {  
                  if (arr[i] === item) {  
                      return true;  
                  }  
              }  
              return false;  
          }
          that.ruleForm = {
            name: authInfo.name,
            mobile: authInfo.mobile, //
            pos: pos,
            college: '',
            inputCollege: '',
            resume: authInfo.resume
          };
          if (authInfo.invite_code) {
            that.hasInvite = true;
            delete that.ruleForm.inviteCode;
          } else {
            that.hasInvite = false;
            that.ruleForm.inviteCode = '';
          }

          if (authInfo.school) {
            if (isInList(that.schools, authInfo.school)) {
              that.ruleForm.college = authInfo.school;
            } else {
              that.ruleForm.college = '其他';
              that.ruleForm.inputCollege = authInfo.school;
            }
          } else {
            that.ruleForm.college = '';
            that.ruleForm.inputCollege = '';
          }
          if (!authInfo.mobile) {
            that.ruleForm.mobile = getCookie('userMobile') ? getCookie('userMobile'): '';
          }        
        }
      });
    },
    submitForm: function (formName) {
      var that = this;
      this.$refs[formName].validate(function (valid) {
        if (valid) {
          //避免重复点击提交
          that.ruleForm.inputCollege = trimStr(that.ruleForm.inputCollege);
          if (that.ruleForm.college == '其他' && that.ruleForm.inputCollege == '') {
            that.errorTip = '请输入您的毕业院校';
            setTimeout(function () {
              that.errorTip = '';
            }, 2000);
            return false;
          }
          if (that.isSubmit) {
            return false;
          }
          that.isSubmit = true;
          that.btnText = "提交中...";
          var formData = {};
          formData.trueName = that.ruleForm.name;
          formData.mobile = that.ruleForm.mobile;
          formData.province = that.ruleForm.pos[0];
          formData.city = that.ruleForm.pos[1];
          formData.area = that.ruleForm.pos[2];
          formData.resume = that.ruleForm.resume;
          if (that.ruleForm.college == '其他') {
            formData.school = that.ruleForm.inputCollege;
          } else {
            formData.school = that.ruleForm.college;
          }

          if (that.ruleForm.inviteCode) {
            formData.inviteCode = that.ruleForm.inviteCode;
          }
          

          for (var prop in formData) {
            formData[prop] = trimStr(formData[prop]);
          }

          artzheAgent.call22('AuthArtist/stepOne',formData,function(res) {
            that.isSubmit = false;
            // console.log(res);
            if (res.code == 30000) {
              that.btnText = '跳转中...';
              window.location.href = '/auth/second';
            } else if (res.code == 30113 && res.data.status == 1000) {
              that.btnText = '提交';
              that.errorTip = res.message;
              setTimeout(function () {
                that.errorTip = '';
              }, 2000);
            }
          });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    handleItemChange: function (val) {
      console.log(val);
      this.getPos(val[val.length-1]);
    },
    getSchool: function (cb) {
      var that = this;
      artzheAgent.call22('Tool/getSchool', {},function(res) {
        // console.log(res);
        if (res.code == 30000) {
          that.schools = res.data.info;
          var schools = res.data.info.map(function (item) {
            var newItem = {};
            newItem.value = item;
            newItem.label = item;
            return newItem;
          });
          schools.push({'value': '其他', 'label': '其他'});
          that.colleges = schools;
          typeof cb == "function" && cb();
        }
      });
    },
    toggleActive: function () {
      this.otherIsActive = !this.otherIsActive;
    },
    isInteger: function (obj) {
      return obj%1 === 0;
    },
    isString: function (str){ 
      return (typeof str=='string')&&str.constructor==String; 
    } 
  }
});