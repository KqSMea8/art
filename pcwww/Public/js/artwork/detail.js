Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
    compress: compress, //图片压缩后缀
    info: {
      artist: "",
      category: "",
      category_name: "",
      color_ids: "",
      comment_total: "",
      cover: "",
      coverList: [],
      coverThumbList: [],
      create_time: "",
      diameter: "0",
      id: "",
      is_deleted: "",
      is_edit: "",
      is_finished: "",
      is_like: "",
      like_images: [],
      like_total: "",
      publisher: {},
      tags: [],
      topography_ids: "",
      updateList: [],
      update_times: "",
      view_total: "",
      width: ""
    },
    btnText: {
      'Y': '已关注',
      'N': '+ 关注'
    },
    relateInfo: {
      data: [],
      page: 0
    },
    otherActive: 1, //相关推荐当前是第几页

    activeIndex: 1, //大图轮播的index+1
    imgboxIsShow: false, //提醒弹窗是否显示
    boxIsShow: false, //弹窗蒙层是否显示
    followClick: false,
    likeClick: false
  },
  created: function() {
    this.getArtworkDetail(); //Api/Artwork/getArtworkDetail
    this.getArtworks();
  },
  mounted: function() {
    var that = this;

    var otherArts = new Swiper('.other-wrap .swiper-container', {
      spaceBetween: 25,
      observer: true, //修改swiper自己或子元素时，自动初始化swiper
      observeParents: true, //修改swiper的父元素时，自动初始化swiper
      slidesPerView: 4,
      slidesPerGroup: 4,
      onSlideNextEnd: function(swiper) {
        that.otherActive = parseInt(swiper.activeIndex / 4 + 1);
      }

    });
    $('.other-wrap .arrow-right').on('click', function(e) {
      e.preventDefault();
      // console.log(otherArts.activeIndex);
      that.otherActive = parseInt(otherArts.activeIndex / 4 + 2);
      if (parseInt(otherArts.activeIndex / 4 + 1) >= that.relateInfo.page) {
        that.getArtworks(function() {
          that.$nextTick(function() {
            otherArts.slideNext();
          });
        });
      } else if (parseInt(otherArts.activeIndex / 4 + 1) < that.relateInfo.page) {
        otherArts.slideNext();
      }
    });
    $('.other-wrap .arrow-left').on('click', function(e) {
      e.preventDefault();
      // console.log(otherArts.activeIndex);
      that.otherActive = parseInt(otherArts.activeIndex / 4);
      if (parseInt(otherArts.activeIndex / 4 + 1) > 1) {
        otherArts.slidePrev();
      }
    });

    eventBus.$on('unlike', function(id, type, index, faceUrl) {
      this.unlike(id, type, index, faceUrl);
    }.bind(this));
  },
  methods: {
    overFollowText: function() {
      if (this.info.publisher.btnText == '已关注') {
        this.info.publisher.btnText = '取消关注';
      }
    },
    outFollowText: function() {
      if (this.info.publisher.btnText == '取消关注') {
        this.info.publisher.btnText = '已关注';
      }
    },
    toggleFollow: function(id) {
      var that = this;
      var data = {
        artistId: id
      };
      if (this.followClick) {
        return false;
      }
      this.followClick = true;

      if (that.info.publisher.isFollow == "Y") {
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
              that.info.publisher.isFollow = "N";
              that.info.publisher.btnText = '+ 关注';
              that.info.publisher.followTotal--;
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
              that.info.publisher.isFollow = "Y";
              that.info.publisher.btnText = '已关注';
              that.info.publisher.followTotal++;
            }
          }
        });
      }
    },
    toggleLike: function() {
      var that = this;
      var data = {
        id: GetLocationId() ? GetLocationId() : -1,
        type: 1
      };
      if (that.info.is_like == "N") {
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
              that.info.is_like = "Y";
              that.info.like_total++;
              if (that.info.like_images.length > 0 && that.info.like_images[0].indexOf(res.data.faceUrl) !== -1) {
                that.info.like_images.unshift(res.data.faceUrl);
              } else if (that.info.like_images.length > 9) {
                that.info.like_images.pop();
                that.info.like_images.unshift(res.data.faceUrl);
              } else {
                that.info.like_images.unshift(res.data.faceUrl);
              }
            }
          }
        });
      } else if (that.info.is_like == "Y") {
        eventBus.$emit('showLikeBox', data.id, 1);
      }
    },
    unlike: function(id, type, index, faceUrl) {
      this.info.is_like = "N";
      this.info.like_total--;
      var arrLikes = [],
        that = this;
      for (var i = 0; i < that.info.like_images.length; i++) {
        if (that.info.like_images[i].indexOf(faceUrl) === -1) {
          arrLikes.push(that.info.like_images[i]);
        }
      }
      that.info.like_images = arrLikes;
    },
    getArtworkDetail: function() {
      var that = this;
      var api = '/Api/Artwork/getArtworkDetail';
      var data = {
        artworkId: GetLocationId() ? GetLocationId() : -1,
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            resInfo.name = checkMark(resInfo.name);
            if (resInfo.publisher.category_name) {
              resInfo.publisher.mark = resInfo.publisher.category_name;
            } else {
              resInfo.publisher.mark = resInfo.publisher.motto;
            }
            if (resInfo.publisher.isFollow == 'Y') {
              resInfo.publisher.btnText = '已关注';
            } else if (resInfo.publisher.isFollow == 'N') {
              resInfo.publisher.btnText = '+ 关注';
            }
            that.info = resInfo;
            that.activeImg = resInfo.coverThumbList[0];


            document.title = resInfo.shareTitle;
            //百度分享js
            window._bd_share_config = {
              "common": {
                "bdSnsKey": {},
                "bdText": resInfo.shareTitle,
                "bdDesc": resInfo.shareDesc,
                "bdMini": "2",
                "bdMiniList": false,
                "bdPic": resInfo.shareImg,
                "bdStyle": "2",
                "bdSize": "32"
              },
              "share": {}
            };
            with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = '/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];


            that.$nextTick(function() {
              var viewSwiper = new Swiper('.view .swiper-container', {
                observer: true, //修改swiper自己或子元素时，自动初始化swiper
                observeParents: true, //修改swiper的父元素时，自动初始化swiper
                onSlideChangeStart: function() {
                  updateNavPosition();
                }
              })

              $('.preview .arrow-left').on('click', function(e) {
                e.preventDefault()
                if (viewSwiper.activeIndex == 0) {
                  viewSwiper.slideTo(viewSwiper.slides.length - 1, 600);
                  return
                }
                viewSwiper.slidePrev()
              })
              $('.preview .arrow-right').on('click', function(e) {
                e.preventDefault()
                if (viewSwiper.activeIndex == viewSwiper.slides.length - 1) {
                  viewSwiper.slideTo(0, 600);
                  return
                }
                viewSwiper.slideNext()
              })
              $('.preview .swiper-slide').on('click', function(e) {
                e.preventDefault();
                var index = $('.preview .swiper-slide').index(this);
                viewSwiper.slideTo(index, 600);
              })

              var previewSwiper = new Swiper('.preview .swiper-container', {
                spaceBetween: 20,
                slidesPerView: 'auto',
                observer: true, //修改swiper自己或子元素时，自动初始化swiper
                observeParents: true, //修改swiper的父元素时，自动初始化swiper
                onlyExternal: true,
                onInit: function(s) {
                  $('.preview .swiper-slide').eq(0).addClass('active-nav');
                  that.activeIndex = 1; //初始化
                }
              })

              function updateNavPosition() {
                $('.preview .active-nav').removeClass('active-nav');
                var activeNav = $('.preview .swiper-slide').eq(viewSwiper.activeIndex).addClass('active-nav');
                that.activeIndex = viewSwiper.activeIndex + 1;
                if (!activeNav.hasClass('swiper-slide-visible')) {
                  if (activeNav.index() > previewSwiper.activeIndex) {
                    var thumbsPerNav = Math.floor(previewSwiper.width / activeNav.width()) - 1
                    previewSwiper.slideTo(activeNav.index() - thumbsPerNav)
                  } else {
                    previewSwiper.slideTo(activeNav.index())
                  }
                }
              }
            });

          }
        }
      });
    },
    getArtworks: function(cb) {
      var that = this;
      var api = '/Api/Artwork/getArtworks';
      var data = {
        artworkId: GetLocationId() ? GetLocationId() : -1,
        page: ++this.relateInfo.page,
        pagesize: 4
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            if (resInfo.page == 1) {
              that.relateInfo = resInfo;
            } else if (resInfo.page > 1) {
              that.relateInfo.data = that.relateInfo.data.concat(resInfo.data);
            }
          }
          typeof cb == 'function' && cb();
        }
      });
    },
    hideBox: function() {
      $('html,body').css({
        'height': 'auto',
        'overflow': 'auto'
      });
      this.boxIsShow = false;
      this.imgboxIsShow = false;
    },
    showimgBox: function() {
      $('html,body').css({
        'height': '100%',
        'overflow': 'hidden'
      });
      $('.layerbox .img-box img').css({
        'max-height': $('body').height()
      });

      this.boxIsShow = true;
      this.imgboxIsShow = true;
    },
  }
});