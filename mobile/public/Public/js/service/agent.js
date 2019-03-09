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
  var _setCookie = function(key, value, expiredays) {
    var exdate = new Date()
    exdate.setDate(exdate.getDate() + expiredays)
    document.cookie = key + "=" + escape(value) +
      ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; path=/";
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
    _getToken: function(func) {
      if (!_getCookie('apiToken')) {
        var api = this.domin + '/api/user/getToken';
        $.ajax({
          type: 'POST',
          url: api,
          dataType: 'json',
          async: false,
          beforeSend: function(XMLHttpRequest) {
            var timestamp = _getUnixTimestamp();
            var randStr = _getRandString(16);
            var secret = _getSecret(timestamp, randStr);
            XMLHttpRequest.setRequestHeader('X-Artzhe-Time', timestamp);
            XMLHttpRequest.setRequestHeader('X-Artzhe-Nonce', randStr);
            XMLHttpRequest.setRequestHeader('X-Artzhe-Sign', secret);
          },
          success: function(response) {
            if (response.code = '30000') {
              _setCookie('apiToken', response.data.token);
              typeof func == 'function' && func();
            } else {
              throw new Exception(response.message);
            }
          }
        });
      }
      return _getCookie('apiToken');
    },
    call: function(route, data, func, errorFunc) {
      var sel = this;
      var token = sel._getToken();
      // var api = sel.domin + '/V2/' + route + '?token=' + token;
      var api = sel.domin + '/V2/' + route;
      $.ajax({
        url: api, //修改密码
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
    call1: function(route, data, func, errorFunc) {
      var sel = this;
      var token = sel._getToken();
      // var api = sel.domin + '/api/' + route + '?token=' + token;
      var api = sel.domin + '/api/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call1(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
      var token = sel._getToken();
      // var api = sel.domin + '/V2/' + route + '?token=' + token;
      var api = sel.domin + '/V2/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call2(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
      var token = sel._getToken();
      // var api = sel.domin + '/V20/' + route + '?token=' + token;
      var api = sel.domin + '/V20/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call20(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
      var token = sel._getToken();
      // var api = sel.domin + '/V22/' + route + '?token=' + token;
      var api = sel.domin + '/V22/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call22(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
    call32: function(route, data, func, errorFunc) {
      var sel = this;
      var token = sel._getToken();
      // var api = sel.domin + '/V32/' + route + '?token=' + token;
      var api = sel.domin + '/V32/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call32(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
    call42: function(route, data, func, errorFunc) {
      var sel = this;
      var token = sel._getToken();
      // var api = sel.domin + '/V42/' + route + '?token=' + token;
      var api = sel.domin + '/V42/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call42(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
    call43: function(route, data, func, errorFunc) {
      var sel = this;
      var token = sel._getToken();
      // var api = sel.domin + '/V43/' + route + '?token=' + token;
      var api = sel.domin + '/V43/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call42(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
    call44: function (route, data, func, errorFunc) {
      var sel = this;
      var token = sel._getToken();
      // var api = sel.domin + '/V43/' + route + '?token=' + token;
      var api = sel.domin + '/V44/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function (response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call42(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
          }
          return func(response);
        },
        error: function (xhr, type) {
          if (typeof errorFunc == "function") {
            return errorFunc();
          }
        }
      });
    },
    callM: function(route, data, func, errorFunc) {
      var sel = this;
      var token = sel._getToken();
      // var api = sel.domin + '/M/' + route + '?token=' + token;
      var api = sel.domin + '/M/' + route;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);

            sel._getToken(function () {
              sel.call42(route, data, func, errorFunc);
            });
            // return window.location.href = '/passport/logout';
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
