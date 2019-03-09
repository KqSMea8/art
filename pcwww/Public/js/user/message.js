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
    list: [],
    loading: true,
    totalpage: 1,
    curpage: 1,
    inputpage: '',
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
      // this.page = 0;
      this.curpage = 0;
      this.list = [];
      this.busy = false;
      this.unloaded = true;
      this.inputpage = '';
      this.getList();
    },
    getList: function () {
      this.busy = true;
      this.loading = true;
      var that = this;
      var api = '/Api/UserCenter/getMyMessageList'; //获取消息列表
      var data = {
        page: this.curpage,
        pagesize: 10,
        type: this.type
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == '30000' && res.data.status == '1000') {
            that.loading = false;

            var resInfo = res.data.info;
            that.totalpage = res.data.info.maxpage;
            that.curpage = res.data.info.page;
            if (that.page <= 1) {
              that.list = resInfo.message;
            } else if (that.page > 1) {
              that.list = that.list.concat(resInfo.message);
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
    },
    pagePrev: function() {
      var that = this;
      if (this.curpage - 1 != 0) {
        this.loading = true;
        this.curpage--;
        this.getList();
      }
    },
    pageNext: function() {
      var that = this;
      if (this.curpage + 1 <= this.totalpage) {
        this.loading = true;
        this.curpage++;
        this.getList();
      }
    },
    gotopage: function() {
      var that = this;
      if (0 < this.inputpage && this.inputpage <= this.totalpage) {
        this.loading = true;
        this.curpage = this.inputpage;
        this.getList();
      }
    },
  }
});