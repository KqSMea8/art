var vmAuth = new Vue({
  el: '#manage',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    activeName: 'first',
    prodItems: [], //作品列表
    prodCount: 0, //作品数量
    curpage: 1, //当前页
    totalpage: '', //总页数
    inputpage: '', //输入页码

    prodItems2: [], //作品系列
    prodCount2: 0, //作品系列数量
    curpage2: 1, //作品系列当前页
    totalpage2: '', //作品系列总页数
    inputpage2: '', //作品系列输入页码
    seriesTitleEdit: false,//新标题flag开关
    titlelength20: false, //标题错误提示
    newSeriesTitle: '', //新标题
    titleinfo: {}, //点击修改时标题和id获取
    loading: true, //数据加载开关
    loading2:true,
    maskseen: false, //预览显示开关
    alertseen: false, //弹出框提示开关
    newseen: false, //上传新作品弹窗
    editseen: false,
    maskTxt: '去上传',
    isSetCover: false,
    onlySelf: false, //眼睛按钮是否可点击
    onlyscreen:false, //隐藏或显示作品提示弹出层
    ischangeeyes:false, //是否改变显示状态
    clickdInfo:{},
    isok: false,
    form1: { //规则字段
      name: '', //画作名称
      category: '', //作品类型
      permission: '', //作品权限
      desc: '' //画作介绍
    },
    rules1: { //字段规则
      name: [{
        required: true,
        message: '请填写画作名称',
        trigger: 'blur'
      }],
      category: [{
        type: 'number',
        required: true,
        message: '请选择画作类别',
        trigger: 'change'
      }],
      permission: [{
        type: 'number',
        required: true,
        message: '请选择作品权限',
        trigger: 'change'
      }],
      desc: [{
        required: true,
        message: '请输入画作简介',
        trigger: 'blur'
      }],
    },
    categoryOptions: [{
      "id": 1,
      "sort": 0,
      "value": "油画"
    }, {
      "id": 2,
      "sort": 5,
      "value": "水彩"
    }, {
      "id": 3,
      "sort": 10,
      "value": "插画"
    }, {
      "id": 4,
      "sort": 15,
      "value": "素描"
    }, {
      "id": 5,
      "sort": 20,
      "value": "工笔"
    }, {
      "id": 6,
      "sort": 25,
      "value": "国画"
    }, {
      "id": 7,
      "sort": 30,
      "value": "版画"
    }, {
      "id": 8,
      "sort": 35,
      "value": "漆画"
    }, {
      "id": 9,
      "sort": 40,
      "value": "丙烯"
    }, {
      "id": 10,
      "sort": 45,
      "value": "其它"
    }], //画作类别选项
    permissionOptions: [{
        "id": 1,
        "value": "所有人可见"
      }, {
        "id": 2,
        "value": "仅自己可见"
      }] //权限选项
  },
  created: function() {

    var that = this;
    //获取产品列表
    artzheAgent.callMP('Artwork/getMyUpdateArtworkList', {
      "page": that.curpage,
      'perPageCount': 12
    }, function(response) {
      if (response.code == 30000 && response.data.status == 1000) {
        that.loading = false;
        var prodItems = response.data.info.artwork;
        that.totalpage = response.data.info.maxpage; //获取到总页数
        that.prodCount = response.data.info.total; //获取总数量
        prodItems.forEach(function(item) {
          var srcUrl = item.coverUrl.split('?')[0];
          if (srcUrl == '' || srcUrl == '-1') {
            item.coverUrl = '/image/upload/bgadd.png';
          }
        });
        that.prodItems = prodItems;
        //获取产品总数量
        artzheAgent.call2('UserCenter/getMyGalleryDetail', {}, function(response) {
          if (response.code == 30000 && response.data.status == 1000) {
            that.loading = false;
            // that.prodCount = response.data.info.artTotal;
            //that.totalpage = Math.ceil(that.prodCount / 9);
            if (response.data.info.isSetCover === 'Y') {
              that.isSetCover = true;
            }
            that.isok = true;
          } else {
            that.$message.error(response.code + ' : ' + response.message);
          }
        })
      } else {
        that.$message.error(response.code + ' : ' + response.message);
      }
    })
    this.getList2()
  },
  methods: {
    getlistTab: function(tab){
      console.log(tab.name)
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
    getList: function() {
      var that = this;
      artzheAgent.callMP('Artwork/getMyUpdateArtworkList', {
        "page": that.curpage,
        'perPageCount': 12
      }, function(response) {
        if (response.code == 30000 && response.data.status == 1000) {
          var prodItems = response.data.info.artwork;
          prodItems.forEach(function(item) {
            var srcUrl = item.coverUrl.split('?')[0];
            if (srcUrl == '' || srcUrl == '-1') {
              item.coverUrl = '/image/upload/bgadd.png';
            }
          });
          that.prodItems = prodItems;
          that.loading = false;
        } else {
          that.$message.error(response.code + ' : ' + response.message);
        }
      });
      console.log('现在在' + this.curpage + '页');
    },
    gotoEdit: function(id, isEdit) {

    },
    gotoAdd: function() {
      if (!this.checkOk()) {
        return false;
      }
      // this.maskseen = true;
      // this.alertseen = false;
      // this.editseen = false;
      // this.newseen = true;

      window.location.href = '/upload/addartwork';

      // if (this.prodCount > 0) {
      //   window.location.href = '/upload/addupdate';
      // } else {
      //   window.location.href = '/upload/addartwork';
      // }
      // window.location.href = '/upload/edit';

    },
    addSeries: function(){
      console.log('series clicked')
      // window.location.href = '/upload/addartwork';
    },
    showNewPro: function() {
      this.checkOk();
      this.maskseen = true;
      this.alertseen = false;
      this.editseen = false;
      this.newseen = true;
      // window.location.href = '/upload/edit';

    },
    showEdit: function() {
      this.checkOk();
      this.maskseen = true;
      this.alertseen = false;
      this.newseen = false;
      this.editseen = true;
    },
    checkOk: function() {
      //判断是否获取到数据
      if (this.isok == false) {
        return false;
      }
      //判断是否有画廊封面
      if (this.isSetCover == false) {
        this.maskseen = true;
        this.newseen = false;
        this.editseen = false;
        this.alertseen = true;
        return false;
      }
      return true;
    },
    goUpload: function() {
      this.maskTxt = '跳转中...'
      window.location.href = '/user/setcover';
    },
    closemaskSeen: function() { //关闭预览蒙层
      this.maskseen = false;
      this.alertseen = false;
      this.newseen = false;
      this.editseen = false;
    },
    changeOnlySelf: function(){ //可见=>不可见  或 不可见=>可见
      var that = this;
      var id = this.clickdInfo.id;
      var statue = this.clickdInfo.statue;
      var ojbk={};//改变可见为不可见obj
      if(this.ischangeeyes){
        if(statue==1){
          ojbk.artworkId = id;
          ojbk.state = 2;
        }else{
          ojbk.artworkId = id;
          ojbk.state = 1;
        }
        if(this.onlySelf){ //避免重复点击
          return false
        }
        this.onlySelf = true;
        artzheAgent.callMP('Artwork/changeState',ojbk,function(res){
          if(res.code==30000){
            for(var i in that.prodItems){
              if(that.prodItems[i].artistId == id){
                that.prodItems[i].state = ojbk.state;
              }
            }
            that.onlySelf = false; //把按钮置为（可点击）状态
          }
        },function(err){ //ajax错误把按钮置为（可点击）状态
          that.onlySelf = false;
        })
        this.ischangeeyes = false;
        this.onlyscreen = false;
      }
    },
    geteyesInfo: function(id,statue){ //获取当前点击的眼睛项的数据
      this.onlyscreen = true;
      this.ischangeeyes = true;
      this.clickdInfo={
        id:id,
        statue:statue
      }
    },
    handleeyediabled: function(){ //点击关闭眼睛
      this.onlyscreen = false;
      this.ischangeeyes = false;
    },
    totoping: function(obj,index){ //置顶
      var that = this;
      artzheAgent.callMP('Artwork/settop', {artwork_id: obj.artistId},function(res){
        if(res.code == 30000 && res.data.status ==1000){
          that.curpage = 1;
          that.getList();
        }
      },
      function(error){
        that.$message({
          type:'error',
          message:error
        })
      })
    },
    getList2: function() {
      var that = this;
      artzheAgent.callMP('Artwork/getArtworkSeriesPage', {
        "page": that.curpage2,
        'pagesize': 12
      }, function(response) {
        if (response.code == 30000 && response.data.status == 1000) {
          var prodItems = response.data.info.list;
          that.totalpage2 = response.data.info.maxpage; //获取到总页数
          that.prodCount2 = response.data.info.total; //获取总数量
          prodItems.forEach(function(item) {
            if(item.cover == ''){
              item.cover = '/image/upload/bgadd.png';
            }
          });
          that.prodItems2 = prodItems;
          that.loading2 = false;
        } else {
          that.$message.error(response.code + ' : ' + response.message);
        }
      });
    },
    pagePrev2: function() {
      var that = this;
      if (this.curpage2 - 1 != 0) {
        this.loading2 = true;
        this.curpage2--;
        this.getList2();
      }
    },
    pageNext2: function() {
      var that = this;
      if (this.curpage2 + 1 <= this.totalpage2) {
        this.loading2 = true;
        this.curpage2++;
        this.getList2();
      }
    },
    gotopage2: function() {
      var that = this;
      if (0 < this.inputpage2 && this.inputpage2 <= this.totalpage2) {
        this.loading2 = true;
        this.curpage2 = this.inputpage2;
        this.getList2();
      }
    },
    newtitle: function(id,name){
      this.seriesTitleEdit = true;
      this.newSeriesTitle = name; //输入框显示当前名字
      this.titleinfo = {
        series_id: id,
        series_name: name
      }
    },
    checktitle: function(){
      if(this.newSeriesTitle.length>20){
        this.titlelength20 = true;
      }else{
        this.titlelength20 = false;
      }
    },
    changetitle: function(){
      var that = this;
      if(this.newSeriesTitle.length>20){

        return false
      }
      this.newSeriesTitle = this.newSeriesTitle.replace(/[^\u4e00-\u9fa5a-zA-Z\d]+/g ,''); //去除不是字母数字中文的字符
      if(this.newSeriesTitle == this.titleinfo.series_name || this.newSeriesTitle ==''){
        this.seriesTitleEdit = false;
        return false
      };
      artzheAgent.callMP('Artwork/editArtworkSeries',this.titleinfo,function(res){
        if(res.code == 30000 &&res.data.status == 1000){
          that.prodItems2.each(function(index,value){
            if(that.titleinfo.series_id == res.data.series_id){
              that.titleinfo.series_name == res.data.series_name;
            }
          })
        }else{
          that.$message({
            type:'error',
            message:'修改系列名失败'
          })
        }
        that.seriesTitleEdit = false;
      });
    },
    canclechange: function(){
      this.titlelength20 = false;
      this.seriesTitleEdit = false;
      
    },
  }
});
