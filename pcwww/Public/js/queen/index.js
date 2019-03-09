var href = window.location.href;
// 百度统计代码
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?b04dbbe8716725ab25d51f59b1f1931e";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();

//获取请求参数
function GetRequest() {
  var url = location.search; //获取url中"?"符后的字串
  var theRequest = {};
  if (url.indexOf("?") != -1) {
    var str = url.substr(1);
    strs = str.split("&");
    for (var i = 0; i < strs.length; i++) {
      theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
    }
  }
  return theRequest;
}


function checkUA() { //浏览器ua判断
  var isIOS, isAndroid, isWeChat, isAPP;
  var ua = navigator.userAgent.toLowerCase();
  if (/iphone|ipad|ipod/.test(ua)) {
    isIOS = true;
    isAndroid = false;
  } else if (/android/.test(ua)) {
    isIOS = false;
    isAndroid = true;
  }
  if (/micromessenger/.test(ua)) {
    isWeChat = true;
  }
  if (/artzhe/.test(ua)) {
    isAPP = true;
  }
  return {
    isIOS: isIOS,
    isAndroid: isAndroid,
    isWeChat: isWeChat,
    isAPP: isAPP
  };
}

function jsToNative(ocData) {
  if (checkUA().isAndroid) {
    ocData = JSON.stringify(ocData);
    OCModel.jsCallNative(ocData);
  }

  if (checkUA().isIOS) {
    try {
      window.webkit.messageHandlers[ocData.api].postMessage(ocData);
    }
    catch (ex) {
      OCModel.jsCallNative(ocData);
    }
  }
}


  var az_token = GetRequest().az_token;
  var actId = ''; //
  var goodsId='';
  var index = ''; //当前点击的index
  var isLogin = az_token ? 1 : 0; //判断app内是否登陆
  var isBindWeChat = 0; // 判断是否绑定微信  | 0 未绑定 | 1绑定 | 2 没有安装微信 | 3 取消登录微信 | 4 绑定其他
  var thirdInfo = {};
  var bargainData = {}; // 砍价参数
  var fromAppMsg = ''; //从app返回回来的消息
  var shareObj = {}; //分享所需的数据
