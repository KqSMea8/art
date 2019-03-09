<?php if ($this->_var['full_page']): ?>
<!DOCTYPE html>
<html>
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
                    <div class="design-content">
                        <div class="templet">
                            <div class="templet-thumb">
                                <img id="screenshot" src="<?php echo $this->_var['curr_template']['screenshot']; ?>" width="168" height="216">
                            </div>
                            <div class="templet-info">
                                <h3 class="template_tit">当前使用模板</h3>
                                <strong class="template_name"><?php echo $this->_var['curr_template']['name']; ?>&nbsp;<?php echo $this->_var['curr_template']['version']; ?></strong>
                                <span><?php echo $this->_var['curr_template']['desc']; ?></span>
                                <div class="template_desc"><a href="<?php if ($this->_var['curr_template']['author_uri']): ?><?php echo $this->_var['curr_template']['author_uri']; ?><?php else: ?>#<?php endif; ?>" target="_blank"/><?php echo $this->_var['curr_template']['author']; ?></a></div>
                                <input class="button mr10" onclick="backupTemplates('<?php echo $this->_var['curr_template']['code']; ?>')" value="备份该模板模板" type="button">
                            </div>
                            <div class="plat"></div>
                        </div>
                        <div class="tabs">
                            <ul class="qh">
                                <li class="current" data-export='1' ectype="li_type">本店模板</li>
                                <li data-export='0' ectype="li_type">可用的模板</li>
                            </ul>
                            <div class="export">   
                                <div class="btns">
                                    <a href="javascript:void(0);" class="btn btn2 export_tem" ectype='export'>导出</a>
                                    <a href="javascript:void(0);" class="btn btn2 determine" ectype='confirm'>确定</a>
                                    <a href="javascript:void(0);" class="btn btn2 determine" ectype='cancel'>取消</a>
                                    <div id="temp_mode" class="imitate_select select_w145 hide">
                                        <div class="cite">全部模板</div>
                                        <ul>
                                            <li><a href="javascript:;" data-value="0" class="ftx-01">全部模板</a></li>
                                            <li><a href="javascript:;" data-value="2" class="ftx-01">免费模板</a></li>
                                            <li><a href="javascript:;" data-value="1" class="ftx-01">付费模板</a></li>
                                        </ul>
                                        <input name="temp_mode" type="hidden" value="0" id="temp_mode_val"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="template-info">
                            <div class="template-list" data-type="backups" id="backupTemplates">
                                <form method="post" action="visual_editing.php?act=export_tem" name="listForm" id="exportForm">
                                    <ul class="list">
                                        <?php $_from = $this->_var['available_templates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'template');$this->_foreach['template'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['template']['total'] > 0):
    foreach ($_from AS $this->_var['template']):
        $this->_foreach['template']['iteration']++;
?>
                                        <li <?php if ($this->_var['default_tem'] == $this->_var['template']['code']): ?>class="curr"<?php endif; ?> data-name="<?php echo $this->_var['template']['code']; ?>">
                                            <input type="checkbox" class="checkitems" value="<?php echo $this->_var['template']['code']; ?>" name="checkboxes[]">
                                            <div class="tit"><?php echo $this->_var['template']['name']; ?>-<a href="<?php if ($this->_var['template']['author_uri']): ?><?php echo $this->_var['template']['author_uri']; ?><?php else: ?>#<?php endif; ?>" target="_blank" /><?php echo $this->_var['template']['author']; ?></a></div>
                                            <div class="span"><?php echo $this->_var['template']['desc']; ?></div>
                                            <div class="img">
                                                <?php if ($this->_var['template']['screenshot']): ?><img width="263" height="338" src="<?php echo $this->_var['template']['screenshot']; ?>" data-src-wide="<?php echo $this->_var['template']['template']; ?>" border="0" id="<?php echo $this->_var['template']['code']; ?>" class="pic" ectype="pic"> <?php endif; ?>                                       <div class="bg"></div>
                                            </div>
                                            <div class="info">
                                            	<div class="row"><a href="<?php echo $this->_var['template']['template']; ?>" target="_blank" class="mr10" ectype="see">查看大图</a></div>
                                                <div class="row">
                                                    <a href="visual_editing.php?act=first&code=<?php echo $this->_var['template']['code']; ?>" target="_blank" class="mr10">装修</a>
                                                    <a href="javascript:template_information('<?php echo $this->_var['template']['code']; ?>','<?php echo $this->_var['ru_id']; ?>');" class="mr10">编辑模板信息</a>
                                                    <a href="javascript:removeTemplate('<?php echo $this->_var['template']['code']; ?>')">删除模板</a>
                                                </div>
                                            </div>
                                            <div class="box" onclick="javascript:setupTemplate('<?php echo $this->_var['template']['code']; ?>','0')">
                                                <i class="icon icon-gou"></i>
                                                <span>立即使用</span>
                                            </div>
                                            <i class="ing"></i>
                                        </li>
                                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    </ul>
                                </form>
                            </div>
                            <div class="template-list" style="display: none;">
                                <div class="list-div" id="listDiv">
                                <?php endif; ?>
                                <ul class="list">
                                    <?php $_from = $this->_var['default_templates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'template');$this->_foreach['template'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['template']['total'] > 0):
    foreach ($_from AS $this->_var['template']):
        $this->_foreach['template']['iteration']++;
?>
                                    <li <?php if ($this->_var['default_tem'] == $this->_var['template']['code']): ?>class="curr"<?php endif; ?>>
                                        <div class="tit"><?php echo $this->_var['template']['name']; ?>-<a href="<?php if ($this->_var['template']['author_uri']): ?><?php echo $this->_var['template']['author_uri']; ?><?php else: ?>#<?php endif; ?>" target="_blank"/><?php echo $this->_var['template']['author']; ?></a></div>
                                        <div class="span"><?php echo $this->_var['template']['desc']; ?></div>
                                        <div class="img">
                                            <?php if ($this->_var['template']['screenshot']): ?><img width="263" height="338" src="<?php echo $this->_var['template']['screenshot']; ?>" data-src-wide="<?php echo $this->_var['template']['template']; ?>" border="0" id="<?php echo $this->_var['template']['code']; ?>" class="pic" ectype="pic"> <?php endif; ?>                                       <div class="bg"></div>
                                        </div>
                                        <div class="info">
                                            <div class="row">
                                            	<div class="price">价格：<em class="org"><?php if ($this->_var['template']['temp_mode'] == 0): ?>免费<?php else: ?><?php echo $this->_var['template']['temp_cost']; ?><?php endif; ?></em></div>
                                                <div class="sales_volume">销量：<?php echo $this->_var['template']['sales_volume']; ?></div>
                                            </div>    
                                            <div class="row">
                                            	<a href="<?php echo $this->_var['template']['template']; ?>" target="_blank" class="mr10" ectype="see">查看大图</a><?php if ($this->_var['template']['template']): ?><?php endif; ?>
                                                <a href="../merchants_store.php?preview=1&temp_code=<?php echo $this->_var['template']['code']; ?>" target="_blank" class="mr10">预览</a>
                                            </div>
                                        </div>
                                        <div class="box" onclick="javascript:setupTemplate('<?php echo $this->_var['template']['code']; ?>','1','<?php echo $this->_var['template']['temp_id']; ?>','<?php echo $this->_var['template']['temp_mode']; ?>')">
                                            <i class="icon icon-gou"></i>
                                            <span><?php if ($this->_var['template']['temp_mode'] == 0): ?>使用此模板<?php else: ?>购买此模板<?php endif; ?></span>
                                        </div>
                                    </li>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </ul>
                                <?php echo $this->fetch('page.dwt'); ?>
                                <?php if ($this->_var['full_page']): ?>
                        		</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $this->fetch('library/seller_footer.lbi'); ?>
    
    <?php echo $this->smarty_insert_scripts(array('files'=>'spectrum-master/spectrum.js,jquery.purebox.js,../js/plupload.full.min.js,../js/jquery.picTip.js')); ?>
    <script type="text/javascript">
		listTable.recordCount = <?php echo empty($this->_var['record_count']) ? '0' : $this->_var['record_count']; ?>;
		listTable.pageCount = <?php echo empty($this->_var['page_count']) ? '1' : $this->_var['page_count']; ?>;

		<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
		listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		$.divselect("#temp_mode","#temp_mode_val",function(obj){
                        listTable.filter['temp_mode'] =  obj.attr("data-value");
                        listTable.filter['page'] = 1;
                        listTable.loadList();
                });
		$(function(){
                    $(".export").show();
			$(".tabs [ectype='li_type']").click(function(){
				var export_type = $(this).data("export");
				if(export_type == '1'){
                                    $(".export").find('.export_tem').show();
                                    $("#temp_mode").hide();
				}else{
                                    $(".export").find('.export_tem').hide();
                                    $("#temp_mode").show();
				}
				var index = $(this).index();
				$(this).addClass("current").siblings().removeClass("current");
				$(".template-info").find(".template-list").eq(index).show().siblings().hide();
			});

			//导出
			$(document).on("click", "a[ectype='export']", function () {
				$("#backupTemplates").find(".checkitems").show();
				$(".export").find('.determine').show();
				$(".export").find('.export_tem').hide();
			});
			
			//取消
			 $(document).on("click", "a[ectype='cancel']", function () {
				$("#backupTemplates").find(".checkitems").hide();
				$(".export").find('.determine').hide();
				$(".export").find('.export_tem').show();
			});
			
			//确定
			$(document).on("click", "a[ectype='confirm']", function () {
				$("#exportForm").submit();
			})
		});
		
		function setupTemplate(tem,type,temp_id,temp_mode){
			var msg = '启用新的Flash样式将覆盖原来的样式。您确定要启用选定的样式吗？';
			if(temp_mode == 1){
				msg = "确认购买该模板吗？";
			}
			if(confirm(msg)){
				Ajax.call('visual_editing.php', "act=release&type="+type+"&suffix=" + tem + "&temp_id=" + temp_id, setupTemplateResponse, 'POST', 'JSON');
			}
		}
		
		function setupTemplateResponse(data){
			if(data.error == 1 || data.error == 4){
				if(data.error == 4){
					alert("由于您存在购买记录，无需再次购买，模板已直接导入您的模板库！");
				}
				location.href = "visual_editing.php?act=templates";
			}
			else if(data.error == 2){
			   template_mall_pb(data.content);
			}
			else if(data.error == 3){
				if(confirm("改模板您存在购买记录，确定再次购买？")){
					template_mall_pb(data.content);
				}
			}
			else{
				alert(data.content);
			}
		}
		
		function template_mall_pb(content){
			pb({
				id: "template_mall_dialog",
				title: "模板信息",
				width: 945,
				content: content,
				ok_title: "确定",
				drag: true,
				foot: true,
				cl_cBtn: false,
				onOk: function () {
					$("#template_mall_form").submit();
				}
			});
		}
		
		function template_information(code){
			Ajax.call('dialog.php', 'act=template_information' + '&code=' + code, informationResponse, 'POST', 'JSON');
		}
		
		function informationResponse(result){
			 var content = result.content;
			pb({
				id: "template_information",
				title: "模板信息",
				width: 945,
				content: content,
				ok_title: "确定",
				drag: true,
				foot: true,
				cl_cBtn: false,
				onOk: function () {
					$('#information').submit();
				}
			});
		}
		
		function removeTemplate(code){
			if(code){
				if(confirm("确定删除该模板吗？删除后将无法找回！！请谨慎操作！！")){
					Ajax.call('visual_editing.php', "act=removeTemplate&code=" + code, removeTemplateResponse, 'POST', 'JSON');
				}
			}else{
				alert('请选择删除的模板');
			}
		}
		
		function removeTemplateResponse(data){
			if(data.error == 0){
                $("#backupTemplates").html(data.content);
                resetHref();
			}else{
				alert(data.content);
			}
		}
		
		function defaultTemplate(code){
			if(confirm("确定恢复默认模板吗？恢复后将无法找回现在的模板！！请谨慎操作！！")){
				Ajax.call('visual_editing.php', "act=defaultTemplate&code=" + code, '', 'POST', 'JSON');
			}
		}
		
		function backupTemplates(code){
			Ajax.call('dialog.php', 'act=template_information' + '&code=' + code, backupTemplateResponse, 'POST', 'JSON');
		}
		
		function backupTemplateResponse (data){
			var content = data.content;
			pb({
				id: "template_information",
				title: "模板信息",
				width: 945,
				content: content,
				ok_title: "确定",
				drag: true,
				foot: true,
				cl_cBtn: false,
				onOk: function () {
					backupTemplate_entry();
				}
			});
		}
		
		function backupTemplate_entry(){
			var actionUrl = "visual_editing.php?act=backupTemplates";
			$("#information").ajaxSubmit({
				type: "POST",
				dataType: "json",
				url: actionUrl,
				data: {"action": "TemporaryImage"},
				success: function (data) {
					if (data.error == "1") {
						alert(data.content);
					}else{
						$("#backupTemplates").html(data.content);
                                                resetHref();
					}
				},
				async: true
			});
		}
                function resetHref(){
                        var obj = $("#backupTemplates").find("li");                        
                        obj.each(function(){
                               var href = $(this).find("*[ectype='see']").attr("href");
                               $(this).find("*[ectype='see']").attr("href","");
                        });
                        
                        obj.each(function(){
                               var href = $(this).find("*[ectype='pic']").attr("src");
                               $(this).find("*[ectype='pic']").attr("src",href + "?&" + +Math.random());
                        });
                }
	</script>
</body>
</html>
<?php endif; ?>