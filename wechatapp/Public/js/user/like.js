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
    list: [],
    page: 0,
    total: ''
  },
  created: function() {
    this.getList();
  },
  mounted: function() {

  },
  methods: {
    getList: function () {
      this.busy = true;

      var that = this;
      var api = '/Api/UserCenter/getMyLikeArtworkList';  //获取喜欢作品列表
      var data = {
        page: ++this.page,
        pagesize: 10
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info.data;
            that.total = res.data.info.total;
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