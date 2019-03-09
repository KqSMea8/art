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
                <form method="post" action="" name="listForm">
                <!-- start ad position list -->
                <div class="list-div" id="listDiv">
				<?php endif; ?>
                    <table cellpadding="1" cellspacing="1" class="ecsc-default-table mt20">
                        <thead>
                        <tr>
                            <th width="10%"><?php echo $this->_var['lang']['record_id']; ?></th>
                            <th width="20%"><?php echo $this->_var['lang']['title']; ?></th>
                            <th width="15%"><?php echo $this->_var['lang']['shipping_title']; ?></th>
                            <th width="20%"><?php echo $this->_var['lang']['type']['name']; ?></th>
                            <th width="20%"><?php echo $this->_var['lang']['update_time']; ?></th>
                            <th width="15%"><?php echo $this->_var['lang']['handler']; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $_from = $this->_var['transport_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                        <tr>
                            <td align="center"><?php echo $this->_var['list']['tid']; ?></td>
                            <td>
								<span onclick="javascript:listTable.edit(this, 'edit_title', <?php echo $this->_var['list']['tid']; ?>)"><?php echo htmlspecialchars($this->_var['list']['title']); ?></span>
                            </td>
                            <td>
								<?php if ($this->_var['list']['shipping_title']): ?>
                                    <?php echo htmlspecialchars($this->_var['list']['shipping_title']); ?>
                                <?php else: ?>
                                    (空)
                                <?php endif; ?>
                            </td>
                            <td>
                            	<?php if ($this->_var['list']['freight_type'] == 1): ?>
                                    <?php echo $this->_var['lang']['freight_type']['two']; ?>
                                <?php else: ?>
                                    <?php echo $this->_var['lang']['freight_type']['one']; ?>
                                    <em class="red">(
                                    <?php if ($this->_var['list']['type'] == 1): ?>
                                        <?php echo $this->_var['lang']['type']['on']; ?>
                                    <?php else: ?>
                                        <?php echo $this->_var['lang']['type']['off']; ?>
                                    <?php endif; ?>
                                    )</em>
                                <?php endif; ?>    
                            </td>
                            <td><?php echo $this->_var['list']['update_time']; ?></td>
                            <td class="ecsc-table-handle">
                              <span><a href="goods_transport.php?act=edit&tid=<?php echo $this->_var['list']['tid']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>" class="btn-green"><i class="icon icon-edit"></i><p><?php echo $this->_var['lang']['edit']; ?></p></a></span>
                              <span class="mr0"><a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['list']['tid']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['remove']; ?>" class="btn-red"><i class="icon icon-trash"></i><p><?php echo $this->_var['lang']['drop']; ?></p></a></span>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </tbody>
                        <tfoot>
                        	<tr><td colspan="10"><?php echo $this->fetch('page.dwt'); ?></td></tr>
                        </tfoot>
                    </table>
				<?php if ($this->_var['full_page']): ?>
                </div>
				<!-- end ad_position list -->
				</form>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<script type="text/javascript">
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  
  onload = function()
  {
    startCheckOrder();
  }
  
</script>
</body>
</html>
<?php endif; ?>
