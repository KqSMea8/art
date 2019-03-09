var editorText = '<p style="color: rgb(153, 153, 153);">捕捉创作灵感，记录创作故事。可上传生活状态图，作品图（建议像素：1024*1024）</p>';
var ue = UE.getEditor('editor',{
           toolbars: [
                  ['undo', 'redo', '|','fontsize', '|','blockquote','horizontal', '|','removeformat', 'formatmatch', 'insertimage'],
                ['bold', 'italic', 'underline', 'forecolor','backcolor','|','indent','justifyleft', 'justifycenter', 'justifyright', 'justifyjustify','|','rowspacingtop', 'rowspacingbottom', 'lineheight', '|','insertorderedlist', 'insertunorderedlist','|','imagenone', 'imageleft', 'imageright', 'imagecenter'
              ] ]
           ,enableContextMenu: false
           ,elementPathEnabled : false
           ,wordCount:false
           ,enableAutoSave:true  
        }); 

        UE.Editor.prototype.placeholder = function (justPlainText) {
          var _editor = this;
          _editor.addListener("focus", function () {
            var localHtml = _editor.getContent();
            if ($.trim(localHtml) === $.trim(justPlainText)) {
              _editor.setContent("<p><br></p>");
            }
          });
          // _editor.addListener("blur", function () {
          //   var localHtml = _editor.getContent();
          //   if (!localHtml) {
          //     _editor.setContent(justPlainText);
          //   }
          // });
          // _editor.ready(function () {
          //   _editor.fireEvent("blur");
          // });
        };
          
