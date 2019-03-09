<!--<?php if ($this->_var['page_count'] > 1): ?>-->
<div id="turn-page">
    <div class="pagination">
        <ul>
            <!--<li><?php if ($this->_var['filter']['page'] != 1): ?><a href="javascript:listTable.gotoPageFirst()"><?php endif; ?><span>首页</span><?php if ($this->_var['filter']['page'] != 1): ?></a><?php endif; ?></li>-->
            <li<?php if ($this->_var['filter']['page'] == 1): ?> class="curr"<?php endif; ?>><?php if ($this->_var['filter']['page'] != 1): ?><a href="javascript:listTable.gotoPagePrev()"><?php endif; ?><span class="prev">1</span><?php if ($this->_var['filter']['page'] != 1): ?></a><?php endif; ?></li>
            <?php $_from = $this->_var['page_count_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'page_count_0_46455300_1514946463');$this->_foreach['pageCount'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pageCount']['total'] > 0):
    foreach ($_from AS $this->_var['page_count_0_46455300_1514946463']):
        $this->_foreach['pageCount']['iteration']++;
?>
            <?php if ($this->_var['page_count_0_46455300_1514946463'] == $this->_var['filter']['page']): ?>
                <li><span class="currentpage"><?php echo $this->_var['page_count_0_46455300_1514946463']; ?></span></li>
            <?php else: ?>
                <li><a href="javascript:listTable.gotoPage(<?php echo $this->_var['page_count_0_46455300_1514946463']; ?>)"><span><?php echo $this->_var['page_count_0_46455300_1514946463']; ?></span></a></li>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <li<?php if ($this->_var['filter']['page'] == $this->_var['filter']['page_count']): ?> class="curr"<?php endif; ?>><?php if ($this->_var['filter']['page'] != $this->_var['filter']['page_count']): ?><a href="javascript:listTable.gotoPageNext()"><?php endif; ?><span class="next">1</span><?php if ($this->_var['filter']['page'] != $this->_var['filter']['page_count']): ?></a><?php endif; ?></li>
            <!--<li><?php if ($this->_var['filter']['page'] != $this->_var['filter']['page_count']): ?><a href="javascript:listTable.gotoPageLast()" class="last"><?php endif; ?><span>末页</span><?php if ($this->_var['filter']['page'] != $this->_var['filter']['page_count']): ?></a><?php endif; ?></li>-->
        </ul>
    </div>    
</div>
<!--<?php endif; ?>-->