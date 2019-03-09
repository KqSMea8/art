<?php if ($this->_var['full_page']): ?>
<!doctype html>
<html>
<?php echo $this->fetch('pageheader.dwt'); ?>
<div class="content">
	<div class="title"><?php echo $this->_var['page_title']; ?></div>
    <div class="explanation" id="explanation">
        <i class="sc_icon"></i>
        <ul>
            <li>门店职员为管理员方便分配权限设定，目前权限暂定为：商品管理、订单管理、职员管理、设置管理。</li>
            <li>添加新职员时请填写正确的邮箱地址，方便找回密码时使用。</li>
        </ul>
    </div>
    <div class="common-head">
    	<a href="<?php echo $this->_var['action_link']['href']; ?>" class="btn btn30 blue_btn ml0" ectype="addAssistant"><?php echo $this->_var['action_link']['text']; ?></a>
        <a href="<?php echo $this->_var['action_link2']['href']; ?>" class="btn btn30 blue_btn ml0" ectype="addAssistant"><?php echo $this->_var['action_link2']['text']; ?></a>
    </div>
    <div class="list-div" id="listDiv">
    	<?php endif; ?>  
        <table class="table table-striped">
            <thead>
                <tr>
                	<th width="5%" class="first">编号</th>
                    <th width="20%"><?php echo $this->_var['lang']['login_name']; ?></th>
                    <th width="20%"><?php echo $this->_var['lang']['tel']; ?></th>
                    <th width="20%"><?php echo $this->_var['lang']['email']; ?></th>
                    <th width="20%"><?php echo $this->_var['lang']['add_time']; ?></th>
                    <th width="15%" class="last"><?php echo $this->_var['lang']['handler']; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list_0_95415500_1514946347');$this->_foreach['assistant'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['assistant']['total'] > 0):
    foreach ($_from AS $this->_var['list_0_95415500_1514946347']):
        $this->_foreach['assistant']['iteration']++;
?>
                <tr>
                    <td class="first"><?php echo $this->_foreach['assistant']['iteration']; ?></td>
                    <td><?php echo $this->_var['list_0_95415500_1514946347']['stores_user']; ?></td>
                    <td><?php echo $this->_var['list_0_95415500_1514946347']['tel']; ?></td>
                    <td><?php echo $this->_var['list_0_95415500_1514946347']['email']; ?></td>
                    <td><?php echo $this->_var['list_0_95415500_1514946347']['add_time']; ?></td>
                    <td class="handle last">
                        <a href="store_assistant.php?act=edit&id=<?php echo $this->_var['list_0_95415500_1514946347']['id']; ?>" class="btn_pencil"><i class="icon icon-pencil"></i><?php echo $this->_var['lang']['edit']; ?></a>
                        <a href="javascript:;" onclick="dialog('delete', {id:<?php echo $this->_var['list_0_95415500_1514946347']['id']; ?>})" title="<?php echo $this->_var['lang']['remove']; ?>" class="btn_trash"><i class="icon icon-trash"></i><?php echo $this->_var['lang']['remove']; ?></a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr class="tfoot"><td class="no-records" colspan="10"><?php echo $this->_var['lang']['no_records']; ?></td></tr>  
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </tbody>
            <tfoot>
            	<tr>
                    <td colspan="10" style="padding-right:26px;"><?php echo $this->fetch('page.dwt'); ?></td>
                </tr>
            </tfoot>
        </table>
		<?php if ($this->_var['full_page']): ?>
    </div>
</div>

<script type="text/javascript">
	listTable.recordCount = <?php echo $this->_var['record_count']; ?>;
	listTable.pageCount = <?php echo $this->_var['page_count']; ?>;
	
	<?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
	listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
<?php echo $this->fetch('pagefooter.dwt'); ?>
<?php endif; ?>