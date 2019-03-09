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
				<!-- start payment list -->
                <div class="list-div" id="listDiv">
                <table class="ecsc-default-table mt20">
                	<thead>
                        <tr>
                            <th width="12%" class="tl pl10"><?php echo $this->_var['lang']['shipping_name']; ?></th>
                            <th width="35%" class="tl pl10"><?php echo $this->_var['lang']['shipping_desc']; ?></th>
                            <th width="6%"><?php echo $this->_var['lang']['insure']; ?></th>
                            <th width="6%"><?php echo $this->_var['lang']['support_cod']; ?></th>
							<th width="10%">支持快递鸟打印</th>
                            <th width="5%"><?php echo $this->_var['lang']['sort_order']; ?></th>
                            <th width="15%"><?php echo $this->_var['lang']['handler']; ?></th>
                        </tr>
                    </thead>
					<tbody>
                    <?php $_from = $this->_var['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'module');if (count($_from)):
    foreach ($_from AS $this->_var['module']):
?>
                    <?php if (( $this->_var['seller_shopinfo']['ru_id'] > 0 && $this->_var['module']['install'] == 1 && $this->_var['module']['code'] != 'cac' ) || $this->_var['seller_shopinfo']['ru_id'] == 0): ?>
                        <tr>
                            <td class="tl pl10"><?php echo $this->_var['module']['name']; ?></td>
                            <td class="tl pl10"><?php echo $this->_var['module']['desc']; ?></td>
                            <td align="center"><?php echo $this->_var['module']['insure_fee']; ?></td>
                            <td align='center'><?php if ($this->_var['module']['cod'] == 1): ?><?php echo $this->_var['lang']['yes']; ?><?php else: ?><?php echo $this->_var['lang']['no']; ?><?php endif; ?></td>
							<td align="center"><?php if ($this->_var['module']['kdniao_print'] == 1): ?>是<?php else: ?>否<?php endif; ?></td>
                            <td align="center" valign="top"> <?php if ($this->_var['module']['install'] == 1): ?> <span><?php echo $this->_var['module']['shipping_order']; ?></span> <?php else: ?> &nbsp; <?php endif; ?> </td>
                            <td align="center" nowrap="true">
                                <?php if ($this->_var['module']['install'] == 1): ?>
                                    <a href="shipping.php?act=edit_print_template&shipping=<?php echo $this->_var['module']['id']; ?>"><?php echo $this->_var['lang']['shipping_print_edit']; ?></a>
                                <?php else: ?>
                                    未启用
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php endforeach; else: ?>
                    	<tr><td class="no-records" colspan="11"><?php echo $this->_var['lang']['no_records']; ?>&nbsp;&nbsp;请您完善<a href="index.php?act=merchants_first">店铺基本信息设置</a></td></tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
               		</tbody>
                </table>
        		</div>
        	</div>
    	</div>
	</div>
</div>
<!-- end payment list -->

<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<script type="Text/Javascript" language="JavaScript">
<!--


onload = function()
{
    // 开始检查订单
    startCheckOrder();
}

//-->
</script>
</body>
</html>