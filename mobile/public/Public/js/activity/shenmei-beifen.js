Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmGalleryDetail = new Vue({
  // element to mount to
  el: '#app',
  // initial data
  data: {
    isLoading: true,
    artistId: '',
    imageList: [
      [{
        arturl: '/Public/image/activity/demo1.png',
        id: '1',
        tagids: '1,5',
        artname: ''
      }, {
        arturl: '/Public/image/activity/demo2.jpg',
        id: '2',
        tagids: '2,10',
        artname: ''
      }, ],
      [{
        arturl: '/Public/image/activity/demo1.png',
        id: '3',
        tagids: '3,6',
        artname: ''
      }, {
        arturl: '/Public/image/activity/demo2.jpg',
        id: '4',
        tagids: '4,8',
        artname: ''
      }, ],
      [{
        arturl: '/Public/image/activity/demo1.png',
        id: '5',
        tagids: '1,6',
        artname: ''
      }, {
        arturl: '/Public/image/activity/demo2.jpg',
        id: '6',
        tagids: '3,9',
        artname: ''
      }, ],
      [{
        arturl: '/Public/image/activity/demo1.png',
        id: '7',
        tagids: '4,8',
        artname: ''
      }, {
        arturl: '/Public/image/activity/demo2.jpg',
        id: '8',
        tagids: '9,11',
        artname: ''
      }, ],
      [{
        arturl: '/Public/image/activity/demo1.png',
        id: '9',
        tagids: '5,12',
        artname: ''
      }, {
        arturl: '/Public/image/activity/demo2.jpg',
        id: '10',
        tagids: '6,18',
        artname: ''
      }, ]
    ],
    progress: '0%',
    curIndex: '0',
    selectedIds: [],
    friendList: [{
      name: '李坤',
      avatar: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_180,w_180',
      title: '灵魂伴侣',
      precent: '100%',
      color: '#efc543'
    }, {
      name: '李坤2',
      avatar: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_180,w_180',
      title: '灵魂伴侣',
      precent: '80%',
      color: '#f89aa9'
    }, ],
    // 分享弹窗
    shareIsShow: false,
    boxIsShow: false,
    resultIsShow: false,
    shenmeiIsShow: true,
    hasHecheng: false,
    clicked: 1,
    userInfo: {
      nickname: '',
      face: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_100,w_100'
    }

  },
  created: function() {
    this.init();
  },
  mounted: function() {
    this.swpierAndLoad();
  },
  // methods
  methods: {
    init: function() {
      var that = this;
      artzheAgent.call2('Active/getNextImages', {}, function (res) {
        console.log(res);
        if (res.code == 3000) {
          that.imageList = res.data;
        }
      });
      // var img = this.userInfo.face;//imgurl 就是你的图片路径  

      // function getBase64Image(img) {  
      //      var canvas = document.createElement("canvas");  
      //      canvas.width = img.width;  
      //      canvas.height = img.height;  
      //      var ctx = canvas.getContext("2d");  
      //      ctx.drawImage(img, 0, 0, img.width, img.height);  
      //      var ext = img.src.substring(img.src.lastIndexOf(".")+1).toLowerCase();  
      //      var dataURL = canvas.toDataURL("image/"+ext);  
      //      return dataURL;  
      // }  

      // var image = new Image();  
      // image.src = img;  
      // image.onload = function(){  
      //   var base64 = getBase64Image(image);
      //   that.userInfo.face = base64;  
      //   console.log(base64);  
      // }

      $.ajax({


      });
      var link = window.location.origin + '/activity/result?uid=asdasgagsakjhksef';

      wx.ready(function(){
        wx.onMenuShareTimeline({
          title: '艺术画廊',
          link: link,
          imgUrl: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_180,w_180'
        });
        wx.onMenuShareAppMessage({
          title: '艺术画廊',
          desc: 'lalallalalalallalallallalla',
          link: link,
          imgUrl: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_180,w_180',
          type: 'link',
          dataUrl: ''
        });
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
    hecheng: function() {
      $(".cover").show();
        if (this.clicked == 1) {
          var div = $(".cover");
          var w = div.width();
          var h = div.height();
          var canvas = document.createElement("canvas");
          canvas.width = w * 2;
          canvas.height = h * 2;
          canvas.style.width = w + "px";
          canvas.style.height = h + "px";
          var context = canvas.getContext("2d");
          //然后将画布缩放，将图像放大两倍画到画布上
          var cenX = (div.offset().left) * 2;
          var cenY = (div.offset().top) * 2;
          context.translate(-cenX, -cenY);
          context.scale(2, 2);
          html2canvas(div, {
            canvas: canvas,
            onrendered: function(canvas) {
              var image = new Image();
              image.id = "newimg";
              image.crossOrigin = "Anonymous";
              image.src = canvas.toDataURL("image/png");
              div.append(image);
            },
            useCORS:true
          });
          this.clicked = 0;
        }
    },
    addActiveAndNum: function(id, index, tagids) {
      var that = this;
      var nextIndex = index + 1;
      this.selectedIds.push(tagids);
      this.selectedIds = this.uniqueArr(this.selectedIds);
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
        this.shenmeiIsShow = false;
        setTimeout(function() {
          that.resultIsShow = true;
        },300);

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