var vmApp = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace'),
    },
    activeName: 'first',

    //专题推荐页码
    topicPageInfo: {
      cur: 1, //当前页
      max: '', //总页数
      total: '', //专题数量
      input: '' //输入页码
    },
    myPageInfo: {
      cur: 1, //当前页
      max: '', //总页数
      total: '', //专题数量
      input: '' //输入页码
    },
    topicLoading: true,
    myLoading: false,

    //我的申请页码
    myPage: 1, //当前页
    myTotalPage: 1, //总页数
    myTopicCount: 1, //专题数量
    myInputPage: '', //输入页码

    isGetArtTotal: false,
    artTotal: '0',
    artistInfo: {
      name: getCookie('userName'),
      applyed: false, //艺术家有没有申请过
      codeUrl: '/image/promote/template-qrcode.png',
      btnUrl: '/image/promote/template-btn.png'
    },
    applyed: false, //艺术家有没有申请过
    template: {
      btnUrl: '/image/promote/template-btn.png',
      codeUrl: '/image/promote/template-qrcode.png'
    },
    subjectList: [{
      // "id": "3",
      // "sub_name": "风景", //主题名称
      // "sub_title": "自然风光推荐",
      // "cover": "http://gsy-other.oss-cn-beijing.aliyuncs.com/uploads/2017/05/08/1494232232265.png", //主题封面
      // "description": "自然美好的风光，是祖国欣欣向荣的象征", //主题描述
      // "start_time": "1493600400", //主题开始时间
      // "end_time": "1496152800", //主题结束时间
      // "applyStatus": 0 //状态0:未申请,1:申请中,2:申请通过,-1:申请未通过
    }],
    applyBtnText: [
      '申请',
      '申请中',
      '专题推荐中',
      '再次申请'
    ],
    myList: [
      // {
      //   "artistid": "45", //艺术品id
      //   "subid": "1", //专题id
      //   "sub_name": "风景", //风景
      //   "sub_title": "微距专场", //副标题
      //   "cover": "http://gsy-other.oss-cn-beijing.aliyuncs.com/uploads/2017/05/08/1494232232265.png",
      //   "description": "专题描述",
      //   "name": "作品名称",
      //   "shape": "1", //形状1方形2圆形
      //   "length": "100", //作品长度
      //   "width": "100", //作品宽度
      //   "diameter": "0", //直径
      //   "category_name": "油画" //作品类型
      // }
    ],
    boxIsShow: false,
    remarkIsShow: false
  },
  created: function() {
    var that = this;
    artzheAgent.callMP('UserCenter/getMyGalleryDetail', {}, function(res) {
      // console.log(res);
      if (res.code == 30000) {
        that.isGetArtTotal = true;
        that.artTotal = res.data.info.realtotal;
      }
    });
    this.getTopicPage();
    this.getMyPage();
  },
  methods: {
    handleTabClick: function() {

    },
    //专题推荐页面跳转
    topicPagePrev: function() {
      var that = this;
      this.topicLoading = true;
      if (this.topicPageInfo.cur - 1 != 0) {
        this.topicPageInfo.cur--;
        this.getTopicPage();
      }
    },
    topicPageNext: function() {
      var that = this;
      this.topicLoading = true;
      if (parseInt(this.topicPageInfo.cur) + 1 <= this.topicPageInfo.max) {
        this.topicPageInfo.cur++;
        this.getTopicPage();
      }
    },
    topicGotoPage: function() {
      var that = this;
      if (0 < this.topicPageInfo.input && this.topicPageInfo.input <= this.topicPageInfo.max && this.topicPageInfo.input != this.topicPageInfo.cur) {
        this.topicPageInfo.cur = this.topicPageInfo.input;
        this.getTopicPage();
      }
    },
    getTopicPage: function () {
      var that = this;
      artzheAgent.callMP('subject/subjectList', {
        "page": that.topicPageInfo.cur,
        'pagesize': 5
      }, function(res) {
        if (res.code == 30000 && res.data.status == 1000) {
          that.subjectList = res.data.info.list;
          that.topicPageInfo = {
            cur: res.data.info.page, //当前页
            max: res.data.info.maxpage, //总页数
            total: res.data.info.total, //专题数量
            input: '' //输入页码
          };
          that.topicLoading = false;
        } else {
          that.$message.error(res.code + ' : ' + res.message);
        }
      });
    },

    //我的申请页面跳转
    myPagePrev: function() {
      var that = this;
      if (this.myPageInfo.cur - 1 != 0) {
        this.myLoading = true;
        this.myPageInfo.cur--;
        this.getMyPage();
      }
    },
    myPageNext: function() {
      var that = this;
      if (parseInt(this.myPageInfo.cur) + 1 <= this.myPageInfo.max) {
        this.myLoading = true;
        this.myPageInfo.cur++;
        this.getMyPage();
      }
    },
    myGotoPage: function() {
      var that = this;
      if (0 < this.myPageInfo.input && this.myPageInfo.input <= this.myPageInfo.max && this.myPageInfo.input != this.myPageInfo.cur) {
        this.myLoading = true;
        this.myPageInfo.cur = this.myPageInfo.input;
        this.getMyPage();
      }
    },
    getMyPage: function () {
      var that = this;
      artzheAgent.callMP('subject/subjectAllow', {
        page: that.myPageInfo.cur,
        pagesize: 5
      }, function(res) {
        that.myLoading = false;
        console.log(res);
        if (res.code == 30000 && res.data.status == 1000) {
          that.myList = res.data.info.list;
          that.myList.forEach(function (item) {
            if (item.shape == '1') {  //方形
              if (item.length > 0 && item.width > 0) {
                item.size = item.length  + 'x' + item.width + 'cm,';
              } else {
                item.size = '';
              }
            } else if (item.shape == '2') { //圆形
              if (item.diameter > 0) {
                item.size = 'D=' + item.diameter + 'cm,';
              } else {
                item.size = '';
              }
            }
          });

          that.myPageInfo = {
            cur: res.data.info.page, //当前页
            max: res.data.info.maxpage, //总页数
            total: res.data.info.total, //专题数量
            input: '' //输入页码
          };
        }
      });
      console.log('现在在' + this.myPageInfo.cur + '页');
    },
    gotoApply: function(item) {
      if (!this.isGetArtTotal) {
        return false;
      }
      if (!this.artTotal || this.artTotal == '0') {
        this.showRemark();
        return false;
      }
      Storage.set('applySubjectItem', item);
      window.location.href = '/topic/apply';
    },
    showRemark: function() {
      this.boxIsShow = true;
      this.remarkIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.remarkIsShow = false;
      this.stopIsShow = false;
    },
    addActive: function(item) {
      this.$nextTick(function() {
        if (item.active) {
          Vue.set(item, 'active', false);
        } else {
          this.subjectList.forEach(function(item) {
            Vue.set(item, 'active', false);
          });
          this.myList.forEach(function (item) {
            Vue.set(item, 'active', false);
          });
          Vue.set(item, 'active', true);
        }
      });
    }
  },
  filters: {
    timeFormat: function(value) {
      value = value * 1000;
      var dateTime = new Date(value);
      var year = dateTime.getFullYear();
      var month = dateTime.getMonth() + 1;
      var day = dateTime.getDate();

      var timeSpanStr = year + '-' + month + '-' + day;

      return timeSpanStr;
    }
  }
});