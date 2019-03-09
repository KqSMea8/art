Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmGallery = new Vue({
  el: '#gallery',
  data: {
    artworkCateInfo:{},
    isShowCategory: false,
    isLoading: true,
    page: 1,
    pagesize: 10,
    maxpage: '',
    galleryList: [],
    isActive: false,
    current: 1,
    curCateList: [],
    curGen: '',
    curCate: '',
    followClick: false
  },
  created: function() {
    // body...
    var that = this;
    this.getData('','', this.addAnimate);
    this.getArtworkCategory();
  },
  mounted: function () {
    var that = this;
    // setTimeout(() => {
    //           $(document).ready(function() {
    //             fadeInUp('.gallery-list', '.gallery-item', 0.2);
    //           });
    //           that.loadMore();
    // });

  },
  methods: {
    getData: function(gender, category, cb) {
      // body...
      var that = this;
      var data = {
        gender: gender,
        category: category,
        page: 1,
        pagesize: this.pagesize
      };
      $.ajax({
        type: "POST",
        url: "/api/Gallery/getArtworkList", //获取画廊列表页
        data: data,
        success: function(res) {
          console.log(res);
          // that.$nextTick(function () {
          //   that.isLoading = false;
          // });
          if (res.code == '30000') {
            var galleryInfo = res.data.info;
            // that.page = galleryInfo.page;
            that.maxpage = galleryInfo.maxpage;
            var galleryList = galleryInfo.list;
            console.log(galleryList);
            galleryList = galleryList.map(function(item, index, array) {
              if (item.otherArt.length > 3) {
                item.otherArt  = item.otherArt.slice(0, 3);
                return item;
              } else {
                return item;
              }
            });
            that.galleryList = galleryList;
            typeof cb == "function" && cb();
            that.$nextTick(function() {
              // DOM 更新了
              fadeInUp('.gallery-list', '.gallery-item', 0.2);
              // that.loadMore();
            });
          }
        },
        complete: function() {
          that.$nextTick(function() {
            that.isLoading = false;
          });
        }
      });
    },
    addAnimate: function () {
      var that = this;
      this.$nextTick(function() {
        // DOM 更新了
        // fadeInUp('.gallery-list', '.gallery-item', 0.2);
        that.loadMore();
      });
    },
    getArtworkCategory: function () {
      var that = this;
      $.ajax({
        type: "POST",
        url: "/api/Gallery/getArtworkCategoryStat", //获取画廊分类和统计信息
        success: function(res) {
          console.log(res);
          if (res.code == '30000') {
            that.artworkCateInfo = res.data.info;
            that.curCateList = that.artworkCateInfo.all;
            that.isShowCategory = res.data.info.isShowCategory;
          }
        }
      });
    },
    // //动画and刷新加载
    loadMore: function() {
      var that = this;
      var iHeight = $('.gallery-item').height();
      console.log(iHeight);
      console.log($('body').height());
      $('#main').dropload({
        scrollArea: window,
        threshold: iHeight,
        // autoLoad: false,
        loadUpFn: function(me) {
          console.log("下拉");
          $.ajax({
            type: 'POST',
            url: '/api/Gallery/getArtworkList',
            data: {
              page: 1,
              pagesize: that.pagesize
            },
            success: function(res) {
              console.log(res);
              if (res.code == '30000') {
                var galleryInfo = res.data.info;
                // that.page = galleryInfo.page;
                that.maxpage = galleryInfo.maxpage;
                var galleryList = galleryInfo.list;
                console.log(galleryList);
                galleryList = galleryList.map(function(item, index, array) {
                  if (item.otherArt.length > 3) {
                    item.otherArt  = item.otherArt.slice(0, 3);
                    return item;
                  } else {
                    return item;
                  }
                });
                that.galleryList = galleryList;
                that.page = 1;
                that.$nextTick(function() {
                  // DOM 更新了
                  fadeInUp('.gallery-list', '.gallery-item', 0.2);
                });
              }
              me.resetload();
              // 重置页数，重新获取loadDownFn的数据
              // page = 1;
              // 解锁loadDownFn里锁定的情况
              me.unlock();
              me.noData(false);
            },
            error: function(xhr, type) {
              me.resetload();
            }
          });
        },
        loadDownFn: function(me) {
          console.log("down");
          if (that.page >= that.maxpage) {
            console.log(that.page);
            console.log(that.maxpage);
            me.resetload();
            me.noData(true);
            me.lock('down');
            return false;
          }
          that.page = that.page + 1;
          $.ajax({
            type: 'POST',
            url: '/api/Gallery/getArtworkList',
            data: {
              page: that.page,
              pagesize: that.pagesize
            },
            success: function(res) {
              console.log(res);
              if (res.code == '30000') {
                var galleryInfo = res.data.info;
                that.maxpage = galleryInfo.maxpage;
                var galleryList = galleryInfo.list;
                console.log(galleryList);
                galleryList = galleryList.map(function(item, index, array) {
                  if (item.otherArt.length > 3) {
                    item.otherArt  = item.otherArt.slice(0, 3);
                    return item;
                  } else {
                    return item;
                  }
                });
                galleryList = that.galleryList.concat(galleryList);
                that.galleryList = galleryList;
                that.$nextTick(function() {
                  // DOM 更新了
                  fadeInUp('.gallery-list', '.gallery-item', 0.2);
                });
              }
              // 每次数据加载完，必须重置
              me.resetload();
            },
            error: function(xhr, type) {
              // 即使加载出错，也得重置
              me.resetload();
            }
          });
        }
      });

    },
    // refresh: function () {
    //   // body...
    //   console.log('refresh');
    // },
    // infinite: function () {
    //   // body...
    //   console.log('infinite');
    // },
    toggle: function() {
      this.isActive = !this.isActive;
    },
    choosePrinter: function(index) {
      this.current = index;
      if (index == 0) {
        this.curGen = 1;
        this.curCateList = this.artworkCateInfo.man ;
      } else if (index == 1) {
        this.curGen = '';
        this.curCateList = this.artworkCateInfo.all;
      } else {
        this.curGen = 2;
        this.curCateList = this.artworkCateInfo.women;
      }  
    },
    chooseCate: function(category) {
      this.isActive = false;
      this.curCate = category;
      // console.log(this.curGen, this.curCate);
      this.getData(this.curGen, this.curCate);
    },
    toggleFollow: function(id, index) {
      console.log(id);
      console.log(index);
      var that = this;
      var data = {
        token: this.token,
        artistId: id
      };
      if (this.followClick) {
        return false;
      }
      this.followClick = true;
      if (that.galleryList[index].follow == "Y") {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: "/api/Gallery/unfollow", //取消关注
          data: data,
          success: function(res) {
            // console.log(res);
            that.followClick = false;
            console.log('unFollow.res', res);
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              window.location.href = "/wechat/login";
            } else if (res.code == '30000') {
              if (res.data.status == 1000) {
                that.galleryList[index].follow = "N";
                that.galleryList[index].follower_total--;
              }
            }
          },
          complete: function() {
            that.followClick = false;
          }
        });
      } else {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: "/api/Gallery/follow", //关注
          data: data,
          success: function(res) {
            that.followClick = false;
            // console.log('follow.res', res);
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              window.location.href = "/wechat/login";
            } else if (res.code == '30000') {
              if (res.data.status == 1000) {
                that.galleryList[index].follow = "Y";
                that.galleryList[index].follower_total++;
              }
            }
          },
          complete: function() {
            that.followClick = false;
          }
        });
      }
    }
  },
  components: {
    VueLazyload,
    VueScroller
  }
});