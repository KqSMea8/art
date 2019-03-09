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
                
                <div class="explanation clear mb20" id="explanation">
                    <div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4></div>
                    <ul>
                        <li>设置商品运费模板：系统->配送方式-><a href="goods_transport.php?act=list">运费管理</a></li>
                    </ul>
                </div>
                
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
                
                <form method="post" action="" name="listForm" onsubmit="return confirmSubmit(this)">
                    <input type="hidden" name="act" value="batch">
                    <input type="hidden" name="type" value>
                        <?php endif; ?>
                    <div id="listDiv">
                        <table class="ecsc-default-table goods-default-table">
                            <thead>
                                <tr ectype="table_header">
                                    <th width="8%" class="frist"><a href="javascript:listTable.sort('goods_id');"><?php echo $this->_var['lang']['record_id']; ?></a><?php echo $this->_var['sort_goods_id']; ?></th>
                                    <th width="34%" class="tl"><?php echo $this->_var['lang']['goods_steps_name']; ?></th>
                                    <th width="10%"><?php echo $this->_var['lang']['shop_price']; ?>/<?php echo $this->_var['lang']['lab_commission_rate']; ?></th>
                                    <th width="7%"><?php echo $this->_var['lang']['lab_storage']; ?></th>
                                    <th width="7%"><a href="javascript:listTable.sort('sort_order'); "><?php echo $this->_var['lang']['sort_order']; ?></a><div class="img"><?php echo $this->_var['sort_sort_order']; ?></div></th>
                                    <th width="8%"><?php echo $this->_var['lang']['on_sale']; ?></th>
                                    <th width="8%"><?php echo $this->_var['lang']['audit_status']; ?></th>
                                    <th width="19%"><?php echo $this->_var['lang']['handler']; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>
                                <tr>
                                    <td class="frist trigger">
                                    	<div class="checkbox-info">
                                    		<input type="checkbox" class="ui-checkbox" value="<?php echo $this->_var['goods']['goods_id']; ?>" id="checkbox_<?php echo $this->_var['goods']['goods_id']; ?>" name="checkboxes[]"><label for="checkbox_<?php echo $this->_var['goods']['goods_id']; ?>" class="ui-label"></label>
                                        </div>
                                        <div class="number"><?php echo $this->_var['goods']['goods_id']; ?></div>
                                    </td>
                                    <td class="tl">
                                        <div class="goods-info">
                                        	<div class="goods-sku">
                                            	<span class="sku">货号：<?php echo $this->_var['goods']['goods_sn']; ?></span>
                                                <span class="time">发布时间：<?php echo $this->_var['goods']['formated_add_tim']; ?></span>
                                            </div>
                                        	<div class="goods-img"><a href="../goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" onmouseover="toolTip('<img src=<?php echo $this->_var['goods']['goods_thumb']; ?>>')" onmouseout="toolTip()"></a></div>
                                            <div class="goods-desc">
                                                <div class="name" class="hidden">
                                                	<font onclick="listTable.edit(this, 'edit_goods_name', <?php echo $this->_var['goods']['goods_id']; ?>)" title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"><?php echo sub_str(htmlspecialchars($this->_var['goods']['goods_name']),30); ?></font>
                                                    <?php if ($this->_var['goods']['brand_name']): ?><font class="green">[ <?php echo $this->_var['goods']['brand_name']; ?> ]</font><?php endif; ?>
                                                </div>
                                            	<div class="goods-tag">
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
                                            <div class="goods-lie">
                                            	<span>商品运费：</span>
                                                <?php if ($this->_var['goods']['freight'] == 1): ?>
                                                <span class="red"><?php echo $this->_var['lang']['lab_freight_fixed']; ?></span>
                                                <?php elseif ($this->_var['goods']['freight'] == 2): ?>
                                                <a href="goods_transport.php?act=edit&tid=<?php echo $this->_var['goods']['tid']; ?>" target="_blank">
                                                    <?php if ($this->_var['goods']['transport']['freight_type'] == 1): ?>
                                                        <span><?php echo $this->_var['lang']['lab_freight_temp']; ?></span>&nbsp;<em class="red">(<?php echo $this->_var['lang']['lab_freight_type']['two']; ?>)</em>
                                                    <?php else: ?>
                                                        <span><?php echo $this->_var['lang']['lab_freight_temp']; ?></span>&nbsp;<em class="red">(<?php echo $this->_var['lang']['lab_freight_type']['one']; ?>)</em>
                                                    <?php endif; ?>
                                                </a>
                                                <?php else: ?>
                                                <span class="red"><?php echo $this->_var['lang']['lab_freight_area']; ?></span>&nbsp;<em class="red">(<?php echo $this->_var['lang']['lab_goods_shipping']; ?>)</em>
                                                <?php endif; ?>
                                            </div>                                  
                                        </div>
                                    </td>
                                    <td>
                                    	<p>
                                        <?php if ($this->_var['goods']['model_attr'] == 1): ?>
                                            <input name="goods_model_price" data-goodsid="<?php echo $this->_var['goods']['goods_id']; ?>" class="sc-btn btn25 sc-blueBg-btn fn" value="仓库价格" type="button">  
                                        <?php elseif ($this->_var['goods']['model_attr'] == 2): ?>
                                            <input name="goods_model_price" data-goodsid="<?php echo $this->_var['goods']['goods_id']; ?>" class="sc-btn btn25 sc-blueBg-btn fn" value="地区价格" type="button">
                                        <?php else: ?>
                                            <p onclick="listTable.edit(this, 'edit_goods_price', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['shop_price']; ?></p>
                                        <?php endif; ?>
                                        </p>
                                        <p>
                                            <?php if ($this->_var['commission_setting']): ?>
                                            <input class="text w30 tc fn" style="margin-right:0px; height:20px; margin-top:5px;" onblur="listTable.editInput(this, 'edit_commission_rate', '<?php echo $this->_var['goods']['goods_id']; ?>' );" autocomplete="off" value="<?php echo empty($this->_var['goods']['commission_rate']) ? '0' : $this->_var['goods']['commission_rate']; ?>" type="text" <?php if (! $this->_var['goods']['user_id']): ?>disabled<?php endif; ?>>&nbsp;%
                                            <?php else: ?>
                                            <span class="red"><?php echo empty($this->_var['goods']['commission_rate']) ? '0' : $this->_var['goods']['commission_rate']; ?>%</span>
                                            <?php endif; ?>
                                        </p>
                                    </td>
                                    <td>
                                    	<?php if ($this->_var['goods']['is_attr']): ?>
                                            <a href="javascript:;" ectype="add_sku" data-goodsid="<?php echo $this->_var['goods']['goods_id']; ?>" data-userid="<?php echo $this->_var['goods']['user_id']; ?>"><i class="icon icon-edit font16"></i></a>
                                        <?php else: ?>
                                            <p onclick="listTable.edit(this, 'edit_goods_number', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['goods_number']; ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td><p onclick="listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['goods']['goods_id']; ?>)"><?php echo $this->_var['goods']['sort_order']; ?></p></td>
                                    <td>
                                        <div class="switch<?php if ($this->_var['goods']['is_on_sale']): ?> active<?php endif; ?> ml25" title="<?php if ($this->_var['goods']['is_on_sale']): ?>是<?php else: ?>否<?php endif; ?>" onclick="listTable.switchBt(this, 'toggle_on_sale', <?php echo $this->_var['goods']['goods_id']; ?>)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="<?php echo $this->_var['goods']['is_on_sale']; ?>" name="">
                                    </td>
                                    <td class="audit_status">
                                        <?php if ($this->_var['goods']['review_status'] == 1): ?>
                                        <font class="org2"><?php echo $this->_var['lang']['not_audited']; ?></font>
                                        <?php elseif ($this->_var['goods']['review_status'] == 2): ?>
                                        <font class="red"><?php echo $this->_var['lang']['audited_not_adopt']; ?></font>
                                        <i class="tip yellow" title="<?php echo $this->_var['goods']['review_content']; ?>"><?php echo $this->_var['lang']['prompt']; ?></i>
                                        <?php elseif ($this->_var['goods']['review_status'] == 3 || $this->_var['goods']['review_status'] == 4): ?>
                                        <font class="green"><?php echo $this->_var['lang']['audited_yes_adopt']; ?></font>
                                        <?php elseif ($this->_var['goods']['review_status'] == 5): ?>
                                        <font class="blue"><?php echo $this->_var['lang']['wuxu_adopt']; ?></font>
                                        <?php endif; ?>
                                    </td>
                                    <td class="ecsc-table-handle tr">
                                        <span><a href="../goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank" class="btn-orange"><i class="sc_icon_see"></i><p><?php echo $this->_var['lang']['view']; ?></p></a></span>
                                        <span><a href="goods.php?act=copy&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>&extension_code=<?php echo $this->_var['code']; ?>" title='<?php echo $this->_var['lang']['copy_goods']; ?>' class="btn-orange"><i class="icon-copy"></i><p><?php echo $this->_var['lang']['copy']; ?></p></a></span></br>
                                        <span><a href="goods.php?act=edit&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>&extension_code=<?php echo $this->_var['code']; ?>" class="btn-green"><i class="icon-edit"></i><p><?php echo $this->_var['lang']['edit']; ?></p></a></span>
                                        <span><a href="javascript:void(0);" onclick="listTable.remove(<?php echo $this->_var['goods']['goods_id']; ?>, '您确实要把该商品放入回收站吗？')" class="btn-red"><i class="icon-trash"></i><p><?php echo $this->_var['lang']['drop']; ?></p></a></span>
										<span><a href="goods.php?act=view_log&id=<?php echo $this->_var['goods']['goods_id']; ?>" class="btn-violet"><i class="icon-file-alt"></i><p>日志</p></a></span>
                                        <br />
                                        <?php if ($this->_var['add_handler']): ?>
                                            <?php $_from = $this->_var['add_handler']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'handler');$this->_foreach['namehandler'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['namehandler']['total'] > 0):
    foreach ($_from AS $this->_var['handler']):
        $this->_foreach['namehandler']['iteration']++;
