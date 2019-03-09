var vmApp = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace'),
    },
    applyInfo: {
      id: '',
      artist: getCookie('userid'),
      desc: '',
      img: ''
    },
    isSubmit: false,
    applyImgList: {

    },
    uploadImg: '',
    userInfo: {    //需后端返回
      // "name":"李狗蛋",
      // "nickname":"李狗蛋",
      // "account":"李狗蛋",
      // "category" : "油画/水彩",
      // "motto":"离我去者，昨日之日不可留",
      // "resume":"李靖之子，其母怀胎三年六个月所生，出生时已是成年形态，拥有一次重新设定形态的机会。重新设定形态之后拥有可爱萝莉的脸型与肌肉男的身体，力大无比，喜欢卖萌",
      // "birthday":"1489648890",
      // "gender":"1",//1男2女3(未知???),
      // "face":"156",
      // "faceUrl":"https://img6.bdstatic.com/img/image/smallpic/anyixuan.jpg",
      // "mobile":"13765851683",
      // "follower_total":"100",
      // "follow_total":"101",
      // "invite_total":"120"
    },
    artistInfo: {
      applyed: true,
      imgUrl: '/image/promote/template.png'
    },
    applyed: true,
    imgUrl: '/image/promote/template.png',
    templateInfo: {
      curIdx: '0',
      curUrl: '/image/promote/template_btn_blank.png',
      list: [
      {num: '38', imgUrl:'/image/promote/template.png'},
      {num: '39', imgUrl:'/image/promote/template1.png'}
      ]
    },
    promoteInfo: {

    },
    errorTip: '',
    btnText: '提交申请',
    boxIsShow: false
  },
  created: function () {
    var that = this;
    artzheAgent.call('User/getUserInfo', {}, function(res) {
      console.log(res);
      if (res.code == 30000) {
        that.userInfo = res.data.info;
      }
    });
    artzheAgent.call('Extension/getInfoByArtist', {artistid: this.myInfo.uid}, function(res) {
      console.log(res);
      if (res.code == 30000) {
        if (res.data.status == 1000) {
          that.promoteInfo = res.data.info;
          that.applyInfo.id = res.data.info.id;
          that.applyInfo.desc = res.data.info.desc;
          that.applyInfo.img = res.data.info.img;
          that.uploadImg = res.data.info.img;
        }
      }
    });
  },
  methods: {
    submitApply: function () {
      console.log('applyPromote');
      var that = this;
      var formData = {};
      if (this.applyInfo.img == '' || this.applyInfo.desc == '' || this.applyInfo.img.indexOf('undefined') > -1) {
        if (this.applyInfo.img == '') {
          this.errorTip = "请上传个性照作为推广封面";
        } else if (this.applyInfo.desc == '') {
          this.errorTip = "请输入个人名句";
        } else if (this.applyInfo.img.indexOf('undefined') > -1) {
          that.$message({
            message: '图片上传失败，请重新上传！'                  
          }); 
        }
        setTimeout(function () {
          that.errorTip = '';
        }, 2000);
        return false;
      }

      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }


      this.isSubmit = true;
      this.btnText = "提交中...";

      if (this.applyInfo.id) {
        formData = this.applyInfo;
        console.log(formData);
        artzheAgent.call('Extension/edit', formData, function(res) {
          that.isSubmit = false;
          console.log(res);
          
          if (res.code == 30000) {
            that.btnText = "跳转中...";
            that.showBox();
            setTimeout(function () {
              window.location.href = '/promote/index';
            }, 3000);
          }
        });
      } else {
        formData = {
          artist: this.applyInfo.artist,
          desc: this.applyInfo.desc,
          img: this.applyInfo.img
        };
        console.log(formData);
        artzheAgent.call('Extension/apply', formData, function(res) {
          that.isSubmit = false;
          console.log(res);

          if (res.code == 30000) {
            that.btnText = "跳转中...";
            that.showBox();
            setTimeout(function () {
              window.location.href = '/promote/index';
            }, 3000);
          }
        });
      }
    },
    beforeAvatarUpload: function (file) {
      var type = file.type.toUpperCase();
      if (type !== 'IMAGE/JPEG' && type !== 'IMAGE/PNG' && type !== 'IMAGE/JPG' && type !== 'IMAGE/BMP' && type !== 'IMAGE/GIF') {
        this.$message({
          message: '请上传图片'
        });
        return false;
      }
    },
    handleAvatarSuccess: function (res, file) {
      // console.log(res);

      this.uploadImg = ResHeader + res.path;
      this.applyInfo.img = ResHeader + res.path;
    },
    stopPromote: function () {

    },
    rePromote: function () {
      this.isToApply = true;
    },
    gotoPromote: function () {
      this.isToApply = true;
    },
    downloadPic: function () {

    },
    chooseTemplate: function (index) {
      this.templateInfo.curIdx = index;
      this.templateInfo.curUrl = imgUrl;
    },
    goToSecond: function () {
      this.isNext = true;
    },
    handlePreview: function (argument) {
      // body...
    },
    handleRemove: function () {
      // body...
    },
    showBox: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    gotoPromoteIndex: function () {
      this.hideBox();
      window.location.href = '/promote/index';
    }
  }
});