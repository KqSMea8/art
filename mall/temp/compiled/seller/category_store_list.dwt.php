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
					<?php if ($this->_var['parent_id'] > 0): ?>
                    	<a href="category_store.php?act=list&parent_id=<?php echo $this->_var['parent_id']; ?>&back_level=<?php echo $this->_var['level']; ?>" class="sc-btn sc-blue-btn"><i class="icon icon-reply"></i>&nbsp;返回上一级</a>
					<?php endif; ?>
                    </div>
                </div>
                <div class="list-div" id="listDiv">
                <?php endif; ?>
                <table id="list-table" class="ecsc-default-table">
					<thead>
						<tr>
							<th width="10%" class="tl pl10">级别(<?php echo $this->_var['cat_level']; ?>级)</th>
							<th width="30%" class="tl">分类名称</th>
							<th width="10%">商品数量</th>
							<th width="10%">数量单位</th>
							<th width="10%">价格分级</th>
							<th width="11%">排序</th>
							<th width="7%">是否显示</th>
							<th width="12%" class="handle">操作</th>
						</tr>
					</thead>
					<tbody>
                        <?php $_from = $this->_var['cat_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cat');if (count($_from)):
    foreach ($_from AS $this->_var['cat']):
?>
                        <tr align="center" class="<?php echo $this->_var['cat']['level']; ?>" id="<?php echo $this->_var['cat']['level']; ?>_<?php echo $this->_var['cat']['cat_id']; ?>">
						  <td class="tl pl10">
							<div class="tDiv first_setup">
								<div class="setup_span">
									<em><i class="icon icon-cog"></i>设置<i class="arrow"></i></em>
									<ul>
										<?php if ($this->_var['level'] < 2): ?>
										<li><a href="category_store.php?act=add&parent_id=<?php echo $this->_var['cat']['cat_id']; ?>">新增下一级</a></li>
										<li><a href="category_store.php?act=list&parent_id=<?php echo $this->_var['cat']['cat_id']; ?>&level=<?php echo $this->_var['level']; ?>">查看下一级</a></li>
										<?php endif; ?>
										<li><a href="javascript:void(0);" ectype="transfer_goods" data-cid="<?php echo $this->_var['cat']['cat_id']; ?>">转移商品</a></li>                                      
									</ul>
								</div>
							</div>
						  </td>
                          <td class="first-cell tl" id="level_<?php echo $this->_var['cat']['level']; ?>_<?php echo $this->_var['cat']['cat_id']; ?>">
                              <div class="first_column">
                                <i class="up" id="icon_<?php echo $this->_var['cat']['level']; ?>_<?php echo $this->_var['cat']['cat_id']; ?>" data-level="<?php echo $this->_var['cat']['level']; ?>" data-catid="<?php echo $this->_var['cat']['cat_id']; ?>" data-isclick="0"></i><span><a href="goods.php?act=list&cat_id=<?php echo $this->_var['cat']['cat_id']; ?>&cat_type=seller"><?php echo $this->_var['cat']['cat_name']; ?></a></span>
                              </div>
                              <?php if ($this->_var['cat']['cat_image']): ?>
                              <img src="../<?php echo $this->_var['cat']['cat_image']; ?>" border="0" style="vertical-align:middle;" width="60px" height="21px">
                              <?php endif; ?>
                          </td>
                          <td><?php echo $this->_var['cat']['goods_num']; ?></td>
                          <td><span onclick="listTable.edit(this, 'edit_measure_unit', <?php echo $this->_var['cat']['cat_id']; ?>)"><!-- <?php if ($this->_var['cat']['measure_unit']): ?> --><?php echo $this->_var['cat']['measure_unit']; ?><!-- <?php else: ?> -->&nbsp;&nbsp;&nbsp;&nbsp;<!-- <?php endif; ?> --></span></td>
                          <td><span onclick="listTable.edit(this, 'edit_grade', <?php echo $this->_var['cat']['cat_id']; ?>)"><?php echo $this->_var['cat']['grade']; ?></span></td>
                          <td align="center"><span onclick="listTable.edit(this, 'edit_sort_order', <?php echo $this->_var['cat']['cat_id']; ?>)"><?php echo $this->_var['cat']['sort_order']; ?></span></td>
						  <td>
                            <div class="switch <?php if ($this->_var['cat']['is_show']): ?>active<?php endif; ?>" title="<?php if ($this->_var['cat']['is_show']): ?>是<?php else: ?>否<?php endif; ?>" onclick="listTable.switchBt(this, 'toggle_is_show', <?php echo $this->_var['cat']['cat_id']; ?>)">
                                <div class="circle"></div>
                            </div>
                            <input type="hidden" value="0" name="">
						  </td>
						  <td class="ecsc-table-handle tr">
							  <span><a href="category_store.php?act=edit&amp;cat_id=<?php echo $this->_var['cat']['cat_id']; ?>" class="btn-green"><i class="icon icon-edit"></i><p><?php echo $this->_var['lang']['edit']; ?></p></a></span>
							  <span><a href="javascript:void(0);" onclick="listTable.remove(<?php echo $this->_var['cat']['cat_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" class="btn-red"><i class="icon icon-trash"></i><p><?php echo $this->_var['lang']['drop']; ?></p></a></span>
						  </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td class="no-records" colspan="11"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </tbody>
                    <tfoot>
                        <tr><td colspan="10"><?php echo $this->fetch('page.dwt'); ?></td></tr>
                    </tfoot>
                </table>
                    <?php if ($this->_var['full_page']): ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<script type="text/javascript" src="js/jquery.purebox.js"></script>
<script type="text/javascript">

listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
listTable.pageCount = <?php echo $this->_var['page_count']; ?>;

<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  
//转移分类
$(document).on('click',"*[ectype='transfer_goods']",function(){
	if(confirm('执行此操作时，当前分类所有下级分类也同时转移，确定执行吗？')){
		var cat_id = $(this).data("cid");
		$.jqueryAjax("category_store.php", "act=move&cat_id="+cat_id, function(data){
			var content = data.content;
			pb({
				id:"transfer_dialog",
				title:"转移商品",
				width:732,
				content:content,
				ok_title:"开始转移",
				cl_title:"重置",
				drag:false,
				foot:true,
				onOk:function(){
					$("#moveCategory").submit();
				}
			});
			$.category();  //分类选择
			$(".select-list").hover(function(){
				$(".select-list").perfectScrollbar("destroy");
				$(".select-list").perfectScrollbar();
			});
		});
	}
});
</script>
</body>
</html>
<?php endif; ?>