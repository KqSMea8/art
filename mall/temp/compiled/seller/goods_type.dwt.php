<?php if ($this->_var['full_page']): ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><?php echo $this->fetch('library/seller_html_head.lbi'); ?></head>

<body>
<?php echo $this->fetch('library/seller_header.lbi'); ?>
<div class="ecsc-layout">
    <div class="site wrapper">
        <?php echo $this->fetch('library/seller_menu_left.lbi'); ?>
        <div class="ecsc-layout-right">
            <div class="main-content" id="mainContent">
                <?php echo $this->fetch('library/url_here.lbi'); ?>
				<?php echo $this->fetch('library/seller_menu_tab.lbi'); ?>
                <div class="search-info">
                    <div class="search-form">
                        <form method="post" action="javascript:searchGoodsType()" name="searchFormList">		
                            <div class="search-key">
                                <input type="text" class="text text_2" name="keyword" value="" placeholder="<?php echo $this->_var['lang']['keyword']; ?>">
                                <input type="submit" class="submit" value="<?php echo $this->_var['lang']['button_search']; ?>">
                            </div>
                        </form>
                    </div>
                </div>
				<form method="post" action="" name="listForm">
				<!-- start goods type list -->
				<div class="list-div" id="listDiv">
				<?php endif; ?>				
                <table class="ecsc-default-table">
                    <thead>
                        <tr>
                        	<th width="6%"><a href="javascript:listTable.sort('cat_id');"><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_cat_id']; ?></th>
                            <th width="15%"><?php echo $this->_var['lang']['goods_type_name']; ?></th>
                            <th width="25%"><?php echo $this->_var['lang']['attr_groups']; ?></th>
                            <th width="10%">类型分类</th>
                            <th width="12%"><?php echo $this->_var['lang']['attribute_number']; ?></th>
                            <th width="12%"><?php echo $this->_var['lang']['goods_type_status']; ?></th>
                            <th width="15%"><?php echo $this->_var['lang']['handler']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $_from = $this->_var['goods_type_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_type');if (count($_from)):
    foreach ($_from AS $this->_var['goods_type']):
?>
                    <tr class="bd-line">
                    	<td><?php echo $this->_var['goods_type']['cat_id']; ?></td>
                        <td>
                        <?php if ($this->_var['attr_set_up'] == 1): ?>
                        <span onclick="javascript:listTable.edit(this, 'edit_type_name', <?php echo $this->_var['goods_type']['cat_id']; ?>)"><?php echo $this->_var['goods_type']['cat_name']; ?></span>
                        <?php else: ?>
                        <?php echo $this->_var['goods_type']['cat_name']; ?>
                        <?php endif; ?>
                        </td>
                        <td><?php echo $this->_var['goods_type']['attr_group']; ?></td>
                        <td><?php echo $this->_var['goods_type']['gt_cat_name']; ?></td>
                        <td><?php echo $this->_var['goods_type']['attr_count']; ?></td>
                        <td><img src="images/<?php if ($this->_var['goods_type']['enabled']): ?>yes<?php else: ?>no<?php endif; ?>.png" title="<?php echo $this->_var['lang']['click']; ?>" class="pointer"/></td>
                        <td class="ecsc-table-handle tr">
                          <span><a href="attribute.php?act=list&goods_type=<?php echo $this->_var['goods_type']['cat_id']; ?>" title="<?php echo $this->_var['lang']['attribute']; ?>" class="btn-orange"><i class="icon sc_icon_see"></i><p><?php echo $this->_var['lang']['view']; ?></p></a></span>
                          <?php if ($this->_var['attr_set_up'] == 1): ?>
                          <span><a href="goods_type.php?act=edit&cat_id=<?php echo $this->_var['goods_type']['cat_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>" class="btn-green"><i class="icon icon-edit"></i><p><?php echo $this->_var['lang']['edit']; ?></p></a></span>
                          <span><a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods_type']['cat_id']; ?>, '<?php echo $this->_var['lang']['remove_confirm']; ?>')" title="<?php echo $this->_var['lang']['drop']; ?>" class="btn-red"><i class="icon icon-trash"></i><p><?php echo $this->_var['lang']['drop']; ?></p></a></span>
                          <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="20">
                            <?php echo $this->fetch('page.dwt'); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
				<?php if ($this->_var['full_page']): ?>
				</div>
				</form>				
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<script type="text/javascript" language="JavaScript">
	listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
	listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
	
	<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	
	function searchGoodsType()
	{
		listTable.filter['keyword'] = Utils.trim(document.forms['searchFormList'].elements['keyword'].value);
		listTable.filter['page'] = 1;
	
		listTable.loadList();
	}
	
</script>

</body>
</html>
<?php endif; ?>