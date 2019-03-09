var vmApp = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace'),
    },
    isNext: true,
    applyInfo: {
      
    },
    artTotal: '',
    artistInfo: {
      name: getCookie('userName'),
      applyed: false,      //艺术家有没有申请过
      codeUrl: '/image/promote/template-qrcode.png',
      btnUrl: '/image/promote/template-btn.png'
    },
    applyed: false, //艺术家有没有申请过
    template: {
      btnUrl: '/image/promote/template-btn.png',
      codeUrl: '/image/promote/template-qrcode.png'
    },
    // templateInfo: {
    //   curIdx: '0',
    //   curUrl: '/image/promote/template-blank.png',
    //   list: [
    //   {num: '38', imgUrl:'/image/promote/template.png'},
    //   {num: '39', imgUrl:'/image/promote/template1.png'}
    //   ]
    // },
    promoteInfo: {
      // "id" : "11",
      // "artist" : "10",
      // "desc" : "我们的时代",
      // "img" : "//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/16/1492349370380.jpeg",
      // "one" : "//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/16/1492349370380.jpeg",//带按钮
      // "two" : "//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/16/14380.jpeg",//都不带
      // "three" : "//gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/04/16/149234930.jpeg",//带二维码
      // "status" :"",//1、审核中，2、审核失败，3、审核成功，4、用户终止推广
      // "url" : "gallery-77-艺术者"
    },
    stopBtnText: '是',
    applyBtnText: '申请',
    reBtnText: '重新编辑',
    boxIsShow: false,
    stopIsShow: false,
    remarkIsShow: false,
    fullscreenLoading: true //全屏加载动画是否显示
  },
  created: function () {
    var that = this;
      artzheAgent.call('Extension/getInfoByArtist', {artistid: this.myInfo.uid}, function(res) {
        console.log(res);
        that.fullscreenLoading = false;
        if (res.code == 30000) {
          if (res.data.status == 1000) {
            that.promoteInfo = res.data.info;
            if (res.data.info.status == '3' || res.data.info.status == '1' || res.data.info.status == '2') {
              that.applyed = true;
            } else if (res.data.info.status == '4') {
              that.applyed = false;
            }
          } 
          if (res.data.status == 1001) {
            that.applyed = false;
            // that.artTotal = res.data.artTotal;
          }
        }
      });
      artzheAgent.call2('UserCenter/getMyGalleryDetail', {}, function(res) { //获取作品总数
        // console.log(res);
        if (res.code == 30000) {
          that.artTotal = res.data.info.realtotal;
        }
      });
  },
  methods: {
    stopPromote: function () {
      var that = this;
      console.log('stopPromote');
      artzheAgent.call('Extension/stop', {id: this.promoteInfo.id}, function(res) {
        that.isSubmit = false;
        console.log(res);
        if (res.code == 30000) {
          that.stopBtnText = "跳转中...";
          that.boxIsShow = false;
          window.location.href = '/promote/index';
        }
      });
    },
    rePromote: function () {
      this.reBtnText = "跳转中...";
      window.location.href = '/promote/apply';
    },
    gotoPromote: function () {
      if (this.promoteInfo.status != '4') {
        if (this.artTotal == '0') {
          this.showRemark();
          return false;
        }
      }
      this.applyBtnText = "跳转中...";
      window.location.href = '/promote/apply';
    },
    downloadPic: function () {
      document.getElementById('download-url').click();
    },
    showStop: function () {
      this.boxIsShow = true;
      this.stopIsShow = true;
    },
    showRemark: function () {
      this.boxIsShow = true;
      this.remarkIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
      this.remarkIsShow = false;
      this.stopIsShow = false;
    },
    // chooseTemplate: function (index) {
    //   this.templateInfo.curIdx = index;
    //   this.templateInfo.curUrl = imgUrl;
    // },
    // goToSecond: function () {
    //   this.isNext = true;
    // },
  }
});