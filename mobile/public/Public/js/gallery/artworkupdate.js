Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: false,
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmArtworkUpdate = new Vue({
  // element to mount to
  el: '#artwork-update',
  // initial data
  data: {
    isLoading: true,
    likeClick: false,
    followClick: false,
    zanClick: false,
    isLike: false,
    isFollow: false,
    updateId: '',
    artistid: '',
    update: {
      "id": "14", //更新的ID
      "artwork_id": "", //作品的ID
      "artname": "", //作品名称
      "time": "", //更新时间，用户选择的
      "wit": "", //内容
      "cover": "", //封面
      "publisher": "",
      "commentTotal": "", //评论总数
      "is_finished": "", //是否完成
      "is_like": "", //是否喜欢
      "number": "", //第几次更新
      "like_total": "", //喜欢总数
      "view_total": "", //浏览总数
      "create_time": "", //上传时间
      "orgImages": [], // 原图的列表
      "commentList": [],
      "shareTitle": "",
      "shareDesc": "",
      "shareImg": "",
      "shareInfo": {
        "cover": "",
        "face": "",
        "name": "",
        "category": "",
        "link": ""
      },
      "publisherInfo": {
        "nickname": "",
        "name": "",
        "face": "",
        "artTotal": "",
        "faceUrl": "",
        "isFollow": "",
        "follower_total": ""
      }, //作者
      "related": [], //相关推荐
      "likes": [], //喜欢的人头像
    },
    boxIsShow: false,
    shareIsShow: false,
    downloadIsShow: false, //下载新增代码
    boxMsg: '',
    btnShow: false,
    commentContent: '',
    commentSubmit: false,
    userInfo: {

    },
    publisher: {},
    aDInfo: {
      isShow: true,
      height: '1.333333rem'
    },
    H5TopInfo: []
  },
  watch: {
    // 如果 发生改变，这个函数就会运行
    commentContent: function() {
      if (this.commentContent == '') {
        this.btnShow = false;
      } else {
        this.btnShow = true;
      }
    }
  },
  created: function() {
    var userNickname = document.getElementById('nickname').value || '';
    var userFace = document.getElementById('face').value || '';
    var artistid = document.getElementById('artistid').value || '';
    this.userInfo = {
      face: userFace,
      nickname: userNickname
    };
    this.artistid = artistid;

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
      this.updateId = document.getElementById('artworkid').value || '';
      var data = {
        id: this.updateId
      };
      artzheAgent.call2('Artwork/updateDetail', data, function(res) {
        // console.log('获取作品单次更新详情.res', res);
        that.isLoading = false;
        if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
          // getToken(that.init);
          // window.location.href = "/wechat/login";  //暂时屏蔽
        } else if (res.code == '30000') {
          console.log('获取作品单次更新详情.data.info', res.data.info);
          document.title = res.data.info.artname;
          var update = res.data.info;
          if (update.is_finished == "Y") {
            update.number = 0;
          } else if (update.number > 9) {
            update.number = 10;
          } else {
            update.number = update.number; //可省略
          }
          if (update.is_like == "Y") {
            that.isLike = true;
          } else {
            that.isLike = false;
          }
          if (res.data.info.publisherInfo.isFollow == "Y") {
            that.isFollow = true;
          } else {
            that.isFollow = false;
          }
          if (update.commentList.length > 2) {
            update.commentList = update.commentList.slice(0, 2);
          }
          if (update.likes.length > 6) {
            update.likes = update.likes.slice(0, 6);
          }
          // update.wit = update.wit.replace(/([a-z]*-*[a-z]+:\s*[0-9]+)px/g, '$1/75rem');
          update.wit = px2rem(update.wit);

          //图片懒加载

          var el = document.createElement('div');
          el.innerHTML = update.wit;
          var $el = $(el);
          var imgs = $el.find('img');
          imgNum = $("img").length,

          imgs.each(function () {
            var src = $(this).attr("src");
            $(this).attr("data-src", src);
            $(this).attr('src', '/Public/image/holder.png');
          });

          update.wit = el.innerHTML;


          that.update = update;
          that.publisher = update.publisher;

          //设置广告位信息
          that.newGetH5AD(res.data.info.shareInfo);
          // that.newGetH5AD(res.data.info.publisherInfo.id);
        }
        that.$nextTick(function() {

          that.showImgList();
          that.lazyload();
          
          // document.addEventListener('touchmove',that.lazyload, false);
          // document.addEventListener('scroll',that.lazyload, false);
          // document.addEventListener('wheel',that.lazyload, false);

          // TODO: 等页面加载完成后给音频添加播放事件
          function pauseAll() {
            $('.audioPlayBox').attr('data-flag',false);
            for( var i = 0 , len = $('audio').length ; i < len ; i ++ ){
              // $('audio')[i].currentTime=0;
              $('audio')[i].volume=0.5; // 声音音量。1为最大
              $('audio')[i].pause();
              $('.playImgBox').removeClass('playPause').addClass('playimg'); // 重置播放图标
            }
          }

          $('.audioPlayBox').on('click',function(){
            var thisIndex = $('.audioPlayBox').index($(this));
            if($(this).attr('data-flag')=='true'){ // 通过判断$('.audioPlayBox')的data-flag来做操作
              pauseAll();
              $('.audioPlayBox').attr('data-flag',false);
              $(this).children(1).children('.playImgBox').removeClass('playPause').addClass('playimg'); // 为当前播放的加上暂停图标
            }else{
              pauseAll();
              $(this).attr('data-flag', true);
              $(this).children(1).children('.playImgBox').removeClass('playimg').addClass('playPause'); // 为当前播放的加上暂停图标
              $('audio')[thisIndex].play();
            }
          })

        });
      });
    },
    lazyload: function () {
      var imgs = $('#wit').find('img');
      var n = 0;
      for (var i = n; i < imgs.length; i++) {
        if (imgs.eq(i).offset().top < parseInt($(window).height()) + parseInt($('.update-wrap').scrollTop())) {
          if (imgs.eq(i).attr("src") == "/Public/image/holder.png") {
            var src = imgs.eq(i).attr("data-src");
            imgs.eq(i).attr("src", src);
            n = i + 1;
          }
        }
      }
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
        artistId: this.artistid
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
              that.update.publisherInfo.follower_total--;
            }
          }
        });
      } else {
        artzheAgent.call('Gallery/follow', data, function(res) {
          that.followClick = false;
          console.log('follow.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isFollow = true;
              that.update.publisherInfo.follower_total++;
            }
          }
        });
      }
    },
    stickInput: function (e) {
      setTimeout(function() {
        var input = document.getElementById('message-frame');
        input.scrollIntoView(true);
        // var height = document.getElementById('message-frame').offsetHeight;
        // window.scrollTo(0,document.body.offsetHeight);
        // document.body.scrollTop = document.body.scrollHeight;
      }, 100);
    },
    toggleLike: function(msg) {
      eventBus.$emit('showDownloadBox', msg);
      return false; //下载新增代码

      var that = this;
      var data = {
        id: this.updateId,
        type: 2
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
          console.log('cancelLike.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isLike = false;
              var arrLikes = [];
              for (var i = 0; i < that.update.likes.length; i++) {
                if (that.update.likes[i].indexOf(res.data.faceUrl) === -1) {
                  arrLikes.push(that.update.likes[i]);
                }
              }
              that.update.likes = arrLikes;
              that.update.like_total--;
            }
          }
        });
      } else {
        artzheAgent.call('Artwork/like', data, function(res) {
          that.likeClick = false;
          console.log('likeArt.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isLike = true;
              if (res.data.faceUrl.indexOf('?x-oss-process') === -1) {
                res.data.faceUrl = res.data.faceUrl + '?x-oss-process=image/resize,m_fixed,h_180,w_180';
              }

              if (that.update.likes.length > 0 && that.update.likes[0].indexOf(res.data.faceUrl) !== -1) {
                that.update.likes.unshift(res.data.faceUrl);
              } else if (that.update.likes.length > 5) {
                that.update.likes.pop();
                that.update.likes.unshift(res.data.faceUrl);
              } else {
                that.update.likes.unshift(res.data.faceUrl);
              }
              that.update.like_total++;
            }
          }
        });
      }
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
          console.log(res);
          that.zanClick = false;
          console.log('unFollow.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.update.commentList.forEach(function(item) {
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
          console.log('follow.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.update.commentList.forEach(function(item) {
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
        artId: this.updateId,
        type: 2,
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
            that.update.commentTotal++;
            that.update.commentList.unshift(commentItem);
          }
        }
        that.commentSubmit = false;
      });
    },
    showImgList: function() {
      var that = this;
      var $imgList = $('#wit img');
      $imgList.click(function(event) { //绑定图片点击事件
        var index = $imgList.index(this);
        var imgList = that.update.orgImages;
        var thisImg = that.update.orgImages[index];
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
      // that.$nextTick(function() {
      //   var mySwiperH5 = new Swiper("#swiper-container-t", {
      //     loop: true,
      //     autoplay: 0,
      //     speed: 1000,
      //     slidesPerView: "auto",
      //     pagination: null,
      //     paginationClickable: true,
      //     centeredSlides: !0,
      //     observer: true, //修改swiper自己或子元素时，自动初始化swiper
      //     observeParents: true, //修改swiper的父元素时，自动初始化swiper
      //   });
      // });
    },
    closeAD: function() {
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
