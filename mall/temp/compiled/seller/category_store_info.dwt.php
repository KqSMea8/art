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
                <div class="ecsc-form-goods">
                <form action="category_store.php" method="post" name="theForm" enctype="multipart/form-data" id="category_info_form">
                    <div class="wrapper-list">
                    	<dl>
                        	<dt><?php echo $this->_var['lang']['require_field']; ?>&nbsp;<?php echo $this->_var['lang']['cat_name']; ?>：</dt>
                            <dd>
                            	<?php if ($this->_var['form_act'] == 'insert'): ?>
                                <textarea name="cat_name" cols="48" rows="3" class="textarea"><?php echo htmlspecialchars($this->_var['cat_info']['cat_name']); ?></textarea>
								<div class="form_prompt"></div>
                                <div class="notic"><?php echo $this->_var['lang']['category_name_notic']; ?></div>
                                <?php else: ?>
                                <input type='text' class="text" name='cat_name' maxlength="20" value='<?php echo htmlspecialchars($this->_var['cat_info']['cat_name']); ?>' size='27' />
								<div class="form_prompt"></div>
                                <?php endif; ?>
                            </dd>
                        </dl>
                        <dl>
                        	<dt>手机小图标：</dt>
                                <dd>
                                <div class="type-file-box">
                                	<div class="input">
                                        <input type="text" name="textfile" class="type-file-text" id="textfield" autocomplete="off" value="<?php if ($this->_var['cat_info']['touch_icon']): ?><?php echo $this->_var['cat_info']['touch_icon']; ?><?php endif; ?>" readonly />
                                        <input type="button" name="button" id="button" class="type-file-button" value="上传..." />
                                        <input type="file" class="type-file-file" id="ad_img" name="touch_icon" data-state="imgfile" size="30" hidefocus="true" value="" />
                                    </div>
                                    <?php if ($this->_var['cat_info']['touch_icon']): ?>
                                    <span class="show">
                                        <a href="../<?php echo $this->_var['cat_info']['touch_icon']; ?>" target="_blank" class="nyroModal"><i class="icon icon-picture" onmouseover="toolTip('<img src=../<?php echo $this->_var['cat_info']['touch_icon']; ?>>')" onmouseout="toolTip()"></i></a>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="form_prompt"></div>
                                <div class="notic m20" id="AdCodeImg">（注：手机端专用,建议上传正方形图片（100*100））</div>
                        </dd>
                        </dl>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['parent_id']; ?>：</dt>
                            <dd>
                            	<div class="search_select">
                                    <div class="categorySelect">
                                        <div class="selection">
                                            <input type="text" name="category_name" id="category_name" class="text w290 valid" value="<?php if ($this->_var['parent_category']): ?><?php echo $this->_var['parent_category']; ?><?php else: ?>顶级分类<?php endif; ?>" autocomplete="off" readonly data-filter="cat_name" />
                                            <input type="hidden" name="parent_id" id="category_id" value="<?php echo empty($this->_var['parent_id']) ? '0' : $this->_var['parent_id']; ?>" data-filter="cat_id" />
                                        </div>
                                        <div class="select-container w320" style="display:none;">
                                            <?php echo $this->fetch('library/filter_category_seller.lbi'); ?>
                                        </div>
                                    </div>
                            	</div>
                            </dd>
                        </dl>
                        <dl id="measure_unit">
                        	<dt><?php echo $this->_var['lang']['measure_unit']; ?>：</dt>
                            <dd><input type="text"class="text text_4" name='measure_unit' value='<?php echo $this->_var['cat_info']['measure_unit']; ?>' size="12" /></dd>
                        </dl>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['sort_order']; ?>：</dt>
                            <dd><input type="text" class="text text_4" name='sort_order' <?php if ($this->_var['cat_info']['sort_order']): ?>value='<?php echo $this->_var['cat_info']['sort_order']; ?>'<?php else: ?> value="50"<?php endif; ?> size="15" /></dd>
                        </dl>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['is_show']; ?>：</dt>
                            <dd>
                            	<div class="checkbox_items">
                                    <div class="checkbox_item">
                                        <input type="radio" class="ui-radio" name="is_show" value="1" id="is_show_1" <?php if ($this->_var['cat_info']['is_show'] != 0): ?> checked="true"<?php endif; ?>/>
                                        <label class="ui-radio-label" for="is_show_1"><?php echo $this->_var['lang']['yes']; ?></label>
                                    </div>
                                    <div class="checkbox_item">
                                        <input type="radio" class="ui-radio" name="is_show" value="0" id="is_show_0" <?php if ($this->_var['cat_info']['is_show'] == 0): ?> checked="true"<?php endif; ?> />
                                        <label class="ui-radio-label" for="is_show_0"><?php echo $this->_var['lang']['no']; ?></label>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['show_seller_nav']; ?>：</dt>
                            <dd>
                            	<div class="checkbox_items">
                                	<div class="checkbox_item">
                                        <input type="radio" class="ui-radio" name="show_in_nav" value="1" id="show_in_nav_1" <?php if ($this->_var['cat_info']['show_in_nav'] != 0): ?> checked="true"<?php endif; ?>/>
                                        <label class="ui-radio-label" for="show_in_nav_1"><?php echo $this->_var['lang']['yes']; ?></label>
                                    </div>
                                    <div class="checkbox_item">
                                        <input type="radio" class="ui-radio" name="show_in_nav" value="0" id="show_in_nav_0" <?php if ($this->_var['cat_info']['show_in_nav'] == 0): ?> checked="true"<?php endif; ?> />
                                        <label class="ui-radio-label" for="show_in_nav_0"><?php echo $this->_var['lang']['no']; ?></label>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                        <?php if ($this->_var['cat_name_arr']): ?>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['category_herf']; ?>：</dt>
                            <dd>
                            	<textarea name='category_links' class="textarea" rows="6" cols="48"><?php echo $this->_var['cat_info']['category_links']; ?></textarea>
                            	<div class="notic"><?php echo $this->_var['lang']['category_herf_notic']; ?></div>
                            </dd>
                        </dl>
                        <?php endif; ?>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['filter_attr']; ?>：</dt>
							<dd>
                            	<div class="item mt10">
									<div class="value_select" ectype="type_cat">
                                        <div id="parent_id1" class="imitate_select select_w145" ectype="typeCatSelect">
                                            <div class="cite">请选择</div>
                                            <ul>
                                                <li><a href="javascript:;" data-value="0" data-level='1' class="ftx-01">请选择</a></li>
                                                <?php $_from = $this->_var['type_level']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
                                                <li><a href="javascript:;" data-value="<?php echo $this->_var['cat']['cat_id']; ?>" data-level="<?php echo $this->_var['cat']['level']; ?>" class="ftx-01"><?php echo $this->_var['cat']['cat_name']; ?></a></li>
                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                            </ul>
                                            <input type="hidden" value="<?php echo empty($this->_var['cat_tree1']['checked_id']) ? '0' : $this->_var['cat_tree1']['checked_id']; ?>" id="parent_id_val1" ectype="typeCatVal">
                                        </div>
                                        <?php if ($this->_var['cat_tree1']['arr']): ?>
                                        <div id="parent_id2" class="imitate_select select_w145" ectype="typeCatSelect">
                                            <div class="cite">请选择</div>
                                            <ul>
                                                <li><a href="javascript:;" data-value="0" data-level='2' class="ftx-01">请选择</a></li>
                                                <?php $_from = $this->_var['cat_tree1']['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
                                                <li><a href="javascript:;" data-value="<?php echo $this->_var['cat']['cat_id']; ?>" data-level="<?php echo $this->_var['cat']['level']; ?>" class="ftx-01"><?php echo $this->_var['cat']['cat_name']; ?></a></li>
                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                            </ul>
                                            <input type="hidden" value="<?php echo empty($this->_var['cat_tree']['checked_id']) ? '0' : $this->_var['cat_tree']['checked_id']; ?>" id="parent_id_val2" ectype="typeCatVal">
                                        </div>
                                        <?php endif; ?>
                                        <?php if ($this->_var['cat_tree']['arr']): ?>
                                        <div id="parent_id<?php if ($this->_var['cat_tree1']['arr']): ?>3<?php else: ?>2<?php endif; ?>" class="imitate_select select_w145" ectype="typeCatSelect">
                                            <div class="cite">请选择</div>
                                            <ul>
                                                <li><a href="javascript:;" data-value="0" data-level='<?php if ($this->_var['cat_tree1']['arr']): ?>3<?php else: ?>2<?php endif; ?>' class="ftx-01">请选择</a></li>
                                                <?php $_from = $this->_var['cat_tree']['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
                                                <li><a href="javascript:;" data-value="<?php echo $this->_var['cat']['cat_id']; ?>" data-level="<?php echo $this->_var['cat']['level']; ?>" class="ftx-01"><?php echo $this->_var['cat']['cat_name']; ?></a></li>
                                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                            </ul>
                                            <input type="hidden" value="<?php echo empty($this->_var['type_c_id']) ? '0' : $this->_var['type_c_id']; ?>" id="parent_id_val<?php if ($this->_var['cat_tree1']['arr']): ?>3<?php else: ?>2<?php endif; ?>" ectype="typeCatVal">
                                        </div>
                                        <?php endif; ?>
									</div>
                                    <div class="imitate_select select_w170">
                                        <div class="cite"><?php echo $this->_var['lang']['sel_goods_type']; ?></div>
                                        <ul style="display: none;">
                                            <?php echo $this->_var['goods_type_list']; ?>
                                        </ul>
                                        <input name="goods_type" type="hidden" value="0">
                                    </div>
                                    <div class="imitate_select select_w120">
                                    	<div class="cite"><?php echo $this->_var['lang']['sel_goods_type']; ?></div>
                                        <ul style="display: none;">
                                            <li><a href="javascript:;" data-value="0" class="ftx-01"><?php echo $this->_var['lang']['sel_filter_attr']; ?></a></li>
                                        </ul>
                                    	<input name="filter_attr[]" type="hidden" value="0">
                                    </div>
                                    <a href="javascript:;" onclick="addFilterAttr(this)" class="fl mr10 mt5" ectype="operation">[+]</a>
                                </div>
                                <?php $_from = $this->_var['filter_attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'filter_attr');$this->_foreach['filter_attr_tab'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['filter_attr_tab']['total'] > 0):
    foreach ($_from AS $this->_var['filter_attr']):
        $this->_foreach['filter_attr_tab']['iteration']++;
?>
                                <div class="item mt10">
                                  <div class="imitate_select select_w170">
                                      <div class="cite"><?php echo $this->_var['lang']['sel_goods_type']; ?>111</div>
                                      <ul style="display: none;">
                                          <?php echo $this->_var['goods_type_list']; ?>
                                      </ul>
                                      <input name="goods_type" type="hidden" value="<?php echo $this->_var['filter_attr']['goods_type']; ?>">
                                  </div>
                                  <div class="imitate_select select_w120">
                                      <div class="cite"><?php echo $this->_var['lang']['sel_goods_type']; ?></div>
                                      <ul style="display: none;">
                                          <li><a href="javascript:;" data-value="0" class="ftx-01"><?php echo $this->_var['lang']['sel_filter_attr']; ?></a></li>
                                          <?php $_from = $this->_var['filter_attr']['option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
                                          <li><a href="javascript:;" data-value="<?php echo $this->_var['key']; ?>" class="ftx-01"><?php echo $this->_var['item']; ?></a></li>
                                          <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                      </ul>
                                      <input name="filter_attr[]" type="hidden" value="<?php echo $this->_var['filter_attr']['filter_attr']; ?>">
                                  </div>
                                  <a href="javascript:;" onclick="removeFilterAttr(this)" class="fl mr10 mt5" ectype="operation">[-]&nbsp;</a>
                                </div>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                <div class="notic"><?php echo $this->_var['lang']['filter_attr_notic']; ?></div>
                                <input name="attr_parent_id" type="hidden" value="<?php echo empty($this->_var['type_c_id']) ? '0' : $this->_var['type_c_id']; ?>">
                            </dd>
                        </dl>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['grade']; ?>：</dt>
                            <dd>
                            	<input type="text" name="grade" value="<?php echo empty($this->_var['cat_info']['grade']) ? '0' : $this->_var['cat_info']['grade']; ?>" size="40" class="text mr10" />
                            	<div class="notic"><?php echo $this->_var['lang']['notice_grade']; ?></div>
                            </dd>
                        </dl>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['cat_style']; ?>：</dt>
                            <dd>
                            	<input type="text" name="style" value="<?php echo htmlspecialchars($this->_var['cat_info']['style']); ?>" size="40"  class="text mr10" />
                            	<div class="notic"><?php echo $this->_var['lang']['notice_style']; ?></div>
                            </dd>
                        </dl>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['keywords']; ?>：</dt>
                            <dd><input type="text" name="keywords" value='<?php echo $this->_var['cat_info']['keywords']; ?>' size="50" class="text mr10" /></dd>
                        </dl>
                        <dl>
                        	<dt><?php echo $this->_var['lang']['cat_desc']; ?>：</dt>
                            <dd><textarea name='cat_desc' rows="6" cols="48" class="textarea"><?php echo $this->_var['cat_info']['cat_desc']; ?></textarea></dd>
                        </dl>
                        <dl class="button_info">
                        	<dt>&nbsp;</dt>
                            <dd>
                            	<input type="submit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="sc-btn sc-blueBg-btn btn35" id="submitBtn" />
                                <input type="reset" value="<?php echo $this->_var['lang']['button_reset']; ?>" class="sc-btn btn35 sc-blue-btn" />
                                <input type="hidden" name="act" value="<?php echo $this->_var['form_act']; ?>" />
                                <input type="hidden" name="old_cat_name" value="<?php echo $this->_var['cat_info']['cat_name']; ?>" />
                                <input type="hidden" name="cat_id" value="<?php echo $this->_var['cat_info']['cat_id']; ?>" />
                            </dd>
                        </dl>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>

<script type="text/javascript" src="../js/jquery.picTip.js"></script>
<script type="text/javascript">
$(function(){
	//表单验证
	$("#submitBtn").click(function(){
		if($("#category_info_form").valid()){
			$("#category_info_form").submit();
		}
	});
	
	$('#category_info_form').validate({
		errorPlacement:function(error, element){
			var error_div = element.parents('dl').find('div.form_prompt');
			//element.parents('dl').find(".notic").hide();
			error_div.append(error);
		},
		rules:{
			cat_name :{
				required : true
			},
			grade :{
				min : 0,
				max : 10 
			}
		},
		messages:{
			cat_name:{
				 required : '<i class="icon icon-exclamation-sign"></i>'+catname_empty
			},
			grade:{
				 min : '<i class="icon icon-exclamation-sign"></i>价格区间不能小于0',
				 max : '<i class="icon icon-exclamation-sign"></i>价格区间不能大于10'
			}
		}			
	});
});
/**
 * 新增一个筛选属性
 */
function addFilterAttr(obj)
{
	var obj = $(obj);
	var parent = obj.parents(".item");
	var clone = parent.clone();
	clone.find("[ectype='operation']")
	.attr("onclick",'removeFilterAttr(this)')
	.html("[-]");
	
	parent.after(clone);
}

/**
 * 删除一个筛选属性
 */
function removeFilterAttr(obj)
{
	var obj = $(obj);
	var parent = obj.parents(".item");
	parent.remove();
}

//ecmoban模板堂 --zhuo start

//判断选择的分类是否是顶级分类，如果是则可用 类目证件
function get_cat_parent_val(f,lev){
	var title_list = document.getElementsByName("document_title[]");
	var cat_parent_id = f + "_" + Number(lev - 1);
	
	var arr = new Array();
	var str = new String(cat_parent_id);
	var arr = str.split("_");
	var sf = Number(arr[0]);
	var slevel = Number(arr[1]);
	
	catList(sf, lev);

	for(i=0; i<title_list.length; i++){
		if(sf != 0){
			title_list[i].disabled = true;
			title_list[i].value = '';
		}else{
			title_list[i].disabled = false;
		}	
	}
}
/**
   * 添加类目证件
   */
  function addCategoryFile(obj)
  {  
	 var title_list = document.getElementsByName("document_title[]");
	 var catParent = document.getElementById('cat_parent_id').value; 
	 if(catParent != 0){
		 alert('该分类必须是顶级分类才能使用!');

		 for(i=0; i<title_list.length; i++){
			 title_list[i].value = '';
		 }
		 
		 return false;
	}
	  
    var src      = obj.parentNode.parentNode;
    var tbl      = document.getElementById('documentTitle_table');

    var row  = tbl.insertRow(tbl.rows.length);
    var cell = row.insertCell(-1);
    cell.innerHTML = src.cells[0].innerHTML.replace(/(.*)(addCategoryFile)(.*)(\[)(\+)/i, "$1removeCategoryFile$3$4-");

    title_list[title_list.length-1].value = "";
  }

  /**
   * 删除类目证件
   */
  function removeCategoryFile(obj,dt_id)
  {
	  if(dt_id > 0){
	   if (confirm('确实要删除该信息吗')){
		   <?php if ($this->_var['cat_id'] > 0): ?>
		   location.href = 'category.php?act=title_remove&dt_id=' + dt_id + '&cat_id=' + <?php echo $this->_var['cat_id']; ?>;  
		   <?php endif; ?>
	   }
	  }else{
		  var row = rowindex(obj.parentNode.parentNode);
		  var tbl = document.getElementById('documentTitle_table');
	
		  tbl.deleteRow(row);
	  }
  }
  //ecmoban模板堂 --zhuo end

  // 分类分级 by qin
  function catList(val, level)
  {
	var cat_parent_id = val;
	Ajax.call('goods.php?is_ajax=1&act=sel_cat', 'cat_id='+cat_parent_id+'&cat_level='+level, catListResponse, 'GET', 'JSON');
  }

  function catListResponse(result)
  {
	document.getElementById('cat_parent_id').value = result.parent_id + "_" + Number(result.cat_level - 1);  
	if (result.error == '1' && result.message != '')
	{
	  alert(result.message);
	  return;
	}
	var response = result.content;
	var cat_level = result.cat_level; // 分类级别， 1为顶级分类
	for(var i=cat_level;i<10;i++)
	{
	  $("#cat_list"+Number(i+1)).remove();
	}
	if(response)
	{
		$("#cat_list"+cat_level).after(response);
	}
	return;
  }
//-->
</script>
<script type="text/javascript">
  var arr = new Array();
  var sel_filter_attr = "<?php echo $this->_var['lang']['sel_filter_attr']; ?>";
  <?php $_from = $this->_var['attr_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('att_cat_id', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['att_cat_id'] => $this->_var['val']):
?>
	arr[<?php echo $this->_var['att_cat_id']; ?>] = new Array();
	<?php $_from = $this->_var['val']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('i', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['i'] => $this->_var['item']):
?>
	  <?php $_from = $this->_var['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('attr_id', 'attr_val');if (count($_from)):
    foreach ($_from AS $this->_var['attr_id'] => $this->_var['attr_val']):
?>
		arr[<?php echo $this->_var['att_cat_id']; ?>][<?php echo $this->_var['i']; ?>] = ["<?php echo $this->_var['attr_val']; ?>", <?php echo $this->_var['attr_id']; ?>];
	  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

 //修改 by wu
    function changeCat(obj)
    {
            var obj = $(obj);
            var key = obj.data('value');

            if(arr[key]){
                    var tArr = arr[key];
                    var target = obj.parents(".imitate_select").next().find("ul");
                    target.find("li:gt(0)").remove();
                    for(var i=0; i<tArr.length; i++){
                            var line = "<li><a href='javascript:;' data-value='"+tArr[i][1]+"' class='ftx-01'>"+tArr[i][0]+"</a></li>";
                            target.append(line);
                    }
            }
    }
	
	//属性分类筛选出属性类型
	$.divselect("*[ectype='typeCatSelect']","*[ectype='typeCatVal']",function(obj){
		var level = obj.data('level'),
			val = obj.data("value");
		
		get_childcat(obj,2,1);
	});
</script>

</body>
</html>
