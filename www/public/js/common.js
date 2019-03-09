// var token = getCookie('token');

// if (!token) {
//   getToken();
// }

// //避免 CSRF 攻击
// $.ajaxSetup({
//   headers: {
//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//   }
// });

// // getToken
// function getToken() {
//   $.ajax({
//     headers: {
//       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     },
//     type: "POST",
//     url: "/public/getToken",
//     async: false, //同步获取
//     data: {},
//     success: function(res) {
//       if (res.code = "30000") {
//         console.log('getToken.data', res.data);
//         token = res.data.token;
//       }
//     }
//   });
// }
console.log('注意！')
console.log('本环境采用的element-ui版本为1.4.13 ')
console.log('注意！')
var ossInfo = {
  action: 'https://artzhe.oss-cn-shenzhen.aliyuncs.com',
  audioAction: 'https://artaudio.oss-cn-shenzhen.aliyuncs.com'
};

// 默认环境
var mEnv = switchDomin('m').indexOf('local-') > -1 ? 'https://dev-m.artzhe.com' : switchDomin('m');

//各环境domain转换
function switchDomin(str) { //str:mp|m|www|api
  var myDomin, aDomin, aFirst, sFirst, sFirstNew;

  aDomin = window.location.host.split('.'); //域名数组
  sFirst = aDomin[0]; //获取二级域名前缀
  if (aDomin.length > 2) {
    aDomin.shift();
  }
  sMain = aDomin.join('.');
  aFirst = sFirst.split('-');
  sFirstNew = '';

  if (aFirst.length > 1) {
    sFirstNew = aFirst[0] + '-';
  }
  myDomin = 'https:' + '//' + sFirstNew + str + '.' + sMain;

  return myDomin;
}

// 获取当前日期
function getCurentDate() {
  var now = new Date();

  var year = now.getFullYear();       //年
  var month = now.getMonth() + 1;     //月
  var day = now.getDate();            //日
  var hh = now.getHours();            //时
  var mm = now.getMinutes();          //分

  var clock = year + "年";

  if(month < 10) {
    clock += "0";
  }

  clock += month + "月";
  if(day < 10) {
    clock += "0";
  }

  clock += day + "日";

  // if(hh < 10) {
  //   clock += "0";
  // }
  // clock += " " + hh + ":";

  // if (mm < 10) {
  //   clock += '0';
  // }
  // clock += mm;

  return clock;
}

//判断字符串内是否含有《，没有加上《》
function checkMark(str) {
  if (str.indexOf('《') == -1) {
    str = '《' + str + '》';
  }
  return str;
}


// vue全局组件
// 注册一个空的 Vue 实例，作为 ‘中转站’
var eventBus = new Vue({});

