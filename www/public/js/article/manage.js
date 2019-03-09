var vmAuth = new Vue({
  el: '#manage',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    prodItems: [], //文章列表    
    prodCount: 0, //文章数量
    curpage: 1, //当前页
    totalpage: '', //总页数
    inputpage: '', //输入页码
    loading: true //数据加载开关
  },
  created: function() {
    var that = this;
    //获取产品列表

    this.getList();
    
  },
  methods: {
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
    getList: function() {
      var that = this;
      artzheAgent.call20('article/getmyarticlelist', {
        "page": that.curpage,
        'pagesize': 12
      }, function(response) {
        if (response.code == 30000 && response.data.status == 1000) {
          var prodItems = response.data.info.articles;
          prodItems.forEach(function(item) {
            var srcUrl = item.cover.split('?')[0];
            if (srcUrl == '' || srcUrl == '-1') {
              item.cover = '/image/upload/bgadd.png';
            }
          });
          that.prodItems = prodItems;
          that.loading = false;
          that.prodCount = response.data.info.total;
          that.totalpage = response.data.info.maxpage;
        } else {
          that.$message.error(response.code + ' : ' + response.message);
        }
      });
      console.log('现在在' + this.curpage + '页');
    },
    gotoAdd: function() {
      window.location.href = '/article/edit';
    },
  }
});