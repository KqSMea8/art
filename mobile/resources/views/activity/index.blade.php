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
    <title>测测你的审美性格</title>
  </head>
  <script>   
(function(){ 
  var host = window.location.host;
  var link = window.location.protocol + '//api.artzhe.com/v2/active/shenmei';
      if (host.indexOf('test') > -1) {
        link = window.location.protocol + '//test-api.artzhe.com/v2/active/shenmei';
      }  
    window.location.href = link;  
})();  
  
</script>
  <body>

  </body>
</html>