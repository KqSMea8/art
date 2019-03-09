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
  el: '#article-detail',
  // initial data
  data: {
    isLoading: true,
    likeClick: false,
    followClick: false,
    zanClick: false,
    isLike: false,
    isFollow: false,
    articleId: '',
    artistid: '',
    update: {
      "title": "", //文章标题
      "like_count": '', //喜欢数
      "create_time": "", //添加日期
      "views": '', //浏览量
      "is_like": '', //1,0是否喜欢
      "follow_user": '', // 1,0是否关注
      "content": "", //内容
      "userinfo": { //作者信息
        "id": '',
        "nickname": '',
        "faceUrl": '',
        "category_names": '',
        "gender": "1", //"性别。1：男；2：女；3：保密",
        "is_artist": '', //是否艺术家
        "is_agency": '', //是否认证机构
        "is_planner": '' //是否策展人
      },
      "like_users": [ //喜欢的头像列表
      ],
      "comments": {
        "total": '', //评论数
        "commentlist": [{
          "commentId": "", //评论id
          "artist": "", //评论者ID
          "faceUrl": "",
          "nickname": "",
          "gender": "",
          "time": "", //时间
          "content": "", //内容
          "repayer": "", //回复
          "repayContent": '', //回复内容
          "repayTime": '', //回复时间
          "likes": '', //点赞
          "isLike": '', //Y,N是否点赞
          "isRepay": '' //是否回复,1、0
        }]
      },
      "related": [ //相关文章
        //  {
        //   "id": 666, //文章id
        //   "title": "呃呃呃呃呃呃呃呃呃呃呃",
        //   "images": [
        //     "https://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1490348469526407",
        //     "https://gsy-other.oss-cn-beijing.aliyuncs.com/other/artzhe/user/iosapp1490348469526407"
        //   ],
        //   "excerpt": "这里，你可以提出编程相关的疑惑，关注感兴趣的问题，对认可的回答投赞同票；大家会帮你解决编程的问题，和你探讨技术更新，为你的回答投上赞同",
        //   "like_count": 90000,
        //   "is_like": 0,
        //   "user": {
        //     "id": 44456,
        //     "nickname": "广泛大锅饭",
        //     "faceUrl": "https://gsy-other.oss-cn-beijing.aliyuncs.com",
        //     "is_artist": 1,
        //     "is_agency": 1,
        //     "is_planner": 1
        //   }
        // }
      ]
    },
    commentHolder: '',
    commentHolderList: [
      '等一座城 等一个人 等你的留言',
      '最美的不是下雨天，而是你刷过的留言板',
      '留言都是爱你的形状',
      '你写下的欣赏，是给xx最大的肯定',
      '记录此刻感受，这是一种态度，不解释！'
    ],
    commentSubmit: false
  },
  created: function() {
    this.init();
  },
  // methods
  methods: {
    init: function(h5_token, articleId) {
      var that = this;
      this.articleId = GetLocationId() || '';

      var data = {
        h5_token: h5_token ? h5_token : GetRequest().h5_token,
        id: articleId? articleId : this.articleId
      };

      var route = 'MobileGetH5/getArticleDetail';
      var api = window.location.origin + '/V31/' + route;

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          that.isLoading = false;
          if (res.code == 30000) {
            console.log('获取艺术号详情.data.info', res.data.info);
            document.title = res.data.info.title;
            var update = res.data.info;

            that.commentHolderList[3] = '你写下的欣赏，是给' + update.userinfo.nickname + '最大的肯定';
            that.commentHolder = that.commentHolderList[Math.floor(Math.random()*5)];

            if (update.comments.commentlist.length > 5) {
              update.comments.commentlist = update.comments.commentlist.slice(0, 5);
            }
            if (update.like_users.length > 10) {
              update.like_users = update.like_users.slice(0, 10);
            }
            update.content = px2rem(update.content);
            update.content = update.content.replace(/width: auto !important;/g, '');

            //图片懒加载

            var el = document.createElement('div');
            el.innerHTML = update.content;
            var $el = $(el);
            var imgs = $el.find('img');
            imgNum = $("img").length,

              imgs.each(function() {
                var src = $(this).attr("src");
                $(this).attr("data-original", src);
                // $(this).addClass("lazy");
                $(this).attr('src', '/Public/image/holder.png');
              });

            update.content = el.innerHTML;

            that.update = update;
            that.publisher = update.publisher;
            // that.fadeOut();
            that.$nextTick(function() {
              $(".view img").lazyload({
                threshold: 200,　　　　　　
                event: "scrollstop", //滚动加载
                effect: "fadeIn" //淡入
              });
              that.setImgStyle($('.view img'));
              var $imgList = $('.view img');
              $imgList.click(function(event) { //绑定图片点击事件
                if ($(this).parent()[0].tagName !== 'A') {
                  var index = $imgList.index(this);
                  that.gotoApp('image', index);
                }

              });
            });
            that.fadeOut();
          }
        }
      });
    },
    setImgStyle: function ($imgList) {
      $imgList.each(function() {
        var that = $(this);
        var src = $(this).attr("data-original");
        getImageWidth(src,function(w,h){
          if (w <= 64) {
            that.css({width:48,height:48,display:'inline-block'});
          }
        });
      });
    },
    toggleFollow: function(msg) {
      var that = this, api;
      if (this.followClick) {
        return false;
      }
      this.followClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass('anim-zooming');
      }); //放大缩小动画效果

      var ocData = {
        artistId: this.update.userinfo.id
      };

      if (this.update.follow_user == '1') {
        ocData.api = 'unfollow';
      } else {
        ocData.api = 'follow';
      }

      this.jsToNative(ocData);
    },
    toggleLike: function(msg) {
      var that = this;
      var ocData = {
        id: this.articleId,
      };
      if (this.likeClick) {
        return false;
      }
      this.likeClick = true;

      $(event.currentTarget).find('i').removeClass('anim-zooming').addClass('anim-zooming').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
        $(this).removeClass('anim-zooming');
      }); //放大缩小动画效果


      if (this.update.is_like == '1') {
        ocData.api = 'unlike';
      } else {
        ocData.api = 'like';
      }

      this.jsToNative(ocData);
    },
    toggleZan: function(id, isLike) {
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
        ArticleId: this.articleId
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
          that.update.is_like = '0';
          var arrLikes = [];
          for (var i = 0; i < that.update.like_users.length; i++) {
            if (that.update.like_users[i].indexOf(obj.faceUrl) === -1) {
              arrLikes.push(that.update.like_users[i]);
            }
          }
          that.update.like_users = arrLikes;
          that.update.like_count--;
        }
      }
      if (obj.api == 'like') { //喜欢
        this.likeClick = false;
        if (obj.code == 30000) {
          this.update.is_like = '1';
          if (obj.faceUrl.indexOf('?x-oss-process') === -1) {
            obj.faceUrl = obj.faceUrl + '?x-oss-process=image/resize,m_fixed,h_180,w_180';
          }
          if (that.update.like_users.length > 0 && that.update.like_users[0].indexOf(obj.faceUrl) !== -1) {
            that.update.like_users.unshift(obj.faceUrl);
          } else if (that.update.like_users.length > 9) {
            that.update.like_users.pop();
            that.update.like_users.unshift(obj.faceUrl);
          }  else {
            that.update.like_users.unshift(obj.faceUrl);
          }
          that.update.like_count++;
        }
      }

      if (obj.api == 'unfollow') { //取消关注
        that.followClick = false;
        if (obj.code == 30000) {
          that.update.follow_user = '0';
        }
      }
      if (obj.api == 'follow') { //关注
        that.followClick = false;
        if (obj.code == 30000) {
          that.update.follow_user = '1';
        }
      }

      if (obj.api == 'unzan') { //取消点赞
        that.zanClick = false;
        if (obj.code == 30000) {
          that.update.comments.commentlist.forEach(function(item) {
            if (item.commentId == obj.commentId) {
              item.isLike = 'N';
              item.likes--;
            }
          });
        }
      }
      if (obj.api == 'zan') { //点赞
        that.zanClick = false;
        if (obj.code == 30000) {
          that.update.comments.commentlist.forEach(function(item) {
            if (item.commentId == obj.commentId) {
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
          that.update.comments.total++;
          that.update.comments.commentlist.unshift(commentItem);
        }
      }

      if (obj.api == 'repayMessage') { //回复评论
        that.commentSubmit = false;
        if (obj.code == 30000) {
          that.update.comments.commentlist.forEach(function(item) {
            if (item.commentId == obj.commentId) {
              Vue.set(item, 'repayContent', obj.data.repayInfo.content);
              Vue.set(item, 'repayer', obj.data.repayInfo.nickname);
              Vue.set(item, 'repayTime', obj.data.repayInfo.time);
            }
          });
        }
      }

      if (obj.api == 'reload') { //重载页面
        that.init(obj.h5_token, obj.articleId);
      }
    },
  },
  components: {
    VueLazyload: VueLazyload
  }
});

var interact = vmApp.interact;
