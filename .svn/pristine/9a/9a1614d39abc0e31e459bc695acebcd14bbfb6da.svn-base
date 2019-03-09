var vmUser = new Vue({
  // element to mount to
  el: '#user',
  // initial data
  data: {
    isLoading: true,
    boxIsShow: false,
    inviteIsShow: false,
    downloadIsShow: false,
    boxMsg: '',
    userMsg: [],
    hasUserMsg: false,
    hasMoreMsg: false,
    userInfo: {},
    applyInfo: {
      '0': '申请认证艺术家',
      '1': '认证审核中',
      '-1': '认证审核失败'
    }
  },
  created: function() {
    var that = this;
    this.init();
  },
  // methods
  methods: {
    init: function() {
      var that = this;
      artzheAgent.call('UserCenter/getMyGalleryDetail', {}, //获取“我的”首页信息
        function(res) {
          // console.log('获取“我的”首页信息.res', res);
          if (res.code == '30000') {
            if (res.data.status == 1000) {
              var userInfo = res.data.info;
              that.userInfo = userInfo;
              Storage.set('userInfo', userInfo);
              that.$nextTick(function () {
                that.isLoading = false;
                var clipboard = new Clipboard('#copy-btn');
                clipboard.on('success', function(e) {
                  e.clearSelection();
                  that.hideBox();
                  TipsShow.showtips({
                    info: "复制成功"
                  });
                });
              });
            }
          }
        }
      );
      // $.ajax({
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   },
      //   type: "POST",
      //   url: "/api/UserCenter/getMyGalleryDetail", //获取“我的”首页信息
      //   // data: that.token,
      //   success: function(res) {

      //     // console.log(res);
      //     console.log('获取“我的”首页信息.res', res);
      //     // if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
      //     //   window.location.href = "/wechat/login";
      //     // } else 
      //     if (res.code == '30000') {
      //       if (res.data.status == 1000) {
      //         var userInfo = res.data.info;
      //         // if (userInfo.isArtist == '-1') {
      //         //   $.ajax({
      //         //     headers: {
      //         //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //         //     },
      //         //     type: "POST",
      //         //     url: "/api/UserCenter/getMyMessageList", //获取我的消息列表
      //         //     data: {
      //         //       // token: that.token,
      //         //       page: 1,
      //         //       perPageCount: 5
      //         //     },
      //         //     success: function(res) {
          
      //         //       // console.log(res);
      //         //       console.log('获取我的消息列表.res', res);
      //         //       if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
      //         //         window.location.href = "/wechat/login";
      //         //       } else if (res.code == '30000') {
      //         //         if (res.data.status == 1000) {
      //         //           var userMsg = res.data.info;
      //         //           if (userMsg.length > 4) {
      //         //             userMsg = userMsg.slice(0, 4);
      //         //             that.hasUserMsg = true;
      //         //             that.hasMoreMsg = true;
      //         //             that.userMsg = userMsg;
      //         //           } else if (userMsg.length < 4 && userMsg.length > 0) {
      //         //             that.hasUserMsg = true;
      //         //             that.userMsg = userMsg;
      //         //           } else {
      //         //             that.hasUserMsg = false;
      //         //           }
      //         //         }
      //         //       }
      //         //     }
      //         //   });
      //         // }
      //         that.userInfo = userInfo;
      //         that.$nextTick(function () {
      //           that.isLoading = false;
      //           var clipboard = new Clipboard('#copy-btn');
      //           clipboard.on('success', function(e) {
      //             e.clearSelection();
      //             that.hideBox();
      //             TipsShow.showtips({
      //               info: "复制成功"
      //             });
      //           });
      //         });
      //       }
      //     }
      //   }
      // });
    },
    showDownload: function(msg) {
      this.boxMsg = msg;
      this.boxIsShow = true;
      this.downloadIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.downloadIsShow = false;
      this.inviteIsShow = false;
    },
    showInvite: function () {
      this.boxIsShow = true;
      this.inviteIsShow = true;
    }
  },
  filters: {
    timeFormat: function(value) {
      value = value * 1000;
      var dateTime = new Date(value);
      var year = dateTime.getFullYear();
      var month = dateTime.getMonth() + 1;
      var day = dateTime.getDate();
      var hour = dateTime.getHours();
      var minute = dateTime.getMinutes();
      var second = dateTime.getSeconds();
      var now = new Date();
      var now_new = now.getTime(); //js毫秒数

      var milliseconds = 0;
      var timeSpanStr;

      milliseconds = now_new - value;

      if (milliseconds <= 1000 * 60 * 1) {
        timeSpanStr = '刚刚';
      } else if (milliseconds <= 1000 * 60 * 60) {
        timeSpanStr = Math.round((milliseconds / (1000 * 60))) + '分钟前';
      } else if (1000 * 60 * 60 * 1 < milliseconds && milliseconds <= 1000 * 60 * 60 * 24) {
        timeSpanStr = Math.round(milliseconds / (1000 * 60 * 60)) + '小时前';
      } else if (1000 * 60 * 60 * 24 < milliseconds && milliseconds <= 1000 * 60 * 60 * 24 * 3) {
        timeSpanStr = Math.round(milliseconds / (1000 * 60 * 60 * 24)) + '天前';
      } else {
        timeSpanStr = year + '-' + month + '-' + day;
      }
      return timeSpanStr;
    }
  }
});