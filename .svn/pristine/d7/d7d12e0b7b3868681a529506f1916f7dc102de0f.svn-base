//图片压缩
var compress = {
  face: '?x-oss-process=image/resize,m_fill,h_80,w_80,limit_0,image/format,jpg', //头像
  S: '?x-oss-process=image/resize,m_fill,h_180,w_180,limit_0,image/format,jpg',  //作品封面小图
  L: '?x-oss-process=image/resize,m_fill,h_500,w_660,limit_0,image/format,jpg'  //作品大图
};

//正则校验
var validInfo = {
  mobile: /^1[34578]{1}\d{9}$/,
  password: /^\S{6,16}$/,
  chinese: /^[^\u4e00-\u9fa5]{6,16}$/,
  verifyCode: /\d{4,6}/,
  idCardNo: /\d{17}[\d|x]|\d{15}/,
  notEmply: /\s*\S+/,
  email: /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
};

//各环境domain转换
function switchDomin(str) { //str:mp|m|www|api
  var myDomin, aDomin, aFirst, sFirst, sFirstNew;

  aDomin = window.location.host.split('.'); //域名数组
  sFirst = aDomin[0]; //获取二级域名前缀
  if (aDomin.length > 2) {
    aDomin.shift();
  }
  sMain = aDomin.join('.');
  aFirst = sFirst.split('-');
  sFirstNew = '';

  if (aFirst.length > 1) {
    sFirstNew = aFirst[0] + '-';
  }
  myDomin = window.location.protocol + '//' + sFirstNew + str + '.' + sMain;

  return myDomin;
}

//跳转微官网
!function(a){var b=/iPhone/i,c=/iPod/i,d=/iPad/i,e=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,f=/Android/i,g=/(?=.*\bAndroid\b)(?=.*\bSD4930UR\b)/i,h=/(?=.*\bAndroid\b)(?=.*\b(?:KFOT|KFTT|KFJWI|KFJWA|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|KFARWI|KFASWI|KFSAWI|KFSAWA)\b)/i,i=/Windows Phone/i,j=/(?=.*\bWindows\b)(?=.*\bARM\b)/i,k=/BlackBerry/i,l=/BB10/i,m=/Opera Mini/i,n=/(CriOS|Chrome)(?=.*\bMobile\b)/i,o=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,p=new RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),q=function(a,b){return a.test(b)},r=function(a){var r=a||navigator.userAgent,s=r.split("[FBAN");if("undefined"!=typeof s[1]&&(r=s[0]),s=r.split("Twitter"),"undefined"!=typeof s[1]&&(r=s[0]),this.apple={phone:q(b,r),ipod:q(c,r),tablet:!q(b,r)&&q(d,r),device:q(b,r)||q(c,r)||q(d,r)},this.amazon={phone:q(g,r),tablet:!q(g,r)&&q(h,r),device:q(g,r)||q(h,r)},this.android={phone:q(g,r)||q(e,r),tablet:!q(g,r)&&!q(e,r)&&(q(h,r)||q(f,r)),device:q(g,r)||q(h,r)||q(e,r)||q(f,r)},this.windows={phone:q(i,r),tablet:q(j,r),device:q(i,r)||q(j,r)},this.other={blackberry:q(k,r),blackberry10:q(l,r),opera:q(m,r),firefox:q(o,r),chrome:q(n,r),device:q(k,r)||q(l,r)||q(m,r)||q(o,r)||q(n,r)},this.seven_inch=q(p,r),this.any=this.apple.device||this.android.device||this.windows.device||this.other.device||this.seven_inch,this.phone=this.apple.phone||this.android.phone||this.windows.phone,this.tablet=this.apple.tablet||this.android.tablet||this.windows.tablet,"undefined"==typeof window)return this},s=function(){var a=new r;return a.Class=r,a};"undefined"!=typeof module&&module.exports&&"undefined"==typeof window?module.exports=r:"undefined"!=typeof module&&module.exports&&"undefined"!=typeof window?module.exports=s():"function"==typeof define&&define.amd?define("isMobile",[],a.isMobile=s()):a.isMobile=s()}(this);
if (isMobile.any) {
  window.location.href = switchDomin('m') + location.pathname;
}

// 弹出提示
var Toast = function(config){  //new Toast({message:'124645665665453'}).show();
  this.context = config.context==null?$('body'):config.context;//上下文
  this.message = config.message;//显示内容
  this.msgEntity = '';
  this.time = config.time==null?3000:config.time;//持续时间
  this.left = config.left;//距容器左边的距离
  this.top = config.top;//距容器上方的距离
  this.init();
};
Toast.prototype = {
    //初始化显示的位置内容等
    init : function(){
        if($("#toastMessage")){
            $("#toastMessage").remove();
        }
        //设置消息体
        var msgDIV = [];
        msgDIV.push('<div id="toastMessage">');
        msgDIV.push('<span>'+this.message+'</span>');
        msgDIV.push('</div>');
        this.msgEntity = $(msgDIV.join('')).appendTo(this.context);
        //设置消息样式
        var left = this.left == null ? this.context.width()/2-this.msgEntity.outerWidth(true)/2 : this.left;
        var top = this.top == null ? '40%' : this.top;
        this.msgEntity.css({
            top: top,
            left: left
        });
        this.msgEntity.hide();
        this.show();
    },
    //显示动画
    show :function(){
        this.msgEntity.fadeIn(this.time/3);
        this.msgEntity.fadeOut(this.time/2);
    }
};

// vue全局组件

// 注册一个空的 Vue 实例，作为 ‘中转站’
var eventBus = new Vue({});