var vmAuth = new Vue({
  el: '#edit',
  data: {
    myInfo: {
      uid: getCookie('userid'),
      name: getCookie('userName'),
      face: getCookie('userFace')
    },    
    updateLists:[],//作品更新状态列表    
    proname:'',//作品名称    
    ruleForm: {//规则验证字段
          date: new Date() ,
          cover:'',
          class:'',
          tagValue:[]
    },
    coverShow: true,//是否显示封面图
    rules: {//字段验证规则
      date: [{
        type: 'date',
        required: true,
        message: '请填写创作时间',
        trigger: 'blur'
      }] ,       
      cover: [{                          
         required: true,
         message: '封面图需上传' ,
         trigger: 'change'        
       }],
       class: [{  
         type: 'number',               
         required: true,
         message: '请填写画作类别',
         trigger: 'change'
       }],
       tagValue:[{
          type: 'array', 
          required: true,
          message: '请选择画作标签' ,
          trigger: 'change'         
       }]
    },
    artID:'',//艺术品id
    updateid:'',//当前更新id
    editTitle:'',//作品标题    
    isTitleTip:false,//标题提示   
    classOptions:[],//画作类别选项              
    maskseen:false,//预览显示开关
    alertseen:false,//弹出框提示开关
    tagOptions: [],//画作标签 
    desc:'',  //画作介绍
    curli:'Add'+getCookie('userid'),//当前选中的li
    isFinished:'',//作品是否完成标志
    titleDisable:false,//标题是否可修改
    storageTag:false,//是否可保存标志
    loading:true,//加载动画是否显示
    isClick:false,//防止点击后获取的内容不对应
    uploadloading:false
    // isOK:true
  },
  computed: {
    addDate: function () {//新增单次更新创作日期显示
        var that = this;
        if(that.curli == 'Add'+that.myInfo.uid){
           if(that.ruleForm.date){
               return formatDate(that.ruleForm.date)
           }    
        }else if(Storage.get('editorAdd'+that.myInfo.uid)){
           return formatDate(Storage.get('editorAdd'+that.myInfo.uid).date);
        }
        return formatDate(new Date());
      },
    bg:function(){//新增单次更新背景显示
       var that = this;
          if(this.curli == 'Add'+that.myInfo.uid){
              if(that.ruleForm.cover){
                  return 'background-image:url("'+that.ruleForm.cover+'")';
              }else{
                 return '';
              }               
          }else if(Storage.get('editorAdd'+that.myInfo.uid) && Storage.get('editorAdd'+that.myInfo.uid).cover != ''){
              return  'background-image:url("'+Storage.get('editorAdd'+ that.myInfo.uid).cover+'")';
          } else{
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
  created:function(){ 
       var that =this;  
        window.localStorage.clear(); 
        //编辑器ready             
        ue.ready(function(){ 
            //因为Laravel有防csrf防伪造攻击的处理所以加上此行    
            var _token =  $('meta[name="csrf-token"]').attr('content');     
            ue.execCommand('serverparam','_token',_token);  
            ue.setContent(editorText);  
            oft = $('#editor').offset().top+81,
             ofl = $('#editor').offset().left + 8;
             $('#editor-title').css({'top': oft  ,'left': ofl }).show();
             $(window).resize(function(){
                oft = $('#editor').offset().top+81,
                 ofl = $('#editor').offset().left + 8;
                 $('#editor-title').css({'top': oft  ,'left': ofl }).show();
             })
             $('#editor-title input').on('input',function(){
                 var len = getByteLen($(this).val());
                 if (len > 20 ) {
                   isTitleTip = true;
                 }else{
                   isTitleTip = false;
                 } ;
                 $('#editor-Titcount').text(len+'/20');
             }) 
             //焦点获取处理
             ue.placeholder(editorText);
              
             that.artID = GetRequest('id').id; //地址栏中获取艺术品id  
             //获取艺术品状态更新列表(放这里要在加载编辑器后调用editPro导致报错的问题)
             if(!that.artID){that.loading = false;}             

             if(that.artID){
               Storage.set('artID',that.artID);
               artzheAgent.call('Artwork/getArtDetail',{"artId":that.artID},function(response){
                 if(response.code == 30000 && response.data.status == 1000){
                    that.editTitle = response.data.info.name;
                    that.updateLists = response.data.info.updateList;
                    that.proname =   response.data.info.name;
                    that.isFinished = response.data.info.is_finished;
                    var len = getByteLen(that.editTitle);
                    $('#editor-Titcount').text(len+'/20');
                    if(len){
                       that.titleDisable = true;
                    }
                     if(that.isFinished==='Y'){//如果是完成作品则加载第一个
                        that.curli = that.updateLists[0].list[0].id;
                        that.editPro(that.curli);
                     }
                     that.loading = false;
                  }else{
                    that.$message.error(response.code + ' : ' + response.message);
                  }   
               })
             }
        });
     
      //获取作品分类
      artzheAgent.call('Artwork/getArtworkCategoryConfig',{},function(response){ 
          
        if(response.code == 30000 && response.data.status == 1000){
          that.classOptions = response.data.info;             
         }else{
           that.$message.error(response.code + ' : ' + response.message);
         }  
      })
       //获取作品标签
      artzheAgent.call('Artwork/getArtworkTagConfig',{},function(response){
        console.log(response); 
        if(response.code == 30000 && response.data.status == 1000){
            that.tagOptions = response.data.info; 
             // that.$nextTick(function(){
             // that.loading = false;          
             //  })             
         }else{
           that.$message.error(response.code + ' : ' + response.message);
         }        
      }) 

      timer = setInterval(function(){//自动保存当前编辑状态  
        if(that.curli == 'Add'+that.myInfo.uid && $.trim(ue.getContent())!= '' && $.trim(ue.getContent()) != editorText ){
           that.storageTag = true;
        }      
        if (that.storageTag) {//判断是否切换状态，避免缓存错误
           that.saveForm();
        }
      },5000)
  },
  methods: {
    saveForm: function (formName) {
      var that = this;
      if($.trim(ue.getContent())== '' || $.trim(ue.getContent()) == editorText){return false}
      var storageResult= Storage.set('editor'+that.curli,{
          'artID':that.artID,
          'title':that.editTitle,
          'date': that.ruleForm.date,
          'class':that.ruleForm.class,
          'tag':that.ruleForm.tagValue,
          'desc':that.desc,
          'coverShow':that.coverShow,
          'cover':that.ruleForm.cover,
          'wit':ue.getContent()
        });      
    },
    maskSeen:function(){//预览点击事件
      var that = this;
      if(!this.editTitle){
          that.$message({
              message:'请填写标题！'              
          }); 
          return false;
      }else if($.trim(ue.getPlainTxt())=== editorText){
          that.$message({
              message:'请编辑内容！'              
          }); 
          return false;
      }else if($(ue.getContent()).find('img').length <= 0){
          that.$message({
              message:'可上传生活状态图，作品图（建议像素：1024*1024）！'              
          }); 
          return false;
      }

      if(that.uploadloading){
         that.$message({
              message:'图片上传中！'              
          }); 
         return false;
      }
      this.$refs.ruleForm.validate(function(valid){
        if (valid) {  
           // if(!that.isOK){return false;} 
           that.maskseen = true;
           that.alertseen = false;
           that.saveForm();
           //iframe显示
           var frame = $("#previewCreative_iframe")[0].contentWindow;      
           frame.$("#iframe-name").html(that.editTitle);  
           frame.$("#iframe-date").html(formatDate(that.ruleForm.date)); 
           frame.$("#wrap").html(ue.getContent());
           frame.$("#artist-name").html('作者：'+  that.myInfo.name)  
        } else {
          that.$message({
              message:'请填写创作信息！'              
          }); 
          return false;
        } 
    } ) 
    },
    closemaskSeen:function(){//关闭预览蒙层
       this.maskseen = false;
    },
    alertSeen:function(){//弹框显示
       this.alertseen = true;
    },    
    beforeAvatarUpload:function(file) {
       this.uploadloading = true;

      // this.isOK =false;
      // var isJPG = file.type === 'image/jpeg';
      // var isLt2M = file.size / 1024 / 1024 < 2;

      // if (!isJPG) {
      //   this.$message.error('上传头像图片只能是 JPG 格式!');
      // }
      // if (!isLt2M) {
      //   this.$message.error('上传头像图片大小不能超过 2MB!');
      // }
      // return isJPG && isLt2M;
    },    
    handleAvatarScucess:function(res, file) {
        if (res.success) {
              this.$message({
                  message:'封面图片上传成功！',
                  type:'success'
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
     editPro:function(updateid){//点击更新状态获取更新编辑内容
         //获取画作更新详情
         var that = this;
         if(this.isClick){ return false; } //防止快速点击情况下获取内容不对应
         this.isClick = true;
         this.storageTag = false;         
         this.curli = updateid;
         var that = this;
         this.updateid = updateid;
         if(Storage.get('editor'+that.updateid)){//如果有缓存就获取缓存 否则重新请求
              var osto = Storage.get('editor'+that.updateid);      
              if(osto){
                 that.editTitle =  osto.title;
                 var len = getByteLen(that.editTitle);
                 $('#editor-Titcount').text(len+'/20');
                 that.ruleForm.date= new Date(osto.date);
                 that.ruleForm.class= osto.class;
                 that.ruleForm.tagValue = osto.tag;
                 that.desc = osto.desc;
                 that.ruleForm.coverShow = osto.coverShow;
                 that.ruleForm.cover = osto.cover;                  
                 ue.setContent(osto.wit);
                 that.storageTag = true; 
                 that.isClick = false;
              }      
         }else{//重新请求
           artzheAgent.call('Artwork/getUpdateInfo',{"id":updateid},function(response){
                if(response.code == 30000 && response.data.status == 1000){
                    that.artID = response.data.info.artwork_id;
                    that.editTitle = response.data.info.name;
                    ue.setContent(response.data.info.wit); 
                    var len = getByteLen(that.editTitle);
                    $('#editor-Titcount').text(len+'/20');
                    that.ruleForm.date = new Date(response.data.info.create_date);
                    that.ruleForm.class= Number(response.data.info.category);
                    that.ruleForm.tagValue = response.data.info.tag_ids;
                    that.desc = response.data.info.summary;
                    that.coverShow = response.data.info.is_cover_show == "Y";
                    that.ruleForm.cover =response.data.info.cover; 
                    that.storageTag = true; 
                    that.saveForm();//请求后存立刻入缓存中，避免多次请求
                    that.isClick = false;
                 }else{
                   that.$message.error(response.code + ' : ' + response.message);
                 } 
           }) 
        }
     },
     updatePro:function(){//增加更新
         var that = this;
         if(this.curli === 'Add'+that.myInfo.uid){//如果当前是新增，则增加更新
            var st = Storage.get('editor'+that.curli); 
            var dateformat = formatDate(st.date);
            var obj = {               
              'artworkName':st.title,
              'categoryId':st.class,
              'artworkTagIds':st.tag.join(','),
              'story':st.desc,
              'wit':ue.getContent(),
              'createDate':dateformat,
              'coverId':st.cover,
            };
            if(GetRequest('id').id){//单次更新需要加上产品id
               obj.artworkId = GetRequest('id').id;
            } 
            if (obj.coverId.indexOf('undefined') > -1 ) {
               that.$message({
                   message: '上传失败'                  
               }); 
             return false;}
             artzheAgent.call('Artwork/addUpdate',obj,function(response){ 
                that.maskseen = false;
                that.alertseen = false;
                if(response.data.status == 1000 && response.code == 30000){
                     that.$message({
                         message:'更新成功！',
                         type:'success'
                     }); 
                     window.location.href = '/upload/manage';
                  // artzheAgent.call('Artwork/getArtDetail',{"artID":GetRequest('id').id},function(response){
                  //    that.updateLists = response.data.info.updateList;
                  //    that.proname =   response.data.info.name     
                  // })
                }else{
                    that.$message(response.code + ' : ' + response.message);  
                } 
             })
            

         }else{//有单次更新id则调取edit
              var st = Storage.get('editor'+that.curli); 
              var dateformat = formatDate(st.date);
              var obj = { 
                'artworkUpdateId': Number(that.curli),              
                'artworkName':st.title,
                'categoryId':st.class,
                'artworkTagIds':st.tag.join(','),
                'story':st.desc,
                'wit':ue.getContent(),
                'createDate':dateformat,
                'coverId':st.cover,
              };
             artzheAgent.call('Artwork/edit',obj,function(response){ 
                 that.maskseen = false;
                 that.alertseen = false;
                 if(response.data.status == 1000 && response.code == 30000){
                      that.$message({
                          message:'更新成功！',
                          type:'success'
                      }); 
                      clearInterval(timer);
                      window.localStorage.clear();                    
                      window.location.href = '/upload/manage' ;
                   // artzheAgent.call('Artwork/getArtDetail',{"artID":GetRequest('id').id},function(response){
                   //    that.updateLists = response.data.info.updateList;
                   //    that.proname =   response.data.info.name     
                   // })
                 }else{
                     that.$message(response.code + ' : ' + response.message);  
                 } 
             })
         }
         
     },
     finishedPro:function(){//进入完成页面
      var that = this;
      var editID = this.curli;
      var isSet =  Storage.set('editID',editID);
        if(isSet){
            window.location.href = '/upload/finished'    
        }
     },
     addPro:function(){//左侧列表第一个  
        if(!this.storageTag){ return false;}      
        var that = this;
       this.curli = 'Add'+that.myInfo.uid;
        var osto = Storage.get('editor'+that.curli); 
        if(osto){
           // that.editTitle =  osto.title;
           var len = getByteLen(that.editTitle);
           $('#editor-Titcount').text(len+'/20');
           that.ruleForm.date= new Date(osto.date);
           that.ruleForm.class= osto.class;
           that.ruleForm.tagValue = osto.tag;
           that.desc = osto.desc;
           that.ruleForm.coverShow = osto.coverShow;
           that.ruleForm.cover = osto.cover;
           ue.setContent(osto.wit);        
        }else{
           // that.editTitle =  '';
           var len = getByteLen(that.editTitle);
           $('#editor-Titcount').text(len+'/20');
           that.ruleForm.date= new Date();
           that.ruleForm.class= '';
           that.ruleForm.tagValue = [];
           that.desc = '';
           that.ruleForm.coverShow = '';
           that.ruleForm.cover = '';
           ue.setContent(editorText);
        }         
     }
  }  
});
   

