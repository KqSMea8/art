var vmAuth = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    errorTip: '',
    isAgree: true,
    ruleShow: true,
    boxIsShow: false,
  },
  methods: {
    agreeToggle: function () {
      this.isAgree = !this.isAgree;
    },
    goToFirst: function () {
      var that = this;
      console.log(this.isAgree);
      if (this.isAgree) {
        console.log('tongyi');
        window.location.href = '/authcurator/first';
      } else {
        this.errorTip = '请勾选《艺术者认证服务协议》';
        setTimeout(function () {
          that.errorTip = '';
        }, 2000);
        return false;
      }
    },
    showXieyi: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    agreeRule: function () {
      this.isAgree = true;
      this.boxIsShow = false;
    }
  }
});