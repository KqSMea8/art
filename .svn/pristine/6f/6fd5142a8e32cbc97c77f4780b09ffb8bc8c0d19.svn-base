<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><?php echo $this->fetch('library/seller_html_head.lbi'); ?></head>

<body>
<?php echo $this->fetch('library/seller_header.lbi'); ?>
<div class="ecsc-layout">
    <div class="site wrapper">
		<?php echo $this->fetch('library/seller_menu_user.lbi'); ?>
        <div class="ecsc-layout-right">
            <div class="main-content" id="mainContent">
                <div class="top-container">
                    <div class="basic-info">
                    	<div class="ecsc-seller-info">
                        	<div class="store-logo"><img src="<?php echo $this->_var['seller_info']['logo_thumb']; ?>" /></div>
                            <div class="store-info">
                            	<div class="seller-name"><?php echo $this->_var['seller_info']['shop_name']; ?></div>
                                <div class="seller-desc">
                                	<div class="item">
                                    	<span><em>用 户 名：</em><strong><?php echo $this->_var['seller_info']['user_name']; ?></strong></span>
                                        <span class="store-name"><em>店铺名称：</em><strong><a href="../merchants_store.php?merchant_id=<?php echo $this->_var['ru_id']; ?>" target="_blank"><?php echo $this->_var['seller_info']['shopName']; ?></a></strong></span>
                                    </div>
                                    <div class="item">
                                    	<span><em>管理权限：</em><strong>管理员</strong></span>
                                        <span><em>最后登录：</em><strong><?php echo $this->_var['seller_info']['last_login']; ?></strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="list-items">
                                <ul>
                                    <li><a href="order.php?act=list&shipped_deal=shipped_deal">待处理订单<em>(<?php echo $this->_var['order']['shipped_deal']; ?>)</em></a></li>
                                    <li><a href="favourable.php?act=list">当前优惠活动<em>(<?php echo $this->_var['favourable_count']; ?>)</em></a></li>
                                    <li><a href="favourable.php?act=list&fav_dateout=1">即将到期优惠活动<em>(<?php echo $this->_var['favourable_dateout_count']; ?>)</em></a></li>
                                    <li><a href="order.php?act=return_list">退换货订单<em>(<?php echo $this->_var['order']['return_number']; ?>)</em></a></li>
                                    <li><a href="comment_manage.php?act=list&reply=1">待商品回复咨询<em>(<?php echo $this->_var['reply_count']; ?>)</em></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="detail-rate">
                        	<div class="title">店铺动态评分</div>
                            <ul>
                            	<li>
                                	<div class="canvas" data-per="80">
                                        <div class="canvas_wrap">
                                            <div class="circle">
                                                <div class="circle_item circle_left"></div>
                                                <div class="circle_item circle_right wth0"></div>
                                            </div>
                                            <div class="canvas_num"><?php echo $this->_var['merch_cmt']['cmt']['commentRank']['zconments']['score']; ?>分</div>
                                        </div>
                                    </div>
                                    <span>描述相符</span>
                                </li>
                                <li>
                                	<div class="canvas" data-per="70">
                                        <div class="canvas_wrap">
                                            <div class="circle">
                                                <div class="circle_item circle_left"></div>
                                                <div class="circle_item circle_right wth0"></div>
                                            </div>
                                            <div class="canvas_num"><?php echo $this->_var['merch_cmt']['cmt']['commentServer']['zconments']['score']; ?>分</div>
                                        </div>
                                    </div>
                                    <span>服务态度</span>
                                </li>
                                <li>
                                	<div class="canvas" data-per="83.4">
                                        <div class="canvas_wrap">
                                            <div class="circle">
                                                <div class="circle_item circle_left"></div>
                                                <div class="circle_item circle_right wth0"></div>
                                            </div>
                                            <div class="canvas_num"><?php echo $this->_var['merch_cmt']['cmt']['commentDelivery']['zconments']['score']; ?>分</div>
                                        </div>
                                    </div>
                                    <span>发货速度</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="seller-cont">
                    <div class="container_left">
                        <div class="container type-a type-one">
                            <div class="hd">
                                <h3>店铺及商品提示</h3>
                            </div>
                            <div class="content">
                                <ul>
                                    <li><a href="goods.php?act=list&is_on_sale=1" target="_blank">出售中的商品<em>(<?php echo $this->_var['seller_goods_info']['is_sell']; ?>)</em></a></li>
                                    <li><a href="goods.php?act=trash" target="_blank">商品回收站<em>(<?php echo $this->_var['seller_goods_info']['is_delete']; ?>)</em></a></li>
                                    <li><a href="goods.php?act=list&is_on_sale=0" target="_blank">已下架的商品<em>(<?php echo $this->_var['seller_goods_info']['is_on_sale']; ?>)</em></a></li>
                                    <li><a href="goods.php?act=list&stock_warning=1">库存预警商品<em>(<?php echo $this->_var['seller_goods_info']['is_warn']; ?>)</em></a></li>
                                    <li><a href="goods.php?act=list&intro_type=is_new" target="_blank">新品商品数<em>(<?php echo $this->_var['new_count']; ?>)</em></a></li>
                                    <li><a href="goods.php?act=list&intro_type=is_best" target="_blank">精品商品数<em>(<?php echo $this->_var['best_count']; ?>)</em></a></li>
                                    <li><a href="goods.php?act=list&intro_type=is_hot" target="_blank">热销商品数<em>(<?php echo $this->_var['hot_count']; ?>)</em></a></li>
                                    <li><a href="goods.php?act=list&intro_type=is_promote" target="_blank">促销商品数<em>(<?php echo $this->_var['promotion_count']; ?>)</em></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="container type-a type-two">
                            <div class="hd">
                                <h3>交易提示</h3>
                            </div>
                            <div class="content">
                                <ul>
                                	<li><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['unconfirmed']; ?>" target="_blank">待确定<em>(<?php echo $this->_var['order']['unconfirmed']; ?>)</em></a></li>
                                    <li><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['await_pay']; ?>" target="_blank">待付款<em>(<?php echo $this->_var['order']['await_pay']; ?>)</em></a></li>
                                    <li><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['await_ship']; ?>" target="_blank">待发货<em>(<?php echo $this->_var['order']['await_ship']; ?>)</em></a></li>
                                    <li><a href="order.php?act=list&composite_status=<?php echo $this->_var['status']['finished']; ?>" target="_blank">已完成<em>(<?php echo $this->_var['order']['finished']; ?>)</em></a></li>
                                    <li><a href="goods_booking.php?act=list_all" target="_blank">缺货登记<em>(<?php echo $this->_var['booking_goods']; ?>)</em></a></li>
                                    <li><a href="goods.php?act=no_comment" target="_blank">待评价<em>(<?php echo $this->_var['no_comment']; ?>)</em></a></li>
                                    <?php if ($this->_var['complaint_count'] > 0): ?>
                                    <li><a href="complaint.php?act=list" target="_blank">交易纠纷<em>(<?php echo $this->_var['complaint_count']; ?>)</em></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container_right">
                        <div class="container type-b type-b-one">
                            <div class="hd">
                                <h3>商家帮助</h3>
                            </div>
                            <div class="content">
                                <ul>
                                    <?php $_from = $this->_var['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');if (count($_from)):
    foreach ($_from AS $this->_var['vo']):