//插入艺术者控件弹窗
Vue.component('insert-artzhe-box', {
  template: '<div class="maskWrap" v-show="searchSeen" style="display: none">'+
              '<div class="mask" @click="closeSearchSeen"></div>'+
              '<div class="search-wrap" v-show="searchSeen">'+
                '<div class="title-tab">'+
                  '<ul class="tab-navs clearfix">'+
                    '<li class="tab-nav selected">'+
                      '<a href="javascript:;">插入</a>'+
                    '</li>'+
                  '</ul>'+
                '</div>'+
                '<div class="search-con">'+
                  '<div class="frm_control_group">'+
                    '<label for="" class="frm_label">插入内容</label>'+
                    '<div class="frm_controls frm_vertical_lh">'+
                        '<label v-for="(item,index) in typeList" @click="chooseType(item.type)" :class="[item.selected? \'selected\' : \'\', \'frm_radio_label\']" :for="\'checkbox\' + index">'+
                            '<i class="icon_radio"></i>'+
                            '<span class="lbl_content">{{item.text}}</span>'+
                            '<input type="radio" name="link_type" :value="index" class="frm_radio" :id="\'checkbox\' + index">'+
                        '</label>'+
                    '</div>'+
                  '</div>'+
                  '<div class="frm_control_group">'+
                    '<label for="" class="frm_label">搜索</label>'+
                    '<div v-if="isArtistCircle==false" class="frm_controls">'+
                        '<span class="js_acc_search_main frm_input_box search_input_box search with_del append" style="display: block;">'+
                            '<a style="display: block;" class="js_acc_search_del del_btn" href="javascript:">'+
                              '<i class="icon_search_del"></i>'+
                            '</a>'+
                            '<a @click="gotoSearch(1)" href="javascript:void(0);" class="js_acc_search_btn frm_input_append">'+
                              '<i class="icon16_common search_gray"></i>'+
                            '</a>'+
                            '<input v-model="searchInputText" @keyup.enter="gotoSearch(1)" type="text" placeholder="输入名称，回车进行搜索" class="frm_input js_acc_search_input valid">'+
                        '</span>'+
                    '</div>'+
                    '<div v-else-if="isArtistCircle==true" class="frm_controls">'+
                    '<el-date-picker v-model="timeSelect" type="date" :editable="false" :picker-options="timeLines" class="pickerOptions1 frm_input_box.search" placeholder="选择日期" format @focus="cleardatavalue" @change="gotoDateSearch(1)"></el-date-picker>'+
                        '<span class="js_acc_search_main frm_input_box search_input_box search with_del2 append" style="display: inline-block;">'+
                            '<a style="display: block;" class="js_acc_search_del del_btn" href="javascript:">'+
                              '<i class="icon_search_del"></i>'+
                            '</a>'+
                            '<a @click="gotoSearch(1)" href="javascript:void(0);" class="js_acc_search_btn frm_input_append">'+
                              '<i class="icon16_common search_gray"></i>'+
                            '</a>'+
                            '<input v-model="searchInputText" @keyup.enter="gotoSearch(1)" @focus="clearsearchedvalue" type="text" placeholder="输入用户名搜索" class="frm_input js_acc_search_input valid plcolor">'+
                        '</span>'+
                    '</div>'+
                  '</div>'+
                  '<ul v-if="isArtistCircle==false" class="search-list topline" v-loading="searchLoading" element-loading-text="拼命加载中">'+
                    '<li v-for="item in searchInfo.list" class="search-item">'+
                      '<div v-if="activeType == \'artwork\' || activeType == \'article\' || activeType == \'artwork_update\'">'+
                        '<span class="search-col1">{{item.title}}</span>'+
                        '<span class="search-col2">{{item.user.nickname}}</span>'+
                        '<span class="search-col3 addbtnbox1" @click="addToRich(item)"><span class="add-btn1">添加</span></span>'+
                      '</div>'+
                      '<div v-else>'+
                        '<span class="search-col1">{{item.nickname}}</span>'+
                        '<span class="search-col2">{{item.category_names}}艺术家</span>'+
                        '<span class="search-col3 addbtnbox1" @click="addToRich(item)"><span class="add-btn1">添加</span></span>'+
                      '</div>'+
                    '</li>'+
                  '</ul>'+
                  '<ul v-else-if="isArtistCircle==true" class="search-list" v-loading="searchLoading" element-loading-text="拼命加载中">'+
                    '<li v-for="item in searchInfo.list" class="search-item linenone">'+
                      '<div v-if="item.type==2" class="picAndText">'+
                        '<img :src="item.images_url[0]">'+
                        '<div class="contentDiv">'+
                          '<div class="ttcontent ">'+
                            '<p class="pt nowrap1">{{item.user.nickname}}</p>'+
                            '<p class="ptm">{{item.datetime}}</p>'+
                            '<p class="pc nowrap1">{{item.excerpt}}</p>'+
                          '</div>'+
                          '<span class="search-col3 addbtnbox1" @click="addToRich(item)"><span class="add-btn1">添加</span></span>'+
                        '</div>'+
                      '</div>'+
                      '<div v-if="item.type==3" class="onlyVedio">'+
                        '<div class="contentvideoimg">'+
                          '<img :src="item.video_poster">'+
                          '<div class="playbtnimg"></div>'+
                        '</div>'+
                        '<div class="contentDiv">'+
                          '<div class="ttcontent ">'+
                          '<p class="pt nowrap1">{{item.user.nickname}}</p>'+
                          '<p class="ptm">{{item.datetime}}</p>'+
                          '<p class="pc nowrap1">{{item.excerpt}}</p>'+
                          '</div>'+
                          '<span class="search-col3 addbtnbox1" @click="addToRich(item)"><span class="add-btn1">添加</span></span>'+
                        '</div>'+
                      '</div>'+
                      '<div v-if="item.type==1" class="onlyAndText">'+
                        '<div class="contentDiv">'+
                          '<div class="ttcontent ">'+
                          '<p class="pt nowrap1">{{item.user.nickname}}</p>'+
                          '<p class="ptm">{{item.datetime}}</p>'+
                          '<p class="pc nowrap1">{{item.excerpt}}</p>'+
                          '</div>'+
                          '<span class="search-col3 addbtnbox1" @click="addToRich(item)"><span class="add-btn1">添加</span></span>'+
                        '</div>'+
                      '</div>'+
                      '<div v-if="item.type>10" class="onlyAndText">'+
                        '<div class="contentDiv">'+
                          '<div class="ttcontent ">'+
                          '<p class="pt nowrap1">{{item.user.nickname}}</p>'+
                          '<p class="ptm">{{item.datetime}}</p>'+
                          '<p class="pc looklikelink nowrap1">链接：{{item.share_link.title}}</p>'+
                          '</div>'+
                          '<span class="search-col3 addbtnbox1" @click="addToRich(item)"><span class="add-btn1">添加</span></span>'+
                        '</div>'+
                      '</div>'+
                    '</li>'+
                  '</ul>'+
                  '<div class="upload-page uppage1 el-pagination" v-if="searchInfo.maxpage > 1">'+
                    '<button type="button" v-show="searchInfo.page > 1"  :class="[ searchInfo.page == 1 ? \'disabled\' : \'\',\'btn-prev\']" @click="pagePrev()" ></button>'+
                    '<span class="upload-num" >{{searchInfo.page}}/{{searchInfo.maxpage}}</span>'+
                    '<button type="button" v-show="searchInfo.page != searchInfo.maxpage " :class="[ searchInfo.page == searchInfo.maxpage ? \'disabled\' : \'\',\'btn-next\']" @click="pageNext()" ></button>'+
                    '<span class="el-pagination__jump "><input type="number" min="1" number="true" v-model="inputpage" class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="gotoPage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>'+
                  '</div>'+
                '</div>'+
                '</ul>'+
              '</div>'+
           '</div>',
  data: function () {
    return {
      isArtistCircle:false,
      timeSelect:null, //选择时间
      searchLoading: false,
      searchSeen: false,
      activeType: 'artwork',
      searchInputText: '', //搜索框值
      searchInfo: {
        type: '',
        list:[],
        page: 1,
        pagesize:4,
        maxpage:1
      },
      searchErrorText: '',
      typeList: [
        {type: 'artwork', text: '作品', selected: true},
        {type: 'article', text: '文章', selected: false},
        {type: 'artwork_update', text: '创作花絮', selected: false},
        {type: 'artist', text: '艺术家', selected: false},
        {type: 'art_circle', text: '艺术圈', selected: false}
        // {type: 'artwork', text: '作品'},
        // {type: 'artwork', text: '作品'}
      ],
      totalpage: 6,
      curpage: 1,
      inputpage: '',
      timeLines: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      },
    };
  },
  created: function () {

  },
  mounted: function() {
    console.log(this.searchInputText)
    $('.artquan a').on('click',function(){return false}) //禁止点击

    eventBus.$on('showSearch', function() {
      this.showSearch();
    }.bind(this));
  },
  methods: {
    showSearch: function () {
      this.searchSeen = true;
    },
    chooseType: function (type) {
      this.searchInputText='';
      this.timeSelect =null;
      var that = this;
      this.typeList.forEach(function (item) {
        if (item.selected == true && that.activeType == item.type) {
          return false;
        } else {
          item.selected = false;
          if (item.type == type) {
            item.selected = true;
            that.activeType = type;
            if(type == 'art_circle'){
              that.isArtistCircle = true;
            }else {
              that.isArtistCircle = false;
            }
          }
          that.resetSearch();
        }
      });
    },
    resetSearch: function () {
      this.searchInfo = {
        type: '',
        list:[],
        page: 0,
        pagesize:4,
        maxpage:1
      };
    },
    gotoSearch: function (page) {
      var that = this;

      if (that.searchInputText == '') {
        that.$message({
          message: '关键字不能为空'
        });
      }
      var data = {
        type: that.activeType,
        page: page ? page : 1,
        pagesize: 4,
        keyword: that.searchInputText
      };
      that.searchLoading = true;
      if (that.activeType == 'artwork' || that.activeType == 'article' || that.activeType == 'artwork_update' || that.activeType == 'art_circle') {
        artzheAgent.callMP('Article/ImportContentList', data, function(response) {
          that.searchLoading = false;
          if (response.data.status == 1000 && response.code == 30000) {
            if (response.data.info.page == 1 && response.data.info.list.length == 0) {
              that.$message({
                message: '没有相关内容'
              });
            }

            that.searchInfo = response.data.info;
        }
        }, function(res) {
          that.searchLoading = false;
        });
      } else {
        artzheAgent.callMP('Article/ImportUserList', data, function(response) {
          that.searchLoading = false;
          if (response.data.status == 1000 && response.code == 30000) {
            if (response.data.info.page == 1 && response.data.info.list.length == 0) {
              that.$message({
                message: '没有相关内容'
              });
            }
            that.searchInfo = response.data.info;

        }
        }, function(res) {
          that.searchLoading = false;
        });
      }

    },
    gotoDateSearch: function (page) {
      // console.log('ajax:'+ this.timeSelect)
      var that = this;
      if (this.timeSelect == null) {

        return
      }
      var data = {
        type: that.activeType,
        page: page ? page : 1,
        pagesize: 4,
        keyword: '',
        date: that.changedate(that.timeSelect)
      };
      that.searchLoading = true;
      if (that.activeType == 'art_circle') {
        artzheAgent.callMP('Article/ImportContentList', data, function(response) {
          that.searchLoading = false;
          if (response.data.status == 1000 && response.code == 30000) {
            if (response.data.info.page == 1 && response.data.info.list.length == 0) {
              that.$message({
                message: '没有相关内容'
              });
            }
            that.searchInfo = response.data.info;
            console.log(that.searchInfo)
        }
        }, function(res) {
          that.searchLoading = false;
        });
      }

    },
    pagePrev: function () {
      if (this.searchInfo.page <= 1) return;
      if(this.timeSelect!=null){
        this.gotoDateSearch(--this.searchInfo.page)
      }else{
        this.gotoSearch(--this.searchInfo.page);
      }

      // this.gotoSearch(--this.searchInfo.page);
    },
    pageNext: function () {
      if (this.searchInfo.page >= this.searchInfo.maxpage) return;
      console.log(this.timeSelect)
      if(this.timeSelect!=null){
        this.gotoDateSearch(++this.searchInfo.page)
      }else{
        this.gotoSearch(++this.searchInfo.page);
      }
      // this.gotoSearch(++this.searchInfo.page);
    },
    gotoPage: function () {
      if (this.inputpage > this.searchInfo.maxpage || this.inputpage < 1) {
        this.$message({
          message: '请输入正确的页码'
        });
        return false;
      }
      if(this.timeSelect!=null){
        this.gotoDateSearch(this.inputpage)
      }else{
        this.gotoSearch(this.inputpage);
      }

    },
    closeSearchSeen: function () {
      this.searchSeen = false;
    },
    addToRich: function (item) {
      var keyLink = '', keyType = '';
      if (this.activeType == 'artwork_update') {
        keyLink = '/artwork/update/' + item.id;
        keyType = 'artworkUpdate';
      } else if (this.activeType == 'artwork') {
        keyLink = '/artwork/detail/' + item.id;
        keyType = 'artworkDetail';
      } else if (this.activeType == 'article') {
        keyLink = '/article/detail/' + item.id;
        keyType = 'articleDetail';
      } else if (this.activeType == 'artist') {
        keyLink = '/gallery/detail/' + item.id;
        keyType = 'galleryDetail';
      }else if (this.activeType == 'art_circle') {

        keyLink = '/article/detail/' + item.id;
        keyType = 'artCircleDetail';
      }
      var data = {
        link: mEnv + keyLink,
        type: keyType,
        id: item.id
      };
      var strData = JSON.stringify(data);

      var content = '';
      if (this.activeType == 'artwork_update') {
        content = '<h4 contenteditable="false" class="search-update"><a target="_blank" data-artzhe-type="link" data-artzhe-typeDetail="' + data.type +'" + data-artzhe-id="' + data.id + '" contenteditable="false" href="' + data.link + '">' +
          '<p class="search-title">'+ item.user.nickname + item.title + '</p>' +
          '<p class="search-detail">'+ item.excerpt +'</p>' +
        '</a></h4><div><br></div>';
      } else if (this.activeType == 'artist') {
        content = '<h4 contenteditable="false" class="search-user"><a target="_blank" data-artzhe-type="link" data-artzhe-typeDetail="' + data.type +'" + data-artzhe-id="' + data.id + '" contenteditable="false" href="' + data.link + '">'+
          '<p class="user-avatar" style="background-image: url('+ item.faceUrl +')"></p>'+
          '<h4 class="search-user-info">'+
            '<p class="user-name">'+ item.nickname +'</p>'+
            '<p class="user-type">'+ item.category_names +'艺术家</p>'+
          '</h4>'+
        '</a></h4><div><br></div>';
      } else if (this.activeType == 'article' || this.activeType == 'artwork') {
        content = '<h4 contenteditable="false" class="search-link"><a target="_blank" data-artzhe-type="link" data-artzhe-typeDetail="' + data.type +'" + data-artzhe-id="' + data.id + '" contenteditable="false" href="' + data.link + '">'+
        item.title +
        '</a></h4><div><br></div>';
      }else if (this.activeType == 'art_circle') {
        //
        if(item.type==1){
          content ='<div style="text-align:center;display:block;"><section contenteditable="false" class="search-user artquan contentDivforUE" id="artquan">'+
          '<a target="_blank" class="abc" data-artzhe-type="link" data-artzhe-typeDetail="' + data.type +'" + data-artzhe-id="' + data.id + '" contenteditable="false" href="javascript:;">'+
            '<section class="ttcontentforUE noleftpadding" contenteditable="false">'+
              '<p class="ptforUE nowrap1" contenteditable="false">'+item.user.nickname+'</p>'+
              '<p class="ptmforUE" contenteditable="false">'+item.datetime+'</p>'+
              '<p class="pcforUE nowrap1" contenteditable="false">'+item.excerpt+'</p>'+
            '</section>'+
            '<section class="contentDivforUEboxgo" contenteditable="false">'+
              '<p class="goxiangqing" contenteditable="false">查看详情 &gt;</p>'+
              '<section class="smalltrp" contenteditable="false">'+
                '<p contenteditable="false">'+item.like_total+'</p>'+
                '<p contenteditable="false">'+item.comment_total+'</p>'+
              '</section>'+
            '</section>'+
            '</a>'+
          '</section></div><p><br></p>';
        }
        if(item.type==2){
          content ='<div style="text-align:center;display:block;"><section contenteditable="false" class="search-user artquan contentDivforUE" id="artquan">'+
          '<a target="_blank" class="abc" data-artzhe-type="link" data-artzhe-typeDetail="' + data.type +'" + data-artzhe-id="' + data.id + '" contenteditable="false" href="javascript:;">'+
            '<section class="playbtnbxo" contenteditable="false">'+
              '<img class="contentimg" contenteditable="false" src="'+item.images_url[0]+'"/>'+
            '</section>'+
            '<section class="ttcontentforUE " contenteditable="false">'+
              '<p class="ptforUE nowrap1" contenteditable="false">'+item.user.nickname+'</p>'+
              '<p class="ptmforUE" contenteditable="false">'+item.datetime+'</p>'+
              '<p class="pcforUE nowrap1" contenteditable="false">'+item.excerpt+'</p>'+
            '</section>'+
            '<section class="contentDivforUEboxgo" contenteditable="false">'+
              '<p class="goxiangqing" contenteditable="false">查看详情 &gt;</p>'+
              '<section class="smalltrp" contenteditable="false">'+
                '<p contenteditable="false">'+item.like_total+'</p>'+
                '<p contenteditable="false">'+item.comment_total+'</p>'+
              '</section>'+
            '</section>'+
            '</a>'+
          '</section></div><p><br></p>';
        }
        if(item.type==3){
          content ='<div style="text-align:center;display:block;"><section contenteditable="false" class="search-user artquan contentDivforUE" id="artquan">'+
          '<a target="_blank" class="abc" data-artzhe-type="link" data-artzhe-typeDetail="' + data.type +'" + data-artzhe-id="' + data.id + '" contenteditable="false" href="javascript:;">'+
            '<section class="playbtnbxo" contenteditable="false">'+
              '<img class="contentimg" contenteditable="false" src="'+item.video_poster+'"/>'+
              '<p class="contentimgplay" contenteditable="false"></p>'+
            '</section>'+
            '<section class="ttcontentforUE " contenteditable="false">'+
              '<p class="ptforUE nowrap1" contenteditable="false">'+item.user.nickname+'</p>'+
              '<p class="ptmforUE" contenteditable="false">'+item.datetime+'</p>'+
              '<p class="pcforUE nowrap1" contenteditable="false">'+item.excerpt+'</p>'+
            '</section>'+
            '<section class="contentDivforUEboxgo" contenteditable="false">'+
              '<p class="goxiangqing" contenteditable="false">查看详情 &gt;</p>'+
              '<section class="smalltrp" contenteditable="false">'+
                '<p>'+item.like_total+'</p>'+
                '<p>'+item.comment_total+'</p>'+
              '</section>'+
            '</section>'+
            '</a>'+
          '</section></div><p><br></p>';
        }
        if(item.type>10){
          // content ='<div contenteditable="false" class="search-user artquan contentDivforUE" id="artquan">'+
          // '<a target="_blank" class="abc" data-artzhe-type="link" data-artzhe-typeDetail="' + data.type +'" + data-artzhe-id="' + data.id + '" contenteditable="false" href="javascript:;">'+
          //   '<h4 class="ttcontentforUE noleftpadding" contenteditable="false">'+
          //     '<p class="ptforUE nowrap1" contenteditable="false">'+item.user.nickname+'</p>'+
          //     '<p class="ptmforUE" contenteditable="false">'+item.datetime+'</p>'+
          //     '<p class="pcforUE nowrap1" contenteditable="false">链接：'+item.share_link.title+'</p>'+
          //   '</h4>'+
          //   '<div class="contentDivforUEboxgo" contenteditable="false">'+
          //     '<p class="goxiangqing" contenteditable="false">查看详情 &gt;</p>'+
          //     '<h5 class="smalltrp" contenteditable="false">'+
          //       '<p contenteditable="false">'+item.like_total+'</p>'+
          //       '<p contenteditable="false">'+item.comment_total+'</p>'+
          //     '</h5>'+
          //   '</div>'+
          //   '</a>'+
          // '</div><p><br></p>';

          content ='<div style="text-align:center;display:block;"><section contenteditable="false" class="search-user artquan contentDivforUE" id="artquan">'+
          '<a target="_blank" class="abc" data-artzhe-type="link" data-artzhe-typeDetail="' + data.type +'" + data-artzhe-id="' + data.id + '" contenteditable="false" href="javascript:;">'+
            '<section class="ttcontentforUE noleftpadding" contenteditable="false">'+
              '<p class="ptforUE nowrap1" contenteditable="false">'+item.user.nickname+'</p>'+
              '<p class="ptmforUE" contenteditable="false">'+item.datetime+'</p>'+
              '<p class="pcforUE nowrap1" contenteditable="false">链接：'+item.share_link.title+'</p>'+
            '</section>'+
            '<section class="contentDivforUEboxgo" contenteditable="false">'+
              '<p class="goxiangqing" contenteditable="false">查看详情 &gt;</p>'+
              '<section class="smalltrp" contenteditable="false">'+
                '<p contenteditable="false">'+item.like_total+'</p>'+
                '<p contenteditable="false">'+item.comment_total+'</p>'+
              '</section>'+
            '</section>'+
            '</a>'+
          '</section></div><p><br></p>';
        }
      }
      ue.focus();
      ue.execCommand('inserthtml', content);
      ue.focus();
      this.closeSearchSeen();
      // ue.execCommand('insertlink', news);
    },
    clearsearchedvalue: function(){
      this.timeSelect =null;
      this.inputpage= '';
      this.resetSearch()
    },
    cleardatavalue: function(){
      this.searchInputText = '';
      this.inputpage= '';
      this.resetSearch()
    },
    changedate: function (str) {

      console.log(str)
      if(str== null){
        return
      }
      str = str.toString();
      var date;
      var std;
      // str = str.replace(/ GMT.+$/, '');
      std = str.substring(0, 24)
      var d = new Date(std);
      var a = [d.getFullYear(), d.getMonth() + 1, d.getDate()];
      for(var i = 0, len = a.length; i < len; i ++) {
          if(a[i] < 10) {
              a[i] = '0' + a[i];
          }
      }
      return date = a[0] + '-' + a[1] + '-' + a[2];
    }
  }
});
//插入艺术者控件按钮
Vue.component('insert-artzhe-btn', {
  template: '<li @click="showSearchBox" id="j_insert_btn">插入</li>',
  data: function () {
    return {

    };
  },
  created: function () {

  },
  mounted: function() {
    // eventBus.$on('showSearchBox', function() {
    //   this.showSearch();
    // }.bind(this));
  },
  methods: {
    showSearchBox: function () {
      eventBus.$emit('showSearch');// 同级组件传参
    }
  }
});

