function initJcrop() {
  $('#cropbox').Jcrop({
    onSelect: updateCoords,
    aspectRatio: 1,
    boxWidth: 300,
    boxHeight: 300
  }, function() {

    //图片实际尺寸
    var bb = this.getBounds();
    var bWidth = Number(bb[0]) / 2;
    var bHeight = Number(bb[1]) / 2;
    // console.log(bb);
    this.setSelect([0, 0, bWidth, bHeight]);


    var ss = this.getWidgetSize();
    var aheight = (300 - Number(ss[1])) / 2 + "px";
    $(".jcrop-holder").css("margin-top", aheight);
    // console.log(bWidth);
    // console.log(bHeight);
  });
}

function updateCoords(c) {
  // console.log(c);
  var img = document.getElementById("cropbox");
  var ctx = document.getElementById("myCan").getContext("2d");

  //img,开始剪切的x,Y坐标宽高，放置图像的x,y坐标宽高。
  ctx.drawImage(img, c.x, c.y, c.w, c.h, 0, 0, 400, 400);
}

function transDataUrl(dataurl) {
  var data = dataurl.split(',')[1];
  data = window.atob(data);
  var ia = new Uint8Array(data.length);
  for (var i = 0; i < data.length; i++) {
    ia[i] = data.charCodeAt(i);
  }
  return new Blob([ia], {
    type: "image/png",
    endings: 'transparent'
  });
}
Vue.use(VueLazyload, {
  preLoad: 1.3,
  // error: 'dist/error.png',
  loading: '/Public/image/holder.png',
  attempt: 1
});
var vmApp = new Vue({
  el: '#app',
  data: {
    isLogin: true,
    form: {
      face: '/Public/image/holder.png',
      nickname: '',
      motto: '',
      resume: '',
      gender: '',
      cover: '/Public/image/holder.png'
    },
    info: {

    },
    compress: compress, //图片压缩后缀
    isSubmit:false,
    //裁切上传图片相关
    boxIsShow: false,
    uploadIsShow: false,
    btnText: '完成',
    uploadText: '确认上传',
    btnfollow: '+ 关注',
    uploadClick: false,
    preTxet: '', //预览文字
    activeImg: '', // cover|face
    activeName: 'first', //tab
    isshow1: true,
    isshow2: true,
    busy:false,
    busy2:false,
    flourList: [], //我的花絮列表
    collectionList: [], //我的作品集列表
    loading: true,
    totalpage: 1,
    curpage: 1,
    inputpage: '',
    totalpage2: 1,
    curpage2: 1,
    inputpage2: '',
  },
  created: function() {
      var active = window.location.search.split('?')[1]?window.location.search.split('?')[1]:'first'; //默认为个人信息tab
      this.activeName = active;
      
      this.flourlist();
      this.collectionlist();
  },
  mounted: function() {
    eventBus.$on('setUserInfo', function(info) {
      this.init(info);
    }.bind(this));
  },
  methods: {
    init: function (info) {
      var that = this;
      this.info = info;
      this.form = {
        face: info.faceUrl,
        nickname: info.name,
        motto: info.motto,
        resume: info.resume,
        gender: info.gender ? info.gender : 3,
        cover: info.cover
      };
      if (info.isArtist == 1) {
        this.$nextTick(function () {
          new QRCode(document.getElementById("qrcode"), switchDomin('m') + '/gallery/detail/'+ that.info.artist);
        });
      }
    },
    checknic: function(){ //检测超过20字符截取前20个
      if(this.zhStrlen(this.form.nickname)>20){
        this.$nextTick(() => {
          this.form.nickname = this.cutstr(this.form.nickname,20)
          this.form.nickname = this.trimStr(this.form.nickname);
        })
      }
    },
    onSubmit: function (data) {
      var that = this;
      var api = '/Api/UserCenter/saveUserInfo'; //设置个人信息
      var data = data;

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }
      this.isSubmit = true;
      $.ajax({
        type: "POST",
        url: api,
        data: data,
        success: function(res) {
          if (res.code == '30000' && res.data.status == '1000') {
            that.$message({
              message: '设置成功',
              type: 'success'
            });
          }
        },
        complete: function () {
          that.isSubmit = false;
        }
      });
    },
    showUpload: function(imgType) { //上传封面或头像
      if (imgType == 'cover') {
        this.activeImg = 'cover';
        this.preTxet = '上传封面';
      } else if (imgType == 'face') {
        this.activeImg = 'face';
        this.preTxet = '上传头像';
      }

      this.boxIsShow = true;
      this.uploadIsShow = true;
    },
    hideBox: function() {
      this.boxIsShow = false;
      this.uploadIsShow = false;
    },
    uploadImg: function() {
      var that = this;
      if ($("#imgfield").html()) {
        //获取裁剪完后的base64图片url,转换为blob
        var image = new Image();
        var data = document.getElementById("myCan").toDataURL();
        var imgSrc = transDataUrl(data);
        // console.log(imgSrc);
        this.uploadText = "上传中...";
        //避免重复点击提交
        if (this.uploadClick) {
          return false;
        }
        this.uploadClick = true;
        var fd = new FormData();
        fd.append('file', imgSrc);
        $.ajax({
          url: "/Api/UserCenter/uploadImage",
          data: fd,
          type: 'POST',
          dataType: 'json',
          asyn: false,
          processData: false, // 告诉jQuery不要去处理发送的数据
          contentType: false, // 告诉jQuery不要去设置Content-Type请求头
          success: function(res) {
            // console.log(res);
            that.uploadClick = false;
            if (res.code == '30000' && res.data.status == '1000') {
              // that.$message({
              //   message: '上传成功'
              // });
              that.uploadText = "上传";

              that.form[that.activeImg] = res.data.info.url;
              var activeImg = that.activeImg;
              var subData = {};
              subData[that.activeImg] = res.data.info.url;
              that.onSubmit(subData);
              that.hideBox();
            } else {
              that.$message({
                message: '上传失败'
              });
              that.uploadText = "确认上传";
            }
          },
          complete: function(res) {
            that.uploadClick = false;
          },
          error: function (res) {
            that.$message({
              message: '上传失败'
            });
            that.uploadText = "确认上传";
          }
        });
      } else {
        that.$message({
          message: '请先选择图片'
        });
      }
    },
    getimg: function() {
      $("#fileimg").click();
      this.showUpload();
    },
    imgchange: function() {
      var that = this;
      var localimg = $("#fileimg").get(0).files[0];
      if (!localimg) {
        return;
      }
      var fileName = localimg.name;
      var fileSize = localimg.size;
      var fileType = fileName.substring(fileName.lastIndexOf('.'), fileName.length).toLowerCase();
      if (fileType != '.gif' && fileType != '.jpeg' && fileType != '.png' && fileType != '.jpg') {
        that.$message({
          message: '上传失败，请上传jpg,png格式的图片'
        });
        return;
      }

      // var size = 3 * 1024 * 1024;
      // if (fileSize > size) {
      //   that.$message({
      //     message:'上传失败，请上传3MB以内的图片。'
      //   });
      //   return;
      // }

      var reader = new FileReader();
      //将文件读取为DataURL
      reader.readAsDataURL(localimg);
      reader.onload = function(e) {
        var localimghtml = '<img id="cropbox" src="' + e.target.result + '" >';
        $("#imgfield").html(localimghtml);
        initJcrop();
      };

    },
    getlistTab: function(tab){
      console.log(tab.name)
    },
    followorno: function(){ //关注或取消关注
      this.btnfollow = '取消关注';
    },
    flourlist: function(){ //创作、絮
      this.loading = true;
      var that = this;
      var obj = {
        pagesize: 4,
        page: that.curpage
      };
      $.ajax({
        url:'/Api/UserCenter/getMyArtistRecord',
        type: 'post',
        data: obj,
        dataType: 'json',
        success: function(res){
          if(res.code == 30000){
            that.loading = false;
            var resInfo = res.data.info;
            that.totalpage = res.data.info.maxpage,
            that.curpage = res.data.info.page,
            that.flourList = resInfo.data;
            
          }
        }
      })
    },
    collectionlist: function(){ //作品、集
      var that = this;
      var obj = {
        pagesize: 6,
        page: that.curpage2
      };
      $.ajax({
        url: '/Api/UserCenter/getMyArtistArtworkList',
        type: 'post',
        data: obj,
        dataType:'json',
        success: function(res){
          that.loading = false;
          if(res.code == 30000){
            var resInfo = res.data.info;
            that.totalpage2 = res.data.info.maxpage,
            that.curpage2 = res.data.info.page,
            that.collectionList = resInfo.data;

          }
        }
      })
    },
    toggleLike: function (id, index) {
      var that = this;
      var data = {
        id: id,
        type: 1
      };

      if (that.collectionList.data[index].is_like == "N") {
        if (this.likeClick) {
          return false;
        }
        this.likeClick = true;
        $.ajax({
          type: "POST",
          url: '/Api/Artwork/like',
          data: data,
          success: function(res) {
            // console.log(res);
            that.likeClick = false;
            if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
              eventBus.$emit('showLogin', 'login', 'login');
            } else if (res.code == '30000' && res.data.status == 1000) {
              that.artworkInfo.data[index].is_like = "Y";
              that.artworkInfo.data[index].liketotal++;
            }
          }
        });
      } else if (that.artworkInfo.data[index].is_like == "Y") {
        eventBus.$emit('showLikeBox', id, 1, index);
        // $.ajax({
        //   type: "POST",
        //   url: '/Api/Artwork/unlike',
        //   data: data,
        //   success: function(res) {
        //     console.log(res);
        //     that.likeClick = false;
        //     if (res.code == '30102' || res.code == "30103" || res.code == "30004") {
        //       eventBus.$emit('showLogin', 'login', 'login');
        //     } else if (res.code == '30000' && res.data.status == 1000) {
        //       that.artworkInfo.data[index].is_like = "N";
        //       that.artworkInfo.data[index].liketotal--;
        //     }
        //   }
        // });
      }
    },
    unlike: function(id, type, index) {
      this.artworkInfo.data[index].is_like = "N";
      this.artworkInfo.data[index].liketotal--;
    },
    pagePrev: function() {
      var that = this;
      if (this.curpage - 1 != 0) {
        this.loading = true;
        this.curpage--;
        this.flourlist();
      }
    },
    pageNext: function() {
      var that = this;
      if (this.curpage + 1 <= this.totalpage) {
        this.loading = true;
        this.curpage++;
        this.flourlist();
      }
    },
    gotopage: function() {
      var that = this;
      if (0 < this.inputpage && this.inputpage <= this.totalpage) {
        this.loading = true;
        this.curpage = this.inputpage;
        this.flourlist();
      }
    },
    pagePrev2: function() {
      var that = this;
      if (this.curpage2 - 1 != 0) {
        this.loading2 = true;
        this.curpage2--;
        this.collectionlist();
      }
    },
    pageNext2: function() {
      var that = this;
      if (this.curpage2 + 1 <= this.totalpage2) {
        this.loading2 = true;
        this.curpage2++;
        this.collectionlist();
      }
    },
    gotopage2: function() {
      var that = this;
      if (0 < this.inputpage2 && this.inputpage2 <= this.totalpage2) {
        this.loading = true;
        this.curpage2 = this.inputpage2;
        this.collectionlist();
      }
    },
    cutstr: function(str, len) { //

      /**
       * js截取字符串，中英文都能用
       * @param str：需要截取的字符串
       * @param len: 需要截取的长度
       */

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
    },
    trimStr: function(str) {//去除字符串首尾空格
      return str.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
    },
    zhStrlen: function(str) {//字符串长度汉字算2个字符
      return str.replace(/[^\x00-\xff]/g, "**").length;
    }
  }
});
