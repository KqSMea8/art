var vmAuth = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    statusRemark:{
      '-1': '审核失败',
      '1': '审核中...',
      '2': '审核通过',
      '0': ''
    },
    remarkIsShow: false, //提醒弹窗是否显示
    boxIsShow: false,  //弹窗蒙层是否显示
    authList: [
      {title:'艺术家认证', status:'', type:'1',name:'艺术家', memo:'', link0:'/auth/rule',link1:'/auth/first'},
      {title:'艺术机构认证', status:'', type:'2',name:'艺术机构', memo:'', link0:'/autharts/rule',link1:'/autharts/first'},
      {title:'策展人认证', status:'', type:'3',name:'策展人', memo:'', link0:'/authcurator/rule',link1:'/authcurator/first'}
    ],
    remarkInfo: {
      status: '',
      content: '',
      link: ''
    }
  },
  created: function () {
    this.getAuthInfo();
  },
  methods: {
    getAuthInfo: function () {
      var that = this;
      artzheAgent.call2('Auth/getApplyState',{},function(res) {
        
        if (res.code == 30000 && res.data.status == 1000) {
          console.log(res);
          var info = res.data.info;
          // agencyMemo:""
          // agencyState:"1"
          // artistMemo:""
          // artistState:"2"
          // plannerMemo:"策展人不通过"
          // plannerState:"-1"
          that.authList = [
            {title:'艺术家认证', status:info.artistState, type:'1',name:'艺术家', memo:info.artistMemo, link0:'/auth/rule',link1:'/auth/first'},
            {title:'艺术机构认证', status:info.agencyState, type:'2',name:'艺术机构', memo:info.agencyMemo, link0:'/autharts/rule',link1:'/autharts/first'},
            {title:'策展人认证', status:info.plannerState, type:'3',name:'策展人', memo:info.plannerMemo, link0:'/authcurator/rule',link1:'/authcurator/first'}
          ];

        } else {
          window.location.href = '/';
        }
      });
    },
    hideBox: function () {
      this.boxIsShow = false;
      this.remarkIsShow = false;
    },
    goToAuth: function (type, status, memo, link0, link1) {
      console.log(type, status, memo, link0, link1);
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
  }
});