//插入视频按钮
Vue.component('insert-video-btn', {
  template: '<li id="j_upload_video_btn" @click="showVideoBox">视频</li>',
  data: function () {
    return {

    };
  },
  created: function () {

  },
  mounted: function() {

  },
  methods: {
    showVideoBox: function () {
      eventBus.$emit('showVideoBox');// 同级组件传参
    }
  }
});

//插入视频弹窗
Vue.component('insert-video-box', {
  template: '<div class="maskWrap" v-show="videoSeen" style="display: none">\
              <div class="mask" @click="closeVideoSeen"></div>\
              <div class="video-wrap" v-show="videoSeen">\
                <div class="title-tab">\
                  <ul class="tab-navs clearfix">\
                    <li class="tab-nav selected">\
                      <a href="javascript:;">视频</a>\
                    </li>\
                  </ul>\
                </div>\
                <div class="video-con">\
                  <div class="video-btn-box"><input type="file" id="file-video" @change="videoChange" style="display: none;"><button @click="getVideo" class="video-btn btn"> + 上传视频</button></div>\
                  <ul class="video-list clearfix" v-loading="videoLoading" element-loading-text="拼命加载中">\
                    <li v-for="item in videoInfo.list" :class="[item.selected? \'selected\':\'\', \'video-item\', \'fl\']" :style="{backgroundImage: \'url(\' + item.poster +\')\'}" @click="chooseVideo(item)">\
                    <i class="video-play-icon"></i>\
                    <div class="video-mask">\
                      <i class="video-choose-icon"></i>\
                    </div>\
                    </li>\
                  </ul>\
                  <div class="upload-page el-pagination" v-if="videoInfo.maxpage > 1">\
                    <button type="button"  :class="[ videoInfo.page == 1 ? \'disabled\' : \'\',\'btn-prev\']" @click="pagePrev()" >&lt;</button>\
                    <span class="upload-num" >{{videoInfo.page}}/{{videoInfo.maxpage}}</span>\
                    <button type="button" :class="[ videoInfo.page == videoInfo.maxpage ? \'disabled\' : \'\',\'btn-next\']" @click="pageNext()" >&gt;</button>\
                    <span class="el-pagination__jump "><input type="number" min="1" number="true" v-model="inputpage" class="el-pagination__editor el-pagination__editor2" style="width: 58px;"> <a href="javascript:;" @click="gotoPage()"  class="el-button el-button--info is-plain upload-jump"><span>跳转</span></a></span>\
                  </div>\
                  <div v-if="videoInfo.total > 0" class="btn-group">\
                    <input type="button" @click="setVideo" value="确定" class="btn btn-sure">\
                    <input type="button" @click="closeVideoSeen" value="取消" class="btn btn-cancel">\
                  </div>\
                </div>\
                </ul>\
              </div>\
           </div>',
  data: function () {
    return {
      activeVideo: {},
      videoSeen: false,
      videoInfo: {
        type: '',
        list:[
          // {id: 1, url: '', poster: 'https://shp.qpic.cn/qqvideo_ori/0/x1323bchnup_496_280/0', video_name:''}
        ],
        page: 1,
        pagesize:6,
        maxpage:1,
        total: 0
      },
      videoData: {},
      videoLoading: false,
      inputpage: ''
    };
  },
  created: function () {

  },
  mounted: function() {
    eventBus.$on('showVideoBox', function() {
      this.showVideoBox();
    }.bind(this));
  },
  methods: {
    showVideoBox: function () {
      var that = this;
      this.videoSeen = true;
      this.getVideoList();
      this.videoInfo.list.forEach(function (item) {
        item.selected = false;
      });
      // eventBus.$emit('showVideoBox');
    },
    chooseVideo: function (item) {
      var that = this;
      this.$nextTick(function() {
        this.videoInfo.list.forEach(function (videoItem) {
          if (videoItem.id == item.id) {
            Vue.set(videoItem, 'selected', true);
            that.activeVideo = videoItem;
            // videoItem.selected = true;
          } else {
            Vue.set(videoItem, 'selected', false);
          }
        });
      });
    },
    closeVideoSeen: function () {
      this.videoSeen = false;
      this.activeVideo = {};
    },
    getVideo: function () {
      $("#file-video").click();
    },
    videoChange: function () {
      var that = this;
      var localVideo = $("#file-video").get(0).files[0];

      if (!localVideo) {
        return;
      }
      var fileName = localVideo.name;
      var fileSize = localVideo.size;
      var fileType = localVideo.type.toUpperCase();
      console.log(fileType);
      if (fileType !== 'VIDEO/MP4') {
        that.$message({
          message: '上传失败，请上传mp4格式的视频'
        });
        return;
      }

      var reData = ossObj.set_upload_param(localVideo.name);
      that.videoData.data = reData;
      that.videoData.file = localVideo;
      // 检查是否支持FormData　
      if (window.FormData) {　　　　　
        var formData = new FormData();　　　　 // 建立一个upload表单项，值为上传的文件
        for (var i in that.videoData.data) {
          formData.append(i, that.videoData.data[i]);
        }　　　　
        formData.append('file', that.videoData.file);　　　　
        var xhr = new XMLHttpRequest();　
        xhr.open('POST', ossInfo.action);　　　　 // 定义上传完成后的回调函数
        var mess = that.$message({
          message: '视频上传中，请稍后...',
          duration:0
        });　　
        xhr.onload = function() {　　　　　　
          if (xhr.status === 200) {　
            var videoUrl = ossInfo.action + '/' + that.videoData.data.key; //视频链接
            artzheAgent.callMP('Attachments/MakeScreenshot', {video_src:videoUrl}, function(response) {
              mess.close();
              if (response.state == 1) {
                artzheAgent.callMP('Video/postinfo', {url:videoUrl, poster:response.poster, video_name: ''}, function(resVideo) {
                  console.log(resVideo);
                  that.getVideoList();
                });

                // that.setVideo(videoUrl, response.poster);
              }
            });
            // that.setVideo(ossInfo.action + '/' + that.videoData.data.key); //视频链接
          } else {
            mess.close();　　　　　　　　
            that.$message({
              message: '上传失败'
            });　　　　　　
          }　　　　
        };　　　　
        xhr.send(formData);　　
      }
    },
    setVideo: function () {
      var item = this.activeVideo;
      if (item.url) {
        var videoTemp = '<div><video poster="' + item.poster + '" src="' + item.url + '" controls="controls" preload="meta"><source src="' + item.url + '" type="video/mp4"></source></video></div>&#8203;';
        ue.focus();
        ue.execCommand('inserthtml',videoTemp);
        this.closeVideoSeen();
      } else {
        that.$message({
          message: '请先选择视频'
        });
      }

    },
    getVideoList: function (page) {
      var that = this;
      var data = {
        page: page ? page : 1,
        pagesize: this.videoInfo.pagesize
      };
      that.videoLoading = true;
      artzheAgent.callMP('Video/myvideo', data, function(response) {
        that.videoLoading = false;
        if (response.data.status == 1000 && response.code == 30000) {
          if (response.data.info.page == 1 && response.data.info.list.length == 0) {
            // that.$message({
            //   message: '没有相关内容'
            // });
          }
          that.videoInfo = response.data.info;
      }
      }, function(res) {
        that.videoLoading = false;
      });
    },
    pagePrev: function () {
      if (this.videoInfo.page <= 1) return;
      this.getVideoList(--this.videoInfo.page);
    },
    pageNext: function () {
      if (this.videoInfo.page >= this.videoInfo.maxpage) return;
      this.getVideoList(++this.videoInfo.page);
    },
    gotoPage: function () {
      if (this.inputpage > this.videoInfo.maxpage || this.inputpage < 1) {
        this.$message({
          message: '请输入正确的页码'
        });
        return false;
      }
      this.getVideoList(this.inputpage);
    }
  }
});

