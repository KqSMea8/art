Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

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
}

// 获取URL中的id /artwork/update/150?from=singlemessage
function GetLocationId() {
  var path = window.location.pathname; //获取url中路径
  var ids = path.split('/');
  var id = ids[ids.length - 1];
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

// 像素转rem
// function px2rem(con) {
//   con = con.replace(/:(\s)?(\d+(\.\d)?)px/g, function(s, t) {
//     s = s.replace('px', '');
//     s = s.replace(':', '');
//     var value = parseInt(s) * 0.0266667; //   此处 1rem = 75px
//     return ':' + value + "rem";
//   });
//   con = con.replace(/:(\s)?(\d+(\.\d)?)pt/g, function(s, t) {
//     s = s.replace('pt', '');
//     s = s.replace(':', '');
//     var value = parseInt(s) * 0.0355556; //   此处 1rem = 56.25pt
//     return ':' + value + "rem";
//   });
//   return con;
// }
function px2rem(con) { // /(\d)+\.?[0-9]+(px)|(\d)+(px)/gi
  con = con.replace(/(\d)+\.?[0-9]+(px)|(\d)+(px)/gi, function(s, t) {
    s = s.replace('px', '');
    // s = s.replace(':', '');
    var value = parseInt(s) * 0.0266667; //   此处 1rem = 75px
    return value + "rem";
  });
  con = con.replace(/:(\s)?(\d+(\.\d)?)pt/g, function(s, t) {
    s = s.replace('pt', '');
    // s = s.replace(':', '');
    var value = parseInt(s) * 0.0355556; //   此处 1rem = 56.25pt
    return ':' + value + "rem";
  });
  return con;
}

var OCModel;

var vmApp = new Vue({
  // element to mount to
  el: '#artwork-update',
  // initial data
  data: {
    loadtimes:0,
    loadtimed:0,
    isLoading: true,
    likeClick: false,
    followClick: false,
    zanClick: false,
    isLike: false,
    isFollow: false,
    updateId: '',
    artistid: '',
    update: {
      "id": "14", //更新的ID
      "artwork_id": "", //作品的ID
      "artname": "", //作品名称
      "time": "", //更新时间，用户选择的
      "wit": "", //内容
      "cover": "", //封面
      "publisher": "",
      "commentTotal": "", //评论总数
      "is_finished": "", //是否完成
      "is_like": "", //是否喜欢
      "number": "", //第几次更新
      "like_total": "", //喜欢总数
      "view_total": "", //浏览总数
      "create_time": "", //上传时间
      "orgImages": [], // 原图的列表
      "commentList": [],
      "tags": [],
      "shareTitle": "",
      "shareDesc": "",
      "shareImg": "",
      "shareInfo": {
        "cover": "",
        "face": "",
        "name": "",
        "category": "",
        "link": ""
      },
      "publisherInfo": {
        "nickname": "",
        "name": "",
        "face": "",
        "artTotal": "",
        "faceUrl": "",
        "isFollow": "",
        "follower_total": ""
      }, //作者
      "related": [], //相关推荐
      "likes": [], //喜欢的人头像
    },
    boxIsShow: false,
    shareIsShow: false,
    downloadIsShow: false, //下载新增代码
    boxMsg: '',
    commentContent: '',
    commentSubmit: false,
    userInfo: {

    },
    commentHolder: '',
    commentHolderList: [
      '等一座城 等一个人 等你的留言',
      '最美的不是下雨天，而是你刷过的留言板',
      '留言都是爱你的形状',
      '你写下的欣赏，是给xx最大的肯定',
      '记录此刻感受，这是一种态度，不解释！'
    ],
    publisher: {},
    artStr: '' //画作参数
  },
  created: function() {
    this.init();
  },
  // methods
  methods: {
    init: function(h5_token, updateId) {
      var that = this;
      this.updateId = GetLocationId() || '-1';

      var data = {
        h5_token: h5_token ? h5_token : GetRequest().h5_token,
        id: updateId ? updateId : this.updateId
      };

      var route = 'MobileGetH5/ArtworkUpdateDetail';
      var api = window.location.origin + '/V32/' + route;

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == 30000) {
            that.isLoading = false;
            document.title = res.data.info.artname;
            var update = res.data.info;
            // 去除为空的tag
            // if(update.tags.length>0){
            //   var u = update.tags.length;
            //   while(u--){
            //     if(arr[u]==''){
            //       update.tags.splice(u,1);
            //     }
            //   }
            // }
            //

            that.commentHolderList[3] = '你写下的欣赏，是给' + update.publisher + '最大的肯定';
            that.commentHolder = that.commentHolderList[Math.floor(Math.random()*5)];
            update.artname = that.checkMark(update.artname);
            var artObj = {
              type: 'artworkDetail',
              id: update.artwork_id
            };
            that.artStr = JSON.stringify(artObj);
            if (update.is_finished == "Y") {
              update.number = 0;
            } else if (update.number > 9) {
              update.number = 10;
            } else {
              update.number = update.number; //可省略
            }

            if (update.commentList.length > 5) {
              update.commentList = update.commentList.slice(0, 5);
            }
            if (update.likes.length > 10) {
              update.likes = update.likes.slice(0, 10);
            }

            update.wit = px2rem(update.wit);

            //图片懒加载

            var el = document.createElement('div');
            el.innerHTML = update.wit;
            var $el = $(el);
            var imgs = $el.find('img');
            imgNum = $("img").length,

              imgs.each(function() {
                var src = $(this).attr("src");
                $(this).attr("data-original", src);
                $(this).attr('src', '/Public/image/holder.png');
              });

            update.wit = el.innerHTML;

            that.update = update;
            that.publisher = update.publisher;
            that.$nextTick(function() {
              $(".view img").lazyload({
                threshold: 200,　　　　　　
                event: "scrollstop", //滚动加载
                effect: "fadeIn" //淡入
              });
              var $imgList = $('.view img');
              $imgList.click(function(event) { //绑定图片点击事件
                var index = $imgList.index(this);
                that.gotoApp('image', index);
              });

              // TODO: 等页面加载完成后给音频添加播放事件
              function pauseAll() {
                $('.audioPlayBox').attr('data-flag',false);
                for( var i = 0 , len = $('audio').length ; i < len ; i ++ ){
                  // $('audio')[i].currentTime=0;
                  $('audio')[i].volume=0.5; // 声音音量。1为最大
                  $('audio')[i].pause();
                  $('.playImgBox').removeClass('playPause').addClass('playimg'); // 重置播放图标
                }
              }

              $('.audioPlayBox').on('click',function(){
                var thisIndex = $('.audioPlayBox').index($(this));
                if($(this).attr('data-flag')=='true'){ // 通过判断$('.audioPlayBox')的data-flag来做操作
                  pauseAll();
                  $('.audioPlayBox').attr('data-flag',false);
                  $(this).children(1).children('.playImgBox').removeClass('playPause').addClass('playimg'); // 为当前播放的加上暂停图标
                }else{
                  pauseAll();
                  $(this).attr('data-flag', true);
                  $(this).children(1).children('.playImgBox').removeClass('playimg').addClass('playPause'); // 为当前播放的加上暂停图标
                  $('audio')[thisIndex].play();
                }
              })

              //APP交互跳转
              var $consList = $('[data-artzhe-type=link]');
              console.log($consList);

              //阻止默认事件函数
              function stopDefault(e) {
                if (e && e.preventDefault)
                  e.preventDefault();
                else
                  window.event.returnValue = false; //兼容IE
              }

              $consList.click(function(event) {
                stopDefault(event);
                var index = $consList.index(this);
                var type = $(this).attr('data-artzhe-typeDetail');
                var id = $(this).attr('data-artzhe-id');

                that.gotoApp(type, id);
              });


            });
            that.fadeOut();
          }
        }
      });
    },
    checkMark: function (str) {
      if (str.indexOf('《') == -1) {
        str = '《' + str + '》';
      }
      return str;
    },
    toggleFollow: function(msg) {
      var that = this;
      if (this.followClick) {
        return false;
      }
      this.followClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass('anim-zooming');
      }); //放大缩小动画效果

      var ocData = {
        artistId: this.update.publisherInfo.id
      };

      if (this.update.publisherInfo.isFollow == 'Y') {
        ocData.api = 'unfollow';
      } else {
        ocData.api = 'follow';
      }

      this.jsToNative(ocData);
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

      if (this.update.is_like == 'Y') {
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
    toRepay: function(id) {
      var that = this;
      var ocData = {
        api: 'repayMessage',
        commentId: id
      };

      if (this.commentSubmit) {
        return false;
      }
      this.commentSubmit = true;

      this.jsToNative(ocData);
    },
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
          that.update.is_like = 'N';
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
          this.update.is_like = 'Y';
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
      if (obj.api == 'unfollow') { //取消关注
        that.followClick = false;
        if (obj.code == 30000) {
          that.update.publisherInfo.isFollow = 'N';
          that.update.publisherInfo.follower_total--;
        }
      }
      if (obj.api == 'follow') { //关注
        that.followClick = false;
        if (obj.code == 30000) {
          that.update.publisherInfo.isFollow = 'Y';
          that.update.publisherInfo.follower_total++;
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
          var commentItem = obj.data.commentInfo;
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

      if (obj.api == 'repayMessage') { //回复评论
        that.commentSubmit = false;
        if (obj.code == 30000) {
          that.update.commentList.forEach(function(item) {
            if (item.commentId == obj.commentId) {
              Vue.set(item, 'repayContent', obj.data.repayInfo.content);
              Vue.set(item, 'repayer', obj.data.repayInfo.nickname);
              Vue.set(item, 'repayTime', obj.data.repayInfo.time);
            }
          });
        }
      }

      if (obj.api == 'reload') { //重载页面
        that.init(obj.h5_token, obj.updateId);
      }

    }
  },
  // components: {
  //   VueLazyload: VueLazyload
  // }
});


var interact = vmApp.interact;
