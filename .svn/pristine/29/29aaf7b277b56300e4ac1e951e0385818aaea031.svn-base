<?php if ($this->_var['dialog_type'] == 'delete'): ?>
<div class="remove">
    <div class="dialog_head">
        <div class="icon_title"></div>
    </div>
    <div class="dialog_content">
        <h3>确定删除？</h3>
        <p>您确实删除该职员吗？</p>
        <i class="bg_yuan1"></i>
        <i class="bg_yuan2"></i>
    </div>
</div>
<?php elseif ($this->_var['dialog_type'] == 'success' || $this->_var['dialog_type'] == 'ajaxfail'): ?>
<div class="<?php if ($this->_var['dialog_type'] == 'success'): ?>success<?php else: ?>fail<?php endif; ?>">
    <div class="dialog_head">
        <div class="icon_title"></div>
    </div>
    <div class="dialog_content">
        <h3><?php echo $this->_var['message']; ?></h3>
        <p>如果你不做出选择，将在</p>
        <i class="bg_yuan1"></i>
        <i class="bg_yuan2"></i>
    </div>
    <div class="dialog_foot">
        <a href="goods.php?act=list&page=<?php echo $this->_var['page']; ?>">门店商品</a>
        <a href="order.php?act=list">订单列表</a>
    </div>
</div>
<?php elseif ($this->_var['dialog_type'] == 'failure'): ?>
<div class="fail">
    <div class="dialog_head">
        <div class="icon_title"></div>
    </div>
    <div class="dialog_content">
        <h3><?php echo $this->_var['message']; ?></h3>
        <p>如果你不做出选择，将在</p>
        <i class="bg_yuan1"></i>
        <i class="bg_yuan2"></i>
    </div>
</div>
<?php endif; ?>