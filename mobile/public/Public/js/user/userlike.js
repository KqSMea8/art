new Vue({
  el: '#user-like',
  data: {
    page: 0,
    isLoading: true,
    isActive: false,
    hasList: true,
    hasMore: true,
    boxIsShow: false,
    msgBoxIsShow: false,
    list: [],
    likeClick: false
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
      alert('hidbow');
      this.boxIsShow = false;
      this.msgBoxIsShow = false;
    },
    showMsgBox: function(id) {
      this.tempId = id;
      this.boxIsShow = true;
      this.msgBoxIsShow = true;
    },
    toggleLike: function(id, unlike) {

      var that = this;
      var data = {
        id: id
      };
      if (this.likeClick) {
        return false;
      }
      this.likeClick = true;
      if (!unlike) {
        artzheAgent.call('Artwork/unlike', data, 
          function(res) {
            that.likeClick = false;
            console.log('cancelLike.res', res);
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              window.location.href = "/wechat/login";
            } else if (res.code == '30000') {
              if (res.data.status == 1000) {
                that.list.forEach(function(item) {
                  if (item.artworkId == id) {
                    Vue.set(item, "unlike", true);
                  }
                });
                that.$nextTick(function() {
                  console.log('data unlike update ok');
                });
              }
            }
          },
          function () {
            that.likeClick = false;
          }
        );
      } else {
        artzheAgent.call('Artwork/like', data,
          function(res) {
            that.likeClick = false;
            console.log('likeArt.res', res);
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              window.location.href = "/wechat/login";
            } else if (res.code == '30000') {
              if (res.data.status == 1000) {
                that.list.forEach(function(item) {
                  if (item.artworkId == id) {
                    Vue.set(item, "unlike", false);
                  }
                });
                that.$nextTick(function() {
                  console.log('data like update ok');
                });
              }
            }
          },
          function () {
            that.likeClick = false;
          }
        );
      }
    },
    getData: function(page) {
      var self = this;
      if (self.hasMore) {
        artzheAgent.call('UserCenter/getMyLikeArtworkList', {
            page: page,
            perPageCount: 10
          },
          function(res) {
            console.log("消息列表.res", res);
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
                  Vue.set(item, "unlike", false);
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
  },
  // components: {
  //   VueScroller
  // },
});