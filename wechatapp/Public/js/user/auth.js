var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
    statusRemark:{
      '-1': '审核失败',
      '1': '审核中...',
      '2': '审核通过',
      '0': ''
    },
    mpDomain: switchDomin('mp'),
    remarkIsShow: false, //提醒弹窗是否显示
    boxIsShow: false,  //弹窗蒙层是否显示
    authList: [
      {title:'艺术家认证', status:'', type:'1',name:'艺术家', memo:'', link0:'',link1:''},
      {title:'艺术机构认证', status:'', type:'2',name:'艺术机构', memo:'', link0:'',link1:''},
      {title:'策展人认证', status:'', type:'3',name:'策展人', memo:'', link0:'',link1:''}
    ],
    remarkInfo: {
      status: '',
      content: '',
      link: ''
    }
  },
  created: function() {
    this.getAuthInfo();
  },
  mounted: function() {


  },
  methods: {
    getAuthInfo: function () {
      var that = this;
      var api = '/Api/UserCenter/getApplyState'; //获取认证信息
      var data = {
      };
      var mp = this.mpDomain;
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          // console.log(res);
          if (res.code == 30000 && res.data.status == 1000) {
            // console.log(res);
            var info = res.data.info;
            that.authList = [
              {title:'艺术家认证', status:info.artistState, type:'1',name:'艺术家', memo:info.artistMemo, link0: mp + '/auth/rule',link1: mp + '/auth/first'},
              {title:'艺术机构认证', status:info.agencyState, type:'2',name:'艺术机构', memo:info.agencyMemo, link0: mp + '/autharts/rule',link1: mp + '/autharts/first'},
              {title:'策展人认证', status:info.plannerState, type:'3',name:'策展人', memo:info.plannerMemo, link0: mp + '/authcurator/rule',link1: mp + '/authcurator/first'}
            ];

          } else {
            window.location.href = '/';
          }
        }
      });
    },
    hideBox: function () {
      this.boxIsShow = false;
      this.remarkIsShow = false;
    },
    goToAuth: function (type, status, memo, link0, link1) {
      // console.log(type, status, memo, link0, link1);
      if (status == 2) return false; //已认证成功不进行任何操作
      if (status == 0) { //未申请
        window.location.href = link0;
      }
      if (status == 1) { //审核中
        this.remarkInfo = {
          status: status,
          content: '认证'+ this.authList[type-1].name + '信息正在审核中<br>请耐心等待~',
          link: 'javascript:;'
        };
        this.boxIsShow = true;
        this.remarkIsShow = true;
      }
      if (status == -1) { //审核失败
        this.remarkInfo = {
          status: status,
          content: '审核不通过<br>' + memo,
          link: this.authList[type-1].link1
        };
        this.boxIsShow = true;
        this.remarkIsShow = true;
      }
    } 
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