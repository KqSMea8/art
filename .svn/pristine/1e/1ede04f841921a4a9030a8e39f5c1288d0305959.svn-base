<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <meta content="telephone=no,email=no" name="format-detection">
    <title>单次更新内容</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=0.0.1">
    <style type="text/css">
      html {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        line-height: 1.5
      }
      body {
        -webkit-touch-callout: none;
        font-family: -apple-system-font, 'PingFang SC Medium', 'Heiti SC', 'Helvetica', 'HelveticaNeue', 'Droidsansfallback', "Droid Sans", 'Dengxian', 'Segoe', 'microsoft yahei', sans-serif;
        line-height: inherit
      }
    </style>
  </head>
  <body>
    <div id="wit" class="wrap view">
    </div>
  </body>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript">
    // 获取URL中的id /artwork/update/150?from=singlemessage
    function GetLocationId() {
      var path = window.location.pathname; //获取url中路径
      var ids = path.split('/');
      var id = ids[ids.length-1];
      return id;
    }

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

    var data = {
      h5_token: GetRequest().h5_token,
      id: GetLocationId()
    }

    var route = 'MobileGetH5/getupdateWit';
    var api = window.location.origin + '/V20/' + route;

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: api,
      data: data,
      success: function(res) {
        if (res.code == 30000) {
          //2018.06.11 return value + "rem";

          // var content = res.data.info.wit.replace(/(\d+)px/g, function(s, t) {
          var content = res.data.info.wit.replace(/(\d)+\.?[0-9]+(px)|(\d)+(px)/gi, function(s, t) {
            s = s.replace('px', '');
            var value = parseInt(s) * 0.0266667;//   此处 1rem = 75px
            return value + "rem";
          });

          document.getElementById('wit').innerHTML = content;
          var $imgList = $('#wit img');
          $imgList.click(function(event) { //绑定图片点击事件
            var index = $imgList.index(this);

            window.location.href = 'image-preview:' + index;
          });
        }
      }
    });
  </script>
</html>
