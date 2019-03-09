var vmApp = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace'),
      inviteCode: ''
    }
  },
  created: function () {
    this.getInviteCode();
  },
  methods: {
    getInviteCode: function () {
      var that = this;
      artzheAgent.call('User/getInviteCode',{uid: this.myInfo.uid},function(res) {
        console.log('User/getInviteCode', res);
        if (res.code == 30000) {
          that.myInfo.inviteCode = res.data.info.code;
        }
      });
    }
  }
});