var vmApp = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace'),
    },
    isSubmit: false,
    ruleForm: {
      subid: '',
      artid: '',
      description: '' 
    },
    rules: {
      artid: [{
        required: true,
        message: '请选择您的作品',
        trigger: 'change'
      }],
      description: [{
        required: true,
        message: '请输入您的作品寄语',
        trigger: 'blur'
      }]
    },
    artworkList: [
      {
        // "id": "48",  //编号
        // "name": "作品名称",
        // "updatetimes": "更新次数",
        // "shape": "1",  //形状1方形2圆形
        // "length": "长",
        // "width": "宽",
        // "diameter": "0",  //直径
        // "story": "作品故事",
        // "last_update_time": "2017-05-24 19:07",  //最后更新时间
        // "isfinished": "N",  //是否完成
        // "liketotal": "0",  //喜欢数
        // "viewtotal": "2",  //浏览数
        // "category_name": "水彩",  //作品类型
        // "panorama": "作品封面",
        // "size": '作品尺寸' //尺寸
      }
    ],
    selectArt: {
      // "id": "48",  //编号
      // "name": "作品名称",
      // "updatetimes": "更新次数",
      // "shape": "1",  //形状1方形2圆形
      // "length": "长",
      // "width": "宽",
      // "diameter": "0",  //直径
      // "story": "作品故事",
      // "last_update_time": "2017-05-24 19:07",  //最后更新时间
      // "isfinished": "N",  //是否完成
      // "liketotal": "0",  //喜欢数
      // "viewtotal": "2",  //浏览数
      // "category_name": "类型",  //作品类型
      // "coverUrl": "http://gsy-other.oss-cn-beijing.aliyuncs.com/uploads/2017/05/24/1495624054665.jpeg",
      // "size": '/作品尺寸' //尺寸
    },
    subjectInfo: {
      // "id": "3",
      // "sub_name": "风景",   //主题名称
      // "sub_title": "自然风光推荐",  //副标题
      // "cover": "主题封面",
      // "description": "自然美好的风光",  //主题描述
      // "start_time": "1493600400",  //主题开始时间
      // "end_time": "1496152800",  //主题结束时间
      // "applyStatus": 0  //状态0:未申请,1:申请中,2:申请通过,-1:申请未通过
    },
    errorTip: '',
    btnText: '提交申请',
    boxIsShow: false
  },
  created: function () {
    var that = this;
    this.subjectInfo = Storage.get('applySubjectItem');
    this.ruleForm.subid = this.subjectInfo.id;

    artzheAgent.call2('Gallery/getArtworkDetailList2', {
      artistId: that.myInfo.uid,
      page: 1,
      perPageNumber: 100
    }, function(res) {
      if (res.code == 30000) {
        var artworkList = res.data.info;
        artworkList.forEach(function (item) {
          if (item.shape == '1') {  //方形
            if (item.length > 0 && item.width > 0) {
              item.size = '/' + item.length  + 'x' + item.width + 'cm';
            } else {
              item.size = '';
            }
            
          } else if (item.shape == '2') { //圆形
            if (item.diameter > 0) {
              item.size = '/D=' + item.diameter + 'cm';
            } else {
              item.size = '';
            }
          }
        });
        // console.log(artworkList);
        that.artworkList = artworkList;

        //默认选择第一幅作品
        that.selectArt = that.artworkList[0];
        that.ruleForm.artid = that.selectArt.id;
      }
    });
  },
  methods: {
    submitForm: function (formName) {
      var that = this;
      this.$refs[formName].validate((valid) => {
        if (valid) {
          var formData = this.ruleForm;
          for (var prop in formData) {
            formData[prop] = trimStr(formData[prop]);
          }

          //避免重复点击提交
          if (this.isSubmit) {
            return false;
          }
          this.isSubmit = true;
          this.btnText = "提交中...";

          artzheAgent.call2('subject/addSubjectApply',formData,
            function(res) {
              that.isSubmit = false;
              // console.log(res);
              if (res.code == 30000) {
                that.btnText = '跳转中...';
                that.showBox();
                window.location.href = '/topic/index';
              }
            },
            function (res) {
              that.isSubmit = false;
            }
          );
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    handleChange: function (item) {
      console.log(item);
      for (var i = 0; i < this.artworkList.length; i++) {
        if (this.artworkList[i].id == item) {
          this.selectArt = this.artworkList[i];
          return false;
        } 
      }
    },
    submitApply: function () {
      console.log('applyPromote');
      var that = this;
      var formData = {};
      if (this.applyInfo.img == '' || this.applyInfo.desc == '') {
        if (this.applyInfo.img == '') {
          this.errorTip = "请上传个性照作为推广封面";
        } else if (this.applyInfo.desc == '') {
          this.errorTip = "请输入个人名句";
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
        artzheAgent.call2('Extension/edit', formData, function(res) {
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
        artzheAgent.call2('Extension/apply', formData, function(res) {
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
    showBox: function () {
      this.boxIsShow = true;
    },
    hideBox: function () {
      this.boxIsShow = false;
    },
    goToList: function () {
      this.hideBox();
      window.location.href = '/topic/index';
    }
  }
});