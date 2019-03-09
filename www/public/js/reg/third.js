var MyComponent = Vue.extend(VueCoreImageUpload);

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
    console.log(bb);
    this.setSelect([0, 0, bWidth, bHeight]);


    var ss = this.getWidgetSize();
    var aheight = (300 - Number(ss[1])) / 2 + "px";
    $(".jcrop-holder").css("margin-top", aheight);
    console.log(bWidth);
    console.log(bHeight);


  });
}

function updateCoords(c) {
  console.log(c);
  var img = document.getElementById("cropbox");
  var ctx = document.getElementById("myCan").getContext("2d");

  //img,开始剪切的x,Y坐标宽高，放置图像的x,y坐标宽高。  
  ctx.drawImage(img, c.x, c.y, c.w, c.h, 0, 0, 200, 200);
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


var vmApp = new Vue({
  el: '#app',
  data: {
    num: '4',
    formData: {
      nickname: '',
      gender: '1',
      face: ''
    },
    errorTips: {
      nickname: '',
      gender: '',
      face: ''
    },
    boxIsShow: false,
    uploadIsShow: false,
    btnText: '完成',
    uploadText: '确认上传',
    uploadClick: false,
    isSubmit: false
  },
  mounted: function() {

  },
  methods: {

    submitForm: function() {
      var that = this;
      this.formData.nickname = trimStr(this.formData.nickname);
      if (this.formData.nickname == '' || this.formData.face == '') {
        if (this.formData.nickname == '') {
          this.errorTips.nickname = "请输入您的昵称";
        } else if (this.formData.face == '') {
          this.errorTips.face = "请上传您的高清个性照";
        }
        setTimeout(function() {
          that.errorTip = '';
          that.errorTips = {
            nickname: '',
            gender: '',
            face: ''
          };
        }, 2000);
        return false;
      }


      //避免重复点击提交
      if (this.isSubmit) {
        return false;
      }


      this.isSubmit = true;
      this.btnText = "提交中...";

      artzheAgent.call('UserCenter/saveUserInfo', this.formData, function(res) {
        that.isSubmit = false;
        console.log(res);
        if (res.code == 30000) {
          that.btnText = "跳转中...";
          setTimeout(function() {
            window.location.href = '/';
          }, 1000);
        }
      });

    },
    imageuploaded: function(res) {
      console.log(res);
      // if (res.errcode == 0) {
      //   this.src = '';
      // }
    },
    showUpload: function() {
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
        console.log(imgSrc);
        this.uploadText = "上传中...";
        //避免重复点击提交
        if (this.uploadClick) {
          return false;
        }
        this.uploadClick = true;
        var fd = new FormData();
        fd.append('file', imgSrc);
        $.ajax({
          url: "/public/upload",
          data: fd,
          type: 'POST',
          dataType: 'json',
          asyn: false,
          processData: false, // 告诉jQuery不要去处理发送的数据
          contentType: false, // 告诉jQuery不要去设置Content-Type请求头
          success: function(res) {
            that.uploadClick = false;
            if (res.success) {
              that.$message({
                message: '上传成功'
              });
              that.uploadText = "上传成功";
              that.formData.face = ResHeader + res.path;
              that.hideBox();
            }
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

    }
  },
  components: {
    'vue-core-image-upload': MyComponent
  },
});