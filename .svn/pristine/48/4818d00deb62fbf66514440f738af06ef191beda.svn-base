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
                <!--start-->
                <script>
                var thisfile = '<?php echo $this->_var['thisfile']; ?>';
                var deleteck = '<?php echo $this->_var['lang']['deleteck']; ?>';
                var deleteid = '<?php echo $this->_var['lang']['delete']; ?>';
                </script>
                <?php if (! $this->_var['crons_enable']): ?>
                <ul style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
                  <li style="border: 1px solid #CC0000; background: #FFFFCC; padding: 10px; margin-bottom: 5px;" ><?php echo $this->_var['lang']['enable_notice']; ?></li>
                </ul>
                <?php endif; ?>
                <div class="search-info">
                <div class="search-form">
                <form action="<?php echo $this->_var['thisfile']; ?>" method="post">
                    <div class="search-key">
                        <input name="goods_name" type="text" size="25" class="text text_2" placeholder="<?php echo $this->_var['lang']['goods_name']; ?>" />
                        <input type="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" class="submit" />
                        <input type="hidden" name="act" value="list" />
                    </div>
                </form>
                </div>
                </div>
                <form method="post" action="" name="listForm">
                <div class="list-div" id="listDiv">
                    <?php endif; ?>
                    <table class="ecsc-default-table">
                        <thead>
                        <tr>
                          <th width="10%"><div class="first_all"><input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" id="all" class="ui-checkbox" /><label class="ui-label" for="all"><?php echo $this->_var['lang']['id']; ?></label></div></th>
                          <th width="50%"><?php echo $this->_var['lang']['goods_name']; ?></th>
                          <th width="15%"><?php echo $this->_var['lang']['starttime']; ?></th>
                          <th width="15%"><?php echo $this->_var['lang']['endtime']; ?></th>
                          <th width="10%"><?php echo $this->_var['lang']['handler']; ?></th>
                        </tr>
                        </thead>
                        <?php $_from = $this->_var['goodsdb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
                        <tr class="bd-line">
                          <td class="first_td_checkbox"><div class="first_all"><input name="checkboxes[]" type="checkbox" value="<?php echo $this->_var['val']['goods_id']; ?>" id="goods_<?php echo $this->_var['val']['goods_id']; ?>" class="ui-checkbox"/><label for="goods_<?php echo $this->_var['val']['goods_id']; ?>" class="ui-label"><?php echo $this->_var['val']['goods_id']; ?></label></div></td>
                          <td class="tl"><a href="../goods.php?id=<?php echo $this->_var['val']['goods_id']; ?>" target="_blank"><span class="activity_name w490"><?php echo $this->_var['val']['goods_name']; ?></span></a></td>
                          <td align="center">
                            <span onclick="listTable.edit(this, 'edit_starttime', '<?php echo $this->_var['val']['goods_id']; ?>');"><!-- <?php if ($this->_var['val']['starttime']): ?> --><?php echo $this->_var['val']['starttime']; ?><!-- <?php else: ?> -->0000-00-00<!-- <?php endif; ?> --></span>
                          </td>
                          <td align="center">
                            <span onclick="listTable.edit(this, 'edit_endtime', '<?php echo $this->_var['val']['goods_id']; ?>');"><!-- <?php if ($this->_var['val']['endtime']): ?> --><?php echo $this->_var['val']['endtime']; ?><!-- <?php else: ?> -->0000-00-00<!-- <?php endif; ?> --></span>
                          </td>
                          <td align="center">
                              <span id="del<?php echo $this->_var['val']['goods_id']; ?>">
                              <?php if ($this->_var['val']['endtime'] || $this->_var['val']['starttime']): ?>
                                <a href="<?php echo $this->_var['thisfile']; ?>?goods_id=<?php echo $this->_var['val']['goods_id']; ?>&act=del" onclick="return confirm('<?php echo $this->_var['lang']['deleteck']; ?>');"><?php echo $this->_var['lang']['delete']; ?></a>
                              <?php else: ?>
                                -
                              <?php endif; ?>
                              </span>
                          </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td class="no-records" colspan="5"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="td_border">
                                    <div class="shenhe">
                                        <input type="hidden" name="act" value="" />
                                        <div class="text_time mr10" id="text_time_start">
                                        	<input type="text" name="date" value='0000-00-00' id="start_time_id" class="text" readonly autocomplete="off" />
                                        </div>
                                        <input type="button" id="btnSubmit1" value="<?php echo $this->_var['lang']['button_start']; ?>" disabled="true" class="sc-btn btn_disabled" onClick="return validate('batch_start')" />
                                        <input type="button" id="btnSubmit2" value="<?php echo $this->_var['lang']['button_end']; ?>" disabled="true" class="sc-btn btn_disabled" onClick="return validate('batch_end')" />
                                    </div>  
                                </td>
                            </tr>
                            <tr><td colspan="5"><?php echo $this->fetch('page.dwt'); ?></td></tr>
                        </tfoot>
                    </table>
                    <?php if ($this->_var['full_page']): ?>
                </div>
                </form>	
                <!--end-->
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<!--start-->
<script type="Text/Javascript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<!--

onload = function()
{
  // 开始检查订单
  startCheckOrder();
}


function validate(name)
{
  if(document.listForm.elements["date"].value == "0000-00-00")
  {
    alert('<?php echo $this->_var['lang']['select_time']; ?>');
    return;	
  }
  else
  {
    document.listForm.act.value=name;
    document.listForm.submit();
  }
}

//时间选择
var opts1 = {
	'targetId':'start_time_id',
	'triggerId':['start_time_id'],
	'alignId':'text_time_start',
	'format':'-',
	'hms':'off'
}
xvDate(opts1);
//-->
</script>
<!--end-->
</body>
</html>
<?php endif; ?>