$(function(){


  //各环境domain转换
  function switchDomin(str) { //str:mp|m|www|api
    var myDomin, aDomin, aFirst, sFirst, sFirstNew;

    aDomin = window.location.host.split('.'); //域名数组
    sFirst = aDomin[0]; //获取二级域名前缀
    if (aDomin.length > 2) {
      aDomin.shift();
    }
    sMain = aDomin.join('.');
    aFirst = sFirst.split('-');
    sFirstNew = '';

    if (aFirst.length > 1) {
      sFirstNew = aFirst[0] + '-';
    }
    myDomin = window.location.protocol + '//' + sFirstNew + str + '.' + sMain;

    return myDomin;
  }

  getList();
  function getList(){ // 获取列表信息

    var data = {
      'activity_id':1
    };
    if (az_token) {
      data.az_token = az_token;
    }
    $.ajax({
      url:'/Activity/ShopActivityGoods/goods',
      type:'post',
      data: data,
      dataType:'json',
      success:function(res){
        isLogin = res.data.info.is_login; //app登陆状态
        isBindWeChat = res.data.info.user_isBind_WX; //是否绑定微信

        if(checkUA().isAPP){
          thirdInfo.user_face = res.data.info.userinfo.user_face;
          thirdInfo.user_id = res.data.info.userinfo.user_id;
          thirdInfo.user_nickname = res.data.info.userinfo.user_nickname;
          thirdInfo.user_union_id = res.data.info.userinfo.user_union_id;


          bargainData.union_id = res.data.info.userinfo.user_union_id;
          bargainData.wx_face = res.data.info.userinfo.user_face;
          bargainData.wx_name = res.data.info.userinfo.user_nickname;


        }
        if(checkUA().isWeChat){
          thirdInfo.user_face = res.data.info.userinfo.WechatAuthorize.user_face;
          thirdInfo.user_id = res.data.info.userinfo.WechatAuthorize.user_id;
          thirdInfo.user_nickname = res.data.info.userinfo.WechatAuthorize.user_nickname;
          thirdInfo.user_union_id = res.data.info.userinfo.WechatAuthorize.user_union_id;

          bargainData.union_id = res.data.info.userinfo.WechatAuthorize.unionId;
          bargainData.wx_face = res.data.info.userinfo.WechatAuthorize.faceUrl;
          bargainData.wx_name = res.data.info.userinfo.WechatAuthorize.nickname;

        }

        console.log(thirdInfo)
        var str = '';
        $.each(res.data.info.list,function(index,value){
          str+='<li>'+
          '<a onclick="_hmt.push([\'_trackEvent\', \'活动一：活动首页查看商品详情\', \'click\', href]);" href="'+ switchDomin('mall') + '/mobile/index.php?m=goods&id=' + value.goods_id+'">'+
              '<img class="listImg" src="'+value.goods_cover+'" alt="">'+
              '</a>'+
              '<div class="linstDescription" data-id="'+value.id+'">'+
                '<p class="listTitle">'+value.goods_name+'</p>'+
                '<span class="listActivity">'+value.activity_name+'</span>'+
                '<p class="listPrice">￥'+value.goods_price+'</p>'+
                '<button class="fanci" data-status="'+value.activity_status+'" data-goodsId="'+value.goods_id+'"></button>'+
              '</div>'+
          '</li>';
          //
          // if(value.activity_status == 1){
          //   str += '<li>'+
          //   '<a onclick="_hmt.push([\'_trackEvent\', \'活动一：活动首页查看商品详情\', \'click\', href]);" href="'+ switchDomin('mall') + '/mobile/index.php?m=goods&id=' + value.goods_id+'">'+
          //       '<img class="listImg" src="'+value.goods_cover+'" alt="">'+
          //       '</a>'+
          //       '<div class="linstDescription" data-id="'+value.id+'">'+
          //         '<p class="listTitle">'+value.goods_name+'</p>'+
          //         '<span class="listActivity">'+value.activity_name+'</span>'+
          //         '<p class="listPrice">￥'+value.goods_price+'</p>'+
          //         '<button class="fanci" data-status="'+value.activity_status+'" data-goodsId="'+value.goods_id+'"></button>'+
          //       '</div>'+
          //   '</li>';
          // }
          // else{
          //   str += '<li>'+
          //   '<a onclick="_hmt.push([\'_trackEvent\', \'活动一：活动首页查看商品详情\', \'click\', href]);" href="'+ switchDomin('mall') + '/mobile/index.php?m=goods&id=' + value.goods_id+'">'+
          //       '<img class="listImg" src="'+value.goods_cover+'" alt="">'+
          //       '</a>'+
          //       '<div class="linstDescription" data-id="'+value.id+'">'+
          //         '<p class="listTitle">'+value.goods_name+'</p>'+
          //         '<span class="listActivity">'+value.activity_name+'</span>'+
          //         '<p class="listPrice">￥'+value.goods_price+'</p>'+
          //         '<button class="fanci shared" data-status="'+value.activity_status+'" data-goodsId="'+value.goods_id+'"></button>'+
          //       '</div>'+
          //   '</li>';
          // }

        });
        $('.queenActivityBox').append(str);
      },
      error:function(err){
        console.log(err.statusText)
      }
    })
  };
  //绑定点击事件 //点击分享
  $('.queenActivityBox').on('click', '.fanci',function(){

    _hmt.push(['_trackEvent', '活动一：活动首页免费领画', 'click', href]);

    index = $('.queenActivityBox .fanci').index(this);
    console.log(index)
    if(checkUA().isWeChat){ // 微信判断
      isLogin = 1;
      isBindWeChat = 1; //在微信中打开时，直接进入下一步
    };
    goodsId = $(this).attr('data-goodsId');
    actId = $(this).parent('.linstDescription').attr('data-id');
    if(isLogin){
        if(isBindWeChat == '1'){ // class名   nowx 未安装微信 //loginwx 未登录微信 //havewx 绑定微信号
          if($(this).attr('data-status') == 1){
            var data = {
              activity_goods_id:actId
            };
            if (az_token) {
              data.az_token = az_token;
            }

            $('.queenActivityBox .fanci').eq(index).addClass('shared'); //改变按钮样式

            $.ajax({
              url:'/Activity/ShopActivityShare/GetShare',
              type:'post',
              dataType:'json',
              data:data,
              success:function(res){
                var shareToId = res.data.info.share_id; // 返回的用户分享出去的商品id
                var nickname = res.data.info.nickname; // 返回的用户昵称
                console.log(thirdInfo) //test
                bargainData.share_id = res.data.info.share_id;

                shareObj.shareTitle = '艺术品免费送，帮我抢个减免大红包！'; //nickname +
                shareObj.shareUrl = window.location.origin+'/activity/queen/share?share_id='+shareToId;
                shareObj.shareImgUrl = 'https://artzhe.oss-cn-shenzhen.aliyuncs.com/activity/queen/share_icon2.jpg';
                shareObj.shareContent = '动动手指，帮帮TA';


                if(res.data.status==1001){ //状态为1001时不显示自砍一刀蒙层

                  // $('.queenActivityBox .fanci').eq(index).addClass('shared'); //改变按钮样式

                  if (checkUA().isAPP) {

                    $('.Firstknife').hide(); // 隐藏获得55元弹层
                    $('.shareToWXBg').fadeIn(); // 显示分享弹层

                  }

                  if(checkUA().isWeChat){ // weixin
                    $('.Firstknife').hide();
                    $('.wxTrip').show();//蒙层显示
                    $('.wxTrip').on('click',function(){
                      $(this).hide();//蒙层消失
                    });
                    //微信分享
                    wx.ready(function () {
                      //分享朋友圈
                      wx.onMenuShareTimeline({
                        title: shareObj.shareTitle,
                        link: shareObj.shareUrl,
                        imgUrl: shareObj.shareImgUrl,// 自定义图标
                        success: function (res) {
                          //alert('shared success');
                          //some thing you should do
                        },
                        cancel: function (res) {
                          //alert('shared cancle');
                        },
                        fail: function (res) {
                          //alert(JSON.stringify(res));
                        }
                      });
                      //分享给好友
                      wx.onMenuShareAppMessage({
                        title: shareObj.shareTitle, // 分享标题
                        desc: '动动手指，帮帮TA', // 分享描述
                        link: shareObj.shareUrl, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                        imgUrl: shareObj.shareImgUrl, // 自定义图标
                        type: 'link', // 分享类型,music、video或link，不填默认为link
                        dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                        success: function () {
                          // 用户确认分享后执行的回调函数

                        },
                        cancel: function () {
                          // 用户取消分享后执行的回调函数
                        }
                      });
                      wx.error(function (res) {
                        // alert(res.errMsg);
                      });
                    });
                  }
                }
                else{
                  getSelfWeChatInfo(); // 自砍一刀
                  $('.cutDown').on('click',function(e){
                    _hmt.push(['_trackEvent', '活动一：活动首页减免更多', 'click', href]);
                    e.stopPropagation();

                    // $('.queenActivityBox .fanci').eq(index).addClass('shared'); //改变按钮样式

                    if (checkUA().isAPP) {

                      $('.Firstknife').hide(); // 隐藏获得55元弹层
                      $('.shareToWXBg').fadeIn(); // 显示分享弹层

                    }

                    if(checkUA().isWeChat){ // weixin
                      $('.Firstknife').hide();
                      $('.wxTrip').show();//蒙层显示
                      $('.wxTrip').on('click',function(){
                        $(this).hide();//蒙层消失
                      });
                      //微信分享
                      wx.ready(function () {
                        //分享朋友圈
                        wx.onMenuShareTimeline({
                          title: shareObj.shareTitle,
                          link: shareObj.shareUrl,
                          imgUrl: shareObj.shareImgUrl,// 自定义图标
                          success: function (res) {
                            //alert('shared success');
                            //some thing you should do
                          },
                          cancel: function (res) {
                            //alert('shared cancle');
                          },
                          fail: function (res) {
                            //alert(JSON.stringify(res));
                          }
                        });
                        //分享给好友
                        wx.onMenuShareAppMessage({
                          title: shareObj.shareTitle, // 分享标题
                          desc: '动动手指，帮帮TA', // 分享描述
                          link: shareObj.shareUrl, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                          imgUrl: shareObj.shareImgUrl, // 自定义图标
                          type: 'link', // 分享类型,music、video或link，不填默认为link
                          dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                          success: function () {
                            // 用户确认分享后执行的回调函数

                          },
                          cancel: function () {
                            // 用户取消分享后执行的回调函数
                          }
                        });
                        wx.error(function (res) {
                          // alert(res.errMsg);
                        });
                      });

                    }
                  })
                }
              },
              error:function(err){
                console.log(err.statusText)
              }
            })

          }
          else if($(this).attr('data-status')==2){
            // alert('活动未开始!')
            $('.aboutactive').show();
            $('.activeinfo').text('活动未开始!');
          }
          else if($(this).attr('data-status')==3){
            // alert('活动已结束!')
            $('.aboutactive').show();
            $('.activeinfo').text('活动已结束!');
          }
        }
        //nowx loginwx havewx wxbindother
        else if (isBindWeChat == 2) { //没有安装微信
          $('.bindwx').show();
          $('.nowx').show();

          //其他的提示块隐藏
          $('.loginwx').hide();
          $('.havewx').hide();
          $('.wxbindother').hide();
        }
        else if (isBindWeChat == 3) { //取消登录微信
          $('.bindwx').show();
          $('.loginwx').show();

          //其他的提示块隐藏
          $('.nowx').hide();
          $('.havewx').hide();
          $('.wxbindother').hide();
        }
        else if(isBindWeChat == 4){ //已绑定其他
          $('.wxbindother p' ).text(fromAppMsg);
          $('.bindwx').show();
          $('.wxbindother').show();

          //其他的提示块隐藏
          $('.nowx').hide();
          $('.havewx').hide();
          $('.loginwx').hide();
        }
        else if (isBindWeChat == 0) { //未绑定微信
          $('.bindwx').show();
          $('.havewx').show();

          //其他的提示块隐藏
          $('.nowx').hide();
          $('.loginwx').hide();
          $('.wxbindother').hide();
        }

    }
    else{
      if (checkUA().isAPP) {
        var willLogin = {
          api:'login'
        }

        jsToNative(willLogin);

      }
    }
  });

  $('.surebind').on('click',function(){ //点击一键绑定时
    getwxcode();
    $('.bindwx').hide();

  });

  //点击 “我知道了” 隐藏弹层
  $('.gologinwx').on('click',function(){
    $('.bindwx').hide();
  });

  //点击 “我知道了” 隐藏弹层
  $('.installwx').on('click',function(){
    $('.bindwx').hide();
  });
  //点击 “我知道了” 隐藏弹层
  $('.aboutactive').on('click',function(){
    $(this).hide();
  });

  $('.useNow').on('click',function(e){ //点击立即使用时fn
    e.stopPropagation();
    $('.Firstknife').hide();
    $('.goshop').show();
  });

  // $('.goshop').on('click',function(){ //点击弹层隐藏
  //   $(this).hide();
  // })

  $('.goshop-btn').on('click',function(e){
    e.stopPropagation();
    _hmt.push(['_trackEvent', '活动一：活动首页立即使用', 'click', href]);
    window.location.href=switchDomin('mall') + '/mobile/index.php?m=goods&id='+goodsId;
  });

  $('.bindwx').on('click',function(){ //隐藏弹层
    $(this).hide();
  });

  $('.whitebox').on('click',function(e){ //阻止默认事件
    e.stopPropagation();
  });
  $('.needwx').on('click',function(e){ //阻止默认事件
    e.stopPropagation();
  });

  $('.dontShare').on('click',function(){ //点击取消 fn
    $('.shareToWXBg').fadeOut();
  });

  $('.toFriend').on('click',function(){ // 点击分享微信fn
    shareObj.api = 'share_wx';
    jsToNative(shareObj);
  });

  $('.toPyq').on('click',function(){ // 点击分享到朋友圈fn
    shareObj.api = 'share_pyq';
    jsToNative(shareObj);
  });


})

