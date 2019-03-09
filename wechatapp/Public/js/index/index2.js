Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

(function($) {
  HCarousel = function(opts) {
    var defaultOpts = {
      $wrap: $('body'),
      current: 0,
      autoPlay: true,
      interval: 5000
    };
    this.opts = $.extend(defaultOpts, opts);
    this.init(opts);
  };
  HCarousel.prototype = {
    init: function() {
      this.attachEl();

      this.switchItem(this.opts.current);

      this.bind();

      if (this.opts.autoPlay) {
        this.autoPlay();
      }
    },
    attachEl: function() {
      var data = this.opts.data;
      this.$carousel = $('.carousel');
      this.$imgList = $('.carousel .img-list');
      this.$switchList = $('.carousel .switch-list');

      if ($('.carousel .img-info').length > 0) {
        this.$imgInfoList = $('.carousel .img-info');
        this.$imgInfoItems = this.$imgInfoList.find('li');
      }

      this.$imgItems = this.$carousel.find('.img-item');
      this.$switchItems = this.$carousel.find('.switch-item');
      this.listLength = this.$imgItems.length;

      this.$mainImgItem = null;
    },
    bind: function() {
      var me = this;
      this.$imgList.on('click', '.img-item', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var isMainImgItem = $(this).hasClass('main-img-item');
        if (isMainImgItem) {
          window.location = $(e.target).parent().attr('href');
        } else {
          var index = $(e.target).parent().index();
          me.switchItem(index);
        }
      });
      this.$switchList.on('mouseover', '.switch-item', function(e) {
        e.stopPropagation();
        var index = $(e.target).index();
        me.switchItem(index);
      });
      if (this.opts.autoPlay) {
        this.$imgList.hover(function() {
          me.stopAutoPlay();
        }, function() {
          me.autoPlay();
        });
      }
    },
    switchItem: function(index) {
      if (this.$mainImgItem) {
        this.clearStyle();
      }
      this.mainIndex = index;
      this.$mainImgItem = this.$imgItems.eq(index);
      this.$mainSwitchItem = this.$switchItems.eq(index);

      this.$mainImgInfoItem = this.$imgInfoItems.eq(index);  //新增

      if (index === 0) {
        this.$prevImgItem = this.$imgItems.eq(this.listLength - 1);
        this.$leftImgItem = this.$imgItems.eq(this.listLength - 2);
      } else if (index === 1) {
        this.$prevImgItem = this.$imgItems.eq(index - 1);
        this.$leftImgItem = this.$imgItems.eq(this.listLength - 1);
      } else if (index > 1) {
        this.$prevImgItem = this.$imgItems.eq(index - 1);
        this.$leftImgItem = this.$imgItems.eq(index - 2);
      }

      if (index === this.listLength - 1) {
        this.$nextImgItem = this.$imgItems.eq(0);
        this.$rightImgItem = this.$imgItems.eq(1);
      } else if (index === this.listLength - 2) {
        this.$nextImgItem = this.$imgItems.eq(index + 1);
        this.$rightImgItem = this.$imgItems.eq(0);
      } else if (index < this.listLength - 2) {
        this.$nextImgItem = this.$imgItems.eq(index + 1);
        this.$rightImgItem = this.$imgItems.eq(index + 2);
      }
      this.addStyle();
    },
    autoPlay: function() {
      var me = this;

      this.timeId = setInterval(function() {
        me.mainIndex++;
        if (me.mainIndex === me.listLength) {
          me.mainIndex = 0;
        }
        me.switchItem(me.mainIndex);
      }, this.opts.interval);
    },
    stopAutoPlay: function() {
      clearInterval(this.timeId);
    },
    addStyle: function() {
      this.$mainImgItem.addClass('main-img-item');
      this.$nextImgItem.addClass('next-img-item');
      this.$prevImgItem.addClass('prev-img-item');
      this.$leftImgItem.addClass('left-img-item');
      this.$rightImgItem.addClass('right-img-item');
      this.$mainSwitchItem.addClass('switch-item-active');

      this.$mainImgInfoItem.addClass('img-info-active'); //新增

    },
    clearStyle: function() {
      this.$mainImgItem.removeClass('main-img-item');
      this.$nextImgItem.removeClass('next-img-item');
      this.$prevImgItem.removeClass('prev-img-item');
      this.$leftImgItem.removeClass('left-img-item');
      this.$rightImgItem.removeClass('right-img-item');
      this.$mainSwitchItem.removeClass('switch-item-active');

      this.$mainImgInfoItem.removeClass('img-info-active'); //新增

    }
  };
})(jQuery);