//原先上传视频按钮
Vue.component('upload-video-btn', {
  template: '<li @click="getVideo" id="j_upload_video_btn">视频<input type="file" id="file-video" name="file-video" style="display:none" @change="videoChange" /></li>',
  data: function () {
    return {
      videoData: {},
    };
  },
  created: function () {

  },
  mounted: function() {

  },
  methods: {
    getVideo: function () {
      $("#file-video").click();
    },
    videoChange: function () {
      var that = this;
      var localVideo = $("#file-video").get(0).files[0];
      if (!localVideo) {
        return;
      }
      var fileName = localVideo.name;
      var fileSize = localVideo.size;
      var fileType = localVideo.type.toUpperCase();
      if (fileType !== 'VIDEO/MP4') {
        that.$message({
          message: '上传失败，请上传mp4格式的视频'
        });
        return;
      }

      var reData = ossObj.set_upload_param(localVideo.name);
      that.videoData.data = reData;
      that.videoData.file = localVideo;
      // 检查是否支持FormData　
      if (window.FormData) {　　　　　
        var formData = new FormData();　　　　 // 建立一个upload表单项，值为上传的文件
        for (var i in that.videoData.data) {
          formData.append(i, that.videoData.data[i]);
        }　　　　
        formData.append('file', that.videoData.file);　　　　
        var xhr = new XMLHttpRequest();　
        xhr.open('POST', '/public/getOSSAudio');　　　　 // 定义上传完成后的回调函数
        var mess = that.$message({
          message: '视频上传中，请稍后...',
          duration:0
        });　　
        xhr.onload = function() {　　　　　　
          if (xhr.status === 200) {　
            var videoUrl = ossInfo.action + '/' + that.videoData.data.key; //视频链接
            artzheAgent.call31('/mp/Audio/postinfo', {video_src:videoUrl}, function(response) {
              console.log(response)
              mess.close();
              if (response.state == 1) {
              // videoUrl 源文件，response.poster 图片
                that.setVideo(videoUrl, response.poster);
              }
            });
            // that.setVideo(ossInfo.action + '/' + that.videoData.data.key); //视频链接
          } else {
            mess.close();　　　　　　　　
            that.$message({
              message: '上传失败'
            });　　　　　　
          }　　　　
        };　　　　
        xhr.send(formData);　　
      }
    },
    setVideo: function (url, poster) {
      var videoTemp = '<div><video poster="' + poster + '" src="' + url + '" controls="controls" preload="meta"><source src="' + url + '" type="video/mp4"></source></video></div>&#8203;';
      ue.focus();
      ue.execCommand('inserthtml',videoTemp);
    }
  }
});

var audioComfirm = '<div class="audioUploadBox" v-show="flag">'+
                      '<div class="audioBox">'+
                        '<p class="title">选择音频</p>'+
                        '<el-tabs v-model="activeName">'+
                            '<el-tab-pane label="素材库" name="first">'+
                              '<div class="listBox">'+
                                '<input type="file" id="file-audio" style="display: none" @change="audioChange" />'+
                                 '<button class="localUpladBtn" @click="localClick"> + 上传音频</button>'+
                              '</div>'+
                              '<div class="upladedAudio">'+
                                '<p v-if="!data1">您还没有上传过音乐！</p>'+
                                //素材库list
                                '<el-radio-group v-else v-model="radio1" class="upladedAudioList" @change="listChangeForLocal(radio1)">'+
                                  '<el-radio v-for="(item,index) in data1" :label="index">'+
                                    '<span>{{item.songName}}</span>'+
                                    '<span class="uploadDate">{{item.uploadDate}}</span>'+
                                  '</el-radio>'+
                                '</el-radio-group>'+
                              '</div>'+
                              '<div class="sureBox">'+
                                '<div class="sureAndCancle">'+
                                  '<div @click="fillMusic">确定</div>'+
                                  '<div @click="closed">取消</div>'+
                                '</div>'+
                                '<div class="pageBox">'+
                                  '<button v-if="nowPage>1" class="goPageBack" @click="handleBackPage"></button>'+
                                  '<span v-else class="fullBox"></span>'+
                                  '<span class="allPage">{{nowPage}}/{{maxPage}}</span>'+
                                  '<button v-if="nowPage<maxPage" class="goPageforward" @click="handleForwardPage"></button>'+
                                  '<span v-else class="fullBox"></span>'+
                                '</div>'+
                                '<div class="audioPage">'+
                                  '<span class="el-pagination__jump">'+
                                    '<input type="number" min="1" number="true" class="el-pagination__editor jumpval" vaule="1"  style="width: 30px;">'+
                                    '<button class="goToPage" @click="gounextPage()">跳转</button>'+
                                  '</span>'+
                                '</div>'+
                              '</div>'+
                              //素材库list end
                            '</el-tab-pane>'+
                            '<el-tab-pane label="搜索" name="second">'+
                            '<div class="s_Box">'+
                              '<input type="text" class="s_Box_addurl searchVal" @keyup.13="audioSearchBtn"  placeholder="歌名/作者"/>'+
                              '<button class="s_Box_addUrlBtn" @click="audioSearchBtn"></button>'+
                            '</div>'+

                            '<div class="searchAudio">'+
                              // '<p v-if="!data1">您还没有上传过音乐！</p>'+
                              // '<ul class="searchAudioList">'+
                              //   '<li v-for="(item,index) in data2" @click="listClick(item.songid)">'+
                              //     '<label for="{{index}}">'+
                              //       '<p class="listLeft">'+
                              //         '<input type="radio" name="localAudio" id="{{index}}"/>'+
                              //       '<span>{{item.songname}}</span>{{index}}'+
                              //       '</p>'+
                              //       '<p class="listRight">'+
                              //         '<span class="uploadDate">{{item.singer[0].name}}</span>'+
                              //         '<span class="audioLong">03:53</span>'+
                              //       '</p>'+
                              //     '</label>'+
                              //   '</li>'+
                              // '</ul>'+
                              //搜索list
                              // '<el-radio-group v-model="radio2" class="upladedAudioList">'+
                              //   '<el-radio v-for="(item,index) in data2" @click="listClick(item.songid)" :label="index">'+
                              //     '<span>{{item.songname}}</span>'+
                              //     '<span class="uploadDate">{{item.singer[0].name}}</span>'+
                              //   '</el-radio>'+
                              // '</el-radio-group>'+
                              '<el-radio-group v-model="radio2" class="upladedAudioList" @change="listChange(radio2)">'+
                                '<el-radio v-for="(item,index) in data2" :songhas="item.hash" :label="index">'+
                                  '<span>{{item.songname}}</span>'+
                                  '<span class="uploadDate">{{item.singername}}</span>'+
                                '</el-radio>'+
                              '</el-radio-group>'+
                              //搜索list end
                            '</div>'+
                            '<div class="sureBox">'+
                              '<div class="sureAndCancle">'+
                                '<div @click="getSearchUrl">确定</div>'+
                                '<div @click="closed">取消</div>'+
                              '</div>'+
                              // '<div class="audioPage">'+
                              //   '<span class="el-pagination__jump">前往'+
                              //     '<input type="number" min="1" number="true" class="el-pagination__editor" style="width: 30px;">页'+
                              //   '</span>'+
                              // '</div>'+
                            '</div>'+
                            //添加网络音乐链接
                            '</el-tab-pane>'+
                            '<el-tab-pane label="链接" name="third">'+
                                '<div class="addurlBox">'+
                                  '<span class="shearchTitle">音频网址</span>'+
                                  '<div class="listBox">'+
                                    '<input type="text" class="addurl" placeholder="请输入音频网址"/>'+
                                    // '<button class="addUrlBtn" disabled></button>'+
                                  '</div>'+
                                '</div>'+
                                '<div class="shearchSureBox">'+
                                  '<div class="shearSureAndCancle">'+
                                    '<div @click="getAudioUrl">确定</div>'+
                                    '<div @click="closed">取消</div>'+
                                  '</div>'+
                                '</div>'+
                            '</el-tab-pane>'+
                            //添加网络音乐链接end
                          '</el-tabs>'+
                        '</div>'+
                      '</div>';
