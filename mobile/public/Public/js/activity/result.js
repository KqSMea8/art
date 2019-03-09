function getRequest() {
  var url = location.search; //获取url中"?"符后的字串
  url = decodeURI(url);
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
var apiHttp = window.location.origin + '/V2/';
var  access_code = getRequest().code;

var vmApp = new Vue({
  // element to mount to
  el: '#app',
  // initial data
  data: {
    isLoading: true,
    friendList: [
      // {
      //   nickname: '李坤',
      //   faceimg: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_180,w_180',
      //   remark: '灵魂伴侣',
      //   percent: '100',
      //   color: '#efc543'
      // }, {
      //   nickname: '李坤2',
      //   faceimg: 'https://gsywww.oss-cn-shenzhen.aliyuncs.com/uploads/2017/05/03/1493805157497.png?x-oss-process=image/resize,m_fixed,h_180,w_180',
      //   remark: '灵魂伴侣',
      //   percent: '80',
      //   color: '#f89aa9'
      // }
    ],
    boxIsShow: false,
    codeIsShow: false,
    hasHecheng: false,
    clicked: 1,
    userInfo: {
      nickname: '',
      face: ''
    },
    resultImg: '',
    total: 0,
    istest: '-1',
    testLink: window.location.protocol + '//api.artzhe.com/v2/active/shenmei'
  },
  created: function() {
    var host = window.location.host;
    if (host.indexOf('test') > -1) {
      this.testLink = window.location.protocol + '//test-api.artzhe.com/v2/active/shenmei';
    }
    this.init();
  },
  mounted: function() {
//
  },
  // methods
  methods: {
    init: function() {
      var that = this;
      var data = {
        uid: getRequest().uid
      };
      if (access_code==null){
          {
              var fromurl=location.href;
              var url='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe73ef5d0e06b9d7c&redirect_uri='+encodeURIComponent(fromurl)+'&response_type=code&scope=snsapi_base&state=EaDnY9AUNmBBx5jGCT7MPUQ7c8c%23wechat_redirect&connect_redirect=1#wechat_redirect';
              location.href=url;
          }
      }else{
          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              url: apiHttp + 'Active/Judge',
              data: {access_code:access_code},
              dataType: "json",
              success: function(res){
                  console.log(res);
                  if (res.code == 3000) {
                      that.istest = res.istest;
                      // if (getRequest().uid == res.useropenid) {
                      //   window.location.href = window.location.origin + '/activity/index';
                      // }
                  }
              }
          });
      }

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
         type: "POST",
         url: apiHttp + 'Active/getFriendsResult',
         data: data,
         dataType: "json",
         success: function(res){
          console.log(res);
          if (res.code == 3000) {
            that.friendList = res.data;
            that.total = res.data.length;
            that.resultImg = res.imgurl;
          }
        }
      });

      // 分享设置
      this.userInfo.nickname = getRequest().nickname;
      var link = window.location.origin + '/activity/result?uid=' + getRequest().uid + '&nickname=' + encodeURI(getRequest().nickname);
      var title = this.userInfo.nickname + '的审美性格竟然是这样，你的呢？';;
      var imgUrl = window.location.origin + '/Public/image/activity/shareicon.png?v=1.0.1';
      var desc = '根据你的审美测性格，还可以看你和' + this.userInfo.nickname + '的审美性格契合度';
      wx.ready(function() {
        wx.onMenuShareTimeline({
          title: desc,
          link: link,
          imgUrl: imgUrl
        });
        wx.onMenuShareAppMessage({
          title: title,
          desc: desc,
          link: link,
          imgUrl: imgUrl,
          type: 'link',
          dataUrl: ''
        });
      });
    },
    showShare: function() {
      this.boxIsShow = true;
      this.shareIsShow = true;
    },
    showCode: function () {
      this.boxIsShow = true;
      this.codeIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.shareIsShow = false;
    },
    hecheng: function() {
      // $(".cover").show();
      //   if (this.clicked == 1) {
      //     var div = $(".cover");
      //     var w = div.width();
      //     var h = div.height();
      //     var canvas = document.createElement("canvas");
      //     canvas.width = w * 2;
      //     canvas.height = h * 2;
      //     canvas.style.width = w + "px";
      //     canvas.style.height = h + "px";
      //     var context = canvas.getContext("2d");
      //     //然后将画布缩放，将图像放大两倍画到画布上
      //     var cenX = (div.offset().left) * 2;
      //     var cenY = (div.offset().top) * 2;
      //     context.translate(-cenX, -cenY);
      //     context.scale(2, 2);
      //     html2canvas(div, {
      //       canvas: canvas,
      //       onrendered: function(canvas) {
      //         var image = new Image();
      //         image.id = "newimg";
      //         image.crossOrigin = "Anonymous";
      //         image.src = canvas.toDataURL("image/png");
      //         div.append(image);
      //       },
      //       useCORS:true
      //     });
      //     this.clicked = 0;
      //   }
    },
    addActiveAndNum: function(id, index, tagids) {
      var that = this;
      var nextIndex = index + 1;
      this.selectedIds.push(tagids);
      this.selectedIds = this.uniqueArr(this.selectedIds);
      mySwiperH.slideTo(nextIndex, 500, true);
      this.progress = nextIndex * 100 / 5 + '%';
      this.curIndex = nextIndex;
      this.$nextTick(function() {
        this.imageList.forEach(function(list) {
          list.forEach(function(item) {
            if (item.id == id) {
              Vue.set(item, 'active', true);
            } else {
              Vue.set(item, 'active', false);
            }
          });
        });
      });

      if (this.curIndex == 5) {
        this.shenmeiIsShow = false;
        setTimeout(function() {
          that.resultIsShow = true;
        },300);

      }
    },
    uniqueArr: function(array) {
      var n = []; //一个新的临时数组 
      //遍历当前数组 
      for (var i = 0; i < array.length; i++) {
        //如果当前数组的第i已经保存进了临时数组，那么跳过， 
        //否则把当前项push到临时数组里面 
        if (n.indexOf(array[i]) == -1) {
          n.push(array[i]);
        }
      }
      return n;
    }
  }
});