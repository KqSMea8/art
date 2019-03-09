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
                                <input type="text" name="keyword" class="text text_2" placeholder="<?php echo $this->_var['lang']['search_comment_tlq']; ?>" />
                               <input type="submit" class="submit" value="<?php echo $this->_var['lang']['button_search']; ?>" />
                            </div>
                        </form>
                    </div>
				</div>
                <form method="POST" action="discuss_circle.php?act=batch_drop" name="listForm" onsubmit="return confirm_bath()">
                <div class="list-div" id="listDiv">
                <?php endif; ?>
                <table class="ecsc-default-table">
                  <thead>
                  <tr>
                    <th width="8%">
                      <div class="first_all">
                          <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" class="ui-checkbox" id="all" />
                          <label for="all" class="ui-label"><a href="javascript:listTable.sort('dis_id'); "><?php echo $this->_var['lang']['record_id']; ?></a></label>
                          <?php echo $this->_var['sort_dis_id']; ?>
                      </div>
                    </th>
                    <th width="20%" class="tl"><a href="javascript:listTable.sort('dis_title'); "><?php echo $this->_var['lang']['discuss_title']; ?></a><?php echo $this->_var['sort_add_time']; ?></th>
                    <th width="12%" class="tl"><a href="javascript:listTable.sort('user_name'); "><?php echo $this->_var['lang']['user_name']; ?></a><?php echo $this->_var['sort_user_name']; ?></th>
                    <th width="10%" class="tl"><a href="javascript:listTable.sort('dis_type'); "><?php echo $this->_var['lang']['discuss_type']; ?></a><?php echo $this->_var['sort_comment_type']; ?></th>
                    <th width="26%" class="tl"><a href="javascript:listTable.sort('goods_id'); "><?php echo $this->_var['lang']['discuss_goods']; ?></a><?php echo $this->_var['sort_id_value']; ?></th>
                    <th width="10%"><a href="javascript:listTable.sort('add_time'); "><?php echo $this->_var['lang']['discuss_time']; ?></a><?php echo $this->_var['sort_ip_address']; ?></th>
                    <th width="14%"><?php echo $this->_var['lang']['handler']; ?></th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php $_from = $this->_var['discuss_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'discuss');if (count($_from)):
    foreach ($_from AS $this->_var['discuss']):
?>
                  <tr class="bd-line">
                    <td class="first_td_checkbox">
                        <div class="first_all">
                        <input value="<?php echo $this->_var['discuss']['dis_id']; ?>" name="checkboxes[]" type="checkbox" class="ui-checkbox" id="checkbox_<?php echo $this->_var['discuss']['dis_id']; ?>">
                        <label for="checkbox_<?php echo $this->_var['discuss']['dis_id']; ?>" class="ui-label"><?php echo $this->_var['discuss']['dis_id']; ?></label>
                        </div>
                    </td>
                    <td class="tl"><?php echo $this->_var['discuss']['dis_title']; ?></td>
                    <td class="tl"><?php if ($this->_var['discuss']['user_name']): ?><?php echo $this->_var['discuss']['user_name']; ?><?php else: ?><?php echo $this->_var['lang']['anonymous']; ?><?php endif; ?></td>
                    <td class="tl"><?php if ($this->_var['discuss']['dis_type'] == 1): ?><?php echo $this->_var['lang']['discuss']; ?><?php elseif ($this->_var['discuss']['dis_type'] == 2): ?><?php echo $this->_var['lang']['technology']; ?><?php else: ?><?php endif; ?></td>
                    <td class="tl"><a href="../goods.php?id=<?php echo $this->_var['discuss']['goods_id']; ?>" target="_blank"><?php echo $this->_var['discuss']['goods_name']; ?></a></td>
                    <td><?php echo $this->_var['discuss']['add_time']; ?></td>
                    <td class="ecsc-table-handle tr">
                      <span><a href="discuss_circle.php?act=user_reply&amp;id=<?php echo $this->_var['discuss']['dis_id']; ?>" title="<?php echo $this->_var['lang']['discuss_user_reply']; ?>" class="btn-orange"><i class="icon sc_icon_see"></i><p><?php echo $this->_var['lang']['view']; ?></p></a></span>
                      <span><a href="discuss_circle.php?act=reply&amp;id=<?php echo $this->_var['discuss']['dis_id']; ?>" title="<?php echo $this->_var['lang']['edit']; ?>" class="btn-green"><i class="icon icon-edit"></i><p><?php echo $this->_var['lang']['edit']; ?></p></a></span>
                      <span><a href="javascript:" onclick="listTable.remove(<?php echo $this->_var['discuss']['dis_id']; ?>, '<?php echo $this->_var['lang']['drop_confirm']; ?>')" title="<?php echo $this->_var['lang']['drop']; ?>" class="btn-red"><i class="icon icon-trash"></i><p><?php echo $this->_var['lang']['drop']; ?></p></a></span>
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
                                <input name="sel_action" type="hidden" value="remove">
                              	<input type="submit" name="drop" id="btnSubmit" value="<?php echo $this->_var['lang']['drop']; ?>" class="sc-btn btn_disabled" disabled="true" />
                            </div>
                        </td>
                    </tr>
                    <tr><td colspan="10"><?php echo $this->fetch('page.dwt'); ?></td></tr>
                  </tfoot>
                  </table>
                <?php if ($this->_var['full_page']): ?>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<script type="text/javascript">
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
      startCheckOrder();
  }

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
</script>
</body>
</html>
<?php endif; ?>