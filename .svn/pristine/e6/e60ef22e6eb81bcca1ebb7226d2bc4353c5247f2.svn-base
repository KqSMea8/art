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
		<title>我的粉丝</title>
		<script src="/Public/js/lib/flexible.js"></script>
		<link rel="stylesheet" type="text/css" href="/Public/css/global.css">
		<!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/> -->
		<!-- <meta name="viewport" content="width=device-width,user-scalable=no"> -->
		<link rel="stylesheet" type="text/css" href="/Public/css/user.css?v=0.0.1">
	</head>
	<body>
		<div class="user-fans" id="user-fans">
			<div v-show="isLoading" id="loading">
        <img src="/Public/image/loading.gif?v=0.0.1">
      </div>
			<div class="holder" v-show="!hasFans">
				<img  src="/Public/image/user/holder.png" alt="">
				<p>多多发表作品，粉丝就会蜂拥而来哦~</p>
			</div>
			<scroller :on-refresh="refresh"
			:on-infinite="infinite"
			ref="my_scroller">
			<ul v-cloak class="fans-list" v-if="hasFans">
				<li class="artist-info" v-for="item in list" :id="item.id">
					<img class="avatar" :src="item.faceUrl">
					<div class="detail">
						<span class="nickname">@{{ item.name }}</span>
						<!--<i class="icons icon-artist"></i>-->
						<span class="desc">@{{ item.motto }}</span>
					</div>
				</li>
			</ul>
			</scroller>
		</div>
	</body>
	<script src="/Public/js/lib/vue.min.js"></script>
	<script src="//cdn.bootcss.com/vue-resource/1.2.1/vue-resource.min.js"></script>
	<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <script src="//cdn.bootcss.com/blueimp-md5/1.1.0/js/md5.min.js"></script>
  <script src="/Public/js/service/agent.js?v=2.0.0"></script>
	<script src="/Public/js/util.js"></script>
	<script src="/Public/js/plugins/vue-scroller.min.js"></script>
	<script type="text/javascript" src="/Public/js/user/userfans.js?v=0.0.1"></script>
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96560910-1', 'auto');
    ga('send', 'pageview');
  </script>
</html>