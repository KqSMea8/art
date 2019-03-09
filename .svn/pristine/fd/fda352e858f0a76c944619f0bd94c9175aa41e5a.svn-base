Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

// 编辑弹窗
Vue.component('edit-box', {
  template: '<div v-show="boxIsShow" class="layerbox">\
        <div @click="hideBox" class="layershade"></div>\
        <div class="layermain">\
          <div v-show="editIsShow" class="thirdLayerIn anim-scale remark-box edit-box">\
            <h3 class="title">修改个人资料 <em @click="hideBox" title="关闭" >×</em></h3>\
            <div class="content">\
              <textarea v-model="content" rows="8" class="art-textarea"></textarea>\
            </div>\
            <div class="btn-group">\
              <div @click="submit" class="btn-s w110">确 定</div>\
              <a @click="hideBox" class="btn-s primary w110">取消</a>\
            </div>\
          </div>\
        </div>\
      ',
  data: function () {
    return {
      editIsShow: false, //提醒弹窗是否显示
      boxIsShow: false,  //弹窗蒙层是否显示
      content: ''
    };
  },
  created: function () {
    
  },
  mounted: function() {
    eventBus.$on('showEditBox', function(content) {
      this.showEditBox(content);
    }.bind(this));
    // 这里必须将 this 绑定在组件实例上。如果不使用 bind , 也可以使用箭头函数。
  },
  methods: {
    showEditBox: function (content) {
      this.boxIsShow = true;
      this.editIsShow = true;
      this.content = content;
    },
    submit: function () {
      var that = this;
      var api = '/Api/UserCenter/saveUserInfo';
      var data = {
        resume: this.content
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == '30000' && res.data.status == '1000') {
            new Toast({message: '修改成功'});
            that.hideBox();
            eventBus.$emit('changeResume', that.content);
          }
        }
      });
    },
    hideBox: function () {
      this.boxIsShow = false;
      this.editIsShow = false;
    },
  }
});

Vue.component('update', {
  template: '<ul class="update-list">\
              <li v-for="item in updateInfo.data" class="update-item clearfix">\
                <a :href="\'/artwork/update/\'+ item.artupid">\
                  <div class="detail-wrap">\
                    <h3 class="title"><strong class="name">{{item.imgname}}</strong> <span class="time">{{item.create_date}}</span></h3>\
                    <p class="story">\
                      {{item.summary}}\
                    </p>\
                    <ul class="tags clearfix">\
                      <li><i class="icons icon-eye"></i>{{item.view_total}}</li>\
                      <li><i class="icons icon-comment"></i>{{item.comment_total}}</li>\
                      <li><i class="icons icon-like"></i>{{item.like_total}}</li>\
                    </ul>\
                  </div>\
                  <div class="img-wrap">\
                    <img class="art-pic" v-lazy="item.imgurl + compress.S">\
                  </div>\
                </a>\
              </li>\
              <ysz-loadmore v-if="unloaded" v-infinite-scroll="getArtistRecord"></ysz-loadmore>\
            </ul>\
            ',
  data: function () {
    return {
      updateInfo: {
        data: [
          // {
          //   view_total: '',
          //   like_total: '',
          //   comment_total:'',
          //   cover:'',
          //   create_date:'',
          //   id:'',
          //   is_like:'',
          //   number:'',
          //   artname: '',
          //   summary:''
          // }
        ],
        "page": 0
      },
      unloaded: true, //未加载完
      busy:false,
      compress: compress //图片压缩后缀
    };
  },
  created: function () {
    this.getArtistRecord();
  },
  mounted: function() {

  },
  methods: {
    getArtistRecord: function () {
      this.busy = true;
      var that = this;
      var api = '/Api/Gallery/getArtistRecord';
      var data = {
        artistId: GetLocationId() ? GetLocationId() : -1,
        page: ++this.updateInfo.page,
        pagesize: 10
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          that.busy = false;
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            // resInfo.data.forEach(function (item) {
            //   item.imgname = checkMark(item.imgname);
            // });
            if (resInfo.page == 1) {

              that.updateInfo = resInfo;
            } else if (resInfo.page > 1) {
              that.updateInfo.data = that.updateInfo.data.concat(resInfo.data);
            }
            if (resInfo.page >= resInfo.maxpage) {
              that.busy = true;
              that.unloaded = false;
            }
          }
        }
      });
    },
  },
});
Vue.component('artwork', {
  template: '<ul class="art-list clearfix">\
              <li v-for="(artitem, index) in artworkInfo.data" class="fl">\
                <a :href="\'/artwork/detail/\' + artitem.id">\
                  <img class="art-pic" v-lazy="artitem.coverUrl + compress.S">\
                  <h3>\
                    <span>{{artitem.name}}</span>\
                    <i @click.prevent="toggleLike(artitem.id, index)" :class="[\'icons\', artitem.is_like == \'Y\'?\'icon-liked\': \'icon-like\']"></i>\
                  </h3>\
                </a>\
              </li>\
              <ysz-loadmore v-if="unloaded" v-infinite-scroll="getArtistArtworkList"></ysz-loadmore>\
            </ul>',
  data: function () {
    return {
      artworkInfo: {
        data: [],
        page: 0
      },
      unloaded: true, //未加载完
      busy:false,
      compress: compress, //图片压缩后缀
      likeClick: false
    };
  },
  created: function () {
    this.getArtistArtworkList();
  },
  mounted: function () {
    eventBus.$on('unlike', function(id, type, index) {
      this.unlike(id, type, index);
    }.bind(this));
  },
  methods: {
    getArtistArtworkList: function () {
      this.busy = true;

      var that = this;
      var api = '/Api/Gallery/getArtistArtworkList';
      var data = {
        artistId: GetLocationId() ? GetLocationId() : -1,
        page: ++this.artworkInfo.page,
        pagesize: 9
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          that.busy = false;
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            resInfo.data.forEach(function (item) {
              item.name = checkMark(item.name);
            });
            if (resInfo.page == 1) {
              that.artworkInfo = resInfo;
            } else if (resInfo.page > 1) {
              that.artworkInfo.data = that.artworkInfo.data.concat(resInfo.data);
            }
            if (resInfo.page >= resInfo.maxpage) {
              that.busy = true;
              that.unloaded = false;
            }
          }
        }
      });
    },
    toggleLike: function (id, index) {
      var that = this;
      var data = {
        id: id,
        type: 1
      };

      if (that.artworkInfo.data[index].is_like == "N") {
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
              that.artworkInfo.data[index].is_like = "Y";
              that.artworkInfo.data[index].liketotal++;
            }
          }
        });
      } else if (that.artworkInfo.data[index].is_like == "Y") {
        eventBus.$emit('showLikeBox', id, 1, index);
        // $.ajax({
        //   type: "POST",
        //   url: '/Api/Artwork/unlike',
        //   data: data,
        //   success: function(res) {
        //     console.log(res);
        //     that.likeClick = false;
        //     if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
        //       eventBus.$emit('showLogin', 'login', 'login');
        //     } else if (res.code == '30000' && res.data.status == 1000) {
        //       that.artworkInfo.data[index].is_like = "N";
        //       that.artworkInfo.data[index].liketotal--;
        //     }
        //   }
        // });
      }
    },
    unlike: function(id, type, index) {
      this.artworkInfo.data[index].is_like = "N";
      this.artworkInfo.data[index].liketotal--;
    }
  },
});


