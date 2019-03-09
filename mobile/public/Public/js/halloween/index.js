
var camera, scene, renderer;
var geometry, material, mesh;
var target = new THREE.Vector3();

var lon = 90, lat = 0;
var phi = 0, theta = 0;

var touchX, touchY;


$(function(){
  // $(function() {
    //  FastClick.attach(document.body);
  // });
  //----------------------------
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
  //取1-12随机数
  function getnum(){
    return Math.ceil(Math.random()*12);
  };
  var imgdex;//第几个海报data-id  改为随机
  var shareInfo = {
    title: '欢迎来到万圣占星馆',
    desc: '你想知道的答案都在这里',
    link: switchDomin('www') + '/Api/WechatLicense/ScanCode',
    imgUrl: window.location.protocol + '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/share.jpg',
  };

  setShare(imgdex); //设置分享信息
  audioAutoPlay('Jaudio');
  init();//初始化
  animated();//动画
  //音乐开关切换
  var audio = document.getElementsByClassName('nav_bgm')[0]
  var onOff=true;
  $(".audioBtn").on("touchend", function(e) {//音乐开关
    if(onOff) {
      audio.pause();
      onOff = !onOff;
      $(this).removeClass('play')
    }
    else {
      audio.play()
      $(this).addClass('play');
      onOff = !onOff;
    }
  });
  //判断是否为block,若存在，则让手等会出现
  if($(".door").css("display")=="block"){
      setTimeout(function(){
       $(".changan").fadeIn(300);
      },1000)
  }else{
   $(".changan").fadeOut();
  };
  //第一层显示与否
  $('.door').on("touchend",function(){
   $('.door').fadeOut(1200);//door蒙层消失
    $('.door').animate({
      display:"none"
    },100,function(){
     $(".trip").fadeIn(1000);
    });
  });
  //第二层蒙层点击时
  $(".meng").on("touchend",function(){//meng蒙层，trip消失
   $(".meng").fadeOut();
   $(".trip").fadeOut();
  });

  //添加牌背面的图片路径
  var line1Img=[
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-1.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-2.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-3.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-4.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-5.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-6.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-7.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-8.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-9.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-10.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-11.png",
    "//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/cards/card-12.png",
  ];

  //点击卡片，反转
  $(".showImg").on("click",function(event){
    // imgdex=$(this).attr("data-id");

    imgdex = getnum();
    $(this).children().eq(1).children().attr("src",line1Img[imgdex-1]);//将牌的后面的显示为随机数
    //alert(imgdex)
    $(".handtrip").css("display","none");
    //console.log(event)
    //  event.preventDefault();
    var _that=$(this);
    $(".onlyOne").css("display","block");
    $(this).children().eq(0).addClass("z1");
    $(this).children().eq(1).removeClass('bk');
    $(this).children().eq(1).addClass("z2");

    $(this).children().eq(0).on("webkitAnimationEnd",function(){
      //animationend,css3监测动画完成

      _that.addClass("rtz");//添加旋转动画
    });
      $(".close").on("touchend",function(){//关闭按钮
        _that.children().eq(0).removeClass("z1");//重置动画翻转卡片
        _that.children().eq(1).addClass('bk');//重置动画翻转卡片
        _that.children().eq(1).removeClass("z2");//重置动画翻转卡片
        _that.removeClass('rtz');//重置旋转动画
       $(".bigImgBox").fadeOut(400);
        // log(123)
        $(".handtrip").css("display","block");
      });
      // webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend
      //效果：每次只能点击一个牌， 遮罩层？
    $(this).children().eq(1).on("webkitAnimationEnd",function(){

      $(".bmgd").attr("src",_that.children().eq(1).children().attr("src"))
      $(".bigImgBox").fadeIn();
      $(".onlyOne").css("display","none");
    });

    // 微信分享定制
    setShare(imgdex);
  });

  // 微信分享定制
  function setShare(index) {
    var titleList = [
      '审时度势',
      '顺长之言',
      '驯虎自如',
      '辞旧迎新',
      '接纳新象',
      '细思自省',
      '随心而动',
      '辨路择道',
      '乐在心中',
      '重燃希望',
      '倾听心声',
      '云开月明'
    ];
    if (index) {
      shareInfo.title = ' 神准万圣占星，简直了！我的占卜结果是“' + titleList[index-1] + '”，你也一起来测测吧！';
      shareInfo.desc = '欢迎来到万圣占星馆';
    } else {
      shareInfo.title = ' 欢迎来到万圣占星馆';
      shareInfo.desc = '你想知道的答案都在这里';
    }

    // log(shareInfo);
    wx.ready(function(){
      wx.onMenuShareTimeline({
        title: shareInfo.title,
        link: shareInfo.link,
        imgUrl: shareInfo.imgUrl
      });
      wx.onMenuShareAppMessage({
        title: shareInfo.title,
        desc: shareInfo.desc,
        link: shareInfo.link,
        imgUrl: shareInfo.imgUrl,
        type: 'link',
        dataUrl: ''
      });
    });
  }
  //生成海报
  var imgArr=[
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-1.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-2.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-3.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-4.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-5.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-6.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-7.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-8.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-9.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-10.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-11.jpg',
    '//artzhe.oss-cn-shenzhen.aliyuncs.com/activity/halloween/posters/poster-12.jpg'
  ];//海报的路径，格式['1.png','2.png']
  $(".shengcheng").on("touchend",function(){
    console.log(imgdex);
    console.log(imgArr[imgdex-1]);
    $(".createhaibao").attr("src", imgArr[imgdex-1]);
    $(".haibaopng").show();
  });
  $(".backstep").on("touchend",function(){
    $(".haibaopng").hide();
  });
  $(".tx").attr("src",getRequest().headimgurl);
});
function getRequest() {
    var url = location.search; //获取url中"?"符后的字串
    url = decodeURI(url);
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
function audioAutoPlay(id){
    var audio = document.getElementById(id);
    audio.play();
    document.addEventListener("WeixinJSBridgeReady", function () {
            audio.play();
    }, false);
    document.addEventListener('YixinJSBridgeReady', function() {
        audio.play();
    }, false);
}

function init() {
    /**
    * 添加相机
     * @type {THREE.PerspectiveCamera}
     */
    camera = new THREE.PerspectiveCamera(
        75, // 相机视角的夹角
        window.innerWidth / window.innerHeight,  // 相机画幅比
        1, // 最近焦距
        1000 // 最远焦距
        );

    /**
     * 创建场景
     * @type {THREE.Scene}
     */
    scene = new THREE.Scene();

    /**
     *正方体的6个面的资源及相关（坐标、旋转等）设置
     */
    var flipAngle = Math.PI, // 180度
        rightAngle = flipAngle / 2, // 90度
        tileWidth = 512;
    var sides = [{
        url: "images/141.jpg", //right
        position: [-tileWidth, 0, 0],
        rotation: [0, rightAngle, 0]
    }, {
        url: "images/141.jpg", //left
        position: [tileWidth, 0, 0],
        rotation: [0, -rightAngle, 0]
    }, {
        url: "images/141.jpg", //top
        position: [0, tileWidth, 0],
        rotation: [rightAngle, 0, Math.PI]
    }, {
        url: "images/141.jpg", //bottom
        position: [0, -tileWidth, 0],
        rotation: [-rightAngle, 0, Math.PI]
    }, {
        url: "images/141.jpg", //front
        position: [0, 0, tileWidth],
        rotation: [0, Math.PI, 0]
    }, {
        url: "images/141.jpg", //back
        position: [0, 0, -tileWidth],
        rotation: [0, 0, 0]
    }];

    for ( var i = 0; i < sides.length; i ++ ) {
        var side = sides[ i ];
        var element = document.getElementById("bg_section_"+i);
        element.width = 514;
        element.height = 514; // 2 pixels extra to close the gap.

        // 添加一个渲染器
        var object = new THREE.CSS3DObject( element );
        object.position.fromArray( side.position );
        object.rotation.fromArray( side.rotation );
        scene.add( object );

    }

    renderer = new THREE.CSS3DRenderer(); // 定义渲染器
    renderer.setSize( window.innerWidth, window.innerHeight ); // 定义尺寸
    document.body.appendChild( renderer.domElement ); // 将场景到加入页面中

    initDevices();
    initMouseControl();

}

// 初始化控制器
function initMouseControl() {
    // mouseControl = new THREE.OrbitControls(camera);
    document.addEventListener( 'mousedown', onDocumentMouseDown, false );
    // document.addEventListener( 'wheel', onDocumentMouseWheel, false );
    document.addEventListener( 'touchstart', onDocumentTouchStart, true );
    document.addEventListener( 'touchmove', onDocumentTouchMove, true );
    window.addEventListener( 'resize', onWindowResize, false );

}

var controlsBtn= document.getElementById("controlBtn"); // 控制陀螺仪开关的按钮
var isDeviceing = false; // 陀螺仪状态
controlsBtn.addEventListener("touchend", controlDevice, true);
isDeviceing == true ? $("#controlBtn").addClass("controlIconae") : $("#controlBtn").addClass("controlIcon");
// 初始化陀螺仪
function initDevices() {
    deviceControl = new THREE.DeviceOrientationControls(camera);
}
/* 控制陀螺仪 */
function controlDevice(event) {
    if (isDeviceing == true) {
        isDeviceing = false;
        //关闭陀螺仪
        $("#controlBtn").removeClass("controlIcon").addClass("controlIconae");
    } else {
        isDeviceing = true;
        //开启陀螺仪
        $("#controlBtn").removeClass("controlIconae").addClass("controlIcon");
    }
}

/**
 * 窗体大小改变
 */
function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize( window.innerWidth, window.innerHeight );
}

