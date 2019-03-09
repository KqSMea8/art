var editorText = '<p style="color: rgb(153, 153, 153);">捕捉创作灵感，记录创作故事。可上传生活状态图，作品图（建议像素：1024*1024）</p>';
var ue = UE.getEditor('editor', {
  toolbars: [
    ['undo', 'redo', '|', 'fontsize', '|', 'blockquote', 'horizontal', '|', 'removeformat', 'formatmatch', 'link'],
    ['bold', 'italic', 'underline', 'forecolor', 'backcolor', '|', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight', '|', 'insertorderedlist', 'insertunorderedlist', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', 'insertimage']
  ],
  // initialFrameHeight:600,
  // initialFrameWidth:800,
  // autoHeightEnabled:false,
  enableContextMenu: false,
  elementPathEnabled: false,
  wordCount: false,
  enableAutoSave: true,
  imagePopup:true,
  // autoFloatEnabled:false,
  allowDivTransToP:false,
  filterRules: function () {
    function transP(node){
      node.tagName = 'p';
      node.setStyle();
    }
    return{
      span:{$: {'style':1,'class':1}},
      p: {$: {'style':1,'contenteditable':1,'class':1}},
      div: {$: {'style':1,'class':1}},
      //$:{}表示不保留任何属性
      br: {$: {}},
      // a:{$: {'style':1, 'href':1}},
      a:transP,
      ol:{$: {'style':1}},
      ul: {$: {'style':1}},
      img: {$: {'style':1, 'src':1}},
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
      h4: {$: {'style':1}},
      h5: {$: {'style':1}},
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
  // _editor.addListener("blur", function () {
  //   var localHtml = _editor.getContent();
  //   if (!localHtml) {
  //     .setContent(ju_editorstPlainText);
  //   }
  // });
  // _editor.ready(function () {
  //   _editor.fireEvent("blur");
  // });
};
// var regAtxt = /(<\/?a[^>]*>)/gi; //与audio标签冲突，换掉
var regAtxt = /<a[^>]+?href=["']?([^"']+)["']?[^>]*>([^<]+)<\/a>/gi;
var regAlink = new RegExp(regAtxt);

var vmEdit = new Vue({
  el: '#edit',
  data: function(){
    var checkDesc =function(rule, value, callback){
      if(value.length>500){
        return callback(new Error('长度不大于 500 个字符'));
      }else{
        callback()
      }
    };
    return {
      myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },
    pickerOptions1: {
      disabledDate: function(time) {
        return time.getTime() > Date.now();
      }
    },
    isAgree : true,
    updateLists: [
      // {
      //     "id": "1", //草稿箱ID
      //     "create_date": "2017-5-30", //创建日期
      //     "number": "2", //记录编号
      //     "summary": "hhjjjjj", //摘要
      //     "isEdit": "Y", //是否可编辑 N不可编辑 Y可编辑
      //     "img": [
      //       "http://wx.qlogo.cn/mmopen/8oFuSj5ibibOPO093x2j1Z5IeCT9HDFuImzlJNbJia075lJvxElpKE6xhEuHZMvkyMlfr7UvFpo1SiaLeTajsyHybrh27F9nfnYF/0?x-oss-process=image/resize,m_fixed,h_180,w_180" //记录里面的图片
      //     ],
      //     "flag": 1 //1.草稿箱 2.更新记录里面的创作记录
      //   },
      //   {
      //     "id": "66", //创作记录更新ID
      //     "create_date": "2017-5-20", //创建日期
      //     "number": "1", //记录编号
      //     "summary": "dfgdlgjdfljgldfjglfdjgmnmsdfldsgldjflgjdflgsgdfdgfdgdd", //摘要
      //     "isEdit": "N", //是否可编辑 N不可编辑 Y可编辑
      //     "img": [
      //       "http://wx.qlogo.cn/mmopen/8oFuSj5ibibOPO093x2j1Z5IeCT9HDFuImzlJNbJia075lJvxElpKE6xhEuHZMvkyMlfr7UvFpo1SiaLeTajsyHybrh27F9nfnYF/0?x-oss-process=image/resize,m_fixed,h_180,w_180" //记录里面的图片
      //     ],
      //     "flag": 2 //1.草稿箱 2.更新记录里面的创作记录
      //   }
    ], //作品更新状态列表
    proname: '', //作品名称
    ruleForm: { //规则验证字段
      date: new Date(),
      cover: '',
      // class:'',
      tagValue: [],
    },
    coverShow: true, //是否显示封面图
    rules: { //字段验证规则
      date: [{
        type: 'date',
        required: true,
        message: '请填写创作时间',
        trigger: 'blur'
      }],
      cover: [{
        required: false,
        message: '封面图需上传',
        trigger: 'change'
      }],
      // class: [{
      //   type: 'number',
      //   required: true,
      //   message: '请填写画作类别',
      //   trigger: 'change'
      // }],
      tagValue: [{
        type: 'array',
        required: true,
        message: '请添加本次创作纪录的标签~',
        trigger: 'blur'
      }],
      desc:[
        { validator: checkDesc, trigger: 'blur' }
      ]
    },
    artID: '', //艺术品id
    updateid: '', //当前更新id
    editTitle: '', //作品标题
    isTitleTip: false, //标题提示
    classOptions: [], //画作类别选项
    maskseen: false, //预览显示开关
    alertseen: false, //弹出框提示开关
    tagOptions: [
      {
        "id": 1,
        "sort": 1,
        "value": "人物"
      }, {
        "id": 2,
        "sort": 2,
        "value": "风景"
      }, {
        "id": 3,
        "sort": 3,
        "value": "静物"
      }, {
        "id": 4,
        "sort": 4,
        "value": "动植物"
      }, {
        "id": 5,
        "sort": 5,
        "value": "萌化"
      }, {
        "id": 6,
        "sort": 6,
        "value": "宗教"
      }, {
        "id": 7,
        "sort": 7,
        "value": "具象"
      }, {
        "id": 8,
        "sort": 8,
        "value": "抽象"
      }, {
        "id": 9,
        "sort": 9,
        "value": "古典"
      }, {
        "id": 10,
        "sort": 10,
        "value": "观念"
      }, {
        "id": 11,
        "sort": 11,
        "value": "表现"
      }, {
        "id": 12,
        "sort": 12,
        "value": "少女"
      }, {
        "id": 13,
        "sort": 13,
        "value": "儿童"
      }, {
        "id": 14,
        "sort": 14,
        "value": "戏曲戏剧"
      }, {
        "id": 15,
        "sort": 15,
        "value": "写实"
      }, {
        "id": 16,
        "sort": 16,
        "value": "抽象"
      }, {
        "id": 17,
        "sort": 17,
        "value": "科幻"
      }, {
        "id": 18,
        "sort": 18,
        "value": "动漫风"
      }, {
        "id": 19,
        "sort": 19,
        "value": "人体"
      }, {
        "id": 20,
        "sort": 20,
        "value": "花鸟"
      }
    ], //画作标签
    desc: '', //画作介绍
    curli: 'Add' + getCookie('userid'), //当前选中的li
    isFinished: '', //作品是否完成标志
    titleDisable: false, //标题是否可修改
    storageTag: false, //是否可保存标志
    loading: true, //加载动画是否显示
    isClick: false, //防止点击后获取的内容不对应
    uploadloading: false,
    curFlag: '3', //1代表草稿，2代表单次更新，3代表新增
    hasDraft: false, //该作品是否有草稿
    ossAction: ossInfo.action,
    uploadData: {},
    updateTime: '0', //当前是第几次更新(阿拉伯)
    isAddRecord: false //是否提交添加创作纪录开关
      // isOK:true
    }
  },
  computed: {
    addDate: function() { //新增单次更新创作日期显示
      var that = this;
      if (that.curli == 'Add' + that.myInfo.uid) {
        if (that.ruleForm.date) {
          return formatDate(that.ruleForm.date)
        }
      } else if (Storage.get('editorAdd' + that.myInfo.uid)) {
        return formatDate(Storage.get('editorAdd' + that.myInfo.uid).date);
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
      } else if (Storage.get('editorAdd' + that.myInfo.uid) && Storage.get('editorAdd' + that.myInfo.uid).cover != '') {
        return 'background-image:url("' + Storage.get('editorAdd' + that.myInfo.uid).cover + '")';
      } else {
        return '';
      }
    },
    // newTitle:function(){//新增单次更新标题显示
    //   var that = this;
    //   if(this.curli == 'Add'+that.myInfo.uid){
    //       return this.editTitle;
    //     }else if(Storage.get('editorAdd'+ that.myInfo.uid)){
    //         return  Storage.get('editorAdd'+ that.myInfo.uid).title;
    //     } else{
    //       return '';
    //     }
    // }
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
          if (len > 20) {
            that.isTitleTip = true;
          } else {
            that.isTitleTip = false;
          }
          $('#editor-Titcount').text(len + '/20');
        });
        //焦点获取处理
      ue.placeholder(editorText);

      that.artID = GetRequest('id').id; //地址栏中获取艺术品id

      that.itemID = GetRequest().itemID; //单次更新id或草稿id
      that.curFlag = GetRequest().flag; //itemID类型 1草稿 2单次更新

      //获取艺术品状态更新列表(放这里要在加载编辑器后调用editPro导致报错的问题)
      if (!that.artID) {
        window.localStorage.clear();
        that.loading = false;
      }

      if (that.artID) {
        that.ruleForm.date = Storage.get('updateDate') ? new Date(Storage.get('updateDate')) : new Date();
        window.localStorage.clear();
        Storage.set('artID', that.artID);
        // /Artwork/getAttributePercent
        artzheAgent.callMP('Artwork/getAttributePercent', {
          "artworkId": that.artID
        }, function(response) {
          if (response.code == 30000 && response.data.status == 1000) {
            // that.editTitle = response.data.info.name;
            that.proname = response.data.info.name;
            that.isFinished = response.data.info.is_finished;
            // var len = getByteLen(that.editTitle);
            var len = that.editTitle.length;
            $('#editor-Titcount').text(len + '/20');
            if (len) {
              // that.titleDisable = true;
            }
            artzheAgent.callMP('Artwork/getRecordList', {
              'artId': that.artID
            }, function(res2) {
              if (res2.code == 30000 && res2.data.status == 1000) {
                var updateLists = res2.data.info;
                console.log(updateLists)
                var title;
                that.updateTime = updateLists.length + 1;
                that.updateLists = updateLists;

                that.hasDraft = that.checkHasDraft(that.updateLists);
                if (that.itemID) { //如果url有更新id则加载更新id
                  that.curli = that.itemID;
                  for (var i = 0; i < updateLists.length; i++) {
                    if (updateLists[i].id == that.itemID) {
                      title = updateLists[i].title;
                      break;
                    }
                  }
                  that.editPro(that.curli, that.curFlag, title);
                } else {
                  if (that.isFinished === 'Y' || that.hasDraft) {
                    that.curli = that.updateLists[0].id;
                    that.curFlag = that.updateLists[0].flag;
                    title = that.updateLists[0].title;
                    that.editPro(that.curli, that.curFlag, title);
                  }
                }
                that.loading = false;
              } else if (res2.code == 30109) {
                window.location.href = '/';
              } else {
                that.$message.error(res2.code + ' : ' + res2.message);
              }
            });
          } else {
            that.$message.error(response.code + ' : ' + response.message);
          }
        });
      }
    });
    timer = setInterval(function() { //自动保存当前编辑状态
      if (that.curli == 'Add' + that.myInfo.uid && $.trim(ue.getContent()) != '' && $.trim(ue.getContent()) != editorText) {
        that.storageTag = true;
      }
      if (that.storageTag) { //判断是否切换状态，避免缓存错误
        that.saveForm();
      }
    }, 5000);
  },
  mounted: function() {
    new StickUpAll('#right-nav');
  },
  methods: {
    saveForm: function(formName) {
      var that = this;
      if ($.trim(ue.getContent()) == '' || $.trim(ue.getContent()) == editorText) {
        return false
      }
      var content = ue.getContent();
      content = content.replace(regAlink, "");

      if(that.desc.length>500){
        that.$message({
          type:'error',
          message: '摘要不超过500字'
        })
        return false
      }
      var storageResult = Storage.set('editor' + that.curli, {
        'artID': that.artID,
        'title': that.editTitle,
        'date': that.ruleForm.date,
        'tag': that.ruleForm.tagValue,
        'desc': that.desc,
        // 'coverShow':that.coverShow,
        'cover': that.ruleForm.cover,
        'wit': content
      });
    },
    maskSeen: function() { //预览点击事件
      var that = this;
      // if (!this.editTitle) {
      //   that.$message({
      //     message: '为你的花絮取个名字'
      //   });
      //   return false;
      // }
      if ($.trim(ue.getContent()) === editorText || $.trim(ue.getContentTxt()) == '') {
        that.$message({
          message: '请添加您的创作花絮内容~'
        });
        return false;
      }
      //  else if ($(ue.getContent()).find('img').length <= 0) {
      //   that.$message({
      //     message: '为了作品更丰富吸引人，作品图片一定不少于1张哦~'
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
      //     message: '请输入故事简介~'
      //   });
      //   return false;
      // }
      // if (that.desc.length < 20) {
      //   that.$message({
      //     message: '故事简介不能少于20字哦~'
      //   });
      //   return false;
      // }
      this.$refs.ruleForm.validate(function(valid) {
        if (valid) {
          // if(!that.isOK){return false;}
          that.maskseen = true;
          that.alertseen = false;
          that.saveForm();
          //iframe显示
          var frame = $("#previewCreative_iframe")[0].contentWindow;
          var editTitle = that.editTitle ? that.editTitle : checkMark(that.proname) + '花絮';

          frame.$("#iframe-name").html(editTitle);
          frame.$("#iframe-date").html(formatDate(that.ruleForm.date));
          frame.$("#iframe-date2").html(formatDate(that.ruleForm.date));
          frame.$("#wrap").html(px2rem(ue.getContent().replace(regAlink, "")));
          frame.$("#artist-name").html('' + that.myInfo.name)
        } else {
          that.$message({
            message: '请填写创作信息！'
          });
          return false;
        }
      });
    },
    closemaskSeen: function() { //关闭预览蒙层
      this.maskseen = false;
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

      //  var reData = ossObj.set_upload_param(file.name);
      //  return new Promise(function (resolve, reject) {//解决beforeUpload中修改data和action不会在请求中生效
      //   that.uploadData = reData;
      //   resolve(true)
      // })
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
    handleAvatarScucess: function(res, file) {
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
    editPro: function(updateid, flag, title) { //点击更新状态获取更新编辑内容
      //获取画作更新详情
      var that = this;
      var data = {};
      if (this.isClick) {
        return false;
      } //防止快速点击情况下获取内容不对应
      this.isClick = true;
      this.storageTag = false;
      this.curli = updateid;
      this.curFlag = flag;
      this.editTitle = title;

      var that = this;
      this.updateid = updateid;
      if (Storage.get('editor' + that.updateid)) { //如果有缓存就获取缓存 否则重新请求
        var osto = Storage.get('editor' + that.updateid);
        if (osto) {
          that.editTitle = osto.title;
          // var len = getByteLen(that.editTitle);
          var len = that.editTitle.length;
          $('#editor-Titcount').text(len + '/20');
          that.ruleForm.date = new Date(osto.date);
          // that.ruleForm.class= osto.class;
          that.ruleForm.tagValue = osto.tag;
          that.desc = osto.desc;
          // that.ruleForm.coverShow = osto.coverShow;
          that.ruleForm.cover = osto.cover;
          ue.setContent(osto.wit);
          that.storageTag = true;
          that.isClick = false;
        }
      } else { //重新请求
        if (flag == '1') { //草稿
          data = {
            "drafId": updateid
          };
        } else { //单次更新
          data = {
            "artworkUpdateId": updateid
          };
        }
        artzheAgent.callMP('Artwork/getEditRecordContent', data,
          function(response) {
            if (response.code == 30000 && response.data.status == 1000) {
              that.artID = response.data.info.artwork_id;
              that.editTitle = response.data.info.title;
              ue.setContent(response.data.info.wit);
              // var len = getByteLen(that.editTitle);
              var len = that.editTitle.length;
              $('#editor-Titcount').text(len + '/20');
              if (response.data.info.create_date) {
                that.ruleForm.date = new Date(response.data.info.create_date);
              } else {
                that.ruleForm.date = new Date();
              }

              // that.ruleForm.class= Number(response.data.info.category);
              that.ruleForm.tagValue = response.data.info.tag ? response.data.info.tag.split(',') : [];
              that.desc = response.data.info.summary;
              // that.coverShow = response.data.info.is_cover_show == "Y";
              that.ruleForm.cover = response.data.info.cover;

              //获取创作日期
              // that.ruleForm.date = new Date(response.data.info.create_date);
              that.storageTag = true;
              that.saveForm(); //请求后立刻存入缓存中，避免多次请求
              that.isClick = false;
            } else {
              that.$message.error(response.code + ' : ' + response.message);
            }
          },
          function() {
            that.isClick = false;
          }
        );
      }
    },
    updatePro: function() { //增加更新
      var that = this;
      if (this.curli === 'Add' + that.myInfo.uid) { //如果当前是新增，则增加更新
        var st = Storage.get('editor' + that.curli);
        var dateformat = formatDate(st.date);
        if(that.desc.length>500){
          that.$message({
            type:'error',
            message: '摘要不超过500字'
          })
          return false
        }
        var obj = {
          'title': that.editTitle,
          'artworkId': that.artID,
          'artworkTag': st.tag.join(','),
          'story': st.desc,
          'wit': ue.getContent().replace(regAlink, ""),
          'createDate': dateformat,
          'cover': st.cover,
        };
        if (GetRequest('id').id) { //单次更新需要加上产品id
          obj.artworkId = GetRequest('id').id;
        }
        if (obj.cover.indexOf('undefined') > -1) {
          that.$message({
            message: '上传失败'
          });
          return false;
        }
        if (that.isAddRecord == true) {
          return false;
        }
        that.isAddRecord = true;
        artzheAgent.callMP('Artwork/addCreateRecord', obj, function(response) {
          that.maskseen = false;
          that.alertseen = false;
          if (response.data.status == 1000 && response.code == 30000) {
            if (that.isAgree) { //同步到艺术圈
              var link, aLink, share_id, addDate;
              link = response.data.shareLink;
              aLink = link.split('/');
              share_id = aLink[aLink.length - 1];
              addDate = {
                share_id: share_id,
                share_type: 'artwork_update'
              };
              artzheAgent.callMP('ArtCircle/add', addDate, function (response2) {
                // body...
              });
            }
            that.$message({
              message: '更新成功！',
              type: 'success'
            });
            window.location.href = '/upload/record?id=' + that.artID;
            // artzheAgent.call('Artwork/getArtDetail',{"artID":GetRequest('id').id},function(response){
            //    that.updateLists = response.data.info.updateList;
            //    that.proname =   response.data.info.name
            // })
          } else {
            that.$message(response.code + ' : ' + response.message);
          }
        }, function (res) {
          that.isAddRecord = false;
        });
      } else { //有单次更新id则调取edit
        var st = Storage.get('editor' + that.curli);
        var dateformat = formatDate(st.date);
        if(that.desc.length>500){
          that.$message({
            type:'error',
            message: '摘要不超过500字'
          })
          return false
        }
        var obj = {
          'title': that.editTitle,
          'artworkTag': st.tag.join(','),
          'story': st.desc,
          'wit': ue.getContent().replace(regAlink, ""),
          'createDate': dateformat,
          'cover': st.cover,
        };

        if (that.curFlag == '1') {
          obj.draftId = Number(that.curli);
        } else if (that.curFlag == '2') {
          obj.artworkUpdateId = Number(that.curli);
        }
        artzheAgent.callMP('Artwork/saveUpdateRecord', obj, function(response) {
          that.maskseen = false;
          that.alertseen = false;
          if (response.data.status == 1000 && response.code == 30000) {
            if (that.isAgree) { //同步到艺术圈
              var link, aLink, share_id, addDate;
              link = response.data.shareLink;
              aLink = link.split('/');
              share_id = aLink[aLink.length - 1];
              addDate = {
                share_id: share_id,
                share_type: 'artwork_update'
              };
              artzheAgent.callMP('ArtCircle/add', addDate, function (response2) {
                // body...
              });
            }
            that.$message({
              message: '更新成功！',
              type: 'success'
            });
            clearInterval(timer);
            window.localStorage.clear();
            window.location.href = '/upload/record?id=' + that.artID;
            // artzheAgent.call('Artwork/getArtDetail',{"artID":GetRequest('id').id},function(response){
            //    that.updateLists = response.data.info.updateList;
            //    that.proname =   response.data.info.name
            // })
          } else {
            that.$message(response.code + ' : ' + response.message);
          }
        })
      }

    },
    saveDraft: function() { //保存草稿
      var that = this;
      if ($.trim(ue.getPlainTxt()) === editorText || $.trim(ue.getContentTxt()) == '') {
        that.$message({
          message: '请添加您的创作纪录内容~'
        });
        return false;
      }
      // else if($(ue.getContent()).find('img').length <= 0){
      //     that.$message({
      //         message:'为了作品更丰富吸引人，作品图片一定不少于1张哦~'
      //     });
      //     return false;
      // }
      if (that.uploadloading) {
        that.$message({
          message: '图片上传中！'
        });
        return false;
      }
      that.saveForm();
      //iframe显示
      var frame = $("#previewCreative_iframe")[0].contentWindow;
      var editTitle = that.editTitle ? that.editTitle : checkMark(that.proname) + '花絮';

      frame.$("#iframe-name").html(editTitle);
      frame.$("#iframe-date").html(formatDate(that.ruleForm.date));
      frame.$("#iframe-date2").html(formatDate(that.ruleForm.date));
      frame.$("#wrap").html(ue.getContent());
      frame.$("#artist-name").html('' + that.myInfo.name);


      var st = Storage.get('editor' + that.curli);
      var dateformat = formatDate(st.date);
      if(that.desc.length>500){
        that.$message({
          type:'error',
          message: '摘要不超过500字'
        })
        return false
      }
      var obj = {
        'title': that.editTitle,
        'artworkId': that.artID,
        'artworkTag': st.tag.join(','),
        'story': st.desc,
        'wit': ue.getContent().replace(regAlink, ""),
        'createDate': dateformat,
        'cover': st.cover
      };
      if (this.curli !== 'Add' + that.myInfo.uid) { //如果当前是新增，则增加草稿
        obj.drafId = Number(that.curli);
      }
      artzheAgent.callMP('Artwork/addArtworkToDraft', obj, function(response) {
        that.maskseen = false;
        that.alertseen = false;
        if (response.data.status == 1000 && response.code == 30000) {
          that.$message({
            message: '保存成功！',
            type: 'success'
          });
        } else {
          that.$message(response.code + ' : ' + response.message);
        }
      });

    },
    addPro: function() { //左侧列表第一个
      if (!this.storageTag) {
        return false;
      }
      var that = this;
      this.curFlag = '3';
      this.curli = 'Add' + that.myInfo.uid;
      var osto = Storage.get('editor' + that.curli);
      if (osto) {
        // that.editTitle =  osto.title;
        // var len = getByteLen(that.editTitle);
        var len = that.editTitle.length;
        $('#editor-Titcount').text(len + '/20');
        that.ruleForm.date = new Date(osto.date);
        // that.ruleForm.class= osto.class;
        that.ruleForm.tagValue = osto.tag;
        that.desc = osto.desc;
        // that.ruleForm.coverShow = osto.coverShow;
        that.ruleForm.cover = osto.cover;
        ue.setContent(osto.wit);
      } else {
        // that.editTitle =  '';
        // var len = getByteLen(that.editTitle);
        var len = that.editTitle.length;
        $('#editor-Titcount').text(len + '/20');
        that.ruleForm.date = new Date();
        // that.ruleForm.class= '';
        that.ruleForm.tagValue = [];
        that.desc = '';
        // that.ruleForm.coverShow = '';
        that.ruleForm.cover = '';
        ue.setContent(editorText);
      }
    },
    agreeToggle: function () {
      this.isAgree = !this.isAgree;
    },
    checkHasDraft: function(arr) {
      for (var i = 0; i < arr.length; i++) {
        if (arr[i].flag == 1) {
          return true;
          break;
        }
      }
    },
    checkdesc: function(){
      if(this.desc.length>500){
        this.$message({
          type:'error',
          message: '摘要不超过500字'
        })
      }
    },
    notspace: function(v){
      if(v.length==0) { return }
      var narr=[];
        for(var i in v){
          if(v[i].replace(/(^\s*)|(\s*$)/g, "")!=''){
            if(/^[A-Za-z0-9\u4e00-\u9fa5]+$/.test(v[i])){
              if (v[i].length >= 5) {
                narr.push(v[i].substr(0, 5));
              } else {
                narr.push(v[i]);
              }
            }
          }
        }
      this.ruleForm.tagValue = narr
    }
  }
});
