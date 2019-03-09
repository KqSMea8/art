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
		<title>我的消息</title>
		<script src="/Public/js/lib/flexible.js"></script>
		<link rel="stylesheet" type="text/css" href="/Public/css/global.css?v=1.0.2">
		<!-- <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/> -->
		<!-- <meta name="viewport" content="width=device-width,user-scalable=no"> -->
		<link rel="stylesheet" type="text/css" href="/Public/css/user.css">
    <style type="text/css">
      ._v-container {
        top: 1.14667rem !important; 
      }
    </style>
	</head>
	<body>
		<div v-cloak class="usermsg" id="usermsg">
			<ul class="nav">
        <li v-for="(tab, index) in tabs" :class="{active:active===index}" @click="toggleActive(index)">
          <span class="cont">@{{tab.cont}}<span v-if="tab.num>0" class="num">@{{tab.num}}</span></span>
        </li>
				<!-- <li class="active">
          <span class="cont">评论<span class="num">99+</span></span>
        </li>
				<li>喜欢</li>
				<li>系统通知</li> -->
			</ul>
			<scroller :on-refresh="refresh"
			:on-infinite="infinite"
			ref="my_scroller">
			<ul v-cloak class="list">
				<li v-for="(msg, index) in list" :class="[msg.active ? 'active' : '', 'item', 'fix']" @click="addActive(msg)">
					<div class="info">
						<img class="avatar" :src="msg.faceUrl" alt="头像">
						<span class="name">@{{msg.name}}</span>
						<span class="time">@{{ msg.createTime | timeFormat }}</span>
						<span v-if="msg.showType == 3 && msg.isRepay == 'N'" :class="[msg.active? 'hide': '', 'to-reply']">回复</span>
						<span v-if="msg.showType == 3 && msg.isRepay == 'Y'" class="replyed">已回复</span>
					</div>
					<p class="desc">@{{msg.content}}</p>
					<div v-if="msg.showType == 3 && msg.isRepay == 'N'" class="reply">
						<textarea v-model="msg.replyContent" class="reply-con" cols="20" rows="4"></textarea>
						<div @click="replyCom(msg.comment_id, index)" class="btn-reply">回复</div>
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
	<script src="/Public/js/util.js?v=2.2.2"></script>
	<script src="/Public/js/plugins/dropload.min.js"></script>
	<script src="/Public/js/plugins/vue-scroller.min.js"></script>
	<script type="text/javascript" src="/Public/js/user/usermsg.js?v=1.1.1"></script>
</html>