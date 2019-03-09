<div class="ecsc-head-layout">
	<div class="wrapper">
    	<div class="admin-logo">
        	<a href="./">
                <div class="t">
                    <?php if ($this->_var['seller_logo']): ?>
                    <img src="<?php echo $this->_var['seller_logo']; ?>" class="logo"/>
                    <?php else: ?>
                    <img src="images/logo.png" class="logo"/>
                    <?php endif; ?>
                    <h1>商家中心</h1>
                </div>
                <div class="en"><img src="images/en.png" /></div>
            </a>
        </div>
        <div class="ecsc-nav">
        	<ul class="ecsc-nav-ul">
            	<li <?php if (! $this->_var['menu_select']['action']): ?>class="current"<?php endif; ?>><a href="./">首页</a><div class="arrow"></div></li>
                <?php $_from = $this->_var['seller_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'menu');$this->_foreach['menu'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menu']['total'] > 0):
    foreach ($_from AS $this->_var['menu']):
        $this->_foreach['menu']['iteration']++;
?>
                <?php if ($this->_var['menu']['url']): ?>
                    <li <?php if ($this->_var['menu']['action'] == $this->_var['menu_select']['action']): ?>class="current"<?php endif; ?>><a href="<?php echo $this->_var['menu']['url']; ?>"><?php echo $this->_var['menu']['label']; ?></a><div class="arrow"></div></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <div class="ecsc-admin">
        	<div class="avatar">
				<form action="index.php" method="post" enctype="multipart/form-data" runat="server">
					<input type="hidden" name="act" value="upload_store_img">
					<input type="file" name="img">
				</form>
				<a href="javascript:void(0);"><img src="<?php if ($this->_var['admin_info']['admin_user_img']): ?>../<?php echo $this->_var['admin_info']['admin_user_img']; ?><?php else: ?>images/tx.png<?php endif; ?>"></a>
			</div>
            <dl>
            	<dt>
                	<span><?php echo $_SESSION['seller_name']; ?></span>
                    <?php if ($this->_var['privilege_seller'] == 1): ?><a href="privilege.php?act=modif" class="modif"><i class="icon icon-edit"></i></a><?php endif; ?>
                </dt>
                <dd>
                    <span><i class="sc_icon sc_icon_seller"></i><a class="navbar-brand" href="<?php if ($this->_var['head_shop_url']): ?><?php echo $this->_var['head_shop_url']; ?><?php else: ?>../merchants_store.php?merchant_id=<?php echo $this->_var['ru_id']; ?><?php endif; ?>" target="_blank">店铺</a></span>
                    <span><i class="sc_icon sc_icon_set"></i><a class="navbar-brand navbar-right" href="index.php?act=clear_cache">清缓存</a></span>
                    <span><i class="sc_icon sc_icon_out"></i><a class="navbar-brand navbar-right" href="privilege.php?act=logout">退出</a></span>
                </dd>
            </dl>
        </div>
    </div>
</div>
<script type="text/javascript">
//上传管理员头像
$("[runat='server'] input[name='img']").change(function(){
	var actionUrl = "index.php?act=upload_store_img";
	$("[runat='server']").ajaxSubmit({
		type: "POST",
		dataType: "json",
		url: actionUrl,
		data: {"action": "TemporaryImage"},
		success: function (data) {
			if (data.error == "0") {
				alert(data.massege);
			} else if (data.error == "1") {
				$(".avatar img").attr("src", data.content);
			}
		},
		async: true
	});
});
</script>