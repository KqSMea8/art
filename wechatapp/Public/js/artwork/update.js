Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

//下载APP弹窗
Vue.component('app-down-box', {
  template: '<div v-show="boxIsShow" class="layerbox">\
        <div @click="hideBox" class="layershade"></div>\
        <div class="layermain">\
          <div v-show="downIsShow" class="thirdLayerIn anim-scale remark-box">\
            <h3 class="title">扫码下载艺术者APP <em @click="hideBox" title="关闭" >×</em></h3>\
            <div class="content">\
              <img class="app-code" src="//artzhe.oss-cn-shenzhen.aliyuncs.com/static/pc/APP.png"/>\
              <p class="tip">\
                下载艺术者APP<br>\
                查看全部内容\
              </p>\
            </div>\
          </div>\
        </div>\
      ',
  data: function () {
    return {
      downIsShow: false, //提醒弹窗是否显示
      boxIsShow: false,  //弹窗蒙层是否显示
    };
  },
  created: function () {
    
  },
  mounted: function() {
    eventBus.$on('showDownloadFix', function(id, type, index) {
      this.showLikeBox(id, type, index);
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showLikeBox: function (id, type, index) {
      this.id = id;
      this.type = type;
      this.index = index;
      this.boxIsShow = true;
      this.downIsShow = true;
    },
    unlike: function () {
      var that = this;
      var data = {
        id: this.id,
        type: this.type
      };
      $.ajax({
        type: "POST",
        url: '/Api/Artwork/unlike',
        data: data,
        success: function(res) {
          // console.log(res);
          that.likeClick = false;
          if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
            eventBus.$emit('showLogin', 'login', 'login');
          } else if (res.code == '30000' && res.data.status == 1000) {
            that.hideBox();
            eventBus.$emit('unlike', that.id, that.type, that.index, res.data.faceUrl);
          }
        }
      });
    },
    hideBox: function () {
      this.boxIsShow = false;
      this.downIsShow = false;
    },
  }
});

var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
    btnText: {
      'Y': '已关注',
      'N': '+ 关注'
    },
    compress: compress, //图片压缩后缀
    info: {
      publisherInfo: {
        face: '/Public/image/holder.png'
      }
    }
  },
  created: function() {
    this.getUpdateDetail();
  },
  mounted: function() {
    eventBus.$on('unlike', function(id, type, index, faceUrl) {
      this.unlike(id, type, index, faceUrl);
    }.bind(this));
  },
  methods: {
    showDownloadFix: function () {
      eventBus.$emit('showDownloadFix');
    },
    getUpdateDetail: function () {
      var that = this;
      var api = '/Api/Artwork/getUpdateDetail';
      var data = {
        updateId: GetLocationId() ? GetLocationId() : -1,
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            // resInfo.artname = checkMark(resInfo.artname);
            if (resInfo.publisherInfo.category_name) {
                resInfo.publisherInfo.mark = resInfo.publisherInfo.category_name;
            } else {
                resInfo.publisherInfo.mark = resInfo.publisherInfo.motto;
            }
            if (resInfo.publisherInfo.isFollow == 'Y') {
              resInfo.publisherInfo.btnText = '已关注';
            } else if (resInfo.publisherInfo.isFollow == 'N') {
              resInfo.publisherInfo.btnText = '+ 关注';
            }
            that.info = resInfo;

            document.title = resInfo.artname;
            //百度分享js
            window._bd_share_config = {
              "common": {
                "bdSnsKey": {},
                "bdText": resInfo.shareTitle,
                "bdDesc": resInfo.shareDesc,
                "bdMini": "2",
                "bdMiniList": false,
                "bdPic": resInfo.shareImg,
                "bdStyle": "2",
                "bdSize": "32"
              },
              "share": {}
            };
            with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = '/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];

          }
        }
      });
    },
    overFollowText: function () {
      if (this.info.publisherInfo.btnText == '已关注') {
        this.info.publisherInfo.btnText = '取消关注';
      }
    },
    outFollowText: function () {
      if (this.info.publisherInfo.btnText == '取消关注') {
        this.info.publisherInfo.btnText = '已关注';
      }
    },
    toggleFollow: function(id) {
      var that = this;
      var data = {
        artistId: id
      };
      if (this.followClick) {
        return false;
      }
      this.followClick = true;

      if (that.info.publisherInfo.isFollow == "Y") {
        $.ajax({
          type: "POST",
          url: '/Api/Gallery/unfollow',
          data: data,
          success: function(res) {
            // console.log(res);
            that.followClick = false;
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              eventBus.$emit('showLogin', 'login', 'login');
            } else if (res.code == '30000' && res.data.status == 1000) {
              that.info.publisherInfo.isFollow = "N";
              that.info.publisherInfo.btnText = '+ 关注';
              that.info.publisherInfo.followTotal--;
            }
          }
        });
      } else {
        $.ajax({
          type: "POST",
          url: '/Api/Gallery/follow',
          data: data,
          success: function(res) {
            // console.log(res);
            that.followClick = false;
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              eventBus.$emit('showLogin', 'login', 'login');
            } else if (res.code == '30000' && res.data.status == 1000) {
              that.info.publisherInfo.isFollow = "Y";
              that.info.publisherInfo.btnText = '已关注';
              that.info.publisherInfo.followTotal++;
            }
          }
        });
      }
    },
    toggleLike: function () {
      var that = this;
      var data = {
        id: GetLocationId() ? GetLocationId() : -1,
        type: 2
      };
      if (that.info.is_like == "N") {
        if (this.likeClick) {
          return false;
        }
        this.likeClick = true;
        $.ajax({
          type: "POST",
          url: '/Api/Artwork/like',
          data: data,
          success: function(res) {
            // console.log(res);
            that.likeClick = false;
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              eventBus.$emit('showLogin', 'login', 'login');
            } else if (res.code == '30000' && res.data.status == 1000) {
              that.info.is_like = "Y";
              that.info.like_total++;
              if (that.info.likes.length > 0 && that.info.likes[0].indexOf(res.data.faceUrl) !== -1) {
                that.info.likes.unshift(res.data.faceUrl);
              } else if (that.info.likes.length > 9) {
                that.info.likes.pop();
                that.info.likes.unshift(res.data.faceUrl);
              } else {
                that.info.likes.unshift(res.data.faceUrl);
              }
            }
          }
        });
      } else if (that.info.is_like == "Y") {
        eventBus.$emit('showLikeBox', data.id, data.type);
      }
    },
    unlike: function(id, type, index, faceUrl) {
      this.info.is_like = "N";
      this.info.like_total--;
      var arrLikes = [], that = this;
      for (var i = 0; i < that.info.likes.length; i++) {
        if (that.info.likes[i].indexOf(faceUrl) === -1) {
          arrLikes.push(that.info.likes[i]);
        }
      }
      that.info.likes = arrLikes;
    },
  }
});