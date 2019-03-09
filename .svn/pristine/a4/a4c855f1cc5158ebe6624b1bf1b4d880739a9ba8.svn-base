var vmAuth = new Vue({
  el: '#manage',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    prodItems: [], //作品列表    
    prodCount: 0, //作品数量
    curpage: 1, //当前页
    totalpage: '', //总页数
    inputpage: '', //输入页码
    loading: true, //数据加载开关
    maskseen: false, //预览显示开关
    alertseen: false, //弹出框提示开关
    newseen: false, //上传新作品弹窗
    editseen: false,
    maskTxt: '去上传',
    isSetCover: false,
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
    },{
      "id": 2,
      "value": "仅自己可见"
    }]//权限选项
  },
  created: function() {
    var that = this;
    //获取产品列表     
    artzheAgent.call('Gallery/getArtworkDetailList', {
      "artistId": that.myInfo.uid,
      "page": that.curpage,
      'perPageNumber': 9
    }, function(response) {
      if (response.code == 30000 && response.data.status == 1000) {
        that.prodItems = response.data.info;
        //获取产品总数量
        artzheAgent.call('UserCenter/getMyGalleryDetail', {}, function(response) {
          if (response.code == 30000 && response.data.status == 1000) {
            that.loading = false;
            that.prodCount = response.data.info.artTotal;
            that.totalpage = Math.ceil(that.prodCount / 9);
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

  },
  methods: {
    submitForm1: function(formName) {
      var that = this;
      this.$refs[formName].validate(function(valid) {
        if (valid) {
          if (that.isUpload1 || that.isUpload1) {
            that.$message({
              message: '图片上传中，请稍后！'
            });
            return false;
          }
          var st = Storage.get('editor' + that.editID);
          var dateformat = formatDate(st.date);
          var arr1 = [],
            arr2 = [];
          for (var i = 0; i < that.ruleForm.fileList1.length; i++) {
            arr1[i] = that.ruleForm.fileList1[i].url;
          }
          for (var i = 0; i < that.ruleForm.fileList2.length; i++) {
            arr2[i] = that.ruleForm.fileList2[i].url;
          }
          var obj = {
            'artworkName': that.ruleForm.name,
            'categoryId': st.class,
            'artworkTagIds': st.tag.join(','),
            'story': that.ruleForm.desc,
            'wit': st.wit,
            'createDate': dateformat,
            'coverId': st.cover,
            'colorIds': that.ruleForm.color.join(','),
            'artworkLength': that.ruleForm.width,
            'artworkWidth': that.ruleForm.height,
            'panoramaIds': arr1.join(','),
            'topographyIds': arr2.join(',')
          };

          if (obj.panoramaIds.indexOf('undefined') > -1 || obj.topographyIds.indexOf('undefined') > -1) {
            that.$message({
              message: '图片上传失败，请重试！'
            });
            return false;
          }

          if (that.editID === 'Add' + that.myInfo.uid) {
            obj.artworkId = st.artId;
            artzheAgent.call('Artwork/finishArtwork', obj, function(response) { //新增完成画作 
              console.log(response);
              if (response.data.status == 1000 && response.code == 30000) {
                that.$message({
                  message: '更新成功！',
                  type: 'success'
                });
                // Storage.del('editorAdd'+ that.myInfo.uid);
                window.localStorage.clear();
                window.location.href = '/upload/manage'
              } else {
                that.$message.error(response.code + ' : ' + response.message);
              }

            })
          } else {
            obj.artworkUpdateId = that.editID;
            artzheAgent.call('Artwork/edit', obj, function(response) { //单次更新的完成画作 
              console.log(response);
              if (response.data.status == 1000 && response.code == 30000) {
                that.$message({
                  message: '更新成功！',
                  type: 'success'
                });
                // Storage.del('editorAdd'+ that.myInfo.uid);
                window.localStorage.clear();
                window.location.href = '/upload/manage'
              } else {
                that.$message.error(response.code + ' : ' + response.message);
              }

            })
          }
        } else {
          console.log('error submit!!');
          return false;
        }

      });
    },
    pagePrev: function() {
      var that = this;
      this.loading = true;
      if (this.curpage - 1 != 0) {
        this.curpage--;
        artzheAgent.call('Gallery/getArtworkDetailList', {
          "artistId": that.myInfo.uid,
          "page": that.curpage,
          'perPageNumber': 9
        }, function(response) {
          if (response.code == 30000 && response.data.status == 1000) {
            that.prodItems = response.data.info
            that.loading = false;
          } else {
            that.$message.error(response.code + ' : ' + response.message);
          }
        })
        console.log('现在在' + this.curpage + '页');
      }
    },
    pageNext: function() {
      var that = this;
      this.loading = true;
      if (this.curpage + 1 <= this.totalpage) {
        this.curpage++;
        artzheAgent.call('Gallery/getArtworkDetailList', {
          "artistId": that.myInfo.uid,
          "page": that.curpage,
          'perPageNumber': 9
        }, function(response) {
          if (response.code == 30000 && response.data.status == 1000) {
            that.prodItems = response.data.info;
            that.loading = false;
          } else {
            that.$message.error(response.code + ' : ' + response.message);
          }
        })
        console.log('现在在' + this.curpage + '页');
      }
    },
    gotopage: function() {
      var that = this;
      if (0 < this.inputpage && this.inputpage <= this.totalpage) {
        this.loading = true;
        this.curpage = this.inputpage;
        artzheAgent.call('Gallery/getArtworkDetailList', {
          "artistId": that.myInfo.uid,
          "page": that.curpage,
          'perPageNumber': 9
        }, function(response) {
          if (response.code == 30000 && response.data.status == 1000) {
            that.prodItems = response.data.info;
            that.loading = false;
          } else {
            that.$message.error(response.code + ' : ' + response.message);
          }
        })
      }
    },
    showNewPro: function() {
      //判断是否有画廊封面
      this.checkOk();
      this.maskseen = true;
      this.alertseen = false;
      this.editseen = false;
      this.newseen = true;
      // window.location.href = '/uploads/edit';

    },
    showEdit: function() {
      this.checkOk();
      this.maskseen = true;
      this.alertseen = false;
      this.newseen = false;
      this.editseen = true;
    },
    checkOk: function() {
      //判断是否有画廊封面
      if (this.isok == false) {
        return false;
      }
      if (this.isSetCover == false) {
        this.maskseen = true;
        this.newseen = false;
        this.editseen = false;
        this.alertseen = true;
        return false;
      }
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
  }
});