?>
                                    <li><a target="_blank" href="../article.php?id=<?php echo $this->_var['vo']['article_id']; ?>" title="<?php echo $this->_var['vo']['title']; ?>"><?php echo $this->_var['vo']['title']; ?></a></li>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="container type-b type-b-two">
                            <div class="hd">
                                <h3>联系方式</h3>
                            </div>
                            <div class="content">
                                <ul>
                                    <li>电话：<?php echo $this->_var['seller_info']['kf_tel']; ?></li>
                                    <li>邮箱：<?php echo $this->_var['seller_info']['seller_email']; ?></li>
                                    <li>地址：<?php echo $this->_var['seller_info']['shop_address']; ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="seller-cont">
                	<div class="hd">
                        <h3>店铺数据<font style="font-size:12px; color:#7d7d7d">（已成交付款为准：已付款订单）</font></h3>
                    </div>
                    <div class="main-left">
                    	<div class="container">
                            <div class="container-left"><i class="shop-icon shop-icon-pc"></i></div>
                            <div class="container-right">
                                <ul>
                                    <li>今日PC客单价<p><?php echo empty($this->_var['today_sales']['format_sales']) ? '0' : $this->_var['today_sales']['format_sales']; ?></p></li>
                                    <li>今日PC成交额<p><?php echo empty($this->_var['today_sales']['format_count']) ? '0' : $this->_var['today_sales']['format_count']; ?></p></li>
                                    <li>今日PC子订单数<p><?php echo empty($this->_var['today_sub_order']['sub_order']) ? '0' : $this->_var['today_sub_order']['sub_order']; ?></p></li>
                                </ul>
                                <ul>
                                    <li>昨日PC客单价<p><?php echo empty($this->_var['yes_sales']['format_sales']) ? '0' : $this->_var['yes_sales']['format_sales']; ?></p></li>
                                    <li>昨日PC成交额<p><?php echo empty($this->_var['yes_sales']['format_count']) ? '0' : $this->_var['yes_sales']['format_count']; ?></p></li>
                                    <li>昨日PC子订单数<p><?php echo empty($this->_var['yes_sub_order']['sub_order']) ? '0' : $this->_var['yes_sub_order']['sub_order']; ?></p></li>
                                </ul>
                            </div>
                        </div>
                        <div class="container">
                            <div class="container-left"><i class="shop-icon shop-icon-move"></i></div>
                            <div class="container-right">
                                <ul>
                                    <li>今日移动客单价<p><?php echo empty($this->_var['today_move_sales']['format_sales']) ? '0' : $this->_var['today_move_sales']['format_sales']; ?></p></li>
                                    <li>今日移动成交额<p><?php echo empty($this->_var['today_move_sales']['format_count']) ? '0' : $this->_var['today_move_sales']['format_count']; ?></p></li>
                                    <li>今日移动子订单数<p><?php echo empty($this->_var['today_move_sub_order']['sub_order']) ? '0' : $this->_var['today_move_sub_order']['sub_order']; ?></p></li>
                                </ul>
                                <ul>
                                    <li>昨日移动客单价<p><?php echo empty($this->_var['yes_move_sales']['format_sales']) ? '0' : $this->_var['yes_move_sales']['format_sales']; ?></p></li>
                                    <li>昨日移动成交额<p><?php echo empty($this->_var['yes_move_sales']['format_count']) ? '0' : $this->_var['yes_move_sales']['format_count']; ?></p></li>
                                    <li>昨日移动子订单数<p><?php echo empty($this->_var['yes_move_sub_order']['sub_order']) ? '0' : $this->_var['yes_move_sub_order']['sub_order']; ?></p></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                	<div class="main-right">
                    	今日总成交额<p><?php echo empty($this->_var['all_count']) ? '0' : $this->_var['all_count']; ?></p>
                        今日全店成交转化率<p><?php echo $this->_var['cj']; ?></p>
                    </div>
                </div>
                <div class="rank-container">
                	<div class="container type-a">
                        <div class="hd">
                            <h3>单品销售排名</h3>
                        </div>
                        <div class="content">
                            <table class="ecsc-default-table rank">
                            <thead>
                                <tr>
                                    <th width="20%" class="frist">排名</th>
                                    <th width="70%" class="tl">商品信息</th>
                                    <th width="10%">销量(件)</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $_from = $this->_var['goods_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'vo');$this->_foreach['goods_info'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods_info']['total'] > 0):
    foreach ($_from AS $this->_var['vo']):
        $this->_foreach['goods_info']['iteration']++;