Vue.component('audio-upload-comp', {
  template: audioComfirm,
  data: function () {
    return {
      flag: false, // 显示或隐藏整个弹层
      activeName: 'first', // element的tab默认高亮
      radio1: 0, // element的单选按钮  素材库
      radio2: 0, // element的单选按钮  搜索
      audioData: {}, //
      localUpData: {}, // 当前上传的音乐
      data1: [], // 用户曾经上传时的音乐列表  素材库
      data1Url: {
        id: 0,
        url: '',
        songName: '',
        songImg: '',
        singerName: ''
      },
      data2: {},// 搜索的列表  搜索
      data2Url: { // 搜索音乐的id，和has
        id: 0,
        has: ''
      },
      nowPage: 1, //当前页数
      maxPage: 0
    }
  },
  mounted: function () {
    that = this;
    eventBus.$on('showUpload', function (msg) { // 获取到flag信息（子组件接收参数）
      that.flag = msg;
    });
    // TODO: 点击上传音乐按钮时，先加载出曾经上传过的音频
    //this.data1 =  // 点击上传音乐按钮时，先加载出曾经上传过的音频
    this.sureUpload(1);
  },
  methods: {
    closed: function () { // 关闭按钮
      this.flag = false;
    },
    localClick: function () { // 激活上传按钮
       $("#file-audio").click();
    },
    sureUpload: function (page) { // 素材库页面
      var that = this;
      $.ajax({
        url:'/mp/Audio/myaudio?page='+page+'&pagesize=3', // page pagesize
        dataType:'json',
        type:'get',
        success:function(data){
          // console.log(data)
          that.data1= data.data.info.list;
          that.maxPage = data.data.info.maxpage;

          //首次将值赋给data1Url对象，因为，默认选择的第一项不会触发change事件
          if (data.data.info.list.length > 0) {
            that.data1Url.url=data.data.info.list[0].audioUrl;
            that.data1Url.singerName=data.data.info.list[0].singerName;
            that.data1Url.songName=data.data.info.list[0].songName;
            that.data1Url.songImg=data.data.info.list[0].songImg;
          }
        }
      })
      // console.log(this.data1Url)
    },
    audioChange: function () { //上传判断
      /* TODO:
      *1.再在列表重新请求一次数据库，然后渲染
      */
      var that = this;
      var localAudio = $("#file-audio").get(0).files[0];
      if (!localAudio) {
        return;
      }
      var fileName = localAudio.name; // 上传文件名
      var fileSize = localAudio.size; // 上传文件大小
      // console.log(fileSize)
      var fileType = localAudio.type.toUpperCase(); // 将后缀转为小写
      if (fileType !== 'AUDIO/MP3') {
        that.$message({
          message: '上传失败，请上传mp3格式的音乐'
        });
        return;
      }
      if (fileSize >= 20480000) {
        that.$message({
          message: '上传失败，请上传小于20M的音乐'
        });
        return;
      }
      var reData = ossObj.set_upload_param(localAudio.name);
      that.audioData.data = reData;
      that.audioData.file = localAudio;
      // 检查是否支持FormData　
      if (window.FormData) {
        var formData = new FormData();　　　　 // 建立一个upload表单项，值为上传的文件
        for (var i in that.audioData.data) {
          formData.append(i, that.audioData.data[i]);
        }　　　　
        formData.append('file', that.audioData.file);　　　　
        var xhr = new XMLHttpRequest();　
        xhr.open('POST', ossInfo.audioAction);　　　　 // 定义上传完成后的回调函数
        var mess = that.$message({
          message: '音频频上传中，请稍后...',
          duration:0
        });　　
        xhr.onload = function() {
          if (xhr.status === 200) {　
            var audioUrl = ossInfo.audioAction + '/' + that.audioData.data.key; //音频链接
            $.ajax({  // 上传
              url:'/mp/Audio/postinfo',
              dataType:'json',
              type:'post',
              data:{songName:fileName,singerName:'未知歌手',audioUrl:audioUrl,songImg:''},
              success:function(data){
                console.log('上传成功！')
                that.sureUpload(1); // 上传成功刷新列表
                mess.close();
              }
            })
              // console.log(that.audioData)
            // that.setAudio(audioUrl);
            // function formatDateTime (date) {
            //   var y = date.getFullYear();
            //   var m = date.getMonth() + 1;
            //   m = m < 10 ? ('0' + m) : m;
            //   var d = date.getDate();
            //   d = d < 10 ? ('0' + d) : d;
            //   return y + '-' + m + '-' + d;
            // };
            // that.localUpData.fileName = fileName; // 上传的音乐文件名
            // that.localUpData.url = audioUrl; // 上传的音乐的链接
            // that.localUpData.upLoadDate = formatDateTime(new Date()); // 上传时间
            //that.data1.push(that.localUpData)
            // console.log(that.data1)

          } else {
            mess.close();　　　　　　　　
            that.$message({
              message: '上传失败'
            });　　　　　　
          }　　　　
        };
        xhr.send(formData);
      }
    },
    handleForwardPage: function () { // 前进一页

      if(this.nowPage>=this.maxPage){
        this.nowPage = this.maxPage;
      }else{
        this.nowPage++;
      }
      this.sureUpload(this.nowPage);
    },
    handleBackPage: function () { //后退一页
      if(this.nowPage<=1){
        this.nowPage=1
      }else{
        this.nowPage--;
      }
      this.sureUpload(this.nowPage);
    },
    gounextPage: function () { // 做个ajax请求，请求下一页数据
      var wantToPage = $('.jumpval').val();
      if(wantToPage <= this.maxPage&&wantToPage >= 1){
        this.nowPage = wantToPage;
        this.sureUpload(this.nowPage);
      }
    },
    getAudioUrl: function () { // 点击歌曲外链页面确定按钮时
      var url = $(".addurl").val();
      var endFourth = url.slice(-4).toLowerCase();
      if (endFourth !== '.mp3') {
        that.$message({
          message: '上传失败，请上传mp3格式的音乐'
        });
        return;
      }
      this.setAudio({url:url,img:'',singerName:'未知作家',songName:'未知歌曲'});
      this.closed();
    },
    audioSearchBtn: function () { //歌曲搜索按钮
      var that = this;
      var content = $(".searchVal").val();
      $.ajax({
        type: 'GET',
        // url: 'https://c.y.qq.com/soso/fcgi-bin/search_for_qq_cp?format=jsonp&n=20&w='+ content,
        url:'http://mobilecdn.kugou.com/api/v3/search/song?format=jsonp&keyword='+content+'&page=1&pagesize=20&showtype=1', // 酷狗api
        dataType: 'jsonp',
        jsonp: 'callback',
        success: function (data) {

          that.data2 = data.data.info; // 歌曲列表20首
          // console.log(that.data2.lists)
        },
        error: function (err) {
          that.$message({
            message: err
          });
        }
      })
    },
    listChange: function (id) { // 酷狗歌曲单独的id
      //this.data2Url.id默认为0，因为列表里默认第一项为0,没有触发change事件
      this.data2Url.id = id; //将歌曲列表的id赋给data2.id
      var that = this;
      var data2list = this.data2;
      for(var i=0;i<data2list.length;i++){
        if(id==i){
          this.data2Url.has=data2list[i].hash; // 将对应的hash值赋给data2.has
          break;
        }
      }
      // this.data2.url = 'http://ws.stream.qqmusic.qq.com/'+id+'.m4a?fromtag=46';
      // this.data2.url = 'http://tingapi.ting.baidu.com/v1/restserver/ting?method=baidu.ting.song.play&songid='+id;

    },
    listChangeForLocal: function (id) {  //自己上传歌曲单独的id  本地库
      this.data1Url.id = id;
      for(var i=0;i<this.data1.length;i++){
        if(id==i){
          this.data1Url.url=this.data1[i].audioUrl; // 将对应的hash值赋给data2.has
          this.data1Url.singerName=this.data1[i].singerName;
          this.data1Url.songName=this.data1[i].songName;
          this.data1Url.songImg=this.data1[i].songImg;
          break;
        }
      }
    },
    fillMusic: function () { // 素材页点击确定按钮时
      this.setAudio({url:this.data1Url.url,img:this.data1Url.imgUrl,singerName:this.data1Url.singerName,songName:this.data1Url.songName});
      this.closed();
    },
    getSearchUrl: function () { // 搜索页点击确定按钮
      console.log(this.data2Url)
      var that = this;
      //this.data2Url.id默认为0，因为列表里默认第一项为0,没有触发change事件
      this.data2Url.has=this.data2[this.data2Url.id].hash; // 拿到选择的对应歌曲的has值，做ajax去获取对应的链接。
      $.ajax({
        url:'http://m.kugou.com/app/i/getSongInfo.php?cmd=playInfo&format=jsonp&hash='+this.data2Url.has,
        type:'get',
        dataType:'jsonp',
        jsonp: 'callback',
        success:function(data){
          console.log(data)
          that.setAudio({url:data.url,img:data.imgUrl,singerName:data.singerName,songName:data.songName});
        }
      })
      // this.setAudio(this.data2Url);
      this.closed();
    },
    setAudio: function (obj) { // 将歌曲的样式添加到富文本内 {url:data.url,img:data.imgUrl,singerName:data.singerName,songName:data.songName}
      obj.img = obj.img ? obj.img : 'https://artaudio.oss-cn-shenzhen.aliyuncs.com/static/ico_app_music_bg.png';
      var audioTemp = '<p class="audioPlayBox" contenteditable="false">'+
        '<audio  class="audioPlayer" src="' + obj.url + '" controls="controls" preload="meta" loop="loop" style="display: none">'+
          '<source src="' + obj.url + '" type="audio/mp3"></source>'+
        '</audio>'+
        '<strong class="leftPlay" style="background-image:url('+obj.img+')">'+
          // '<img class="musicImg" src="'+img+'" alt=""/>'+
          '<span src="" alt="" class="playimg playImgBox"></span>'+
        '</strong>'+
        '<strong class="rightDirection">'+
        '<span class="musicTitle">'+obj.songName+'</span>'+
          '<span class="musicAuthor">'+obj.singerName+'</span>'+
        '</strong>'+
      '</p>&#8203;'
      ue.focus();
      ue.execCommand('inserthtml',audioTemp);
    }
  }
});


