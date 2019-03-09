<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="艺术者">
    <meta name="description" content="专注手绘艺术，遇见你的品味">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <!-- <meta name="csrf-token" content="3wOniT3eM1AZx48w3gR6EawM0lDrcQwDSSh1xOOw"> -->
    <meta content="telephone=no,email=no" name="format-detection">
    <title>我的</title>
    <script src="/Public/js/lib/flexible.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.1.1">
    <!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/> -->
    <!-- <meta name="viewport" content="width=devi ce-width,user-scalable=no"> -->
    <link rel="stylesheet" type="text/css" href="/Public/css/user.css">
    <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
  	<script type="text/javascript" charset="utf-8">
  		wx.config({!! $wechat_json !!});
  	</script>
  </head> 
  <body>
    <div v-cloak id="user">
      <div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
      <div id="header">
        <div class="userinfo">
          <a href="/user/profile">
            <img class="avatar" :src="userInfo.faceUrl">
            <div class="detail">
              <span class="nickname">@{{userInfo.name}}</span>
              <!-- 艺术家标识 -->
              <div v-if="userInfo.isArtist == '1'" class="artist">
                <i class="icons icon-artist"></i>
                <span>艺术家</span>
              </div>
              <span class="desc ellipsis">@{{userInfo.motto}}</span>
              <a href="/user/setting">
                <i class="icons icon-set"></i>
              </a>
            </div>
            <!-- 艺术家邀请码 -->
            <div v-if="userInfo.isArtist == '1'" class="invite">
              <span @click="showInvite">邀请码</span>
              <!-- <i class="icons icon-question"></i> -->
              <!-- <i class="icons icon-arrow"></i> -->
            </div>
            <!-- 欣赏者申请认证 -->
            <div v-if="userInfo.isArtist == '-1'" class="appeal">
              <a @click="showDownload('如需成为认证艺术家，请在APP中完成认证流程。')" href="javascript:;" class="btn-appeal">@{{applyInfo[userInfo.applyStatus]}}</a>
            </div>
            <!-- 欣赏者喜欢 关注 消息 -->
            <!-- <div v-if="userInfo.isArtist == '-1'" class="my-bar-list">
              <a class="my-bar-item" href="/collect/index">
                <i class="icons icon-like"></i>
                <span class="my-bar-label">我的喜欢</span>
              </a>
              <a class="my-bar-item" href="/follow/myfollows">
                <i class="icons icon-follow"></i>
                <span class="my-bar-label">我的关注</span>
              </a>
              <a class="my-bar-item" href="/message/index">
                <i class="icons icon-msg"></i>
                <span class="my-bar-label">我的消息</span>
              </a>
            </div> -->
          </a>
        </div>
      </div>
      <div id="main">
        <!-- 欣赏者内容 -->
        <!-- 无动态欣赏者 -->
        <!-- <div v-if="userInfo.isArtist == '-1' && !hasUserMsg" class="go-enjoy">
          <a href="/gallery/index" class="btn btn-go-enjoy">去欣赏作品</a>
          <div class="go-enjoy-info">你有一双发现美的眼睛，<br>快去为你喜欢的作品点个赞。</div>
        </div> -->
        <!-- 有动态欣赏者 -->
        <!-- <div v-if="userInfo.isArtist == '-1' && hasUserMsg" class="trend">
          <ul class="list">
            <li class="item" v-for="msgItem in userMsg">
              <div class="info">
                <img class="avatar" src="/Public/image/user/avatar.png" :src="msgItem.faceUrl">
                <span class="name">@{{msgItem.name}}</span>
                <span class="time">@{{ msgItem.createTime | timeFormat }}</span>
              </div>
              <p class="desc">@{{msgItem.content}}</p>
            </li>
          </ul>
          <div v-if="hasMoreMsg" class="more">
            <a href="/message/index">
              <span>查看更多</span>
              <i class="icons icon-arrow-two"></i>
            </a>
          </div>
        </div> -->
        <!-- 艺术家内容 -->
        <ul class="artist-content">
          <li v-if="userInfo.isArtist == '1'" class="item">
            <a :href="'/gallery/detail/' + userInfo.artist">
              <i class="icons icon-gallery"></i>
              <span class="my">我的画廊</span>
              <i class="icons icon-arrow"></i>
              <span class="num">@{{userInfo.viewTotal}}人浏览</span>
            </a>
          </li>
          <li @click="showDownload('为提高艺术创作质量，请在APP中上传作品。')" v-if="userInfo.isArtist == '1'" class="item">
            <a href="javascript:;">
              <i class="icons icon-artwork"></i>
              <span class="my">上传作品</span>
              <i class="icons icon-arrow"></i>
              <span class="num">@{{userInfo.artTotal}}幅</span>
            </a>
          </li>
          <li v-if="userInfo.isArtist == '1'" class="item">
            <a href="/invite/index">
              <i class="icons icon-invite"></i>
              <span class="my">我的邀请</span>
              <i class="icons icon-arrow"></i>
              <span class="num">已邀请@{{userInfo.inviteTotal}}个</span>
            </a>
          </li>
          <li class="item" style="margin-bottom: 0;">
            <a href="/message/index">
              <i class="icons icon-msg"></i>
              <span class="my">我的消息</span>
              <i class="icons icon-arrow"></i>
              <span class="num">@{{userInfo.unreadMessageTotal}}个未读</span>
            </a>
          </li>
          <li class="item">
            <a href="/collect/index">
              <i class="icons icon-like"></i>
              <span class="my">我的喜欢</span>
              <i class="icons icon-arrow"></i>
              <span class="num">@{{userInfo.likeTotal}}幅</span>
            </a>
          </li>
          <li v-if="userInfo.isArtist == '1'" class="item">
            <a href="/follow/myfans">
              <i class="icons icon-fans"></i>
              <span class="my">我的粉丝</span>
              <i class="icons icon-arrow"></i>
              <span class="num">@{{userInfo.followerTotal}}个</span>
            </a>
          </li>
          <li class="item">
            <a href="/follow/myfollows">
              <i class="icons icon-follow"></i>
              <span class="my">我的关注</span>
              <i class="icons icon-arrow"></i>
              <span class="num">@{{userInfo.followTotal}}个</span>
            </a>
          </li>
          <li class="item">
            <a href="/user/feedback">
              <i class="icons icon-feedback"></i>
              <span class="my">我要反馈</span>
              <i class="icons icon-arrow"></i>
              <span class="num"></span>
            </a>
          </li>
        </ul>
      </div>
      <!-- <div v-if="userInfo.isArtist == '1'" id="add">
        <div @click="showDownload('为提高艺术创作质量，请在APP中上传作品。')" class="btn-add icons icon-add-l"></div>
        <div v-if="userInfo.artTotal == '0'" class="publish fadeInAndOut">
          点击发布你的第一个作品,<br> 艺术圈都在等你更新呢~
        </div>
      </div> -->
      <!-- 没有上传过作品时显示 -->
      <!-- <div v-if="userInfo.isArtist == '1' && userInfo.artTotal == '0'" class="upload fadeInAndOut">上传3幅作品后，你将出现在“画廊”栏目</div> -->
      <!-- 弹窗 -->
      <div v-cloak v-show="boxIsShow" class="layerbox layermshow" id="j_layerShow">
        <div @click="hideBox" class="layershade"></div>
        <div class="layermain">
          <div v-show="downloadIsShow" class="thirdLayerIn anim-scale download-box" id="download-app">
            <h3 class="title">艺术者提示 <i @click="hideBox" class="icons icon-close"></i></h3>
            <div class="content">
              @{{ boxMsg }}
            </div>
            <div class="btn-group">
              <a class="btn2 btn-down" href="//a.app.qq.com/o/simple.jsp?pkgname=com.artzhe">下载艺术者APP</a>
            </div>
          </div>
          <div v-show="inviteIsShow" class="thirdLayerIn anim-scale invite-box download-box">
            <h3 class="title">邀请码 <i @click="hideBox" class="icons icon-close"></i></h3>
            <div class="content">
              您的专属邀请码是<br>
              <div class="f36" id="invite-code">@{{userInfo.inviteCode}}</div>
              赶快邀请其他艺术家入驻吧~<br>
              <p class="f24">(24小时更换一次)</p>
            </div>
            <div class="btn-group">
              <input type="button" :data-clipboard-text="userInfo.inviteCode" id="copy-btn" class="btn2" value="复制邀请码">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="tab-bar">
      <nav class="tab-bar-list">
        <a class="tab-bar-item" href="/index/recommend">
          <i class="icons icon-recommend"></i>
          <span class="tab-label">推荐</span>
        </a>
        <a class="tab-bar-item" href="/gallery/index">
          <i class="icons icon-gallery"></i>
          <span class="tab-label">画廊</span>
        </a>
        <a class="tab-bar-item active" href="/user/index">
          <i class="icons icon-user"></i>
          <span class="tab-label">我</span>
        </a>
      </nav>
    </div>
    <script src="/Public/js/lib/vue.min.js"></script>
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
    <script src="/Public/js/service/agent.js?v=2.0.0"></script>
    <script src="/Public/js/plugins/clipboard.min.js"></script>
    <script src="/Public/js/lib/jweixin-1.0.0.js"></script>
    <script src="/Public/js/util.js?v=2.2.0"></script>
    <script type="text/javascript" src="/Public/js/user/user.js?v=1.1.0"></script>
    <script type="text/javascript">
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-96560910-1', 'auto');
      ga('send', 'pageview');
    </script>
  </body>
</html>