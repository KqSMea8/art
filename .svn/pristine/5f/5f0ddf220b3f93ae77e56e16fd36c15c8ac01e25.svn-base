var vmComments = new Vue({
  // element to mount to
  el: '#comments',
  // initial data
  data: {
    isLoading: true,
    hasList: true,
    comInfoList: [],
    boxIsShow: false,
    shareIsShow: false,
    downloadIsShow: false, //下载新增代码
    boxMsg: '',
    commentContent: '',
    artId: '',
    commentSubmit: false,
    zanClick: false,
    hasMore: true,
    page: 0,
    maxPage: 1,
    aDInfo: {
      isShow: true,
      height: '1.333333rem'
    },
    H5TopInfo: []
  },
  created: function() {
    var userNickname = document.getElementById('nickname').value || '';
    var userFace = document.getElementById('face').value || '';
    this.artId = document.getElementById('artworkid').value || '';
    this.userInfo = {
      face: userFace,
      nickname: userNickname
    };

    // this.getH5TopInfo();

    // this.init();
  },
  mounted: function() {
    // body...
    noZoom();
    if (FastClick) {
      FastClick.attach(document.body);
    }
  },
  // methods
  methods: {
    init: function() {
      var that = this;
      var data = {
        id: this.artId,
        type: 1,
        page: 1,
        pageSize: 10
      };
      artzheAgent.call('Artwork/getCommentList', data, function(res) {
        console.log('获取作品留言列表.res', res);

        if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
          // getToken(that.init);
          // window.location.href = "/wechat/login"; //暂时屏蔽
        } else if (res.code == '30000') {
          console.log('获取作品留言列表.data.info', res.data.info);
          that.comInfoList = res.data.info.list;
          
          
        }
      });
    },
    refresh: function() {
      this.page = 1;
      this.hasMore = true;
      this.getData(this.page);
      // this.$nextTick(function () {
      //   this.$refs.my_scroller.resize();
      // });
    },

    infinite: function() {
      this.page = this.page + 1;
      this.getData(this.page);
    },
    getData: function(page) {
      var that = this;
      if (that.hasMore) {
        artzheAgent.call('Artwork/getCommentList', {
          id: that.artId,
          type: 1,
          page: page,
          pageSize: 10
        }, function(res) {
          // console.log("获取作品留言列表.res", res);
          that.isLoading = false;
          if (res.code == 30000) {
            if (that.H5TopInfo.length == 0) {
              //设置广告位信息
              that.newGetH5AD(res.data.info.shareInfo);
            }
            if (res.data.info.list.length > 0) {
              if (page == 1) {
                that.comInfoList = res.data.info.list;
                that.$refs.my_scroller.finishPullToRefresh();
                that.$refs.my_scroller.finishInfinite();
                if (res.data.info.maxpage == 1) {
                  that.$refs.my_scroller.finishInfinite(true);
                }
              } else {
                that.comInfoList = that.comInfoList.concat(res.data.info.list);
                that.$refs.my_scroller.finishInfinite();
              }

            } else {
              if (page == 1) {
                that.hasList = false;
              }
              that.hasMore = false;
              that.$refs.my_scroller.finishInfinite(true);
            }
            that.$nextTick(function() {
              that.$refs.my_scroller.resize();
            });
            that.maxPage = res.data.info.maxpage;
          } else {
            TipsShow.showtips({
              info: res.message
            });
          }
        });
        // $.ajax({
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   url: "/api/Artwork/getCommentList", //获取作品留言列表
        //   type: 'POST',
        //   dataType: "json",
        //   data: {id: that.artId, type: 1, page: page, pageSize: 10},
        //   success: function (res) {
        //     console.log("获取作品留言列表.res", res);
        //     that.isLoading=false;
        //     if (res.code == 30000) {
        //       if(res.data.info.list.length>0){
        //         if(page==1){
        //           that.comInfoList = res.data.info.list;
        //           that.$refs.my_scroller.finishPullToRefresh();
        //           that.$refs.my_scroller.finishInfinite();
        //           if (res.data.info.maxpage == 1) {
        //             that.$refs.my_scroller.finishInfinite(true);
        //           }
        //         }else{
        //           that.comInfoList = that.comInfoList.concat(res.data.info.list);
        //           that.$refs.my_scroller.finishInfinite();
        //         }

        //       }else{
        //         if (page == 1) {
        //           that.hasList = false;
        //         }
        //         that.hasMore = false;
        //         that.$refs.my_scroller.finishInfinite(true);
        //       }
        //       that.$nextTick(function () {
        //         that.$refs.my_scroller.resize();
        //       });
        //       that.maxPage = res.data.info.maxpage;
        //     } else {
        //       TipsShow.showtips({
        //         info: res.message
        //       });
        //     }
        //     that.$nextTick(function () {
        //       that.isLoading = false;
        //     });
        //   },
        //   complete: function () {
        //     // that.$nextTick(function () {
        //     //   that.isLoading = false;
        //     // });
        //   }
        // });
      } else {
        this.$refs.my_scroller.finishInfinite(true);
      }
    },
    showShare: function() {
      eventBus.$emit('showShareBox');
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.shareIsShow = false;
      this.downloadIsShow = false;
    },
    toggleZan: function (id, isLike) {
      eventBus.$emit('showDownloadBox', '感谢您的点赞，立即下载APP查看更多作品吧~');
      return false; //下载新增代码

      var that = this;
      var data = {
        commentId: id
      };
      
      if (this.zanClick) {
        return false;
      }
      this.zanClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass('anim-zooming');
      });  //放大缩小动画效果

      if (isLike == 'Y') {
        artzheAgent.call('Comment/unzan', data, function(res) {
          that.zanClick = false;
          // console.log('unzan.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.comInfoList.forEach(function(item) {
                if (item.commentId == id) {
                  // Vue.set(item, "unfollow", true);
                  item.isLike = 'N';
                  item.likes--;
                }
              });
            }
          }
        });
      } else {
        artzheAgent.call('Comment/zan', data, function(res) {
          that.zanClick = false;
          // console.log('zan.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.comInfoList.forEach(function(item) {
                if (item.commentId == id) {
                  // Vue.set(item, "unfollow", true);
                  item.isLike = 'Y';
                  item.likes++;
                }
              });
            }
          }
        });
      }
    },
    commentUpdate: function(msg) {
      eventBus.$emit('showDownloadBox', msg);
      return false; //下载新增代码

      var that = this;
      var data = {
        artId: this.artId,
        type: 1,
        content: this.commentContent
      };
      if (this.commentContent === '') {
        TipsShow.showtips({
          info: "请输入评论"
        });
        return false;
      }
      if (this.commentSubmit) {
        return false;
      }
      console.log(data);
      this.commentSubmit = true;
      artzheAgent.call('Artwork/comment', data, function(res) {
        console.log('comment.res', res);
        if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
          window.location.href = "/wechat/login";
        } else if (res.code == '30000') {
          if (res.data.status == 1000) {
            var commentItem = res.data.commentInfo;
            commentItem.isLike = 'N';
            commentItem.likes = '0';
            
            that.commentContent = '';
            that.comInfoList.unshift(commentItem);
          }
        }
        that.commentSubmit = false;
      });
    },
    getH5TopInfo: function() {
      var that = this;
      artzheAgent.call('Ad/getH5Top', {}, function(res) {
        // console.log('H5顶部广告位.res', res);
        that.H5TopInfo = res.data.info;
        that.$nextTick(function() {
          var mySwiperH5 = new Swiper("#swiper-container-t", {
            loop: true,
            autoplay: 4000,
            speed: 1000,
            slidesPerView: "auto",
            pagination: '#swiper-pagination-t',
            paginationClickable: true,
            centeredSlides: !0,
            observer: true, //修改swiper自己或子元素时，自动初始化swiper
            observeParents: true, //修改swiper的父元素时，自动初始化swiper
          });
        });
      });
    },
    newGetH5AD: function (shareInfo) {
      var that = this;
      var info = shareInfo;
      var H5TopInfo = {};

      H5TopInfo.img = info.face;
      H5TopInfo.title = info.name;
      if (info.motto) {
        H5TopInfo.desc = info.motto;
      } else {
        H5TopInfo.desc = info.category + '艺术家';
      }
      that.H5TopInfo[0] = H5TopInfo;
      that.$nextTick(function() {
        var mySwiperH5 = new Swiper("#swiper-container-t", {
          loop: true,
          autoplay: 0,
          speed: 1000,
          slidesPerView: "auto",
          pagination: null,
          paginationClickable: true,
          centeredSlides: !0,
          observer: true, //修改swiper自己或子元素时，自动初始化swiper
          observeParents: true, //修改swiper的父元素时，自动初始化swiper
        });
      });
    },
    closeAD: function() {
      this.aDInfo = {
        isShow: false,
        height: '0'
      };
    }
  },
  // components: {
  //   VueScroller: VueScroller
  // }
});