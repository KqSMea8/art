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
    <title>万圣占星馆</title>
  </head>
  <script>   
  (function(){ 
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
    var url = switchDomin('www') + '/Api/WechatLicense/ScanCode';
    window.location.replace(url);
    window.location.href = url;  
  })();  
  
</script>
  <body>

  </body>
</html>