var vmApp = new Vue({
  el: '#app',
  data: {
    boxIsShow: false,
    isRemember: true,
    compress: compress, //图片压缩后缀
    dakaList: [
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka0.jpg',title:'艺术者创始人',name:'韩宇宙',desc:'在谈到创立「艺术者」平台的初衷时，韩宇宙说，尽管如今已经到了「知识付费」和「消费升级」的热潮期，但就整体而言，互联网仍然缺乏优质内容的供应。从一副手绘作品的创作上来讲，人们对于历史名画的认识往往停留在静态画面上，并不了解其背后的创作历程。而「艺术者」要做的就是把一幅艺术作品的创作过程真实、完整地呈现给用户，让人们在欣赏和购买这些艺术作品的同时，也能与艺术家近距离互动。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka1.jpg',title:'迅雷创始人',name:'程浩',desc:'而迅雷创始人程浩更表示，任何资讯都会过时，但艺术越久远越有意义，自己和韩宇宙先生是多年的好友，相信「艺术者」平台一定能激发青年艺术家更多的创作动力和才华。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka2.jpg',title:'高搜易集团创始人',name:'陈康',desc:'随着国内消费升级不断深入，人们对于消费品的追逐从轻奢品逐步转向文创用品。近两年来，国内市场出现了一大批文化IP，领域涵盖了艺术、文具、服装、图书等方方面面，反映出国人对于文化产品的消费能力持续上扬。艺术者的诞生既满足了艺术创作者连接粉丝的需要，也满足了艺术爱好者看画、买画乃至参与创作的愿望。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka3.jpg',title:'糗事百科创始人',name:'王坚',desc:'艺术者也吸引了糗事百科创始人王坚的关注。王坚说，互联网的发展为内容创造者提供了更方便、更多元化的作品变现渠道，「艺术者」就是一个很合适的平台，在这里，艺术家不仅可以展示和曝光自己的作品，还有机会遇见真正的知音，找到那群愿意「为艺术埋单」的人。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka4.jpg',title:'微位科技CBO',name:'陈俊澄',desc:'从事美术、设计创作十余年，曾参与制作多款人气游戏并成立了科创锐动产业基金的微位科技 CBO 陈俊澄对于「艺术者」平台也有着自己的见解。<br>陈俊澄认为一直以来，艺术家们的作品能否被观众看到很大程度上取决于展会和画廊能否提供机会。而「艺术者」作为一个互联网平台，将艺术创作者和广大受众拉进了同一个平面。艺术家不仅可以展示自己的创作，还能直接获得反馈。陈俊澄相信，在「艺术者」平台上一定会诞生一批「艺术家网红」，更多的青年艺术家也将因为「艺术者」而获得更多曝光个人作品的机会。'}
    ],
    loginBoxShow: false,
    loginInfo: {
      loginActive: true,
      wechatActive: false,
    },
    form: {
      mobile: '',
      password: '',
      verifyCode: '',
      from: 'pc'
    },
    busy: false, //数据懒加载开关
    websiteConfig: { //网站配置信息
      images: [],
      authors: [],
      news: []
    },
    recordInfo: {
      data: [], //首页创作纪录列表
      page: 0
    },
    artistList: [], //最新加入的艺术家列表
    bottomLoginShow: false, //底部登录框是否显示
    bottomDownloadShow: false, //底部下载框是否显示
    userInfo: {},
  },
  created: function() {
    this.getConfig();
    this.getRecord();
    this.getArtist();
  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.userInfo = info;
    }.bind(this));
  },
  methods: {
    getConfig: function () {
      var that = this;
      var api = '/Api/WebsiteConfig/getWebConfig';
      var data = {
        
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            resInfo.news.forEach(function (item) {
              if (item.type == 1) {
                item.href = '/news/detail/' + item.id;
              } else if (item.type == 2) {
                item.href = item.url;
              }
            });
            that.websiteConfig = resInfo;
          }
          that.$nextTick(function () {
            new HCarousel({
              $wrap: $('.banner .lunbo'),
              current: 0,
              autoPlay: true,
              interval: 5000
            });
            var mySwiperH = new Swiper("#swiper-container-1", {
              loop: true,
              autoplay: 5000,
              speed:1000,
              slidesPerView: "auto",
              pagination : '#swiper-pagination-1',
              paginationClickable: true,
              centeredSlides: !0,
              observer:true,         //修改swiper自己或子元素时，自动初始化swiper
              observeParents:true,   //修改swiper的父元素时，自动初始化swiper
            });
            new StickUpAll('.stick-wrap');
          });
        }
      });
    },
    getRecord: function () {
      //超过50条强制退出
      if (this.recordInfo.page >= 5) return false;

      this.busy = true;
      var that = this;
      var api = '/Api/Home/getRecord/';
      var data = {
        page: ++this.recordInfo.page,
        pagesize: 10
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            // resInfo.data.forEach(function (currentValue) {
            //   currentValue.imgname = checkMark(currentValue.imgname);
            // });
            if (resInfo.page == 1) {
              that.recordInfo = resInfo;
            } else if (resInfo.page > 1) {
              that.recordInfo.data = that.recordInfo.data.concat(resInfo.data);
            }
          }
        },
        complete: function (res) {
          that.$nextTick(function () {
            //根据是否登录，选择加载30条 or 50 条
            if (that.userInfo.artist) {
              if (that.recordInfo.page < 5) {
                that.busy = false;
              } else {
                that.bottomDownloadShow = true;
              }
            } else {
              if (that.recordInfo.page < 3) {
                that.busy = false;
              } else {
                that.bottomLoginShow = true;
              }
            } 
          });
        }
      });
    },
    getArtist: function () {
      var that = this;
      var api = '/Api/Home/getArtist';
      var data = {
        size: 9
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            that.artistList = res.data.info;
          }
        }
      });
    },
    showReg: function () {
      eventBus.$emit('showLogin', 'login', 'reg');
    },
    showLogin: function (argument) {
      eventBus.$emit('showLogin', 'login', 'login');
    }
  }
});