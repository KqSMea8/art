Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});
var vmRecommend = new Vue({
  el: '#recommend',
  data: {
    isLoading: true,
    boxMsg: '',
    page: 1,
    pagesize: 10,
    maxpage: '',
    printList: [],
    addShow: false
  },
  created: function() {
    // body...
    var that = this;
    var page = 1;
    this.getData(page, this.addAnimate);
  },
  mounted: function() {
    noZoom();
    if (FastClick) {
      FastClick.attach(document.body);
    }
  },
  methods: {
    getData: function(newPage, cb) {
      // body...
      var that = this;
      var data = {
        page: newPage,
        pagesize: this.pagesize
      };
      artzheAgent.call1('Recommend/index', data, function(res) { //获取推荐列表页
        // console.log(res);
        if (res.code == '30000') {
          var printInfo = res.data.info;
          that.maxpage = printInfo.maxpage;
          var printList = printInfo.list;
          printList = printList.map(function(item, index, array) {
            if (item.is_finished == "Y") {
              item.update_times = 0;
            } else if (item.update_times > 9) {
              item.update_times = 10;
            }
            return item;
          });
          // console.log(printList);
          that.printList = printList;
          typeof cb == "function" && cb();
        }
        that.isLoading = false;
        that.$nextTick(function () {
          // DOM 更新了
          fadeInUp('.print-list', '.print-item', 0.2);
          // that.loadMore();
          rDrop.noData(false);
          rDrop.unlock();
          rDrop.resetload();
        });

      });
      // artzheAgent.call('UserCenter/getMyGalleryDetail', {}, function(res) { //确定是否为艺术家
      //   // console.log(res);
      //   console.log('确定是否为艺术家.res', res);
      //   if (res.code == '30000') {
      //     if (res.data.status == 1000) {
      //       var userInfo = res.data.info;
      //       if (res.data.info.isArtist == '1') {
      //         that.addShow = true;
      //       }
      //     }
      //   } else {
      //     that.addShow = false;
      //   }
      // });

      // $.ajax({
      //   type: "POST",
      //   url: "/api/Recommend/index", //获取推荐列表页
      //   data: data,
      //   success: function(res) {
      //     console.log(res);

      //     if (res.code == '30000') {
      //       var printInfo = res.data.info;
      //       that.maxpage = printInfo.maxpage;
      //       var printList = printInfo.list;
      //       printList = printList.map(function(item, index, array) {
      //         if (item.is_finished == "Y") {
      //           item.update_times = 0;
      //         } else if (item.update_times > 9) {
      //           item.update_times = 10;
      //         }
      //         return item;
      //       });
      //       console.log(printList);
      //       that.printList = printList;
      //       typeof cb == "function" && cb();
      //     }
      //   },
      //   complete: function () {
      //     that.$nextTick(function () {
      //       that.isLoading = false;
      //     });
      //   }
      // });
      // $.ajax({
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   },
      //   type: "POST",
      //   url: "/api/UserCenter/getMyGalleryDetail", //确定是否为艺术家
      //   // data: that.token,
      //   success: function(res) {

      //     // console.log(res);
      //     console.log('确定是否为艺术家.res', res);
      //     if (res.code == '30000') {
      //       if (res.data.status == 1000) {
      //         var userInfo = res.data.info;
      //         if (res.data.info.isArtist == '1') {
      //           that.addShow = true;
      //         }
      //       }
      //     } else {
      //       that.addShow = false;
      //     }
      //   }
      // });
    },
    addAnimate: function () {
      var that = this;
      this.$nextTick(function() {
        // DOM 更新了
        fadeInUp('.print-list', '.print-item', 0.2);
        that.loadMore();
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
    //动画and刷新加载
    loadMore: function() {
      var that = this;
      var iHeight = $('.print-item').height();
      // console.log(iHeight);
      // console.log($('body').height());
      rDrop = $('#main').dropload({
        domDown: {
          domClass : 'dropload-down',
          domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
          domLoad : '<div class="dropload-load">○加载中...</div>',
          domNoData : '<div class="dropload-noData">已经全部加载完毕</div>'
        },
        scrollArea: window,
        threshold: iHeight,
        autoLoad: false,
        loadUpFn: function(me) {
          console.log("下拉");
          artzheAgent.call1('Recommend/index', {
              page: 1,
              pagesize: that.pagesize
            }, function(res) { 
              // console.log(res);
              // console.log(me);
              if (res.code == '30000') {
                var printInfo = res.data.info;
                that.maxpage = printInfo.maxpage;
                var printList = printInfo.list;
                printList = printList.map(function(item, index, array) {
                  if (item.is_finished == "Y") {
                    item.update_times = 0;
                  } else if (item.update_times > 9) {
                    item.update_times = 10;
                  }
                  return item;
                });
                // console.log(printList);
                that.printList = printList;
                that.page = 1;
                that.$nextTick(function() {
                  fadeInUp('.print-list', '.print-item', 0.2);
                });
              }
              me.resetload();
              // 重置页数，重新获取loadDownFn的数据
              // page = 1;
              // 解锁loadDownFn里锁定的情况
              me.unlock();
              me.noData(false);
            },
            function (res) {
              // 即使加载出错，也得重置
              me.resetload();
            }
          );

          // $.ajax({
          //   type: 'POST',
          //   url: '/api/Recommend/index',
          //   data: {
          //     page: 1,
          //     pagesize: that.pagesize
          //   },
          //   success: function(res) {
    
          //     console.log(res);
          //     console.log(me);
          //     if (res.code == '30000') {
          //       var printInfo = res.data.info;
          //       that.maxpage = printInfo.maxpage;
          //       var printList = printInfo.list;
          //       printList = printList.map(function(item, index, array) {
          //         if (item.is_finished == "Y") {
          //           item.update_times = 0;
          //         } else if (item.update_times > 9) {
          //           item.update_times = 10;
          //         }
          //         return item;
          //       });
          //       console.log(printList);
          //       that.printList = printList;
          //       that.page = 1;
          //       that.$nextTick(function() {
          //         fadeInUp('.print-list', '.print-item', 0.2);
          //       });
          //     }
          //     me.resetload();
          //     // 重置页数，重新获取loadDownFn的数据
          //     // page = 1;
          //     // 解锁loadDownFn里锁定的情况
          //     me.unlock();
          //     me.noData(false);
          //   },
          //   error: function(xhr, type) {
          //     me.resetload();
          //   }
          // });
        },
        loadDownFn: function(me) {
          // console.log("down");
          if (that.page >= that.maxpage) {            
            console.log('all');
            me.noData(true);
            me.lock('down');
            me.resetload();
            return false;
          }
          that.page = that.page + 1;
          artzheAgent.call1('Recommend/index', {
              page: that.page,
              pagesize: that.pagesize
            }, function(res) { 
              // console.log(res);
              if (res.code == '30000') {
                var printInfo = res.data.info;
                // that.page = parseInt(printInfo.page);
                that.maxpage = printInfo.maxpage;
                var printList = printInfo.list;
                printList = printList.map(function(item, index, array) {
                  if (item.is_finished == "Y") {
                    item.update_times = 0;
                  } else if (item.update_times > 9) {
                    item.update_times = 10;
                  }
                  return item;
                });
                console.log(printList);
                printList = that.printList.concat(printList);
                that.printList = printList;
                that.$nextTick(function() {
                  fadeInUp('.print-list', '.print-item', 0.2);
                });
              }
              // 每次数据加载完，必须重置
              me.resetload();
            },
            function (res) {
              // 即使加载出错，也得重置
              me.resetload();
            }
          );
          // $.ajax({
          //   type: 'POST',
          //   url: '/api/Recommend/index',
          //   data: {
          //     page: that.page,
          //     pagesize: that.pagesize
          //   },
          //   success: function(res) {
    
          //     console.log(res);
          //     if (res.code == '30000') {
          //       var printInfo = res.data.info;
          //       // that.page = parseInt(printInfo.page);
          //       that.maxpage = printInfo.maxpage;
          //       var printList = printInfo.list;
          //       printList = printList.map(function(item, index, array) {
          //         if (item.is_finished == "Y") {
          //           item.update_times = 0;
          //         } else if (item.update_times > 9) {
          //           item.update_times = 10;
          //         }
          //         return item;
          //       });
          //       console.log(printList);
          //       printList = that.printList.concat(printList);
          //       that.printList = printList;
          //       that.$nextTick(function() {
          //         fadeInUp('.print-list', '.print-item', 0.2);
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
    }
  },
  // components: {
  //   VueLazyload
  // }
});