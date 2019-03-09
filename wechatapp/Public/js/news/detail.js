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
    info:{
      "title": "",//文章标题
      "content": "",//文章内容
      "source_site": "",//采集的网站名字
      "source_time": "",//采集的文章的发布时间
      "view_total": ""//浏览总数
    },
    relateInfo: {
      data:[],
      page: 0
    },
    otherActive: 1, //相关推荐当前是第几页
    
  },
  created: function() {
    // this.getNewsDetail();
    this.getArtworks();
  },
  mounted: function() {
    var that = this;
    var otherArts = new Swiper('.other-wrap .swiper-container', {
      spaceBetween: 25,
      observer:true,         //修改swiper自己或子元素时，自动初始化swiper
      observeParents:true,   //修改swiper的父元素时，自动初始化swiper
      slidesPerView: 4,
      slidesPerGroup : 4,
      onSlideNextEnd: function (swiper) {
        that.otherActive = parseInt(swiper.activeIndex/4 + 1);
      }  
    });
    $('.other-wrap .arrow-right').on('click', function(e){
      e.preventDefault();
      // console.log(otherArts.activeIndex);
      that.otherActive = parseInt(otherArts.activeIndex/4 + 2);
      if (parseInt(otherArts.activeIndex/4 + 1) >= that.relateInfo.page) {
        that.getArtworks(function () {
            that.$nextTick(function () {
              otherArts.slideNext();
            });
        });
      } else if (parseInt(otherArts.activeIndex/4 + 1) < that.relateInfo.page) {
        otherArts.slideNext();
      } 
    });
    $('.other-wrap .arrow-left').on('click', function(e){
      e.preventDefault();
      // console.log(otherArts.activeIndex);
      that.otherActive = parseInt(otherArts.activeIndex/4);
      if (parseInt(otherArts.activeIndex/4 + 1) > 1) {
        otherArts.slidePrev();
      }
    });

    // new StickUpAll('.auth-wrap');
  },
  methods: {
    getNewsDetail: function () {
      var that = this;
      var api = '/Api/Seo/getSeoDetail';
      var data = {
        id: GetLocationId() ? GetLocationId() : -1,
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            that.info = res.data.info;
          }
        }
      });
    },
    getArtworks: function (cb) {
      var that = this;
      var api = '/Api/Artwork/getArtworks';
      var data = {
        page: ++this.relateInfo.page,
        pagesize: 4
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          console.log(res);
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
    }
  }
});