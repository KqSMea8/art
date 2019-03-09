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
    <title>专题内容</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.2.3">
    <link rel="stylesheet" type="text/css" href="/Public/css/richwap.css?v=1.0.1">
    <style type="text/css">
      .wrap a[data-artzhe-type=link]{
        display: inline-block;
      }
      html {
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        line-height: 1.5;
        min-height: 100%;
        background:#fff;
      }
      body {
        min-height: 100%;
        margin: 0;
        -webkit-touch-callout: none;
        font-family: -apple-system-font, 'PingFang SC Medium', 'Heiti SC', 'Helvetica', 'HelveticaNeue', 'Droidsansfallback', "Droid Sans", 'Dengxian', 'Segoe', 'microsoft yahei', sans-serif;
        line-height: inherit;
        background:#fff;
      }
      #cover {
        width: 100%;
        /* height: 5.06667rem; */
        height:auto;
        background-size: 100% 5.06667rem;
      }
      #title {
        margin: 0;
        padding: 0.4rem 0.08rem 0.2rem 0.32rem;
        text-indent: -0.24rem;
        font-size: 0.48rem;
      }
      .wrap {
        padding: 0 0.32rem;
        word-break: break-all;
        /*font-size: 16px;*/
        font-size: 0.4rem;
        line-height: 1.6;
      }
      .wrap img {
        /*display: inline-block;*/
      }
      .interact{
        margin-top: 0.16rem;
      }
      /*喜欢列表*/
      .liker {
        position: relative;
        padding: 0.52rem 0.4rem;
        margin-bottom: 0.16rem;
        background-color: #fff;
        border-top: 1px solid #eee;
      }
      .liker .icons {
        width: 0.92rem;
        height: 0.68rem;
      }
      .liker .icons.icon-like {
        background-position: -4.06667rem -9.17333rem;
      }
      .liker .icons.icon-liked {
        background-position: -4.06667rem -8.17333rem;
      }
      .liker .like {
        float: left;
        padding-right: 0.32rem;
        height: 0.68rem;
        font-size: 0.32rem;
        color: #999;
        line-height: 0.68rem;
        border-right: 1px solid #eee;
      }
      .liker .likers {
        margin-left: 0.08rem;
        float: left;
      }
      .liker .likers li {
        position: relative;
        float: left;
        margin-left: 0.08rem;
      }
      .liker .likers .num {
        position: absolute;
        top: 0;
        left: 0;
        width: 0.68rem;
        height: 0.68rem;
        font-size: 0.26667rem;
        line-height: 0.68rem;
        text-align: center;
        color: #fff;
        background-color: rgba(0,0,0, .3);
        border-radius: 50%;
      }
      .liker img {
        height: 0.68rem;
        width: 0.68rem;
        vertical-align: top;
        border: 1px solid #dedede;
        border-radius: 50%;
      }
      /*喜欢列表 end */

      /* 评论 */
      .interact .btn-group {
        padding-top: 0.16rem;
        padding-bottom: 0.32rem;
        text-align: center;
        background-color: #fff;
      }
      .interact .btn-group .btnx {
        display: inline-block;
        width: 9.2rem;
        height: 1.17333rem;
        line-height: 1.17333rem;
        font-size: 0.42667rem;
        text-align: center;
        color: #333;
        border-radius: 0.12rem;
      }
      .interact .btn-see {
        border: 1px solid #bebebe;
      }
      .interact .btn-comment {
        background-color: #f4bb21;
      }
      .comments {
        position: relative;
        background-color: #fff;
      }
      .comments h2 {
        padding: 0 0.3rem;
        height: 0.92rem;
        line-height: 0.92rem;
        font-size: 0.32rem;
        font-weight: normal;
        color: #999;
        border-bottom: 1px solid #eee;
      }
      .comments h2 .icons {
        height: 0.92rem;
        width: 0.6rem;

      }
      .comments h2 .icons.icon-comment {
        background-position: -3.24rem -8.04rem;
      }
      .comment-holder {
        padding-top: 0.64rem;
        text-align: center;
        font-size: 0.32rem;
        color: #999;
        background-color: #fff;
      }
      .comment-holder .img-wrap img {
        width: 2.45333rem;
        height: 1.48rem;
      }
      .comment-holder .img-wrap p{
        padding-top: 0.32rem;
        padding-bottom: 0.6rem;
      }
      .comments .comment-list {
        padding: 0.4rem 0.4rem 0.65333rem;
      }
      .comments .comment {
        padding: 0.26667rem 0.4rem;
        font-size: 0.36rem;
        line-height: 0.45rem;
        color: #666;
        border-bottom: 1px solid #eee;
      }
      .comments .comment:last-of-type {
        border-bottom: none;
      }
      .comment .user-com, .comment .painter-com {
        position: relative;
        margin-left: 0.73333rem;
      }
      .user-com .avatar {
        position: absolute;
        left: -0.73333rem;
        top: -0.08rem;
        width: 0.6rem;
        height: 0.6rem;
        border-radius: 50%;
      }
      .user-com .com {
        position: relative;
        margin-top: 0.24rem;
        width: 6.8rem;
        font-size: 0.37333rem;
        color: #666;
        word-break: normal;
        word-wrap: break-word;
      }
      .comment .name {
        display: inline;
        font-size: 0.42667rem;
      }
      .comment .time {
        display: inline-block;
        padding-left: 0.36rem;
        font-size: 0.32rem;
        color: #999;
      }
      .comment .painter-com .time {
        position: absolute;
        right: -1.62rem;
        padding-left: 0;
      }
      .comment .icon-r {
        float: right;
        color: #999;
      }
      .comment .painter-com {
        position: relative;
        padding-top: 0.10667rem;
        width: 6.8rem;
        font-size: 0.37333rem;
      }
      .comment .painter-com .name, .comment .painter-com span {
        position: relative;
        margin-right: -0.08rem;
        word-break: normal;
        word-wrap: break-word;
      }
      .comment .painter-com .name::before {
        content: '';
        position: absolute;
        left: -0.2rem;
        top: 0.16rem;
        width: 0.10667rem;
        height: 0.10667rem;
        border-radius: 50%;
        background-color: #eaab32;
      }
      .painter-com .com {
        padding-left: 0.1rem;
      }
      .btn-re {
        position: absolute;
        right: -1.66rem;
        bottom: 0;
        display: inline-block;
        padding: 0.08rem 0.16rem;
        font-size: 0.32rem;
        line-height: 1;
        text-align: center;
        color: #999;
        border-radius: 0.06667rem;
        border: 1px solid #cacaca;
      }
      /* 评论 end */
    </style>
  </head>
  <body>

    <!-- <div id="cover"></div> -->
    <img id="cover" src="" alt="">
    <h1 id="title"></h1>
    <div id="wit" class="wrap view"></div>
      <div id="reply" v-cloak>

        <div class="interact">
          <div class="liker fix">
            <div class="like" @click="toggleLike">
              <i :class="['icons', update.is_like==1?'icon-liked': 'icon-like']"></i>
            </div>
            <ul class="likers fix">
              <li v-for="(item, index) in update.likes">
                <img :src="item">
                <p v-if="update.like_total > 10 & index == '9'" class="num">@{{update.like_total}}</p>
              </li>
            </ul>
          </div>
          <ul v-if="update.commentList.length > 0" class="comments">
            <h2>
              <i class="icons icon-comment"></i>
              @{{update.commentTotal}}条评论
            </h2>
            <li class="comment" v-for="commentItem in update.commentList">
              <div class="user-com">
                <div class="icon-r" @click="toggleZan(commentItem.commentId,commentItem.isLike)">
                  <i :class="['icons', commentItem.isLike == 'Y'?'icon-praised': 'icon-praise']"></i>
                  <span v-if="commentItem.likes>0" class="label">@{{commentItem.likes}}</span>
                </div>
                <img class="avatar" :src="commentItem.faceUrl">
                <a class="name" href="javascript:;">@{{commentItem.nickname }}</a>
                <div class="time">@{{commentItem.time}}</div>

                <div class="hfbox fix">
                    <p class="com hf">@{{commentItem.content}}</p>
                </div>
              </div>
              <!-- <div class="painter-com fix" v-if="commentItem.repayContent">
                <a class="name" href="javascript:;">@{{commentItem.repayer}}</a>
                <span>回复：</span>
                <span class="com">@{{commentItem.repayContent}}</span>
                <div class="time">@{{commentItem.repayTime}}</div>
              </div> -->
            </li>
          </ul>
          <div v-if="update.commentList.length == 0" class="comment-holder">
            <div class="img-wrap">
              <img src="/Public/image/commentHolder.png">
              <p>@{{commentHolder}}</p>
            </div>
            <div class="btn-group">
              <a @click="toComment" class="btnx btn-comment">去留言</a>
            </div>
          </div>
          <div v-if="update.commentTotal > 5" class="btn-group">
            <a @click="gotoApp('artworkComment', update.id)" class="btnx btn-see">查看@{{update.commentTotal}}条评论</a>
          </div>
        </div>

      </div>
  </body>
  <!-- <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script> -->
  <script src="/Public/js/lib/jquery.min.js"></script> <!-- //1.11.3 -->
  <script src="/Public/js/lib/vue.min.js"></script>
  <script type="text/javascript">
    // 获取URL中的id /artwork/update/150?from=singlemessage
    function GetLocationId() {
      var path = window.location.pathname; //获取url中路径
      var ids = path.split('/');
      var id = ids[ids.length-1];
      return id;
    }
    // 获取图片宽高
    function getImageWidth(url,callback){
      var img = new Image();
      img.src = url;

      // 如果图片被缓存，则直接返回缓存数据
      if(img.complete){
        callback(img.width, img.height);
      }else{
        // 完全加载完毕的事件
        img.onload = function(){
          callback(img.width, img.height);
        }
      }

    }
    // 设置表情样式
    function setImgStyle ($imgList) {
      $imgList.each(function() {
        var that = $(this);
        var src = $(this).attr("src");
        getImageWidth(src,function(w,h){
          if (w <= 64) {
            that.css({width:48,height:48,display:'inline-block'});
          }
        });
      });
    }

    function n2br(str) {
      str = str.replace(/\r\n/g, "<br>");
      str = str.replace(/\r/g, "<br>");
      str = str.replace(/\n/g, "<br>");
      return str;
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

    // var data = {
    //   h5_token: GetRequest().h5_token,
    //   subid: GetLocationId()
    // }

    // var route = 'MobileGetH5/getSubjectContent';
    // var api = window.location.origin + '/V42/' + route;

    // $.ajax({
    //   headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   },
    //   type: "POST",
    //   url: api,
    //   data: data,
    //   success: function(res) {
    //     if (res.code == 30000) {
    //       var resInfo = res.data.info;
    //       document.getElementById('cover').src = resInfo.cover;
    //       //2018.06.11 /(\d)+\.?[0-9]+(px)|(\d)+(px)/gi

    //       // var content = resInfo.description.replace(/(\d+)px/g, function(s, t) {
    //       var content = resInfo.description.replace(/(\d)+\.?[0-9]+(px)|(\d)+(px)/gi, function(s, t) {
    //         s = s.replace('px', '');
    //         var value = parseInt(s) * 0.0266667;//   此处 1rem = 75px
    //         return value + "rem";
    //       });

    //       content = content.replace(/width: auto !important;/g, '');
    //       // content = n2br(content);

    //       document.getElementById('wit').innerHTML = content;
    //       document.getElementById('title').innerHTML = '【' + resInfo.sub_title + '】';
    //       // document.getElementById('cover').style.backgroundImage = "url(" + resInfo.cover + ")";

    //       var $imgList = $('#wit img');
    //       setImgStyle($imgList);

    //       $imgList.click(function(event) { //绑定图片点击事件
    //         var index = $imgList.index(this);
    //         console.log(index)
    //         var tonativedata = {
    //           api: 'previewImg',
    //           imgNum: index
    //         }
    //         jsToNative(tonativedata)
    //       });
    //     }
    //   }
    // });

    function jsToNative(ocData) {
      if (checkUA().isAndroid) {
        ocData = JSON.stringify(ocData);
        OCModel.jsCallNative(ocData);
      }

      if (checkUA().isIOS) {
        try {
          window.webkit.messageHandlers[ocData.api].postMessage(ocData);
        }
        catch (ex) {
          OCModel.jsCallNative(ocData);
          // window.location.href='previewImg://'+ocData.imgNum;
        }
      }
    };
    //检测浏览器
    function checkUA() {
      var isIOS, isAndroid;
      var ua = navigator.userAgent.toLowerCase();
      if (/iphone|ipad|ipod/.test(ua)) {
        isIOS = true;
        isAndroid = false;
      } else if (/android/.test(ua)) {
        isIOS = false;
        isAndroid = true;
      }
      return {
        isIOS: isIOS,
        isAndroid: isAndroid
      };
    };
    function checkUA2() { //浏览器ua判断
      var isIOS, isAndroid, isWeChat, isAPP;
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
      if (/artzhe/.test(ua)) {
        isAPP = true;
      }
      return {
        isIOS: isIOS,
        isAndroid: isAndroid,
        isWeChat: isWeChat,
        isAPP: isAPP
      };
    }
  </script>
  <script>
    var comVue = new Vue({
      el: '#reply',
      data: function(){
        return {
          likeClick: false,
          zanClick: false,
          isLike: false,
          updateId: '',
          update: {
            commentTotal: "", //评论总数
            is_like: 0, //是否喜欢
            like_total: "", //喜欢总数
            commentList: [],
            likes: [], //喜欢的人头像
          },
          commentHolderList: [
            '等一座城 等一个人 等你的留言',
            '最美的不是下雨天，而是你刷过的留言板',
            '留言都是爱你的形状',
            '记录此刻感受，这是一种态度，不解释！'
          ],
          commentContent: '',
          commentSubmit: false,
          commentHolder: '',
        }
      },
      created: function() {
        this.updateId = GetLocationId() || '-1';
      },
      mounted: function() {
        this.getDataList();
        // this.getCommentList();
      },
      methods: {
        getDataList: function(){ //获取内容
          var that = this;
          var data = {
            h5_token: GetRequest().h5_token,
            subid: GetLocationId()
          }

          var route = 'MobileGetH5/getSubjectContent';
          var api = window.location.origin + '/V44/' + route;

          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: api,
            data: data,
            success: function(res) {
              if (res.code == 30000) {
                var resInfo = res.data.info;
                document.getElementById('cover').src = resInfo.cover;

                that.commentHolder = that.commentHolderList[Math.floor(Math.random()*5)];
                //2018.06.11 /(\d)+\.?[0-9]+(px)|(\d)+(px)/gi

                // var content = resInfo.description.replace(/(\d+)px/g, function(s, t) {
                var content = resInfo.description.replace(/(\d)+\.?[0-9]+(px)|(\d)+(px)/gi, function(s, t) {
                  s = s.replace('px', '');
                  var value = parseInt(s) * 0.0266667;//   此处 1rem = 75px
                  return value + "rem";
                });

                content = content.replace(/width: auto !important;/g, '');
                // content = n2br(content);

                document.getElementById('wit').innerHTML = content;
                document.getElementById('title').innerHTML = '【' + resInfo.sub_title + '】';
                // document.getElementById('cover').style.backgroundImage = "url(" + resInfo.cover + ")";


                //评论点赞
                that.update.like_total = res.data.info.like_total;
                that.update.is_like = res.data.info.is_like;
                that.update.likes = res.data.info.like_list;
                that.update.commentList = res.data.info.comment_list;
                that.update.commentTotal = res.data.info.comment_total;
                //

                var $imgList = $('#wit img');
                setImgStyle($imgList);

                $imgList.click(function(event) { //绑定图片点击事件
                  var index = $imgList.index(this);
                  var tonativedata = {
                    api: 'previewImg',
                    imgNum: index
                  }
                  jsToNative(tonativedata);
                });
                //APP交互跳转 a链接
                var $consList = $('[data-artzhe-type=link]');

                //阻止默认事件函数
                function stopDefault(e) {
                  if (e && e.preventDefault)
                    e.preventDefault();
                  else
                    window.event.returnValue = false; //兼容IE
                }
                $consList.click(function(event) { //绑定链接点击事件
                  console.log(123)
                  stopDefault(event);
                  var index = $consList.index(this);
                  var type = $(this).attr('data-artzhe-typeDetail');
                  var id = $(this).attr('data-artzhe-id');

                  that.gotoApp(type, id);
                });
                that.fadeOut()
              }
            }
          });
        },
        getCommentList: function(){ ////获取评论、点赞信息
          var that = this;
          var data = {
            h5_token: GetRequest().h5_token,
            subid: GetLocationId()
          }

          var route = 'MobileGetH5/getSubjectContent ';
          var api = window.location.origin + '/V42/' + route;
          $.ajax({
            url: api,
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(res){
              if(res.code==30000){
                console.log(res.data.info)
                that.update.like_total = res.data.info.like_total;
                that.update.is_like = res.data.info.is_like;
                that.update.likes = res.data.info.like_list;
                that.update.commentList = res.data.info.comment_list;
                that.update.commentTotal = res.data.info.comment_total;

                // that.update = res.data.info;

              }
            }
          })
        },
        toggleLike: function(msg) {
          var that = this;
          var data = {
            id: this.updateId,
            type: 2
          };
          if (this.likeClick) {
            return false;
          }
          this.likeClick = true;

          $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass('anim-zooming');
          }); //放大缩小动画效果

          var ocData = {
            id: this.updateId
          };

          if (this.update.is_like == 1) {
            ocData.api = 'unlike';
          } else {
            ocData.api = 'like';
          }

          this.jsToNative(ocData);
        },
        toggleZan: function(id, isLike) {
          // return false; //屏蔽点赞功能
          var that = this;
          var ocData = {
            commentId: id
          };

          if (this.zanClick) {
            return false;
          }
          this.zanClick = true;

          $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $(this).removeClass('anim-zooming');
          }); //放大缩小动画效果

          if (isLike == 'Y') {
            ocData.api = 'unzan';
          } else {
            ocData.api = 'zan';
          }

          this.jsToNative(ocData);
        },
        toComment: function() {
          var that = this;
          var ocData = {
            api: 'comment',
            artId: this.updateId,
            type: 2,
          };

          if (this.commentSubmit) {
            return false;
          }
          this.commentSubmit = true;

          this.jsToNative(ocData);
        },
        // toRepay: function(id) {
        //   var that = this;
        //   var ocData = {
        //     api: 'repayMessage',
        //     // commentId: id
        //   };

        //   if (this.commentSubmit) {
        //     return false;
        //   }
        //   this.commentSubmit = true;

        //   this.jsToNative(ocData);
        // },
        fadeOut: function () {
          var that = this;
          var ocData = {
            api: 'fadeOut',
          };
          this.jsToNative(ocData);
          
        },
        gotoApp: function(type, id) {
          var that = this;
          var ocData = {
            api: 'link',
            type: type,
            id: id
          };

          this.jsToNative(ocData);
        },
        jsToNative: function (ocData) {
          if (checkUA().isAndroid) {
            ocData = JSON.stringify(ocData);
            OCModel.jsCallNative(ocData);
          }

          if (checkUA().isIOS) {
            try {
              window.webkit.messageHandlers[ocData.api].postMessage(ocData);
            }
            catch (ex) {
              OCModel.jsCallNative(ocData);
            }
          }
        },
        interact: function(obj) {
          var that = this;
          if (obj.api == 'unlike') { //取消喜欢
            that.likeClick = false;
            if (obj.code == 30000) {
              that.update.is_like = 0;
              var arrLikes = [];
              for (var i = 0; i < that.update.likes.length; i++) {
                if (that.update.likes[i].indexOf(obj.faceUrl) === -1) {
                  arrLikes.push(that.update.likes[i]);
                }
              }
              that.update.likes = arrLikes;
              that.update.like_total--;
            }
          }
          if (obj.api == 'like') { //喜欢
            this.likeClick = false;
            if (obj.code == 30000) {
              this.update.is_like = 1;
              if (obj.faceUrl.indexOf('?x-oss-process') === -1) {
                obj.faceUrl = obj.faceUrl + '?x-oss-process=image/resize,m_fixed,h_180,w_180';
              }
              if (that.update.likes.length > 0 && that.update.likes[0].indexOf(obj.faceUrl) !== -1) {
                that.update.likes.unshift(obj.faceUrl);
              } else if (that.update.likes.length > 9) {
                that.update.likes.pop();
                that.update.likes.unshift(obj.faceUrl);
              } else {
                that.update.likes.unshift(obj.faceUrl);
              }
              that.update.like_total++;
            }
          }
          if (obj.api == 'unzan') { //取消点赞
            that.zanClick = false;
            if (obj.code == 30000) {
              that.update.commentList.forEach(function(item) {
                if (item.commentId == obj.commentId) {
                  // Vue.set(item, "unfollow", true);
                  item.isLike = 'N';
                  item.likes--;
                }
              });
            }
          }
          if (obj.api == 'zan') { //点赞
            that.zanClick = false;
            if (obj.code == 30000) {
              that.update.commentList.forEach(function(item) {
                if (item.commentId == obj.commentId) {
                  // Vue.set(item, "unfollow", true);
                  item.isLike = 'Y';
                  item.likes++;
                }
              });
            }
          }

          if (obj.api == 'comment') { //评论
            that.commentSubmit = false;
            if (obj.code == 30000) {
              var commentItem = obj.data.commentInfo ;
              commentItem.isLike = 'N';
              commentItem.likes = '0';
              that.commentContent = '';
              that.update.commentTotal++;
              that.update.commentList.unshift(commentItem);
              if (that.update.commentList.length > 5) {
                that.update.commentList.pop();
              }
            }
          }

          // if (obj.api == 'repayMessage') { //回复评论
          //   that.commentSubmit = false;
          //   if (obj.code == 30000) {
          //     that.update.commentList.forEach(function(item) {
          //       if (item.commentId == obj.commentId) {
          //         Vue.set(item, 'repayContent', obj.data.repayInfo.content);
          //         Vue.set(item, 'repayer', obj.data.repayInfo.nickname);
          //         Vue.set(item, 'repayTime', obj.data.repayInfo.time);
          //       }
          //     });
          //   }
          // }

          if (obj.api == 'reload') { //重载页面
            that.init(obj.h5_token, obj.updateId);
          }
        }
      },
    })
    var interact = comVue.interact;
  
  </script>
</html>