var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
    btnText: '',
    followClick: false,
    compress: compress, //图片压缩后缀
    artistId: GetLocationId() ? GetLocationId() : -1,
    artistInfo: {
      btnText: ''
    },
    active: 0,
    currentView: 'update',
    tabs: [{
      type: '创作·絮',
      view: 'update'
    }, {
      type: '作品·集',
      view: 'artwork'
    }],
    moreText: '查看更多'
  },
  created: function() {
    this.getArtistDetail();
  },
  mounted: function() {
    eventBus.$on('changeResume', function(content) {
      this.changeResume(content);
    }.bind(this));
  },
  methods: {
    changeResume: function (content) {
      this.artistInfo.resume = content;
    },
    showEditBox: function () {
      eventBus.$emit('showEditBox', this.artistInfo.resume);
    },
    getArtistDetail: function () {
      var that = this;
      var api = '/Api/Gallery/getArtistDetail';
      var data = {
        artistId: this.artistId
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            resInfo.resume = utils.n2br(resInfo.resume);
            if (resInfo.isFollowed == 'Y') {
              resInfo.btnText = '已关注';
            } else if (resInfo.isFollowed == 'N') {
              resInfo.btnText = '+ 关注';
            }
            that.artistInfo = resInfo;
            document.title = resInfo.name + '的画廊';
          }
        }
      });
    },
    seeMore: function () {
      if (this.moreText == "查看更多") {
        this.moreText = "收起";
      } else {
        this.moreText = "查看更多";
      }
      this.$nextTick(function () {
        if ($('.auth-wrap').length > 0) {
          new StickUpAll('.auth-wrap');
          $(document).scrollTop($(document).scrollTop() + 1);
        }
      });
    },
    overFollowText: function () {
      if (this.artistInfo.btnText == '已关注') {
        this.artistInfo.btnText = '取消关注';
      }
    },
    outFollowText: function () {
      if (this.artistInfo.btnText == '取消关注') {
        this.artistInfo.btnText = '已关注';
      }
    },
    toggle: function (index, view) {
      this.active = index;
      this.currentView = view;
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

      if (that.artistInfo.isFollowed == "Y") {
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
              that.artistInfo.isFollowed = "N";
              that.artistInfo.btnText = '+ 关注';
              that.artistInfo.followTotal--;
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
              that.artistInfo.isFollowed = "Y";
              that.artistInfo.btnText = '已关注';
              that.artistInfo.followTotal++;
            }
          }
        });
      }
    },

  }
});