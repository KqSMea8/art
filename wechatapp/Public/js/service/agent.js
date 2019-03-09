/**
 * API接口代理，WEB页面调用，转接入API接口
 */
var apiDomin = '//api.artzhe.com';
function checkApiDomin() {
  var str1 = window.location.host.split('.')[0];
  if (str1.indexOf('test') >= 0) {
    apiDomin = '//test-api.artzhe.com';
  } else if (str1.indexOf('local') >= 0) {
    apiDomin = '//local-api.artzhe.com';
  } else if (str1.indexOf('dev') >= 0) {
    apiDomin = '//dev-api.artzhe.com';
  } else {
    apiDomin = '//api.artzhe.com';
  }
}
checkApiDomin();

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
  var _setCookie = function(key, value, expiredays) {
    var exdate = new Date()
    exdate.setDate(exdate.getDate() + expiredays)
    document.cookie = key + "=" + escape(value) +
      ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; domain=" + GetCookieDomain() + "; path=/";
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
    // domin: window.location.protocol + '//' + window.location.host,
    domin: apiDomin,
    _getToken: function(func) {
      if (!_getCookie('apiToken')) {
        var api = this.domin + '/api/user/getToken';
        // var api = 'https://test-api.artzhe.com/Public/Home/image/logo.png';
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
              _setCookie('apiToken', response.data.token)
            } else {
              throw new Exception(response.message);
            }
          }
        })
      }
      return _getCookie('apiToken');
    },
    call: function(route, data, func, errorFunc) {
      var sel = this;
      var token = sel._getToken();
      var api = sel.domin + '/api/' + route + '?token=' + token;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);
            return window.location.href = '/passport/logout';
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
      var api = sel.domin + '/V2/' + route + '?token=' + token;
      $.ajax({
        url: api, //请求地址
        type: 'POST',
        dataType: "json",
        data: data,
        success: function(response) {
          if (response.code == '30103') {
            _setCookie('apiToken', undefined, 0);
            return window.location.href = '/passport/logout';
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