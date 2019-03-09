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
      var api = '/Api/UserCenter/getMyFollowList'; //获取关注列表
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
            resInfo.forEach(function (item) {
              item.follow = 'Y';
              item.btnText = '已关注';
            });
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
    },
    overFollowText: function (index) {
      if (this.list[index].btnText == '已关注') {
        this.list[index].btnText = '取消关注';
      }
    },
    outFollowText: function (index) {
      if (this.list[index].btnText == '取消关注') {
        this.list[index].btnText = '已关注';
      }
    },
    toggleFollow: function(id, index) {
      var that = this;
      var data = {
        artistId: id
      };
      if (this.followClick) {
        return false;
      }
      this.followClick = true;
      if (that.list[index].follow == "Y") {
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
              that.list[index].follow = "N";
              that.list[index].btnText = '+ 关注';
              that.list[index].followTotal--;
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
              that.list[index].follow = "Y";
              that.list[index].btnText = '已关注';
              that.list[index].followTotal++;
            }
          }
        });
      }
    },
  },
  filters: {
    timeFormat: function(value) {
      value = value * 1000;
      var dateTime = new Date(value);
      // console.log(dateTime);
      var year = dateTime.getFullYear();
      var month = dateTime.getMonth() + 1;
      var day = dateTime.getDate();
      var hour = dateTime.getHours();
      var minute = dateTime.getMinutes();
      var second = dateTime.getSeconds();
      var now = new Date();
      var now_new = now.getTime(); //js毫秒数

      var milliseconds = 0;
      var timeSpanStr;

      timeSpanStr = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;

      return timeSpanStr;
    }
  }
});