var vmarter=new Vue({
    el : '#atrerorg',
    data: {
        myInfo : {
            uid: getCookie('userid'),
            name: getCookie('userName'),
            face: getCookie('userFace')
        },
        tableData : [], // 表格数据
        haveArterNum: 0, //我的艺术家总数
        addArtDialog: false, //新艺术家弹窗
        openUploadImg: false, //上传头像
        addArter:[{}], //添加新艺术家信息
        addgendersel : [
            {
                value:'3',
                label:'请选择',
                disabled: true
            },
            {
                value: '1',
                label: '男'
            },
            {
                value: '2',
                label : '女'
            }
        ],
        uploadloading: false, //上传load
        uploadText: '确认上传',
        imgorbtn:false, //hover图片时显示更换头像提示
        newArtI: {
            'mobile': '',
            'face':'https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png',
            'nickname': '',
            'gender': '',
            'password':''
        },
        loading: false,
        // floading:false,
        prodCount: 0,
        curpage : 1, //当前页
        totalpage : '', //总页数
        inputpage : '', //输入页码
    },
    created:function() {
      this.getArtList(); // 初始化数据
    },
    mounted:function() {

    },
    methods:{
        gouTuArter : function (arterId,status) { //登陆当前艺术家（arterId）的账号
            this.$message({
                type:'info',
                message:'拼命切换中'
            })
            // this.floading = true;
            var that = this;
            var jgobj={
                artist_user_id : arterId
            }
            artzheAgent.callMP('Agency/ChangeLoginToArtist', jgobj, function (res) {
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
                            var userType=-1;
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
                            // setCookie('temporaryLogin',1); //切换登录用户
                            //
                            // _setCookie('userid', res.data.info.artist);
                            // _setCookie('userName', res.data.info.name);
                            // _setCookie('userFace', res.data.info.faceUrl);
                            // _setCookie('userMobile', res.data.info.mobile);
                            // _setCookie('userType', userType);
                            _setCookie('temporaryLogin', 1); //切换登录用户
                            var lk = window.location.hostname.split('-')[0];
                            lk = lk=='harry'||lk=='test'?lk +'-www.artzhe.com':'www.artzhe.com';
                            //window.location.href = lk+'/user/index?second'; //跳转到用户中心

                            if (status == 2){
                                //已通过，跳转到创作中心
                                //https://test-mp.artzhe.com/artorganization/test-www.artzhe.com/user/index?second
                                window.location.href = 'https://'+lk+'/user/index?second'; //跳转到用户中心
                                return false
                            } else if (status == 0 || status == -1){
                                //未提交审核、未通过，跳转到艺术家认证
                                window.location = '/auth/rule';
                            }else{
                                window.location = '/'; //跳转到首页
                            }
                        } else {
                            deleteCookie('userid');
                            deleteCookie('userName');
                            deleteCookie('userFace');
                            deleteCookie('userMobile');
                        }
                        // this.floading = false;
                    });

                }
            })
        },
        getArtList : function(){ //获取列表
            var that=this;
            var obj = {
                page: that.curpage,
                pagesize: 7
            };
            this.loading = true;
            artzheAgent.callMP('Agency/MyArtist ',obj,function(res){
                that.loading = false;
                if(res.code==30000){
                    var info = res.data.info;
                    that.tableData = info.artist; //艺术家列表
                    that.totalpage = info.maxpage; //总页数
                    that.haveArterNum = info.total; //已有艺术家数
                }
            })
        },
        addNewArter:function(){
            this.addArtDialog =true;
        },
        willAddArter:function(){ //点击确认添加的fn
            var that = this;
            var mreg = /\@/i; //@符号
            // var regEmail = /^([0-9A-Za-z]{1})+([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9_\-])+\.)+([a-zA-Z0-9]{2,4})+$/; //邮箱正则
            var regEmail = /^([0-9A-Za-z]{1})+([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9_\-])+\.)+([a-zA-Z0-9]{2,4})$/; //邮箱正则
            var mobileReg = /^1[3|4|5|7|8|9][0-9]\d{4,8}$/; //定义手机号正则表达式

            this.newArtI.mobile = trimStr(this.newArtI.mobile); //去除手机号首尾空格
            this.newArtI.nickname = trimStr(this.newArtI.nickname); //去除昵称首尾空格

            if(mreg.test(this.newArtI.mobile) == true){
              if(!regEmail.test(this.newArtI.mobile)){ //邮箱验证
                that.$message({
                  type:'error',
                  message:'邮箱错误！'
                })
                return
              }
            }else{
              if(!mobileReg.test(this.newArtI.mobile)){ //手机验证
                that.$message({
                  type:'error',
                  message:'手机号错误！'
                })
                return
              }
            }

            if (getByteLen(this.newArtI.nickname) > 16) { //控制昵称8位内
                this.$message({
                    type: 'error',
                    message: '昵称最长不超过8个汉字！'
                });
                this.newArtI.nickname = cutstr(this.newArtI.nickname, 16); //帮你切掉
                return
            }

            if (this.newArtI.gender == '' || this.newArtI.gender == 3){
                this.$message({
                    type:'error',
                    message:'请选择性别！'
                })
                return
            }

            var reg = /[\u4e00-\u9fa5]/gi; //中文
            this.newArtI.password = trimStr(this.newArtI.password); //去除首尾空格
            if (this.newArtI.password.length > 16 || this.newArtI.password.length <6) { //控制密码在6-16位
                this.$message({
                    type: 'error',
                    message: '密码长度为6-16位！'
                });
                this.newArtI.password = cutstr(this.newArtI.password, 16); //帮你切掉
                return
            } else if (reg.test(this.newArtI.password) == true || (/\s/g).test(this.newArtI.password) ==true){
                this.$message({
                    type: 'error',
                    message: '密码长不能含有空格、中文！'
                });
                return
            }

            var arterinfo = this.newArtI;
            artzheAgent.callMP('Agency/AddUser', arterinfo, function (res) { //上传成功后
                if (res.code == 30000) {
                    that.newArtI = { //重置
                        'mobile': '',
                        'face': 'https://artzhe.oss-cn-shenzhen.aliyuncs.com/common/avatar512.png',
                        'nickname': '',
                        'gender': '3',
                        'password': ''
                    }
                    // console.log(res)
                    // that.gouTuArter(res.data.artist_user_id)
                    that.addArtDialog = false;
                    that.getArtList(); //重新请求列表数据
                }else{
                    that.$message({
                        type:'error',
                        message : res.message
                    })
                }
            })
        },
        openupImg: function(){ //上传头像frame （弃用ing）
            // this.openUploadImg = true
            document.getElementById('uploadbox').style.display='block';
            $('#uploadifr').attr('src', '/public/ossH5uploadjsForm?to_tag=upface')
        },
        imgchange: function () { //上传头像 选择图片
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
            var reader = new FileReader();
            //将文件读取为DataURL
            reader.readAsDataURL(localimg);
            reader.onload = function (e) {
                var localimghtml = '<img id="cropbox" src="' + e.target.result + '" >';
                $("#imgfield").html(localimghtml);
                initJcrop();
            };

        },
        uploadImg: function () { //上传头像 确认上传
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
                fd.append('_token', $('#_token').val());
                $.ajax({
                    url: "/Public/upload",
                    data: fd,
                    type: 'POST',
                    dataType: 'json',
                    asyn: false,
                    processData: false, // 告诉jQuery不要去处理发送的数据
                    contentType: false, // 告诉jQuery不要去设置Content-Type请求头
                    success: function (res) {
                        // console.log(res);
                        that.uploadClick = false;
                        if (res.success == true) {
                            // that.$message({
                            //   message: '上传成功'
                            // });
                            that.uploadText = "上传";

                            // that.form[that.activeImg] = res.data.info.url;
                            // var activeImg = that.activeImg;
                            // var subData = {};
                            // subData[that.activeImg] = res.data.info.url;

                            console.log(res)
                            that.newArtI.face = res.path; //赋值给头像
                            that.openUploadImg = false;
                        } else {
                            that.$message({
                                message: '上传失败'
                            });
                            that.uploadText = "确认上传";
                        }
                    },
                    complete: function (res) {
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
        addArterClose: function () { //添加新艺术家弹窗
            this.addArtDialog = false;
        },
        pagePrev : function () {
            var that = this;
            if (this.curpage - 1 != 0) {
                this.loading = true;
                this.curpage--;
                this.getArtList();
            }
        },
        pageNext : function () {
            var that = this;
            if (this.curpage + 1 <= this.totalpage) {
                this.loading = true;
                this.curpage++;
                this.getArtList();
            }
        },
        gotopage : function () {
            var that = this;
            if (0 < this.inputpage && this.inputpage <= this.totalpage) {
                this.loading = true;
                this.curpage = this.inputpage;
                this.getArtList();
            }
        },
    }
})
function initJcrop() { //头像裁剪配置fn
    $('#cropbox').Jcrop({
        onSelect: updateCoords,
        aspectRatio: 1,
        boxWidth: 300,
        boxHeight: 300
    }, function () {

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

function updateCoords(c) { //头像裁剪fn
    // console.log(c);
    var img = document.getElementById("cropbox");
    var ctx = document.getElementById("myCan").getContext("2d");

    //img,开始剪切的x,Y坐标宽高，放置图像的x,y坐标宽高。
    // ctx.drawImage(img, c.x, c.y, c.w, c.h, 0, 0, 1000, 1000);
    ctx.drawImage(img, c.x, c.y, c.w, c.h, 0, 0, 400, 400);
}

function transDataUrl(dataurl) { //获取头像信息fn
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
