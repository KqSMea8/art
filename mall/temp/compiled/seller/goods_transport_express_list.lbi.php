<ul class="transport-express" data-id="<?php echo $this->_var['id']; ?>">
	<?php $_from = $this->_var['shipping_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shipping');if (count($_from)):
    foreach ($_from AS $this->_var['shipping']):
?>
	<li>
        <input type="checkbox" name="shipping" value="<?php echo $this->_var['shipping']['shipping_id']; ?>" class="ui-checkbox" id="shipping_<?php echo $this->_var['shipping']['shipping_id']; ?>" <?php if ($this->_var['shipping']['is_selected']): ?>checked<?php endif; ?> <?php if (! $this->_var['shipping']['is_selected'] && $this->_var['shipping']['is_disabled']): ?>disabled<?php endif; ?> >
        <label for="shipping_<?php echo $this->_var['shipping']['shipping_id']; ?>" class="ui-label"><?php echo $this->_var['shipping']['shipping_name']; ?></label>
	</li>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <li>
    	<input type="checkbox" name="all" value="" id="all" class="ui-checkbox" />
        <label class="ui-label" for="all">全选</label>
    </li>
</ul>