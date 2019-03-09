<?php if ($this->_var['child_category']): ?>
<select onchange="get_select_category(this.value,<?php echo empty($this->_var['cat_level']) ? '0' : $this->_var['cat_level']; ?>,'<?php echo empty($this->_var['select_jsId']) ? 'cat_parent_id' : $this->_var['select_jsId']; ?>',<?php echo empty($this->_var['type']) ? '0' : $this->_var['type']; ?>, 1)" cat-level="<?php echo $this->_var['cat_level']; ?>" cat-type="select" class="select">	
	<?php if ($this->_var['cat_level'] == 1): ?>
	<option value="0" <?php if ($this->_var['cat_info']['parent_id'] == 0): ?>selected="selected"<?php endif; ?>>顶级分类</option>
	<?php else: ?>
	<option value="0">请选择分类</option>
	<?php endif; ?>
	<?php $_from = $this->_var['child_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['child']['iteration']++;
?>
	<option value="<?php echo $this->_var['child']['cat_id']; ?>" <?php if ($this->_var['child']['cat_id'] == $this->_var['child_cat_id']): ?>selected="selected"<?php endif; ?>><?php echo $this->_var['child']['cat_name']; ?></option>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</select>
<?php endif; ?>