// 子页面页头
Vue.component('ysz-header', {
  template: '<div class="y-header">\
        <div class="w clearfix">\
          <div class="y-logo">\
            <a href="/index">\
              <img src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/logo.png">\
            </a>\
          </div>\
          <ul class="head-nav">\
            <li><a href="/index">首页</a></li>\
            <li><a :href="mpDomin">创作中心</a></li>\
            <li><a href="/arts">艺术号</a></li>\
            <li><a href="/app">下载APP</a></li>\
            <li><a href="/about">关于艺术者</a></li>\
          </ul>\
          <change-user-btn></change-user-btn>\
          <div v-if="isChecked" class="login-info">\
            <div v-if="isLogin" class="is-login">\
              <div class="user-info">\
                <a href="/user/index">\
                  <img :src="info.faceUrl + compress.face" :alt="info.name" class="avatar">\
                </a>\
              </div>\
              <ul class="user-list">\
                <li><a href="/user/index"><i class="icons icon-home"></i>我的资料</a></li>\
                <li><a href="/user/message"><i class="icons icon-message"></i>我的消息<span v-if="info.unreadMessageTotal > 0">{{info.unreadMessageTotal}}</span></a></li>\
                <li><a href="/user/follow"><i class="icons icon-follow"></i>我的关注</a></li>\
                <li><a href="/user/like"><i class="icons icon-like"></i>我的喜欢</a></li>\
                <li v-if="info.isArtist == 1"><a href="/user/fans"><i class="icons icon-fans"></i>我的粉丝</a></li>\
                <li v-if="info.isArtist == 1"><a href="/user/invite"><i class="icons icon-invite"></i>我的邀请</a></li>\
                <li v-if="info.isAgency == 1"><a href="/user/agency"><i class="icons icon-agency"></i>机构特权</a></li>\
                <li v-if="info.isPlanner == 1"><a href="/user/planer"><i class="icons icon-planer"></i>策展人特权</a></li>\
                <li v-if="info.isArtist != 1 && info.isAgency != 1 && info.isPlanner != 1"><a href="/user/auth"><i class="icons icon-auth"></i>申请认证</a></li>\
                <li v-if="info.mall_orders && info.mall_orders.order_all != 0"><a href="/user/orderlist"><i class="icons icon-orderlist"></i>我的订单</a></li>\
                <li><a @click="logout" href="javascript:;"><i class="icons icon-logout"></i>退出</a></li>\
              </ul>\
            </div>\
            <div v-else class="no-login">\
              <div @click="showReg" class="txt reg-btn">注册</div>\
              <div @click="showLogin" class="txt login-btn active">登录</div>\
            </div>\
          </div>\
        </div>\
      </div>\
      ',
  data: function () {
    return {
      mpDomin: switchDomin('mp'),
      info: {

      },
      isChecked: false,
      isLogin: false,
      compress: compress, //图片压缩后缀
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
      var api = '/Api/UserCenter/getMyHomeDetail';
      var data = {
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          that.isChecked = true;
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            that.info = resInfo;
            that.isLogin = true;
            eventBus.$emit('setUserInfo', resInfo);
          } else if (res.code == '30004' && res.data.status == '1000') { //未登录
            eventBus.$emit('setUserInfo', {});
            if (window.location.href.indexOf('user') > -1) {
              that.isLogin = false;
              window.location.href= window.location.origin;
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
          // console.log(res);

          if (res.code == '30000' && res.data.status == '1000') {
            _setCookie('temporaryLogin', 0); //切换登录用户
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
//切换用户的按钮
//' href="javascript:;" style="text-align:center;color:#f4ad23" @click="changeuserfn">返回机构</a></div>'+
Vue.component('change-user-btn', {
template : '<div v-if="shouldchange" style="display:inline-block;width:96px;height:38px;float:right;"><a' +
  ' href="javascript:;" style="text-align:center;color:#f4ad23" @click="dialogVisible = true">返回机构</a>'+
    '<div v-show="dialogVisible" style="position:fixed;width:100%;height:100%;top:0;left:0;background:rgba(0,0,0,.3);z-index:2003;">'+
      '<div style="position:fixed;top: 15%;width: 330px;left: 50%;margin-left:-165px;z-index:2005;background: #fff;line-height: initial;">'+
        '<div style="padding: 20px 20px 0px;">'+
          '<span style="font-size: 16px;font-weight: 700;color: rgb(61, 54, 31);">提示</span>'+
        '</div>'+
        '<div style="padding: 30px 20px;color: rgb(106, 99, 72);font-size: 14px;">确认返回机构账户？</div>'+
        '<div style="padding: 10px 20px 15px;text-align: right;box-sizing: border-box;">'+
          '<span>'+
            '<button @click="dialogVisible = false" style="display: inline-block;line-height: 1;white-space: nowrap;cursor: pointer;background: #fff;border: 1px solid rgb(217, 211, 191);color: rgb(61, 54, 31);-webkit-appearance: none;text-align: center;box-sizing: border-box;outline: 0;margin: 0;padding: 10px 15px;font-size: 16px;height: auto;border-radius: 4px;">取 消</button>'+
            '<button @click="changeuserfn" style="display: inline-block;line-height: 1;white-space: nowrap;cursor: pointer;background-color: #f4ad23;border: 1px solid rgb(217, 211, 191);color: rgb(61, 54, 31);-webkit-appearance: none;text-align: center;box-sizing: border-box;outline: 0;margin: 0;margin-left: 10px;padding: 10px 15px;font-size: 16px;height: auto;border-radius: 4px;">确 定</button>'+
          '</span>'+
        '</div>'+
      '</div>'+
    '</div>'+
  '</div>',

  // '<el-dialog title="提示" :show-close="false" :visible.sync="dialogVisible" size="tiny" :before-close="handleClose" custom-class="jgdialog">'+
  //   '<span>确认返回机构账户？</span>' +
  //   '<span slot="footer" class="dialog-footer">' +
  //   '<el-button @click="dialogVisible = false">取 消</el-button>' +
  //   '<el-button type="primary" @click="changeuserfn">确 定</el-button>' +
  //   '</span>' +
  //   '</el-dialog>'+
  data: function () { //'v-loading.fullscreen.lock="floading" element-loading-text="拼命切换中"'+
    return {
      shouldchange : getCookie('temporaryLogin')>0? true : false,
      dialogVisible: false,
      // floading:false,
    }
  },
  created: function(){

  },
  methods: {
    changeuserfn: function(){
      this.$message({
        type:'info',
        message:'拼命切换中'
      });
      this.dialogVisible = false;
      this.floading = true;
      var that=this;
      var lk = window.location.hostname.split('-')[0];
      lk = lk=='harry'||lk=='test'?lk +'-mp.artzhe.com':'mp.artzhe.com';
      window.location.href = 'https://'+lk+'/user/loadinfo'; //跳转到艺术家管理
      // $.ajax({
      //   url: '/Api/Agency/ChangeLoginToRealIdentity',
      //   data: '',
      //   dataType: 'json',
      //   success: function(res){
      //     if (res.code == 30000) {
      //       $.ajax({
      //         url:'/Api/UserCenter/getMyInfo',
      //         data:'',
      //         dataType:'json',
      //         success:function(res){
      //           deleteCookie('userType');
      //           deleteCookie('userid');
      //           deleteCookie('userName');
      //           deleteCookie('userFace');
      //           deleteCookie('userMobile');
      //           if (res.code == 30000) {
      //             var resInfo = res.data.info;
      //             that.myInfo = {
      //               uid: res.data.info.artist,
      //               name: res.data.info.name,
      //               face: res.data.info.faceUrl
      //             };
      //             var userType = -1;
      //             if (res.data.info.isArtist == '1') { //艺术家
      //               userType = 1;
      //             } else if (res.data.info.isAgency == '1') { //艺术机构
      //               userType = 2;
      //             } else if (res.data.info.isPlanner == '1') { //策展人
      //               userType = 3;
      //             } else { //普通用户
      //               userType = -1;
      //             }
      //             setCookie('userid', res.data.info.id);
      //             setCookie('userName', res.data.info.nickname);
      //             setCookie('userFace', res.data.info.faceUrl);
      //             setCookie('userType', userType);
      //             _setCookie('temporaryLogin', 0); //切换登录用户
      //
      //             var lk = window.location.hostname.split('-')[0];
      //             lk = lk=='harry'||lk=='test'?lk +'-mp.artzhe.com':'mp.artzhe.com';
      //             window.location.href = 'https://'+lk+'/artorganization/arter'; //跳转到艺术家管理
      //           } else {
      //             deleteCookie('userid');
      //             deleteCookie('userName');
      //             deleteCookie('userFace');
      //             deleteCookie('userMobile');
      //           }
      //         }
      //       })
      //     }
      //   }
      // })

    },
    handleClose: function(done) {
      console.log(done)
    }
  },
});
// 登录弹窗
Vue.component('login-box', {
  template: '<div v-show="boxIsShow" class="layerbox">\
        <div @click="hideBox" class="layershade"></div>\
        <div class="layermain">\
          <div v-show="loginBoxShow" class="login-box">\
            <div class="login-title">\
              <ul :class="[\'titles\', \'mobile-title\', loginInfo.wechatActive? \'\': \'active\']">\
                <li @click="showBox(\'login\', \'login\')" :class="[loginInfo.loginActive? \'active\': \'\']">登录</li>\
                <li @click="showBox(\'login\', \'reg\')" :class="[loginInfo.loginActive? \'\': \'active\']">注册</li>\
              </ul>\
              <div :class="[\'titles\', \'wechat-title\', loginInfo.wechatActive? \'active\': \'\']">微信登录</div>\
              <em @click="hideBox" title="关闭" >×</em>\
            </div>\
            <div class="login-con">\
              <ul v-show="!loginInfo.wechatActive">\
                <li :class="[\'form\', \'login-form\', loginInfo.loginActive? \'active\': \'\']">\
                  <div class="item-group">\
                    <input v-model="form.mobile" class="input" type="text" maxlength="11" placeholder="请输入您的手机号">\
                  </div>\
                  <div class="item-group">\
                    <input v-model="form.password" @keyup.enter="toLogin" class="input" maxlength="16" type="password" placeholder="请输入您的密码">\
                  </div>\
                  <div class="item-group clearfix">\
                    <p class="rem-check" @click="toggleRemember"><input type="checkbox"><i :class="[\'icons\', isRemember? \'icon-remembered\': \'icon-remember\']"></i>记住我</p>\
                    <a class="forget" target="_blank" :href="mpDomin + \'/forget/first\'">忘记密码</a>\
                  </div>\
                  <div class="btn-group">\
                    <input @click="toLogin" class="btn btn-b" type="submit" value="登录">\
                  </div>\
                </li>\
                <li :class="[\'form\', \'reg-form\', [loginInfo.loginActive? \'\': \'active\']]">\
                  <div class="item-group">\
                    <input v-model="form.mobile" class="input" type="text" maxlength="11" placeholder="请输入您的手机号">\
                  </div>\
                  <div class="item-group">\
                    <input v-model="form.password" class="input" maxlength="16" type="password" placeholder="设置密码（6～16位字母、数字或字符）">\
                  </div>\
                  <div class="item-group">\
                    <input v-model="form.verifyCode" maxlength="6" class="input input-m" type="text" placeholder="验证码">\
                    <input type="button" :class="[isClickgetVerify ? \'clicked\' : \'\', \'btn\', \'btn-m\', \'fr\']" @click="getVerifyCode()" :value="getVerifyCodeText">\
                  </div>\
                  <div class="btn-group">\
                    <input @click="toReg" class="btn btn-b" type="submit" value="马上注册">\
                  </div>\
                  <p class="tip">您的账号开通后即代表您已同意<a target="_blank" href="/doc/index">《用户注册协议》</a></p>\
                </li>\
              </ul>\
              <div :class="[\'wechat\', loginInfo.wechatActive? \'active\': \'\']">\
                <div class="img-wrap">\
                  <iframe height="300px" :src="wechatCode" ></iframe>\
                </div>\
                <p>请使用微信扫一扫登录艺术者</p>\
              </div>\
              <div class="others">\
                <div @click="showWechat(\'wechat\')" :class="[\'to-wechat\', loginInfo.wechatActive? \'\': \'active\']"><a href="javascript:;"><i class="icons icon-wechat"></i>微信登录</div>\
                <div @click="showWechat()" :class="[\'to-mobile\', loginInfo.wechatActive? \'active\': \'\']"><a href="javascript:;">使用其他方式登录</a></div>\
              </div>\
            </div>\
          </div>\
        </div>\
      </div>\
      ',
  data: function () {
    return {
      mpDomin: switchDomin('mp'),
      loginBoxShow: false,
      boxIsShow: false,
      isRemember: true,
      compress: compress, //图片压缩后缀
      form: {
        mobile: '',
        password: '',
        verifyCode: '',
        from: 'pc'
      },
      wechatCode: '',
      loginInfo: {
        loginActive: true,
        wechatActive: false,
      },
      // 注册登录相关
      isSubmit: false,
      isClickgetVerify:false,
      count: 60,
      getVerifyCodeText: '获取短信验证码'
    };
  },
  mounted: function() {
    eventBus.$on('showLogin', function(box, type) {
      this.showBox(box, type);
    }.bind(this))
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    setWechat: function () {
      this.wechatCode = '/Api/Wechat/ScanCode';
    },
    hideBox: function () {
      this.boxIsShow = false;
      this.loginBoxShow = false;
    },
    showBox: function (box,type) {
      this.boxIsShow = true;
      if (box == 'login') {
        this.loginBoxShow = true;
        this.loginInfo.wechatActive = false;
        if (type == 'reg') {
          this.loginInfo.loginActive = false;
        }
        if (type == 'login') {
          this.loginInfo.loginActive = true;
        }
      }
    },
    showWechat: function (wechat) {
      if (wechat == 'wechat') {
        this.loginInfo.wechatActive = true;
        this.setWechat();
      } else {
        this.loginInfo.wechatActive = false;
      }
    },
    toggleRemember: function () {
      this.isRemember = !this.isRemember;
    },
    toLogin: function () {
      var that = this;
      var api = '/Api/User/accountLogin';
      var mobile = this.form.mobile;
      var password = this.form.password;
      var data = {
        mobile: this.form.mobile,
        password: this.form.password,
        from: 'pc'
      };

      if (mobile == "" || !validInfo.mobile.test(mobile) || password == "" || password.length < 6 || password.length > 16 || !validInfo.password.test(password) || !validInfo.chinese.test(password)) {
        if (mobile == "") {
          new Toast({message: '请输入您的手机号'});
        } else if (!validInfo.mobile.test(mobile)) {
          new Toast({message: '请输入正确的手机号'});
        } else if (password == "") {
          new Toast({message: '请输入您的密码'});
        } else if (password.length < 6 || password.length > 16) {
          new Toast({message: '请输入6-16位密码'});
        } else if (!validInfo.password.test(password)) {
          new Toast({message: '密码不能包含空格，汉字'});
        } else if (!validInfo.chinese.test(password)) {
          new Toast({message: '密码不能包含空格，汉字'});
        }
        return false;
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == 30000 && res.data.status == 1000) {
            that.hideBox();
            that.bottomLoginShow = false;
            //同步
              var script = document.createElement('script');
              script.src = switchDomin('mall') + "/seller/privilege.php?act=signin&az_from=mpartzhe";
              document.body.appendChild(script);
            //同步end

            setTimeout(function() {
              window.location.reload();
            }, 100);

            // eventBus.$emit('getUserInfo');

            that.isLogin = true;
            that.busy = false;
          } else if (res.code == 30111) {
            new Toast({message: '您输入的帐号或者密码不正确，请重新输入'});
          } else  {
              new Toast({message: res.message});
          }
        },
        complete: function (res) {
          that.isSubmit = false;
        }
      });
    },
    toReg: function () {
      var that = this;
      var api = '/Api/User/accountLogin';
      var mobile = this.form.mobile;
      var password = this.form.password;
      var verifyCode = this.form.verifyCode;
      var data = {
        mobile: this.form.mobile,
        password: this.form.password,
        verifyCode: this.form.verifyCode,
        from: 'pc'
      };

      if (mobile == "" || !validInfo.mobile.test(mobile) || password == "" || password.length < 6 || password.length > 16 || !validInfo.password.test(password) || !validInfo.chinese.test(password) || verifyCode == "" || !validInfo.verifyCode.test(verifyCode)) {
        if (mobile == "") {
          new Toast({message: '请输入您的手机号'});
        } else if (!validInfo.mobile.test(mobile)) {
          new Toast({message: '请输入正确的手机号'});
        } else if (password == "") {
          new Toast({message: '请输入您的密码'});
        } else if (password.length < 6 || password.length > 16) {
          new Toast({message: '请输入6-16位密码'});
        } else if (!validInfo.password.test(password)) {
          new Toast({message: '密码不能包含空格，汉字'});
        } else if (!validInfo.chinese.test(password)) {
          new Toast({message: '密码不能包含空格，汉字'});
        } else if (verifyCode == "") {
          new Toast({message: '请输入短信验证码'});
        } else if (!validInfo.verifyCode.test(verifyCode)) {
          new Toast({message: '验证码错误，请重新输入'});
        }
        return false;
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;

      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == 30000 && res.data.status == 1000) {
            that.hideBox();
            that.isLogin = true;
            that.bottomLoginShow = false;
            that.busy = false;
            eventBus.$emit('showSetUser'); //设置用户基本信息
          } else if (res.code == 30110) {
            new Toast({message: '验证码错误，请重新输入'});
          } else if (res.code == 30114) {
            new Toast({message: '您已注册，请直接登录'});
          }
        },
        complete: function (res) {
          that.isSubmit = false;
        }
      });
    },
    getVerifyCode: function () {
      var that = this;
      var mobile = this.form.mobile;
      var data = {
        'mobile': this.form.mobile,
      };

      if (mobile == "" || !validInfo.mobile.test(mobile)) {
        if (mobile == "") {
          new Toast({message: '请输入您的手机号'});
        } else if (!validInfo.mobile.test(mobile)) {
          new Toast({message: '请输入正确的手机号'});
        }
        return false;
      }

      if (that.isClickgetVerify) {
        return false;
      }
      that.setTime();

      $.ajax({
        type: "POST",
        url: '/Api/User/sendVerifyCode', //获取手机验证码
        data: data,
        success: function(res) {
          // console.log('获取手机验证码', res);
          if (res.code == 30000 && res.data.status == 1000) {

          }
        }
      });
    },
    setTime: function (argument) {
      var that = this;
      var count = this.count;
      if (this.count == 0) {
        this.isClickgetVerify = false;
        this.getVerifyCodeText = "重新发送";
        this.count = 60;
        return false;
      } else {
        this.isClickgetVerify = true;
        this.getVerifyCodeText = this.count + "S";
        this.count = --count;
        // console.log(this.count);
      }
      setTimeout(function() {
        that.setTime();
      }, 1000);
    }
  }
});

// 设置用户基本信息弹窗
Vue.component('set-user-box', {
  template: '<div>\
  <div v-show="boxIsShow" class="layerbox">\
        <div @click="hideBox" class="layershade"></div>\
        <div class="layermain">\
          <div v-show="setBoxShow" class="login-box set-box">\
            <div class="login-title">\
              <div class="titles wechat-title active">个人信息完善</div>\
              <em @click="hideBox" title="关闭" >×</em>\
            </div>\
            <div class="login-con">\
              <ul>\
                <li class="form login-form active">\
                  <div class="item-group">\
                    <input v-model="form.nickname" class="input" type="text" maxlength="11" placeholder="请输入您的昵称">\
                  </div>\
                  <div class="item-group clearfix">\
                    <div class="tit"><label>性别</label></div>\
                    <div class="con">\
                      <div class="box radio-wrap">\
                        <el-radio class="radio" v-model="form.gender" label="1">男</el-radio>\
                        <el-radio class="radio" v-model="form.gender" label="2">女</el-radio>\
                      </div>\
                    </div>\
                  </div>\
                  <div class="item-group clearfix">\
                    <div class="tit"><label>头像</label></div>\
                    <div class="con">\
                      <div class="box">\
                        <el-upload action="/Api/UserCenter/uploadImage" :show-file-list="false" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload">\
                          <input type="button" class="btn-s" value="上传">\
                        </el-upload>\
                      </div>\
                      <div class="el-loading-mask2" v-show="uploadloading" style="float: left;"><div class="el-loading-spinner"><svg viewBox="25 25 50 50" class="circular"><circle cx="50" cy="50" r="20" fill="none" class="path"></circle></svg></div></div>\
                      <div v-if="form.face" class="face-preview">\
                        <h3>头像预览</h3>\
                        <img class="cude" :src="form.face + compress.S">\
                        <img class="circle" :src="form.face + compress.S">\
                      </div>\
                    </div>\
                  </div>\
                  <div class="btn-group">\
                    <input @click="submit" class="btn btn-b" type="submit" value="完成">\
                  </div>\
                </li>\
              </ul>\
            </div>\
          </div>\
        </div>\
      </div>\
    </div>\
      ',
  data: function () {
    return {
      setBoxShow: false,
      boxIsShow: false,
      compress: compress, //图片压缩后缀
      isSubmit: false,
      form: {
        nickname: '',
        gender: 3,
        face: ''
      },
      uploadloading: false
    };
  },
  mounted: function() {
    eventBus.$on('showSetUser', function() {
      this.showBox();
    }.bind(this))
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    beforeAvatarUpload: function (file) {
      var type = file.type.toUpperCase();
      if (type !== 'IMAGE/JPEG' && type !== 'IMAGE/PNG' && type !== 'IMAGE/JPG' && type !== 'IMAGE/BMP' && type !== 'IMAGE/GIF') {
        this.$message({
          message: '请上传图片'
        });
        return false;
      }
      this.uploadloading = true;
    },
    handleAvatarSuccess: function (res) {
      var that = this;
      // console.log(res);
      that.uploadloading = false;
      if (res.code == '30000' && res.data.status == '1000') {
        that.$message({
          message: '上传成功'
        });
        that.form.face = res.data.info.url;
      } else {
        that.$message({
          message: '上传失败'
        });
      }
    },
    showUpload: function () {
      // body...
    },
    hideBox: function () {
      this.boxIsShow = false;
      this.setBoxShow = false;
      window.location.reload();
    },
    showBox: function (box,type) {
      this.boxIsShow = true;
      this.setBoxShow = true;
    },
    submit: function () {
      var that = this;
      var api = '/Api/UserCenter/saveUserInfo'; //设置个人信息
      var data = this.form;
      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }

      this.isSubmit = true;
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == '30000' && res.data.status == '1000') {
            that.$message({
              message: '设置成功',
              type: 'success'
            });
          }
        },
        complete: function () {
          that.isSubmit = false;
          that.hideBox();
        }
      });
    }

  }
});

