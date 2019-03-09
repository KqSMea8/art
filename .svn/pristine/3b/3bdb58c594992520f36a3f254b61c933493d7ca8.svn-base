<?php if ($this->_var['transport_express']): ?>
<table class="ecsc-default-table ecsc-table-seller mb10">
	<tr>
		<td width="50%" class="tl">快递名称</td>
		<td width="20%" class="tc">额外运费（元）</td>
		<td width="30%" class="tc">操作</td>
	</tr>
	<?php $_from = $this->_var['transport_express']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'express');if (count($_from)):
    foreach ($_from AS $this->_var['express']):
?>
	<tr>
		<td width="50%" class="tl"><?php if ($this->_var['express']['express_list']): ?><?php echo $this->_var['express']['express_list']; ?><?php else: ?>未指定快递<?php endif; ?></td>
		<td width="20%">
			<input type="hidden" name="id" value="<?php echo $this->_var['express']['id']; ?>" />
			<input type="text" name="shipping_fee[<?php echo $this->_var['express']['id']; ?>]" class="text w80 tc fn" onblur="insertexpress(this.value,<?php echo $this->_var['express']['id']; ?>);" autocomplete="off" value="<?php echo $this->_var['express']['shipping_fee']; ?>" />
		</td>
		<td width="30%">
			<input type="button" value="编辑" class="sc-btn btn30 sc-blueBg-btn fn mr10" data-role="edit_express" ectype="edit_express">
			<input type="button" value="删除" class="sc-btn btn30 sc-blueBg-btn fn mr10" data-role="drop_express" ectype="drop_express">
		</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<script type="text/javascript">
function insertexpress(fee,id){
	Ajax.call('goods_transport.php','act=edit_express_fee&fee='+fee+'&id='+id,'','POST','JSON');
}
</script>
<?php endif; ?>
