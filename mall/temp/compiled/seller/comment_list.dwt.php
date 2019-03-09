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
                        <form action="javascript:searchComment()" name="searchForm">
							<div class="search-key">
                                <input type="text" name="keyword" class="text text_2" placeholder="<?php echo $this->_var['lang']['search_comment']; ?>" />
                                <input type="submit" class="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" />
                            </div>
                        </form>
                    </div>
                </div>					
                <form method="POST" action="comment_manage.php?act=batch_drop" name="listForm" onsubmit="return confirm_bath()">
                <!-- start comment list -->
                <div class="list-div" id="listDiv">
                <?php endif; ?>
                <table class="ecsc-default-table">
                    <thead>
                        <tr>
                            <th width="8%">
                                <div class="first_all">
                                    <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" class="ui-checkbox" id="all"/>
                                    <label for="all" class="ui-label"><a href="javascript:listTable.sort('comment_id'); "><?php echo $this->_var['lang']['record_id']; ?></a></label>
                                    <?php echo $this->_var['sort_comment_id']; ?>
                                </div>
                            </th>
                            <th width="10%"><a href="javascript:listTable.sort('user_name'); "><?php echo $this->_var['lang']['user_name']; ?></a><div class="img"><?php echo $this->_var['sort_user_name']; ?></div></th>
                            <th width="10%"><a href="javascript:listTable.sort('comment_type'); "><?php echo $this->_var['lang']['comment_type']; ?></a><div class="img"><?php echo $this->_var['sort_comment_type']; ?></div></th>
                            <th width="30%"><a href="javascript:listTable.sort('id_value'); "><?php echo $this->_var['lang']['comment_obj']; ?></a><div class="img"><?php echo $this->_var['sort_id_value']; ?></div></th>
                            <th width="10%"><a href="javascript:listTable.sort('ip_address'); "><?php echo $this->_var['lang']['ip_address']; ?></a><div class="img"><?php echo $this->_var['sort_ip_address']; ?></div></th>
                            <th width="10%"><a href="javascript:listTable.sort('add_time'); "><?php echo $this->_var['lang']['comment_time']; ?></a><div class="img"><?php echo $this->_var['sort_add_time']; ?></div></th>
                            <th width="10%"><?php echo $this->_var['lang']['comment_flag']; ?></th>
                            <th width="10%"><?php echo $this->_var['lang']['handler']; ?></th>
                        </tr>
                  </thead>
                  <tbody>
                  <?php $_from = $this->_var['comment_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
                  <tr class="bd-line">
                    <td class="first_td_checkbox">
                        <div class="first_all">
                            <input value="<?php echo $this->_var['comment']['comment_id']; ?>" name="checkboxes[]" type="checkbox" id="comment_<?php echo $this->_var['comment']['comment_id']; ?>" class="ui-checkbox">
                            <label for="comment_<?php echo $this->_var['comment']['comment_id']; ?>" class="ui-label"><?php echo $this->_var['comment']['comment_id']; ?></label>
                        </div>
                    </td>
                    <td align="center"><?php if ($this->_var['comment']['user_name']): ?><?php echo $this->_var['comment']['user_name']; ?><?php else: ?><?php echo $this->_var['lang']['anonymous']; ?><?php endif; ?></td>
                    <td align="center"><?php echo $this->_var['lang']['type'][$this->_var['comment']['comment_type']]; ?></td>
                    <td align="center"><a href="../<?php if ($this->_var['comment']['comment_type'] == '0' || $this->_var['comment']['comment_type'] == '2' || $this->_var['comment']['comment_type'] == '3'): ?>goods<?php else: ?>article<?php endif; ?>.php?id=<?php echo $this->_var['comment']['id_value']; ?>" target="_blank"><?php echo $this->_var['comment']['title']; ?></a></td>
                    <td align="center"><?php echo $this->_var['comment']['ip_address']; ?></td>
                    <td align="center"><?php echo $this->_var['comment']['add_time']; ?></td>
                    <td align="center"><?php if ($this->_var['comment']['status'] == 0): ?><?php echo $this->_var['lang']['hidden']; ?><?php else: ?><?php echo $this->_var['lang']['display']; ?><?php endif; ?></td>
                    <td class="ecsc-table-handle<?php if ($this->_var['comment_edit_delete']): ?> tr<?php endif; ?>">
                      <span<?php if (! $this->_var['comment_edit_delete']): ?> mr0<?php endif; ?>><a href="comment_manage.php?act=reply&amp;id=<?php echo $this->_var['comment']['comment_id']; ?>" class="btn-green"><i class="icon icon-edit"></i><p><?php echo $this->_var['lang']['edit']; ?></p></a></span>
                      <?php if ($this->_var['comment_edit_delete']): ?>
                      <span><a href="javascript:void(0);" onclick="listTable.remove(<?php echo $this->_var['comment']['comment_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['drop']; ?>" class="btn-red"><i class="icon icon-trash"></i><p><?php echo $this->_var['lang']['drop']; ?></p></a></span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; else: ?>
                  <tr><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>
                  <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                  </tbody>
                  <tfoot>
                    <?php if ($this->_var['comment_edit_delete']): ?>
                    <tr>
                        <td colspan="10" class="td_border">
                            <div class="shenhe">
                                <div id="sel_action" class="imitate_select select_w120">
                                    <div class="cite"><?php echo $this->_var['lang']['please_select']; ?></div>
                                    <ul>
                                        <li><a href="javascript:;" data-value="remove" class="ftx-01"><?php echo $this->_var['lang']['drop_select']; ?></a></li>
                                        <li><a href="javascript:;" data-value="allow" class="ftx-01"><?php echo $this->_var['lang']['allow']; ?></a></li>
                                        <li><a href="javascript:;" data-value="deny" class="ftx-01"><?php echo $this->_var['lang']['forbid']; ?></a></li>
                                    </ul>
                                    <input name="sel_action" type="hidden" value="remove" id="">
                                </div>
                                <input type="hidden" name="act" value="batch" />
                                <input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['button_submit']; ?>" class="sc-btn btn_disabled" disabled="true" />
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="10">
                            <?php echo $this->fetch('page.dwt'); ?>
                        </td>
                    </tr>
                  </tfoot>
                </table>

                <?php if ($this->_var['full_page']): ?>
                </div>
                <!-- end comment list -->
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<script type="text/javascript" language="JavaScript">
<!--
  listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
  listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
  cfm = new Object();
  cfm['allow'] = '<?php echo $this->_var['lang']['cfm_allow']; ?>';
  cfm['remove'] = '<?php echo $this->_var['lang']['cfm_remove']; ?>';
  cfm['deny'] = '<?php echo $this->_var['lang']['cfm_deny']; ?>';

  <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
  listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

  
  onload = function()
  {
      // 开始检查订单
      startCheckOrder();
  }
  /**
   * 搜索评论
   */
  function searchComment()
  {
      var keyword = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
	
      if (keyword.length > 0)
      {
        listTable.filter['keywords'] = keyword;
        listTable.filter.page = 1;
        listTable.loadList();
      }
      else
      {
          document.forms['searchForm'].elements['keyword'].focus();
      }
  }
  

  function confirm_bath()
  {
    var action = document.forms['listForm'].elements['sel_action'].value;

    return confirm(cfm[action]);
  }
//-->
</script>
</body>
</html>
<?php endif; ?>