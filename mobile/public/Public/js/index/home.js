var vmApp = new Vue({
  el: '#app',
  data: {
    userid: '',
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace'),
    },
    artistInfo: {
      faceUrl : '',
      name: '',
      motto: ''
    },
    isCheck: true,
    mobile: '',
    isLogin: true,
    isSubmit: false,
    applyStatus: '',
    applyRemark: '',
    userInfo: {
      mobile: '',
      password: ''
    },
    errorTip: '',
    btnText: '登录',
    swiper1: [
      {img:'/Public/image/home/swiper1-1.png',name: '石高青',desc: '绘画对于我来说就是我的灵魂，把我内心的触感说出来。自然界中的各种生灵，他们的神秘，优雅，忧郁的或潜藏开心的，在我的画笔下似人非人，似物非物，如果语言是认知的边界，或许绘画能带我多走两步。哪怕只有一步，足以成为坚持如初的热爱。'},
      {img:'/Public/image/home/swiper1-2.png',name: '周迅',desc: '艺术之所以为艺术就在于每个人解读和表达方式不同，如果图画能让观者心中产生共鸣，那这幅画就是有生命的。'},
      {img:'/Public/image/home/swiper1-3.png',name: '朱可染',desc: '我喜欢画面特别简单，我个人的思考是事物越简单就越接近本质，‘一花一世界，一叶一菩提’，我想把微小的东西做到极致就行了。'}
    ],
    swiper2: [
      {img: '/Public/image/home/swiper2-1.png'},
      {img: '/Public/image/home/swiper2-2.png'},
      {img: '/Public/image/home/swiper2-3.png'}
    ],
    aDInfo: {
      isShow: true,
      height: '1.333333rem'
    },
    H5TopInfo: []
  },
  created: function () {
    this.getH5TopInfo();
  },
  mounted: function () {
    noZoom();
    if (FastClick) {
      FastClick.attach(document.body);
    }
  },
  methods: {
    getH5TopInfo: function () {
      var that = this;
      artzheAgent.call('Ad/getH5Top', {}, function(res) {
        console.log('H5顶部广告位.res', res);
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
      // $.ajax({
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   },
      //   type: "POST",
      //   url: "/api/Ad/getH5Top", //H5顶部广告位
      //   data: {},
      //   success: function(res) {
      //     console.log('H5顶部广告位.res', res);
      //     that.H5TopInfo = res.data.info;
      //     that.$nextTick(function() {
      //       var mySwiperH5 = new Swiper("#swiper-container-t", {
      //         loop: true,
      //         autoplay: 4000,
      //         speed:1000,
      //         slidesPerView: "auto",
      //         pagination : '#swiper-pagination-t',
      //         paginationClickable: true,
      //         centeredSlides: !0,
      //         observer:true,         //修改swiper自己或子元素时，自动初始化swiper
      //         observeParents:true,   //修改swiper的父元素时，自动初始化swiper
      //       });
      //     });
      //   }
      // });
    },
    closeAD: function () {
      this.aDInfo = {
        isShow: false,
        height: '0'
      };
    }
  }
});