Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmArtworkDetail = new Vue({
  // element to mount to
  el: '#artwork-detail',
  // initial data
  data: {
    isLoading: true,
    followClick: false,
    isFollow: false,
    likeClick: false,
    isLike: false,
    userId: '',
    artId: '',
    artworkNow: {
      prints: {}
    },
    updateList: {},
    boxIsShow: false,
    shareIsShow: false,
    downloadIsShow: false, //下载新增代码
    boxMsg: '',
    artist: {},
    curYear: '',
    aDInfo: {
      isShow: true,
      height: '1.333333rem'
    },
    H5TopInfo: [],
    sellInfo: {}
  },
  created: function() {
    var artId = document.getElementById('artworkid').value || '';
    this.artId = artId;
    this.init();
    // this.getH5TopInfo();
  },
  mounted: function () {
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
        artId: this.artId
      };
      // artzheAgent.call22('Artwork/getArtDetail', data, function(res) {
      //   // console.log('获取作品详情.res', res);
      //   // console.log('获取作品详情.data', res.data);
      //   if (res.code == 30000) {
      //     var artworkNow = res.data.info;
      //     that.artist = res.data.info.publisher;
      //     var updateList = res.data.info.updateList;
      //     document.title = res.data.info.name;
      //
      //     artworkNow.story = n2br(artworkNow.story); //转换换行符
      //     updateList = updateList.map(function(item, index, array) {
      //       item.list.forEach(function(childItem, childIndex, childArray) {
      //         // var dateArray = childItem.create_date.split("-");
      //         var create_date = childItem.create_date.replace(/-/gi,"/");
      //         var dateTime = new Date(create_date);
      //         childItem.month = dateTime.getMonth() + 1;
      //         childItem.day = dateTime.getDate();
      //         childItem.summary = n2br(childItem.summary);
      //         if (childItem.number > 10) {
      //           childItem.number = 10;
      //         }
      //         if (childItem.coverUrl.length > 3) {
      //           childItem.coverUrl = childItem.coverUrl.slice(0, 3);
      //         }
      //       });
      //       return item;
      //     });
      //     that.artworkNow = artworkNow;
      //     that.updateList = updateList;
      //     if (that.updateList.length > 0) {
      //       that.curYear = that.updateList[0].year;
      //     }
      //     that.isLike = res.data.info.is_like;
      //     that.isFollow = res.data.info.publisher.isFollow;
      //     if (res.data.info.is_like == "Y") {
      //       that.isLike = true;
      //     } else {
      //       that.isLike = false;
      //     }
      //     if (res.data.info.publisher.isFollow == "Y") {
      //       that.isFollow = true;
      //     } else {
      //       that.isFollow = false;
      //     }
      //     if (that.artworkNow.is_finished == "Y") {
      //       that.artworkNow.update_times = 0;
      //     } else if (that.artworkNow.update_times > 9) {
      //       that.artworkNow.update_times = 10;
      //     } else {
      //       that.artworkNow.update_times = that.artworkNow.update_times; //可省略
      //     }
      //
      //     var swiper = new Swiper('#swiper-covers', {
      //       pagination: '#swiper-covers-pagination',
      //       paginationClickable: true,
      //       observer: true, //修改swiper自己或子元素时，自动初始化swiper
      //       observeParents: true, //修改swiper的父元素时，自动初始化swiper
      //     });
      //     that.isLoading = false;
      //
      //     //设置广告位信息
      //     that.newGetH5AD(res.data.info.shareInfo);
      //
      //     that.$nextTick(function() {
      //       // that.isLoading = false;
      //       $('.update-year-item .year').each(function(index, domEle) {
      //         new StickUpAll(domEle);
      //       });
      //       that.showImgList();
      //     });
      //   }
      // });
      artzheAgent.callM('Artwork/getArtDetail',{id: data.artId},function(res){ // 新接口
        // console.log('获取作品详情.res', res);
        // console.log('获取作品详情.data', res.data);
        if (res.code == 30000) {

          that.sellInfo.prints = res.data.info.goodsInfo.prints; //版画
          that.sellInfo.raw = res.data.info.goodsInfo.raw; //版画

          // console.log(that.sellInfo)
          var artworkNow = res.data.info;
          that.artist = res.data.info.publisher;
          var updateList = res.data.info.updateList;
          document.title = res.data.info.name;

          artworkNow.story = n2br(artworkNow.story); //转换换行符
          updateList = updateList.map(function(item, index, array) {
            item.list.forEach(function(childItem, childIndex, childArray) {
              // var dateArray = childItem.create_date.split("-");
              var create_date = childItem.create_date.replace(/-/gi,"/");
              var dateTime = new Date(create_date);
              childItem.month = dateTime.getMonth() + 1;
              childItem.day = dateTime.getDate();
              childItem.summary = n2br(childItem.summary);
              if (childItem.number > 10) {
                childItem.number = 10;
              }
              if (childItem.coverUrl.length > 3) {
                childItem.coverUrl = childItem.coverUrl.slice(0, 3);
              }
            });
            return item;
          });
          that.artworkNow = artworkNow;
          that.updateList = updateList;
          if (that.updateList.length > 0) {
            that.curYear = that.updateList[0].year;
          }
          that.isLike = res.data.info.is_like;
          that.isFollow = res.data.info.publisher.isFollow;
          if (res.data.info.is_like == "Y") {
            that.isLike = true;
          } else {
            that.isLike = false;
          }
          if (res.data.info.publisher.isFollow == "Y") {
            that.isFollow = true;
          } else {
            that.isFollow = false;
          }
          if (that.artworkNow.is_finished == "Y") {
            that.artworkNow.update_times = 0;
          } else if (that.artworkNow.update_times > 9) {
            that.artworkNow.update_times = 10;
          } else {
            that.artworkNow.update_times = that.artworkNow.update_times; //可省略
          }

          var swiper = new Swiper('#swiper-covers', {
            pagination: '#swiper-covers-pagination',
            paginationClickable: true,
            observer: true, //修改swiper自己或子元素时，自动初始化swiper
            observeParents: true, //修改swiper的父元素时，自动初始化swiper
          });
          that.isLoading = false;

          //设置广告位信息
          that.newGetH5AD(res.data.info.shareInfo);

          that.$nextTick(function() {
            // that.isLoading = false;
            $('.update-year-item .year').each(function(index, domEle) {
              new StickUpAll(domEle);
            });
            that.showImgList();
          });
        }
      });
    },
    showShare: function() {
      eventBus.$emit('showShareBox');
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.shareIsShow = false;
      this.downloadIsShow = false;
    },
    showMsg: function (msg) {
      eventBus.$emit('showDownloadBox', msg);
      return false; //下载新增代码

      window.location.href = '/artwork/messageboard/' + this.artworkNow.id;
    },
    toggleLike: function(msg) {
      eventBus.$emit('showDownloadBox', msg);
      return false; //下载新增代码

      var that = this;
      var data = {
        id: this.artId
      };
      if (this.likeClick) {
        return false;
      }
      this.likeClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass('anim-zooming');
      });  //放大缩小动画效果

      if (this.isLike) {
        artzheAgent.call('Artwork/unlike', data, function(res) {
          that.likeClick = false;
          // console.log('cancelLike.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isLike = false;
              that.artworkNow.like_total--;
            }
          }
        });
      } else {
        artzheAgent.call('Artwork/like', data, function(res) {
          that.likeClick = false;
          // console.log('likeArt.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isLike = true;
              that.artworkNow.like_total++;
            }
          }
        });
      }
    },
    toggleFollow: function(msg, event) {
      eventBus.$emit('showDownloadBox', msg);
      return false; //下载新增代码

      var that = this;
      var data = {
        artistId: this.artworkNow.artist
      };
      if (this.followClick) {
        return false;
      }
      this.followClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass('anim-zooming');
      });  //放大缩小动画效果

      if (this.isFollow) {
        artzheAgent.call('Gallery/unfollow', data, function(res) {
          that.followClick = false;
          // console.log('unFollow.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isFollow = false;
              that.artist.follower_total--;
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
              that.isFollow = true;
              that.artist.follower_total++;
            }
          }
        });
      }
    },
    showCoverList: function(item) {

      wx.previewImage({
        current: item,
        urls: this.artworkNow.coverList
      });
    },
    showImgList: function() {
      var that = this;
      var $imgList = $('#swiper-covers').find('img');
      // console.log($imgList);
      $imgList.click(function(event) { //绑定图片点击事件
        var index = $imgList.index(this);

        var imgList = that.artworkNow.coverList;
        var thisImg = that.artworkNow.coverList[index];

        wx.ready(function() {
          wx.previewImage({
            current: thisImg, // 当前显示图片的http链接
            urls: imgList // 需要预览的图片http链接列表
          });
        });
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
    },
    sellPainting:function(){ //购买版画btn
      console.log('购买版画btn')
      window.location.href = this.sellInfo.prints.link;

    },
    sellRaw:function(){ //购买原作btn
      console.log('购买原作btn')
      window.location.href=this.sellInfo.raw.link;

    }
  }

  // components: {
  //   VueLazyload
  // }
});
