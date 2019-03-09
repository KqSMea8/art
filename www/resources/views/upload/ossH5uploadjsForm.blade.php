<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>OSS web直传</title>
	<link rel="stylesheet" type="text/css" href="/js/oss-h5-upload-js/style.css"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>

<h2><br>
</h2>
<h4>您所选择的文件列表：
  <input name="upload_to_tag" type="hidden" id="upload_to_tag" value="<?php echo $to_tag;?>" title="上传到的标签">
</h4>
<div id="ossfile">你的浏览器不支持flash,Silverlight或者HTML5！</div>

<br/>


<div id="container">
	<a id="selectfiles" href="javascript:void(0);" class='btn'>选择文件</a>
	<a id="postfiles" href="javascript:void(0);" class='btn'>开始上传</a>
</div>

<pre id="console"></pre>

<p>&nbsp;</p>

</body>
<script type="text/javascript" src="/js/oss-h5-upload-js/lib/plupload-2.1.2/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/js/oss-h5-upload-js/upload.js"></script>
</html>
