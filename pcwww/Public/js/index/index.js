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
    isLogin:false, //是否登陆
    boxIsShow: true,
    isRemember: true,
    swiper1: [
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/shigaoqing.jpg',name: '石高青',desc: '绘画对于我来说就是我的灵魂，把我内心的触感说出来。自然界中的各种生灵，他们的神秘，优雅，忧郁的或潜藏开心的，在我的画笔下似人非人，似物非物，如果语言是认知的边界，或许绘画能带我多走两步。哪怕只有一步，足以成为坚持如初的热爱。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/zhouxun.jpg',name: '周迅',desc: '艺术之所以为艺术就在于每个人解读和表达方式不同，如果图画能让观者心中产生共鸣，那这幅画就是有生命的。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/zhukeran.jpg',name: '朱可染',desc: '我喜欢画面特别简单，我个人的思考是事物越简单就越接近本质，‘一花一世界，一叶一菩提’，我想把微小的东西做到极致就行了。'}
    ],
    dakaList: [
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka0.jpg',title:'艺术者创始人',name:'韩宇宙',desc:'在谈到创立「艺术者」平台的初衷时，韩宇宙说，尽管如今已经到了「知识付费」和「消费升级」的热潮期，但就整体而言，互联网仍然缺乏优质内容的供应。从一副手绘作品的创作上来讲，人们对于历史名画的认识往往停留在静态画面上，并不了解其背后的创作历程。而「艺术者」要做的就是把一幅艺术作品的创作过程真实、完整地呈现给用户，让人们在欣赏和购买这些艺术作品的同时，也能与艺术家近距离互动。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka1.jpg',title:'迅雷创始人',name:'程浩',desc:'而迅雷创始人程浩更表示，任何资讯都会过时，但艺术越久远越有意义，自己和韩宇宙先生是多年的好友，相信「艺术者」平台一定能激发青年艺术家更多的创作动力和才华。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka2.jpg',title:'高搜易集团创始人',name:'陈康',desc:'随着国内消费升级不断深入，人们对于消费品的追逐从轻奢品逐步转向文创用品。近两年来，国内市场出现了一大批文化IP，领域涵盖了艺术、文具、服装、图书等方方面面，反映出国人对于文化产品的消费能力持续上扬。艺术者的诞生既满足了艺术创作者连接粉丝的需要，也满足了艺术爱好者看画、买画乃至参与创作的愿望。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka3.jpg',title:'糗事百科创始人',name:'王坚',desc:'艺术者也吸引了糗事百科创始人王坚的关注。王坚说，互联网的发展为内容创造者提供了更方便、更多元化的作品变现渠道，「艺术者」就是一个很合适的平台，在这里，艺术家不仅可以展示和曝光自己的作品，还有机会遇见真正的知音，找到那群愿意「为艺术埋单」的人。'},
      {img:'//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/index/daka4.jpg',title:'微位科技CBO',name:'陈俊澄',desc:'从事美术、设计创作十余年，曾参与制作多款人气游戏并成立了科创锐动产业基金的微位科技 CBO 陈俊澄对于「艺术者」平台也有着自己的见解。<br>陈俊澄认为一直以来，艺术家们的作品能否被观众看到很大程度上取决于展会和画廊能否提供机会。而「艺术者」作为一个互联网平台，将艺术创作者和广大受众拉进了同一个平面。艺术家不仅可以展示自己的创作，还能直接获得反馈。陈俊澄相信，在「艺术者」平台上一定会诞生一批「艺术家网红」，更多的青年艺术家也将因为「艺术者」而获得更多曝光个人作品的机会。'}
    ]
  },
  created: function() {

  },
  mounted: function() {
    new HCarousel({
      $wrap: $('.banner .lunbo'),
      current: 0,
      autoPlay: true,
      interval: 5000
    });
  },
  methods: {
    hideBox: function () {
      this.boxIsShow = false;
    },
    toggleRemember: function () {
      this.isRemember = !this.isRemember;
    }
  }
});