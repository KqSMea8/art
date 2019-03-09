// 注册一个空的 Vue 实例，作为 ‘中转站’
var eventBus = new Vue({});

// 子页面页头
Vue.component('ysz-header', {
  template: '<div class="y-header-www">\
        <div class="w clearfix">\
          <div class="y-logo">\
            <a href="/index">\
              <img src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/logo.png">\
            </a>\
          </div>\
          <ul class="head-nav">\
            <li><a :href="wwwDomin + \'/index\'">首页</a></li>\
            <li><a class="cur" href="/">创作中心</a></li>\
            <li><a :href="wwwDomin + \'/arts\'">艺术号</a></li>\
            <li><a :href="wwwDomin + \'/app\'">下载APP</a></li>\
            <li><a :href="wwwDomin + \'/about\'">关于艺术者</a></li>\
          </ul>\
          <div class="fr" style="margin-left:10px;">\
            <change-user-btn></change-user-btn>\
          </div>\
          <div v-if="isChecked" class="login-info">\
            <div v-if="isLogin" class="is-login">\
              <div class="user-info">\
                <a :href="wwwDomin + \'/user/index\'">\
                  <img :src="info.faceUrl" :alt="info.name" class="avatar">\
                </a>\
              </div>\
              <ul class="user-list">\
                <li><a :href="wwwDomin + \'/user/index\'"><i class="icons icon-home"></i>我的资料</a></li>\
                <li><a :href="wwwDomin + \'/user/message\'"><i class="icons icon-message"></i>我的消息<span v-if="info.unreadMessageTotal > 0">{{info.unreadMessageTotal}}</span></a></li>\
                <li><a :href="wwwDomin + \'/user/follow\'"><i class="icons icon-follow"></i>我的关注</a></li>\
                <li><a :href="wwwDomin + \'/user/like\'"><i class="icons icon-like"></i>我的喜欢</a></li>\
                <li v-if="info.isArtist == 1"><a :href="wwwDomin + \'/user/fans\'"><i class="icons icon-fans"></i>我的粉丝</a></li>\
                <li v-if="info.isArtist == 1"><a :href="wwwDomin + \'/user/invite\'"><i class="icons icon-invite"></i>我的邀请</a></li>\
                <li v-if="info.isAgency == 1"><a :href="wwwDomin + \'/user/agency\'"><i class="icons icon-agency"></i>机构特权</a></li>\
                <li v-if="info.isPlanner ==1"><a :href="wwwDomin + \'/user/planer\'"><i class="icons icon-planer"></i>策展人特权</a></li>\
                <li v-if="info.isArtist != 1 && info.isAgency != 1 && info.isPlanner != 1"><a :href="wwwDomin + \'/user/auth\'"><i class="icons icon-auth"></i>申请认证</a></li>\
                <li v-if="info.mall_orders && info.mall_orders.order_all != 0"><a :href ="wwwDomin+ \'/user/orderlist\'"><i class="icons icon-orderlist"></i>我的订单</a></li>\
                <li><a href="/passport/logout"><i class="icons icon-logout"></i>退出</a></li>\
              </ul>\
            </div>\
          </div>\
        </div>\
      </div>\
      ',
  data: function () {
    return {
      wwwDomin: switchDomin('www'),
      info: {

      },
      isChecked: false,
      isLogin: false,
      // compress: compress, //图片压缩后缀
    };
  },
  mounted: function() {
    this.highLightPage();
    this.getUserInfo();
    eventBus.$on('getUserInfo', function() {
      this.getUserInfo();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showReg: function () {
      eventBus.$emit('showLogin', 'login', 'reg');
    },
    showLogin: function (argument) {
      eventBus.$emit('showLogin', 'login', 'login');
    },
    highLightPage: function() {
      var links = $('.y-header .head-nav a');
      for (var i = 0, len = links.length; i < len; i++) {
        var linkURL = links[i].getAttribute('href');
        if (window.location.href.indexOf(linkURL) !== -1) {
          $(links[i]).addClass('cur');
        }
        if (window.location.pathname == '/') {
          $(links[0]).addClass('cur');
        }
      }
    },
    getUserInfo: function () {
      var that = this;
      var api = '/api/UserCenter/getMyGalleryDetail';
      var data = {
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          console.log(res);
          that.isChecked = true;
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            that.info = resInfo;
            that.isLogin = true;
            eventBus.$emit('setUserInfo', resInfo);
          } else if (res.code == '30004' && res.data.status == '1000') { //未登录
            if (window.location.href.indexOf('user') > -1) {
              window.location.href= window.location.origin;
              that.isLogin = false;
            }
          }
        }
      });
    },
    logout: function () {
      var that = this;
      var api = '/Api/User/logout';
      var data = {
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            that.isLogin = false;
            if (window.location.href.indexOf('user') > -1) {
              window.location.href= window.location.origin;
            } else {
              window.location.href= window.location.href;
            }
          }
        }
      });
    }
  }
});

