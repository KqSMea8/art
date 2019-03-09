<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="艺术者">
  <meta name="description" content="艺术者">
  <title>作品系列</title>
  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
  <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
  <link href="/js/lib/element/index.css" rel="stylesheet">
  <link href="/css/global.css?v=2.0.0" rel="stylesheet">
  <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
  <style media="screen">
  .line1{
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }
  .main-wrap{
    box-shadow: 4px 1px 14px 4px rgba(0, 0, 0, .1);
  }
  .main-wrap .title a {
    font-size: 14px;
    color: #999;
  }
  .main-wrap .title a:hover{
    color: #f4ad23;
  }
  .addnewart{
    color: #fff;
  }
  .addnewart:hover{
    color: #fff;
  }
  .main-wrap .title span {
    font-size: 14px;
    color: #999;
  }
  .main-wrap .title span.now {
    color: #333;
  }
  .upload-button {
    position: absolute;
    right: 20px;
    top: 12px;
    padding: 0;
    line-height: 40px;
    height: 40px;
    width: 160px;
    color: #fff;
    z-index: 1;
    color: #fff;
    background-color: #f4ad23;
    border-color: #f4ad23;
  }
  .upload-button:hover{
    color: #fff;
    box-shadow: 1px 1px 1px #f4ad23;
  }
  .listbox{
    position: relative;
    min-height: 770px;
  }
  .nolist{
    font-size: 24px;
    color: #aaa;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
  }
  .listbox ul{
    padding: 30px 50px 80px 50px;
    margin: 0 auto;
  }
  .list{
    width: 252px;
    border-radius: 2px;
    float: left;
    margin: 20px 20px 0 0;
    box-shadow: 3px 5px 20px rgba(0, 0, 0, .2);
    transform: translateY(0px);
    transition: transform .4s ease;
  }
  .list:hover {
    transform: translateY(-5px);
  }
  .imgbox{
    position: relative;
    height: 252px;
    background-repeat: no-repeat;
    background-position: center;
    background-size: 100% auto;
    background-image: url('/image/upload/bgadd.png');
  }
  .img{
    position: absolute;
    z-index: 5;
    display: block;
    border: none;
    max-width: 100%;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
  }
  .upload-rImgmask {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,.2);
  }
  .list .myself {
    position: absolute;
    right: 12px;
    top: 8px;
    font-size: 14px;
    line-height: 30px;
    color: #fff;
    z-index: 5;
  }
  .list .icons.icon-myself {
    width: 30px;
    height: 30px;
    vertical-align: top;
    background-position: -365px -304px;
  }
  .time{
    padding-left: 10px;
    padding-right: 10px;
    position: absolute;
    bottom: 0;
    left: 0px;
    width: 100%;
    height: 30px;
    line-height: 30px;
    font-size: 14px;
    white-space: nowrap;
    text-overflow: ellipsis;
    color: #fff;
    background-color: rgba(0,0,0,0.6);
    z-index: 6;
  }
  .textbox{
    position: relative;
    padding: 21px 16px 24px;
    color: #999;
  }
  .textp{
    width: 190px;
    font-size: 18px;
    color: #333;
  }
  .iconclear{
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 20px;
    cursor: pointer;
  }
  .iconclear:hover{
    color: #F56C6C;
  }
  .shureremove{
    text-align: center;
  }
  .shureremove .el-message-box__btns{
    text-align: center;
  }
  .shureremove .el-button{
    height: 36px;
    font-size: 16px;
  }
  .shureremove .el-message-box__message p{
    font-size: 18px;
    color: #333;
  }
  .upload-page {
    position: absolute;
    bottom: 0;
    width: 100%;
    text-align: right;
    padding: 24px 50px 25px;
  }
  span.upload-num {
    font-size: 16px;
    color: #7b7b7b;
    text-align: center;
  }
  .upload-page .btn-prev, .upload-page .btn-next {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid #a9a9a9;
  }
  .el-pagination__editor2 {
    border-color: #b7b7b7;
  }
  .upload-jump.is-plain {
      height: 28px;
      line-height: 28px;
      padding: 0 6px;
      vertical-align: bottom;
      border-color: #b7b7b7;
  }
  </style>
