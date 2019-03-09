var vmAuth = new Vue({
  el: '#app',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    prodItems: [{
      // "id":"1212",//艺术品id
      // "name":"艺术品名称",
    }], //作品列表
    form1: { //规则字段
      artworkId: '' //作品id
    },
    rules1: { //字段规则
      artworkId: [{
        required: true,
        message: '请选择你要添加纪录的作品',
        trigger: 'change'
      }]
    }
  },
  created: function() {
    var that = this;
    //获取产品列表
    artzheAgent.call2('Artwork/getArtWorkListByAuthor', {}, function(response) {
      if (response.code == 30000 && response.data.status == 1000) {
        that.prodItems = response.data.info.list;
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
          window.location.href = '/upload/record' + '?id=' + that.form1.artworkId;
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
  }
});
