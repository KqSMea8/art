var editorText = '<p style="color: rgb(153, 153, 153);">从这里开始写正文</p>';
var ue = UE.getEditor('editor', {
  toolbars: [
    ['undo', 'redo', '|', 'fontsize', '|', 'blockquote', 'horizontal', '|', 'removeformat', 'formatmatch', 'link'],
    ['bold', 'italic', 'underline', 'forecolor', 'backcolor', '|', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight', '|', 'insertorderedlist', 'insertunorderedlist', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', 'insertimage']
  ],
  // initialFrameWidth:714,
  // initialFrameHeight:600,
  // autoHeightEnabled:false,
  enableContextMenu: false,
  elementPathEnabled: false,
  wordCount: false,
  enableAutoSave: true,
  imagePopup:false,
  // autoFloatEnabled:false,
  allowDivTransToP:false,
  filterRules: function () {
    return{
      span:{$: {'style':1,'class':1}},
      p: {$: {'style':1,'contenteditable':1,'class':1}},
      div: {$: {'style':1, 'class':1, 'id':1, 'contenteditable':1}},
      //$:{}表示不保留任何属性
      br: {$: {}},
      a:{$: {'style':1, 'href':1, 'target':1, 'contenteditable':1, 'class':1, 'data-artzhe-typeDetail':1, 'data-artzhe-id':1, 'data-artzhe-params':1, 'data-artzhe-type':1}},
      ol:{$: {'style':1}},
      ul: {$: {'style':1}},
      img: {$: {'style':1, 'src':1,'class':1, 'contenteditable':1}},
      dl:{$: {'style':1}},
      dt:{$: {'style':1}},
      dd:{$: {'style':1}},
      li:{$: {'style':1}},
      blockquote: {$: {'style':1}},
      quote: {$: {'style':1}},
      video: {$: {'src':1, 'poster':1, 'controls':1, 'preload':1}},
      audio: {$: {'src':1, 'autoplay':1, 'controls':1, 'loop':1,'preload':1,'style':1,'class':1}},
      source: {$: {'type':1, 'src':1}},
      article: {$: {'style':1}},
      section:{ $: {'style':1, 'class':1, 'contenteditable':1,'id':1}},
      table: function (node) {
          UE.utils.each(node.getNodesByTagName('table'), function (t) {
              UE.utils.each(t.getNodesByTagName('tr'), function (tr) {
                  var p = UE.uNode.createElement('p'), child, html = [];
                  while (child = tr.firstChild()) {
                      html.push(child.innerHTML());
                      tr.removeChild(child);
                  }
                  p.innerHTML(html.join('&nbsp;&nbsp;'));
                  t.parentNode.insertBefore(p, t);
              })
              t.parentNode.removeChild(t)
          });
          var val = node.getAttr('width');
          node.setAttr();
          if (val) {
              node.setAttr('width', val);
          }
      },
      tbody: {$: {}},
      caption: {$: {}},
      th: {$: {}},
      td: {$: {valign: 1, align: 1,rowspan:1,colspan:1,width:1,height:1}},
      tr: {$: {}},
      h1: {$: {'style':1}},
      h2: {$: {'style':1}},
      h3: {$: {'style':1}},
      h4: {$: {'contenteditable':1, 'style':1, 'class':1}},
      h5: {$: {'style':1, 'class':1, 'contenteditable':1}},
      h6: {$: {'style':1}},
      strong: {$: {'style':1,'class':1}},
      i: {$: {'style':1}},
      b: {$: {'style':1}},
      //黑名单，以下标签及其子节点都会被过滤掉
      '-': 'script style meta iframe embed object'
    }
  }()
});

UE.Editor.prototype.placeholder = function(justPlainText) {
  var _editor = this;
  _editor.addListener("focus", function() {
    var localHtml = _editor.getContent();
    if ($.trim(localHtml) === $.trim(justPlainText)) {
      _editor.setContent("<p><br></p>");
    }
  });
};


// document.getElementById('j_upload_video_btn').onclick = function () {
//   // ue.execCommand('插入视频');
//   $("#file-video").click();
// };

