Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});

var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
    unloaded: true, //未加载完
    busy:false,
    compress: compress, //图片压缩后缀
    page:0,
    active: 0,
    type: '',
    tabs: [{
      cont: '全部',
      num: 0,
      type: ''
    }, {
      cont: '评论',
      num: 0,
      type: '10,13'
    }, {
      cont: '喜欢',
      num: 0,
      type: '9,12'
    }, {
      cont: '系统通知',
      num: 0,
      type: '8'
    }],
    list: []
  },
  created: function() {
    this.getList();
  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.tabs[1].num = info.unreadCommentMessageTotal;
      this.tabs[2].num = info.unreadLikeMessageTotal;
      this.tabs[3].num = info.unreadSystemMessageTotal;
    }.bind(this));
  },
  methods: {
    toggleActive: function(index) {
      if (index === this.active) return false;
      this.active = index;
      this.type = this.tabs[index].type;
      this.tabs[index].num = 0;
      this.page = 0;
      this.list = [];
      this.busy = false;
      this.unloaded = true;
      this.getList();
    },
    getList: function () {
      this.busy = true;

      var that = this;
      var api = '/Api/UserCenter/getMyMessageList'; //获取消息列表
      var data = {
        page: ++this.page,
        pagesize: 10,
        type: this.type
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            if (that.page <= 1) {
              that.list = resInfo;
            } else if (that.page > 1) {
              that.list = that.list.concat(resInfo);
            }
            that.$nextTick(function () {
              that.busy = false;
              if (resInfo.length === 0) {
                that.busy = true;
                that.unloaded = false;
              }
            });
          }
        }
      });
    }
  }
});