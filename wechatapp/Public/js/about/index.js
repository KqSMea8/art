var vmApp = new Vue({
  el: '#app',
  data: {
    newsList: []
  },
  created: function() {
    this.getNews();
  },
  mounted: function() {
    
  },
  methods: {
    getNews: function () {
      var that = this;
      var api = '/Api/WebsiteConfig/getNews'; //获取网站最新动态
      var data = {
        page: 1,
        pagesize: 4
      };
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == '30000' && res.data.status == '1000') {
            var resInfo = res.data.info;
            that.newsList = resInfo;
          }
        }
      });
    },
  }
});