</head>
<body>
  <div id="series" v-cloak>
    <!-- header-begin -->
    <header class="ysz-header">
      <div class="y-header">
        <div class="w clearfix">
          <a href="/index">
            <h1 class="y-head fl">
            <img class="logo" src="/image/logo.png" alt="logo">
            <span class="y-title">创作平台</span>
            </h1>
          </a>
          <div class="user fr">
            <div class="info">
              <img :src="myInfo.face">
              <span>@{{myInfo.name}}</span>
              <change-user-btn></change-user-btn>
              <a href="/passport/logout">退出</a>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- header-end -->
    <div class="w main">
      <div class="main-wrap" v-loading="loading" element-loading-text="拼命加载中...">
        <div class=" clearfix ">
          <h2 class="title"><a href="/upload/manage">作品管理</a><span>/<span class="now" style="color:#fbb231;">作品系列</span></span>
          </h2>
          <el-button class="upload-button"><a class="addnewart" :href="'/upload/addartwork?id='+id">+ 添加新作品</a></el-button>
        </div>
        <div class="listbox">
          <ul v-if="datalist.total>0" class="clearfix">
            <li v-for="(item,index) in datalist.artwork" class="fl list" :key="index">
              <div v-if="item.state == '2'" class="myself"><i class="icons icon-myself"></i>仅自己可见</div>
              <a :href="'/upload/record?id='+item.artistId">
                <div class="imgbox" :style="{ backgroundImage: 'url(' +item.coverUrl+ ')'}">
                  <h2 class="time line1">@{{item.last_update_time}}</h2>
                  <div class="upload-rImgmask"></div>
                </div>
              </a>
              <div class="textbox">
                <p class="textp line1">@{{item.name}}</p>
                <i class="el-icon-delete iconclear" @click="removeOutSeries(item.name,item.artistId)"></i>
              </div>
            </li>
          </ul>
          <h3 v-else class="nolist">您的作品系列还没有一幅作品哦！</h3>
          <div class="upload-page el-pagination" v-if='totalpage > 1'>
            <button type="button"  :class="[ curpage == 1 ? 'disabled' : '','btn-prev']" @click="pagePrev" ><</button>
            <span class="upload-num" >@{{curpage}}/@{{totalpage}}</span>
            <button type="button" :class="[ curpage == totalpage ? 'disabled' : '','btn-next']" @click="pageNext" >></button>
            <span class="el-pagination__jump">
              <input type="number" min="1" number="true" v-model='inputpage' class="el-pagination__editor el-pagination__editor2" style="width: 58px;">
              <a href="javascript:;" @click="gotopage"  class="el-button el-button--info is-plain upload-jump">
                <span>跳转</span>
              </a>
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- main-end -->
    <ysz-footer2></ysz-footer2>
  </div>
</body>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="/js/service/agent.js?v=2.1.6"></script>
<script src="/js/lib/vue.min.js"></script>
<script src="/js/lib/element/index.js?v=2.0.0"></script>
<script src="/js/common.js?v=3.9.2"></script>
<script type="text/javascript">
  var series_vm = new Vue({
    el: '#series',
    data: function(){
      return {
        myInfo: {
          uid: getCookie('userid'),
          name: getCookie('userName'),
          face: getCookie('userFace')
        },
        loading: true,
        id: '', //
        img: '/image/upload/bgadd.png', //默认封面图
        datalist: {
          artwork:[],
          total: 0
        },
        totalpage: 1,
        curpage: 1,
        inputpage: '',
      }
    },
    created: function(){
      this.id = GetRequest().id;
      this.getList();
    },
    methods: {
      getList: function(){ //画作系列列表
        var that = this;
        var obj = {
          series_id: this.id,
          page: this.curpage,
          perPageCount: 8,
        }
        artzheAgent.callMP('Artwork/getMyUpdateArtworkList', obj, function(res){
          if(res.code == 30000){
            var newlist = res.data.info;
            newlist.artwork.map(function(val,idx){
              if(val.coverUrl==''){
                val.coverUrl = that.img; //没有封面图时，添加默认封面图
              }
            })
            that.datalist = newlist;
            that.totalpage = newlist.maxpage
          }
          that.loading = false;
        })
      },
      removeOutSeries: function(title,id){ //移出画作弹出层
        var that = this;
        this.$confirm('是否要将 '+title+' 移出系列画作？',{
          customClass: 'shureremove',
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          center: true,
          callback :function(action,instance){
            if(action == 'confirm'){
              // TODO: XMLHttpRequest
              var obj = {
                series_id:that.id,
                artwork_id:id
              }
              // TODO: XMLHttpRequest
              artzheAgent.callMP('artwork/delSeriesArtwork', obj, function(res){
                if(res.code == 30000 && res.data.status ==1000){
                  window.location.href = '/upload/series?id='+that.id;
                }
              })
            }
          }
        })
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
  })
</script>
</html>
