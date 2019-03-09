<?php if ($this->_var['full_page']): ?>
<!doctype html>
<html>
<?php echo $this->fetch('pageheader.dwt'); ?>
<div class="content">
	<div class="title"><?php echo $this->_var['page_title']; ?></div>
    <div class="explanation" id="explanation">
        <i class="sc_icon"></i>
        <ul>
            <li>无属性库存时，请填写默认库存。</li>
            <li>设置属性库存时，则调取属性库存信息，请忽略默认库存。</li>
            <li>库存数量根据门店内实际库存填写，库存数量较少时请及时补货。</li>
        </ul>
    </div>
    <form method="post" action="<?php echo $this->_var['product_php']; ?>" name="addForm" id="addForm" onsubmit="return false;" >
    <input type="hidden" name="goods_id" value="<?php echo $this->_var['goods_id']; ?>" />
    <input type="hidden" name="page" value="<?php echo $this->_var['page']; ?>" />
    <input type="hidden" name="act" value="product_add_execute" />
    <div class="product_stock">
    	<div class="porduct_info">
        	<div class="img"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="60" height="60"></div>
            <div class="info">
            	<div class="name"><a href="#" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a></div>
                <div class="lie"><span>货号：<?php echo $this->_var['goods']['goods_sn']; ?></span><span>价格：<?php echo $this->_var['goods']['shop_price']; ?></span></div>
                <?php if ($this->_var['region_name']): ?>
                <div class="lie"><div class="red">(<?php echo $this->_var['region_name']; ?>)</div></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="stock_input">
        	<span><?php echo $this->_var['lang']['default_inventory']; ?>：</span><input type="text" name="goods_number" class="text" value="<?php echo $this->_var['goods_number']; ?>">
        </div>
    </div>
    <div class="list-div" id="listDiv">
    <?php endif; ?>
        <?php if ($this->_var['have_goods_attr']): ?>
        <table class="table">
        	<thead>
            	<tr>
                	<th class="first" width="8%">编号</th>
                    <?php $_from = $this->_var['attribute']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'attribute_value');if (count($_from)):
    foreach ($_from AS $this->_var['attribute_value']):
