<ul class="area-province" data-id="<?php echo $this->_var['id']; ?>">
	<?php $_from = $this->_var['area_map']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
	<li>
		<input type="checkbox" name="province" value="<?php echo $this->_var['province']['region_id']; ?>" id="province_<?php echo $this->_var['province']['region_id']; ?>" class="ui-checkbox" <?php if ($this->_var['province']['is_selected']): ?>checked<?php endif; ?> <?php if (! $this->_var['province']['is_selected'] && $this->_var['province']['is_disabled']): ?>disabled<?php endif; ?> >
		<label class="ui-label" for="province_<?php echo $this->_var['province']['region_id']; ?>">
        	<span><?php echo $this->_var['province']['region_name']; ?></span>
			<span class="green <?php if (! $this->_var['province']['child_num']): ?>hide<?php endif; ?>" data-role="child_num">(<?php echo $this->_var['province']['child_num']; ?>)</span>
		</label>
        
		<i class="icon icon-angle-down"></i>
		<ul class="area-city hide">
			<?php $_from = $this->_var['province']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
			<li>
				<input type="checkbox" name="city" value="<?php echo $this->_var['city']['region_id']; ?>" id="city_<?php echo $this->_var['city']['region_id']; ?>" class="ui-checkbox" <?php if ($this->_var['city']['is_selected']): ?>checked<?php endif; ?> <?php if ($this->_var['city']['is_disabled']): ?>disabled<?php endif; ?> >
				<label class="ui-label" for="city_<?php echo $this->_var['city']['region_id']; ?>">
                	<span><?php echo $this->_var['city']['region_name']; ?></span>
				</label>				
			</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
	</li>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <li>
    	<input type="checkbox" name="all" value="" id="all" class="ui-checkbox" />
        <label class="ui-label" for="all">全选</label>
    </li>
</ul>