?>
                                                <span><a href="<?php echo $this->_var['handler']['url']; ?>&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>" title="<?php echo $this->_var['handler']['title']; ?>" class="<?php if ($this->_foreach['namehandler']['iteration'] == 1): ?>btn-orange<?php elseif ($this->_foreach['namehandler']['iteration'] == 2): ?>btn-blue<?php elseif ($this->_foreach['namehandler']['iteration'] == 3): ?>btn-green<?php endif; ?>"><i class="<?php echo $this->_var['handler']['icon']; ?>"></i><p><?php echo $this->_var['handler']['title']; ?></p></a></span>
                                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="20" class="no-records"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                            <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="frist tc"><input type="checkbox" id="tfoot-all" name="checkboxes[]" class="ui-checkbox" onclick='listTable.selectAll(this, "checkboxes")'><label for="tfoot-all" class="ui-label"></label></th>
                                    <th class="batch-operation" colspan="20">
                                    	<a href="javascript:void(0);" class="sc-btn sc-red-btn" data-type="trash"><i class="icon-trash"></i>删除</a>
                                        <a href="javascript:void(0);" class="sc-btn sc-org-btn" data-type="on_sale"><i class="icon-arrow-up"></i>上架</a>
                                        <a href="javascript:void(0);" class="sc-btn sc-org-btn" data-type="not_on_sale"><i class="icon-arrow-down"></i>下架</a>
                                        <a href="javascript:void(0);" class="sc-btn sc-org-btn" data-type="return_type"><i class="icon-arrow-down"></i>退换货标识</a>
										<!--运费模板 start-->
										<a href="javascript:void(0);" class="sc-btn sc-org-btn" data-type="set_goods_transport"><i class="icon-book"></i>运费模板</a>
										<div class="imitate_select select_w120" style="float:none; display:none;" ectype="goods_transport">
											<div class="cite">请选择</div>
											<ul style="display: none;">
												 <?php $_from = $this->_var['transport_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
												 <li><a href="javascript:;" data-value="<?php echo $this->_var['item']['tid']; ?>" class="ftx-01"><?php echo $this->_var['item']['title']; ?></a></li>
												 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
											</ul>
											<input name="tid" type="hidden" value="0">
										</div>	
										<a href="javascript:void(0);" class="sc-btn sc-org-btn" data-type="goods_transport" style="display:none;" ectype="goods_transport"><i class="icon-ok"></i>确定</a>
										<!--运费模板 end-->
                                    	<span><?php if ($this->_var['record_count']): ?>共<?php echo $this->_var['record_count']; ?>条记录，<?php endif; ?></span>
                                        <span class="page page_3">
                                    		<i>每页</i> <input type='text' size='3' id='pageSize' style=" border:1px solid #e5e5e5; background:#FFF; text-align:center; padding:3px; border-radius:4px;" value="<?php echo $this->_var['filter']['page_size']; ?>" onkeypress="return listTable.changePageSize(event)" />
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
	//listTable.filter['review_status'] = Utils.trim(document.forms['searchFormList'].elements['review_status'].value);
	listTable.filter['keyword'] = Utils.trim(document.forms['searchFormList'].elements['keyword'].value);
	listTable.filter['page'] = 1;

	listTable.loadList();
}