// TODO: 上传音频
//qq音乐搜索api https://c.y.qq.com/soso/fcgi-bin/search_for_qq_cp?format=jsonp&n=20&w=    asd  &jsonpCallback=_jsonpc386jp82o8

//asd 为搜索参数
// songid 为歌曲id
// singer[0].name 为作者名字
//歌曲api http://ws.stream.qqmusic.qq.com/1972930.m4a?fromtag=46

// var li = '<li @click="getAudio" id="j_upload_audio_btn">音频<input type="file" id="file-audio" name="file-audio" style="display:none" @change="audioChange" /></li>'
var li= '<li @click="getAudio" id="j_upload_audio_btn">音频</li>'
Vue.component('upload-audio-btn', {
  template: li,
  data: function () {
    return {
      audioData: {}
    };
  },
  methods: {
    getAudio: function () {
      // $("#file-audio").click();
      var flag = true;
      eventBus.$emit('showUpload', flag);// 同级组件传参
    },
    // audioChange: function () {
    //   var that = this;
    //   var localAudio = $("#file-audio").get(0).files[0];
    //   if (!localAudio) {
    //     return;
    //   }
    //   var fileName = localAudio.name;
    //   var fileSize = localAudio.size;
    //   var fileType = localAudio.type.toUpperCase();
    //   if (fileType !== 'AUDIO/MP3') {
    //     that.$message({
    //       message: '上传失败，请上传mp3格式的音乐'
    //     });
    //     return;
    //   }
    //
    //   var reData = ossObj.set_upload_param(localAudio.name);
    //   that.audioData.data = reData;
    //   that.audioData.file = localAudio;
    //   // 检查是否支持FormData　
    //   if (window.FormData) {
    //     var formData = new FormData();　　　　 // 建立一个upload表单项，值为上传的文件
    //     for (var i in that.audioData.data) {
    //       formData.append(i, that.audioData.data[i]);
    //     }　　　　
    //     formData.append('file', that.audioData.file);　　　　
    //
    //     var xhr = new XMLHttpRequest();　
    //     xhr.open('POST', ossInfo.action);　　　　 // 定义上传完成后的回调函数
    //     var mess = that.$message({
    //       message: '音频频上传中，请稍后...',
    //       duration:0
    //     });　　
    //     xhr.onload = function() {
    //       if (xhr.status === 200) {　
    //         var audioUrl = ossInfo.action + '/' + that.audioData.data.key; //音频链接
    //         that.setAudio(audioUrl);
    //         mess.close();
    //       } else {
    //         mess.close();　　　　　　　　
    //         that.$message({
    //           message: '上传失败'
    //         });　　　　　　
    //       }　　　　
    //     };　　　　
    //     xhr.send(formData);　　
    //   }
    // },
    // setAudio: function (url) {
    //   //audio标签会被过滤掉，未找到在哪设置（原api文件可以设置audio标签），套用了video标签，可以播放
    //   // var audioTemp = '<div><video src="' + url + '" controls="controls" preload="meta"><source src="' + url + '" type="audio/mp3"></source></video></div>&#8203;';
    //   var audioTemp=  '<div><audio src="' + url + '" controls="controls" preload="meta"><source src="' + url + '" type="audio/mp3"></source></audio></div>&#8203;';
    //
    //   ue.focus();
    //   ue.execCommand('inserthtml',audioTemp);
    // }
  }
});

// 子页面页脚
Vue.component('ysz-footer2', {
  template: '\
      <footer v-once>\
        <div class="y-footer">\
          <div class="w clearfix">\
            <p class="mail">联系邮箱：artzhe@artzhe.com</p>\
            <!-- <p class="qrcode">\
              <img src="/image/qrcode-wx.png">\
              <img src="/image/qrcode-app.png">\
            </p> -->\
            <p class="copyright">\
              Copyright 2017 www.artzhe.com. All Rights Reserved \
              <span>粤ICP备17041531号-1</span>\
            </p>\
          </div>\
        </div>\
      </footer>\
      '
});

// 创作中心导航栏组件
Vue.component('ysz-upload-nav', { // v-if="userType ==2"  艺术家管理显示条件
  template: '\
      <ul v-cloak class="upload-left">\
        <div v-if="isChecked">\
         <li><span><i class="icons icon-manage"></i>管理</span>\
            <ul>\
              <li v-if="userType == 1"><a href="/upload/manage">作品管理</a></li>\
              <li><a href="/article/manage">艺术号管理</a></li>\
              <li v-if ="role.isAgency==1" > <a href="/artorganization/arter">艺术家管理</a></li>\
            </ul>\
         </li>\
         <li v-if="userType == 1"><span><i class="icons icon-promote"></i>推广</span>\
            <ul>\
              <li><a href="/promote/index">APP封面</a></li>\
              <li><a href="/topic/index">艺术专题</a></li>\
            </ul>\
         </li>\
         <li v-if="userType == 1"><span><i class="icons icon-invite"></i>邀请</span>\
            <ul>\
              <li><a href="/invite/index">我的邀请</a></li>\
            </ul>\
         </li>\
         <li><span><i class="icons icon-auth"></i>认证</span>\
            <ul>\
              <li><a href="/auth/manage">申请认证</a></li>\
            </ul>\
         </li>\
         <li v-if="userType == 1"><span><i class="icons icon-trade"></i>加入交易</span>\
            <ul>\
              <li v-if="userType == 1 && applyMallInfo.Mallstatus != 1"><a href="/trade/apply">申请交易</a></li>\
              <li v-if="userType == 1 && applyMallInfo.Mallstatus == 1"><a href="/trade/artwork">原作交易</a></li>\
              <li v-if="userType == 1 && applyMallInfo.Mallstatus == 1 && userInfo.artTotal > 0"><a target="_blank" :href="mallLink">后台入口</a></li>\
            </ul>\
         </li>\
        </div>\
      </ul>\
      ',
  data: function () {
    return {
      userInfo: {},
      userType: -1,
      role : {},
      isChecked: false,
      applyMallInfo: {
        isApplyed: false,
        Mallstatus: -3, //申请状态 1通过，0审核中，2不通过
        checkMsg: ''
      },
      mallLink: switchDomin('mall') + '/seller/relocation.php?redirect=' + encodeURIComponent(switchDomin('mall') + '/seller/privilege.php?act=signin&az_from=mpartzhe')
    };
  },
  created: function() {
    this.getUserInfo();
    this.getApplyStatus();
  },
  mounted: function() {
    // this.highLightPage();

  },
  methods: {
    highLightPage: function() {
      var links = $('#main .upload-left a');
      for (var i = 0, len = links.length; i < len; i++) {
        var linkURL = links[i].getAttribute('href');
        if (window.location.href.indexOf(linkURL) !== -1) {
          $(links[i]).addClass('cur');
        }
      }
    },
    getUserInfo: function() {
      var that = this;
      artzheAgent.callMP('UserCenter/getMyGalleryDetail',{},function(res) {
        if (res.code == 30000) {

          var resInfo = res.data.info;
          that.userInfo = resInfo;
          //机构
          if (resInfo.isArtist == '1') { //艺术家
            that.role.isArtist = 1;
          }
          if (resInfo.isAgency == '1') { //艺术机构
          that.role.isAgency = 1;
          }
          if (resInfo.isPlanner == '1') { //艺术机构
            that.role.isPlanner = 1;
          }
          console.log(that.role)
          //
          if (resInfo.isArtist == '1') { //艺术家
            that.userType = 1;

          } else if (resInfo.isAgency == '1') { //艺术机构
            that.userType = 2;
          console.log(that.userType)
          } else if (resInfo.isPlanner == '1') { //策展人
            that.userType = 3;
          } else { //普通用户
            that.userType = -1;
          }
        } else {
        }
        that.isChecked = true;
        that.$nextTick(function() {
          that.highLightPage();
        });

      });
    },
    getApplyStatus: function () {
      var that = this;
      artzheAgent.callMP('User/ArtistMallStatus', {}, function(response) { //获取商城申请审核状态
        if (response.code === 30000) {
          that.applyMallInfo.isApplyed = true;
          that.applyMallInfo.Mallstatus = response.data.status;
          if (response.data.status == 1) { //通过

          } else if (response.data.status == 0) { //审核中

          } else if (response.data.status == 2) { //不通过
            that.applyMallInfo.checkMsg = response.data.checkMsg;
          }
        } else if (response.code == 30005) { //未申请
          that.applyMallInfo.isApplyed = false;
          that.applyMallInfo.Mallstatus = -1;
        }
        that.$nextTick(function() {
          that.highLightPage();
        });
        eventBus.$emit('setMallStatus', that.applyMallInfo);
      }, function(res) {
      });
    }
  }
});

