var token = getCookie('apiToken');
if (!token) {
  getToken();
}
//避免 CSRF 攻击
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
// getToken
function getToken() {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "POST",
    url: "/public/getToken",
    async: false, //同步获取
    data: {},
    success: function(res) {
      if (res.code = "30000") {
        console.log('getToken.data', res.data);
        token = res.data.token;
      }
    }
  });
}
// 像素转rem
// function px2rem(con) {
//   con = con.replace(/:(\s)?(\d+(\.\d)?)px/g, function(s, t) {
//     s = s.replace('px', '');
//     s = s.replace(':', '');
//     var value = parseInt(s) * 0.0266667; //   此处 1rem = 75px
//     return ':' + value + "rem";
//   });
//   con = con.replace(/:(\s)?(\d+(\.\d)?)pt/g, function(s, t) {
//     s = s.replace('px', '');
//     s = s.replace(':', '');
//     var value = parseInt(s) * 0.0355556; //   此处 1rem = 56.25pt
//     return ':' + value + "rem";
//   });
//   return con;
// }
function px2rem(con) { // /(\d)+\.?[0-9]+(px)|(\d)+(px)/gi
  con = con.replace(/(\d)+\.?[0-9]+(px)|(\d)+(px)/gi, function(s, t) {
    s = s.replace('px', '');
    // s = s.replace(':', '');
    var value = parseInt(s) * 0.0266667; //   此处 1rem = 75px
    return value + "rem";
  });
  con = con.replace(/:(\s)?(\d+(\.\d)?)pt/g, function(s, t) {
    s = s.replace('pt', '');
    // s = s.replace(':', '');
    var value = parseInt(s) * 0.0355556; //   此处 1rem = 56.25pt
    return ':' + value + "rem";
  });
  return con;
}


// 获取URL中的id /artwork/update/150?from=singlemessage
function GetLocationId() {
  var path = window.location.pathname; //获取url中路径
  var ids = path.split('/');
  var id = ids[ids.length - 1];
  return id;
}
//替换字符串换行符为br标签
function n2br(str) {
  str = str.replace(/\r\n/g, "<br>");
  str = str.replace(/\r/g, "<br>");
  str = str.replace(/\n/g, "<br>");
  return str;
}
//检测浏览器
function checkUA() {
  var isIOS, isAndroid, isWeChat;
  var ua = navigator.userAgent.toLowerCase();
  if (/iphone|ipad|ipod/.test(ua)) {
    isIOS = true;
    isAndroid = false;
  } else if (/android/.test(ua)) {
    isIOS = false;
    isAndroid = true;
  }
  if (/micromessenger/.test(ua)) {
    isWeChat = true;
  }
  return {
    isIOS: isIOS,
    isAndroid: isAndroid,
    isWeChat: isWeChat
  };
}
//获取字符串结尾数字
function getEndNum(str) {
  var match = str.match(/(\d+$)/g);
  var num = match[0];
  return num;
}
//checkLogin (检查用户是否登录)
function checkLogin(userId) {
  if (userId < 1) {
    window.location.href = "/wechat/login";
    return false;
  }
}
// 从第二个item开始，随着上划，item从下往上动画进入
function fadeInUp($elList, $elItem, delaySecond) {
  var $aLi = $($elList).find($elItem);
  var num = $aLi.length;
  $aLi.eq(1).css('animation-delay', delaySecond + 's').addClass('animated fadeInUp');
  $(window).scroll(function() {
    var wHeight = $(window).height();
    var iHeight = $aLi.eq(0).height();
    var sTop = $(document).scrollTop();
    for (var i = 2; i < num; i++) {
      var gapTop = $aLi.eq(i).offset().top;
      if (sTop + wHeight + iHeight > gapTop) {
        $aLi.eq(i).css('animation-delay', delaySecond + 's').addClass('animated fadeInUp');
      }
    }
  });
}
//导航栏粘贴在顶部
var StickUp = {
  init: function(navEl) { //传入导航栏选择器字符串 示例 'nav'
    this.attachEl(navEl);
    this.bind();
  },
  attachEl: function(navEl) {
    this.$el = $(navEl);
    this.$c = $('body');
    this.elTop = this.$el.offset().top;
  },
  bind: function() {
    var me = this;
    $(window).on('scroll', function() {
      me.do();
    });
  },
  do: function() {
    var scrollTop = this.$c.scrollTop();
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
    this.$el.css('position', 'static');
  }
};
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
    var scrollTop = this.$c.scrollTop();
    if (scrollTop > this.elTop - this.$el.height()) {
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
    this.$el.css('position', 'static');
  }
};
//去除字符串首尾空格
function trimStr(str) {
  return str.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
}
//字符串长度汉字算2个字符
function zhStrlen(str) {
  return str.replace(/[^\x00-\xff]/g, "**").length;
}
//localstorage
var Storage = {}
Storage.get = function(name) {
  return JSON.parse(localStorage.getItem(name))
}
Storage.set = function(name, val) {
  localStorage.setItem(name, JSON.stringify(val));
  return true;
}
Storage.add = function(name, addVal) {
  var oldVal = Storage.get(name)
  var newVal = oldVal.concat(addVal)
  Storage.set(name, newVal)
}
Storage.del = function(name) {
  localStorage.removeItem(name);
}
//时间转换2017年5月16日
function unixToTime(timestamp) {
  if (timestamp == 0) {
    return '保密';
  } else {
    var unixTimestamp = new Date(timestamp * 1000);
    var nowYear = unixTimestamp.getFullYear();
    var nowMonth = unixTimestamp.getMonth() + 1;
    var nowDay = unixTimestamp.getDate();
    var dataStr = nowYear + '年' + nowMonth + '月' + nowDay + '日';
    return dataStr;
  }
}
var rememberUser = {
  remember: function(account) {
    setCookie("yszAccount", account);
  },
  getLast: function() {
    return getCookie("yszAccount");
  }
}
//cookie相关：设置、获取、删除
function setCookie(name, value, expireMinutes) {
  expireMinutes = expireMinutes || 2592000;
  var time = new Date();
  time.setMinutes(time.getMinutes() + expireMinutes);
  document.cookie = name + "=" + value + ";path=/;expires=" + time.toUTCString();
}