// 子页面页脚
Vue.component('ysz-footer', {
  template: '\
      <div class="ysz-footer">\
        <div class="y-footer">\
          <div class="w">\
            <div class="foot-logo">\
              <img src="/Public/image/logo.png" alt="艺术者">\
            </div>\
            <div class="com-info">\
              <ul class="foot-code">\
                <li>\
                  <img class="code-image" src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/wechat.jpg">\
                  <p class="txt">微信订阅号</p>\
                </li>\
                <li>\
                  <img class="code-image" src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/APP.png">\
                  <p class="txt">艺术者APP</p>\
                </li>\
              </ul>\
              <div class="foot-contact">\
                <h3>联系我们</h3>\
                <p>\
                  地址: 深圳市南山区深圳湾科技生态园1期5栋C座<br>\
                  联系邮箱：artzhe@artzhe.com<br>\
                  官方微博：weibo.cn/artzhe2017\
                </p>\
              </div>\
            </div>\
          </div>\
        </div>\
        <p class="copyright">Copyright 2017 www.artzhe.com. ALL Rights Reserved&nbsp;&nbsp;粤ICP备17041531号-1</p>\
      </div>\
      ',
  mounted: function() {
    // this.stickDown();
    // $(window).scroll(this.stickDown()).resize(this.stickDown());
  },
  methods: {
    stickDown: function() {
      var $footer = $(".ysz-footer");
      var footerHeight = $footer.height();
      var top = $footer.offset().top;
      var footerTop = ($(window).scrollTop() + $(window).height() - footerHeight) + "px";
      var winH = $(window).height();
      var docH = $('body').height();
      //如果页面内容高度小于屏幕高度，footer将绝对定位到屏幕底部，否则footer保留它的正常静态定位 　　　
      if (top + footerHeight < winH) {　　
        $footer.css({　　
          position: "absolute"　　
        }).stop().animate({　　
          top: footerTop　　
        });　　　　
      } else {　　　　
        $footer.css({　　
          position: "static"　　　　
        });　　　　
      }

    }
  },
});

