new Vue({
  el: '#usermsg',
  data: {
    page: 0,
    isLoading: true,
    hasList: false,
    hasMore: true,
    list: [],
    active:0,
    tabs: [
      {cont:'评论', num:0, type:'10,13'},
      {cont:'喜欢', num:0, type:'9,12'},
      {cont:'系统通知', num:0, type:'8'}
    ],
    type: '10,13',
    isSubmit:false
  },
  created: function () {
    this.getMessageNum();
  },

  mounted: function() {
    // this.page = 1;
    // this.getData(this.page);

    // setTimeout(() => {
    // 	this.$refs.my_scroller.resize();
    // })
  },

  methods: {
    getMessageNum: function () {
      var that = this;
      artzheAgent.call('UserCenter/getMyGalleryDetail', {}, //获取“我的”首页信息
        function(res) {
          // console.log('获取“我的”首页信息.res', res);
          if (res.code == '30000') {
            if (res.data.status == 1000) {
              var userInfo = res.data.info;
              // that.tabs[0].num = userInfo.unreadCommentMessageTotal;
              that.tabs[1].num = userInfo.unreadLikeMessageTotal;
              that.tabs[2].num = userInfo.unreadSystemMessageTotal;
            }
          }
        }
      );
    },
    refresh: function() {
      this.page = 1;
      this.hasMore = true;
      this.getData(this.page, this.type);
    },

    infinite: function() {
      this.page = this.page + 1;
      
      this.getData(this.page, this.type);
    },
    toggleActive: function (index) {
      this.list = [];
      this.hasMore = true;
      this.active = index;
      this.type = this.tabs[index].type;
      this.tabs[index].num = 0;
      this.page = 0;
      $('body').scrollTop(0);
      this.$refs.my_scroller.finishInfinite();
      // this.refresh();
    },

    getData: function(page,type) {
      var self = this;
      if (self.hasMore) {
        artzheAgent.call('UserCenter/getMyMessageList', {
          page: page,
          type: type,
          perPageCount: 10
        }, function(res) {
          console.log("消息列表.res", res);
          self.isLoading = false;
          if (res.code == 30000) {
            if (res.data.info.length > 0) {
              // res.data.info.forEach(function (item) {
              // 	item.active = false;
              // });
              if (page == 1) {
                self.list = res.data.info;
                self.$refs.my_scroller.finishPullToRefresh();
              } else {
                self.list = self.list.concat(res.data.info);
              }
              self.hasList = true;
              self.$refs.my_scroller.finishInfinite();
            } else {
              self.hasMore = false;
              self.$refs.my_scroller.finishInfinite(true);
            }
            self.$nextTick(function() {
              self.$refs.my_scroller.resize();
            });
          } else {
            TipsShow.showtips({
              info: res.message
            });
          }
        });
      } else {
        this.$refs.my_scroller.finishInfinite(true);
      }
    },
    goToLink: function(link) {
      if (link) {
        aLink = link.split("-");
        if (aLink[0] == 'artDetail') {
          link = '/artwork/detail/' + aLink[1];
        } else if (aLink[0] == 'artUpdateDetail') {
          link = '/artwork/update/' + aLink[1];
        }
        window.location.href = link;
      }
    },
    replyCom: function(comment_id, index) {
      var that = this;
      var content = trimStr(this.list[index].replyContent);
      var commentId = comment_id;
      var data = {
        content: content,
        commentId: commentId
      }
      console.log(data);
      if (content == "") {
        TipsShow.showtips({
          info: '请输入回复内容'
        });
        return false;
      }

      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      artzheAgent.call('Artwork/repayMessage', data,
        function(res) {
          that.isSubmit = false;
          if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.list[index].active = false;
              that.list[index].isRepay = 'Y';
            } else {
              TipsShow.showtips({
                info: res.message
              });
            }
          }
        },
        function (res) {
          that.isSubmit = false;
        }
      );
    },
    addActive: function(msg) {
      this.$nextTick(function() {
        this.list.forEach(function(msg) {
          Vue.set(msg, 'active', false);
        });
        Vue.set(msg, 'active', true);
      });
      if (msg.link.action) {
        if (msg.link.action == 'artDetail') {
          window.location.href = '/artwork/detail/' + msg.link.id;
        } else if (msg.link.action == 'artUpdateDetail') {
          window.location.href = '/artwork/update/' + msg.link.id;
        }
      }
    }
  },
  // components: {
  //   VueScroller
  // },
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