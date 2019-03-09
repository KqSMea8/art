/**
 * API接口代理，WEB页面调用，转接入API接口
 */
//避免 CSRF 攻击
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


(function() {
  var _getCookie = function(key) {
    var arr, reg = new RegExp("(^| )" + key + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg)) {
      return unescape(arr[2]);
    } else {
      return null;
    }
  }
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
  // 一级域名
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
    _setCookie1('web_token', undefined, 0);
    _set('web_token', undefined, 0);
  }
  var _getUnixTimestamp = function() {
    var timestamp = Date.parse(new Date());
    return timestamp.toString().substring(0, timestamp.toString().length - 3)
  }
  var _getSecret = function(timestamp, randStr) {
    var key = 'artzhe_' + _getFormatDate('yyyyMMdd');
    return md5(md5(timestamp) + md5(key) + md5(key + timestamp + randStr + key));
  }
  var _getRandString = function(len) {
    var len = len || 32;　　
    var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';　　
    var maxPos = chars.length;　　
    var pwd = '';　　
    for (i = 0; i < len; i++) {　　　　
      pwd += chars.charAt(Math.floor(Math.random() * maxPos));　　
    }　　
    return pwd;
  }
  var _getFormatDate = function(fmt) {
    var date = new Date();
    var o = {
      "M+": date.getMonth() + 1, //月份
      "d+": date.getDate(), //日
      "h+": date.getHours(), //小时
      "m+": date.getMinutes(), //分
      "s+": date.getSeconds(), //秒
      "q+": Math.floor((date.getMonth() + 3) / 3), //季度
      "S": date.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (date.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
      if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
  }
  artzheAgent = {
    domin: window.location.protocol + '//' + window.location.host,

    call: function(route, data, func, errorFunc) {
      var sel = this;

      var api = sel.domin + '/api/' + route ;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103' || response.code == '30102') {
            _deleteCookie('web_token', undefined, 0);
            setTimeout(function (argument) {
             // return window.location.href = '/passport/logout';
            }, 100);
          }
          return func(response);
        },
        error: function(xhr, type) {
          if (typeof errorFunc == "function") {
            return errorFunc();
          }
        }
      });
    },
    call2: function(route, data, func, errorFunc) {
      var sel = this;

      var api = sel.domin + '/V2/' + route ;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103' || response.code == '30102') {
            _deleteCookie('web_token', undefined, 0);
            //return window.location.href = '/passport/logout';
          }
          return func(response);
        },
        error: function(xhr, type) {
          if (typeof errorFunc == "function") {
            return errorFunc();
          }
        }
      });
    },
    call20: function(route, data, func, errorFunc) {
      var sel = this;

      var api = sel.domin + '/V20/' + route ;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103' || response.code == '30102') {
            _deleteCookie('web_token', undefined, 0);
            //return window.location.href = '/passport/logout';
          }
          return func(response);
        },
        error: function(xhr, type) {
          if (typeof errorFunc == "function") {
            return errorFunc();
          }
        }
      });
    },
    call22: function(route, data, func, errorFunc) {
      var sel = this;

      var api = sel.domin + '/V22/' + route ;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103' || response.code == '30102') {
            _deleteCookie('web_token', undefined, 0);
            //return window.location.href = '/passport/logout';
          }
          return func(response);
        },
        error: function(xhr, type) {
          if (typeof errorFunc == "function") {
            return errorFunc();
          }
        }
      });
    },
    call30: function(route, data, func, errorFunc) {
      var sel = this;

      var api = sel.domin + '/V30/' + route ;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103' || response.code == '30102') {
            _deleteCookie('web_token', undefined, 0);
            //return window.location.href = '/passport/logout';
          }
          return func(response);
        },
        error: function(xhr, type) {
          if (typeof errorFunc == "function") {
            return errorFunc();
          }
        }
      });
    },
    call31: function(route, data, func, errorFunc) {
      var sel = this;

      var api = sel.domin + '/V31/' + route ;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103' || response.code == '30102') {
            _deleteCookie('web_token', undefined, 0);
            //return window.location.href = '/passport/logout';
          }
          return func(response);
        },
        error: function(xhr, type) {
          if (typeof errorFunc == "function") {
            return errorFunc();
          }
        }
      });
    },
    callMP: function(route, data, func, errorFunc) {
      var sel = this;

      var api = sel.domin + '/mp/' + route ;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103' || response.code == '30102') {
            _deleteCookie('web_token', undefined, 0);
            //return window.location.href = '/passport/logout';
          }
          return func(response);
        },
        error: function(xhr, type) {
          if (typeof errorFunc == "function") {
            return errorFunc();
          }
        }
      });
    }
  }
})()