// 页面加载更多
Vue.component('ysz-loadmore', {
  template: '\
      <div infinite-scroll-disabled="busy" infinite-scroll-distance="10" class="spinner">\
        <div class="bounce1"></div>\
        <div class="bounce2"></div>\
        <div class="bounce3"></div>\
        <p>加载中...</p>\
      </div>\
      '
});

// 用户中心左侧个人信息
Vue.component('left-user-info', {
  template: '<div class="left-wrap my-info">\
        <ul class="user-list" id="user-list">\
          <li><a href="/user/index"><i class="icons icon-home"></i>我的资料</a></li>\
          <li><a href="/user/message"><i class="icons icon-message"></i>我的消息<span v-if="info.unreadMessageTotal > 0">{{info.unreadMessageTotal}}</span></a></li>\
          <li><a href="/user/follow"><i class="icons icon-follow"></i>我的关注</a></li>\
          <li><a href="/user/like"><i class="icons icon-like"></i>我的喜欢</a></li>\
          <li v-if="info.isArtist == 1"><a href="/user/fans"><i class="icons icon-fans"></i>我的粉丝</a></li>\
          <li v-if="info.isArtist == 1"><a href="/user/invite"><i class="icons icon-invite"></i>我的邀请</a></li>\
          <li v-if="info.isAgency == 1"><a href="/user/agency"><i class="icons icon-agency"></i>机构特权</a></li>\
          <li v-if="info.isPlanner ==1"><a href="/user/planer"><i class="icons icon-planer"></i>策展人特权</a></li>\
          <li v-if="info.mall_orders && info.mall_orders.order_all != 0"><a href="/user/orderlist"><i class="icons icon-orderlist"></i>我的订单</a></li>\
          <li><a href="/user/auth"><i class="icons icon-auth"></i>申请认证</a></li>\
        </ul>\
      </div>\
      ',
  data: function () {
    return {
      info: {

      }
    };
  },
  mounted: function() {
    new StickUpAll('#user-list');
    eventBus.$on('setUserInfo', function(info) {
      this.info = info;
      this.$nextTick(function () {
        // DOM 现在更新了
        // `this` 绑定到当前实例
        this.highLightPage();
      })
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    highLightPage: function () {
      var links = $('#user-list li a');
      for (var i = 0, len = links.length; i < len; i++) {
        var linkURL = links[i].getAttribute('href');
        if (window.location.href.indexOf(linkURL) !== -1) {
          $(links[i]).parent().addClass('active');
        }
      }
    }
  }
});

//取消喜欢弹窗
Vue.component('like-box', {
  template: '<div v-show="boxIsShow" class="layerbox">\
        <div @click="hideBox" class="layershade"></div>\
        <div class="layermain">\
          <div v-show="remarkIsShow" class="thirdLayerIn anim-scale remark-box">\
            <h3 class="title">温馨提示 <em @click="hideBox" title="关闭" >×</em></h3>\
            <div class="content">确定不再喜欢TA吗？</div>\
            <div class="btn-group">\
              <div @click="unlike" class="btn-s w110">确 定</div>\
              <a @click="hideBox" class="btn-s primary w110">取消</a>\
            </div>\
          </div>\
        </div>\
      ',
  data: function () {
    return {
      remarkIsShow: false, //提醒弹窗是否显示
      boxIsShow: false,  //弹窗蒙层是否显示
      id: '',
      type: '',
      index: ''
    };
  },
  created: function () {

  },
  mounted: function() {
    eventBus.$on('showLikeBox', function(id, type, index) {
      this.showLikeBox(id, type, index);
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showLikeBox: function (id, type, index) {
      this.id = id;
      this.type = type;
      this.index = index;
      this.boxIsShow = true;
      this.remarkIsShow = true;
    },
    unlike: function () {
      var that = this;
      var data = {
        id: this.id,
        type: this.type
      };
      $.ajax({
        type: "POST",
        url: '/Api/Artwork/unlike',
        data: data,
        success: function(res) {
          // console.log(res);
          that.likeClick = false;
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            eventBus.$emit('showLogin', 'login', 'login');
          } else if (res.code == '30000' && res.data.status == 1000) {
            that.hideBox();
            eventBus.$emit('unlike', that.id, that.type, that.index, res.data.faceUrl);
          }
        }
      });
    },
    hideBox: function () {
      this.boxIsShow = false;
      this.remarkIsShow = false;
    },
  }
});

//首页认证按钮
Vue.component('auth-btn1', {
  template: '<div v-if="JSON.stringify(userInfo) == \'{}\' || userInfo.applyStatus == 0" @click="gotoAuth" class="i-auth btn-m">我要认证成为艺术家</div>\
      ',
  data: function () {
    return {
      userInfo: {id:-1}
    };
  },
  created: function () {

  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.userInfo = info;
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    gotoAuth: function () {
      if (this.userInfo.artist) {
        if (this.userInfo.applyStatus == 0) {
          window.location.href = '/user/auth';
        }
      } else {
        eventBus.$emit('showLogin', 'login', 'login');
      }
    }
  }
});

//艺术号页面认证按钮
Vue.component('auth-btn2', {
  template: '<a href="javascript:;" v-if="JSON.stringify(userInfo) == \'{}\' || (userInfo.plannerStatus == 0 && userInfo.agencyStatus == 0)" @click="gotoAuth" class="btn">立即入驻</a>',
  data: function () {
    return {
      userInfo: {id:-1}
    };
  },
  created: function () {

  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.userInfo = info;
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    gotoAuth: function () {
      if (this.userInfo.artist) {
        if (this.userInfo.plannerStatus == 0 && this.userInfo.agencyStatus == 0) {
          window.location.href = '/user/auth';
        }
      } else {
        eventBus.$emit('showLogin', 'login', 'login');
      }
    }
  }
});

//认证弹窗
Vue.component('auth-box', {
  template: '<div v-if="JSON.stringify(userInfo) == \'{}\' || userInfo.applyStatus == 0" class="auth-wrap">\
                <p>下一个网红艺术家就是你</p>\
                <p>这里有全世界青年艺术家</p>\
                <a @click="gotoAuth" class="btn-m" href="javascript:;">我要认证成为艺术家</a>\
      </div>\
      ',
  data: function () {
    return {
      userInfo: {id:-1}
    };
  },
  created: function () {

  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.userInfo = info;
      this.$nextTick(function () {
        if ($('.auth-wrap').length > 0) {
          new StickUpAll('.auth-wrap');
        }
      });
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    gotoAuth: function () {
      if (this.userInfo.artist) {
        if (this.userInfo.applyStatus == 0) {
          window.location.href = '/user/auth';
        }
      } else {
        eventBus.$emit('showLogin', 'login', 'login');
      }
    }
  }
});

//认证浮动窗
Vue.component('auth-fixedbox', {
  template: '<div v-if="JSON.stringify(userInfo) == \'{}\' || userInfo.applyStatus == 0" class="auth-fixed">\
        <p>下一个网红艺术家就是你</p>\
        <p>这里有全世界青年艺术家</p>\
        <a @click="gotoAuth" class="btn-m" href="javascript:;">我要认证</a>\
      </div>\
      ',
  data: function () {
    return {
      userInfo: {id:-1}
    };
  },
  created: function () {

  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.userInfo = info;
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    gotoAuth: function () {
      if (this.userInfo.artist) {
        if (this.userInfo.applyStatus == 0) {
          window.location.href = '/user/auth';
        }
      } else {
        eventBus.$emit('showLogin', 'login', 'login');
      }
    }
  }
});

// 获取一级域名
function GetCookieDomain() {
  var host = location.hostname;
  var ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
  if (ip.test(host) === true || host === 'localhost') return host;
  var regex = /([^]*).*/;
  var match = host.match(regex);
  if (typeof match !== "undefined" && null !== match) host = match[1];
  if (typeof host !== "undefined" && null !== host) {
    var strAry = host.split(".");
    if (strAry.length > 1) {
      host = strAry[strAry.length - 2] + "." + strAry[strAry.length - 1];
    }
  }
  return '.' + host;
}

//cookie相关：设置、获取、删除
function setCookie(name, value, expireMinutes) {
  expireMinutes = expireMinutes || 2592000;
  var time = new Date();
  time.setMinutes(time.getMinutes() + expireMinutes);
  document.cookie = name + "=" + escape(value) + "; domain=" + GetCookieDomain() + ";path=/;expires=" + time.toUTCString();
}

function getCookie(key) {
  var arr, reg = new RegExp("(^| )" + key + "=([^;]*)(;|$)");
  if (arr = document.cookie.match(reg)) {
    return unescape(arr[2]);
  } else {
    return null;
  }
}

function deleteCookie(name) {
  if (getCookie(name) === true) {
    return setCookie(name, undefined, 0);
  }

  return setCookie(name, '', 0);
}


function n2br(str) {
  str = str.replace(/\r\n/g, "<br>");
  str = str.replace(/\n/g, "<br>");
  return str;
}

// 获取URL中的id /artwork/update/150?from=singlemessage
function GetLocationId() {
  var path = window.location.pathname; //获取url中路径
  var ids = path.split('/');
  var id = ids[ids.length-1];
  return id;
}

//判断字符串内是否含有《，没有加上《》
function checkMark(str) {
  if (str.indexOf('《') == -1) {
    str = '《' + str + '》';
  }
  return str;
}

// 返回顶部
var ToTop = {
  init : function () {
    this.attachEl();
    this.bind();
  },
  attachEl : function () {
    this.$el = $('#to-top');
    this.$c = $(document);
  },
  bind : function () {
    var me = this;
    this.$el.on('click',function () {
      me.goToTop();
    });
    this.$c.on('scroll',$.proxy(this.scroll,this));
  },
  goToTop : function () {
    $("body,html").animate({scrollTop:0}, 500);
  },
  scroll : function () {
    if (this.$c.scrollTop()>100) {
      this.$el.show();
    } else {
      this.$el.hide();
    }
  }
};

ToTop.init();

//导航栏粘贴在顶部
function StickUpAll(navEl) {
    this.$el = $(navEl);
    this.$c = $('body');
    this.elTop = this.$el.offset().top;
    this.bind();
}

StickUpAll.prototype = {
  bind: function() {
    var me = this;
    $(window).on('scroll', function() {
      me.do();
    });
  },
  do: function() {
    var scrollTop = this.$c.scrollTop() ? this.$c.scrollTop() : $('html').scrollTop();
    if (scrollTop > this.elTop) {
      this.stick();
    } else {
      this.unstick();
    }
  },
  stick: function() {
    if (this.$el.hasClass('sticked')) {
      return;
    }
    this.$el.addClass('sticked');
    this.$el.css('position', 'fixed');
    var $temp = $('<div class="temp"></div>');
    $temp.height(this.$el.height());
    this.$el.before($temp);
  },
  unstick: function() {
    this.$el.removeClass('sticked');
    this.$el.prev('.temp').remove();
    this.$el.css('position', 'relative');
  }
};


var utils = function () {
  function n2br(str) {
    str = str.replace(/\r\n/g, "<br>");
    str = str.replace(/\n/g, "<br>");
    return str;
  }

  function getToken() {

  }

  return {
    n2br: n2br
  };
}();

// 检测字符串是否含有书名号
function checkMark(str) {
  if (str.indexOf('《') == -1) {
    str = '《' + str + '》';
  }
  return str;
}

//日期格式化
function formatDate(date, fmt) {
  if (/(Y+)/.test(fmt)) {
    fmt = fmt.replace(RegExp.$1, (date.getFullYear() + '').substr(4-RegExp.$1.length));
  }
  var o = {
    'M+': date.getMonth() + 1,
    'D+': date.getDate(),
    'h+': date.getHours(),
    'm+': date.getMinutes(),
    's+': date.getSeconds()
  }
  for (var k in o) {
    // debugger;
    if (new RegExp('(' + k + ')').test(fmt)) {
      var str = o[k] + '';
      fmt = fmt.replace(RegExp.$1, RegExp.$1.length ===1 ? str : padLeftZero(str));
    }
  }
  return fmt;
}
function padLeftZero(str) {
  return ('00' + str).substr(str.length);
}

// 百度统计代码
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?b04dbbe8716725ab25d51f59b1f1931e";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();

// 谷歌统计代码
(function(i, s, o, g, r, a, m) {
  i['GoogleAnalyticsObject'] = r;
  i[r] = i[r] || function() {
    (i[r].q = i[r].q || []).push(arguments)
  }, i[r].l = 1 * new Date();
  a = s.createElement(o),
    m = s.getElementsByTagName(o)[0];
  a.async = 1;
  a.src = g;
  m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

ga('create', 'UA-96560910-2', 'auto');
ga('send', 'pageview');


// 一级域名
var _getCookie = function(key) {
  var arr, reg = new RegExp("(^| )" + key + "=([^;]*)(;|$)");
  if (arr = document.cookie.match(reg)) {
    return unescape(arr[2]);
  } else {
    return null;
  }
}
var _setCookie = function(key, value, expiredays) {
  var exdate = new Date()
  exdate.setDate(exdate.getDate() + expiredays)
  document.cookie = key + "=" + escape(value) +
    ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; domain=" + GetCookieDomain() + "; path=/";
}
var _setCookie1 = function(key, value, expiredays) {
  var exdate = new Date()
  exdate.setDate(exdate.getDate() + expiredays)
  document.cookie = key + "=" + escape(value) +
    ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; path=/";
}
var _deleteCookie = function (key, value, expiredays) {
  function _set(key, value, expiredays) {
    var exdate = new Date()
    exdate.setDate(exdate.getDate() + expiredays)
    document.cookie = key + "=" + escape(value) +
      ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; path=/";
  }
  _setCookie1(key, undefined, 0);
  _set(key, undefined, 0);
}
