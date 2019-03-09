Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

function getImageWidth(url,callback){
  var img = new Image();
  img.src = url;

  // 如果图片被缓存，则直接返回缓存数据
  if(img.complete){
    callback(img.width, img.height);
  }else{
    // 完全加载完毕的事件
    img.onload = function(){
      callback(img.width, img.height);
    }
  }

}


var vmArtworkUpdate = new Vue({
  // element to mount to
  el: '#article-detail',
  // initial data
  data: {
    isLoading: true,
    likeClick: false,
    followClick: false,
    zanClick: false,
    isLike: false,
    isFollow: false,
    articleId: '',
    artistid: '',
    update: {
      "title": "",
      "content": "",
      "like_count": "",
      "create_time": "",
      "views": "",
      "is_like": 0,
      "follow_user": 0,
      "html5_url": "https://m.artzhe.com/article/content/27",
      "userinfo": {
        "id": "100037",
        "nickname": "gordon",
        "faceUrl": "https://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/07/28/1501224616175.png",
        "gender": "1",
        "is_artist": 0,
        "is_agency": 0,
        "is_planner": 0
      },
      "like_users": [
        "https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png"
        // "https://artzhe.oss-cn-shenzhen.aliyuncs.com/other/artzhe/user/android2017-08-01-111406-4tqzdyrv1z.jpg"
      ],
      "images": [
        "https://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/08/15/1502793432102932.jpeg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg",
        "https://artzhe.oss-cn-shenzhen.aliyuncs.com/uploads/2017/08/15/1502793386555454.jpeg?x-oss-process=image/resize,m_fill,h_300,w_300,limit_0,image/format,jpg"
      ],
      "video": "",
      "comments": {
        "total": "",
        "commentlist": [
          {
            // artist:"",
            // commentId:"",
            // content:"",
            // faceUrl:"",
            // gender:"",
            // isRepay:1,
            // is_like:0,
            // likes:"",
            // nickname:"",
            // repayContent:"",
            // repayTime:"",
            // repayer:"",
            // time:""
        }]
      },
      "related": [{
        "id": "",
        "title": "",
        "excerpt": "",
        "like_count": "",
        "is_like": 0,
        "images": [
        ],
        "video": ""
      }],
      "shareInfo": {
        "shareTitle": "",
        "shareDesc": "",
        "shareImg": "",
        "shareLink": ""
      }
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
    aDInfo: {
      isShow: true,
      height: '1.333333rem'
    },
    H5TopInfo: [],
    alinkid:[],
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
    // this.userInfo = {
    //   face: userFace,
    //   nickname: userNickname
    // };

    this.init();
    // this.getH5TopInfo();

  },
  mounted: function() {


    noZoom();
    if (FastClick) {
      FastClick.attach(document.body);
    }
  },
  beforeUpdate:function(){
    this.$nextTick(function(){
      var alint = document.querySelectorAll('.abc');
      var aids = [];
      for (var adx = 0; adx<alint.length; adx++){
        aids.push(alint[adx].getAttribute('data-artzhe-id'));
      }
      this.alinkid = aids;
      if(this.alinkid.length>0){
        this.checklikeandnews(this.alinkid)
      }
      console.log(this.alinkid)
      if(!this.checkUA1().isAPP){//移动端显示 查看详情 测试
        var allatag = document.querySelectorAll('.abc');
        for(var i=0;i<allatag.length;i++){
          document.querySelectorAll('.abc')[i].href='https://a.app.qq.com/o/simple.jsp?pkgname=com.artzhe'
        }

      }
    })
  },
  // methods
  methods: {
    init: function() {
      var that = this;
      this.articleId = GetLocationId() || '';
      var data = {
        id: this.articleId
      };
      // artzheAgent.call20('Artwork/updateDetail', data, function(res) {
      artzheAgent.call44('article/getdetailH5', data, function(res) {

        // console.log('获取艺术号详情.res', res);
        that.isLoading = false;
        if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
          // getToken(that.init);
          // window.location.href = "/wechat/login";  //暂时屏蔽
        } else if (res.code == '30000') {

          document.title = res.data.info.title;
          var update = res.data.info;
          if (update.is_like == "1") {
            that.isLike = true;
          } else {
            that.isLike = false;
          }
          // if (res.data.info.userinfo.isFollow == "Y") {
          //   that.isFollow = true;
          // } else {
          //   that.isFollow = false;
          // }
          if (update.comments.commentlist.length > 2) {
            update.comments.commentlist = update.comments.commentlist.slice(0, 2);
          }
          if (update.like_users.length > 6) {
            update.like_users = update.like_users.slice(0, 6);
          }

          // test 2019.01.05
          // 去除img的行内style的important，使其自适应宽高
          update.content = update.content.replace(/!important/g,''); //

          update.content = px2rem(update.content);
          var reg = new RegExp("<p><br/></p>","g"); //去除自定义样式插入的空白标签<p><br/></p>
          update.content = update.content.replace(reg,'');

          //图片懒加载
          var el = document.createElement('div');
          el.innerHTML = update.content;

          var $el = $(el);
          var imgs = $el.find('img');

          imgNum = $("img").length,

            imgs.each(function() {
              var that = $(this);
              var src = $(this).attr("src");
              $(this).attr("data-src", src);
              $(this).attr('src', '/Public/image/holder.png');
            });

          update.content = el.innerHTML;

          that.update = update;

          var shareInfo = update.shareInfo;

          wx.ready(function(){
            wx.onMenuShareTimeline({
              title: shareInfo.shareTitle,
              link: shareInfo.shareLink,
              imgUrl: shareInfo.shareImg
            });
            wx.onMenuShareAppMessage({
              title: shareInfo.shareTitle,
              desc: shareInfo.shareDesc,
              link: shareInfo.shareLink,
              imgUrl: shareInfo.shareImg,
              type: 'link',
              dataUrl: ''
            });
          });

          //设置广告位信息
          that.newGetH5AD(that.update.userinfo);
        }
        that.$nextTick(function() {
          that.setImgStyle($('.view img'));
          that.showImgList();
          that.lazyload();
          document.addEventListener('touchmove', that.lazyload, false);
          document.addEventListener('scroll', that.lazyload, false);
          document.addEventListener('wheel', that.lazyload, false);

          // 兼容iOS webview _blank无法打开a链接
          if (checkUA().isIOS) {
            $("a").attr("target","_self");
          }

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
    lazyload: function() {
      var imgs = $('#content').find('img');
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
    setImgStyle: function ($imgList) {
      $imgList.each(function() {
        var that = $(this);
        var src = $(this).attr("data-src");
        getImageWidth(src,function(w,h){
          if (w <= 64) {
            that.css({width:48,height:48,display:'inline-block'});
          }
        });
      });
    },
    showShare: function() {
      this.boxIsShow = true;
      this.shareIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.shareIsShow = false;
      this.downloadIsShow = false; //下载新增代码
    },
    toggleFollow: function(msg) {
      this.boxMsg = msg;
      this.boxIsShow = true;
      this.downloadIsShow = true;
      return false; //下载新增代码

      var that = this;
      var data = {
        artistId: this.artistid
      };
      if (this.followClick) {
        return false;
      }
      this.followClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass('anim-zooming');
      }); //放大缩小动画效果

      if (this.isFollow) {
        artzheAgent.call('Gallery/unfollow', data, function(res) {
          that.followClick = false;
          // console.log('unFollow.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isFollow = false;
              that.update.userinfo.follower_total--;
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
              that.update.userinfo.follower_total++;
            }
          }
        });
      }
    },
    toggleLike: function(msg) {
      this.boxMsg = msg;
      this.boxIsShow = true;
      this.downloadIsShow = true;
      return false; //下载新增代码

      var that = this;
      var data = {
        id: this.articleId,
        // type: 2
      };
      if (this.likeClick) {
        return false;
      }
      this.likeClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass('anim-zooming');
      }); //放大缩小动画效果

      if (this.isLike) {
        artzheAgent.call20('article/unlike', data, function(res) {
          that.likeClick = false;
          console.log('cancelLike.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.isLike = false;
              var arrLikes = [];
              for (var i = 0; i < that.update.like_users.length; i++) {
                if (that.update.like_users[i].indexOf(res.data.faceUrl) === -1) {
                  arrlike_users.push(that.update.like_users[i]);
                }
              }
              that.update.like_users = arrLikes;
              that.update.like_count--;
            }
          }
        });
      } else {
        artzheAgent.call20('article/like', data, function(res) {
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

              if (that.update.like_users.length > 0 && that.update.like_users[0].indexOf(res.data.faceUrl) !== -1) {
                that.update.like_users.unshift(res.data.faceUrl);
              } else if (that.update.like_users.length > 5) {
                that.update.like_users.pop();
                that.update.like_users.unshift(res.data.faceUrl);
              } else {
                that.update.like_users.unshift(res.data.faceUrl);
              }
              that.update.like_count++;
            }
          }
        });
      }
    },
    toggleZan: function(id, is_like) {
      this.boxMsg = "下载艺术者APP即可点赞~";
      this.boxIsShow = true;
      this.downloadIsShow = true;
      return false; //屏蔽点赞功能
      var that = this;
      var data = {
        commentId: id
      };

      if (this.zanClick) {
        return false;
      }
      this.zanClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass('anim-zooming');
      }); //放大缩小动画效果

      if (is_like == '1') {
        artzheAgent.call20('ArticleComment/unzan', data, function(res) {
          console.log(res);
          that.zanClick = false;
          console.log('unFollow.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.update.comments.commentlist.forEach(function(item) {
                if (item.commentId == id) {
                  // Vue.set(item, "unfollow", true);
                  item.is_like = '0';
                  item.likes--;
                }
              });
            }
          }
        });
      } else {
        artzheAgent.call20('ArticleComment/zan', data, function(res) {
          that.zanClick = false;
          console.log('follow.res', res);
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            window.location.href = "/wechat/login";
          } else if (res.code == '30000') {
            if (res.data.status == 1000) {
              that.update.comments.commentlist.forEach(function(item) {
                if (item.commentId == id) {
                  // Vue.set(item, "unfollow", true);
                  item.is_like = '1';
                  item.likes++;
                }
              });
            }
          }
        });
      }
    },
    commentUpdate: function(msg) {
      this.boxMsg = msg;
      this.boxIsShow = true;
      this.downloadIsShow = true;
      return false; //下载新增代码

      var that = this;
      var data = {
        artId: this.articleId,
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
            that.update.comments.commentlist.unshift(commentItem);
          }
        }
        that.commentSubmit = false;
      });
    },
    showImgList: function() {
      var that = this;
      var $imgList = $('#content img');
      $imgList.click(function(event) { //绑定图片点击事件
        var index = $imgList.index(this);
        var imgList = that.update.images;
        var thisImg = that.update.images[index];
        if ($(this).parent()[0].tagName !== 'A') {
          wx.ready(function() {
            wx.previewImage({
              current: thisImg, // 当前显示图片的http链接
              urls: imgList // 需要预览的图片http链接列表
            });
          });
        }
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
    newGetH5AD: function(shareInfo) {
      var that = this;
      var info = shareInfo;
      var H5TopInfo = {};

      H5TopInfo.img = info.faceUrl;
      H5TopInfo.title = info.nickname;
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
    },
    checkUA1: function() { //浏览器ua判断
      var isIOS, isAndroid, isWeChat, isAPP;
      var ua = navigator.userAgent.toLowerCase();
      if (/iphone|ipad|ipod/.test(ua)) {
        isIOS = true;
        isAndroid = false;
      } else if (/android/.test(ua)) {
        isIOS = false;
        isAndroid = true;
      }
      if (/micromessenger/.test(ua)) {
        isWeChat = true;
      }
      if (/artzhe/.test(ua)) {
        isAPP = true;
      }
      return {
        isIOS: isIOS,
        isAndroid: isAndroid,
        isWeChat: isWeChat,
        isAPP: isAPP
      }
    },
    checklikeandnews: function(ids){ //更新喜欢，留言数量
      var self = this;
      var data = {
        art_circle_ids:ids.toString()
      }
      artzheAgent.call43('MobileGetH5/ArtCircleStatisticalData',data,function(res){
        if(res.code == 30000){
          var at=0;
          $.each(res.data.info,function(index,value){
            document.querySelectorAll('.smalltrp')[at].children[0].innerHTML=value.like_total;
            document.querySelectorAll('.smalltrp')[at].children[1].innerHTML=value.comment_total;
            at++;
          })
        }
      })
    }
  },
  // components: {
  //   VueLazyload: VueLazyload
  // }
});