/*
相机焦点跟着鼠标或手指的操作移动
 */
function onDocumentMouseDown( event ) {
    event.preventDefault();
    document.addEventListener( 'mousemove', onDocumentMouseMove, false );
    document.addEventListener( 'mouseup', onDocumentMouseUp, false );

}

function onDocumentMouseMove( event ) {
    var movementX = event.movementX || event.mozMovementX || event.webkitMovementX || 0;
    var movementY = event.movementY || event.mozMovementY || event.webkitMovementY || 0;
    lon -= movementX * 0.1;
    lat += movementY * 0.1;
}

function onDocumentMouseUp( event ) {
    document.removeEventListener( 'mousemove', onDocumentMouseMove );
    document.removeEventListener( 'mouseup', onDocumentMouseUp );
}

/**
 * 鼠标滚轮改变相机焦距
 */
function onDocumentMouseWheel( event ) {
    camera.fov += event.deltaY * 0.05;
    camera.updateProjectionMatrix();
}

function onDocumentTouchStart( event ) {
    // event.preventDefault();
    var touch = event.touches[ 0 ];
    touchX = touch.screenX;
    touchY = touch.screenY;

}

function onDocumentTouchMove( event ) {
    event.preventDefault();
    $(".handtrip").css("display","none");
    var touch = event.touches[ 0 ];
    lon -= ( touch.screenX - touchX ) * 0.3;
    lat += ( touch.screenY - touchY ) * 0.3;
    touchX = touch.screenX;
    touchY = touch.screenY;
}

/**
 * 实时渲染函数
 */
function animated() {
    requestAnimationFrame(animated);
    // lon = Math.max(-180, Math.min(180, lon));//限制固定角度内旋转
    // lon += 0.1;//自动旋转
    lat = Math.max(-85, Math.min(85, lat)); //限制固定角度内旋转
    phi = THREE.Math.degToRad(85 - lat);
    theta = THREE.Math.degToRad(lon+180);
    target.x = Math.sin(phi) * Math.cos(theta);
    target.y = Math.cos(phi);
    target.z = Math.sin(phi) * Math.sin(theta);
    camera.lookAt( target );
    camera.updateProjectionMatrix();
    isDeviceing == false ? initMouseControl() : deviceControl.update();
    renderer.render(scene, camera);
}
function log(str){
  console.log(str);
}