?>
                    <th><?php echo $this->_var['attribute_value']['attr_name']; ?></th>
                    <?php endforeach; else: ?>
                    <th>&nbsp;</th>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <th><?php echo $this->_var['lang']['goods_sn']; ?></th>
                    <th><?php echo $this->_var['lang']['goods_number']; ?></th>
                    <th class="last" width="10%">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_var['product_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'product');$this->_foreach['product'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['product']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['product']):
        $this->_foreach['product']['iteration']++;
?>
                <tr>
                	<td class="first"><?php echo $this->_foreach['product']['iteration']; ?></td>
                    <?php $_from = $this->_var['product']['goods_attr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_attr');if (count($_from)):
    foreach ($_from AS $this->_var['goods_attr']):
?>
                    <td><?php echo $this->_var['goods_attr']; ?></td>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <td><input type="text" name="have_product_sn[]" class="text text_input w100" value="<?php echo empty($this->_var['product']['product_sn']) ? $this->_var['lang']['n_a'] : $this->_var['product']['product_sn']; ?>" autocomplete="off" onkeyup="listTable.editInput(this, 'edit_product_sn', <?php echo $this->_var['product']['product_id']; ?>)"/></td>
                    <td><input type="text" name="have_product_number[]" class="text text_input w50" value="<?php echo $this->_var['product']['product_number']; ?>" autocomplete="off" onkeyup="listTable.editInput(this, 'edit_product_number', <?php echo $this->_var['product']['product_id']; ?>)"/></td>
                    <td class="handle last"><a href="javascript:void(0);" class="btn_trash" onclick="dialog('delete', {id:<?php echo $this->_var['product']['product_id']; ?>, opt:'product_remove'})"><i class="icon icon-trash"></i>删除</a></td>
                </tr>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                
                <tr class="attr_row">
                	<td class="bianhao first"><?php echo $this->_var['more_count']; ?></td>
                    <?php $_from = $this->_var['attribute']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('attribute_key', 'attribute_value');if (count($_from)):
    foreach ($_from AS $this->_var['attribute_key'] => $this->_var['attribute_value']):
?>
                    <td>
                        <div class="imitate_select w150" data-tab="formType">
                            <div class="cite">请选择</div>
                            <ul>
                            	<?php $_from = $this->_var['attribute_value']['attr_values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?>
                                <li><a href="javascript:;" data-value="<?php echo $this->_var['value']; ?>" title="<?php echo $this->_var['value']; ?>" class="ftx-01"><?php echo $this->_var['value']; ?></a></li>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </ul>
                            <input name="attr[<?php echo $this->_var['attribute_value']['attr_id']; ?>][]" type="hidden" value="">
                        </div>
                    </td>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <td><input type="text" name="product_sn[]" class="text w100" value="" size="20" autocomplete="off" /></td>
                    <td><input type="text" name="product_number[]" class="text w50" value="" size="10" autocomplete="off" /></td>
                    <td class="handle last"><a href="javascript:void(0);" class="btn_trash hide"><i class="icon icon-trash"></i>删除</a></td>
                </tr>
                <tr class="tfoot">
                	<td colspan="10"><a href="javascript:void(0);" class="addtr" onclick="add_attr_product(this);"><i class="icon icon-plus"></i></a></td>
                </tr>
            </tbody>
        </table>
        <?php endif; ?>
    <?php if ($this->_var['full_page']): ?>
    </div>
    <div class="btn_info">
        <input type="button" class="btn blue_btn btn30" value="<?php echo $this->_var['lang']['button_save']; ?>" id="submitBtn" />
    </div>
    </form>
</div>
<!--start-->
<script type="text/javascript">
<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

listTable.query = 'product_query';

var _attr = new Array;
<?php $_from = $this->_var['attribute']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('attribute_key', 'attribute_value');if (count($_from)):
    foreach ($_from AS $this->_var['attribute_key'] => $this->_var['attribute_value']):
?>
_attr[<?php echo $this->_var['attribute_key']; ?>] = '<?php echo $this->_var['attribute_value']['attr_id']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>



/**
 * 追加货品添加表格
 */
function add_attr_product(obj)
{
	var obj = $(obj);
	var tr = obj.parents("tr").prev(".attr_row").clone();
	var i = tr.find(".bianhao").text();
	tr.find(".btn_trash").removeClass("hide");
	tr.find(".btn_trash").attr("onclick","minus_attr_product(this)");
	i++;
	tr.find(".bianhao").html(i);
	obj.parents("tr").prev(".attr_row").after(tr);
}

/**
 * 删除追加的货品表格
 */
function minus_attr_product(obj)
{
	$(obj).parents("tr").remove();
}

//保存商品库存
$(function(){
	$("#submitBtn").click(function(){
		var form = $(this).parents("form");
		var volumePri = form.find("input[name='product_sn[]']");
		var check_sn = '';
		for (i = 0 ; i < volumePri.length ; i ++)
		{
			if(volumePri.eq(i).val() != "")
			{
				check_sn=check_sn+'||'+volumePri.eq(i).val();
			}
		}
		
		var callback = function(res)
		{
			if (res.error > 0){
				alert(res.message);
			}else{
				//form.submit();
				send_form_data("form[name=addForm]");
			}
		}
		Ajax.call('goods.php?is_ajax=1&act=check_products_goods_sn', "goods_sn=" + check_sn, callback, "GET", "JSON");
	});
});

//jq仿select
function selectIm(){
	$(document).on("click",".imitate_select .cite",function(){
		$(this).parents(".imitate_select").find("ul").show();
	});
	
	$(document).on("click",".imitate_select li a",function(){
		var _this = $(this);
		var val = _this.data('value');
		var text = _this.html();
		_this.parents(".imitate_select").find(".cite").html(text);
		_this.parents(".imitate_select").find("input[type=hidden]").val(val);
		_this.parents(".imitate_select").find("ul").hide();
		
	});
	
	$(document).click(function(e){
		if(e.target.className !='cite' && !$(e.target).parents("div").is(".imitate_select")){
			$('.imitate_select ul').hide();
		}
	});
}
selectIm();		


</script>
<!--end-->

<?php echo $this->fetch('pagefooter.dwt'); ?>
<?php endif; ?>