Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var apiHttp = window.location.origin + '/V2/';

function getRequest() {
  var url = location.search; //获取url中"?"符后的字串
  url = decodeURI(url);
  var theRequest = {};
  if (url.indexOf("?") != -1) {
    var str = url.substr(1);
    strs = str.split("&");
    for (var i = 0; i < strs.length; i++) {
      theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
    }
  }
  return theRequest;
}

var vmApp = new Vue({
  // element to mount to
  el: '#app',
  // initial data
  data: {
    isLoading: true,
    artistId: '',
    imageList: [ //图片列表
    ],
    progress: '0%',
    curIndex: '0',
    // selectedIds: [],
    // 分享弹窗
    friendList: [
      // {
      //   nickname: '李坤',
      //   faceimg: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_180,w_180',
      //   remark: '灵魂伴侣',
      //   percent: '100',
      //   color: '#efc543'
      // }, {
      //   nickname: '李坤2',
      //   faceimg: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_180,w_180',
      //   remark: '灵魂伴侣',
      //   percent: '80',
      //   color: '#f89aa9'
      // }
    ],
    total: 0, //好友总数
    shareIsShow: false,
    boxIsShow: false,
    introIsShow: true, //活动介绍
    resultIsShow: false, //活动结果
    shenmeiIsShow: false, //活动测试
    hasHecheng: false,
    clicked: 1,
    userInfo: {
      uid: '',
      nickname: '',
      face: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_100,w_100'
    },
    loadProgress: 10,
    resultImg: '/Public/image/activity/holder.png',
    isflag: 0, //0表示未测试过  1表示有测试过
    isSubmit: false
  },
  beforeCreate: function() {
    var that = this;

    // 初始化进度
    // var timer = window.setInterval(function() { // 设置定时器
    //   if (that.loadProgress >= 90) {
    //     window.clearInterval(timer);
    //     that.loadProgress = 90;
    //   } else {
    //     that.loadProgress++;
    //   }
    // }, 100);
    // window.onload = function(argument) {
    //   that.loadProgress = 100;
    //   setTimeout(function(argument) {
    //     that.isLoading = false;
    //   }, 300);
    // };
  },
  created: function() {
    var that = this;
    this.resultImg = getRequest().imgurl;
    this.userInfo.uid = getRequest().uid;
    this.userInfo.nickname = getRequest().nickname;
    this.isflag = getRequest().isflag ? getRequest().isflag : 0;

    // this.isLoading = false;
    if (this.isflag == 1) {
      this.introIsShow = false;
      this.shenmeiIsShow = false;
      this.resultIsShow = true;
    } else if (this.isflag == 0) {
      this.introIsShow = true;
    }
    // 分享设置
    var link, title, imgUrl, desc;
    if (this.resultIsShow == true) {
      link = window.location.origin + '/activity/result?uid=' + that.userInfo.uid + '&nickname=' + encodeURI(that.userInfo.nickname);
      title = that.userInfo.nickname + '的审美性格竟然是这样，你的呢？';
      imgUrl = window.location.origin + '/Public/image/activity/shareicon.png?v=1.0.1';
      desc = '根据你的审美测性格，还可以看你和' + that.userInfo.nickname + '的审美性格契合度';
    } else {
      link = window.location.origin + '/activity/index';
      title = '一个超准的审美性格测试';
      imgUrl = window.location.origin + '/Public/image/activity/shareicon.png?v=1.0.1';
      desc = '根据你的审美测性格，还可看和好友的审美性格契合度。';
    }

    wx.ready(function() {
      wx.onMenuShareTimeline({
        title: title,
        link: link,
        imgUrl: imgUrl
      });
      wx.onMenuShareAppMessage({
        title: title,
        desc: desc,
        link: link,
        imgUrl: imgUrl,
        type: 'link',
        dataUrl: ''
      });
    });

    this.init();
  },
  mounted: function() {

  },
  // methods
  methods: {
    init: function() {
      var that = this;
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: apiHttp + 'Active/getNextImages', //获取图片及测试结果
        data: {},
        dataType: "json",
        success: function(res) {
          console.log(res);
          if (res.code == 3000) {
            that.imageList = res.data;
          }
        }
      });
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: apiHttp + 'Active/getFriendsResult',
        data: {
          uid: getRequest().uid
        },
        dataType: "json",
        success: function(res) {
          console.log(res);
          if (res.code == 3000) {
            that.friendList = res.data;
            that.total = res.data.length;
          }
        }
      });

    },
    gotoShenmei: function() {
      this.introIsShow = false;
      this.shenmeiIsShow = true;
      this.$nextTick(function() {
        // DOM 现在更新了
        // `this` 绑定到当前实例
        this.swpierAndLoad();
      });

    },
    // 轮播切换及加载
    swpierAndLoad: function() {
      var that = this;
      mySwiperH = new Swiper("#swiper-container-h", {
        slidesPerView: "auto",
        centeredSlides: !0,
        onlyExternal: true, //slide无法拖动，只能使用扩展API函数例如slideNext() 或slidePrev()或slideTo()等改变slides滑动。
        observer: true, //修改swiper自己或子元素时，自动初始化swiper
        observeParents: true //修改swiper的父元素时，自动初始化swiper
      });
    },
    showShare: function() {
      this.boxIsShow = true;
      this.shareIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.shareIsShow = false;
    },
    addActiveAndNum: function(id, index, tagids) {
      var that = this;
      var nextIndex = index + 1;
      // this.selectedIds.push(tagids);
      // this.selectedIds = this.uniqueArr(this.selectedIds);
      mySwiperH.slideTo(nextIndex, 500, true);
      this.progress = nextIndex * 100 / 5 + '%';
      this.curIndex = nextIndex;
      this.$nextTick(function() {
        this.imageList.forEach(function(list) {
          list.forEach(function(item) {
            if (item.id == id) {
              Vue.set(item, 'active', true);
            } else {
              Vue.set(item, 'active', false);
            }
          });
        });
      });
      if (this.curIndex == 5) {
        if (that.isSubmit == true) {
          return false;
        }
        that.isSubmit = true;
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: apiHttp + 'Active/isFinished', //测试完毕
          data: {
            uid: that.userInfo.uid
          },
          dataType: "json",
          success: function(res) {
            console.log(res);
            if (res.code == 3000) {
              that.shenmeiIsShow = false;
              setTimeout(function() {
                that.resultIsShow = true;
                that.isSubmit = false;

                // 分享设置
                var link = window.location.origin + '/activity/result?uid=' + that.userInfo.uid + '&nickname=' + encodeURI(that.userInfo.nickname);
                var title = that.userInfo.nickname + '的审美性格竟然是这样，你的呢？';
                var imgUrl = window.location.origin + '/Public/image/activity/shareicon.png?v=1.0.1';
                var desc = '根据你的审美测性格，还可以看你和' + that.userInfo.nickname + '的审美性格契合度';
                wx.ready(function() {
                  wx.onMenuShareTimeline({
                    title: title,
                    link: link,
                    imgUrl: imgUrl
                  });
                  wx.onMenuShareAppMessage({
                    title: title,
                    desc: desc,
                    link: link,
                    imgUrl: imgUrl,
                    type: 'link',
                    dataUrl: ''
                  });
                });
              }, 10); //延时防止误点击
            } else {
              that.isSubmit = false;
            }
          }
        });
      }
    },
    uniqueArr: function(array) {
      var n = []; //一个新的临时数组 
      //遍历当前数组 
      for (var i = 0; i < array.length; i++) {
        //如果当前数组的第i已经保存进了临时数组，那么跳过， 
        //否则把当前项push到临时数组里面 
        if (n.indexOf(array[i]) == -1) {
          n.push(array[i]);
        }
      }
      return n;
    }
  },
  components: {
    VueLazyload
  }
});