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
                    <form name="theForm" method="post" action="goods_batch.php?act=edit" onsubmit="return getGoodsIDs()">
                        <div class="wrapper-list border1 step" ectype="filter" data-filter="goods">
                            <dl class="notBg">
                                <dt><?php echo $this->_var['lang']['select_method']; ?></dt>
                                <dd>
                                    <div class="checkbox_items">
                                        <div class="checkbox_item">
                                            <input name="select_method" id="sm_cat" type="radio" class="ui-radio" value="cat" checked onclick="toggleSelectMethod(this.value)">
                                            <label for="sm_cat" class="ui-radio-label"><?php echo $this->_var['lang']['by_cat']; ?></label>
                                        </div>
                                        <div class="checkbox_item">
                                            <input name="select_method" id="sm_sn" type="radio" class="ui-radio" value="sn" onclick="toggleSelectMethod(this.value)">
                                            <label for="sm_sn" class="ui-radio-label"><?php echo $this->_var['lang']['by_sn']; ?></label>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <div id="cat_batch">
                                <dl class="notBg border-bottom0">
                                     <div class="goods_search_div pt10">
                                        <div class="search_select">
                                            <div class="categorySelect">
                                                <div class="selection">
                                                    <input type="text" name="category_name" id="category_name" class="text w250 valid" value="请选择分类" autocomplete="off" readonly data-filter="cat_name" />
                                                    <input type="hidden" name="category_id" id="category_id" value="0" data-filter="cat_id" />
                                                </div>
                                                <div class="select-container" style="display:none;">
                                                    <?php echo $this->fetch('library/filter_category.lbi'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="search_select">
                                            <div class="brandSelect">
                                                <div class="selection">
                                                    <input type="text" name="brand_name" id="brand_name" class="text w120 valid" value="请选择品牌" autocomplete="off" readonly data-filter="brand_name" />
                                                    <input type="hidden" name="brand_id" id="brand_id" value="0" data-filter="brand_id" />
                                                </div>
                                                <div class="brand-select-container" style="display:none;">
                                                    <?php echo $this->fetch('library/filter_brand.lbi'); ?>
                                                </div>
                                            </div>                            
                                        </div>
                                        <input type="text" name="keyword" class="text text_2 mr10" value="" placeholder="请输入关键字" data-filter="keyword" autocomplete="off" />
                                        <a href="javascript:void(0);" class="sc-btn sc-blueBg-btn" ectype="search">搜索</a>
                                    </div>
                                </dl>

                                <dl class="notBg pt0">
                                    <div class="move_div mt0">
                                        <div class="move_left">
                                            <h4>待选列表</h4>
                                            <div class="move_info">
                                                <div class="move_list">
                                                    <?php echo $this->fetch('library/move_left.lbi'); ?>
                                                </div>
                                            </div>
                                            <div class="move_handle">
                                                <a href="javascript:void(0);" class="sc-btn btn25 moveAll" ectype="moveAll">全选</a>
                                                <a href="javascript:void(0);" class="sc-btn btn25 sc-blueBg-btn" ectype="sub" data-operation="add_edit_goods">确定</a>
                                            </div>
                                        </div>
                                        <div class="move_middle">
                                            <div class="move_point" data-operation="add_edit_goods"></div>
                                        </div>
                                        <div class="move_right">
                                            <h4>已选列表</h4>
                                            <div class="move_info">
                                                <div class="move_list">
                                                    <?php echo $this->fetch('library/move_right.lbi'); ?>	
                                                </div>
                                            </div>
                                            <div class="move_handle">
                                                <a href="javascript:void(0);" class="sc-btn btn25 moveAll" ectype="moveAll">全选</a>
                                                <a href="javascript:void(0);" class="sc-btn btn25 sc-blueBg-btn" ectype="sub" data-operation="drop_edit_goods">移除</a>
                                            </div>
                                        </div>
                                    </div>
                                </dl>
                            </div>
                            <div id="sn_batch" style="display:none">
                                <dl>
                                    <dt><?php echo $this->_var['lang']['input_sn']; ?></dt>
                                    <dd>
                                        <textarea name="sn_list" rows="10" cols="40" id="sn_list" class="textarea"></textarea>
                                        <div class="notic">（每行一个）</div>
                                    </dd>
                                </dl>
                            </div>
                            <dl class="notBg">
                                <dt><?php echo $this->_var['lang']['edit_method']; ?></dt>
                                <dd>
                                    <div class="checkbox_items">
                                        <div class="checkbox_item">
                                            <input name="edit_method" type="radio" class="ui-radio" id="edit_method_each" value="each" checked>
                                                <label for="edit_method_each" class="ui-radio-label"><?php echo $this->_var['lang']['edit_each']; ?></label>
                                        </div>
                                        <div class="checkbox_item">
                                            <input type="radio" name="edit_method" class="ui-radio" id="edit_method_all" value="all">
                                                <label for="edit_method_all" class="ui-radio-label"><?php echo $this->_var['lang']['edit_all']; ?></label>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                            <dl class="button_info">
                            	<dt>&nbsp;</dt>
                                <dd>
                                	<input type="submit" name="submit" value="<?php echo $this->_var['lang']['go_edit']; ?>" class="sc-btn sc-blueBg-btn btn35" />
                                	<input type="hidden" name="goods_ids" value="" />
                                </dd>
                            </dl>
                        </div>
                    </form>
                  </div>
                </div>					
                <!--end-->
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>

<script language="JavaScript">
  var ele = document.forms['theForm'].elements;

  onload = function()
  {
    // 开始检查订单
      startCheckOrder();
  }

  /**
   * 切换选择商品方式：
   * @param: method 当前方式 cat sn
   */
  function toggleSelectMethod(method)
  {
    if (method == 'cat')
    {
        $("#cat_batch").css('display','');
        $("#sn_batch").css('display','none');
    }
    else
    {
        $("#cat_batch").css('display','none');
        $("#sn_batch").css('display','');
    }

  }

  
//取得选择的商品id，赋值给隐藏变量。同时检查是否选择或输入了商品
    function getGoodsIDs()
    {
            if (document.getElementById('sm_cat').checked)
            {
                    var idArr = new Array();
                    //获取商品id
                    $(".step[ectype=filter] .move_right .move_list ul li.current").each(function(){
                            idArr.push($(this).data("value"));
                    });

                    if (idArr.length <= 0)
                    {
                            alert(please_select_goods);
                            return false;
                    }
                    else
                    {
                            document.forms['theForm'].elements['goods_ids'].value = idArr.join(',');
                            return true;
                    }
            }
            else
            {
                    if (document.forms['theForm'].elements['sn_list'].value == '')
                    {
                            alert(please_input_sn);
                            return false;
                    }
                    else
                    {
                            return true;
                    }
            }
    }
  
</script>

</body>
</html>