var vmEdit = new Vue({
  el: '#edit',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    isAgree: true,
    updateLists: [
      // {
      //     "id": "1", //文章id
      //     "create_date": "2017-5-30", //创建日期
      //     "excerpt": "hhjjjjj", //摘要
      //     "img": [
      //       "https://wx.qlogo.cn/mmopen/8oFuSj5ibibOPO093x2j1Z5IeCT9HDFuImzlJNbJia075lJvxElpKE6xhEuHZMvkyMlfr7UvFpo1SiaLeTajsyHybrh27F9nfnYF/0?x-oss-process=image/resize,m_fixed,h_180,w_180" //记录里面的图片
      //     ],
      //     "type": 1 //1:正式文章，2：草稿
      //   }
    ], //文章更新状态列表
    proname: '', //文章名称
    ruleForm: { //规则验证字段
      cover: '',
      date: formatDate(new Date())
    },
    rules: { //字段验证规则
      cover: [{
        required: true,
        message: '封面图需上传',
        trigger: 'change'
      }]
    },
    articleID: '', //文章id
    editTitle: '', //文章标题
    type: '', //1:正式文章，2：草稿
    isTitleTip: false, //标题提示
    maskseen: false, //预览显示开关
    alertseen: false, //弹出框提示开关
    desc: '', //画作介绍
    curli: 'Add' + getCookie('userid'), //当前选中的li
    titleDisable: false, //标题是否可修改
    storageTag: false, //是否可保存标志
    loading: true, //加载动画是否显示
    uploadloading: false,
    ossAction: ossInfo.action,
    uploadData: {},
    updateTime: '0', //当前是第几次更新(阿拉伯)
    isAddRecord: false, //是否提交添加创作纪录开关
    articleNum: {
      draft: '',
      publish: ''
    },
    isGetNum: false, //有没有获取到数量
    alertList: [{
        text: '你今天已发了50篇文章了，<br>累了吧，明天继续再来发文吧~'
      },
      {
        text: '你的草稿已超过100篇了，<br>累了吧，明天继续再来发文吧~'
      }
    ],
    alertInfo: {
      text: ''
    },
    contentTarget: [], //内容标签
    selectdTarget: [], //内容标签选中的项
    selectflag: true, //内容标签不可选
    hangupval: '', // 显示的发布时间
    futuretimeLines: {
      disabledDate(time) {
        return time.getTime() < Date.now() - 8.64e7;
      }
    },
    hangupvalAfter: '',//转换的发布时间
  },
  computed: {
    addDate: function() { //新增单次更新创作日期显示
      var that = this;
      if (that.ruleForm.date) {
        return formatDate(that.ruleForm.date);
      }
      return formatDate(new Date());
    },
    bg: function() { //新增单次更新背景显示
      var that = this;
      if (this.curli == 'Add' + that.myInfo.uid) {
        if (that.ruleForm.cover) {
          return 'background-image:url("' + that.ruleForm.cover + '")';
        } else {
          return '';
        }
      } else {
        return '';
      }
    },
  },
  created: function() {
    var that = this;
    //编辑器ready
    ue.ready(function() {
      //因为Laravel有防csrf防伪造攻击的处理所以加上此行
      var _token = $('meta[name="csrf-token"]').attr('content');
      ue.execCommand('serverparam', '_token', _token);
      ue.setContent(editorText);
      oft = 81,
      ofl = 6;
      $('#editor-title').insertAfter('.edui-editor-toolbarbox');
      $('#editor-title').css({
        'top': oft,
        'left': ofl
      }).show();
      $(window).resize(function() {
        oft = $('#editor').offset().top + 81,
          ofl = $('#editor').offset().left + 8;
        $('#editor-title').css({
          'top': oft,
          'left': ofl
        }).show();
      });
      $('#editor-title input').on('input', function() {
          // var len = getByteLen($(this).val());
          var len = $(this).val().length;
          if (len > 64) {
            that.isTitleTip = true;
          } else {
            that.isTitleTip = false;
          }
          $('#editor-Titcount').text(len + '/64');
        });
        //焦点获取处理
      ue.placeholder(editorText);

      that.articleID = GetRequest().id ? GetRequest().id : ''; //地址栏中获取文章id

      //获取今天发布文章数量
      artzheAgent.call22('Article/getTodayArticle', {}, function(response) {
        if (response.code == 30000 && response.data.status == 1000) {
          var resInfo = response.data.article;
          that.isGetNum = true;
          that.articleNum = resInfo;
        } else {
          that.$message.error(response.code + ' : ' + response.message);
        }
      });

      //获取文章状态更新列表(放这里要在加载编辑器后调用editPro导致报错的问题)
      if (!that.articleID) {
        // window.localStorage.clear();
        that.loading = false;
      }

      if (that.articleID) {
        that.ruleForm.date = new Date();
        // window.localStorage.clear();
        // Artwork/getAttributePercent
        artzheAgent.callMP('article/getmyarticle', {
          "id": that.articleID
        }, function(response) {

          if (response.code == 30000 && response.data.status == 1000) {
            var resInfo = response.data.info;
            that.editTitle = resInfo.title;
            that.proname = resInfo.title;
            if(response.data.info.tag.length>0){
              that.selectdTarget = resInfo.tag; //获取草稿内的内容标签
            }

            // var len = getByteLen(that.editTitle);
            var len = that.editTitle.length;
            $('#editor-Titcount').text(len + '/64');
            if (len) {
              that.titleDisable = false;
            }
            that.ruleForm.date = resInfo.last_update_time ? new Date(resInfo.last_update_time): new Date();
            that.desc = resInfo.excerpt;
            that.type = resInfo.type;
            that.ruleForm.cover = resInfo.cover;
            // that.hangupval = new Date(resInfo.publish_time);
            that.hangupvalAfter = resInfo.publish_time;
            that.hangupval = new Date(resInfo.publish_time.replace(/-/g, "/")); //兼容MAC safari 最好时间格式设置为2018/10/02 08:30
            ue.setContent(resInfo.content);
            that.loading = false;
          } else {
            that.$message.error(response.code + ' : ' + response.message);
          }
        });
      }

    });
    // timer = setInterval(function() { //自动保存当前编辑状态
    //   if (that.curli == 'Add' + that.myInfo.uid && $.trim(ue.getContent()) != '' && $.trim(ue.getContent()) != editorText) {
    //     that.storageTag = true;
    //   }
    //   if (that.storageTag) { //判断是否切换状态，避免缓存错误
    //     that.saveForm();
    //   }
    // }, 5000)
    this.getcontentTarget();
  },
  mounted: function() {
    //-- 禁止输入时间
    // var arr = document.querySelectorAll('.el-input__inner');
    // for(i in arr.length){
    // 	arr[i].setAttribute('readOnly',false)
    // };
    //----
    new StickUpAll('#right-nav');
    this.$nextTick(function(){
      this.selectflag = false;
    })

  },
  methods: {
    saveForm: function(formName) {
      var that = this;
      if ($.trim(ue.getContent()) == '' || $.trim(ue.getContent()) == editorText) {
        return false;
      }else if (that.selectdTarget.length==0) {
        that.$message({
          message: '内容标签不能为空哦',
          type: 'error'
        });
        return false;
      }
    },
    maskSeen: function() { //预览点击事件
      var that = this;
      if (!this.editTitle) {
        that.$message({
          message: '为你的文章取个名字'
        });
        return false;
      } else if ($.trim(ue.getContent()) === editorText || $.trim(ue.getContentTxt()) == '') {
        that.$message({
          message: '请添加您的文章内容~'
        });
        return false;
      }else if (that.selectdTarget.length==0) {
        that.$message({
          message: '内容标签不能为空哦',
          type: 'error'
        });
        return false;
      }

      // if (that.ruleForm.cover == '' || that.ruleForm.cover.indexOf('undefined') > -1) {
      //   that.$message({
      //     message: '封面图需上传'
      //   });
      //   return false;
      // }

      if (that.uploadloading) {
        that.$message({
          message: '图片上传中！'
        });
        return false;
      }
      // if ($.trim(that.desc.length) == 0) {
      //   that.$message({
      //     message: '请输入文章摘要'
      //   });
      //   return false;
      // }

      that.maskseen = true;
      that.alertseen = false;
      that.saveForm();
      //iframe显示
      var frame = $("#previewCreative_iframe")[0].contentWindow;
      frame.$("#iframe-name").html(that.editTitle);
      frame.$("#iframe-date").html(formatDate(that.ruleForm.date));
      frame.$("#iframe-date2").html(formatDate(that.ruleForm.date));
      // frame.$("#wrap").html(px2rem(ue.getContent()));
      // var reg = new RegExp("<p><br/></p>","gi");
      frame.$("#wrap").html(ue.getContent());

      frame.$("#artist-name").html('' + that.myInfo.name);
    },
    closemaskSeen: function() { //关闭预览蒙层
      this.maskseen = false;
      this.alertseen = false;
    },
    alertSeen: function() { //弹框显示
      this.alertseen = true;
    },
    beforeAvatarUpload: function(file) {
      var type = file.type.toUpperCase();
      if (type !== 'IMAGE/JPEG' && type !== 'IMAGE/PNG' && type !== 'IMAGE/JPG' && type !== 'IMAGE/BMP' && type !== 'IMAGE/GIF') {
        this.$message({
          message: '请上传图片'
        });
        return false;
      }
      this.uploadloading = true;
    },
    uploadAvatar: function(options) {
      var that = this;
      var reData = ossObj.set_upload_param(options.file.name);
      options.data = reData;
      options.file.url = options.action + '/' + options.data.key;
      // 检查是否支持FormData　
      if (window.FormData) {　　　　　
        var formData = new FormData();　　　　 // 建立一个upload表单项，值为上传的文件
        for (var i in options.data) {
          formData.append(i, options.data[i]);
        }　　　　
        formData.append('file', options.file);
        console.log(formData);　　　　
        var xhr = new XMLHttpRequest();　
        xhr.open('POST', options.action);　　　　 // 定义上传完成后的回调函数　　　
        xhr.onload = function() {　　　　　　
          if (xhr.status === 200) {　　　　　　　　
            that.success(options.file);
          } else {　　　　　　　　
            that.$message({
              message: '上传失败'
            });　　　　　　
          }　　　　
        };　　　　
        xhr.send(formData);　　
      }
    },
    success: function(file) {
      // body...
      this.$message({
        message: '封面图片上传成功！',
        type: 'success'
      });
      this.ruleForm.cover = file.url;
      this.uploadloading = false;
    },
    handleAvatarSuccess: function(res, file) {
      if (res.success) {
        this.$message({
          message: '封面图片上传成功！',
          type: 'success'
        });
        this.ruleForm.cover = ResHeader + res.path;
        // this.ruleForm.cover =  URL.createObjectURL(file.raw);
        this.$refs.ruleForm.validateField('cover');
        // this.isOK = true;
      } else {
        this.$message({
          message: '上传失败'
        });
      }
      this.uploadloading = false;
    },
    updatePro: function() { //上传文章
      if (this.checkNum('publish')) {
        this.alertInfo = this.alertList[0];
        this.alertSeen();
        return false;
      }
      var that = this;
      // var st = Storage.get('article' + that.curli);
      // var dateformat = formatDate(st.date);

      var obj = {
        'title': that.editTitle,
        'excerpt': that.desc,
        'content': ue.getContent(),
        'cover': that.ruleForm.cover,
        'type': 1, //1:正式文章，2：草稿
        'tag': that.selectdTarget.toString(), //内容标签
        'publish_time': that.hangupvalAfter,
      };

      if (that.articleID) {
        obj.id = that.articleID;
      }

      if (that.isAgree) {
        obj.Share2ArtCircle = 1;
      } else {
        obj.Share2ArtCircle = 0;
      }

      // if (obj.cover.indexOf('undefined') > -1) {
      //   that.$message({
      //     message: '封面图需上传'
      //   });
      //   return false;
      // }
      if (that.isAddRecord == true) {
        return false;
      }
      that.isAddRecord = true;
      artzheAgent.callMP('article/save', obj, function(response) {
        that.isAddRecord = false;
        that.maskseen = false;
        that.alertseen = false;
        if (response.data.status == 1000 && response.code == 30000) {
          that.$message({
            message: '发布成功！',
            type: 'success'
          });
          window.location.href = '/article/manage';
        } else {
          that.$message(response.code + ' : ' + response.message);
        }
      }, function(res) {
        that.isAddRecord = false;
      });
    },
    saveDraft: function() { //保存草稿
      if (this.checkNum('draft')) {
        this.alertInfo = this.alertList[1];
        this.alertSeen();
        return false;
      }
      var that = this;
      if (!this.editTitle) {
        that.$message({
          message: '为你的文章取个名字'
        });
        return false;
      }
      if ($.trim(ue.getContent()) === editorText || $.trim(ue.getContentTxt()) == '') {
        that.$message({
          message: '请添加您的文章内容~'
        });
        return false;
      }
      if (that.uploadloading) {
        that.$message({
          message: '图片上传中！'
        });
        return false;
      }
      if (that.selectdTarget.length==0) {
        that.$message({
          message: '内容标签不能为空哦',
          type: 'error'
        });
        return false;
      }
      that.saveForm();

      var obj = {
        'title': that.editTitle,
        'excerpt': that.desc,
        'content': ue.getContent(),
        'cover': that.ruleForm.cover,
        'type': 2, //1:正式文章，2：草稿
        'tag': that.selectdTarget.toString(),  //内容标签

      };

      if (that.articleID) {
        obj.id = that.articleID;
      }

      if (that.isAddRecord == true) {
        return false;
      }
      that.isAddRecord = true;
      artzheAgent.callMP('article/save', obj, function(response) {
        that.isAddRecord = false;
        that.maskseen = false;
        that.alertseen = false;
        if (response.data.status == 1000 && response.code == 30000) {
          if (response.data.id) {
            that.articleID = response.data.id;
          }
          that.$message({
            message: '保存成功！',
            type: 'success'
          });
        } else {
          that.$message(response.code + ' : ' + response.message);
        }
      }, function(res) {
        that.isAddRecord = false;
      });
    },
    agreeToggle: function () {
      this.isAgree = !this.isAgree;
    },
    checkNum: function (type) {
      if (type == 'draft') {
        if (this.articleNum.draft >= 100) { //今天发布草稿数量100
          return true;
        } else {
          return false;
        }
      } else if (type == 'publish') {
        if (this.articleNum.publish >= 50) { //今天发布文章数量50
          return true;
        } else {
          return false;
        }
      }
    },
    getcontentTarget:function(){
      var self = this;
      var obj = {};
      artzheAgent.callMP('Article/getTags', obj, function(response){
        if (response.code == 30000 && response.data.status == 1000) {
          self.contentTarget = response.data.info.tag;
        }
      })
    },
    checknull:function(){
      if(this.selectdTarget.length==0){
        that.$message({
          message: '内容标签不能为空',
          type: 'error'
        });
      }
    },
    gethangupval:function(t){ //获取发布时间函数
      /****
       *
       * 
       * 时间格式在 MAC的safari浏览器中会出现问题
       * 
       * 如 2018-10-10 15：30 在windows上是不会出问题的，但在Mac的safari中会报错 'invalid date'(格式错误)；
       * 
       * 如 2018-10-10 在win Safari5及以下版本中会显示NAN,Mac上Safari7以上则没有此问题。
       * 
       * 解决办法：
       * 博客地址 https://blog.csdn.net/biany2/article/details/50464242?locationNum=12
       * 
       */

      console.log(t)
      console.log(this.hangupvalAfter)
      
      var nowtime = new Date().getTime();
      var selecttime = new Date(t).getTime();
      var ua = navigator.userAgent.toLowerCase();
      if (/safari/.test(ua)) {
        var offhand = t.replace(/-/g, "/");
        selecttime = new Date(offhand).getTime();
      }
      console.log(selecttime)
      if((nowtime+300000)<selecttime){ //大于5分钟
        this.hangupvalAfter = t;
      }else{
        this.hangupvalAfter = '';
      }
    }
  }
});
