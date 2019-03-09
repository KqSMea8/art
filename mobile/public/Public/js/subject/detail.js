Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmSubject = new Vue({
  // element to mount to
  el: '#subject',
  // initial data
  data: {
    data: {
      'subid': GetLocationId()? GetLocationId(): 1,
      'page': 1,
      'pagesize': 100
    },
    info: {

    }
  },
  created: function() {
    this.init();
  },
  mounted: function() {
    noZoom();
    if (FastClick) {
      FastClick.attach(document.body);
    }
  },
  // methods
  methods: {
    init: function() {
      var that = this;

      artzheAgent.call42('Home/getSubjectDetailH5', this.data, function(res) {
        eventBus.$emit('hideLoadingBox');
        if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
          // getToken(that.init);
          // window.location.href = "/wechat/login";  //暂时屏蔽
        } else if (res.code == '30000') {
          document.title = res.data.info.sub_title;
          var info = res.data.info;

          info.description = px2rem(info.description);
          info.data.forEach(function(item) {
            if (item.shape == 1 && item.length) {
              item.tags = item.category + ' ' + item.length + '*' + item.width + 'cm';
            } else if (item.shape == 1 && item.diameter) {
              item.tags = item.category + ' ' + 'D=' + item.diameter + 'cm';
            } else {
              item.tags = item.category;
            }


          });

          //图片懒加载

          var el = document.createElement('div');
          el.innerHTML = info.description;
          var $el = $(el);
          var imgs = $el.find('img');

          imgs.each(function () {
            var src = $(this).attr("src");
            $(this).attr("data-src", src);
            $(this).attr('src', '/Public/image/holder.png');
          });

          info.description = el.innerHTML;
          that.info = info;

          var shareData = {
            title: info.shareInfo.title,
            imgUrl: info.shareInfo.image,
            link: info.shareInfo.link,
            desc: info.shareInfo.title
          };
          that.share(shareData);
        }
        that.$nextTick(function() {
          that.lazyload();
          document.addEventListener('touchmove',that.lazyload, false);
          document.addEventListener('scroll',that.lazyload, false);
          document.addEventListener('wheel',that.lazyload, false);
        });
      });
    },
    lazyload: function () {
      var imgs = $('#wit').find('img');
      var n = 0;
      for (var i = n; i < imgs.length; i++) {
        if (imgs.eq(i).offset().top < parseInt($(window).height()) + parseInt($(window).scrollTop())) {
          if (imgs.eq(i).attr("src") == "/Public/image/holder.png") {
            var src = imgs.eq(i).attr("data-src");
            imgs.eq(i).attr("src", src);
            n = i + 1;
          }
        }
      }
    },
    share: function (data) {
      wx.ready(function(){
        wx.onMenuShareTimeline({
          title: data.title,
          link: data.link,
          imgUrl: data.imgUrl
        });
        wx.onMenuShareAppMessage({
          title: data.title,
          desc: data.desc,
          link: data.link,
          imgUrl: data.imgUrl,
          type: 'link',
          dataUrl: ''
        });
      });
    },
    getImageWidth: function (url,callback){
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
    },
    setImgStyle: function ($imgList) {
      $imgList.each(function() {
        var that = $(this);
        var src = $(this).attr("src");
        getImageWidth(src,function(w,h){
          if (w <= 64) {
            that.css({width:48,height:48,display:'inline-block'});
          }
        });
      });
    },
    showShare: function() {
      eventBus.$emit('showShareBox');
    },
    showImgList: function() {
      // var that = this;
      // var $imgList = $('#wit img');
      // $imgList.click(function(event) { //绑定图片点击事件
      //   var index = $imgList.index(this);
      //   var imgList = that.update.orgImages;
      //   var thisImg = that.update.orgImages[index];
      //   wx.ready(function() {
      //     wx.previewImage({
      //       current: thisImg, // 当前显示图片的http链接
      //       urls: imgList // 需要预览的图片http链接列表
      //     });
      //   });
      // });
    }
  }
});