function confirmSubmit(frm, ext)
{
  if (frm.elements['type'].value == 'trash')
  {
	  return confirm(batch_trash_confirm);
  }
  else if (frm.elements['type'].value == 'not_on_sale')
  {
	  return confirm(batch_no_on_sale);
  }
  else if (frm.elements['type'].value == 'move_to')
  {
	  ext = (ext == undefined) ? true : ext;
	  return ext && document.getElementById('target_cat').value != 0;
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

function changeAction(type)
{
  //运费模板 start
  if(type == 'set_goods_transport'){
	$("div[ectype='goods_transport']").css({'display':'inline-table'});
	$("a[ectype='goods_transport']").css({'display':''});
	return;
  }
  //运费模板 end
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
    // 获取商品列表
    $(document).on("click",'i[ectype="GoodsList"]',function(){
		if($(this).hasClass("icon-plus-sign")){
			$(this).removeClass('icon-plus-sign').addClass('icon-minus-sign');
			var parenttr = $(this).parents('tr');
			parenttr.next().show()
		}else{
			$(this).removeClass('icon-minus-sign').addClass('icon-plus-sign');
			$(this).parents('tr').next().hide();
		}
	});

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

//仓库库存修改弹出框
$(document).on('click',"*[ectype='dialog']",function(){
	var url =$(this).data('url');
	var title = $(this).attr('title');
	Ajax.call(url,'',dsc_warehouse, 'POST', 'JSON');
	function dsc_warehouse(result){
		pb({
			id:"tipDialog",
			title:title,
			content:result.content,
			drag:false,
			ok_title:"确定",
			cl_title:"取消"
		});
	}
});

//单选勾选
function get_ajax_act(t, goods_id, act, FileName){
	
	if(t.checked == false){
		t.value = 0;
	}
	
	Ajax.call(FileName + '.php?act=' + act, 'id=' + goods_id + '&val=' + t.value, act_response, 'POST', 'JSON');
}

function act_response(result){}

function dropWarehouse(w_id)
{
	Ajax.call('goods.php?is_ajax=1&act=drop_warehouse', "w_id="+w_id, dropWarehouseResponse, "GET", "JSON");
}

function dropWarehouseResponse(result)
{
	if (result.error == 0)
	{
	  document.getElementById('warehouse_' + result.content).style.display = 'none';
	}
}

function dropWarehouseArea(a_id)
{
	Ajax.call('goods.php?is_ajax=1&act=drop_warehouse_area', "a_id="+a_id, dropWarehouseAreaResponse, "GET", "JSON");
}

function dropWarehouseAreaResponse(result)
{
	if (result.error == 0)
	{
	  document.getElementById('warehouse_area_' + result.content).style.display = 'none';
	}
}

//仓库/地区价格 start
$(document).on("click","input[name='goods_model_price']",function(){
	var goods_id = $(this).data("goodsid");
	
	$.jqueryAjax('dialog.php', 'act=add_goods_model_price' + '&goods_id=' + goods_id, function(data){
		var content = data.content;
		pb({
			id:"categroy_dialog",
			title:"仓库/地区价格",
			width:864,
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