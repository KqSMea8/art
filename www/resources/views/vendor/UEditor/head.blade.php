<?php
$userid_js=session('userid');

;
$pos = strpos($_COOKIE['userMobile'],'91916');

if($userid_js==100001||$userid_js==100000||$pos===0){
?>
<script src="/laravel-ueditor/ueditor_artzhe.config.js"></script>
<?php
}else{
?>
<script src="/laravel-ueditor/ueditor.config.js"></script>
<?php
}
?>
<script src="/laravel-ueditor/ueditor.all.min.js?v=2.0.0"></script>
{{-- 载入语言文件,根据laravel的语言设置自动载入 --}}
<script src="/laravel-ueditor/lang/zh-cn/zh-cn.js"></script>