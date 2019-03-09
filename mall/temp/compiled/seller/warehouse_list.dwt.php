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
                <div class="list-div" id="listDiv">
                <?php endif; ?>
                  <table class="ecsc-default-table mt20">	
                    <thead>
                    <tr>
                      <th width="10%">编号</th>
                      <th width="40%">仓库名称</th>
                      <th width="40%">所在层级</th>
                      <th width="10%"><?php echo $this->_var['lang']['handler']; ?></th>
                    </tr>
					</thead>
				  <tbody>
				  <?php $_from = $this->_var['region_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['area_name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['area_name']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['area_name']['iteration']++;
?>
				  <tr>
                      <td><?php echo $this->_foreach['area_name']['iteration']; ?></td>
                      <td>
                       <?php if ($this->_var['priv_ru'] == 1 && $this->_var['region_type'] == 0): ?>    
                       <span onclick="listTable.edit(this, 'edit_area_name', '<?php echo $this->_var['list']['region_id']; ?>'); return false;"><?php echo htmlspecialchars($this->_var['list']['region_name']); ?></span>
                       <?php else: ?>
                       <?php echo htmlspecialchars($this->_var['list']['region_name']); ?>
                       <?php endif; ?>					  
					  </td>  
                      <td><?php echo $this->_var['area_here']; ?></td>
                      <td class="ecsc-table-handle<?php if ($this->_var['list']['regionId'] > 0 && $this->_var['freight_model'] == 1): ?> tr<?php endif; ?>">
                        <?php if ($this->_var['list']['region_child']): ?>
                            <?php if ($this->_var['list']['child']): ?>		
                                <?php if ($this->_var['region_type'] < 4): ?>
                                    <span<?php if ($this->_var['list']['regionId'] <= 0 || $this->_var['freight_model'] != 1): ?> class="mr0"<?php endif; ?>><a href="warehouse.php?act=list&type=<?php echo $this->_var['list']['region_type+1']; ?>&pid=<?php echo $this->_var['list']['region_id']; ?>&regionId=<?php echo $this->_var['list']['regionId']; ?>" title="<?php echo $this->_var['lang']['manage_area']; ?>" class="btn-orange"><i class="icon sc_icon_see"></i><p><?php echo $this->_var['lang']['manage_area']; ?></p></a></span>
                                <?php endif; ?>
                            <?php endif; ?>   
                        <?php else: ?>
                        <span class="mr0"><a href="javascript:;" class="btn-orange"><i class="icon sc_icon_see"></i><p>无</p></a></span>    
                        <?php endif; ?>
					  </td>
				  </tr>
				  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				  </tbody>
                </table>
                <?php if ($this->_var['full_page']): ?>
                </div>
        	</div>
    	</div>
	</div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>

<script type="text/javascript">
<!--

onload = function() {
  
  // 开始检查订单
  startCheckOrder();
}

/**
 * 新建区域
 */
function add_area()
{
    var region_name = Utils.trim(document.forms['theForm'].elements['region_name'].value);
    var region_type = Utils.trim(document.forms['theForm'].elements['region_type'].value);
    var parent_id   = Utils.trim(document.forms['theForm'].elements['parent_id'].value);
	if(document.forms['theForm'].elements['regionId']){
		var regionId   = Utils.trim(document.forms['theForm'].elements['regionId'].value);
	}else{
		var regionId = 0;
	}

    if (region_name.length == 0)
    {
        alert(region_name_empty);
    }
    else
    {
      Ajax.call('warehouse.php?is_ajax=1&act=add_area',
        'parent_id=' + parent_id + '&region_name=' + region_name + '&region_type=' + region_type + '&regionId=' + regionId,
        listTable.listCallback, 'POST', 'JSON');
    }

    return false;
}

//-->
</script>

</body>
</html>
<?php endif; ?>