function getCookie(name) {
  var cookies = document.cookie.split(';');
  var total = cookies.length;
  var i, cookie;
  for (i = 0; i < total; i++) {
    cookie = cookies[i].split('=');
    if (cookie[0][0] == ' ') {
      cookie[0] = cookie[0].substring(1, cookie[0].length);
    }
    if (name == decodeURIComponent(cookie[0])) {
      return (cookie.length > 1) ? decodeURIComponent(cookie.splice(1, cookie.length).join('=')) : true;
    }
  }
  return '';
}

function deleteCookie(name) {
  if (getCookie(name) === true) {
    return setCookie(name, undefined, 0);
  }
  return setCookie(name, '', 0);
}

function formatTime(timespan) {
  var dateTime = new Date(timespan);
  var year = dateTime.getFullYear();
  var month = dateTime.getMonth() + 1;
  var day = dateTime.getDate();
  var hour = dateTime.getHours();
  var minute = dateTime.getMinutes();
  var second = dateTime.getSeconds();
  var now = new Date();
  var now_new = Date.parse(now.toDateString()); //typescript转换写法
  var milliseconds = 0;
  var timeSpanStr;
  milliseconds = now_new - timespan;
  if (milliseconds <= 1000 * 60 * 1) {
    timeSpanStr = '刚刚';
  } else if (1000 * 60 * 1 < milliseconds && milliseconds <= 1000 * 60 * 60) {
    timeSpanStr = Math.round((milliseconds / (1000 * 60))) + '分钟前';
  } else if (1000 * 60 * 60 * 1 < milliseconds && milliseconds <= 1000 * 60 * 60 * 24) {
    timeSpanStr = Math.round(milliseconds / (1000 * 60 * 60)) + '小时前';
  } else if (1000 * 60 * 60 * 24 < milliseconds && milliseconds <= 1000 * 60 * 60 * 24 * 15) {
    timeSpanStr = Math.round(milliseconds / (1000 * 60 * 60 * 24)) + '天前';
  } else if (milliseconds > 1000 * 60 * 60 * 24 * 15 && year == now.getFullYear()) {
    timeSpanStr = month + '-' + day + ' ' + hour + ':' + minute;
  } else {
    timeSpanStr = year + '-' + month + '-' + day + ' ' + hour + ':' + minute;
  }
  return timeSpanStr;
}
// 弹出层提示
var isShow = false;
var TipsShow = (function() {
  var Showtips = function(o) {
    this.timer = o.timer || 2000,
      this.info = o.info || "请输入提示信息",
      this.callback = o.callback,
      this.init();
  }
  Showtips.prototype = {
    init: function() {
      if (!isShow) {
        isShow = true;
        var body = document.getElementsByTagName("body")[0];
        var div = document.createElement("div");
        div.className = "tipshow effect";
        div.id = "tipshow";
        body.insertBefore(div, null);
        var tipbg = document.createElement("div");
        tipbg.className = "tipbg";
        var tipshow = document.getElementById("tipshow");
        tipshow.appendChild(tipbg);
        var fontwrap = document.createElement("div");
        fontwrap.className = "fontwrap";
        tipshow.appendChild(fontwrap);
        var font = document.createElement("div");
        font.className = "font";
        font.innerHTML = this.info;
        tipshow.children.item(1).appendChild(font);
        setTimeout(function() {
          var ele = document.getElementById("tipshow");
          ele.parentNode.removeChild(ele);
          isShow = false;
        }, this.timer);
      }
      return;
    }
  }
  return {
    showtips: function(o) {
      var st = new Showtips(o);
    }
  };
})();
// vue全局组件
// 注册一个空的 Vue 实例，作为 ‘中转站’
var eventBus = new Vue({});
// 提醒弹窗
Vue.component('remark-box', {
  template: '<div v-show="boxIsShow" id="j_layerShow" class="layerbox">\
        <div @click="hideBox" class="layershade"></div>\
        <div class="layermain">\
          <div v-show="remarkIsShow" class="thirdLayerIn anim-scale remark-box">\
            <h3 class="title">{{msgData.title}}<i class="icons icon-close " @click="hideBox" title="关闭" ></i></h3>\
            <div class="content">{{msgData.content}}</div>\
            <div v-if="msgData.isShowBtns" class="btn-group">\
              <span @click="confirm" class="btn-s">确 定</span>\
              <span @click="cancel" class="btn-s">取消</span>\
            </div>\
          </div>\
        </div>\
      ',
  data: function() {
    return {
      remarkIsShow: false, //提醒弹窗是否显示
      boxIsShow: false, //弹窗蒙层是否显示
      msgData: {
        title: '',
        content: '',
        isShowBtns: false
      }
    };
  },
  created: function() {},
  mounted: function() {
    eventBus.$on('showRemarkBox', function(msgData) { //{}
      this.showBox(msgData);
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function(msgData) {
      this.msgData = {
        title: msgData.title ? msgData.title : '温馨提示',
        content: msgData.content ? msgData.content : '提示内容',
        isShowBtns: false
      };
      this.boxIsShow = true;
      this.remarkIsShow = true;
    },
    confirm: function() {
      var that = this;
      var data = {
        id: this.id,
        type: this.type
      };
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.remarkIsShow = false;
    },
    cancel: function() {
      this.hideBox();
    },
  }
});
//loading弹窗
Vue.component('loading-box', {
  template: '<div id="loading" v-show="boxIsShow"><img src="/Public/image/loading.gif?v=0.0.1"></div>',
  data: function() {
    return {
      boxIsShow: true //弹窗蒙层是否显示
    };
  },
  created: function() {},
  mounted: function() {
    eventBus.$on('hideLoadingBox', function() {
      this.hideBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function() {
      this.boxIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
    }
  }
});
//底部导航栏
Vue.component('footer-bar', {
  template: '<div id="tab-bar">\
      <nav class="tab-bar-list">\
        <a class="tab-bar-item" href="/index/recommend">\
          <i class="icons icon-recommend"></i>\
          <span class="tab-label">推荐</span>\
        </a>\
        <a class="tab-bar-item" href="/gallery/index">\
          <i class="icons icon-gallery"></i>\
          <span class="tab-label">画廊</span>\
        </a>\
        <a class="tab-bar-item" @click.prevent="showDownloadBox" href="/user/index">\
          <i class="icons icon-user"></i>\
          <span class="tab-label">我</span>\
        </a>\
      </nav>\
    </div>\
      ',
  data: function() {
    return {};
  },
  created: function() {},
  mounted: function() {
    this.highLightPage();
  },
  methods: {
    showDownloadBox: function() {
      eventBus.$emit('showDownloadBox');
    },
    highLightPage: function() {
      var links = $('#tab-bar a');
      for (var i = 0, len = links.length; i < len; i++) {
        var linkURL = links[i].getAttribute('href');
        if (window.location.href.indexOf(linkURL) !== -1) {
          $(links[i]).addClass('active');
        }
        // if (window.location.pathname == '/') {
        //   $(links[0]).addClass('active');
        // }
      }
    }
  }
});
// 下载app弹窗
Vue.component('download-box', {
  template: '<div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">\
        <div @click="hideBox" class="layershade"></div>\
        <div class="layermain">\
          <div v-show="remarkIsShow" class="thirdLayerIn anim-scale download-box" id="download-app">\
            <h3 class="title">{{msgData.title}}<i @click="hideBox" class="icons icon-close"></i></h3>\
            <div class="content">{{msgData.content}}</div>\
            <div class="btn-group">\
              <a class="btn2 btn-down" href="https://a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">下载艺术者APP</a>\
            </div>\
          </div>\
        </div>\
      </div>\
      ',
  data: function() {
    return {
      remarkIsShow: false, //提醒弹窗是否显示
      boxIsShow: false, //弹窗蒙层是否显示
      msgData: {
        title: '艺术者提示',
        content: '',
        isShowBtns: false
      }
    };
  },
  created: function() {},
  mounted: function() {
    eventBus.$on('showDownloadBox', function(msg) { //{}
      this.showBox(msg);
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function(msg) {
      this.msgData.content = msg ? msg : '下载艺术者APP即可互动';
      this.boxIsShow = true;
      this.remarkIsShow = true;
    },
    confirm: function() {
      var that = this;
      var data = {
        id: this.id,
        type: this.type
      };
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.remarkIsShow = false;
    },
    cancel: function() {
      this.hideBox();
    },
  }
});
// 分享弹窗
Vue.component('share-box', {
  template: '<div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">\
        <div @click="hideBox" class="layershade"></div>\
        <div class="layermain">\
          <div @click="hideBox" v-show="remarkIsShow" class="share"></div>\
        </div>\
      </div>\
      ',
  data: function() {
    return {
      remarkIsShow: false, //提醒弹窗是否显示
      boxIsShow: false, //弹窗蒙层是否显示
      msgData: {
        title: '',
        content: '',
        isShowBtns: false
      }
    };
  },
  created: function() {},
  mounted: function() {
    eventBus.$on('showShareBox', function() { //{}
      this.showBox();
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showBox: function() {
      this.boxIsShow = true;
      this.remarkIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.remarkIsShow = false;
    }
  }
});

// 禁止iOS客户端两个指头缩放
function noZoom() {
  document.addEventListener('touchstart', function(event) {
    if (event.touches.length > 1) {
      event.preventDefault();
    }
  })
  var lastTouchEnd = 0;
  document.addEventListener('touchend', function(event) {
    var now = (new Date()).getTime();
    if (now - lastTouchEnd <= 300) {
      event.preventDefault();
    }
    lastTouchEnd = now;
  }, false)
}

// 百度统计
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?5ac1548948569ad5fe7d032ae56883a1";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
// 谷歌统计
// (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
// (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
// m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
// })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
// ga('create', 'UA-96560910-1', 'auto');
// ga('send', 'pageview');
// if (Swiper) {
//   var mySwiperH = new Swiper("#swiper-container-t", {
//     loop: true,
//     autoplay: 4000,
//     speed:1000,
//     slidesPerView: "auto",
//     pagination : '#swiper-pagination-t',
//     paginationClickable: true,
//     centeredSlides: !0,
//     observer:true,         //修改swiper自己或子元素时，自动初始化swiper
//     observeParents:true,   //修改swiper的父元素时，自动初始化swiper
//   });
// }
//公用组件
// Vue.component('fix-download-app', {
//   template: '\
//     <div class="appDown" id="j_appDown">\
//       <div class="appDown-in fix">\
//         <div class="appDown-logo"></div>\
//         <a href="https://a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">\
//           <div class="appDown-txt">\
//             <h3>艺术者APP</h3>\
//             <p>专注手绘艺术，遇见你的品味</p>\
//           </div>\
//           <div class="btn btn-down"><i class="icons icon-downloadapp-s"></i>立即下载</div>\
//         </a>\
//       </div>\
//     </div>\
//   ',
//   props: ['isShow', 'list'],
//   methods: {
//     // 不是直接更新值，而是使用此方法来对输入值进行格式化和位数限制
//     updateValue: function (value) {
//       var formattedValue = value
//         // 删除两侧的空格符
//         .trim()
//         // 保留 2 小数位
//         .slice(0, value.indexOf('.') + 3)
//       // 如果值不统一，手动覆盖以保持一致
//       if (formattedValue !== value) {
//         this.$refs.input.value = formattedValue
//       }
//       // 通过 input 事件发出数值
//       this.$emit('input', Number(formattedValue))
//     }
//   }
// })
