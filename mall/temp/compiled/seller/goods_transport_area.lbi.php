<?php if ($this->_var['transport_area']): ?>
<table class="ecsc-default-table ecsc-table-seller mb10">
	<tr>
		<td width="50%" class="tl">运送到</td>
		<td width="20%" class="tc">运费（元）</td>
		<td width="30%" class="tc">操作</td>
	</tr>
	<?php $_from = $this->_var['transport_area']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'area');if (count($_from)):
    foreach ($_from AS $this->_var['area']):
?>
	<tr>
		<td width="50%" class="tl">
			<?php if ($this->_var['area']['area_map']): ?>
			<?php $_from = $this->_var['area']['area_map']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'map');if (count($_from)):
    foreach ($_from AS $this->_var['map']):
?>
			<p><strong><?php echo $this->_var['map']['top_area']; ?>：</strong><?php echo $this->_var['map']['area_list']; ?></p>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			<?php else: ?>
			未指定地区
			<?php endif; ?>		
		</td>
		<td width="20%">
			<input type="hidden" name="id" value="<?php echo $this->_var['area']['id']; ?>" />
			<input type="text" name="sprice[<?php echo $this->_var['area']['id']; ?>]" class="text w80 tc fn" onblur="insertfee(this.value,<?php echo $this->_var['area']['id']; ?>);" autocomplete="off" value="<?php echo $this->_var['area']['sprice']; ?>" />
		</td>
		<td width="30%" align="center">
			<input type="button" value="编辑" class="sc-btn btn30 sc-blueBg-btn fn mr10" data-role="edit_area" ectype="edit_area">
			<input type="button" value="删除" class="sc-btn btn30 sc-blueBg-btn fn mr0" data-role="drop_area" ectype="drop_area">
		</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</table>
<script type="text/javascript">
function insertfee(fee,id){
	Ajax.call('goods_transport.php','act=edit_area_fee&fee='+fee+'&id='+id,'','POST','JSON');
}
</script>
<?php endif; ?>
