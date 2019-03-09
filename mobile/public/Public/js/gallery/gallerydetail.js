Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmGalleryDetail = new Vue({
  // element to mount to
  el: '#gallery-detail',
  // initial data
  data: {
    isLoading: true,
    followClick: false,
    boxIsShow: false,
    shareIsShow: false,
    downloadIsShow: false, //下载新增代码
    boxMsg: '',
    artistInfo: {},
    artistId: '',
    artworkList: [

    ],
    page: 1,
    maxPage: 10000000,
    aDInfo: {
      isShow: true,
      height: '1.333333rem'
    },
    H5TopInfo: []
  },
  created: function() {
    this.init();
    // this.getH5TopInfo();
  },
  mounted: function() {
    // body...

    this.swpierAndLoad();

    noZoom();
    if (FastClick) {
      FastClick.attach(document.body);
    }
  },
  // methods
  methods: {
    init: function () {
      var that = this;
      this.artistId = document.getElementById('artistid').value || '';

      var data = {
        artistId: this.artistId
      };
      artzheAgent.call22('Gallery/getDetail', data, function(res) {
          // console.log('获取画家信息.res', res);
          that.isLoading = false;
          if (res.code == '30000') {
            that.artistInfo = res.data.info;
            document.title = that.artistInfo.name + '的画廊';
            that.artistInfo.resume = n2br(that.artistInfo.resume);

            //设置广告位信息
            that.newGetH5AD(res.data.info.shareInfo);
          }
      });
      artzheAgent.call44('Gallery/getArtworkDetailList', {artistId: this.artistId,page: 1,perPageNumber: 10}, function(res) {
          // console.log('获取画家作品列表.res', res);
          if (res.code == '30000') {
            var artList = res.data.info;
            // var current_page = res.data.current_page;
            // var last_page = res.data.last_page;
            var artworkList = artList.map(function(item, index, array) {
              item.story = n2br(item.story);
              if (item.isfinished == "Y") {
                item.updatetimes = 0;
                return item;
              } else if (item.updatetimes > 9) {
                item.updatetimes = 10;
                return item;
              } else {
                return item;
              }
            });
            that.artworkList = artworkList;
            // that.current_page = current_page;
            // that.last_page = last_page;
          }
      });
    },
    // 轮播切换及加载
    swpierAndLoad: function () {
      var that = this;
      var mySwiperH = new Swiper("#swiper-container-h", {
        slidesPerView: "auto",
        centeredSlides: !0,
        observer:true,         //修改swiper自己或子元素时，自动初始化swiper
        observeParents:true,   //修改swiper的父元素时，自动初始化swiper
        onSlideChangeEnd: function(swiper) {
          if (swiper.activeIndex == 0) { //切换结束时，告诉我现在是第几个slide
            $('#btn-resume').css({
              'display': 'none'
            });
            $('#btn-painting').css({
              'display': 'block'
            });
            $('.intro-wrap').scrollTop(0);
          } else {
            $('#btn-resume').css({
              'display': 'block'
            });
            $('#btn-painting').css({
              'display': 'none'
            });
            $('.intro-wrap').scrollTop(0);
          }
          //加载艺术品列表
          if ($('#swiper-container-h .swiper-slide').eq(-1).offset().left < 500) {
            if(that.page >= that.maxPage ) {
              console.log('加载完毕');
              return false;
            } else {
              var page = that.page + 1;
              var data = {
                artistId: that.artistId,
                page: page
              };
              // console.log('获取下一页.data', data);
              artzheAgent.call('Gallery/getArtworkDetailList', data, function(res) {
                  console.log('获取画家作品列表下一页.res', res);
                  if (res.code == '30000') {
                    var artList = res.data.info;
                    if (artList.length == 0) {
                      that.maxPage = that.page;
                      return false;
                    }
                    // var current_page = res.data.current_page;
                    // var last_page = res.data.last_page;
                    var newArtworkList = artList.map(function(item, index, array) {
                      if (item.is_finished == "Y") {
                        item.updatetimes = 0;
                        return item;
                      } else if (item.updatetimes > 9) {
                        item.updatetimes = 10;
                        return item;
                      } else {
                        return item;
                      }
                    });
                    // for (var i = 0; i < newArtworkList.length; i++) {
                    //   newArtworkList[i]
                    // }
                    that.artworkList = that.artworkList.concat(newArtworkList);
                    that.page++;
                  }
              });
            }
          }
        }
      });
      $('#btn-painting').on('click', function() {
        mySwiperH.slideTo(1, 1000, true);
      });
      $('#btn-resume').on('click', function() {
        mySwiperH.slideTo(0, 1000, true);
      });
    },
    showShare: function() {
      eventBus.$emit('showShareBox');
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.shareIsShow = false;
      this.downloadIsShow = false; //下载新增代码
    },
    toggleFollow: function(msg) {
      eventBus.$emit('showDownloadBox', msg);
      return false; //下载新增代码

      var that = this;
      var data = {
        artistId: this.artistId
      };
      if (this.followClick) {
        return false;
      }
      this.followClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass('anim-zooming');
      });  //放大缩小动画效果

      if (that.artistInfo.isFollowed == "Y") {
        artzheAgent.call('Gallery/unfollow', data, function(res) {
            // console.log(res);
            that.followClick = false;
            // console.log('unFollow.res', res);
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              window.location.href = "/wechat/login";
            } else if (res.code == '30000') {
              if (res.data.status == 1000) {
                that.artistInfo.isFollowed = "N";
                that.artistInfo.followTotal--;
              }
            }
        });

      } else {
        artzheAgent.call('Gallery/follow', data, function(res) {
            that.followClick = false;
            // console.log('follow.res', res);
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              window.location.href = "/wechat/login";
            } else if (res.code == '30000') {
              if (res.data.status == 1000) {
                that.artistInfo.isFollowed = "Y";
                that.artistInfo.followTotal++;
              }
            }
        });
      }
    },
    getH5TopInfo: function () {
      var that = this;
      var data = {
        artistId: this.artistId
      };
      artzheAgent.call('Gallery/getDetail', data, function(res) {
        // console.log('H5顶部广告位.res', res);
        var info = res.data.info.shareInfo;
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
    closeAD: function () {
      this.aDInfo = {
        isShow: false,
        height: '0'
      };
    }
  },
  // components: {
  //   VueLazyload
  // }
});
