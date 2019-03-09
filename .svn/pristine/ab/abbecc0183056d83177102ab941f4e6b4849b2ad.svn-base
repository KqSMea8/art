<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script type="text/javascript" src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
	<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.1.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdn.bootcss.com/Swiper/3.3.1/css/swiper.min.css"/>
	<script type="text/javascript" src="//cdn.bootcss.com/Swiper/3.3.1/js/swiper.min.js"></script>
	<script type="text/javascript" src="//cdn.bootcss.com/jquery-json/2.4.0/jquery.json.min.js"></script>
	<script type="text/javascript" src="//lic.oss-cn-shenzhen.aliyuncs.com/plugin/layer/mobile/layer.js"></script>
	<script type="text/javascript" src="/v2/data/assets/js/common.js"></script>
	<link rel="stylesheet" href="/v2/themes/default/statics/css/ectouch.css" />
	<script type="text/javascript" src="/v2/themes/default/js/ectouch.js"></script>
	<script type="text/javascript" src="/v2/themes/default/statics/js/ectouch.js"></script>
	<script type="text/javascript" >var tpl = '/v2/themes/default';</script>
	@yield('loadSource')
	@section('title')
		<title>简单生活</title>
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="author" content="">
	@show
</head>
<body>
	<div class="con">
		@section('header')
			@include('public.header')
		@show

		@yield('main')
	</div>

	@yield('footer_script')

	<script type="text/javascript">
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-90554870-1', 'auto');
		ga('send', 'pageview');
	</script>

</body>
</html>
