//oss直传相关
//获取随机字符串--随机文件名
function random_string(len) {　　
  len = len || 32;　　
  var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';　　
  var maxPos = chars.length;　　
  var pwd = '';　　
  for (i = 0; i < len; i++) {　　
    pwd += chars.charAt(Math.floor(Math.random() * maxPos));
  }
  return pwd;
}

//获取文件名后缀
function get_suffix(filename) {
  var pos = filename.lastIndexOf('.'),
    suffix = '';
  if (pos != -1) {
    suffix = filename.substring(pos)
  }
  return suffix;
}
//直传oss对象
var ossObj = {
  accessid: '',
  accesskey: '',
  host: '',
  policyBase64: '',
  signature: '',
  callbackbody: '',
  filename: '',
  key: '',
  expire: 0,
  g_object_name: '',
  g_object_name_type: 'random_name', //'local_name'
  now: Date.parse(new Date()) / 1000,
  timestamp: Date.parse(new Date()) / 1000,
  //请求后台上传签名
  send_request: function() {
    var xmlhttp = null;
    if (window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (xmlhttp != null) {
      serverUrl = '/public/getOSS';
      xmlhttp.open("GET", serverUrl, false);
      xmlhttp.send(null);
      return xmlhttp.responseText;
    } else {
      alert("Your browser does not support XMLHTTP.");
    }
    // return '{accessid: "p0qCqg52u0rz7XaE",host: "http://post-test.oss-cn-hangzhou.aliyuncs.com",policy: "eyJleHBpcmF0aW9uIjoiMjAxNy0wNC0yN1QxNToyMToxMFoiLCJjb25kaXRpb25zIjpbWyJjb250ZW50LWxlbmd0aC1yYW5nZSIsMCwxMDQ4NTc2MDAwXSxbInN0YXJ0cy13aXRoIiwiJGtleSIsInVzZXItZGlyXC8iXV19",signature: "rstrV1kizKPr6byfHzIHnz+Pt80=",expire: 1493277670,dir: "user-dir/"}'
  },
  //上传文件名
  calculate_object_name: function(filename) {
    if (this.g_object_name_type == 'local_name') {
      this.g_object_name += "${filename}"
    } else if (this.g_object_name_type == 'random_name') {
      suffix = get_suffix(filename)
      this.g_object_name = this.key + random_string(10) + suffix
    }
    return ''
  },
  //设置上传参数
  set_upload_param: function(filename) {
    var ret = this.get_signature();
    this.g_object_name = this.key;
    if (filename != '') {
      suffix = get_suffix(filename)
      this.calculate_object_name(filename)
    }
    return new_multipart_params = {
      'key': this.g_object_name,
      'policy': this.policyBase64,
      'OSSAccessKeyId': this.accessid,
      'success_action_status': '200', //让服务端返回200,不然，默认会返回204
      // 'callback' : this.callbackbody,
      'signature': this.signature,
    };
  },
  //上传前获取签名
  get_signature: function() {
    //可以判断当前expire是否超过了当前时间,如果超过了当前时间,就重新取一下.3s 做为缓冲
    now = timestamp = Date.parse(new Date()) / 1000;
    if (this.expire < now + 3) {
      var body = this.send_request();
      var obj = eval("(" + body + ")").data;
      this.host = obj.host;
      this.policyBase64 = obj.policy;
      this.accessid = obj.accessid;
      this.signature = obj.signature;
      this.expire = parseInt(obj.expire);
      this.callbackbody = obj.callback;
      this.key = obj.dir;
      return true;
    }
    return false;
  }
};

var uploadFiles = new plupload.Uploader({
  runtimes: 'html5,flash,silverlight,html4',
  browse_button: 'selectfiles',
  //multi_selection: false,
  container: document.getElementById('container'),
  flash_swf_url: 'lib/plupload-2.1.2/js/Moxie.swf',
  silverlight_xap_url: 'lib/plupload-2.1.2/js/Moxie.xap',
  url: 'http://oss.aliyuncs.com',

  init: {
    PostInit: function() {
      document.getElementById('ossfile').innerHTML = '';
      document.getElementById('postfiles').onclick = function() {
        set_upload_param(uploader, '', false);
        return false;
      };
    },

    FilesAdded: function(up, files) {
      plupload.each(files, function(file) {
        document.getElementById('ossfile').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ')<b></b>' + '<div class="progress"><div class="progress-bar" style="width: 0%"></div></div>' + '</div>';
      });
    },

    BeforeUpload: function(up, file) {
      check_object_radio();
      get_dirname();
      set_upload_param(up, file.name, true);
    },

    UploadProgress: function(up, file) {
      var d = document.getElementById(file.id);
      d.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
      var prog = d.getElementsByTagName('div')[0];
      var progBar = prog.getElementsByTagName('div')[0];
      progBar.style.width = 2 * file.percent + 'px';
      progBar.setAttribute('aria-valuenow', file.percent);
    },

    FileUploaded: function(up, file, info) {
      if (info.status == 200) {
        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = 'upload to oss success, object name:' + get_uploaded_object_name(file.name);
      } else {
        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = info.response;
      }
    },

    Error: function(up, err) {
      document.getElementById('console').appendChild(document.createTextNode("\nError xml:" + err.response));
    }
  }
});
