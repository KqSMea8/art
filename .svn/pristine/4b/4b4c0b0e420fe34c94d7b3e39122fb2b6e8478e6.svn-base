var href = window.location.href;

//growingio统计代码
var _vds = _vds || [];
window._vds = _vds;


// 百度统计代码
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?b04dbbe8716725ab25d51f59b1f1931e";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();

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

//获取请求参数
function GetRequest() {
  var url = location.search; //获取url中"?"符后的字串
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

// 弹出提示
var Toast = function(config){  //new Toast({message:'124645665665453'});
  this.context = config.context==null?$('body'):config.context;//上下文
  this.message = config.message;//显示内容
  this.msgEntity = '';
  this.time = config.time==null?5000:config.time;//持续时间
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
        this.msgEntity.fadeIn(this.time/5);
        this.msgEntity.fadeOut(this.time/2);
    }
};

// vue全局组件

// 注册一个空的 Vue 实例，作为 ‘中转站’
var eventBus = new Vue({});

//关注公众号弹窗
Vue.component('follow-box', {
  template: '<div v-show="boxIsShow" class="layerbox layermshow">\
            <div @click="hideBox" class="layershade"></div>\
            <div class="layermain">\
            <div class="thirdLayerIn anim-scale qrcode-box">\
                <img onclick="_hmt.push([\'_trackEvent\', \'活动一：助力页二维码\', \'click\', href]);" src="/Public/image/queen/qrcode-weixin.jpg" class="qrcode-weixin">\
                <p class="qrcode-info">长按识别二维码，免费领画</p>\
            </div>\
        </div>\
      ',
  data: function () {
    return {
      boxIsShow: false,  //弹窗蒙层是否显示
    };
  },
  created: function () {
    
  },
  mounted: function() {
    eventBus.$on('showFollowBox', function() {
      this.showBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    }
  }
});

//使用弹窗
Vue.component('use-box', {
  template: '<div v-show="boxIsShow" class="layerbox layermshow">\
            <div @click="hideBox" class="layershade"></div>\
            <div class="layermain">\
            <div class="thirdLayerIn anim-scale use-box">\
                <h3 class="use-title">红包使用提示</h3>\
                <p class="use-info">减免金额将以优惠券形式发送到您个人账户，<span class="important">请将原价商品加入购物车，点击结算后</span>，在订单提交页面点选优惠券即可进行价格减免哦！</p>\
                <div class="btns-group"><a @click="goto" :href="goodsLink" class="btn-know">去使用</a></div>\
            </div>\
        </div>\
      ',
  data: function () {
    return {
      boxIsShow: false,  //弹窗蒙层是否显示
      goodsLink: ''
    };
  },
  created: function () {
    
  },
  mounted: function() {
    eventBus.$on('showUseBox', function(goodsLink) {
      this.goodsLink = switchDomin('mall') + '/mobile/index.php?m=user&c=login&back_act=' + escape(goodsLink); //http://test-mall.artzhe.com/mobile/index.php?m=user&c=login&back_act=
      this.showBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    goto: function () {
      _hmt.push(['_trackEvent', '活动一：助力页我知道了', 'click', href]);
      eventBus.$emit('showLoadingBox');
    }
  }
});

//loading弹窗
Vue.component('loading-box', {
  template: '<div id="loading" v-show="boxIsShow"><img src="/Public/image/loading.gif?v=0.0.1"></div>',
  data: function () {
    return {
      boxIsShow: false  //弹窗蒙层是否显示
    };
  },
  created: function () {
    
  },
  mounted: function() {
    eventBus.$on('showLoadingBox', function() {
      this.showBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    }
  }
});

//分享弹窗
Vue.component('share-box', {
  template: '<div v-show="boxIsShow" @click="hideBox" class="wxTrip">\
        <div class="ruleimg"></div>\
      </div>\
      ',
  data: function () {
    return {
      boxIsShow: false,  //弹窗蒙层是否显示
    };
  },
  created: function () {
    
  },
  mounted: function() {
    eventBus.$on('showShareBox', function() {
      this.showBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    }
  }
});

//完成弹窗 助力好友到达人数上限提示 （主人）
Vue.component('done-box', {
  template: '<div v-show="boxIsShow" class="layerbox layermshow">\
            <div @click="hideBox" class="layershade"></div>\
            <div class="layermain">\
            <div class="thirdLayerIn anim-scale remind-box">\
                <p class="remind-info">你的助力好友已经到达50人上限， 快去使用吧！</p>\
                <div class="btns-group"><a @click="goto" :href="goodsLink" class="btn-touse">去使用</a></div>\
            </div>\
        </div>\
      ',
  data: function () {
    return {
      boxIsShow: false,  //弹窗蒙层是否显示
      goodsLink: ''
    };
  },
  created: function () {
    
  },
  mounted: function() {
    eventBus.$on('showDoneBox', function(goodsLink) {
      this.goodsLink = switchDomin(mall) + '/mobile/index.php?m=user&c=login&back_act=' + escape(goodsLink);
      this.showBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    goto: function () {
      _hmt.push(['_trackEvent', '活动一：助力页去使用', 'click', href]);
      eventBus.$emit('showLoadingBox');
    }
  }
});

//完成弹窗 助力好友到达人数上限提示（客人）
Vue.component('client-box', {
  template: '<div v-show="boxIsShow" class="layerbox layermshow">\
            <div @click="hideBox" class="layershade"></div>\
            <div class="layermain">\
            <div class="thirdLayerIn anim-scale remind-box">\
                <p class="remind-info">她的助力好友已经达到上限，您可以尝试其他操作!</p>\
                <div class="btns-group">\
                  <a @click="hideBox" onclick="_hmt.push([\'_trackEvent\', \'活动一：助力页不必了\', \'click\', href]);" href="javascript:;" class="btn-noneed fl">不必了</a>\
                  <a @click="showFollowBox" href="javascript:;" class="btn-free fr">免费领画</a>\
                </div>\
            </div>\
        </div>\
      ',
  data: function () {
    return {
      boxIsShow: false,  //弹窗蒙层是否显示
    };
  },
  created: function () {
    
  },
  mounted: function() {
    eventBus.$on('showClientBox', function(goodsLink) {
      this.goodsLink = goodsLink;
      this.showBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    goto: function () {
      eventBus.$emit('showLoadingBox');
    },
    showFollowBox: function () {
      _hmt.push(['_trackEvent', '活动一：助力页免费领画', 'click', href]);
      this.hideBox();
      eventBus.$emit('showFollowBox');

    }
  }
});

//生成分享海报弹窗
Vue.component('poster-box', {
  template: '<div v-show="boxIsShow" class="poster-wrap layermshow">\
            <div class="poster-content">\
              <img src="/Public/image/queen/blue/poster-bg.png" class="background">\
              <div class="cover-wrap">\
                <img class="cover" :src="goodsImgLink">\
              </div>\
              <h4 class="name">{{info.share_goods_name}}</h4>\
              <p class="msg">\
              长按识别二维码，为我助力减价<br>\
              最高可直接减到免单\
              </p>\
              <div class="qrcode-wrap">\
                <div id="qrcode" class="qrcode"></div>\
              </div>\
            </div>\
            <img @click="hideBox" class="close" src="//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/close.png" alt="关闭">\
            <div class="remark-wrap">\
              <div class="remark">\
                <p class="mark">长按保存，分享给您的好友</p>\
                <span class="hand scale-btn"></span>\
              </div>\
            </div>\
        </div>\
      ',
  props: {
    info: {
      type: Object
    },
  },
  data: function () {
    return {
      boxIsShow: false,  //弹窗蒙层是否显示
    };
  },
  computed: {
    shareLink: function () {
      // http://test-mall.artzhe.com/mobile/index.php?m=goods&id=913
      return window.location.origin + window.location.pathname + window.location.search;
    },
    goodsImgLink: function () {
      var link = this.info.share_goods_id ? '/Public/image/queen/blue/goods/' + this.info.share_goods_id +'.jpg' : '/Public/image/queen/blue/goods/0.jpg';
      return link;
    }
  },
  created: function () {
    
  },
  mounted: function() {
    new QRCode(document.getElementById("qrcode"), this.shareLink);
    this.$nextTick(function () {
    });

    eventBus.$on('showPosterBox', function() {
      this.showBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function () {
      this.boxIsShow = true;
      this.$nextTick(function () {
        var winHeight = $(window).height();
        var posterEl = $('.poster-content');
        var w = posterEl.width();
        var h = posterEl.height();
        //要将 canvas 的宽高设置成容器宽高的 2 倍
        var canvas = document.createElement("canvas");
        canvas.width = w * 2;
        canvas.height = h * 2;
        canvas.style.width = w + "px";
        canvas.style.height = h + "px";
        var context = canvas.getContext("2d");
        //然后将画布缩放，将图像放大两倍画到画布上
        // var cenX=(posterEl.offset().left)*2;
        // var cenY=(posterEl.offset().top)*2;
        // context.translate(-cenX,-cenY);
        context.scale(2,2);
        html2canvas(posterEl, {
          canvas: canvas,
          onrendered: function(canvas) {
            var image = new Image();
            image.id="poster-img";
            image.crossOrigin = "Anonymous";
            image.src = canvas.toDataURL("image/png");
            posterEl.append(image);
          }
        });
      });

      setTimeout(function(){//定时器 
        $(".poster-wrap .remark-wrap").css("display","none");//将图片的display属性设置为none
        },
      2000);//设置三千毫秒即3秒
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    goto: function () {
      eventBus.$emit('showLoadingBox');
    },
    showFollowBox: function () {
      _hmt.push(['_trackEvent', '活动一：助力页免费领画', 'click', href]);
      this.hideBox();
      eventBus.$emit('showFollowBox');

    }
  }
});

var vmApp = new Vue({
  el: '#app',
  data: {
    boxIsShow: false,
    info: {},
  },
  computed: {
    // 计算属性的 getter
    bargainTotal: function () {
      // `this` 指向 vm 实例
      var total = 0;
      if (this.info.list) {
        for (var i = 0; i < this.info.list.length; i++) {
          total += this.info.list[i].bargain_value
        }
      }
      return total;
    },
    goodsLink: function () {
      // http://test-mall.artzhe.com/mobile/index.php?m=goods&id=913
      return switchDomin('mall') + '/mobile/index.php?m=goods&id=' + this.info.share_goods_id;
    },
    goodsImgLink: function () {
      var link = this.info.share_goods_id ? '/Public/image/queen/blue/goods/' + this.info.share_goods_id +'.jpg' : '/Public/image/queen/blue/goods/0.jpg';
      return link;
    },
    isMe: function () {
      if (this.info.share_user_id > 0) {
        if (this.info.share_union_id) {
          if (this.info.share_union_id == (this.info.userinfo.WechatAuthorize && this.info.userinfo.WechatAuthorize.unionId)  || this.info.share_user_id == this.info.userinfo.user_id) {
            return true;
          } else {
            return false;
          }
        } else {
          if (this.info.share_user_id == this.info.userinfo.user_id) {
            return true;
          } else {
            return false;
          }
        }
        
      } else {
        if (this.info.userinfo && this.info.userinfo.WechatAuthorize) {
          if (this.info.share_union_id == this.info.userinfo.WechatAuthorize.unionId) {
            return true;
          } else {
            return false;
          }
        } else {
          return false;
        }
      }

    }
  },
  created: function () {
    this.init();
  },
  methods: {
    init: function () {
      var that = this;
      var api = '/Activity/ShopActivityShare/detail'; //获取分享详情
      var data = {
        share_id: GetRequest().share_id
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == 30000 && res.data.status == 1000) {
            var resInfo = res.data.info;
            var shareConfig = resInfo.share_link;
            var shareInfo = {};
            that.info = resInfo;
            // wx.config({
            //     debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            //     appId: shareConfig.appId, // 必填，公众号的唯一标识
            //     timestamp: shareConfig.timestamp, // 必填，生成签名的时间戳
            //     nonceStr: shareConfig.nonceStr, // 必填，生成签名的随机串
            //     signature: shareConfig.signature,// 必填，签名
            //     jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage'] // 必填，需要使用的JS接口列表
            // });
            if (that.info.list.length >= 50 && that.isMe) { //助力好友到达人数上限提示
              eventBus.$emit('showDoneBox', that.goodsLink);
            }
            document.title = resInfo.share_wx_name + '的艺术心愿';
            shareInfo = {
              title: '艺术品免费送，帮我抢个减免大红包！', //resInfo.share_wx_name + 
              desc: '动动手指，帮帮TA',
              imgUrl: 'https://artzhe.oss-cn-shenzhen.aliyuncs.com/activity/queen/share_icon2.jpg',
              link: window.location.origin + window.location.pathname + window.location.search
            };

            wx.ready(function() {
              wx.onMenuShareTimeline({
                title: shareInfo.title, // 分享标题
                link: shareInfo.link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: shareInfo.imgUrl, // 分享图标
                success: function () {
                // 用户确认分享后执行的回调函数
                }
              });
              wx.onMenuShareAppMessage({
                title: shareInfo.title, // 分享标题
                desc: shareInfo.desc, // 分享描述
                link: shareInfo.link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: shareInfo.imgUrl, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                  // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                  // 用户取消分享后执行的回调函数
                }
              });
            });
            (function(){
              _vds.push(['setAccountId', '9aa9cc9a8407e110']);

              _vds.push(['setCS1', 'unionId', resInfo.userinfo.WechatAuthorize.unionId]);
              // _vds.push(['setCS2', 'company_id', '943123']);
              _vds.push(['setCS3', 'user_name', resInfo.userinfo.WechatAuthorize.nickname]);
              // _vds.push(['setCS4', 'company_name', 'GrowingIO']);
              // _vds.push(['setCS5', 'sales_name', '销售员小王']);

              (function() {
                var vds = document.createElement('script');
                vds.type='text/javascript';
                vds.async = true;
                vds.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'dn-growing.qbox.me/vds.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(vds, s);
              })();
            })();
          }
        }
      });
    },
    showUseBox: function () {
      _hmt.push(['_trackEvent', '活动一：助力页立即使用', 'click', href]);
      eventBus.$emit('showUseBox', this.goodsLink);
    },
    showShareBox: function () {
      _hmt.push(['_trackEvent', '活动一：助力页减免更多', 'click', href]);
      eventBus.$emit('showShareBox');
    },
    showFollowBox: function () {
      _hmt.push(['_trackEvent', '活动一：助力页我也要领画', 'click', href]);
      eventBus.$emit('showFollowBox');
    },
    generatePoster: function () {
      // body...
      _hmt.push(['_trackEvent', '活动一：助力页生成朋友圈海报', 'click', href]);
      eventBus.$emit('showPosterBox');
    },
    support: function () {
      // new Toast({message:'客官您来晚了，女王撒娇支持名额已满，您也来玩一把不？'});


      _hmt.push(['_trackEvent', '活动一：助力页助力好友', 'click', href]);

      var that = this;
      var api = '/Activity/Queen/bargain'; //获取分享详情

      if (that.info.list.length >= 50) { //助力好友到达人数上限提示（客人）
        eventBus.$emit('showClientBox');
        return false;
      }
      if (that.info.userinfo.WechatAuthorize) {
        var data = {
          share_id: GetRequest().share_id,
          union_id: that.info.userinfo.WechatAuthorize.unionId,
          wx_face: that.info.userinfo.WechatAuthorize.faceUrl,
          wx_name: that.info.userinfo.WechatAuthorize.nickname
        };
        $.ajax({
          type: "POST",
          url: api,
          data: data,
          success: function(res) {
            if (res.code == 30000 && res.data.status == 1000) {
              var resInfo = res.data.info;
              var resData = {
                bargain_value: Number(resInfo.bargain_value),
                face: resInfo.wx_face,
                nickname: resInfo.wx_name
              }
              that.info.list.unshift(resData);
            } else {
              new Toast({message: res.message});
            }
          },
          error: function(res) {
            new Toast({message: '哎呀，活动太火爆，请刷新后再试一次。'});
          }
        });
      } else {
        new Toast({message: '请在微信浏览器中打开'});
      }

      
    }
  }
});