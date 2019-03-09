new Vue({
  el: '#user-follow',

  // components: {
  //   VueScroller
  // },

  data: {
    page: 0,
    isLoading: true,
    hasList: true,
    hasMore: true,
    boxIsShow: false,
    msgBoxIsShow: false,
    list: [],
    tempId: '',
    isSubmit: false
  },

  mounted: function() {
    // this.page = 1;
    // this.getData(this.page);

    // setTimeout(() => {
    // 	this.$refs.my_scroller.resize();
    // })
  },

  methods: {
    refresh: function() {
      this.page = 1;
      this.hasMore = true;
      this.getData(this.page);
    },

    infinite: function() {
      this.page = this.page + 1;
      this.getData(this.page);
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.msgBoxIsShow = false;
    },
    showMsgBox: function(id) {
      this.tempId = id;
      this.boxIsShow = true;
      this.msgBoxIsShow = true;
    },
    cancelFollow: function() {
      var that = this;
      var data = {
        artistId: this.tempId
      };

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      artzheAgent.call('Gallery/unfollow', data, 
        function(res) { //取消关注
          that.isSubmit = false;
          if (res.code == 30000) {
            that.boxIsShow = false;
            that.msgBoxIsShow = false;
            that.$nextTick(function() {
              that.list.forEach(function(item) {
                if (item.user_id == that.tempId) {
                  Vue.set(item, "unfollow", true);
                }
              });
            });
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

      // $.ajax({
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   },
      //   type: "POST",
      //   url: "/api/Gallery/unfollow",
      //   data: data,
      //   success: function(res) {

      //     console.log('cancelFollow.res', res);
      //     if (res.code == 30000) {
      //       that.boxIsShow = false;
      //       that.msgBoxIsShow = false;
      //       that.$nextTick(function() {
      //         that.list.forEach(function(item) {
      //           if (item.user_id == that.tempId) {
      //             Vue.set(item, "unfollow", true);
      //           }
      //         });
      //       });
      //     } else {
      //       TipsShow.showtips({
      //         info: res.message
      //       });
      //     }
      //   }
      // });
    },
    followArtist: function(id) {
      var that = this;
      var data = {
        artistId: id
      };
      // console.log('followArtist.data', data);

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      artzheAgent.call('Gallery/follow', data, 
        function(res) { //关注
          that.isSubmit = false;
          console.log('followArtist.res', res);
          if (res.code == 30000) {
            that.$nextTick(function() {
              that.list.forEach(function(item) {
                if (item.user_id == id) {
                  Vue.set(item, "unfollow", false);
                }
              });
            });
          }
        },
        function () {
          that.isSubmit = false;
        }
      );

      // $.ajax({
      //   type: "POST",
      //   url: "/api/Gallery/follow",
      //   data: data,
      //   success: function(res) {
      //     console.log('followArtist.res', res);
      //     if (res.code == 30000) {
      //       that.$nextTick(function() {
      //         that.list.forEach(function(item) {
      //           if (item.user_id == id) {
      //             Vue.set(item, "unfollow", false);
      //           }
      //         });
      //       });
      //     }
      //   }
      // });
    },
    getData: function(page) {
      var self = this;
      if (self.hasMore) {

        artzheAgent.call('UserCenter/getMyFollowerList', {
            page: page,
            perPageCount: 10
          },
          function(res) { //获取我的关注列表
            console.log("关注列表.res", res);
            self.isLoading = false;
            if (res.code == 30000) {
              if (res.data.info.length > 0) {
                if (page == 1) {
                  self.list = res.data.info;
                  self.$refs.my_scroller.finishPullToRefresh();
                } else {
                  self.list = self.list.concat(res.data.info);
                }
                self.list.forEach(function(item) {
                  Vue.set(item, "unfollow", false);
                });
                self.hasList = true;
                self.$refs.my_scroller.finishInfinite();
              } else {
                if (page == 1) {
                  self.hasList = false;
                }
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
          }
        );
      } else {
        this.$refs.my_scroller.finishInfinite(true);
      }
    }
  }
});