function getwxcode(){ //通过app调起微信fn
  var getwx={ //微信绑定api
      api:'login_wx'
  }

  jsToNative(getwx);

};

function getSelfWeChatInfo(){ // 自砍一刀价格fn
  var data = bargainData;
  console.log(thirdInfo)
  // alert(JSON.stringify(data));
  $.ajax({
    url:'/Activity/Queen/bargain',
    type:'post',
    dataType:'json',
    data:data,
    success:function(res){
      // alert(res.code)
      // if(res.code == 30000){
        $('.Firstknife').show(); //自砍一刀弹层
        $('.isezingIn').addClass('gole'); //动画
        // $('.Firstknife').on('click',function(){ //点击隐藏
        //   $(this).hide();
        // })
      // }
    },
    error:function(err){
      console.log(err.statusText)
    }
  })
}


  function interact(obj) {
  if (obj.api == 'login') { //登陆
    if (obj.code == 30000) {
      // alert(obj.az_token);
      az_token = obj.az_token;
      isLogin = 1;
      // 手动触发点击

      // toshare();
      // window.location.href = window.location.href + '?az_token=' + obj.az_token;
    }
  }
  if (obj.api == 'login_wx') { //是否绑定微信
    if(obj.code == 30000){ //绑定微信成功
        isBindWeChat = 1;
        if(typeof obj.thirdInfo != 'object'){
          obj.thirdInfo = JSON.parse(obj.thirdInfo); //安卓传过来的是字符串对象

        }else{

        }
        bargainData.union_id = obj.thirdInfo.unionId;
        bargainData.wx_face = obj.thirdInfo.faceUrl;
        bargainData.wx_name = obj.thirdInfo.nickname;
        $('.queenActivityBox .fanci').eq(index).click();
    }
    if (obj.code == 30001){ //没有安装微信
      isBindWeChat = 2;
      $('.bindwx').show();
      $('.nowx').show();

      //其他的提示块隐藏
      $('.loginwx').hide();
      $('.havewx').hide();
      $('.wxbindother').hide();
    }
    if(obj.code == 30002){ //取消登录微信
      isBindWeChat = 3;
          $('.bindwx').show();
          $('.loginwx').show();

          //其他的提示块隐藏
          $('.nowx').hide();
          $('.havewx').hide();
          $('.wxbindother').hide();
    }
    if(obj.code == 30003){ //已绑定其他
      fromAppMsg = obj.msg;
      isBindWeChat = 4;
          $('.wxbindother p' ).text(fromAppMsg);
          $('.bindwx').show();
          $('.wxbindother').show();

          //其他的提示块隐藏
          $('.nowx').hide();
          $('.havewx').hide();
          $('.loginwx').hide();
    }
  }
}
