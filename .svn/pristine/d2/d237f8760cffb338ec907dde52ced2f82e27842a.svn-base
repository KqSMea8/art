<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>跳转中</title>
  </head>
  <body>
    跳转中。。。
  </body>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/js/service/agent.js?v=2.1.6"></script>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <script charset="utf-8">
    window.onload = function(){
      var that=this;
      artzheAgent.callMP('Agency/ChangeLoginToRealIdentity', {}, function (res) {
        if (res.code == 30000) {
          if (res.code == 30000) {
            artzheAgent.call('UserCenter/getMyGalleryDetail', {}, function (res) {

              deleteCookie('userType');
              deleteCookie('userid');
              deleteCookie('userName');
              deleteCookie('userFace');
              deleteCookie('userMobile');
              if (res.code == 30000) {
                var resInfo = res.data.info;
                that.myInfo = {
                  uid: res.data.info.artist,
                  name: res.data.info.name,
                  face: res.data.info.faceUrl
                };
                var userType = -1;
                if (res.data.info.isArtist == '1') { //艺术家
                  userType = 1;
                } else if (res.data.info.isAgency == '1') { //艺术机构
                  userType = 2;
                } else if (res.data.info.isPlanner == '1') { //策展人
                  userType = 3;
                } else { //普通用户
                  userType = -1;
                }
                setCookie('userid', res.data.info.artist);
                setCookie('userName', res.data.info.name);
                setCookie('userFace', res.data.info.faceUrl);
                setCookie('userMobile', res.data.info.mobile);
                setCookie('userType', userType);
                _setCookie('temporaryLogin', 0); //切换登录用户
                window.location = '/artorganization/arter'; //跳转到艺术家管理

              } else {
                deleteCookie('userid');
                deleteCookie('userName');
                deleteCookie('userFace');
                deleteCookie('userMobile');
              }
              // that.floading = false;
            });
          }
        }
      })
    }
  </script>
</html>