//切换用户的按钮
//' href="javascript:;" style="text-align:center;color:#f4ad23" @click="changeuserfn">返回机构</a></div>'+
Vue.component('change-user-btn', {
template : '<div v-if="shouldchange" style="display:inline-block;width:96px;height:38px;"><a' +
  ' href="javascript:;" style="text-align:center;color:#f4ad23" @click="dialogVisible = true">返回机构</a>'+
  '<el-dialog title="提示" :show-close="false" :visible.sync="dialogVisible" size="tiny" :before-close="handleClose" custom-class="jgdialog">'+
    '<span>确认返回机构账户？</span>' +
    '<span slot="footer" class="dialog-footer">' +
    '<el-button @click="dialogVisible = false">取 消</el-button>' +
    '<el-button type="primary" @click="changeuserfn">确 定</el-button>' +
    '</span>' +
    '</el-dialog>'+
  '</div>',
  data: function () { //'v-loading.fullscreen.lock="floading" element-loading-text="拼命切换中"'+
    return {
      shouldchange : getCookie('temporaryLogin')>0 && getCookie('userid')>0? true : false,
      dialogVisible: false,
      // floading:false,
    }
  },
  created: function(){

  },
  methods: {
    changeuserfn: function(){
      this.$message({
        type:'info',
        message:'拼命切换中'
      });
      this.dialogVisible = false;
      this.floading = true;
      var that=this;
      artzheAgent.callMP('Agency/ChangeLoginToRealIdentity', {}, function (res) {
        if (res.code == 30000) {
          if (res.code == 30000) {
            artzheAgent.call('UserCenter/getMyGalleryDetail', {}, function (res) {

              deleteCookie('userType');
              deleteCookie('userid');
              deleteCookie('userName');
              deleteCookie('userFace');
              deleteCookie('userMobile');
              if (res.code == 30000) {
                var resInfo = res.data.info;
                that.myInfo = {
                  uid: res.data.info.artist,
                  name: res.data.info.name,
                  face: res.data.info.faceUrl
                };
                var userType = -1;
                if (res.data.info.isArtist == '1') { //艺术家
                  userType = 1;
                } else if (res.data.info.isAgency == '1') { //艺术机构
                  userType = 2;
                } else if (res.data.info.isPlanner == '1') { //策展人
                  userType = 3;
                } else { //普通用户
                  userType = -1;
                }
                setCookie('userid', res.data.info.artist);
                setCookie('userName', res.data.info.name);
                setCookie('userFace', res.data.info.faceUrl);
                setCookie('userMobile', res.data.info.mobile);
                setCookie('userType', userType);
                _setCookie('temporaryLogin', 0); //切换登录用户
                window.location = '/artorganization/arter'; //跳转到艺术家管理

              } else {
                deleteCookie('userid');
                deleteCookie('userName');
                deleteCookie('userFace');
                deleteCookie('userMobile');
              }
              // that.floading = false;
            });
          }
        }
      })
    },
    handleClose: function(done) {
      console.log(done)
    }
  },
});

// 公共头部 2018.07.13
Vue.component('az-header',{
  template : '<header class="ysz-header">'+
    '<div class ="y-header"><div class="w clearfix">'+
      '<a href="/index">'+
        '<h1 class="y-head fl">'+
          '<img class="logo" src="/image/logo.png" alt="logo">'+
          ' <span class="y-title">创作平台</span>'+
          '</h1>'+
        '</a>'+
        '<div class="user fr">'+
          '<div class="info">'+
            '<img :src="myInfo.face">'+
              '<span>{{ myInfo.name}}</span>'+
              '<change-user-btn></change-user-btn>'+
              '<a href="/passport/logout">退出</a>'+
            '</div>'+
          '</div>'+
        '</div>'+
      '</div>'+
    '</header>',
  data: function(){
    return {
      myInfo : {
        uid: getCookie('userid'),
        name: getCookie('userName'),
        face: getCookie('userFace')
      },
    }
  },
  created: function(){

  },
  methods: {

  }
});

// 全局过滤器
Vue.filter('split24word', function (value) {
  if (!value) return ''
  if (getByteLen(value)>24){
    return cutstr(value,24)+'...'
  }else{
    return value
  }
})

// 像素转rem
function px2rem(con) {
  con = con.replace(/(\s\d+)px/g, function(s, t) {
    s = s.replace('px', '');
    var value = parseInt(s) * 0.0266667;//   此处 1rem = 75px
    return value + "rem";
  });
  con = con.replace(/(:\d+)px/g, function(s, t) {
    s = s.replace('px', '');
    var value = parseInt(s) * 0.0266667;//   此处 1rem = 75px
    return value + "rem";
  });
  return con;
}

//oss直传相关
//获取随机字符串--随机文件名
function random_string(len) {　　
  len = len || 32;　　
  var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';　　
  var maxPos = chars.length;　　
  var pwd = '';　　
  for (i = 0; i < len; i++) {　　
    pwd += chars.charAt(Math.floor(Math.random() * maxPos));
  }
  return pwd;
}