var vmApp = new Vue({
  el: '#app',
  data: {
    // userid: '',
    wwwDomin: switchDomin('www'),
    bottomCodeShow: false,
    identity: {

    },
    myInfo: {
      uid: '',
      name: '',
      face: ''
    },
    userInfo: {
      faceUrl : '',
      name: '',
      motto: ''
    },
    isCheck: true,
    mobile: '',
    isLogin: true,
    isSubmit: false,
    userType: 0,  //1艺术家，2艺术机构，3策展人，-1普通用户，0未登录
    isAuth: '', //有没有申请 Y or N
    enterHref: '', // 进入创作中心的链接 /upload/manage or /article/manage
    authList: [
      {status:'', type:'1',name:'艺术家', memo:'', link0:'/auth/rule',link1:'/auth/first'},
      {status:'', type:'2',name:'艺术机构', memo:'', link0:'/autharts/rule',link1:'/autharts/first'},
      {status:'', type:'3',name:'策展人', memo:'', link0:'/authcurator/rule',link1:'/authcurator/first'}
    ],
    authInfo: {
      name: '', //艺术家、艺术机构、策展人
      remark: '', //后台审核备注信息
      link1: '', //去认证链接：/auth/first
      status: '' //审核状态 0未申请,-1不通过,1审核中,2审核通过
    },
    loginInfo: {
      mobile: '',
      password: '',
      from:'pc'
    },
    errorTip: '',
    btnText: '登录',
    swiper1: [
      {img:'https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/index/artistsaid-0.jpg',name: '石高青',desc: '绘画对于我来说就是我的灵魂，把我内心的触感说出来。自然界中的各种生灵，他们的神秘，优雅，忧郁的或潜藏开心的，在我的画笔下似人非人，似物非物，如果语言是认知的边界，或许绘画能带我多走两步。哪怕只有一步，足以成为坚持如初的热爱。'},
      {img:'https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/index/artistsaid-1.jpg',name: '周迅',desc: '艺术之所以为艺术就在于每个人解读和表达方式不同，如果图画能让观者心中产生共鸣，那这幅画就是有生命的。'},
      {img:'https://artzhe.oss-cn-shenzhen.aliyuncs.com/static/mp/index/artistsaid-2.jpg',name: '朱可染',desc: '我喜欢画面特别简单，我个人的思考是事物越简单就越接近本质，‘一花一世界，一叶一菩提’，我想把微小的东西做到极致就行了。'}
    ],
    swiper2: [
      {img: '/image/index/swiper2-1.png'},
      {img: '/image/index/swiper2-2.png'},
      {img: '/image/index/swiper2-3.png'}
    ]
  },
  created: function () {
    this.checkLogin();
  },
  mounted: function () {
    $(document).on('scroll', function () {
      if ($(document).scrollTop()>500) {
        $('.fix-wrap').show();
      } else {
        $('.fix-wrap').hide();
      }
    });
    // $(".fix-wrap .box").hover(function() {
    //   $(this).find('.code').show();
    // }, function() {
    //   $(this).find('.code').hide();
    // });
    new QRCode(document.getElementById("download-code1"), "https://a.app.qq.com/o/simple.jsp?pkgname=com.artzhe");
    new QRCode(document.getElementById("download-code2"), "https://a.app.qq.com/o/simple.jsp?pkgname=com.artzhe");
    // $('#download-code1').qrcode("https://test-www.artzhe.com/app/download");
    // $('#download-code2').qrcode("https://test-www.artzhe.com/app/download");
  },
  methods: {
    toggleShowCode: function () {
      this.bottomCodeShow = !this.bottomCodeShow;
    },
    checkLogin: function (cb) {
      var that = this;
      artzheAgent.call('UserCenter/getMyGalleryDetail',{},function(res) {
        deleteCookie('userType');
        deleteCookie('userid');
        deleteCookie('userName');
        deleteCookie('userFace');
        deleteCookie('userMobile');
        if (res.code == 30000) {
          var resInfo = res.data.info;
          that.myInfo = {
            uid: res.data.info.artist,
            name: res.data.info.name,
            face: res.data.info.faceUrl
          };
          setCookie('userid', res.data.info.artist);
          setCookie('userName', res.data.info.name);
          setCookie('userFace', res.data.info.faceUrl);
          setCookie('userMobile', res.data.info.mobile);

          that.userInfo = resInfo;
          if(res.data.info.temporary_login==0){
            deleteCookie('temporaryLogin');
          }
          if (res.data.info.isArtist == '1') { //艺术家
            that.userType = 1;
            that.enterHref = '/upload/manage';
          } else if (res.data.info.isAgency == '1') { //艺术机构
            that.userType = 2;
            that.enterHref = '/article/manage';
          } else if (res.data.info.isPlanner == '1') { //策展人
            that.userType = 3;
            that.enterHref = '/article/manage';
          } else { //普通用户
            that.userType = -1;
            if (resInfo.applyStatus != '0') { //申请艺术家
              that.isAuth = 'Y';
              that.authInfo = {
                name: '艺术家',
                remark: resInfo.applyRemark,
                link1: '/auth/first',
                status: resInfo.applyStatus
              };
            } else if (resInfo.agencyStatus != '0') { //申请艺术机构
              that.isAuth = 'Y';
              that.authInfo = {
                name: '艺术机构',
                remark: resInfo.agencyRemark,
                link1: '/autharts/first',
                status: resInfo.agencyStatus
              };
            } else if (resInfo.plannerStatus != '0') { //申请策展人
              that.isAuth = 'Y';
              that.authInfo = {
                name: '策展人',
                remark: resInfo.plannerRemark,
                link1: '/authcurator/first',
                status: resInfo.plannerStatus
              };
            } else { //未申请
              that.isAuth = 'N';
            }
            typeof cb == "function" && cb();
          }
          setCookie('userType', that.userType);
          that.$nextTick(function () {
            that.isLogin = true;
          });
        } else {
          deleteCookie('userid');
          deleteCookie('userName');
          deleteCookie('userFace');
          deleteCookie('userMobile');
          deleteCookie('temporaryLogin');
          that.isLogin = false;
        }
        that.isCheck = false;
      });
    },
    accountLogin: function () {
      var that = this;
      var mobile = this.loginInfo.mobile;
      var password = this.loginInfo.password;
      if (!validInfo.mobile2.test(mobile)) {
        if (mobile == "" || !validInfo.mobile.test(mobile) || password == "" || password.length < 6 || password.length > 16 || !validInfo.password.test(password) || !validInfo.chinese.test(password)) {
          if (mobile == "") {
            this.errorTip = "请输入您的手机号";
            // return false;
          } else if (!validInfo.mobile.test(mobile)) {
            this.errorTip = "请输入正确的手机号";
            // return false;
          } else if (password == "") {
            this.errorTip = "请输入您的密码";
            // return false;
          } else if (password.length < 6 || password.length > 16) {
            this.errorTip = "请输入6-16位密码";
            // return false;
          } else if (!validInfo.password.test(password)) {
            this.errorTip = "密码不能包含空格，汉字";
            // return false;
          } else if (!validInfo.chinese.test(password)) {
            this.errorTip = "密码不能包含空格，汉字";
            // return false;
          }
          setTimeout(function () {
            that.errorTip = '';
          }, 2000);
          return false;
        }
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;
      this.btnText = "登录中...";

      artzheAgent.call('user/accountLogin',this.loginInfo,function(res) {
        that.isSubmit = false;
        that.btnText = "登录";
        // console.log(res);
        if (res.code == 30000) {
          setCookie('userid', res.data.userid);
          setCookie('userMobile', that.loginInfo.mobile);
          // window.location.href = '/';
          that.checkLogin();
          eventBus.$emit('getUserInfo');

          //同步
            var script = document.createElement('script');
            script.src = switchDomin('mall') + "/seller/privilege.php?act=signin&az_from=mpartzhe";
            document.body.appendChild(script);
          //同步end

          // if (res.data.isArtist == '1') {
          //   window.location.href = '/upload/manage';
          // } else {
          //   that.checkLogin();
          //   // that.applyInfo.tips = '认证成为艺术家，即可上传作品';
          //   // that.applyInfo.btnText = '认证艺术家';
          //   // that.isLogin = true;
          // }
        } else if (res.code == 30111) {
          that.errorTip = "您输入的帐号或者密码不正确，请重新输入";
          setTimeout(function () {
            that.errorTip = '';
          }, 2000);
          return false;
        } else {
            that.errorTip = res.message;
            setTimeout(function () {
                that.errorTip = '';
            }, 2000);
            return false;
        }
      });
    },
    refreshPage: function () {
      window.location.href = '/';
    }
  }
});
