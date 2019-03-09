<?php if ($this->_var['full_page']): ?>
<!doctype html>
<html>
<?php echo $this->fetch('pageheader.dwt'); ?>
<div class="content">
	<div class="title"><?php echo $this->_var['page_title']; ?></div>
    <div class="explanation" id="explanation">
        <i class="sc_icon"></i>
        <ul>
            <li>门店商品默认为网店所有的商品，通过增加库存添加门店商品，门店商品库存根据门店实际库存添加，与系统库存无关。</li>
            <li>请详细填写有属性的商品库存，以免影响下单。</li>
            <li>一键同步功能是一键同步系统库存，请谨慎操作</li>
        </ul>
    </div>
    <div class="common-head">
    	<div class="search">
            <input type="text" class="text" name="keyword" placeholder="请输入关键字" />
            <?php if ($this->_var['brand_list']): ?>
            <div class="imitate_select w150 ml10">
                <div class="cite">品牌</div>
                <ul>
                    <li><a href="javascript:;" data-value="-1" class="ftx-01">全部品牌</a></li>
                    <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['value']):
?>
                    <li><a href="javascript:;" data-value="<?php echo $this->_var['key']; ?>" title="<?php echo $this->_var['value']; ?>" class="ftx-01"><?php echo $this->_var['value']; ?></a></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                <input name="brand_id" type="hidden" value="-1">
            </div>
            <?php endif; ?>
            <?php if ($this->_var['filter_category_list']): ?>
            <div id="cat_id1" class="imitate_select w150 ml10">
                <div class="cite">分类</div>
                <ul>
                    <li><a href="javascript:;" data-value="-1" data-level="1" class="ftx-01">全部分类</a></li>
                    <?php $_from = $this->_var['filter_category_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['value']):
?>
                    <li><a href="javascript:;" data-value="<?php echo $this->_var['value']['cat_id']; ?>" data-level="1" title="<?php echo $this->_var['value']['cat_name']; ?>" class="ftx-01"><?php echo $this->_var['value']['cat_name']; ?></a></li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                <input type="hidden" value="" id="cat_id_val1">
            </div>
            <?php endif; ?>
            <div class="imitate_select w150 ml10">
                <div class="cite">商品状态</div>
                <ul>
                    <li><a href="javascript:;" data-value="-1"  class="ftx-01">全部</a></li>
                    <li><a href="javascript:;" data-value="1" class="ftx-01">有库存</a></li>
                    <li><a href="javascript:;" data-value="2" class="ftx-01">无库存</a></li>
                </ul>
                <input type="hidden" name="goods_type" value="-1" >
            </div>
            <input name="cat_id" type="hidden" value="-1">
            <button class="btn" name="search" onclick="searchGoods()">搜索</button>
        </div>
    </div>
        <form method="POST" action="goods.php?is_ajax=1&act=batch_goods_number" name="listForm" id="listForm" onsubmit="return false;" >
            <div class="list-div" id="listDiv">
                <?php endif; ?>  
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%" class="first sign"><input type="checkbox" name="all_list" class="checkbox hide" id="all_list" /><label for="all_list" class="checkbox_stars"></label></th>
                            <th width="6%" class="tl">编号</th>
                            <th width="45%" class="tl"><?php echo $this->_var['lang']['goods_name']; ?></th>
                            <th width="12%"><?php echo $this->_var['lang']['goods_sn']; ?></th>
                            <th width="12%"><?php echo $this->_var['lang']['shop_price']; ?></th>
                            <th width="10%"><?php echo $this->_var['lang']['store_inventory']; ?></th>
                            <th width="10%" class="last"><?php echo $this->_var['lang']['handler']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['goods']):
?>
                        <tr>
                            <td class="first sign"><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_var['goods']['goods_id']; ?>" class="checkbox hide" id="checkbox_<?php echo $this->_var['goods']['goods_id']; ?>" /><label for="checkbox_<?php echo $this->_var['goods']['goods_id']; ?>" class="checkbox_stars"></label></td>
                            <td class="tl"><?php echo $this->_var['goods']['goods_id']; ?></td>
                            <td class="tl">
                                <div class="product">
                                    <div class="img"><img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="45" height="45" /></div>
                                    <div class="name">
                                        <a href="../goods.php?id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a>
                                        <?php if ($this->_var['goods']['have_goods_attr']): ?><span style="color:red;">（<?php echo $this->_var['lang']['have_attr']; ?>）</span><?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $this->_var['goods']['goods_sn']; ?></td>
                            <td><?php echo $this->_var['goods']['formated_shop_price']; ?></td>
                            <td><?php echo $this->_var['goods']['store_goods_number']; ?></td>
                            <td class="handle last"><a href="goods.php?act=info&goods_id=<?php echo $this->_var['goods']['goods_id']; ?>&page=<?php echo $this->_var['filter']['page']; ?>" class="btn_pencil"><i class="icon icon-pencil"></i>库存</a></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr class="tfoot"><td class="no-records" colspan="11"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <div class="tfoot_btninfo fl ml20">
                                    <input type="hidden" name="page" value="<?php echo $this->_var['filter']['page']; ?>">
                                    <input type="submit" value="一键同步库存" name="remove" ectype="btnSubmit" class="btn btn_disabled" disabled="">
                                </div>
                                <?php echo $this->fetch('page.dwt'); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <?php if ($this->_var['full_page']): ?>
            </div>
        </form>
</div>
<script>
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  
  function searchGoods()
  {
    var keyword = $("input[name=keyword]").val();
    listTable.filter['keyword'] = Utils.trim(keyword);
    listTable.filter['cat_id'] = Utils.trim($("input[name='cat_id']").val());
    listTable.filter['brand_id'] = Utils.trim($("input[name='brand_id']").val());
    listTable.filter['goods_type'] = Utils.trim($("input[name='goods_type']").val());
	listTable.filter['page'] = 1;
	listTable.loadList();
  }
  function resize(){
	var height = $(".content").height();
	var wheight = $(window).height();
	if(wheight>height){
		$(".footer").css({"position":"absolute","bottom":0});
	}else{
		$(".footer").css({"position":"static","bottom":0});
	}
  }
  $.divselect("#cat_id1","#cat_id_val1",function(obj){
    var val = obj.attr("data-value");
    var level = obj.attr("data-level");
    $("input[name='cat_id']").val(val);
   if(val > 0){
        movecatList(val,level);
    }
});
 $.divselect("#cat_id2","#cat_id_val2",function(obj){
    var val = obj.attr("data-value");
    var level = obj.attr("data-level");
    $("input[name='cat_id']").val(val);
    if(val > 0){
        movecatList(val,level);
    }
});
 $.divselect("#cat_id3","#cat_id_val3",function(obj){
    var val = obj.attr("data-value");
    var level = obj.attr("data-level");
});
function movecatList(val,level){
    Ajax.call('goods.php?is_ajax=1&act=sel_cat_goodslist', 'cat_id='+val+'&cat_level='+level, movecatListResponse, 'GET', 'JSON');
}
function movecatListResponse(result){
     var response = result.content;
    var cat_level = result.cat_level; // 分类级别， 1为顶级分类
    for(var i=cat_level;i<10;i++)
    {
      $("#cat_id"+Number(i+1)).hide();
    }
    if(response)
    {
        $("#cat_id"+cat_level).after(response);
    }
}
//保存商品库存
$(function(){
	$(document).on("click","[ectype='btnSubmit']",function(){
    	send_form_data("form[name=listForm]");
	});
});
</script>
<?php echo $this->fetch('pagefooter.dwt'); ?>
<?php endif; ?>