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
    <title>文章内容</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=0.0.2">
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
      #hold {height: 0;}
    </style>
  </head>
  <body>
    <div id="wit" class="wrap view">
    </div>
    <div id="hold"></div>
  </body>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript">
    !function(a,b,c,d){var e=a(b);a.fn.lazyload=function(f){function g(){var b=0;i.each(function(){var c=a(this);if(!j.skip_invisible||c.is(":visible"))if(a.abovethetop(this,j)||a.leftofbegin(this,j));else if(a.belowthefold(this,j)||a.rightoffold(this,j)){if(++b>j.failure_limit)return!1}else c.trigger("appear"),b=0})}var h,i=this,j={threshold:0,failure_limit:0,event:"scroll",effect:"show",container:b,data_attribute:"original",skip_invisible:!1,appear:null,load:null,placeholder:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"};return f&&(d!==f.failurelimit&&(f.failure_limit=f.failurelimit,delete f.failurelimit),d!==f.effectspeed&&(f.effect_speed=f.effectspeed,delete f.effectspeed),a.extend(j,f)),h=j.container===d||j.container===b?e:a(j.container),0===j.event.indexOf("scroll")&&h.bind(j.event,function(){return g()}),this.each(function(){var b=this,c=a(b);b.loaded=!1,(c.attr("src")===d||c.attr("src")===!1)&&c.is("img")&&c.attr("src",j.placeholder),c.one("appear",function(){if(!this.loaded){if(j.appear){var d=i.length;j.appear.call(b,d,j)}a("<img />").bind("load",function(){var d=c.attr("data-"+j.data_attribute);c.hide(),c.is("img")?c.attr("src",d):c.css("background-image","url('"+d+"')"),c[j.effect](j.effect_speed),b.loaded=!0;var e=a.grep(i,function(a){return!a.loaded});if(i=a(e),j.load){var f=i.length;j.load.call(b,f,j)}}).attr("src",c.attr("data-"+j.data_attribute))}}),0!==j.event.indexOf("scroll")&&c.bind(j.event,function(){b.loaded||c.trigger("appear")})}),e.bind("resize",function(){g()}),/(?:iphone|ipod|ipad).*os 5/gi.test(navigator.appVersion)&&e.bind("pageshow",function(b){b.originalEvent&&b.originalEvent.persisted&&i.each(function(){a(this).trigger("appear")})}),a(c).ready(function(){g()}),this},a.belowthefold=function(c,f){var g;return g=f.container===d||f.container===b?(b.innerHeight?b.innerHeight:e.height())+e.scrollTop():a(f.container).offset().top+a(f.container).height(),g<=a(c).offset().top-f.threshold},a.rightoffold=function(c,f){var g;return g=f.container===d||f.container===b?e.width()+e.scrollLeft():a(f.container).offset().left+a(f.container).width(),g<=a(c).offset().left-f.threshold},a.abovethetop=function(c,f){var g;return g=f.container===d||f.container===b?e.scrollTop():a(f.container).offset().top,g>=a(c).offset().top+f.threshold+a(c).height()},a.leftofbegin=function(c,f){var g;return g=f.container===d||f.container===b?e.scrollLeft():a(f.container).offset().left,g>=a(c).offset().left+f.threshold+a(c).width()},a.inviewport=function(b,c){return!(a.rightoffold(b,c)||a.leftofbegin(b,c)||a.belowthefold(b,c)||a.abovethetop(b,c))},a.extend(a.expr[":"],{"below-the-fold":function(b){return a.belowthefold(b,{threshold:0})},"above-the-top":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-screen":function(b){return a.rightoffold(b,{threshold:0})},"left-of-screen":function(b){return!a.rightoffold(b,{threshold:0})},"in-viewport":function(b){return a.inviewport(b,{threshold:0})},"above-the-fold":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-fold":function(b){return a.rightoffold(b,{threshold:0})},"left-of-fold":function(b){return!a.rightoffold(b,{threshold:0})}})}(jQuery,window,document);

    !function(){var a=jQuery.event.special,b="D"+ +new Date,c="D"+(+new Date+1);a.scrollstart={setup:function(){var c,d=function(b){var d=this,e=arguments;c?clearTimeout(c):(b.type="scrollstart",jQuery.event.dispatch.apply(d,e)),c=setTimeout(function(){c=null},a.scrollstop.latency)};jQuery(this).bind("scroll",d).data(b,d)},teardown:function(){jQuery(this).unbind("scroll",jQuery(this).data(b))}},a.scrollstop={latency:300,setup:function(){var b,d=function(c){var d=this,e=arguments;b&&clearTimeout(b),b=setTimeout(function(){b=null,c.type="scrollstop",jQuery.event.dispatch.apply(d,e)},a.scrollstop.latency)};jQuery(this).bind("scroll",d).data(c,d)},teardown:function(){jQuery(this).unbind("scroll",jQuery(this).data(c))}}}();
  </script>
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

    var route = 'MobileGetH5/getArticleContent';
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
          var content = res.data.info.article.content.replace(/([a-z]*-*[a-z]+:\s*[0-9]+)px/g, '$1/75rem');
          var el = document.createElement('div');
          el.innerHTML = content;
          var $el = $(el);
          var imgs = $el.find('img');
          imgNum = $("img").length,

          imgs.each(function () {
            var src = $(this).attr("src");
            $(this).attr("data-original", src);
            // $(this).addClass("lazy");
            $(this).attr('src', '/Public/image/holder.png');
          });

          content = el.innerHTML;
          document.getElementById('wit').innerHTML = content;
          var $imgList = $('#wit img');

          setTimeout(function () {
            // body...
          }, 300);

          $("img").lazyload({
　　　　　　event: "scrollstop", //滚动加载
　　　　　　effect : "fadeIn" //淡入
  　　　　});
          $imgList.click(function(event) { //绑定图片点击事件
            var index = $imgList.index(this);

            window.location.href = 'image-preview:' + index;
          });
        }
      }
    });

  </script>
</html>
