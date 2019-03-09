<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,height=device-height,user-scalable=no,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="format-detection" content="telephone=no">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <title>消息</title>
  <link href="/Public/css/reset.css" type="text/css" rel="stylesheet" />
  <link href="/Public/css/msgIndex.css" type="text/css" rel="stylesheet" />
</head>

<body>
  <div class="messageBox">
    <!-- 商品链接 -->
    <div class="goodsLins">
      <a href="javascript:;">
        <div class="mgoodsBox clear">
          <img src="" alt="" title='111' class="mImg">
          <div class="messageRight">
            <p class="mTitle"></p>
            <p class="mDesc overflowline2"></p>
          </div>
        </div>
      </a>
    </div>
    <!-- 消息列表 -->
    <div class="messageList">
      <ul class="mesListBox">
        <!-- <li class="mesItem clear">
          <img src="" alt="" class="mesTouxiang">
          <div class="mesText">
            <p class="mesName">尽头</p>
            <p class="mesTime">2018-01-10 5:25</p>
            <p class="mesHuifu">温鸥，你好！我想了解一下这副作品加的是什 么框呢?我想购买。</p>
          </div>
        </li> -->

      </ul>
      <div class="moreList">查看更多</div>
      <div class="noMoreList ishide">没有更多了！</div>
    </div>
    <!-- 发送消息 -->
    <div class="sendMessage">
      <input type="text" class="msgInput" name="" value="" placeholder="请输入你的消息">
      <button type="button" class="msgSend" name="button">发送</button>
    </div>
  </div>

  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="/Public/js/plugins/fastclick.js"></script>
  <script type="text/javascript">
    $(function() {
      FastClick.attach(document.body);


      var uobj = getUrlkey(window.location.href); // 将获取的参数对象化
      var msgToken = uobj.h5_token; // 获取传过来的token
      var huaId = uobj.huaId; // 传过来的画作id
      var zixunId = uobj.zixunId; // 获取传过来的卖家id

      // TODO: token获取
      if (!msgToken) {
        getUrlkey(window.location.href);
      } else {
        getlist(0);
      };

      var flag = true; // 阻止重复点击发送按钮
      $('.msgSend').on('click', function() { // 点击发送按钮
        flag = false;
        var inputMsg = $('.msgInput').val(); // 获取到用户输入的消息
        if (inputMsg.replace(/(^\s*)|(\s*$)/g, "") == '') { // 输入内容为空或空格时，阻止发送
          return
        };

        if (flag != false) { // 阻止重复点击发送按钮
          return
        };
        $.ajax({
          url: '/V40/MobileGetH5/consultationAndReply',
          type: 'post',
          data: {
            h5_token: msgToken,
            artworkId: huaId,
            userTo: zixunId,
            content: inputMsg
          },
          dataType: 'json',
          success: function(data) {
            console.log('发送：')
            console.log(data.data.info.userInfo)
            flag = true; // 可点击发送按钮
            $('.msgInput').val(''); // 成功后置空输入框

            var str = '';
            // $.each(data.data.info.userInfo, function(index, val) { //将返回的数据填充到列表
              str = '<li class="mesItem clear" data-uid="'+data.data.info.userInfo.id+'">' +
                '<img src="' + data.data.info.userInfo.face + '" alt="" class="mesTouxiang">' +
                '<div class="mesText">' +
                '<p class="mesName">' + data.data.info.userInfo.name + '</p>' +
                '<p class="mesTime">' + data.data.info.create_time + '</p>' +
                '<p class="mesHuifu">' + data.data.info.content + '</p>' +
                '</div>' +
                '</li>';
            // });
            $('.mesListBox').prepend(str); // 将数据插入到前面
          },
          error: function(err) {
            flag = true; // 可点击发送按钮
            alert(err)
          }
        })

      });

      var maxpage=''; // 最大页数
      nowPage=1; // 当前页数
      $('.moreList').on('click',function(){ // 点击加载更多时
        nowPage++;
        getlist(nowPage);
        if(nowPage>=maxpage){
          $('.moreList').addClass('ishide'); // 隐藏加载更多
          $('.noMoreList').removeClass('ishide'); // 显示无更多消息
          return
        }
      })
      function getlist(id){
        $.ajax({
          url: '/V40/MobileGetH5/getUserConsultation',
          type: 'post',
          data: {
            h5_token: msgToken,
            artworkId: huaId,
            userTo: zixunId,
            page:id,
            pagesize:10
          },
          dataType: 'json',
          success: function(data) {
            // var goodsLink = '';
            console.log('获取列表')
            console.log(data)
            maxpage = data.data.consultationInfo.maxpage;
            // if(data.data.consultationInfo.maxpage>1){
            //   $('.moreList').removeClass('ishide'); // 最大页数大于1，则显示加载更多按钮
            // };
            var str = '';
            // $.each(data.data.artworkInfo, function(index, val) {
            //   goodsLins = '<a href="javascript:;">'
            //   '<div class="mgoodsBox clear">'
            //   '<img src="" alt="" class="mImg">'
            //   '<div class="messageRight">'
            //   '<p class="mTitle">温鸥《复古》温鸥《复古》温鸥《复古》温鸥《复古》温鸥《复古》温鸥《复古》</p>'
            //   '<p class="mDesc overflowline2"></p>'
            //   '</div>'
            //   '</div>'
            //   '</a>'
            // })
            // $('.goodsLins').append(goodsLink)
            //

            //顶部商品填充
            $('.mImg').attr('src',data.data.artworkInfo.cover);
            $('.mImg').attr('title', data.data.artworkInfo.artlistName);
            $('.mTitle').html(data.data.artworkInfo.artworkName);
            $('.mDesc').html(data.data.artworkInfo.story);

            //消息列表获取
            $.each(data.data.consultationInfo.data, function(index, val) { // 获取列表信息，填充
              str += '<li class="mesItem clear" data-id="' + val.id + '">' +
              '<img src="' + val.userInfo.face + '" alt="" class="mesTouxiang">' +
              '<div class="mesText">' +
              '<p class="mesName">' + val.userInfo.name + '</p>' +
              '<p class="mesTime">' + val.create_time + '</p>' +
              '<p class="mesHuifu">' + val.content + '</p>' +
              '</div>' +
              '</li>';
            });
            $('.mesListBox').append(str);
          },
          error: function(err) {
            console.log(err)
          }
        })
      }
      // 检测浏览器类型
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
      };

      // 将地址栏参数转为对象格式
      function getUrlkey(url) {
        var params = {},
          arr = url.split("?");
        if (arr.length <= 1)
          return params;
        arr = arr[1].split("&");
        for (var i = 0, l = arr.length; i < l; i++) {
          var a = arr[i].split("=");
          params[a[0]] = a[1];
        }
        return params;
      };



    })
  </script>
</body>

</html>
