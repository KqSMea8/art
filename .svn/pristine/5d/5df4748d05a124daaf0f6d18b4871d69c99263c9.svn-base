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
                        <form method="get" action="javascript:searchGoodsList()" name="searchFormList">		
                            <div class="search-key">
                                    <input type="text" class="text" name="keyword" value="" placeholder="商品ID/商品关键字">
                                <input type="submit" class="submit" value="<?php echo $this->_var['lang']['button_search']; ?>">
                                <input type="hidden" name="act" value="store_goods_online">
                                <input type="hidden" name="op" value="index">
                                <input type="hidden" name="cat_id" id="cat_id" value="0"/>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- 商品列表 -->
                <form method="post" action="" name="listForm">
                  <!-- start goods list -->
                  <div class="list-div" id="listDiv">
                <?php endif; ?>
                <table class="ecsc-default-table">
                  <thead>
                      <tr>
                        <th width="10%">
                            <div class="first_all">
                                <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" id="all" class="ui-checkbox" />
                                <label for="all" class="ui-label"><a href="javascript:listTable.sort('goods_id');"><?php echo $this->_var['lang']['record_id']; ?></a></label>
                                <?php echo $this->_var['sort_goods_id']; ?>
                            </div>    
                        </th>
                        <th width="45%" class="tl"><a href="javascript:listTable.sort('goods_name');"><?php echo $this->_var['lang']['goods_name']; ?></a><?php echo $this->_var['sort_goods_name']; ?></th>
                        <th width="10%"><a href="javascript:listTable.sort('is_real');"><?php echo $this->_var['lang']['goods_type']; ?></a><?php echo $this->_var['sort_is_real']; ?></th>
                        <th width="15%"><a href="javascript:listTable.sort('goods_sn');"><?php echo $this->_var['lang']['goods_sn']; ?></a><?php echo $this->_var['sort_goods_sn']; ?></th>
                        <th width="10%"><a href="javascript:listTable.sort('shop_price');"><?php echo $this->_var['lang']['shop_price']; ?></a><?php echo $this->_var['sort_shop_price']; ?></th>
                        <th width="10%"><?php echo $this->_var['lang']['handler']; ?></th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                  <tr class="bd-line">
                    <td class="first_td_checkbox">
                        <div class="first_all">
                            <input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['goods']['goods_id']; ?>" id="goods_<?php echo $this->_var['goods']['goods_id']; ?>" class="ui-checkbox" />
                            <label for="goods_<?php echo $this->_var['goods']['goods_id']; ?>" class="ui-label"><?php echo $this->_var['goods']['goods_id']; ?></label>
                        </div>    
                    </td>
                    <td class="tl">
                    	<div class="goods-info">
                            <div class="goods-img"><a href="../goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" onmouseover="toolTip('<img src=<?php echo $this->_var['goods']['goods_thumb']; ?>>')" onmouseout="toolTip()"></a></div>
                            <div class="goods-desc">
                                <div class="name" onclick="listTable.edit(this, 'edit_goods_name', <?php echo $this->_var['goods']['goods_id']; ?>)" class="hidden"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></div>
                                <div class="goods-tag">
                                    <?php if ($this->_var['goods']['brand_name']): ?><font class="fl blue mr5">[ <?php echo $this->_var['goods']['brand_name']; ?> ]</font><?php endif; ?>
    
                                    <?php if ($this->_var['goods']['is_shipping']): ?>
                                    <em class="free">免邮</em>
                                    <?php endif; ?>

                                    <?php if ($this->_var['goods']['stages']): ?>
                                    <em class="byStage">分期</em>
                                    <?php endif; ?>
                                    <?php if (! $this->_var['goods']['is_alone_sale']): ?>
                                    <em class="parts">配件</em>
                                    <?php endif; ?>
                                    
                                    <?php if ($this->_var['goods']['is_promote']): ?>
                                        <?php if ($this->_var['nowTime'] >= $this->_var['goods']['promote_end_date']): ?>
                                    <em class="saleEnd">特卖结束</em>
                                        <?php else: ?>
                                    <em class="sale">特卖</em>    
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php if ($this->_var['goods']['is_xiangou']): ?>
                                        <?php if ($this->_var['nowTime'] >= $this->_var['goods']['xiangou_end_date']): ?>
                                    <em class="purchaseEnd">限购结束</em>
                                        <?php else: ?>
                                    <em class="purchase">限购</em>    
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                    	</div>
                    </td>
                    <td><?php if ($this->_var['goods']['is_real']): ?><?php echo $this->_var['lang']['material_object']; ?><?php else: ?><?php echo $this->_var['lang']['virtual_card']; ?><?php endif; ?></td>
                    <td><?php echo $this->_var['goods']['goods_sn']; ?></td>
                    <td><?php echo $this->_var['goods']['shop_price']; ?></td>
                    <td class="ecsc-table-handle tr">
                      <span><a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods']['goods_id']; ?>, '<?php echo $this->_var['lang']['restore_goods_confirm']; ?>', 'restore_goods')" class="btn-orange"><i class="sc_icon_see"></i><p><?php echo $this->_var['lang']['restore']; ?></p></a></span>
                      <span><a href="javascript:;" onclick="listTable.remove(<?php echo $this->_var['goods']['goods_id']; ?>, '<?php echo $this->_var['lang']['drop_goods_confirm']; ?>', 'drop_goods')" class="btn-red"><i class="icon-trash"></i><p><?php echo $this->_var['lang']['drop']; ?></p></a></span>
                    </td>
                  </tr>
                  <?php endforeach; else: ?>
                  <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                        <td colspan="10" class="td_border">
                            <div class="shenhe">
                                <div class="imitate_select select_w120">
                                    <div class="cite"><?php echo $this->_var['lang']['select_please']; ?></div>
                                    <ul>
                                        <li><a href="javascript:;" data-value="" class="ftx-01"><?php echo $this->_var['lang']['select_please']; ?></a></li>
                                        <li><a href="javascript:;" data-value="restore" class="ftx-01"><?php echo $this->_var['lang']['restore']; ?></a></li>
                                        <li><a href="javascript:;" data-value="drop" class="ftx-01"><?php echo $this->_var['lang']['remove']; ?></a></li>
                                    </ul>
                                    <input name="type" type="hidden" value="">
                                </div>
                                <select name="target_cat" style="display:none" onchange="checkIsLeaf(this)" class="select mr10">
                                    <option value="0"><?php echo $this->_var['lang']['select_please']; ?></option>
                                    <?php echo $this->_var['cat_list']; ?>
                                </select>
                                <input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" id="btnSubmit" name="btnSubmit" class="sc-btn btn_disabled" disabled="true" onclick="changeAction();" />
                                <input type="hidden" name="act" value="batch" />
                            	<span class="lh"><?php if ($this->_var['record_count']): ?>共<?php echo $this->_var['record_count']; ?>条记录<?php endif; ?></span>
                            </div>  
                        </td>
                    </tr>
                    <tr><td colspan="10"><?php echo $this->fetch('page.dwt'); ?></td></tr>
                  </tfoot>
                </table>
                <?php if ($this->_var['full_page']): ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'ToolTip.js')); ?>
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
    startCheckOrder(); // 开始检查订单
    document.forms['listForm'].reset();
  }

  function confirmSubmit(frm, ext)
  {
    if (frm.elements['type'].value == 'restore')
    {
      
      return confirm("<?php echo $this->_var['lang']['restore_goods_confirm']; ?>");
      
    }
    else if (frm.elements['type'].value == 'drop')
    {
      
      return confirm("<?php echo $this->_var['lang']['batch_drop_confirm']; ?>");
      
    }
    else if (frm.elements['type'].value == '')
    {
        return false;
    }
    else
    {
        return true;
    }
  }

  function changeAction()
  {
      var frm = document.forms['listForm'];

      if (!document.getElementById('btnSubmit').disabled && confirmSubmit(frm, false))
      {
          frm.submit();
      }
  }
  function searchGoodsList()
{
	//listTable.filter['review_status'] = Utils.trim(document.forms['searchFormList'].elements['review_status'].value);
	listTable.filter['keyword'] = Utils.trim(document.forms['searchFormList'].elements['keyword'].value);
	listTable.filter['page'] = 1;

	listTable.loadList();
}
  
</script>
</body>
</html>
<?php endif; ?>