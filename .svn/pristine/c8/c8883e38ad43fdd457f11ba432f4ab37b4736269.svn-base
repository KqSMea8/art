Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmGallery = new Vue({
  el: '#gallery',
  data: {
    artworkCateInfo: {},
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
    this.getData('', '', this.addAnimate);
    // this.getArtworkCategory();
  },
  mounted: function() {
    var that = this;
    noZoom();
    if (FastClick) {
      FastClick.attach(document.body);
    }

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
      artzheAgent.call1('Gallery/getArtworkList', data,
        function(res) {
          // console.log(res);
          // that.$nextTick(function () {
          //   that.isLoading = false;
          // });
          if (res.code == '30000') {
            var galleryInfo = res.data.info;
            // that.page = galleryInfo.page;
            that.maxpage = galleryInfo.maxpage;
            var galleryList = galleryInfo.list;
            // console.log(galleryList);
            galleryList = galleryList.map(function(item, index, array) {
              if (item.imginfo) {
                item.otherArt = item.imginfo.map(function (imgItem) {
                  return imgItem.imgurl;
                });
              }
              if (item.otherArt.length > 3) {
                item.otherArt = item.otherArt.slice(0, 3);
                return item;
              } else {
                return item;
              }
            });
            var aTemp = [];
            for (var i = 0; i < galleryList.length; i++) {
              if (galleryList[i].total_art > 0) {
                aTemp.push(galleryList[i]);
              }
            }
            that.galleryList = aTemp;
            typeof cb == "function" && cb();
            that.isLoading = false;
            that.$nextTick(function() {
              // DOM 更新了
              fadeInUp('.gallery-list', '.gallery-item', 0.2);
              // that.loadMore();
              gDrop.noData(false);
              gDrop.unlock();
              gDrop.resetload();
            });
          }
        }
      );
    },
    addAnimate: function() {
      var that = this;
      this.$nextTick(function() {
        // DOM 更新了
        // fadeInUp('.gallery-list', '.gallery-item', 0.2);
        that.loadMore();
      });
    },
    getArtworkCategory: function() {
      var that = this;
      artzheAgent.call('Gallery/getArtworkCategoryStat', {}, function(res) { //获取画廊分类和统计信息
        // console.log(res);
        if (res.code == '30000') {
          that.artworkCateInfo = res.data.info;
          that.curCateList = that.artworkCateInfo.all;
          that.isShowCategory = res.data.info.isShowCategory;
        }
      });
      // $.ajax({
      //   type: "POST",
      //   url: "/api/Gallery/getArtworkCategoryStat", 
      //   success: function(res) {
      //     console.log(res);
      //     if (res.code == '30000') {
      //       that.artworkCateInfo = res.data.info;
      //       that.curCateList = that.artworkCateInfo.all;
      //       that.isShowCategory = res.data.info.isShowCategory;
      //     }
      //   }
      // });
    },
    // //动画and刷新加载
    loadMore: function() {
      var that = this;
      var iHeight = $('.gallery-item').height();
      // console.log(iHeight);
      // console.log($('body').height());

      gDrop = $('#main').dropload({
        domDown: {
          domClass: 'dropload-down',
          domRefresh: '<div class="dropload-refresh">↑上拉加载更多</div>',
          domLoad: '<div class="dropload-load">○加载中...</div>',
          domNoData: '<div class="dropload-noData">已经全部加载完毕</div>'
        },
        scrollArea: window,
        threshold: iHeight,
        // autoLoad: false,
        loadUpFn: function(me) {
          console.log("下拉");
          artzheAgent.call1('Gallery/getArtworkList', {
              gender: that.curGen,
              category: that.curCate,
              page: 1,
              pagesize: that.pagesize
            },
            function(res) { //获取画廊分类和统计信息
              // console.log(res);
              if (res.code == '30000') {
                var galleryInfo = res.data.info;
                // that.page = galleryInfo.page;
                that.maxpage = galleryInfo.maxpage;
                var galleryList = galleryInfo.list;
                console.log(galleryList);
                galleryList = galleryList.map(function(item, index, array) {
                  if (item.otherArt.length > 3) {
                    item.otherArt = item.otherArt.slice(0, 3);
                    return item;
                  } else {
                    return item;
                  }
                });
                var aTemp = [];
                for (var i = 0; i < galleryList.length; i++) {
                  if (galleryList[i].total_art > 0) {
                    aTemp.push(galleryList[i]);
                  }
                }
                that.galleryList = aTemp;
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
            function(res) {
              // 即使加载出错，也得重置
              me.resetload();
            }
          );
        },
        loadDownFn: function(me) {
          // console.log("down");
          if (that.page >= that.maxpage) {
            console.log(that.page);
            console.log(that.maxpage);
            me.noData(true);
            me.lock('down');
            me.resetload();
            return false;
          }
          that.page = that.page + 1;
          artzheAgent.call1('Gallery/getArtworkList', {
              gender: that.curGen,
              category: that.curCate,
              page: that.page,
              pagesize: that.pagesize
            },
            function(res) { //获取画廊分类和统计信息
              // console.log(res);
              if (res.code == '30000') {
                var galleryInfo = res.data.info;
                that.maxpage = galleryInfo.maxpage;
                var galleryList = galleryInfo.list;
                console.log(galleryList);
                galleryList = galleryList.map(function(item, index, array) {
                  if (item.otherArt.length > 3) {
                    item.otherArt = item.otherArt.slice(0, 3);
                    return item;
                  } else {
                    return item;
                  }
                });
                var aTemp = [];
                for (var i = 0; i < galleryList.length; i++) {
                  if (galleryList[i].total_art > 0) {
                    aTemp.push(galleryList[i]);
                  }
                }
                galleryList = that.galleryList.concat(aTemp);

                that.galleryList = galleryList;
                that.$nextTick(function() {
                  // DOM 更新了
                  fadeInUp('.gallery-list', '.gallery-item', 0.2);
                });
              }
              // 每次数据加载完，必须重置
              me.resetload();
            },
            function(res) {
              // 即使加载出错，也得重置
              me.resetload();
            }
          );
          // $.ajax({
          //   type: 'POST',
          //   url: '/api/Gallery/getArtworkList',
          //   data: {
          //     gender: that.curGen,
          //     category: that.curCate,
          //     page: that.page,
          //     pagesize: that.pagesize
          //   },
          //   success: function(res) {
          //     console.log(res);
          //     if (res.code == '30000') {
          //       var galleryInfo = res.data.info;
          //       that.maxpage = galleryInfo.maxpage;
          //       var galleryList = galleryInfo.list;
          //       console.log(galleryList);
          //       galleryList = galleryList.map(function(item, index, array) {
          //         if (item.otherArt.length > 3) {
          //           item.otherArt  = item.otherArt.slice(0, 3);
          //           return item;
          //         } else {
          //           return item;
          //         }
          //       });
          //       galleryList = that.galleryList.concat(galleryList);
          //       that.galleryList = galleryList;
          //       that.$nextTick(function() {
          //         // DOM 更新了
          //         fadeInUp('.gallery-list', '.gallery-item', 0.2);
          //       });
          //     }
          //     // 每次数据加载完，必须重置
          //     me.resetload();
          //   },
          //   error: function(xhr, type) {
          //     // 即使加载出错，也得重置
          //     me.resetload();
          //   }
          // });
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
        this.curCateList = this.artworkCateInfo.man;
      } else if (index == 1) {
        this.curGen = '';
        this.curCateList = this.artworkCateInfo.all;
      } else {
        this.curGen = 2;
        this.curCateList = this.artworkCateInfo.women;
      }
    },
    chooseCate: function(category) {
      // gDrop.noData(false);
      // gDrop.unlock();
      // gDrop.resetload();
      this.isActive = false;
      this.curCate = category;
      // console.log(this.curGen, this.curCate);      
      this.getData(this.curGen, this.curCate);
      // this.loadMore();
    },
    toggleFollow: function(id, index, msg) {
      eventBus.$emit('showDownloadBox', msg);
      return false; //下载新增代码


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
        artzheAgent.call('Gallery/unfollow', data, function(res) {
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
        });

        // $.ajax({
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: "POST",
        //   url: "/api/Gallery/unfollow", //取消关注
        //   data: data,
        //   success: function(res) {
        //     // console.log(res);
        //     that.followClick = false;
        //     console.log('unFollow.res', res);
        //     if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
        //       window.location.href = "/wechat/login";
        //     } else if (res.code == '30000') {
        //       if (res.data.status == 1000) {
        //         that.galleryList[index].follow = "N";
        //         that.galleryList[index].follower_total--;
        //       }
        //     }
        //   },
        //   complete: function() {
        //     that.followClick = false;
        //   }
        // });
      } else {
        artzheAgent.call('Gallery/follow', data, function(res) {
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
        });
        // $.ajax({
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: "POST",
        //   url: "/api/Gallery/follow", //关注
        //   data: data,
        //   success: function(res) {
        //     that.followClick = false;
        //     // console.log('follow.res', res);
        //     if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
        //       window.location.href = "/wechat/login";
        //     } else if (res.code == '30000') {
        //       if (res.data.status == 1000) {
        //         that.galleryList[index].follow = "Y";
        //         that.galleryList[index].follower_total++;
        //       }
        //     }
        //   },
        //   complete: function() {
        //     that.followClick = false;
        //   }
        // });
      }
    }
  },
  // components: {
  //   VueLazyload
  // }
});