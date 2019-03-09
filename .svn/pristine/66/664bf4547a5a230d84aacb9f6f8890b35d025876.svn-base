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
                            <input type="hidden" name="cat_id" id="cat_id" value="0"/>
                        </div>
                    </form>
                    </div>
                </div>
                
                <form method="post" action="" name="listForm" onsubmit="return confirmSubmit(this)">
                    <input type="hidden" name="act" value="batch">
                    <input type="hidden" name="type" value>
                        <?php endif; ?>
                    <div id="listDiv">
                        <table class="ecsc-default-table goods-default-table">
                            <thead>
                                <tr ectype="table_header">
									<th width="8%">
										<div class="first_all">
											<input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" class="ui-checkbox" id="all"/>
											<label for="all" class="ui-label"><?php echo $this->_var['lang']['record_id']; ?></label>
										</div>
									</th>
                                    <th width="40%" class="tl">商品信息</th>
									<th width="20%" class="tl">商品库商品分类</th>
                                    <th width="15%">价格</th>
                                    <th width="7%"><a href="javascript:listTable.sort('sort_order'); "><?php echo $this->_var['lang']['sort_order']; ?></a><div class="img"><?php echo $this->_var['sort_sort_order']; ?></div></th>
                                    <th width="8%"><?php echo $this->_var['lang']['handler']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                                <tr>
									<td class="first_td_checkbox">
										<div class="first_all">
											<input value="<?php echo $this->_var['goods']['goods_id']; ?>" name="checkboxes[]" type="checkbox" id="goods_<?php echo $this->_var['goods']['goods_id']; ?>" class="ui-checkbox">
											<label for="goods_<?php echo $this->_var['goods']['goods_id']; ?>" class="ui-label"><?php echo $this->_var['goods']['goods_id']; ?></label>
										</div>
									</td>									
                                    <td class="tl">
                                        <div class="goods-info">
                                        	<div class="goods-img"><a href="../goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" onmouseover="toolTip('<img src=<?php echo $this->_var['goods']['goods_thumb']; ?>>')" onmouseout="toolTip()"></a></div>
                                            <div class="goods-desc">
                                                <div class="name" class="hidden"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></div>
                                            	<div class="goods-tag">
                                                    <?php if ($this->_var['goods']['brand_name']): ?><font class="fl blue mr5">[ <?php echo $this->_var['goods']['brand_name']; ?> ]</font><?php endif; ?>
                                                </div>
                                            </div>                                          
                                        </div>
                                    </td>
                                    <td>
									<span><?php echo $this->_var['goods']['lib_cat_name']; ?></span>
                                    </td>									
                                    <td>
                                        <span><?php echo $this->_var['goods']['shop_price']; ?></span>
                                    </td>
                                    <td><span onclick="listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['sort_order']; ?></span></td>
                                    <td class="ecsc-table-handle tr">
                                        <span><a href="javascript:void(0);" ectype="seller_import" data-goodsid="<?php echo $this->_var['goods']['goods_id']; ?>" class="btn-red"><i class="icon-upload-alt"></i><p>导入</p></a></span>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="20" class="no-records"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                            <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="frist tc"></th>
                                    <th class="batch-operation" colspan="20">
										<a href="javascript:void(0);" class="sc-btn sc-red-btn"><i class="icon-upload-alt"></i>批量导入</a>
                                    	<span><?php if ($this->_var['record_count']): ?>共<?php echo $this->_var['record_count']; ?>条记录，<?php endif; ?></span>
                                        <span class="page page_3">
                                    	<i>去第</i> 
											<select id="gotoPage" onchange="listTable.gotoPage(this.value)">
												<?php echo $this->smarty_create_pages(array('count'=>$this->_var['page_count'],'page'=>$this->_var['filter']['page'])); ?>
											</select>
        								<i>页</i>
                                    </span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        <?php echo $this->fetch('page.dwt'); ?>
                        <?php if ($this->_var['full_page']): ?>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
<!--高级搜索 start-->
<?php echo $this->fetch('library/goods_search.lbi'); ?>
<!--高级搜索 end-->
    
<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'ToolTip.js,jquery.purebox.js')); ?>
<script type="text/javascript">
listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

function searchGoodsList()
{
	listTable.filter['keyword'] = Utils.trim(document.forms['searchFormList'].elements['keyword'].value);
	listTable.filter['page'] = 1;

	listTable.loadList();
}

function confirmSubmit(frm, ext)
{
  return true;
}

function changeAction(type)
{
  var frm = document.forms['listForm'];
  frm.elements['type'].value = type;
  if(confirmSubmit(frm, false))
  {
	frm.submit();
  }
}

//单选勾选
function get_ajax_act(t, goods_id, act, FileName){
	
	if(t.checked == false){
		t.value = 0;
	}
	
	Ajax.call(FileName + '.php?act=' + act, 'id=' + goods_id + '&val=' + t.value, act_response, 'POST', 'JSON');
}

function act_response(result){
}  
  
$(function(){
	//列表批量处理
	$(document).on("click",".batch-operation a.sc-btn",function(){
		var _this = $(this),
			table = _this.parents(".ecsc-default-table"),
			checked = table.find("input[name='checkboxes[]']").is(":checked"),
			type = _this.data("type");
		if(checked){
			changeAction(type);
		}else{
			alert("请勾选商品");
		}
	});
});

//商品库商品导入 start
$(document).on("click","a[ectype='seller_import']",function(){
	var goods_id = $(this).data("goodsid");
	$.jqueryAjax('goods_lib.php', 'act=seller_import' + '&goods_id=' + goods_id, function(data){
		var content = data.content;
		pb({
			id:"seller_export",
			title:"商品库商品导入",
			width:450,
			content:content,
			ok_title:"确定",
			cl_title:"取消",
			drag:true,
			foot:false
		});
	});
});

//仓库/地区价格 end

//SKU/库存 start
$(document).on("click","a[ectype='add_sku']",function(){
	
	var goods_id = $(this).data('goodsid');
	var user_id = $(this).data('userid');
	
	$.jqueryAjax('dialog.php', 'act=add_sku' + '&goods_id=' + goods_id + '&user_id=' + user_id, function(data){
		var content = data.content;
		pb({
			id:"categroy_dialog",
			title:"编辑商品货品信息",
			width:863,
			content:content,
			ok_title:"确定",
			cl_title:"取消",
			drag:true,
			foot:false
		});
	});
});

//SKU/库存 start
$(document).on("click","a[ectype='add_attr_sku']",function(){
	
	var goods_id = $(this).data('goodsid');
	var product_id = $(this).data('product');
	
	$.jqueryAjax('dialog.php', 'act=add_attr_sku' + '&goods_id=' + goods_id + '&product_id=' + product_id, function(data){
		var content = data.content;
		pb({
			id:"attr_sku_dialog",
			title:"编辑商品货品价格",
			width:563,
			content:content,
			ok_title:"确定",
			cl_title:"取消",
			drag:true,
			foot:true,
			onOk:function(){
				if(data.method){
					insert_attr_warehouse_area_price(data.method);
				}
			}
		});
	});
});

function insert_attr_warehouse_area_price(method){
	var actionUrl = "dialog.php?act=" + method;  
	$("#warehouseForm").ajaxSubmit({
			type: "POST",
			dataType: "JSON",
			url: actionUrl,
			data: {"action": "TemporaryImage"},
			success: function (data) {
			},
			async: true  
	 });
}
</script>
</body>
</html>
<?php endif; ?>