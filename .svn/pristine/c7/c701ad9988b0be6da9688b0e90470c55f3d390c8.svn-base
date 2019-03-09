Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmApp = new Vue({
  el: '#app',
  data: {
    // isLogin: true,
    compress: compress, //图片压缩后缀
    bottomLoginShow: false, //底部登录框是否显示
    bottomDownloadShow: false, //底部下载框是否显示
    info: {
      list:[],
      page: 0
    },
    busy:false,
    userInfo: {},
    followClick: false,
    likeCur: {
      index1: -1,
      index2: -1
    } //当前点击喜欢的index,1:父级，2:自己
  },
  created: function() {
    this.getData(1);
  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.userInfo = info;
    }.bind(this));

    eventBus.$on('unlike', function(id, type, index) {
      this.unlike(id, type, index);
    }.bind(this));
  },
  methods: {
    getData: function () {
      //超过50条强制退出
      if (this.info.page >= 5) return false;

      this.busy = true;
      var that = this;
      var api = '/Api/Gallery/getGalleryList';
      var data = {
        page: ++this.info.page,
        pagesize: 10
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            resInfo.list.forEach(function (item) {
              if (item.follow == 'Y') {
                item.btnText = '已关注';
              } else if (item.follow == 'N') {
                item.btnText = '+ 关注';
              }
              // console.log(item.imginfo);
              item.imginfo.forEach(function (imgItem) {
                imgItem.imgname = checkMark(imgItem.imgname);
              });
            });

            if (resInfo.page == 1) {
              that.info = resInfo;
            } else if (resInfo.page > 1) {
              that.info.list = that.info.list.concat(resInfo.list);
            }
            that.list = res.data.info.list;
          }
        },
        complete: function (res) {
          that.$nextTick(function () {
            //根据是否登录，选择加载30条 or 50 条
            if (that.userInfo.artist) {
              if (that.info.page < 5) {
                that.busy = false;
              } else {
                that.bottomDownloadShow = true;
              }
            } else {
              if (that.info.page < 3) {
                that.busy = false;
              } else {
                that.bottomLoginShow = true;
              }
            } 
          });
        }
      });
    },
    overFollowText: function (index) {
      if (this.info.list[index].btnText == '已关注') {
        this.info.list[index].btnText = '取消关注';
      }
    },
    outFollowText: function (index) {
      if (this.info.list[index].btnText == '取消关注') {
        this.info.list[index].btnText = '已关注';
      }
    },
    showReg: function () {
      eventBus.$emit('showLogin', 'login', 'reg');
    },
    showLogin: function (argument) {
      eventBus.$emit('showLogin', 'login', 'login');
    },
    toggleFollow: function(id, index) {
      var that = this;
      var data = {
        artistId: id
      };
      if (this.followClick) {
        return false;
      }
      this.followClick = true;
      if (that.info.list[index].follow == "Y") {
        $.ajax({
          type: "POST",
          url: '/Api/Gallery/unfollow',
          data: data,
          success: function(res) {
            // console.log(res);
            that.followClick = false;
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              eventBus.$emit('showLogin', 'login', 'login');
            } else if (res.code == '30000' && res.data.status == 1000) {
              that.info.list[index].follow = "N";
              that.info.list[index].btnText = '+ 关注';
              that.info.list[index].followTotal--;
            }
          }
        });
      } else {
        $.ajax({
          type: "POST",
          url: '/Api/Gallery/follow',
          data: data,
          success: function(res) {
            // console.log(res);
            that.followClick = false;
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              eventBus.$emit('showLogin', 'login', 'login');
            } else if (res.code == '30000' && res.data.status == 1000) {
              that.info.list[index].follow = "Y";
              that.info.list[index].btnText = '已关注';
              that.info.list[index].followTotal++;
            }
          }
        });
      }
    },
    toggleLike: function (id, index1, index2) {
      var that = this;
      var data = {
        id: id,
        type: 1
      };
      this.likeCur = {
        index1: index1,
        index2: index2
      };

      if (that.info.list[that.likeCur.index1].imginfo[that.likeCur.index2].islike == "N") {
        if (this.likeClick) {
          return false;
        }
        this.likeClick = true;
        $.ajax({
          type: "POST",
          url: '/Api/Artwork/like',
          data: data,
          success: function(res) {
            // console.log(res);
            that.likeClick = false;
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              eventBus.$emit('showLogin', 'login', 'login');
            } else if (res.code == '30000' && res.data.status == 1000) {
              that.info.list[that.likeCur.index1].imginfo[that.likeCur.index2].islike = "Y";
            }
          }
        });
      } else if (that.info.list[that.likeCur.index1].imginfo[that.likeCur.index2].islike == "Y") {
        eventBus.$emit('showLikeBox', id, 1, index2);
      }
    },
    unlike: function(id, type, index) {
      var that = this;
      that.info.list[that.likeCur.index1].imginfo[that.likeCur.index2].islike = "N";
    }
  }
});