?>
                            <tr class="bd-line2">
                                <td class="frist"><?php echo $this->_foreach['goods_info']['iteration']; ?></td>
                                <td class="tl"><a target="_blank" href="../goods.php?id=<?php echo $this->_var['vo']['goods_id']; ?>" class="goods_name"> <?php echo $this->_var['vo']['goods_name']; ?></a></td>
                                <td class="tc"><?php echo $this->_var['vo']['goods_shipping_total']; ?></td>
                            </tr>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container type-a">
                        <div class="hd">
                            <h3>销售情况统计<font style="font-size:12px; color:#7d7d7d">（已成交付款为准：已付款订单）</font></h3>
                        </div>
                        <div class="content">
                            <table class="ecsc-default-table count">
                            <thead>
                                <tr>
                                    <th width="10%" class="frist">项目</th>
                                    <th width="70%">订单量(笔)</th>
                                    <th width="20%">订单金额(元)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bd-line2">
                                    <td class="frist">昨日销量</td>
                                    <td><?php echo $this->_var['yseterday_shipping_info']['order_total']; ?></td>
                                    <td><?php echo $this->_var['yseterday_shipping_info']['money_total']; ?></td>
                                </tr>
                                <tr class="bd-line2">
                                    <td>月销量</td>
                                    <td><?php echo $this->_var['month_shipping_info']['order_total']; ?></td>
                                    <td><?php echo $this->_var['month_shipping_info']['money_total']; ?></td>
                                </tr>
                                <tr class="bd-line2">
                                    <td>总销量</td>
                                    <td><?php echo $this->_var['total_shipping_info']['order_total']; ?></td>
                                    <td><?php echo $this->_var['total_shipping_info']['money_total']; ?></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->fetch('library/seller_footer.lbi'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.purebox.js')); ?>
<script type="text/javascript">
	$(".canvas").each(function(){
		var per = $(this).data("per");
		if(per>50){
			$(this).find('.circle').addClass('clip-auto');
			$(this).find('.circle_right').removeClass('wth0');
		}
		$(this).find(".circle_left").css("-webkit-transform","rotate("+(18/5)*per+"deg)");
	});
</script>
</body>
</html>
