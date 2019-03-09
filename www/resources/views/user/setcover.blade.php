<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="艺术者">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>设置画廊封面</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <!-- <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" /> -->
    <!-- <link href="/js/plugin/validform/validate.css" rel="stylesheet"> -->
    <link href="/css/iconfont/iconfont.css" rel="stylesheet">
    <link href="/js/lib/element/index.css" rel="stylesheet">
    <link href="/css/global.css?v=2.0.0" rel="stylesheet">
    <link href="/css/gcommon.css?v=2.0.0" rel="stylesheet">
    <link href="/css/user.css?v=2.0.0" rel="stylesheet">
  <style type="text/css">   
    .jcrop-holder {  
        direction: ltr;  
        text-align: center;  
        margin: 0 auto;  
        /* IE10 touch compatibility */  
        -ms-touch-action: none;  
    }  
        /* Selection Border */  
    .jcrop-vline,  
    .jcrop-hline {  
        background: #ffffff url("Jcrop.gif");  
        font-size: 0;  
        position: absolute;  
    }  
    .jcrop-vline {  
        height: 100%;  
        width: 1px !important;  
    }  
    .jcrop-vline.right {  
        right: 0;  
    }  
    .jcrop-hline {  
        height: 1px !important;  
        width: 100%;  
    }  
    .jcrop-hline.bottom {  
        bottom: 0;  
    }  
        /* Invisible click targets */  
    .jcrop-tracker {  
        height: 100%;  
        width: 100%;  
        /* "turn off" link highlight */  
        -webkit-tap-highlight-color: transparent;  
        /* disable callout, image save panel */  
        -webkit-touch-callout: none;  
        /* disable cut copy paste */  
        -webkit-user-select: none;  
    }  
        /* Selection Handles */  
    .jcrop-handle {  
        background-color: #333333;  
        border: 1px #eeeeee solid;  
        width: 7px;  
        height: 7px;  
        font-size: 1px;  
    }  
    .jcrop-handle.ord-n {  
        left: 50%;  
        margin-left: -4px;  
        margin-top: -4px;  
        top: 0;  
    }  
    .jcrop-handle.ord-s {  
        bottom: 0;  
        left: 50%;  
        margin-bottom: -4px;  
        margin-left: -4px;  
    }  
    .jcrop-handle.ord-e {  
        margin-right: -4px;  
        margin-top: -4px;  
        right: 0;  
        top: 50%;  
    }  
    .jcrop-handle.ord-w {  
        left: 0;  
        margin-left: -4px;  
        margin-top: -4px;  
        top: 50%;  
    }  
    .jcrop-handle.ord-nw {  
        left: 0;  
        margin-left: -4px;  
        margin-top: -4px;  
        top: 0;  
    }  
    .jcrop-handle.ord-ne {  
        margin-right: -4px;  
        margin-top: -4px;  
        right: 0;  
        top: 0;  
    }  
    .jcrop-handle.ord-se {  
        bottom: 0;  
        margin-bottom: -4px;  
        margin-right: -4px;  
        right: 0;  
    }  
    .jcrop-handle.ord-sw {  
        bottom: 0;  
        left: 0;  
        margin-bottom: -4px;  
        margin-left: -4px;  
    }  
        /* Dragbars */  
    .jcrop-dragbar.ord-n,  
    .jcrop-dragbar.ord-s {  
        height: 7px;  
        width: 100%;  
    }  
    .jcrop-dragbar.ord-e,  
    .jcrop-dragbar.ord-w {  
        height: 100%;  
        width: 7px;  
    }  
    .jcrop-dragbar.ord-n {  
        margin-top: -4px;  
    }  
    .jcrop-dragbar.ord-s {  
        bottom: 0;  
        margin-bottom: -4px;  
    }  
    .jcrop-dragbar.ord-e {  
        margin-right: -4px;  
        right: 0;  
    }  
    .jcrop-dragbar.ord-w {  
        margin-left: -4px;  
    }  
        /* The "jcrop-light" class/extension */  
    .jcrop-light .jcrop-vline,  
    .jcrop-light .jcrop-hline {  
        background: #ffffff;  
        filter: alpha(opacity=70) !important;  
        opacity: .70!important;  
    }  
    .jcrop-light .jcrop-handle {  
        -moz-border-radius: 3px;  
        -webkit-border-radius: 3px;  
        background-color: #000000;  
        border-color: #ffffff;  
        border-radius: 3px;  
    }  
        /* The "jcrop-dark" class/extension */  
    .jcrop-dark .jcrop-vline,  
    .jcrop-dark .jcrop-hline {  
        background: #000000;  
        filter: alpha(opacity=70) !important;  
        opacity: 0.7 !important;  
    }  
    .jcrop-dark .jcrop-handle {  
        -moz-border-radius: 3px;  
        -webkit-border-radius: 3px;  
        background-color: #ffffff;  
        border-color: #000000;  
        border-radius: 3px;  
    }  
        /* Simple macro to turn off the antlines */  
    .solid-line .jcrop-vline,  
    .solid-line .jcrop-hline {  
        background: #ffffff;  
    }  
        /* Fix for twitter bootstrap et al. */  
    .jcrop-holder img,  
    img.jcrop-preview {  
        max-width: none;  
    }  
        .uploadPics {  
            position: relative;
            float: left;   
            width: 360px;  
            background-color: #fff;  
            /*border-top: 3px solid #ed2828;  */
            height: 456px;  
            overflow: hidden;  
        }  
  
        .uploadPics > img {  
            position: absolute;  
            top: 20px;  
            right: 10px;  
            cursor: pointer;  
        }  
  
        .uploadPics .picTil {  
            padding: 20px;  
            font-size: 16px;  
            color: #323232;  
            border-bottom: 1px solid #f3f3f3;  
        }  
  
        .uploadPics .picCont {  
            margin: 20px;  
            padding: 15px;  
            width: 300px;  
            height: 337px;  
            background-color: #f2f2f5;  
        }  
  
        .uploadPics .picCont > p {  
            margin-top: 20px;  
            text-align: center;  
        }  
  
  
        .uploadPics .picFooter {  
            text-align: center;  
        }  
  
        .uploadPics .picFooter .btn {  
            display: inline-block;  
            margin: 20px;  
            width: 130px;  
            height: 35px;  
            font-size: 18px;  
            line-height: 35px;  
            color: #333;  
            border-radius: 5px;  
            cursor: pointer;  
        }  
  
        .uploadPics .picFooter .upload {  
            background-color: #aaa;  
        }  
  
        .uploadPics .picFooter .confirm {  
            background-color: #f4ad23;  
        }
        .thirdLayerIn .img-preview {
          float: left;
          width: 350px;
          padding: 20px 25px 0;
          text-align: center;
        }
        .thirdLayerIn .img-preview h3 {
          height: 36px;
          line-height: 36px;
          font-size: 20px;
          color: #666;
        }
        #myCan{  
           transform: scale(0.3);
           transform-origin: 0 0;
        } 
        .box {
            text-align: left;
        }
        .Validform_checktip {
          text-align: left;
        }
        .box .btn-s {
          margin-left: 0;
        } 
        .face-preview {
          text-align: left;
        }
        .face-preview h3 {
          height: 50px;
          font-size: 16px;
          line-height: 50px;
          color: #999;
        }
        .face-preview img{
          height: 120px;
          width: 120px;
        }
        .face-preview .circle {
          margin-left: 30px;
          border-radius: 50%;
        }

        .stage-wrap {
          padding-top: 165px;
          padding-bottom: 165px;
        }
        .reg-wrap {
          padding-top: 110px;
        }
    </style>  
  </head>
  <body>
    <div v-cloak id="app">
      <header class="ysz-header">
        <div class="y-header">
          <div class="w clearfix">
            <a href="/index">
              <h1 class="y-head fl">
              <img class="logo" src="/image/logo.png" alt="logo">
              <span class="y-title">创作平台</span>
              </h1>
            </a>
            <div class="user fr">
              <div class="info">
                <img :src="myInfo.face">
                <span>@{{myInfo.name}}</span>
                <change-user-btn></change-user-btn>
                <a href="/passport/logout">退出</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div id="main">
        <div class="w clearfix">
          <div class="main-wrap mb-60" id="reg">
            <h2 class="title">上传画廊封面</h2>
            <div class="stage-wrap">
              <div class="reg-wrap">
                <div class="third-wrap form">
                  <div class="item clearfix">
                    <div class="tit"><label>画廊封面</label></div>
                    <div class="con">
                      <div class="box">
                        <input type="button" value="上传" class="btn-s" @click="showUpload">
                        <span class="mark">建议像素:1024*1024</span>
                      </div>
                      <div v-if="formData.cover" class="face-preview">
                        <h3>封面预览</h3>
                        <img class="cude" :src="formData.cover + '?x-oss-process=image/resize,m_fixed,h_120,w_120'">
                      </div>
                    </div>
                  </div>
                  <div class="btn-group next">
                    <input @click="submitForm" class="btn btn-24" type="button" :value="btnText">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div v-show="uploadIsShow" class="thirdLayerIn anim-scale clearfix" id="remind">
            <div class="uploadPics">
              <div class="picCont" style="width:300px;height:300px;margin:20px auto 0;padding:0;" >  
                  <div id=imgfield  style=overflow:hidden;width:100%;height:100% ></div>  
              </div>  
              <div class="picFooter">  
                <input type="file" id="fileimg" name="fileimg" style="display:none" @change="imgchange" />
                <span class="btn confirm" @click="getimg">选择图片</span>         
                <span class="btn confirm" @click="uploadImg">@{{uploadText}}</span>  
                 
              </div>             
            </div>
            <div class="img-preview">
              <h3>封面预览</h3>
              <canvas id="myCan" width="1000" height="1000"></canvas>
            </div>             
            
          </div>
        </div>
      </div>
      <ysz-footer2></ysz-footer2>
    </div>
  </body>
  <script src="/js/lib/vue.min.js"></script>
  <script src="/js/lib/element/index.js"></script>
  <script src="/js/plugin/vue-core-image-upload.js"></script>
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script type="text/javascript" src="/js/plugin/jquery.Jcrop.min.js"></script> 
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/js/service/agent.js?v=2.1.6"></script>
  <script src="/js/common.js?v=3.9.2"></script>
  <script src="/js/user/setcover.js?v=2.0.0"></script>
</html>