//获取文件名后缀
function get_suffix(filename) {
  var pos = filename.lastIndexOf('.'),
    suffix = '';
  if (pos != -1) {
    suffix = filename.substring(pos)
  }
  return suffix;
}
//直传oss对象
var ossObj = {
  accessid: '',
  accesskey: '',
  host: '',
  policyBase64: '',
  signature: '',
  callbackbody: '',
  filename: '',
  key: '',
  expire: 0,
  g_object_name: '',
  g_object_name_type: 'random_name', //'local_name'
  now: Date.parse(new Date()) / 1000,
  timestamp: Date.parse(new Date()) / 1000,
  //请求后台上传签名
  send_request: function() {
    var xmlhttp = null;
    if (window.XMLHttpRequest) {
      xmlhttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (xmlhttp != null) {
      var serverUrl = '/public/getOSS';
      xmlhttp.open("GET", serverUrl, false);
      xmlhttp.send(null);
      return xmlhttp.responseText;
    } else {
      alert("Your browser does not support XMLHTTP.");
    }
    // return '{accessid: "p0qCqg52u0rz7XaE",host: "https://post-test.oss-cn-hangzhou.aliyuncs.com",policy: "eyJleHBpcmF0aW9uIjoiMjAxNy0wNC0yN1QxNToyMToxMFoiLCJjb25kaXRpb25zIjpbWyJjb250ZW50LWxlbmd0aC1yYW5nZSIsMCwxMDQ4NTc2MDAwXSxbInN0YXJ0cy13aXRoIiwiJGtleSIsInVzZXItZGlyXC8iXV19",signature: "rstrV1kizKPr6byfHzIHnz+Pt80=",expire: 1493277670,dir: "user-dir/"}'
  },
  //上传文件名
  calculate_object_name: function(filename) {
    if (this.g_object_name_type == 'local_name') {
      this.g_object_name += "${filename}"
    } else if (this.g_object_name_type == 'random_name') {
      suffix = get_suffix(filename)
      this.g_object_name = this.key + random_string(10) + suffix
    }
    return ''
  },
  //设置上传参数
  set_upload_param: function(filename) {
    var ret = this.get_signature();
    this.g_object_name = this.key;
    if (filename != '') {
      suffix = get_suffix(filename)
      this.calculate_object_name(filename)
    }
    return new_multipart_params = {
      'key': this.g_object_name,
      'policy': this.policyBase64,
      'OSSAccessKeyId': this.accessid,
      'success_action_status': '200', //让服务端返回200,不然，默认会返回204
      'callback' : this.callbackbody,
      'signature': this.signature
    };
  },
  //上传前获取签名
  get_signature: function() {
    //可以判断当前expire是否超过了当前时间,如果超过了当前时间,就重新取一下.3s 做为缓冲
    now = timestamp = Date.parse(new Date()) / 1000;
    if (this.expire < now + 3) {
      var body = this.send_request();
      var obj = eval("(" + body + ")").data;
      this.host = obj.host;
      this.policyBase64 = obj.policy;
      this.accessid = obj.accessid;
      this.signature = obj.signature;
      this.expire = parseInt(obj.expire);
      this.callbackbody = obj.callback;
      this.key = obj.dir;
      return true;
    }
    return false;
  }
};

var validInfo = {
  mobile: /^1[34578]{1}\d{9}$/,
  mobile2: /^91916/,
  password: /^\S{6,16}$/,
  chinese: /^[^\u4e00-\u9fa5]{6,16}$/,
  verifyCode: /\d{4,6}/,
  idCardNo: /\d{17}[\d|x]|\d{15}/,
  notEmply: /\s*\S+/,
  email: /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
};

// 添加响应头字段
var ResHeader = 'https:';

//替换字符串换行符为br标签
function n2br(str) {
  str = str.replace(/\r\n/g, "<br>");
  str = str.replace(/\n/g, "<br>");
  return str;
}

//获取字符串结尾数字
function getEndNum(str) {
  var match = str.match(/(\d+$)/g);
  var num = match[0];
  return num;
}

//checkLogin (检查用户是否登录)
function checkLogin(userId) {
  if (userId < 1) {
    window.location.href = "/wechat/login";
    return false;
  }
}

function GetRequest() {
  var url = location.search; //获取url中"?"符后的字串
  var theRequest = {};
  if (url.indexOf("?") != -1) {
    var str = url.substr(1);
    strs = str.split("&");
    for (var i = 0; i < strs.length; i++) {
      theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
    }
  }
  return theRequest;
}

//localstorage
var Storage = {};

Storage.get = function(name) {
  return JSON.parse(localStorage.getItem(name));
};

Storage.set = function(name, val) {
  localStorage.setItem(name, JSON.stringify(val));
  return true;
};

Storage.add = function(name, addVal) {
  var oldVal = Storage.get(name);
  var newVal = oldVal.concat(addVal);
  Storage.set(name, newVal);
};

Storage.del = function(name) {
  localStorage.removeItem(name);
};

//格式化日期格式2017-01-02
function formatDate(string) {
  var D = new Date(new Date(string).getTime()),
    year = D.getFullYear(),
    month = D.getMonth() + 1,
    date = D.getDate();
    if (month < 10) {
      month = '0' + month;
    }
    if (date < 10) {
      date = '0' + date;
    }
  return [year, month, date].join('-');
}


//获取字符串长度（汉字算两个字符，字母数字算一个）
function getByteLen(val) {
  var len = 0;
  for (var i = 0; i < val.length; i++) {
    var a = val.charAt(i);
    if (a.match(/[^\x00-\xff]/ig) !== null) {
      len += 2;
    } else {
      len += 1;
    }
  }
  return len;
}
/**
 * js截取字符串，中英文都能用
 * @param str：需要截取的字符串
 * @param len: 需要截取的长度
 */
function cutstr(str, len) {
  var str_length = 0;
  var str_len = 0;
  str_cut = '';
  str_len = str.length;
  for (var i = 0; i < str_len; i++) {
    a = str.charAt(i);
    str_length++;
    if (escape(a).length > 4) {
      //中文字符的长度经编码之后大于4
      str_length++;
    }
    str_cut = str_cut.concat(a);
    if (str_length >= len) {
      str_cut = str_cut.concat("");
      return str_cut;
    }
  }
  //如果给定字符串小于指定长度，则返回源字符串；
  if (str_length < len) {
    return str;
  }
}

// 从第二个item开始，随着上划，item从下往上动画进入
function fadeInUp($elList, $elItem, delaySecond) {
  var $aLi = $($elList).find($elItem);
  var num = $aLi.length;
  $aLi.eq(1).css('animation-delay', delaySecond + 's').addClass('animated fadeInUp');

  $(window).scroll(function() {
    var wHeight = $(window).height();
    var iHeight = $aLi.eq(0).height();
    var sTop = $('body').scrollTop();
    for (var i = 2; i < num; i++) {
      var gapTop = $aLi.eq(i).offset().top;
      if (sTop + wHeight + iHeight > gapTop) {
        $aLi.eq(i).css('animation-delay', delaySecond + 's').addClass('animated fadeInUp');
      }
    }
  });
}


//导航栏粘贴在顶部
var StickUp = {
  init: function(navEl) { //传入导航栏选择器字符串 示例 'nav'
    this.attachEl(navEl);
    this.bind();
  },
  attachEl: function(navEl) {
    this.$el = $(navEl);
    this.$c = $('body');
    this.elTop = this.$el.offset().top;
  },
  bind: function() {
    var me = this;
    $(window).on('scroll', function() {
      me.do();
    });
  },
  do: function() {
    var scrollTop = this.$c.scrollTop();
    if (scrollTop > this.elTop) {
      this.stick();
    } else {
      this.unstick();
    }
  },
  stick: function() {
    if (this.$el.hasClass('sticked')) {
      return;
    }
    this.$el.addClass('sticked');
    this.$el.css('position', 'fixed');
    var $temp = $('<div class="temp"></div>');
    $temp.height(this.$el.height());
    this.$el.before($temp);
  },
  unstick: function() {
    this.$el.removeClass('sticked');
    this.$el.prev('.temp').remove();
    this.$el.css('position', 'static');
  }
};

//导航栏粘贴在顶部
function StickUpAll (navEl) {
    this.$el = $(navEl);
    this.$c = $(document);
    this.elTop = this.$el.offset().top;
    this.bind();
}

StickUpAll.prototype = {
  bind: function() {
    var me = this;
    $(window).on('scroll', function() {
      me.do();
    });
  },
  do: function() {
    var scrollTop = this.$c.scrollTop();
    if (scrollTop > this.elTop) {
      this.stick();
    } else {
      this.unstick();
    }
  },
  stick: function() {
    if (this.$el.hasClass('sticked')) {
      return;
    }
    this.$el.addClass('sticked');
    this.$el.css('position', 'fixed');
    var $temp = $('<div class="temp"></div>');
    $temp.height(this.$el.height());
    this.$el.before($temp);
  },
  unstick: function() {
    this.$el.removeClass('sticked');
    this.$el.prev('.temp').remove();
    this.$el.css('position', 'static');
  }
};


//去除字符串首尾空格
function trimStr(str) {
  return str.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
}

//字符串长度汉字算2个字符
function zhStrlen(str) {
  return str.replace(/[^\x00-\xff]/g, "**").length;
}

//时间转换
function unixToTime(timestamp) {
  if (timestamp == 0) {
    return '保密';
  } else {
    var unixTimestamp = new Date(timestamp * 1000);
    var nowYear = unixTimestamp.getFullYear();
    var nowMonth = unixTimestamp.getMonth() + 1;
    var nowDay = unixTimestamp.getDate();
    var dataStr = nowYear + '年' + nowMonth + '月' + nowDay + '日';
    return dataStr;
  }
}

var rememberUser = {
  remember: function(account) {
    setCookie("yszAccount", account);
  },
  getLast: function() {
    return getCookie("yszAccount");
  }
}

// 获取一级域名
function GetCookieDomain() {
  var host = location.hostname;
  var ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
  if (ip.test(host) === true || host === 'localhost') return host;
  var regex = /([^]*).*/;
  var match = host.match(regex);
  if (typeof match !== "undefined" && null !== match) host = match[1];
  if (typeof host !== "undefined" && null !== host) {
    var strAry = host.split(".");
    if (strAry.length > 1) {
      host = strAry[strAry.length - 2] + "." + strAry[strAry.length - 1];
    }
  }
  return '.' + host;
}

//cookie相关：设置、获取、删除
// 一级域名
function setCookieDomain(key, value, expiredays) {
    var exdate = new Date()
    exdate.setDate(exdate.getDate() + expiredays)
    document.cookie = key + "=" + escape(value) +
      ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; domain=" + GetCookieDomain() + "; path=/";
  }

function setCookie(key, value, expiredays) {
  var exdate = new Date();
  exdate.setDate(exdate.getDate() + expiredays)
  document.cookie = key + "=" + escape(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; path=/";
}

function getCookie(key) {
  var arr, reg = new RegExp("(^| )" + key + "=([^;]*)(;|$)");
  if (arr = document.cookie.match(reg)) {
    return unescape(arr[2]);
  } else {
    return null;
  }
}

function deleteCookie(name) {
  setCookieDomain(name, undefined, 0);
  setCookie(name, undefined, 0);
  // if (getCookie(name) === true) {
  //   return setCookie(name, undefined, 0);
  // }

  // return setCookie(name, '', 0);
}

function formatTime(timespan) {

  timespan = timespan * 1000;
  var dateTime = new Date(timespan);
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

  milliseconds = now_new - timespan;

  if (milliseconds <= 1000 * 60 * 1) {
    timeSpanStr = '刚刚';
  } else if (milliseconds <= 1000 * 60 * 60) {
    timeSpanStr = Math.round((milliseconds / (1000 * 60))) + '分钟前';
  } else if (1000 * 60 * 60 * 1 < milliseconds && milliseconds <= 1000 * 60 * 60 * 24) {
    timeSpanStr = Math.round(milliseconds / (1000 * 60 * 60)) + '小时前';
  } else if (1000 * 60 * 60 * 24 < milliseconds && milliseconds <= 1000 * 60 * 60 * 24 * 3) {
    timeSpanStr = Math.round(milliseconds / (1000 * 60 * 60 * 24)) + '天前';
  } else {
    timeSpanStr = year + '-' + month + '-' + day;
  }
  return timeSpanStr;
}

// 数字转中文
//创建class类
function NumToChinese() {
    this.init.apply(this, arguments);
}
var _numToChinese = {
    // 数字与中文映射
    ary0:["零", "一", "二", "三", "四", "五", "六", "七", "八", "九"],
    // 每四位以内的单位
    ary1:["", "十", "百", "千"],
    // 四位以上的单位
    ary2:["", "万", "亿", "兆"],
    init:function (name) {
        this.name =  String(name);
    },
    strrev:function () {
        var ary = [];
        for (var i = this.name.length; i >= 0; i--) {
            ary.push(this.name[i]);
        }
        return ary.join("");
    }, //倒转字符串。
    isUnit: function(ary) {
        var retVal = false;
        var cur = ary[0];
        if(this.ary2.indexOf(cur) > 0) {
            retVal = true;
        }
        return retVal;
    },// 检查是否时ary2中的单位
    change:function () {
        var $this = this;
        // 反转后再逐位处理
        var ary = this.strrev();
        // 是否读零
        var zero = "";
        // 缓存结果
        var newary = "";
        // 万级单位数组索引
        var i4 = -1;
        for (var i = 0; i < ary.length; i++) {
            // 首先判断万级单位，每隔四个字符就让万级单位数组索引号递增
            if (i % 4 == 0) {
                i4++;
                // 将万级单位存入该字符的读法中去，它肯定是放在当前字符读法的末尾，所以首先将它叠加入$r中，
                newary = this.ary2[i4] + newary;
                // 在万级单位位置的“0”肯定是不用的读的，所以设置零的读法为空
                zero = "";
            }
            //关于0的处理与判断。
            //如果读出的字符是“0”，执行如下判断这个“0”是否读作“零”
            if (ary[i] == '0') {
                switch (i % 4) {
                    case 0:
                        break;
                    // 如果位置索引能被4整除，表示它所处位置是万级单位位置，
                    // 这个位置的0的读法在前面就已经设置好了，所以这里直接跳过
                    case 1:
                    case 2:
                    case 3:
                        // 如果不被4整除，那么都执行这段判断代码：
                        // 如果它的下一位数字（针对当前字符串来说是上一个字符，因为之前执行了反转）也是0，
                        // 那么跳过，否则读作“零”
                        if (ary[i - 1] != '0') {
                            zero = "零";
                        }
                        break;

                }

                newary = zero + newary;
                zero = '';
            }
            else {
                // 如果不是“0”，就将该当字符转换成数值型，
                // 并作为数组ary0的索引号，以得到与之对应的中文读法，
                // 其后再跟上它的的一级单位（空、十、百还是千）最后再加上前面已存入的读法内容。
                newary = this.ary0[parseInt(ary[i])] + this.ary1[i % 4] + newary;
            }

        }
        // 用while处理最前面的零和单位（前面没有数字则不需要单位）
        while (newary.indexOf("零") == 0 || this.isUnit(newary)) {
            newary = newary.substr(1);
        }
        return newary;
    }
}
NumToChinese.prototype = _numToChinese;

// 百度统计代码
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?b04dbbe8716725ab25d51f59b1f1931e";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();

// 谷歌统计代码
// (function(i, s, o, g, r, a, m) {
//   i['GoogleAnalyticsObject'] = r;
//   i[r] = i[r] || function() {
//     (i[r].q = i[r].q || []).push(arguments)
//   }, i[r].l = 1 * new Date();
//   a = s.createElement(o),
//     m = s.getElementsByTagName(o)[0];
//   a.async = 1;
//   a.src = g;
//   m.parentNode.insertBefore(a, m)
// })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

// ga('create', 'UA-96560910-2', 'auto');
// ga('send', 'pageview');
// 一级域名
var _getCookie = function(key) {
  var arr, reg = new RegExp("(^| )" + key + "=([^;]*)(;|$)");
  if (arr = document.cookie.match(reg)) {
    return unescape(arr[2]);
  } else {
    return null;
  }
}
var _setCookie = function(key, value, expiredays) {
  var exdate = new Date()
  exdate.setDate(exdate.getDate() + expiredays)
  document.cookie = key + "=" + escape(value) +
    ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; domain=" + GetCookieDomain() + "; path=/";
}
var _setCookie1 = function(key, value, expiredays) {
  var exdate = new Date()
  exdate.setDate(exdate.getDate() + expiredays)
  document.cookie = key + "=" + escape(value) +
    ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; path=/";
}
var _deleteCookie = function (key, value, expiredays) {
  function _set(key, value, expiredays) {
    var exdate = new Date()
    exdate.setDate(exdate.getDate() + expiredays)
    document.cookie = key + "=" + escape(value) +
      ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString()) + "; path=/";
  }
  _setCookie1(key, undefined, 0);
  _set(key, undefined, 0);
}
