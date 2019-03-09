<?php
//艺术者  禁止倒卖 一经发现停止任何服务 QQ:123456
function cat_list_one_new($cat_id = 0, $cat_level = 0, $sel_cat)
{
	if ($cat_id == 0) {
		$arr = cat_list($cat_id);
		return $arr;
	}
	else {
		$arr = cat_list($cat_id);

		foreach ($arr as $key => $value) {
			if ($key == $cat_id) {
				unset($arr[$cat_id]);
			}
		}

		$str = '';

		if ($arr) {
			$cat_level++;

			switch ($sel_cat) {
			case 'sel_cat_edit':
				$str .= '<select name=\'catList' . $cat_level . '\' id=\'cat_list' . $cat_level . '\' onchange=\'getGoods(this.value, ' . $cat_level . ')\' class=\'select\'>';
				break;

			case 'sel_cat_picture':
				$str .= '<select name=\'catList' . $cat_level . '\' id=\'cat_list' . $cat_level . '\' onchange=\'goods_list(this, ' . $cat_level . ')\' class=\'select\'>';
				break;

			case 'sel_cat_goodslist':
				$str .= '<select class=\'select mr10\' name=\'movecatList' . $cat_level . '\' id=\'move_cat_list' . $cat_level . '\' onchange=\'movecatList(this.value, ' . $cat_level . ')\'>';
				break;

			default:
				break;
			}

			$str .= '<option value=\'0\'>全部分类</option>';

			foreach ($arr as $key1 => $value1) {
				$str .= '<option value=\'' . $value1['cat_id'] . '\'>' . $value1['cat_name'] . '</option>';
			}

			$str .= '</select>';
		}

		return $str;
	}
}

function add_link($extension_code = '')
{
	$href = 'goods.php?act=add';

	if (!empty($extension_code)) {
		$href .= '&extension_code=' . $extension_code;
	}

	if ($extension_code == 'virtual_card') {
		$text = $GLOBALS['_LANG']['51_virtual_card_add'];
	}
	else {
		$text = $GLOBALS['_LANG']['02_goods_add'];
	}

	return array('href' => $href, 'text' => $text, 'class' => 'icon-plus');
}

function get_order_no_comment_goods($ru_id = 0, $sign = 0)
{
	$where = ' AND oi.order_status ' . db_create_in(array(OS_CONFIRMED, OS_SPLITED)) . '  AND oi.shipping_status = \'' . SS_RECEIVED . '\' AND oi.pay_status ' . db_create_in(array(PS_PAYED));
	$where .= ' AND (SELECT count(*) FROM ' . $GLOBALS['ecs']->table('order_info') . ' AS oi2 WHERE oi2.main_order_id = og.order_id) = 0 ';

	if ($sign == 0) {
		$where .= ' AND (SELECT count(*) FROM ' . $GLOBALS['ecs']->table('comment') . (' AS c WHERE c.comment_type = 0 AND c.id_value = g.goods_id AND c.rec_id = og.rec_id AND c.parent_id = 0 AND c.ru_id = \'' . $ru_id . '\') = 0 ');
	}

	$sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('order_info') . ' AS oi ON og.order_id = oi.order_id ' . 'LEFT JOIN  ' . $GLOBALS['ecs']->table('goods') . ' AS g ON og.goods_id = g.goods_id ' . ('WHERE og.ru_id = \'' . $ru_id . '\' ' . $where . ' ');
	$filter['record_count'] = $GLOBALS['db']->getOne($sql);
	$filter = page_and_size($filter);
	$sql = 'SELECT og.*, oi.*,g.goods_thumb, u.user_name FROM ' . $GLOBALS['ecs']->table('order_goods') . ' AS og ' . 'LEFT JOIN ' . $GLOBALS['ecs']->table('order_info') . ' AS oi ON og.order_id = oi.order_id ' . 'LEFT JOIN  ' . $GLOBALS['ecs']->table('goods') . ' AS g ON og.goods_id = g.goods_id ' . 'LEFT JOIN  ' . $GLOBALS['ecs']->table('users') . ' AS u ON u.user_id = oi.user_id ' . ('WHERE og.ru_id = \'' . $ru_id . '\' ' . $where . ' ') . ' ORDER BY oi.order_id DESC ' . ' LIMIT ' . $filter['start'] . (',' . $filter['page_size']);
	$arr = $GLOBALS['db']->getAll($sql);
	return $arr;
}

function list_link($is_add = true, $extension_code = '')
{
	$href = 'goods.php?act=list';

	if (!empty($extension_code)) {
		$href .= '&extension_code=' . $extension_code;
	}

	if (!$is_add) {
		$href .= '&' . list_link_postfix();
	}

	if ($extension_code == 'virtual_card') {
		$text = $GLOBALS['_LANG']['50_virtual_card_list'];
	}
	else {
		$text = $GLOBALS['_LANG']['01_goods_list'];
	}

	return array('href' => $href, 'text' => $text);
}

define('IN_ECS', true);

require dirname(__FILE__) . '/includes/init.php';
require_once ROOT_PATH . '/' . SELLER_PATH . '/includes/lib_goods.php';
include_once ROOT_PATH . '/includes/cls_image.php';
$image = new cls_image($_CFG['bgcolor']);
$exc = new exchange($ecs->table('goods'), $db, 'goods_id', 'goods_name');
$exc_extend = new exchange($ecs->table('goods_extend'), $db, 'goods_id', 'extend_id');
$exc_gallery = new exchange($ecs->table('goods_gallery'), $db, 'img_id', 'goods_id');
$smarty->assign('menus', $_SESSION['menus']);
$smarty->assign('action_type', 'goods');

if(empty($api)){
	$admin_id = get_admin_id();
	$adminru = get_admin_ru_id();
}else{
	$_REQUEST['act'] =$_POST['act'];
	$api=isset($_POST['is_api'])?$_POST['is_api']:0;
	$user_id=isset($_POST['user_id'])?$_POST['user_id']:0;
	$adminru['ru_id']=$user_id; 
}
$admin_id = get_admin_id();
$adminru = get_admin_ru_id();
if ($adminru['ru_id'] == 0) {
	$smarty->assign('priv_ru', 1);
}
else {
	$smarty->assign('priv_ru', 0);
}
$ru_id = $adminru['ru_id'];
$smarty->assign('review_goods', $GLOBALS['_CFG']['review_goods']);
$commission_setting = admin_priv('commission_setting', '', false);
$smarty->assign('commission_setting', $commission_setting);
if(empty($_POST)){
	$attr_id_1 =$db->getOne('select attr_id from' . $ecs->table('attribute') . ' WHERE (attr_name ="装裱" \'\')');//获取装裱的属性id
	$attr_id_2 =$db->getOne('select attr_id from' . $ecs->table('attribute') . ' WHERE (attr_name ="收藏证书" \'\')');//获取收藏证书的id
	$attr_id_3 =$db->getOne('select attr_id from' . $ecs->table('attribute') . ' WHERE (attr_name ="版画规格" \'\')');//获取收藏证书的id
	$attr_id_4 =$db->getOne('select attr_id from' . $ecs->table('attribute') . ' WHERE (attr_name ="创作年份" \'\')');//获取收藏证书的id
	$attr_id_5 =$db->getOne('select attr_id from' . $ecs->table('attribute') . ' WHERE (attr_name ="画布类型" \'\')');//获取收藏证书的id
	$cat_info =$db->query('select cat_name,cat_id from' . $ecs->table('category') . ' WHERE ( is_show = "1" and (cat_name ="版画" OR cat_name ="原作") )');//获取收藏证书的id
	while ($row = $db->fetchRow($cat_info)) {
		$category_info[]=array(
				'cat_name'=>$row['cat_name'],
				'cat_id'=>$row['cat_id'],
			);
	}
	$smarty->assign('category_info',$category_info );
	$smarty->assign('attr_id_list1',$attr_id_1 );
	$smarty->assign('attr_id_list2',$attr_id_2 );
	$smarty->assign('attr_id_list3',$attr_id_3 );
	$smarty->assign('attr_id_list4',$attr_id_4 );
	$smarty->assign('attr_id_list5',$attr_id_5 );
	$smarty->display('goods_simple.dwt');exit();
}
if ($_REQUEST['act'] == 'list' || $_REQUEST['act'] == 'trash' || $_REQUEST['act'] == 'no_comment') {
}
else {
	if ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit' || $_REQUEST['act'] == 'copy') {
		$sql = 'DELETE FROM' . $GLOBALS['ecs']->table('products_changelog') . 'WHERE admin_id = \'' . $_SESSION['admin_id'] . '\'';
		$GLOBALS['db']->query($sql);
		get_del_goodsimg_null();
		get_del_goods_gallery();
		get_del_update_goods_null();
		$smarty->assign('primary_cat', $_LANG['02_cat_and_goods']);

		if ($adminru['ru_id']) {
			$seller_shop_cat = seller_shop_cat($adminru['ru_id']);
		}
		else {
			$seller_shop_cat = array();
		}

		$smarty->assign('menu_select', array('action' => '02_cat_and_goods', 'current' => '01_goods_list'));

		if ($_CFG['group_goods']) {
			$group_goods_arr = explode(',', $_CFG['group_goods']);
			$arr = array();

			foreach ($group_goods_arr as $k => $v) {
				$arr[$k + 1] = $v;
			}

			$smarty->assign('group_goods_arr', $arr);
		}

		if (file_exists(MOBILE_DRP)) {
			if (0 < $adminru['ru_id']) {
				$dis = is_distribution($adminru['ru_id']);
				$smarty->assign('is_dis', $dis);
			}

			if ($adminru['ru_id'] == 0) {
				$smarty->assign('is_dis', 1);
			}
		}

		include_once ROOT_PATH . 'includes/fckeditor/fckeditor.php';
		$is_add = $_REQUEST['act'] == 'add';
		$is_copy = $_REQUEST['act'] == 'copy';
		$code = empty($_REQUEST['extension_code']) ? '' : trim($_REQUEST['extension_code']);
		$code == 'virtual_card' ? 'virtual_card' : '';
		$properties = empty($_REQUEST['properties']) ? 0 : intval($_REQUEST['properties']);
		$smarty->assign('properties', $properties);
		$db->query('DELETE FROM' . $ecs->table('warehouse_goods') . ' WHERE (goods_id = 0 or goods_id = \'\')');
		$db->query('DELETE FROM' . $ecs->table('warehouse_area_goods') . ' WHERE (goods_id = 0 or goods_id = \'\')');

		if ($code == 'virtual_card') {
			admin_priv('virualcard');
			$smarty->assign('menu_select', array('action' => '02_cat_and_goods', 'current' => '01_goods_list'));
		}
		else {
			admin_priv('goods_manage');
		}

		$suppliers_list_name = suppliers_list_name();
		$suppliers_exists = 1;

		if (empty($suppliers_list_name)) {
			$suppliers_exists = 0;
		}

		$smarty->assign('suppliers_exists', $suppliers_exists);
		$smarty->assign('suppliers_list_name', $suppliers_list_name);
		unset($suppliers_list_name);
		unset($suppliers_exists);
		if (ini_get('safe_mode') == 1 && (!file_exists('../' . IMAGE_DIR . '/' . date('Ym')) || !is_dir('../' . IMAGE_DIR . '/' . date('Ym')))) {
			if (@!mkdir('../' . IMAGE_DIR . '/' . date('Ym'), 511)) {
				$warning = sprintf($_LANG['safe_mode_warning'], '../' . IMAGE_DIR . '/' . date('Ym'));
				$smarty->assign('warning', $warning);
			}
		}
		else {
			if (file_exists('../' . IMAGE_DIR . '/' . date('Ym')) && file_mode_info('../' . IMAGE_DIR . '/' . date('Ym')) < 2) {
				$warning = sprintf($_LANG['not_writable_warning'], '../' . IMAGE_DIR . '/' . date('Ym'));
				$smarty->assign('warning', $warning);
			}
		}

		$adminru = get_admin_ru_id();
		$grade_rank = get_seller_grade_rank($adminru['ru_id']);
		$smarty->assign('grade_rank', $grade_rank);
		$smarty->assign('integral_scale', $_CFG['integral_scale']);
		$goods_id = isset($_REQUEST['goods_id']) && !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;

		if ($is_add) {
			$res = array();
			$smarty->assign('is_cause', $res);

			if (0 < $adminru['ru_id']) {
				if ($grade_rank['goods_sun'] != -1) {
					$sql = ' SELECT COUNT(*) FROM' . $ecs->table('goods') . ' WHERE user_id = \'' . $adminru['ru_id'] . '\'';
					$goods_numer = $db->getOne($sql);

					if ($grade_rank['goods_sun'] < $goods_numer) {
						sys_msg($_LANG['on_goods_num']);
						exit();
					}
				}
			}

			$goods = array(
				'goods_id'           => 0,
				'goods_desc'         => '',
				'goods_shipai'       => '',
				'freight'            => 1,
				'cat_id'             => '0',
				'brand_id'           => 0,
				'is_on_sale'         => '1',
				'is_alone_sale'      => '1',
				'is_shipping'        => '0',
				'other_cat'          => array(),
				'goods_type'         => 0,
				'shop_price'         => 0,
				'promote_price'      => 0,
				'market_price'       => 0,
				'integral'           => 0,
				'goods_number'       => $_CFG['default_storage'],
				'warn_number'        => 1,
				'promote_start_date' => local_date($GLOBALS['_CFG']['time_format']),
				'promote_end_date'   => local_date($GLOBALS['_CFG']['time_format'], local_strtotime('+1 month')),
				'goods_weight'       => 0,
				'give_integral'      => 0,
				'rank_integral'      => 0,
				'user_cat'           => 0,
				'goods_unit'         => '个',
				'goods_extend'       => array('is_reality' => 0, 'is_return' => 0, 'is_fast' => 0)
				);

			if ($code != '') {
				$goods['goods_number'] = 0;
			}

			$link_goods_list = array();
			$sql = 'DELETE FROM ' . $ecs->table('link_goods') . ' WHERE (goods_id = 0 OR link_goods_id = 0)' . (' AND admin_id = \'' . $_SESSION['admin_id'] . '\'');
			$db->query($sql);
			$group_goods_list = array();
			$sql = 'DELETE FROM ' . $ecs->table('group_goods') . (' WHERE parent_id = 0 AND admin_id = \'' . $_SESSION['admin_id'] . '\'');
			$db->query($sql);
			$goods_article_list = array();
			$sql = 'DELETE FROM ' . $ecs->table('goods_article') . (' WHERE goods_id = 0 AND admin_id = \'' . $_SESSION['admin_id'] . '\'');
			$db->query($sql);
			$sql = 'DELETE FROM ' . $ecs->table('goods_attr') . ' WHERE goods_id = 0';
			$db->query($sql);
			$img_list = array();
		}
		else {
			$goods = get_admin_goods_info($goods_id);

			if ($goods['user_id'] != $adminru['ru_id']) {
				$Loaction = 'goods.php?act=list';
				ecs_header('Location: ' . $Loaction . "\n");
				exit();
			}

			$cause_list = array('0', '1', '2', '3');

			if (!is_null($goods['goods_cause'])) {
				$res = array_intersect(explode(',', $goods['goods_cause']), $cause_list);
			}
			else {
				$res = array();
			}

			if ($res) {
				$smarty->assign('is_cause', $res);
			}
			else {
				$res = array();
				$smarty->assign('is_cause', $res);
			}

			$http = $GLOBALS['ecs']->http();
			$goods['goods_thumb'] = get_image_path($goods['goods_id'], $goods['goods_thumb'], true);
			if ($is_copy && $code != '') {
				$goods['goods_number'] = 0;
			}

			if (empty($goods) === true) {
				$goods = array(
					'goods_id'           => 0,
					'goods_desc'         => '',
					'goods_shipai'       => '',
					'cat_id'             => 0,
					'is_on_sale'         => '1',
					'is_alone_sale'      => '1',
					'is_shipping'        => '0',
					'other_cat'          => array(),
					'goods_type'         => 0,
					'shop_price'         => 0,
					'promote_price'      => 0,
					'market_price'       => 0,
					'integral'           => 0,
					'goods_number'       => 1,
					'warn_number'        => 1,
					'promote_start_date' => local_date($GLOBALS['_CFG']['time_format']),
					'promote_end_date'   => local_date($GLOBALS['_CFG']['time_format'], local_strtotime('+1 month')),
					'goods_weight'       => 0,
					'give_integral'      => 0,
					'rank_integral'      => 0,
					'user_cat'           => 0,
					'goods_extend'       => array('is_reality' => 0, 'is_return' => 0, 'is_fast' => 0)
					);
			}

			$goods['goods_extend'] = get_goods_extend($goods['goods_id']);
			$specifications = get_goods_type_specifications();
			$goods['specifications_id'] = $specifications[$goods['goods_type']];
			$_attribute = get_goods_specifications_list($goods['goods_id']);
			$goods['_attribute'] = empty($_attribute) ? '' : 1;

			if (0 < $goods['goods_weight']) {
				$goods['goods_weight_by_unit'] = 1 <= $goods['goods_weight'] ? $goods['goods_weight'] : $goods['goods_weight'] / 0.001;
			}

			if (!empty($goods['goods_brief'])) {
				$goods['goods_brief'] = $goods['goods_brief'];
			}

			if (!empty($goods['keywords'])) {
				$goods['keywords'] = $goods['keywords'];
			}

			if (isset($goods['is_xiangou']) && $goods['is_xiangou'] == '0') {
				unset($goods['xiangou_start_date']);
				unset($goods['xiangou_end_date']);
			}
			else {
				$goods['xiangou_start_date'] = local_date('Y-m-d H:i:s', $goods['xiangou_start_date']);
				$goods['xiangou_end_date'] = local_date('Y-m-d H:i:s', $goods['xiangou_end_date']);
			}

			if (!empty($goods['goods_product_tag'])) {
				$goods['goods_product_tag'] = $goods['goods_product_tag'];
			}

			if (isset($goods['is_promote']) && $goods['is_promote'] == '0') {
				unset($goods['promote_start_date']);
				unset($goods['promote_end_date']);
			}
			else {
				$goods['promote_start_date'] = local_date($GLOBALS['_CFG']['time_format'], $goods['promote_start_date']);
				$goods['promote_end_date'] = local_date($GLOBALS['_CFG']['time_format'], $goods['promote_end_date']);
			}

			$other_cat_list1 = array();
			$sql = 'SELECT ga.cat_id FROM ' . $ecs->table('goods_cat') . ' as ga ' . ' WHERE ga.goods_id = \'' . intval($goods_id) . '\'';
			$other_cat1 = $db->getCol($sql);
			$other_catids = '';

			foreach ($other_cat1 as $key => $val) {
				$other_catids .= $val . ',';
			}

			$other_catids = substr($other_catids, 0, -1);
			$smarty->assign('other_catids', $other_catids);

			if ($_REQUEST['act'] == 'copy') {
				if (0 < $adminru['ru_id']) {
					if ($grade_rank['goods_sun'] != -1) {
						$sql = ' SELECT COUNT(*) FROM' . $ecs->table('goods') . ' WHERE user_id = \'' . $adminru['ru_id'] . '\'';
						$goods_numer = $db->getOne($sql);

						if ($grade_rank['goods_sun'] < $goods_numer) {
							sys_msg($_LANG['on_goods_num']);
							exit();
						}
					}
				}

				$goods['goods_id'] = 0;
				$goods['goods_sn'] = '';
				$goods['goods_name'] = '';
				$goods['goods_img'] = '';
				$goods['goods_thumb'] = '';
				$goods['original_img'] = '';
				$sql = 'DELETE FROM ' . $ecs->table('link_goods') . ' WHERE (goods_id = 0 OR link_goods_id = 0)' . (' AND admin_id = \'' . $_SESSION['admin_id'] . '\'');
				$db->query($sql);
				$sql = 'SELECT \'0\' AS goods_id, link_goods_id, is_double, \'' . $_SESSION['admin_id'] . '\' AS admin_id' . ' FROM ' . $ecs->table('link_goods') . ' WHERE goods_id = \'' . intval($_REQUEST['goods_id']) . '\' ';
				$res = $db->query($sql);

				while ($row = $db->fetchRow($res)) {
					$db->autoExecute($ecs->table('link_goods'), $row, 'INSERT');
				}

				$sql = 'SELECT goods_id, \'0\' AS link_goods_id, is_double, \'' . $_SESSION['admin_id'] . '\' AS admin_id' . ' FROM ' . $ecs->table('link_goods') . ' WHERE link_goods_id = \'' . intval($_REQUEST['goods_id']) . '\' ';
				$res = $db->query($sql);

				while ($row = $db->fetchRow($res)) {
					$db->autoExecute($ecs->table('link_goods'), $row, 'INSERT');
				}

				$sql = 'DELETE FROM ' . $ecs->table('group_goods') . (' WHERE parent_id = 0 AND admin_id = \'' . $_SESSION['admin_id'] . '\'');
				$db->query($sql);
				$sql = 'SELECT 0 AS parent_id, goods_id, goods_price, \'' . $_SESSION['admin_id'] . '\' AS admin_id ' . 'FROM ' . $ecs->table('group_goods') . ' WHERE parent_id = \'' . intval($_REQUEST['goods_id']) . '\' ';
				$res = $db->query($sql);

				while ($row = $db->fetchRow($res)) {
					$db->autoExecute($ecs->table('group_goods'), $row, 'INSERT');
				}

				$sql = 'DELETE FROM ' . $ecs->table('goods_article') . (' WHERE goods_id = 0 AND admin_id = \'' . $_SESSION['admin_id'] . '\'');
				$db->query($sql);
				$sql = 'SELECT 0 AS goods_id, article_id, \'' . $_SESSION['admin_id'] . '\' AS admin_id ' . 'FROM ' . $ecs->table('goods_article') . ' WHERE goods_id = \'' . intval($_REQUEST['goods_id']) . '\' ';
				$res = $db->query($sql);

				while ($row = $db->fetchRow($res)) {
					$db->autoExecute($ecs->table('goods_article'), $row, 'INSERT');
				}

				$sql = 'DELETE FROM ' . $ecs->table('goods_attr') . ' WHERE goods_id = 0';
				$db->query($sql);
				$sql = 'SELECT 0 AS goods_id, attr_id, attr_value, attr_price ' . 'FROM ' . $ecs->table('goods_attr') . ' WHERE goods_id = \'' . intval($_REQUEST['goods_id']) . '\' ';
				$res = $db->query($sql);

				while ($row = $db->fetchRow($res)) {
					$db->autoExecute($ecs->table('goods_attr'), addslashes_deep($row), 'INSERT');
				}
			}

			$other_cat_list1 = array();
			$sql = 'SELECT ga.cat_id FROM ' . $ecs->table('goods_cat') . ' as ga ' . ' WHERE ga.goods_id = \'' . intval($_REQUEST['goods_id']) . '\'';
			$goods['other_cat1'] = $db->getCol($sql);

			foreach ($goods['other_cat1'] as $cat_id) {
				$other_cat_list1[$cat_id] = cat_list($cat_id);
			}

			$smarty->assign('other_cat_list1', $other_cat_list1);
			$smarty->assign('other_cat_list2', $other_cat_list2);
			$link_goods_list = get_linked_goods($goods['goods_id']);
			$group_goods_list = get_group_goods($goods['goods_id']);
			$goods_article_list = get_goods_articles($goods['goods_id']);
			if (isset($GLOBALS['shop_id']) && 10 < $GLOBALS['shop_id'] && !empty($goods['original_img'])) {
				$goods['goods_img'] = get_image_path($goods_id, $goods['goods_img']);
				$goods['goods_thumb'] = get_image_path($goods_id, $goods['goods_thumb'], true);
			}

			$sql = 'SELECT * FROM ' . $ecs->table('goods_gallery') . (' WHERE goods_id = \'' . $goods_id . '\'');
			$img_list = $db->getAll($sql);
			$http = $GLOBALS['ecs']->http();
			if (isset($GLOBALS['shop_id']) && 0 < $GLOBALS['shop_id']) {
				foreach ($img_list as $key => $gallery_img) {
					$img_list[$key] = $gallery_img;

					if (!empty($gallery_img['external_url'])) {
						$img_list[$key]['img_url'] = $gallery_img['external_url'];
						$img_list[$key]['thumb_url'] = $gallery_img['external_url'];
					}
					else {
						$gallery_img['img_original'] = get_image_path($gallery_img['goods_id'], $gallery_img['img_original'], true);
						$img_list[$key]['img_url'] = $gallery_img['img_original'];
						$gallery_img['thumb_url'] = get_image_path($gallery_img['goods_id'], $gallery_img['thumb_url'], true);
						$img_list[$key]['thumb_url'] = $gallery_img['thumb_url'];
					}
				}
			}
			else {
				foreach ($img_list as $key => $gallery_img) {
					$img_list[$key] = $gallery_img;

					if (!empty($gallery_img['external_url'])) {
						$img_list[$key]['img_url'] = $gallery_img['external_url'];
						$img_list[$key]['thumb_url'] = $gallery_img['external_url'];
					}
					else {
						$gallery_img['thumb_url'] = get_image_path($gallery_img['goods_id'], $gallery_img['thumb_url'], true);
						$img_list[$key]['thumb_url'] = $gallery_img['thumb_url'];
					}
				}
			}

			$img_desc = array();

			foreach ($img_list as $k => $v) {
				$img_desc[] = $v['img_desc'];
			}

			@$img_default = min($img_desc);
			$min_img_id = $db->getOne(' SELECT img_id   FROM ' . $ecs->table('goods_gallery') . ' WHERE goods_id = \'' . $goods_id . ('\' AND img_desc = \'' . $img_default . '\' ORDER BY img_desc   LIMIT 1'));
			$smarty->assign('min_img_id', $min_img_id);
		}

		if (empty($goods['user_id'])) {
			$goods['user_id'] = $adminru['ru_id'];
		}

		$warehouse_list = get_warehouse_region();
		$smarty->assign('warehouse_list', $warehouse_list);
		$smarty->assign('count_warehouse', count($warehouse_list));
		$warehouse_goods_list = get_warehouse_goods_list($goods_id);
		$smarty->assign('warehouse_goods_list', $warehouse_goods_list);
		$warehouse_area_goods_list = get_warehouse_area_goods_list($goods_id);
		$smarty->assign('warehouse_area_goods_list', $warehouse_area_goods_list);
		$area_count = get_all_warehouse_area_count();
		$smarty->assign('area_count', $area_count);
		$areaRegion_list = get_areaRegion_list();
		$smarty->assign('areaRegion_list', $areaRegion_list);
		$smarty->assign('area_goods_list', get_area_goods($goods_id));
		$consumption_list = get_goods_con_list($goods_id, 'goods_consumption');
		$smarty->assign('consumption_list', $consumption_list);
		$group_goods = get_cfg_group_goods();
		$smarty->assign('group_list', $group_goods);
		$smarty->assign('ru_id', $adminru['ru_id']);
		$goods_name_style = explode('+', empty($goods['goods_name_style']) ? '+' : $goods['goods_name_style']);

		if ($GLOBALS['_CFG']['open_oss'] == 1) {
			$bucket_info = get_bucket_info();

			if ($goods['goods_desc']) {
				$desc_preg = get_goods_desc_images_preg($bucket_info['endpoint'], $goods['goods_desc']);
				$goods['goods_desc'] = $desc_preg['goods_desc'];
			}
		}

		create_html_editor('goods_desc', $goods['goods_desc']);
		create_html_editor2('goods_shipai', 'goods_shipai', $goods['goods_shipai']);

		if (!empty($goods['stages'])) {
			$stages = unserialize($goods['stages']);
		}

		$smarty->assign('code', $code);
		$smarty->assign('ur_here', $is_add ? (empty($code) ? $_LANG['02_goods_add'] : $_LANG['51_virtual_card_add']) : ($_REQUEST['act'] == 'edit' ? $_LANG['edit_goods'] : $_LANG['copy_goods']));
		$smarty->assign('action_link', list_link($is_add, $code));
		$smarty->assign('goods', $goods);
		$smarty->assign('stages', $stages);
		$smarty->assign('goods_name_color', $goods_name_style[0]);
		$smarty->assign('goods_name_style', $goods_name_style[1]);

		if ($is_add) {
			$smarty->assign('cat_list', cat_list_one(0, 0, $seller_shop_cat));
		}
		else {
			$smarty->assign('cat_list', cat_list_one($goods['cat_id'], 0, $seller_shop_cat));
		}

		$smarty->assign('cat_list_new', cat_list($goods['cat_id']));
		$smarty->assign('brand_list', get_brand_list($goods_id));
		$brand_info = get_brand_info($goods['brand_id']);
		$smarty->assign('brand_name', $brand_info['brand_name']);
		$smarty->assign('unit_list', get_unit_list());
		$smarty->assign('user_rank_list', get_user_rank_list());
		$smarty->assign('weight_unit', $is_add ? '1' : (1 <= $goods['goods_weight'] ? '1' : '0.001'));
		$smarty->assign('cfg', $_CFG);
		$smarty->assign('form_act', $is_add ? 'insert' : ($_REQUEST['act'] == 'edit' ? 'update' : 'insert'));
		if ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'edit') {
			$smarty->assign('is_add', true);
		}

		if (!$is_add) {
			$smarty->assign('member_price_list', get_member_price_list($goods_id));
		}

		$smarty->assign('link_goods_list', $link_goods_list);
		$smarty->assign('group_goods_list', $group_goods_list);
		$smarty->assign('goods_article_list', $goods_article_list);
		$smarty->assign('img_list', $img_list);
		$smarty->assign('goods_type_list', goods_type_list($goods['goods_type'], $goods['goods_id'], 'array'));

		if ($GLOBALS['_CFG']['attr_set_up'] == 1) {
			$where = ' AND user_id = \'' . $adminru['ru_id'] . '\' ';
		}
		else if ($GLOBALS['_CFG']['attr_set_up'] == 0) {
			$where = ' AND user_id = 0 ';
		}

		$type_c_id = $db->getOne('SELECT c_id FROM' . $ecs->table('goods_type') . 'WHERE cat_id = \'' . $goods['goods_type'] . '\' ' . $where . ' LIMIT 1');
		$type_level = get_type_cat_arr();
		$smarty->assign('type_level', $type_level);
		$cat_tree = get_type_cat_arr($type_c_id, 2);
		$cat_tree1 = array('checked_id' => $cat_tree['checked_id']);

		if (0 < $cat_tree['checked_id']) {
			$cat_tree1 = get_type_cat_arr($cat_tree['checked_id'], 2);
		}

		$smarty->assign('type_c_id', $type_c_id);
		$smarty->assign('cat_tree', $cat_tree);
		$smarty->assign('cat_tree1', $cat_tree1);
		$smarty->assign('gd', gd_version());
		$smarty->assign('thumb_width', $_CFG['thumb_width']);
		$smarty->assign('thumb_height', $_CFG['thumb_height']);
		$smarty->assign('goods_attr_html', build_attr_html($goods['goods_type'], $goods['goods_id']));
		$volume_price_list = '';

		if (isset($goods_id)) {
			$volume_price_list = get_volume_price_list($goods_id);
		}

		if (empty($volume_price_list)) {
			$volume_price_list = array();
		}

		$smarty->assign('volume_price_list', $volume_price_list);
		$cat_info = get_seller_cat_info($goods['user_cat']);
		get_add_edit_goods_cat_list($goods_id, $goods['cat_id'], 'category', '', $goods['user_id'], $seller_shop_cat);
		get_add_edit_goods_cat_list($goods_id, $goods['user_cat'], 'merchants_category', 'seller_', $goods['user_id']);
		$level_limit = 3;
		$category_level = array();

		if ($_REQUEST['act'] == 'add') {
			for ($i = 1; $i <= $level_limit; $i++) {
				$category_list = array();

				if ($i == 1) {
					$category_list = get_category_list(0, 0, $seller_shop_cat, $goods['user_id']);
				}

				$smarty->assign('cat_level', $i);
				$smarty->assign('category_list', $category_list);
				$category_level[$i] = $smarty->fetch('library/get_select_category.lbi');
			}
		}

		if ($_REQUEST['act'] == 'edit' || $_REQUEST['act'] == 'copy') {
			$parent_cat_list = get_select_category($goods['cat_id'], 1, true);

			for ($i = 1; $i <= $level_limit; $i++) {
				$category_list = array();

				if (isset($parent_cat_list[$i])) {
					$category_list = get_category_list($parent_cat_list[$i], 0, $seller_shop_cat, $goods['user_id'], $i);
				}
				else if ($i == 1) {
					if ($goods['user_id']) {
						$category_list = get_category_list(0, 0, $seller_shop_cat, $goods['user_id'], $i);
					}
					else {
						$category_list = get_category_list(0, 0, $seller_shop_cat, $adminru['ru_id']);
					}
				}

				$smarty->assign('cat_level', $i);
				$smarty->assign('category_list', $category_list);
				$category_level[$i] = $smarty->fetch('library/get_select_category.lbi');
			}
		}

		$smarty->assign('category_level', $category_level);
		set_default_filter(0, 0, $adminru['ru_id']);
		set_seller_default_filter(0, $goods['user_cat'], $adminru['ru_id']);
		$user_cat_name = get_seller_every_category($goods['user_cat']);
		$smarty->assign('user_cat_name', $user_cat_name);

		if (file_exists(MOBILE_DRP)) {
			$smarty->assign('is_dir', 1);
		}
		else {
			$smarty->assign('is_dir', 0);
		}

		$smarty->assign('transport_list', get_table_date('goods_transport', 'ru_id = \'' . $goods['user_id'] . '\'', array('tid, title'), 1));
		assign_query_info();
		$smarty->display('goods_add.dwt');
	}
	else if ($_REQUEST['act'] == 'get_select_category_pro') {
		
	}
	else if ($_REQUEST['act'] == 'set_common_category_pro') {
		}
	else if ($_REQUEST['act'] == 'deal_extension_category') {
		
	}
	else if ($_REQUEST['act'] == 'goods_model_list') {
	}
	else if ($_REQUEST['act'] == 'get_attribute') {
		
	}
	else {
		if ($_REQUEST['act'] == 'set_attribute_table' || $_REQUEST['act'] == 'goods_attribute_query') {
			
		}
		else if ($_REQUEST['act'] == 'add_desc') {
			
		}
		else if ($_REQUEST['act'] == 'desc_list') {
		
		}
		else if ($_REQUEST['act'] == 'desc_query') {
			
		}
		else if ($_REQUEST['act'] == 'edit_link_desc') {
			
		}
		else if ($_REQUEST['act'] == 'add_link_desc') {
			
		}
		else if ($_REQUEST['act'] == 'drop_link_desc') {
			
		}
		else {
			if ($_REQUEST['act'] == 'insert' || $_REQUEST['act'] == 'update'){

					$artWorkId = empty($_POST['artWorkId'])?0:$_POST['artWorkId'];
					if(empty($artWorkId) && empty($api)){
						clear_cache_files();
						sys_msg('缺少相关联的艺术品，添加失败。', 2, array(), false);
						// make_json_result('缺少相关联的艺术品，添加失败');
					}
					$code = empty($_REQUEST['extension_code']) ? '' : trim($_REQUEST['extension_code']);
					$proc_thumb = isset($GLOBALS['shop_id']) && 0 < $GLOBALS['shop_id'] ? false : true;

					if($shield){
						if ($code == 'virtual_card') {
						admin_priv('virualcard');
						}
						else {
							admin_priv('goods_manage');
						}
					}
					

					if ($_POST['goods_sn']) {
						$sql = 'SELECT COUNT(*) FROM ' . $ecs->table('goods') . (' WHERE goods_sn = \'' . $_POST['goods_sn'] . '\' AND is_delete = 0 AND goods_id <> \'' . $_POST['goods_id'] . '\'');

						if (0 < $db->getOne($sql)) {
							sys_msg($_LANG['goods_sn_exists'], 1, array(), false);
						}
					}

					$is_insert = $_REQUEST['act'] == 'insert';
					$original_img = empty($_REQUEST['original_img']) ? '' : trim($_REQUEST['original_img']);
					$goods_img = empty($_REQUEST['goods_img']) ? '' : trim($_REQUEST['goods_img']);
					$goods_thumb = empty($_REQUEST['goods_thumb']) ? '' : trim($_REQUEST['goods_thumb']);
					$is_img_url = empty($_REQUEST['is_img_url']) ? 0 : intval($_REQUEST['is_img_url']);
					$_POST['goods_img_url'] = isset($_POST['goods_img_url']) && !empty($_POST['goods_img_url']) ? trim($_POST['goods_img_url']) : '';
					if (!empty($_POST['goods_img_url']) && $_POST['goods_img_url'] != 'http://' && (strpos($_POST['goods_img_url'], 'http://') !== false || strpos($_POST['goods_img_url'], 'https://') !== false) && $is_img_url == 1) {
						$admin_temp_dir = 'seller';
						$admin_temp_dir = ROOT_PATH . 'temp' . '/' . $admin_temp_dir . '/' . 'admin_' . $admin_id;

						if (!file_exists($admin_temp_dir)) {
							make_dir($admin_temp_dir);
						}

						if (get_http_basename($_POST['goods_img_url'], $admin_temp_dir)) {
							$original_img = $admin_temp_dir . '/' . basename($_POST['goods_img_url']);
						}

						if ($original_img === false) {
							sys_msg($image->error_msg(), 1, array(), false);
						}

						$goods_img = $original_img;

						if ($_CFG['auto_generate_gallery']) {
							$img = $original_img;
							$pos = strpos(basename($img), '.');
							$newname = dirname($img) . '/' . $image->random_filename() . substr(basename($img), $pos);

							if (!copy($img, $newname)) {
								sys_msg('fail to copy file: ' . realpath('../' . $img), 1, array(), false);
							}

							$img = $newname;
							$gallery_img = $img;
							$gallery_thumb = $img;
						}
						if ($proc_thumb && 0 < $image->gd_version() || $is_url_goods_img) {
							if (empty($is_url_goods_img)) {
								$img_wh = $image->get_width_to_height($goods_img, $GLOBALS['_CFG']['image_width'], $GLOBALS['_CFG']['image_height']);
								$GLOBALS['_CFG']['image_width'] = isset($img_wh['image_width']) ? $img_wh['image_width'] : $GLOBALS['_CFG']['image_width'];
								$GLOBALS['_CFG']['image_height'] = isset($img_wh['image_height']) ? $img_wh['image_height'] : $GLOBALS['_CFG']['image_height'];
								$goods_img = $image->make_thumb(array('img' => $goods_img, 'type' => 1), $GLOBALS['_CFG']['image_width'], $GLOBALS['_CFG']['image_height']);

								if ($goods_img === false) {
									sys_msg($image->error_msg(), 1, array(), false);
								}

								$gallery_img = $image->make_thumb(array('img' => $gallery_img, 'type' => 1), $GLOBALS['_CFG']['image_width'], $GLOBALS['_CFG']['image_height']);

								if ($gallery_img === false) {
									sys_msg($image->error_msg(), 1, array(), false);
								}

								if (0 < intval($_CFG['watermark_place']) && !empty($GLOBALS['_CFG']['watermark'])) {
									if ($image->add_watermark($goods_img, '', $GLOBALS['_CFG']['watermark'], $GLOBALS['_CFG']['watermark_place'], $GLOBALS['_CFG']['watermark_alpha']) === false) {
										sys_msg($image->error_msg(), 1, array(), false);
									}

									if ($_CFG['auto_generate_gallery']) {
										if ($image->add_watermark($gallery_img, '', $GLOBALS['_CFG']['watermark'], $GLOBALS['_CFG']['watermark_place'], $GLOBALS['_CFG']['watermark_alpha']) === false) {
											sys_msg($image->error_msg(), 1, array(), false);
										}
									}
								}
							}

							if ($_CFG['auto_generate_gallery']) {
								if ($_CFG['thumb_width'] != 0 || $_CFG['thumb_height'] != 0) {
									$gallery_thumb = $image->make_thumb(array('img' => $img, 'type' => 1), $GLOBALS['_CFG']['thumb_width'], $GLOBALS['_CFG']['thumb_height']);

									if ($gallery_thumb === false) {
										sys_msg($image->error_msg(), 1, array(), false);
									}
								}
							}
						}

						if ($proc_thumb && !empty($original_img)) {
							if ($_CFG['thumb_width'] != 0 || $_CFG['thumb_height'] != 0) {
								$goods_thumb = $image->make_thumb(array('img' => $original_img, 'type' => 1), $GLOBALS['_CFG']['thumb_width'], $GLOBALS['_CFG']['thumb_height']);

								if ($goods_thumb === false) {
									sys_msg($image->error_msg(), 1, array(), false);
								}
							}
							else {
								$goods_thumb = $original_img;
							}
						}
					}

					if (empty($_POST['goods_sn'])) {
						$max_id = $is_insert ? $db->getOne('SELECT MAX(goods_id) + 1 FROM ' . $ecs->table('goods')) : $_REQUEST['goods_id'];
						$goods_sn = generate_goods_sn($max_id);
					}
					else {
						$goods_sn = trim($_POST['goods_sn']);
					}

					$shop_price = !empty($_POST['shop_price']) ? trim($_POST['shop_price']) : 0;
					if($shop_price ==0 ){
							sys_msg('商品价格不能为零！', 2, array(), false);
					}
					$shop_price = floatval($shop_price);
					$market_price = !empty($_POST['market_price']) ? trim($_POST['market_price']) : 0;
					$market_price = floatval($market_price);
					$promote_price = !empty($_POST['promote_price']) ? trim($_POST['promote_price']) : 0;
					$promote_price = floatval($promote_price);
					$cost_price = !empty($_POST['cost_price']) ? trim($_POST['cost_price']) : 0;
					$cost_price = floatval($cost_price);

					if (!isset($_POST['is_promote'])) {
						$is_promote = 0;
					}
					else {
						$is_promote = $_POST['is_promote'];
					}

					$promote_start_date = $is_promote && !empty($_POST['promote_start_date']) ? local_strtotime($_POST['promote_start_date']) : 0;
					$promote_end_date = $is_promote && !empty($_POST['promote_end_date']) ? local_strtotime($_POST['promote_end_date']) : 0;
					$goods_weight = !empty($_POST['goods_weight']) ? $_POST['goods_weight'] * $_POST['weight_unit'] : 0;
					$is_best = isset($_POST['is_best']) && !empty($_POST['is_best']) ? 1 : 0;
					$is_new = isset($_POST['is_new']) && !empty($_POST['is_new']) ? 1 : 0;
					$is_hot = isset($_POST['is_hot']) && !empty($_POST['is_hot']) ? 1 : 0;
					$is_on_sale = isset($_POST['is_on_sale']) && !empty($_POST['is_on_sale']) ? 1 : 1;
					$is_alone_sale = isset($_POST['is_alone_sale']) && !empty($_POST['is_alone_sale']) ? 1 : 0;
					$is_shipping = isset($_POST['is_shipping']) && !empty($_POST['is_shipping']) ? 1 : 0;
					$goods_number = isset($_POST['goods_number']) && !empty($_POST['goods_number']) ? $_POST['goods_number'] : 1;
					$warn_number = isset($_POST['warn_number']) && !empty($_POST['warn_number']) ? $_POST['warn_number'] : 0;
					$goods_type = isset($_POST['goods_type']) && !empty($_POST['goods_type']) ? $_POST['goods_type'] :1;
					$give_integral = isset($_POST['give_integral']) ? intval($_POST['give_integral']) : '-1';
					$rank_integral = isset($_POST['rank_integral']) ? intval($_POST['rank_integral']) : '-1';
					$suppliers_id = isset($_POST['suppliers_id']) ? intval($_POST['suppliers_id']) : 0;
					$commission_rate = isset($_POST['commission_rate']) && !empty($_POST['commission_rate']) ? floatval($_POST['commission_rate']) : 0;
					$is_volume = isset($_POST['is_volume']) && !empty($_POST['is_volume']) ? intval($_POST['is_volume']) : 0;
					$is_fullcut = isset($_POST['is_fullcut']) && !empty($_POST['is_fullcut']) ? intval($_POST['is_fullcut']) : 0;
					$goods_unit = isset($_POST['goods_unit']) ? trim($_POST['goods_unit']) : '个';
					$is_distribution = isset($_POST['is_distribution']) && !empty($_POST['is_distribution']) ? intval($_POST['is_distribution']) : 0;

					if ($is_distribution == 1) {
						$dis_commission = 0 < $_POST['dis_commission'] && $_POST['dis_commission'] <= 100 ? intval($_POST['dis_commission']) : 0;
					}

					$bar_code = isset($_POST['bar_code']) && !empty($_POST['bar_code']) ? trim($_POST['bar_code']) : '';
					$goods_name_style = $_POST['goods_name_color'] . '+' . $_POST['goods_name_style'];
					$other_catids = isset($_POST['other_catids']) ? trim($_POST['other_catids']) : '';
					$catgory_id = empty($_POST['cat_id']) ? 1488 : intval($_POST['cat_id']);
					if (empty($catgory_id) && !empty($_POST['common_category'])) {
						$catgory_id = intval($_POST['common_category']);
					}

					$brand_id = empty($_POST['brand_id']) ? '' : intval($_POST['brand_id']);
					$store_category = !empty($_POST['store_category']) ? intval($_POST['store_category']) : 0;

					if (0 < $store_category) {
						$catgory_id = $store_category;
					}

					$user_cat_arr = explode('_', $_POST['user_cat']);
					$user_cat = $user_cat_arr[0];

					if ($_POST['is_stages']) {
						$stages = serialize($_POST['stages_num']);
						$stages_rate = isset($_POST['stages_rate']) && !empty($_POST['stages_rate']) ? floatval($_POST['stages_rate']) : 0;
					}
					else {
						$stages = '';
						$stages_rate = '';
					}

					$adminru = get_admin_ru_id();
						if(empty($adminru['ru_id'])){
							$adminru['ru_id']=isset($_POST['user_id'])?intval($_POST['user_id']):0;
						}
					$model_price = isset($_POST['model_price']) && !empty($_POST['model_price']) ? intval($_POST['model_price']) : 0;
					$model_inventory = isset($_POST['model_inventory']) && !empty($_POST['model_inventory']) ? intval($_POST['model_inventory']) : 0;
					$model_attr = isset($_POST['model_attr']) && !empty($_POST['model_attr']) ? intval($_POST['model_attr']) : 0;
					$review_status = 5;

					if ($GLOBALS['_CFG']['review_goods'] == 0) {
						$review_status = 5;
					}
					else if (0 < $adminru['ru_id']) {
						$sql = 'select review_goods from ' . $ecs->table('merchants_shop_information') . ' where user_id = \'' . $adminru['ru_id'] . '\'';
						$review_goods = $db->getOne($sql);

						if ($review_goods == 0) {
							$review_status = 5;
						}
					}
					else {
						$review_status = 5;
					}

					$xiangou_num = !empty($_POST['xiangou_num']) ? intval($_POST['xiangou_num']) : 0;
					$is_xiangou = empty($xiangou_num) ? 0 : 1;
					$xiangou_start_date = $is_xiangou && !empty($_POST['xiangou_start_date']) ? local_strtotime($_POST['xiangou_start_date']) : 0;
					$xiangou_end_date = $is_xiangou && !empty($_POST['xiangou_end_date']) ? local_strtotime($_POST['xiangou_end_date']) : 0;
					$cfull = isset($_POST['cfull']) ? $_POST['cfull'] : array();
					$creduce = isset($_POST['creduce']) ? $_POST['creduce'] : array();
					$c_id = isset($_POST['c_id']) ? $_POST['c_id'] : array();
					$sfull = isset($_POST['sfull']) ? $_POST['sfull'] : array();
					$sreduce = isset($_POST['sreduce']) ? $_POST['sreduce'] : array();
					$s_id = isset($_POST['s_id']) ? $_POST['s_id'] : array();
					$goods_img_id = !empty($_REQUEST['img_id']) ? $_REQUEST['img_id'] : '';
					$largest_amount = !empty($_POST['largest_amount']) ? trim($_POST['largest_amount']) : 0;
					$largest_amount = floatval($largest_amount);
					$group_number = !empty($_POST['group_number']) ? intval($_POST['group_number']) : 0;
					$store_new = isset($_POST['store_new']) && !empty($_POST['store_new']) ? 1 : 0;
					$store_hot = isset($_POST['store_hot']) && !empty($_POST['store_hot']) ? 1 : 0;
					$store_best = isset($_POST['store_best']) && !empty($_POST['store_best']) ? 1 : 0;
					$goods_name = trim($_POST['goods_name']);
					if(empty($goods_name )){
							sys_msg('商品名不能为空。', 2, array(), false);
					}
			
					
					$pin = new pin();
					$pinyin = $pin->Pinyin($goods_name, 'UTF8');
					$user_cat = !empty($_POST['user_cat']) ? intval($_POST['user_cat']) : 0;
					$where_drp_sql = '';
					$where_drp_val = '';

					if (file_exists(MOBILE_DRP)) {
						$where_drp_sql = ', is_distribution, dis_commission';
						$where_drp_val = ', \'' . $is_distribution . '\', \'' . $dis_commission . '\'';
					}

					$freight = empty($_POST['freight']) ? 1: intval($_POST['freight']);
					$shipping_fee = !empty($_POST['shipping_fee']) && $freight == 1 ? floatval($_POST['shipping_fee']) : '0.00';
					$tid = !empty($_POST['tid']) && $_POST['freight'] == 2 ? intval($_POST['tid']) : 0;

					if ($is_insert) {
						$freight_insert_key = ', freight, shipping_fee, tid';
						$freight_insert_val = ', \'' . $freight . '\', \'' . $shipping_fee . '\', \'' . $tid . '\'';
					}
					else {
						$freight_update_data = ' freight = \'' . $freight . '\',' . (' shipping_fee = \'' . $shipping_fee . '\',') . (' tid = \'' . $tid . '\',');
					}

					$goods_cause = '';
					$cause = !empty($_REQUEST['return_type']) ? $_REQUEST['return_type'] : 0;

					for ($i = 0; $i < count($cause); $i++) {
						if ($i == 0) {
							$goods_cause = $cause[$i];
						}
						else {
							$goods_cause = $goods_cause . ',' . $cause[$i];
						}
					}

					if ($is_insert) {
						if ($code == '') {
							$sql = 'INSERT INTO ' . $ecs->table('goods') . ' (goods_name, goods_name_style, goods_sn, bar_code, ' . 'cat_id, user_cat, brand_id, shop_price, market_price, cost_price, is_promote, promote_price, ' . 'promote_start_date, promote_end_date, goods_img, goods_thumb, original_img, keywords, goods_brief, ' . 'seller_note, goods_weight, goods_number, warn_number, integral, give_integral, is_best, is_new, is_hot, ' . 'is_on_sale, is_alone_sale, is_shipping, goods_desc, desc_mobile, add_time, last_update, goods_type, rank_integral, suppliers_id , goods_shipai' . ', user_id, model_price, model_inventory, model_attr, review_status, commission_rate' . ', group_number, store_new, store_hot, store_best, goods_cause' . ', goods_product_tag, is_volume, is_fullcut' . $where_drp_sql . $freight_insert_key . ', is_xiangou, xiangou_num, xiangou_start_date, xiangou_end_date, largest_amount, pinyin_keyword,stages,stages_rate,goods_unit' . ')' . ('VALUES (\'' . $goods_name . '\', \'' . $goods_name_style . '\', \'' . $goods_sn . '\', \'' . $bar_code . '\', \'' . $catgory_id . '\', ') . ('\'' . $user_cat . '\', \'' . $brand_id . '\', \'' . $shop_price . '\', \'' . $shop_price . '\', \'' . $shop_price . '\', \'' . $is_promote . '\',\'' . $promote_price . '\', ') . ('\'' . $promote_start_date . '\', \'' . $promote_end_date . '\', \'' . $goods_img . '\', \'' . $goods_thumb . '\', \'' . $original_img . '\', ') . ('\'' . $_POST['keywords'] . '\', \'' . $_POST['goods_brief'] . '\', \'' . $_POST['seller_note'] . '\', \'' . $goods_weight . '\', \'' . $goods_number . '\',') . (' \'' . $warn_number . '\', \'' . $_POST['integral'] . '\', \'' . $give_integral . '\', \'' . $is_best . '\', \'' . $is_new . '\', \'' . $is_hot . '\', \'' . $is_on_sale . '\', \'' . $is_alone_sale . '\', ' . $is_shipping . ', ') . (' \'' . $_POST['goods_desc'] . '\', \'' . $_POST['desc_mobile'] . '\', \'') . gmtime() . '\', \'' . gmtime() . ('\', \'' . $goods_type . '\', \'' . $rank_integral . '\', \'' . $suppliers_id . '\' , \'' . $_POST['goods_shipai'] . '\'') . (', \'' . $adminru['ru_id'] . '\', \'' . $model_price . '\', \'' . $model_inventory . '\', \'' . $model_attr . '\', \'' . $review_status . '\', \'' . $commission_rate . '\'') . (', \'' . $group_number . '\', \'' . $store_new . '\', \'' . $store_hot . '\', \'' . $store_best . '\', \'' . $goods_cause . '\'') . (', \'' . $_POST['goods_product_tag'] . '\', \'' . $is_volume . '\', \'' . $is_fullcut . '\'') . $where_drp_val . $freight_insert_val . (', \'' . $is_xiangou . '\', \'' . $xiangou_num . '\', \'' . $xiangou_start_date . '\', \'' . $xiangou_end_date . '\', \'' . $largest_amount . '\', \'' . $pinyin . '\',\'' . $stages . '\',\'' . $stages_rate . '\',\'' . $goods_unit . '\'') . ')';
						}
						else {
							$sql = 'INSERT INTO ' . $ecs->table('goods') . ' (goods_name, goods_name_style, goods_sn, bar_code, ' . 'cat_id, user_cat, brand_id, shop_price, market_price, cost_price, is_promote, promote_price, ' . 'promote_start_date, promote_end_date, goods_img, goods_thumb, original_img, keywords, goods_brief, ' . 'seller_note, goods_weight, goods_number, warn_number, integral, give_integral, is_best, is_new, is_hot, is_real, ' . 'is_on_sale, is_alone_sale, is_shipping, goods_desc, desc_mobile, add_time, last_update, goods_type, extension_code, rank_integral ,  goods_shipai' . ', user_id, model_price, model_inventory, model_attr, review_status, commission_rate' . ', group_number, store_new, store_hot, store_best, goods_cause' . ', goods_product_tag, is_volume, is_fullcut' . $where_drp_sql . $freight_insert_key . ', is_xiangou, xiangou_num, xiangou_start_date, xiangou_end_date, largest_amount, pinyin_keyword,stages,stages_rate,goods_unit' . ')' . ('VALUES (\'' . $goods_name . '\', \'' . $goods_name_style . '\', \'' . $goods_sn . '\', \'' . $bar_code . '\', \'' . $catgory_id . '\', ') . ('\'' . $user_cat . '\', \'' . $brand_id . '\', \'' . $shop_price . '\', \'' .  $shop_price . '\', \'' .  $shop_price . '\', \'' . $is_promote . '\',\'' . $promote_price . '\', ') . ('\'' . $promote_start_date . '\', \'' . $promote_end_date . '\', \'' . $goods_img . '\', \'' . $goods_thumb . '\', \'' . $original_img . '\', ') . ('\'' . $_POST['keywords'] . '\', \'' . $_POST['goods_brief'] . '\', \'' . $_POST['seller_note'] . '\', \'' . $goods_weight . '\', \'' . $goods_number . '\',') . (' \'' . $warn_number . '\', \'' . $_POST['integral'] . '\', \'' . $give_integral . '\', \'' . $is_best . '\', \'' . $is_new . '\', \'' . $is_hot . '\', 0, \'' . $is_on_sale . '\', \'' . $is_alone_sale . '\', ' . $is_shipping . ', ') . (' \'' . $_POST['goods_desc'] . '\', \'' . $_POST['desc_mobile'] . '\', \'') . gmtime() . '\', \'' . gmtime() . ('\', \'' . $goods_type . '\', \'' . $code . '\', \'' . $rank_integral . '\' , \'' . $_POST['goods_shipai'] . '\'') . (', \'' . $adminru['ru_id'] . '\', \'' . $model_price . '\', \'' . $model_inventory . '\', \'' . $model_attr . '\', \'' . $review_status . '\', \'' . $commission_rate . '\'') . (', \'' . $group_number . '\', \'' . $store_new . '\', \'' . $store_hot . '\', \'' . $store_best . '\', \'' . $goods_cause . '\'') . (', \'' . $_POST['goods_product_tag'] . '\', \'' . $is_volume . '\', \'' . $is_fullcut . '\'') . $where_drp_val . $freight_insert_val . (', \'' . $is_xiangou . '\', \'' . $xiangou_num . '\', \'' . $xiangou_start_date . '\', \'' . $xiangou_end_date . '\', \'' . $largest_amount . '\', \'' . $pinyin . '\',\'' . $stages . '\',\'' . $stages_rate . '\',\'' . $goods_unit . '\'') . ')';
						}
						$not_number = !empty($goods_number) ? 1 : 0;
						$number = '+ ' . $goods_number;
						$use_storage = 7;
					}
					else {
						$_REQUEST['goods_id'] = isset($_REQUEST['goods_id']) && !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
						get_goods_file_content($_REQUEST['goods_id'], $GLOBALS['_CFG']['goods_file'], $adminru['ru_id'], $review_goods, $model_attr);
						$where_drp_up = '';

						if (file_exists(MOBILE_DRP)) {
							$where_drp_up = 'dis_commission = \'' . $dis_commission . '\', ' . ('is_distribution = \'' . $is_distribution . '\', ');
						}

						$sql = 'UPDATE ' . $ecs->table('goods') . ' SET ' . ('goods_name = \'' . $goods_name . '\', ') . ('goods_name_style = \'' . $goods_name_style . '\', ') . ('goods_sn = \'' . $goods_sn . '\', ') . ('bar_code = \'' . $bar_code . '\', ') . ('cat_id = \'' . $catgory_id . '\', ') . ('brand_id = \'' . $brand_id . '\', ') . ('shop_price = \'' . $shop_price . '\', ') . ('market_price = \'' . $shop_price . '\', ') . ('cost_price = \'' . $shop_price . '\', ') . ('is_promote = \'' . $is_promote . '\', ') . ('commission_rate = \'' . $commission_rate . '\', ') . ('is_volume = \'' . $is_volume . '\', ') . ('is_fullcut = \'' . $is_fullcut . '\', ') . ('model_price = \'' . $model_price . '\', ') . ('model_inventory = \'' . $model_inventory . '\', ') . ('model_attr = \'' . $model_attr . '\', ') . ('largest_amount = \'' . $largest_amount . '\', ') . ('group_number = \'' . $group_number . '\',') . ('store_new = \'' . $store_new . '\',') . ('store_hot = \'' . $store_hot . '\',') . ('store_best = \'' . $store_best . '\',') . ('goods_unit = \'' . $goods_unit . '\',') . ('is_xiangou=\'' . $is_xiangou . '\',') . ('xiangou_num = \'' . $xiangou_num . '\',') . ('xiangou_start_date = \'' . $xiangou_start_date . '\',') . ('xiangou_end_date = \'' . $xiangou_end_date . '\',') . ('goods_product_tag = \'' . $_POST['goods_product_tag'] . '\', ') . ('pinyin_keyword = \'' . $pinyin . '\', ') . ('stages = \'' . $stages . '\', ') . ('stages_rate = \'' . $stages_rate . '\', ') . ('user_cat = \'' . $user_cat . '\', ') . $where_drp_up . $freight_update_data . ('goods_cause = \'' . $goods_cause . '\', ') . ('promote_price = \'' . $promote_price . '\', ') . ('promote_start_date = \'' . $promote_start_date . '\', ') . ('suppliers_id = \'' . $suppliers_id . '\', ') . ('promote_end_date = \'' . $promote_end_date . '\', ');

						if ($goods_img) {
							$sql .= 'goods_img = \'' . $goods_img . '\', original_img = \'' . $original_img . '\', ';
						}

						if ($goods_thumb) {
							$sql .= 'goods_thumb = \'' . $goods_thumb . '\', ';
						}

						if ($code != '') {
							$sql .= 'is_real=0, extension_code=\'' . $code . '\', ';
						}

						$sql .= 'keywords = \'' . $_POST['keywords'] . '\', ' . ('goods_brief = \'' . $_POST['goods_brief'] . '\', ') . ('seller_note = \'' . $_POST['seller_note'] . '\', ') . ('goods_weight = \'' . $goods_weight . '\',') . ('goods_number = \'' . $goods_number . '\', ') . ('warn_number = \'' . $warn_number . '\', ') . ('integral = \'' . $_POST['integral'] . '\', ') . ('give_integral = \'' . $give_integral . '\', ') . ('rank_integral = \'' . $rank_integral . '\', ') . ('is_on_sale = \'' . $is_on_sale . '\', ') . ('is_alone_sale = \'' . $is_alone_sale . '\', ') . ('is_shipping = \'' . $is_shipping . '\', ') . ('goods_desc = \'' . $_POST['goods_desc'] . '\', ') . ('desc_mobile = \'' . $_POST['desc_mobile'] . '\', ') . ('goods_shipai = \'' . $_POST['goods_shipai'] . '\', ') . 'last_update = \'' . gmtime() . '\', ' . ('goods_type = \'' . $goods_type . '\' ') . 'WHERE goods_id = \'' . $_REQUEST['goods_id'] . '\' LIMIT 1';
						$db->query($sql);
						$goodsInfo = get_admin_goods_info($_REQUEST['goods_id'], array('goods_number'));

						if ($goodsInfo['goods_number'] < $goods_number) {
							$not_number = $goods_number - $goodsInfo['goods_number'];
							$not_number = !empty($not_number) ? 1 : 0;
							$number = $goods_number - $goodsInfo['goods_number'];
							$number = '+ ' . $number;
							$use_storage = 13;
						}
						else {
							$not_number = $goodsInfo['goods_number'] - $goods_number;
							$not_number = !empty($not_number) ? 1 : 0;
							$number = $goodsInfo['goods_number'] - $goods_number;
							$number = '- ' . $number;
							$use_storage = 8;
						}

						$goods_sql = ' SELECT g.shop_price, g.shipping_fee, g.promote_price, g.give_integral, g.rank_integral, goods_weight, is_on_sale FROM ' . $ecs->table('goods') . ' AS g WHERE goods_id = \'' . $_REQUEST['goods_id'] . '\' ';
						$goods_info = $db->getRow($goods_sql);
						$member_price_sql = ' SELECT m.* FROM ' . $ecs->table('member_price') . ' AS m ' . ' LEFT JOIN ' . $ecs->table('user_rank') . ' AS u ON m.user_rank = u.rank_id WHERE goods_id = \'' . $_REQUEST['goods_id'] . '\' ORDER BY u.min_points ';
						$member_price_arr = $db->getAll($member_price_sql);

						if ($member_price_arr) {
							foreach ($member_price_arr as $v) {
								$user_price_old[$v['user_rank']] = $v['user_price'];
							}
						}
						else {
							$user_price_old = array();
						}

						$volume_price_sql = ' SELECT * FROM ' . $ecs->table('volume_price') . ' WHERE goods_id = \'' . $_REQUEST['goods_id'] . '\' ';
						$volume_price_arr = $db->getAll($volume_price_sql);

						if ($volume_price_arr) {
							foreach ($volume_price_arr as $v) {
								$volume_price_old[$v['volume_number']] = $v['volume_price'];
							}
						}
						else {
							$volume_price_old = array();
						}

						$logs_change_old = array('goods_id' => $_REQUEST['goods_id'], 'shop_price' => $goods_info['shop_price'], 'shipping_fee' => $goods_info['shipping_fee'], 'promote_price' => $goods_info['promote_price'], 'member_price' => serialize($user_price_old), 'volume_price' => serialize($volume_price_old), 'give_integral' => $goods_info['give_integral'], 'rank_integral' => $goods_info['rank_integral'], 'goods_weight' => $goods_info['goods_weight'], 'is_on_sale' => $goods_info['is_on_sale'], 'user_id' => $_SESSION['admin_id'], 'handle_time' => gmtime(), 'old_record' => 1);
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_change_log'), $logs_change_old, 'INSERT');
						$user_price = array_combine($_POST['user_rank'], $_POST['user_price']);

						if ($_POST['is_volume']) {
							$volume_price = array_combine($_POST['volume_number'], $_POST['volume_price']);
						}

						$logs_change = array('goods_id' => $_REQUEST['goods_id'], 'shop_price' => $shop_price, 'shipping_fee' => $shipping_fee, 'promote_price' => $promote_price, 'member_price' => serialize($user_price), 'volume_price' => serialize($volume_price), 'give_integral' => $give_integral, 'rank_integral' => $rank_integral, 'goods_weight'
						=> $goods_weight, 'is_on_sale' => $is_on_sale, 'user_id' => $_SESSION['admin_id'], 'handle_time' => gmtime(), 'old_record' => 0);
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_change_log'), $logs_change, 'INSERT');
					}

					$db->query($sql);
					$goods_id = $is_insert ? $db->insert_id() : $_REQUEST['goods_id'];
					if ($is_insert) {
						if($api && $goods_id>0){
							//操作主图
							if(isset($_POST['goods_original'])&&!empty($_POST['goods_original'])){
									$sql_img = 'UPDATE' . $ecs->table('goods') . (' SET original_img = \'' . $_POST['goods_original'] . '\',goods_img = \'' .$_POST['goods_original'] . '\',goods_thumb = \'' . $_POST['goods_original'] . '\' where goods_id ='.$goods_id.'');
									
									$db->query($sql_img);
							}
							if($goods_id>0 && !empty($_POST['goods_img_gallery'])){ //新增时候操作gallery表 此为API操作

								$gallery_obj=json_decode($_POST['goods_img_gallery'],true);//操作详情图

								if(is_array($gallery_obj)){
									
									foreach($gallery_obj as $k=>$v){
										if(is_array($v)){

											$sql_new ='INSERT INTO' . $ecs->table('goods_gallery') . ' (goods_id,img_url,img_desc,thumb_url,img_original,single_id,external_url,front_cover,dis_id)' . " VALUES ($goods_id,'{$v['img_original']}',{$v['img_desc']},'{$v['img_original']}','{$v['img_original']}', 0,'1',0,0)";
										}
							
										$db->query($sql_new);
									}
								}
							}     					
						}

						//添加关联地区的信息
						if($is_insert && $goods_id>0 ){
								$fittings = array(4,16,29,5,30,31,32,33,6,7,8,27,28,11,18,17,12,13,14,804,15,22,19,20,25,34,35,36,24,23);
								$result = array('error' => 0, 'message' => '', 'content' => '');

								if ($goods_id) {
									$sql = 'SELECT user_id FROM ' . $GLOBALS['ecs']->table('goods') . ' WHERE goods_id = \'' . $goods_id . '\'';
									$ru_id = $db->getOne($sql);
								}
								else {
									$ru_id = $adminru['ru_id'];
								}

								foreach ($fittings as $val) {
									$sql = 'INSERT INTO ' . $ecs->table('link_area_goods') . ' (goods_id, region_id, ru_id) ' . 'VALUES (\'' . $goods_id . '\', \'' . $val . '\', \'' . $ru_id . '\')';
									$db->query($sql, 'SILENT');
								}
						}

						// if($is_insert && $goods_id >0){   自营商品暂不需要传递关联数据
				  //                   	$url="http://test-api.artzhe.com/mp/ArtworkGoods/relateGoods";
				  //                   	$postStr=array(
				  //                   			'goodsId'=>$goods_id,
				  //                   			'artworkId'=>intval($_POST['artWorkId']),
				  //                   			'goodsType'=>1493,
				  //                   			'mallName'=>'艺术者商城',
				  //                   			'status'=>1,
				  //                   		);
				  //                   	$post_data=array(
				  //                   			'param'=>des_encode(json_encode($postStr)),
				  //                   		);
				  //                       $return_data = curl_request($url,$post_data);
      //              		}	

						if ($other_catids) {
							$other_catids = get_del_str_comma($other_catids);
							$sql = 'UPDATE' . $ecs->table('goods_cat') . (' SET goods_id=\'' . $goods_id . '\' WHERE goods_id = 0 AND cat_id in (' . $other_catids . ')');
							$db->query($sql);
						}
					}
					else {
						$sql = 'UPDATE' . $ecs->table('cart') . (' SET freight = \'' . $freight . '\', tid = \'' . $tid . '\', shipping_fee = \'' . $shipping_fee . '\' WHERE goods_id = \'' . $goods_id . '\'');
						$db->query($sql);

						if ($old_commission_rate != $commission_rate) {
							$sql = 'UPDATE ' . $GLOBALS['ecs']->table('cart') . (' SET commission_rate = \'' . $commission_rate . '\' WHERE ru_id = \'') . $adminru['ru_id'] . '\' AND goods_id = \'' . $_REQUEST['goods_id'] . '\' AND is_real = 1 AND is_gift = 0';
							$GLOBALS['db']->query($sql);
						}
					}

					if ($goods_id) {
						$is_reality = !empty($_POST['is_reality']) ? intval($_POST['is_reality']) : 0;
						$is_return = !empty($_POST['is_return']) ? intval($_POST['is_return']) : 0;
						$is_fast = !empty($_POST['is_fast']) ? intval($_POST['is_fast']) : 0;
						$extend = $db->getOne('select count(goods_id) from ' . $ecs->table('goods_extend') . (' where goods_id=\'' . $goods_id . '\''));

						if (0 < $extend) {
							$extend_sql = 'update ' . $ecs->table('goods_extend') . (' SET `is_reality`=\'' . $is_reality . '\',`is_return`=\'' . $is_return . '\',`is_fast`=\'' . $is_fast . '\' WHERE goods_id=\'' . $goods_id . '\'');
						}
						else {
							$extend_sql = 'INSERT INTO ' . $ecs->table('goods_extend') . ('(`goods_id`, `is_reality`, `is_return`, `is_fast`) VALUES (\'' . $goods_id . '\',\'' . $is_reality . '\',\'' . $is_return . '\',\'' . $is_fast . '\')');
						}

						$db->query($extend_sql);
						get_updel_goods_attr($goods_id);
					}

					$extend_arr = array();
					$extend_arr['width'] = isset($_POST['width']) ? trim($_POST['width']) : '';
					$extend_arr['height'] = isset($_POST['height']) ? trim($_POST['height']) : '';
					$extend_arr['depth'] = isset($_POST['depth']) ? trim($_POST['depth']) : '';
					$extend_arr['origincountry'] = isset($_POST['origincountry']) ? trim($_POST['origincountry']) : '';
					$extend_arr['originplace'] = isset($_POST['originplace']) ? trim($_POST['originplace']) : '';
					$extend_arr['assemblycountry'] = isset($_POST['assemblycountry']) ? trim($_POST['assemblycountry']) : '';
					$extend_arr['barcodetype'] = isset($_POST['barcodetype']) ? trim($_POST['barcodetype']) : '';
					$extend_arr['catena'] = isset($_POST['catena']) ? trim($_POST['catena']) : '';
					$extend_arr['isbasicunit'] = isset($_POST['isbasicunit']) ? intval($_POST['isbasicunit']) : 0;
					$extend_arr['packagetype'] = isset($_POST['packagetype']) ? trim($_POST['packagetype']) : '';
					$extend_arr['grossweight'] = isset($_POST['grossweight']) ? trim($_POST['grossweight']) : '';
					$extend_arr['netweight'] = isset($_POST['netweight']) ? trim($_POST['netweight']) : '';
					$extend_arr['netcontent'] = isset($_POST['netcontent']) ? trim($_POST['netcontent']) : '';
					$extend_arr['licensenum'] = isset($_POST['licensenum']) ? trim($_POST['licensenum']) : '';
					$extend_arr['healthpermitnum'] = isset($_POST['healthpermitnum']) ? trim($_POST['healthpermitnum']) : '';
					$db->autoExecute($ecs->table('goods_extend'), $extend_arr, 'UPDATE', 'goods_id = \'' . $goods_id . '\'');

					if ($not_number) {
						$logs_other = array('goods_id' => $goods_id, 'order_id' => 0, 'use_storage' => $use_storage, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $model_inventory, 'model_attr' => $model_attr, 'product_id' => 0, 'warehouse_id' => 0, 'area_id' => 0, 'add_time' => gmtime());
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
					}

					get_goods_payfull($is_fullcut, $cfull, $creduce, $c_id, $goods_id, 'goods_consumption');

					if ($is_insert) {
						if ($model_price == 1) {
							$warehouse_id = isset($_POST['warehouse_id']) ? $_POST['warehouse_id'] : array();

							if ($warehouse_id) {
								$warehouse_id = implode(',', $warehouse_id);
								$db->query(' UPDATE ' . $ecs->table('warehouse_goods') . (' SET goods_id = \'' . $goods_id . '\' WHERE w_id ') . db_create_in($warehouse_id));
							}
						}
						else if ($model_price == 2) {
							$warehouse_area_id = isset($_POST['warehouse_area_id']) ? $_POST['warehouse_area_id'] : array();

							if ($warehouse_area_id) {
								$warehouse_area_id = implode(',', $warehouse_area_id);
								$db->query(' UPDATE ' . $ecs->table('warehouse_area_goods') . (' SET goods_id = \'' . $goods_id . '\' WHERE a_id ') . db_create_in($warehouse_area_id));
							}
						}
						if($api){
							$old_admin_id = $_SESSION['admin_id'];
							$_SESSION['admin_id']=$user_id;
						}
						admin_log($_POST['goods_name'], 'add', 'goods');
						if($api){
							unset($_SESSION['admin_id']);
							$_SESSION['admin_id']=$old_admin_id; 
						}
						
					}
					else {
						admin_log($_POST['goods_name'], 'edit', 'goods');
						$shop_price_format = price_format($shop_price);
						$sql = 'SELECT * FROM ' . $ecs->table('sale_notice') . ' WHERE goods_id=\'' . intval($_REQUEST['goods_id']) . '\' AND STATUS!=1';
						$notice_list = $db->getAll($sql);

						foreach ($notice_list as $key => $val) {
							$sql = ' select user_name from ' . $GLOBALS['ecs']->table('users') . ' where user_id=\'' . $val['user_id'] . '\' ';
							$user_info = $GLOBALS['db']->getRow($sql);
							$user_name = $user_info['user_name'];
							$send_ok = 0;
							if ($shop_price <= $val['hopeDiscount'] && $val['cellphone'] && $_CFG['sms_price_notice'] == '1') {
								$user_info = get_admin_user_info($val['user_id']);
								$smsParams = array('user_name' => $user_info['user_name'], 'username' => $user_info['user_name'], 'goods_sn' => $goods_sn, 'goodssn' => $goods_sn, 'mobile_phone' => $val['cellphone'], 'mobilephone' => $val['cellphone']);

								if ($GLOBALS['_CFG']['sms_type'] == 0) {
									huyi_sms($smsParams, 'sms_price_notic');
								}
								else if (1 <= $GLOBALS['_CFG']['sms_type']) {
									$result = sms_ali($smsParams, 'sms_price_notic');

									if ($result) {
										$resp = $GLOBALS['ecs']->ali_yu($result);
									}
									else {
										sys_msg('阿里大鱼短信配置异常', 1);
									}
								}

								$send_type = 2;

								if ($res) {
									$sql = 'UPDATE ' . $ecs->table('sale_notice') . ' SET status = 1, send_type=2 WHERE goods_id = \'' . intval($_REQUEST['goods_id']) . ('\' AND user_id=\'' . $val['user_id'] . '\'');
									$db->query($sql);
									$send_ok = 1;
									notice_log($goods_id, $val['cellphone'], $send_ok, $send_type);
								}
								else {
									$sql = 'UPDATE ' . $ecs->table('sale_notice') . ' SET status = 3, send_type=2 WHERE goods_id = \'' . intval($_REQUEST['goods_id']) . ('\' AND user_id=\'' . $val['user_id'] . '\'');
									$db->query($sql);
									$send_ok = 0;
									notice_log($goods_id, $val['cellphone'], $send_ok, $send_type);
								}
							}

							if ($send_ok == 0 && $shop_price <= $val['hopeDiscount'] && $val['email']) {
								$template = get_mail_template('sale_notice');
								$smarty->assign('user_name', $user_name);
								$smarty->assign('goods_name', $_POST['goods_name']);
								$smarty->assign('goods_link', $ecs->seller_url() . 'goods.php?id=' . $_REQUEST['goods_id']);
								$smarty->assign('send_date', local_date($GLOBALS['_CFG']['time_format'], gmtime()));
								$content = $smarty->fetch('str:' . $template['template_content']);
								$send_type = 1;

								if (send_mail($user_name, $val['email'], $template['template_subject'], $content, $template['is_html'])) {
									$sql = 'UPDATE ' . $ecs->table('sale_notice') . ' SET status = 1, send_type=1 WHERE goods_id = \'' . intval($_REQUEST['goods_id']) . ('\' AND user_id=\'' . $val['user_id'] . '\'');
									$db->query($sql);
									$send_ok = 1;
									notice_log($goods_id, $val['email'], $send_ok, $send_type);
								}
								else {
									$sql = 'UPDATE ' . $ecs->table('sale_notice') . ' SET status = 3, send_type=1 WHERE goods_id = \'' . intval($_REQUEST['goods_id']) . ('\' AND user_id=\'' . $val['user_id'] . '\'');
									$db->query($sql);
									$send_ok = 0;
									notice_log($goods_id, $val['email'], $send_ok, $send_type);
								}
							}
						}
					}

					if($is_app && isset($_POST['is_mount']) && isset($_POST['is_collect'])){
							$attr_mount_id = $db->getOne('SELECT attr_id FROM ' . $ecs->table('attribute') . (' WHERE attr_name = \'' . '装裱' . '\''));
							$attr_collect_id = $db->getOne('SELECT attr_id FROM ' . $ecs->table('attribute') . (' WHERE attr_name = \'' . '收藏证书' . '\''));

							$_POST['attr_id_list']=array($attr_mount_id,$attr_collect_id);
							if(empty($_POST['is_mount']) && empty($_POST['is_collect'])){
								exit(json_encode(array(
										    'error'=>1,
								            'msg'=>'装裱或者书藏证书缺失',
									)));
							}
							$_POST['attr_value_list']=array($_POST['is_mount'],$_POST['is_collect']);
					}

					if (isset($_POST['attr_id_list']) && isset($_POST['attr_value_list']) || empty($_POST['attr_id_list']) && empty($_POST['attr_value_list'])) {
						$goods_attr_list = array();
						$sql = 'SELECT attr_id, attr_index FROM ' . $ecs->table('attribute') . (' WHERE cat_id = \'' . $goods_type . '\'');
						$attr_res = $db->query($sql);
						$attr_list = array();

						while ($row = $db->fetchRow($attr_res)) {
							$attr_list[$row['attr_id']] = $row['attr_index'];
						}

						$sql = "SELECT g.*, a.attr_type\r\n                FROM " . $ecs->table('goods_attr') . " AS g\r\n                    LEFT JOIN " . $ecs->table('attribute') . (" AS a\r\n                        ON a.attr_id = g.attr_id\r\n                WHERE g.goods_id = '" . $goods_id . '\'');
						$res = $db->query($sql);

						while ($row = $db->fetchRow($res)) {
							$goods_attr_list[$row['attr_id']][$row['attr_value']] = array('sign' => 'delete', 'goods_attr_id' => $row['goods_attr_id']);
						}

						if (isset($_POST['attr_id_list'])) {
							foreach ($_POST['attr_id_list'] as $key => $attr_id) {
								$attr_value = $_POST['attr_value_list'][$key];
								$attr_price = $_POST['attr_price_list'][$key];
								$attr_sort = $_POST['attr_sort_list'][$key];

								if (!empty($attr_value)) {
									if (isset($goods_attr_list[$attr_id][$attr_value])) {
										$goods_attr_list[$attr_id][$attr_value]['sign'] = 'update';
										$goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
										$goods_attr_list[$attr_id][$attr_value]['attr_sort'] = $attr_sort;
									}
									else {
										$goods_attr_list[$attr_id][$attr_value]['sign'] = 'insert';
										$goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
										$goods_attr_list[$attr_id][$attr_value]['attr_sort'] = $attr_sort;
									}
								}
							}
						}

						if (isset($_POST['gallery_attr_id'])) {
							foreach ($_POST['gallery_attr_id'] as $key => $attr_id) {
								$gallery_attr_value = $_POST['gallery_attr_value'][$key];
								$gallery_attr_price = $_POST['gallery_attr_price'][$key];
								$gallery_attr_sort = $_POST['gallery_attr_sort'][$key];

								if (!empty($gallery_attr_value)) {
									if (isset($goods_attr_list[$attr_id][$gallery_attr_value])) {
										$goods_attr_list[$attr_id][$gallery_attr_value]['sign'] = 'update';
										$goods_attr_list[$attr_id][$gallery_attr_value]['attr_price'] = $gallery_attr_price;
										$goods_attr_list[$attr_id][$gallery_attr_value]['attr_sort'] = $gallery_attr_sort;
									}
									else {
										$goods_attr_list[$attr_id][$gallery_attr_value]['sign'] = 'insert';
										$goods_attr_list[$attr_id][$gallery_attr_value]['attr_price'] = $gallery_attr_price;
										$goods_attr_list[$attr_id][$gallery_attr_value]['attr_sort'] = $gallery_attr_sort;
									}
								}
							}
						}

						foreach ($goods_attr_list as $attr_id => $attr_value_list) {
							foreach ($attr_value_list as $attr_value => $info) {
								if ($info['sign'] == 'insert') {
									$sql = 'INSERT INTO ' . $ecs->table('goods_attr') . ' (attr_id, goods_id, attr_value, attr_price, attr_sort)' . ('VALUES (\'' . $attr_id . '\', \'' . $goods_id . '\', \'' . $attr_value . '\', \'' . $info['attr_price'] . '\', \'' . $info['attr_sort'] . '\')');

								}
								else if ($info['sign'] == 'update') {
									$sql = 'UPDATE ' . $ecs->table('goods_attr') . (' SET attr_price = \'' . $info['attr_price'] . '\', attr_sort = \'' . $info['attr_sort'] . '\' WHERE goods_attr_id = \'' . $info['goods_attr_id'] . '\' LIMIT 1');
								}
								else {
									if ($model_attr == 1) {
										$table = 'products_warehouse';
									}
									else if ($model_attr == 2) {
										$table = 'products_area';
									}
									else {
										$table = 'products';
									}

									$where = ' AND goods_id = \'' . $goods_id . '\'';
									$ecs->get_del_find_in_set($info['goods_attr_id'], $where, $table, 'goods_attr', '|');
									$sql = 'DELETE FROM ' . $ecs->table('goods_attr') . ' WHERE goods_attr_id = \'' . $info['goods_attr_id'] . '\' LIMIT 1';
								}
								$db->query($sql);

							}
						}
					}

					if (isset($_POST['user_rank']) && isset($_POST['user_price'])) {
						handle_member_price($goods_id, $_POST['user_rank'], $_POST['user_price']);
					}

					if (isset($_POST['volume_number']) && isset($_POST['volume_price'])) {
						handle_volume_price($goods_id, $is_volume, $_POST['volume_number'], $_POST['volume_price'], $_POST['id']);
					}

					if (isset($_POST['other_cat'])) {
						handle_other_cat($goods_id, array_unique($_POST['other_cat']));
					}

					if ($is_insert) {
						handle_link_goods($goods_id);
						handle_group_goods($goods_id);
						handle_goods_article($goods_id);
						handle_goods_area($goods_id);
						$thumb_img_id = $_SESSION['thumb_img_id' . $_SESSION['admin_id']];

						if ($thumb_img_id) {
							$sql = ' UPDATE ' . $ecs->table('goods_gallery') . ' SET goods_id = \'' . $goods_id . '\' WHERE goods_id = 0 AND img_id ' . db_create_in($thumb_img_id);
							$db->query($sql);
						}

						unset($_SESSION['thumb_img_id' . $_SESSION['admin_id']]);
					}

					if (!empty($_POST['goods_img_url']) && $is_img_url == 1 && empty($api)) {
						$original_img = reformat_image_name('goods', $goods_id, $original_img, 'source');
						$goods_img = reformat_image_name('goods', $goods_id, $goods_img, 'goods');
						$goods_thumb = reformat_image_name('goods_thumb', $goods_id, $goods_thumb, 'thumb');
						$sql = ' UPDATE ' . $ecs->table('goods') . (' SET goods_thumb = \'' . $original_img . '\', goods_img = \'' . $original_img . '\', original_img = \'' . $original_img . '\' WHERE goods_id = \'' . $goods_id . '\' ');
						$db->query($sql);

						if (isset($img)) {
							if (empty($is_url_goods_img)) {
								$img = reformat_image_name('gallery', $goods_id, $img, 'source');
								$gallery_img = reformat_image_name('gallery', $goods_id, $gallery_img, 'goods');
							}
							else {
								$img = $original_img;
								$gallery_img = $goods_img;
							}

							$gallery_thumb = reformat_image_name('gallery_thumb', $goods_id, $gallery_thumb, 'thumb');
							$sql = 'INSERT INTO ' . $ecs->table('goods_gallery') . ' (goods_id, img_url, thumb_url, img_original) ' . ('VALUES (\'' . $goods_id . '\', \'' . $gallery_img . '\', \'' . $gallery_thumb . '\', \'' . $img . '\')');
							$db->query($sql);
						}

						get_oss_add_file(array($goods_img, $goods_thumb, $original_img, $gallery_img, $gallery_thumb, $img));
					}
					else {
						get_oss_add_file(array($goods_img, $goods_thumb, $original_img));
					}

					$where_products = '';
					$goods_model = isset($_POST['goods_model']) && !empty($_POST['goods_model']) ? intval($_POST['goods_model']) : 0;
					$warehouse = isset($_POST['warehouse']) && !empty($_POST['warehouse']) ? intval($_POST['warehouse']) : 0;
					$region = isset($_POST['region']) && !empty($_POST['region']) ? intval($_POST['region']) : 0;
					$arrt_page_count = isset($_POST['arrt_page_count']) && !empty($_POST['arrt_page_count']) ? intval($_POST['arrt_page_count']) : 1;

					if ($goods_model == 1) {
						$table = 'products_warehouse';
						$region_id = $warehouse;
						$products_extension_insert_name = ' , warehouse_id ';
						$products_extension_insert_value = ' , \'' . $warehouse . '\' ';
						$where_products .= ' AND warehouse_id = \'' . $warehouse . '\' ';
					}
					else if ($goods_model == 2) {
						$table = 'products_area';
						$region_id = $region;
						$products_extension_insert_name = ' , area_id ';
						$products_extension_insert_value = ' , \'' . $region . '\' ';
						$where_products .= ' AND area_id = \'' . $region . '\' ';
					}
					else {
						$table = 'products';
						$products_extension_insert_name = '';
						$products_extension_insert_value = '';
					}

					if ($is_insert) {
						$sql = 'UPDATE' . $ecs->table($table) . (' SET goods_id = \'' . $goods_id . '\' WHERE goods_id = 0 AND admin_id = \'' . $admin_id . '\'');
						$db->query($sql);
					}

					$product['goods_id'] = $goods_id;
					$product['attr'] = isset($_POST['attr']) && !empty($_POST['attr']) ? $_POST['attr'] : array();
					$product['product_id'] = isset($_POST['product_id']) && !empty($_POST['product_id']) ? $_POST['product_id'] : array();
					$product['product_sn'] = isset($_POST['product_sn']) && !empty($_POST['product_sn']) ? $_POST['product_sn'] : array();
					$product['product_number'] = isset($_POST['product_number']) && !empty($_POST['product_number']) ? $_POST['product_number'] : array();
					$product['product_price'] = isset($_POST['product_price']) && !empty($_POST['product_price']) ? $_POST['product_price'] : array();
					$product['product_market_price'] = isset($_POST['product_market_price']) && !empty($_POST['product_market_price']) ? $_POST['product_market_price'] : array();
					$product['product_promote_price'] = isset($_POST['product_promote_price']) ? $_POST['product_promote_price'] : array();
					$product['product_warn_number'] = isset($_POST['product_warn_number']) && !empty($_POST['product_warn_number']) ? $_POST['product_warn_number'] : array();
					$product['bar_code'] = isset($_POST['product_bar_code']) && !empty($_POST['product_bar_code']) ? $_POST['product_bar_code'] : array();

					if (empty($product['goods_id'])) {
						sys_msg($_LANG['sys']['wrong'] . $_LANG['cannot_found_goods'], 1, array(), false);
					}

					$sql = 'SELECT goods_sn, goods_name, goods_type, shop_price, model_inventory, model_attr FROM ' . $ecs->table('goods') . (' WHERE goods_id = \'' . $goods_id . '\' LIMIT 1');
					$goods = $db->getRow($sql);

					if (empty($product['product_sn'])) {
						$product['product_sn'] = array();
					}

					foreach ($product['product_sn'] as $key => $value) {
						$product['product_number'][$key] = trim($product['product_number'][$key]);
						$product['product_id'][$key] = isset($product['product_id'][$key]) && !empty($product['product_id'][$key]) ? intval($product['product_id'][$key]) : 0;
						$logs_other = array('goods_id' => $goods_id, 'order_id' => 0, 'admin_id' => $_SESSION['admin_id'], 'model_inventory' => $goods['model_inventory'], 'model_attr' => $goods['model_attr'], 'add_time' => gmtime());

						if ($goods_model == 1) {
							$logs_other['warehouse_id'] = $warehouse;
							$logs_other['area_id'] = 0;
						}
						else if ($goods_model == 2) {
							$logs_other['warehouse_id'] = 0;
							$logs_other['area_id'] = $region;
						}
						else {
							$logs_other['warehouse_id'] = 0;
							$logs_other['area_id'] = 0;
						}

						if ($product['product_id'][$key]) {
							$goods_product = get_product_info($product['product_id'][$key], 'product_number', $goods_model);

							if ($goods_product['product_number'] != $product['product_number'][$key]) {
								if ($product['product_number'][$key] < $goods_product['product_number']) {
									$number = $goods_product['product_number'] - $product['product_number'][$key];
									$number = '- ' . $number;
									$logs_other['use_storage'] = 10;
								}
								else {
									$number = $product['product_number'][$key] - $goods_product['product_number'];
									$number = '+ ' . $number;
									$logs_other['use_storage'] = 11;
								}

								$logs_other['number'] = $number;
								$logs_other['product_id'] = $product['product_id'][$key];
								$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
							}

							$sql = 'UPDATE ' . $GLOBALS['ecs']->table($table) . ' SET product_number = \'' . $product['product_number'][$key] . '\', ' . ' product_market_price = \'' . $product['product_market_price'][$key] . '\', ' . ' product_price = \'' . $product['product_price'][$key] . '\', ' . ' product_promote_price = \'' . $product['product_promote_price'][$key] . '\', ' . ' product_warn_number = \'' . $product['product_warn_number'][$key] . '\',' . 'product_sn = \'' . $goods['goods_sn'] . 'g_p' . $product['product_id'][$key] . '\'' . ' WHERE product_id = \'' . $product['product_id'][$key] . '\'';
							$GLOBALS['db']->query($sql);
						}
						else {
							$number = 0;

							foreach ($product['attr'] as $attr_key => $attr_value) {
								if (empty($attr_value[$key])) {
									continue 2;
								}

								$is_spec_list[$attr_key] = 'true';
								$value_price_list[$attr_key] = $attr_value[$key] . chr(9) . '';
								$id_list[$attr_key] = $attr_key;
							}

							$goods_attr_id = handle_goods_attr($product['goods_id'], $id_list, $is_spec_list, $value_price_list);
							$goods_attr = sort_goods_attr_id_array($goods_attr_id);

							if (!empty($goods_attr['sort'])) {
								$goods_attr = implode('|', $goods_attr['sort']);
							}
							else {
								$goods_attr = '';
							}

							if (check_goods_attr_exist($goods_attr, $product['goods_id'], 0, $region_id)) {
								continue;
							}

							$sql = 'INSERT INTO ' . $GLOBALS['ecs']->table($table) . ' (goods_id, goods_attr, product_sn, product_number, product_price, product_market_price, product_promote_price, product_warn_number, bar_code ' . $products_extension_insert_name . ') VALUES ' . ' (\'' . $product['goods_id'] . ('\', \'' . $goods_attr . '\', \'' . $value . '\', \'') . $product['product_number'][$key] . '\', \'' . $product['product_price'][$key] . '\', \'' . $product['product_market_price'][$key] . '\', \'' . $product['product_promote_price'][$key] . '\', \'' . $product['product_warn_number'][$key] . '\', \'' . $product['bar_code'][$key] . '\' ' . $products_extension_insert_value . ')';

							if (!$GLOBALS['db']->query($sql)) {
								continue;
							}
							else {
								$product_id = $GLOBALS['db']->insert_id();

								if (empty($value)) {
									$sql = 'UPDATE ' . $GLOBALS['ecs']->table($table) . "\r\n                                SET product_sn = '" . $goods['goods_sn'] . 'g_p' . $GLOBALS['db']->insert_id() . ("'\r\n                                WHERE product_id = '" . $product_id . '\'');
									$GLOBALS['db']->query($sql);
								}

								$number = '+ ' . $product['product_number'][$key];
								$logs_other['use_storage'] = 9;
								$logs_other['product_id'] = $product_id;
								$logs_other['number'] = $number;
								$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
							}
						}
					}

					$changelog_where = 'WHERE 1 AND admin_id = \'' . $_SESSION['admin_id'] . '\'';

					if ($is_insert) {
						$changelog_where .= ' AND goods_id = 0';
					}
					else {
						$changelog_where .= ' AND goods_id = \'' . $goods_id . '\'';
					}

					if (!empty($changelog_product_id)) {
						$changelog_where .= ' AND product_id NOT ' . db_create_in($changelog_product_id);
					}

					$sql = 'SELECT goods_attr,product_sn,bar_code,product_number,product_price,product_market_price,product_promote_price,product_warn_number,warehouse_id,area_id,admin_id FROM' . $ecs->table('products_changelog') . $changelog_where . $where_products;
					$products_changelog = $db->getAll($sql);

					if (!empty($products_changelog)) {
						foreach ($products_changelog as $k => $v) {
							if (check_goods_attr_exist($v['goods_attr'], $product['goods_id'], 0, $region_id)) {
								continue;
							}

							$number = 0;
							$logs_other = array('goods_id' => $goods_id, 'order_id' => 0, 'admin_id' => $_SESSION['admin_id'], 'model_inventory' => $goods['model_inventory'], 'model_attr' => $goods['model_attr'], 'add_time' => gmtime());

							if ($goods_model == 1) {
								$logs_other['warehouse_id'] = $warehouse;
								$logs_other['area_id'] = 0;
							}
							else if ($goods_model == 2) {
								$logs_other['warehouse_id'] = 0;
								$logs_other['area_id'] = $region;
							}
							else {
								$logs_other['warehouse_id'] = 0;
								$logs_other['area_id'] = 0;
							}

							$sql = 'INSERT INTO ' . $GLOBALS['ecs']->table($table) . ' (goods_id, goods_attr, product_sn, product_number, product_price, product_market_price, product_promote_price, product_warn_number, bar_code ' . $products_extension_insert_name . ') VALUES ' . ' (\'' . $product['goods_id'] . '\', \'' . $v['goods_attr'] . '\', \'' . $v['product_sn'] . '\', \'' . $v['product_number'] . '\', \'' . $v['product_price'] . '\', \'' . $v['product_market_price'] . '\', \'' . $v['product_promote_price'] . '\', \'' . $v['product_warn_number'] . '\', \'' . $v['bar_code'] . '\' ' . $products_extension_insert_value . ')';

							if (!$GLOBALS['db']->query($sql)) {
								continue;
							}
							else {
								$product_id = $GLOBALS['db']->insert_id();

								if (empty($v['product_sn'])) {
									$sql = 'UPDATE ' . $GLOBALS['ecs']->table($table) . "\r\n                                SET product_sn = '" . $goods['goods_sn'] . 'g_p' . $product_id . ("'\r\n                                WHERE product_id = '" . $product_id . '\'');
									$GLOBALS['db']->query($sql);
								}

								$number = '+ ' . $v['product_number'];
								$logs_other['use_storage'] = 9;
								$logs_other['product_id'] = $product_id;
								$logs_other['number'] = $number;
								$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
							}
						}
					}

					$sql = 'DELETE FROM' . $ecs->table('products_changelog') . ('WHERE goods_id = \'' . $goods_id . '\' AND admin_id = \'') . $_SESSION['admin_id'] . '\'';
					$db->query($sql);
					$goods = get_admin_goods_info($goods_id, array('promote_price', 'promote_start_date', 'promote_end_date', 'user_id', 'model_attr'));
					if ($GLOBALS['_CFG']['add_shop_price'] == 0 && $goods['model_attr'] == 0) {
						include_once ROOT_PATH . '/includes/lib_goods.php';
						$properties = get_goods_properties($goods_id, 0, 0, '', 0, $goods['model_attr'], 0);
						$spe = !empty($properties['spe']) ? array_values($properties['spe']) : $properties['spe'];
						$arr = array();
						$goodsAttrId = '';

						if ($spe) {
							foreach ($spe as $key => $val) {
								if ($val['values']) {
									if ($val['is_checked']) {
										$arr[$key]['values'] = get_goods_checked_attr($val['values']);
									}
									else {
										$arr[$key]['values'] = $val['values'][0];
									}
								}

								if ($arr[$key]['values']['id']) {
									$goodsAttrId .= $arr[$key]['values']['id'] . ',';
								}
							}

							$goodsAttrId = get_del_str_comma($goodsAttrId);
						}

						$time = gmtime();

						if (!empty($goodsAttrId)) {
							$products = get_warehouse_id_attr_number($goods_id, $goodsAttrId, $goods['user_id'], 0, 0, $goods['model_attr']);

							if ($products) {
								$products['product_market_price'] = isset($products['product_market_price']) ? $products['product_market_price'] : 0;
								$products['product_price'] = isset($products['product_price']) ? $products['product_price'] : 0;
								$products['product_promote_price'] = isset($products['product_promote_price']) ? $products['product_promote_price'] : 0;
								$promote_price = 0;
								if ($goods['promote_start_date'] <= $time && $time <= $goods['promote_end_date']) {
									$promote_price = $goods['promote_price'];
								}

								if (0 < $row['promote_price']) {
									$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
								}
								else {
									$promote_price = 0;
								}

								if ($goods['promote_start_date'] <= $time && $time <= $goods['promote_end_date']) {
									$promote_price = $products['product_promote_price'];
								}

								$other = array('product_table' => $products['product_table'], 'product_id' => $products['product_id'], 'product_price' => $products['product_price'], 'product_promote_price' => $promote_price);
								$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods'), $other, 'UPDATE', 'goods_id = \'' . $goods_id . '\'');
							}
						}
					}
					else if (0 < $goods['model_attr']) {
						$goods_other = array('product_table' => '', 'product_id' => 0, 'product_price' => 0, 'product_promote_price' => 0);
						$db->autoExecute($ecs->table('goods'), $goods_other, 'UPDATE', 'goods_id = \'' . $goods_id . '\'');
					}

					clear_cache_files();
					$link = array();

					if ($code == 'virtual_card') {
						$link[1] = array('href' => 'virtual_card.php?act=replenish&goods_id=' . $goods_id, 'text' => $_LANG['add_replenish']);
					}

					if ($is_insert) {
						$link[2] = add_link($code);
					}

					$link[3] = list_link($is_insert, $code);

					for ($i = 0; $i < count($link); $i++) {
						$key_array[] = $i;
					}

					krsort($link);
					$link = array_combine($key_array, $link);

					if ($goods_id) {
						$sql = 'UPDATE ' . $GLOBALS['ecs']->table('cart') . (' SET is_shipping = \'' . $is_shipping . '\' WHERE goods_id = \'' . $goods_id . '\' AND extension_code != \'package_buy\'');
						$GLOBALS['db']->query($sql);
					}

					if ($is_insert) {
						get_del_update_goods_null($goods_id, 1);
					}
					else if ($goods_type == 0) {
						$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('products') . (' WHERE goods_id = \'' . $goods_id . '\'');
						$GLOBALS['db']->query($sql);
						$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('products_area') . (' WHERE goods_id = \'' . $goods_id . '\'');
						$GLOBALS['db']->query($sql);
						$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('products_warehouse') . (' WHERE goods_id = \'' . $goods_id . '\'');
						$GLOBALS['db']->query($sql);
						$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('goods_attr') . (' WHERE goods_id = \'' . $goods_id . '\'');
						$GLOBALS['db']->query($sql);
					}
					if($is_insert && $goods_id >0 && $_POST['artWorkId']){
                    	$url="http://test-api.artzhe.com/mp/ArtworkGoods/relateGoods";
                    	$postStr=array(
                    			'goodsId'=>$goods_id,
                    			'artworkId'=>intval($_POST['artWorkId']),
                    			'goodsType'=>empty($catgory_id)?1488:$catgory_id,
                    			'mallName'=>'艺术者商城',
                    			'status'=>1,
                    		);
                    	$post_data=array(
                    			'param'=>des_encode(json_encode($postStr)),
                    		);
                        curl_request($url,$post_data);
                    }
                    if($is_insert && $goods_id >0 && $api){
                    	exit(json_encode(array(
                    			'error'=>0,
                    			'msg'=>'转化商品成功',
                    			'goods_id'=>$goods_id,
                    		)));
                    }


					sys_msg($is_insert ? $_LANG['add_goods_ok'] : $_LANG['edit_goods_ok'], 0, $link);
                 
                    exit;

				}
				else if ($_REQUEST['act'] == 'batch') {
					 
					
				}
				else if ($_REQUEST['act'] == 'show_image') {
					$smarty->assign('primary_cat', $_LANG['02_cat_and_goods']);
					if (isset($GLOBALS['shop_id']) && 0 < $GLOBALS['shop_id']) {
						$img_url = $_GET['img_url'];
					}
					else {
						if (strpos($_GET['img_url'], 'http://') === 0 && strpos($_GET['img_url'], 'https://') === 0) {
							$img_url = $_GET['img_url'];
						}
						else {
							$img_url = '../' . $_GET['img_url'];
						}
					}

					$smarty->assign('img_url', $img_url);
					$smarty->display('goods_show_image.dwt');
				}
				else if ($_REQUEST['act'] == 'edit_goods_name') {
				
				}
				else if ($_REQUEST['act'] == 'check_products_goods_sn') {
					
				}
				else if ($_REQUEST['act'] == 'edit_goods_price') {
					check_authz_json('goods_manage');
					$goods_id = intval($_POST['id']);
					$goods_price = floatval($_POST['val']);
					$price_rate = floatval($_CFG['market_price_rate'] * $goods_price);
					if ($goods_price < 0 || $goods_price == 0 && $_POST['val'] != $goods_price) {
						make_json_error($_LANG['shop_price_invalid']);
					}
					else if ($exc->edit('shop_price = \'' . $goods_price . '\', market_price = \'' . $price_rate . '\', review_status = 1, last_update=' . gmtime(), $goods_id)) {
						clear_cache_files();
						make_json_result(number_format($goods_price, 2, '.', ''));
					}
				}
				else if ($_REQUEST['act'] == 'edit_goods_number') {
					
				}
				else if ($_REQUEST['act'] == 'edit_commission_rate') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_on_sale') {
					
				}
				else if ($_REQUEST['act'] == 'edit_img_desc') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_best') {
					
				}
				else if ($_REQUEST['act'] == 'main_dsc') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_new') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_hot') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_store_best') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_store_new') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_store_hot') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_is_reality') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_is_return') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_is_fast') {
					
				}
				else if ($_REQUEST['act'] == 'toggle_is_shipping') {
					
				}
				else if ($_REQUEST['act'] == 'edit_sort_order') {
					
				}
				else if ($_REQUEST['act'] == 'query') {
					
				}
				else if ($_REQUEST['act'] == 'remove') {
					
				}
				else if ($_REQUEST['act'] == 'restore_goods') {
					
				}
				else if ($_REQUEST['act'] == 'drop_goods') {
					
				}
				else if ($_REQUEST['act'] == 'get_attr') {
					
				}
				else if ($_REQUEST['act'] == 'drop_image') {
					
				}
				else if ($_REQUEST['act'] == 'drop_product') {
					
				}
				else if ($_REQUEST['act'] == 'drop_warehouse') {
					check_authz_json('goods_manage');
					$w_id = empty($_REQUEST['w_id']) ? 0 : intval($_REQUEST['w_id']);
					$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('warehouse_goods') . (' WHERE w_id = \'' . $w_id . '\' LIMIT 1');
					$GLOBALS['db']->query($sql);
					clear_cache_files();
					make_json_result($w_id);
				}
				else if ($_REQUEST['act'] == 'edit_warehouse_number') {
					check_authz_json('goods_manage');
					$w_id = intval($_POST['id']);
					$region_number = intval($_POST['val']);
					$sql = 'SELECT goods_id, region_number, region_id FROM ' . $ecs->table('warehouse_goods') . (' WHERE w_id = \'' . $w_id . '\' LIMIT 1');
					$warehouse_goods = $db->getRow($sql);
					$goodsInfo = get_admin_goods_info($warehouse_goods['goods_id'], array('model_inventory', 'model_attr'));

					if ($region_number != $warehouse_goods['region_number']) {
						if ($warehouse_goods['region_number'] < $region_number) {
							$number = $region_number - $warehouse_goods['region_number'];
							$number = '+ ' . $number;
							$use_storage = 13;
						}
						else {
							$number = $warehouse_goods['region_number'] - $region_number;
							$number = '- ' . $number;
							$use_storage = 8;
						}

						$logs_other = array('goods_id' => $warehouse_goods['goods_id'], 'order_id' => 0, 'use_storage' => $use_storage, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $goodsInfo['model_inventory'], 'model_attr' => $goodsInfo['model_attr'], 'product_id' => 0, 'warehouse_id' => $warehouse_goods['region_id'], 'area_id' => 0, 'add_time' => gmtime());
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
					}

					$sql = 'update ' . $ecs->table('warehouse_goods') . (' set region_number = \'' . $region_number . '\' where w_id = \'' . $w_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($region_number);
					}
				}
				else if ($_REQUEST['act'] == 'edit_warehouse_sn') {
					check_authz_json('goods_manage');
					$w_id = intval($_POST['id']);
					$region_sn = addslashes(trim($_POST['val']));
					$sql = 'update ' . $ecs->table('warehouse_goods') . (' set region_sn = \'' . $region_sn . '\' where w_id = \'' . $w_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($region_sn);
					}
				}
				else if ($_REQUEST['act'] == 'edit_warehouse_price') {
					check_authz_json('goods_manage');
					$w_id = intval($_POST['id']);
					$warehouse_price = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_goods') . (' set warehouse_price = \'' . $warehouse_price . '\' where w_id = \'' . $w_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($warehouse_price);
					}
				}
				else if ($_REQUEST['act'] == 'edit_warehouse_promote_price') {
					check_authz_json('goods_manage');
					$w_id = intval($_POST['id']);
					$warehouse_promote_price = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_goods') . (' set warehouse_promote_price = \'' . $warehouse_promote_price . '\' where w_id = \'' . $w_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($warehouse_promote_price);
					}
				}
				else if ($_REQUEST['act'] == 'edit_warehouse_give_integral') {
					check_authz_json('goods_manage');
					$w_id = intval($_POST['id']);
					$give_integral = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_goods') . (' set give_integral = \'' . $give_integral . '\' where w_id = \'' . $w_id . '\' ');
					$res = $db->query($sql);
					$other = array('w_id', 'user_id', 'warehouse_price', 'warehouse_promote_price');
					$goods = get_table_date('warehouse_goods', 'w_id=\'' . $w_id . '\'', $other);
					$goods['user_id'] = !empty($goods['user_id']) ? $goods['user_id'] : $adminru['ru_id'];

					if ($goods['warehouse_promote_price']) {
						if ($goods['warehouse_promote_price'] < $goods['warehouse_price']) {
							$shop_price = $goods['warehouse_promote_price'];
						}
						else {
							$shop_price = $goods['warehouse_price'];
						}
					}
					else {
						$shop_price = $goods['warehouse_price'];
					}

					$grade_rank = get_seller_grade_rank($goods['user_id']);
					$give = floor($shop_price * $grade_rank['give_integral']);

					if ($give < $give_integral) {
						make_json_error(sprintf($_LANG['goods_give_integral'], $give));
					}

					if ($res) {
						clear_cache_files();
						make_json_result($give_integral);
					}
				}
				else if ($_REQUEST['act'] == 'edit_warehouse_rank_integral') {
					check_authz_json('goods_manage');
					$w_id = intval($_POST['id']);
					$rank_integral = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_goods') . (' set rank_integral = \'' . $rank_integral . '\' where w_id = \'' . $w_id . '\' ');
					$res = $db->query($sql);
					$other = array('w_id', 'user_id', 'warehouse_price', 'warehouse_promote_price');
					$goods = get_table_date('warehouse_goods', 'w_id=\'' . $w_id . '\'', $other);
					$goods['user_id'] = !empty($goods['user_id']) ? $goods['user_id'] : $adminru['ru_id'];

					if ($goods['warehouse_promote_price']) {
						if ($goods['warehouse_promote_price'] < $goods['warehouse_price']) {
							$shop_price = $goods['warehouse_promote_price'];
						}
						else {
							$shop_price = $goods['warehouse_price'];
						}
					}
					else {
						$shop_price = $goods['warehouse_price'];
					}

					$grade_rank = get_seller_grade_rank($goods['user_id']);
					$rank = floor($shop_price * $grade_rank['rank_integral']);

					if ($rank < $rank_integral) {
						make_json_error(sprintf($_LANG['goods_rank_integral'], $rank));
					}

					if ($res) {
						clear_cache_files();
						make_json_result($rank_integral);
					}
				}
				else if ($_REQUEST['act'] == 'edit_warehouse_pay_integral') {
					check_authz_json('goods_manage');
					$w_id = intval($_POST['id']);
					$pay_integral = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_goods') . (' set pay_integral = \'' . $pay_integral . '\' where w_id = \'' . $w_id . '\' ');
					$res = $db->query($sql);
					$other = array('w_id', 'user_id', 'warehouse_price', 'warehouse_promote_price');
					$goods = get_table_date('warehouse_goods', 'w_id=\'' . $w_id . '\'', $other);
					$goods['user_id'] = !empty($goods['user_id']) ? $goods['user_id'] : $adminru['ru_id'];

					if ($goods['warehouse_promote_price']) {
						if ($goods['warehouse_promote_price'] < $goods['warehouse_price']) {
							$shop_price = $goods['warehouse_promote_price'];
						}
						else {
							$shop_price = $goods['warehouse_price'];
						}
					}
					else {
						$shop_price = $goods['warehouse_price'];
					}

					$grade_rank = get_seller_grade_rank($goods['user_id']);
					$pay = floor($shop_price * $grade_rank['pay_integral']);

					if ($pay < $pay_integral) {
						make_json_error(sprintf($_LANG['goods_pay_integral'], $pay));
					}

					if ($res) {
						clear_cache_files();
						make_json_result($pay_integral);
					}
				}
				else if ($_REQUEST['act'] == 'edit_region_sn') {
					check_authz_json('goods_manage');
					$a_id = intval($_POST['id']);
					$region_sn = addslashes(trim($_POST['val']));
					$sql = 'update ' . $ecs->table('warehouse_area_goods') . (' set region_sn = \'' . $region_sn . '\' where a_id = \'' . $a_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($region_sn);
					}
				}
				else if ($_REQUEST['act'] == 'drop_warehouse_area') {
					check_authz_json('goods_manage');
					$a_id = empty($_REQUEST['a_id']) ? 0 : intval($_REQUEST['a_id']);
					$sql = 'DELETE FROM ' . $GLOBALS['ecs']->table('warehouse_area_goods') . (' WHERE a_id = \'' . $a_id . '\' LIMIT 1');
					$GLOBALS['db']->query($sql);
					clear_cache_files();
					make_json_result($a_id);
				}
				else if ($_REQUEST['act'] == 'edit_region_price') {
					check_authz_json('goods_manage');
					$a_id = intval($_POST['id']);
					$region_price = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_area_goods') . (' set region_price = \'' . $region_price . '\' where a_id = \'' . $a_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($region_price);
					}
				}
				else if ($_REQUEST['act'] == 'edit_region_number') {
					check_authz_json('goods_manage');
					$a_id = intval($_POST['id']);
					$region_number = floatval($_POST['val']);
					$sql = 'SELECT goods_id, region_number, region_id FROM ' . $ecs->table('warehouse_area_goods') . (' WHERE a_id = \'' . $a_id . '\' LIMIT 1');
					$area_goods = $db->getRow($sql);
					$goodsInfo = get_admin_goods_info($area_goods['goods_id'], array('model_inventory', 'model_attr'));

					if ($region_number != $area_goods['region_number']) {
						if ($area_goods['region_number'] < $region_number) {
							$number = $region_number - $area_goods['region_number'];
							$number = '+ ' . $number;
							$use_storage = 13;
						}
						else {
							$number = $area_goods['region_number'] - $region_number;
							$number = '- ' . $number;
							$use_storage = 8;
						}

						$logs_other = array('goods_id' => $area_goods['goods_id'], 'order_id' => 0, 'use_storage' => $use_storage, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $goodsInfo['model_inventory'], 'model_attr' => $goodsInfo['model_attr'], 'product_id' => 0, 'warehouse_id' => 0, 'area_id' => $area_goods['region_id'], 'add_time' => gmtime());
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
					}

					$sql = 'UPDATE ' . $ecs->table('warehouse_area_goods') . (' SET region_number = \'' . $region_number . '\' WHERE a_id = \'' . $a_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($region_number);
					}
				}
				else if ($_REQUEST['act'] == 'edit_region_promote_price') {
					check_authz_json('goods_manage');
					$a_id = intval($_POST['id']);
					$region_promote_price = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_area_goods') . (' set region_promote_price = \'' . $region_promote_price . '\' where a_id = \'' . $a_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($region_promote_price);
					}
				}
				else if ($_REQUEST['act'] == 'edit_warehouse_area_list') {
					check_authz_json('goods_manage');
					$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
					$key = isset($_REQUEST['key']) ? intval($_REQUEST['key']) : 0;
					$goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$ru_id = isset($_REQUEST['ru_id']) ? intval($_REQUEST['ru_id']) : 0;
					$type = isset($_REQUEST['type']) ? intval($_REQUEST['type']) : 1;

					if (0 < $id) {
						$area_list = get_warehouse_area_list($id, $type, $goods_id, $ru_id);
						$smarty->assign('area_list', $area_list);
						$smarty->assign('warehouse_id', $id);
						$smarty->assign('type', $type);
						$result['error'] = 0;
						$result['key'] = $key;
						$result['html'] = $smarty->fetch('library/warehouse_area_list.lbi');
					}
					else {
						$result['key'] = $key;
						$result['error'] = 1;
					}

					make_json_result($result);
				}
				else if ($_REQUEST['act'] == 'edit_region_give_integral') {
					check_authz_json('goods_manage');
					$a_id = intval($_POST['id']);
					$give_integral = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_area_goods') . (' set give_integral = \'' . $give_integral . '\' where a_id = \'' . $a_id . '\' ');
					$res = $db->query($sql);
					$other = array('a_id', 'user_id', 'region_price', 'region_promote_price');
					$goods = get_table_date('warehouse_area_goods', 'a_id=\'' . $a_id . '\'', $other);
					$goods['user_id'] = !empty($goods['user_id']) ? $goods['user_id'] : $adminru['ru_id'];

					if ($goods['region_promote_price']) {
						if ($goods['region_promote_price'] < $goods['region_price']) {
							$shop_price = $goods['region_promote_price'];
						}
						else {
							$shop_price = $goods['region_price'];
						}
					}
					else {
						$shop_price = $goods['region_price'];
					}

					$grade_rank = get_seller_grade_rank($goods['user_id']);
					$give = floor($shop_price * $grade_rank['give_integral']);

					if ($give < $give_integral) {
						make_json_error(sprintf($_LANG['goods_give_integral'], $give));
					}

					if ($res) {
						clear_cache_files();
						make_json_result($give_integral);
					}
				}
				else if ($_REQUEST['act'] == 'edit_region_rank_integral') {
					check_authz_json('goods_manage');
					$a_id = intval($_POST['id']);
					$rank_integral = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_area_goods') . (' set rank_integral = \'' . $rank_integral . '\' where a_id = \'' . $a_id . '\' ');
					$res = $db->query($sql);
					$other = array('a_id', 'user_id', 'region_price', 'region_promote_price');
					$goods = get_table_date('warehouse_area_goods', 'a_id=\'' . $a_id . '\'', $other);
					$goods['user_id'] = !empty($goods['user_id']) ? $goods['user_id'] : $adminru['ru_id'];

					if ($goods['region_promote_price']) {
						if ($goods['region_promote_price'] < $goods['region_price']) {
							$shop_price = $goods['region_promote_price'];
						}
						else {
							$shop_price = $goods['region_price'];
						}
					}
					else {
						$shop_price = $goods['region_price'];
					}

					$grade_rank = get_seller_grade_rank($goods['user_id']);
					$rank = floor($shop_price * $grade_rank['rank_integral']);

					if ($rank < $rank_integral) {
						make_json_error(sprintf($_LANG['goods_rank_integral'], $rank));
					}

					if ($res) {
						clear_cache_files();
						make_json_result($rank_integral);
					}
				}
				else if ($_REQUEST['act'] == 'edit_region_pay_integral') {
					check_authz_json('goods_manage');
					$a_id = intval($_POST['id']);
					$pay_integral = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_area_goods') . (' set pay_integral = \'' . $pay_integral . '\' where a_id = \'' . $a_id . '\' ');
					$res = $db->query($sql);
					$other = array('a_id', 'user_id', 'region_price', 'region_promote_price');
					$goods = get_table_date('warehouse_area_goods', 'a_id=\'' . $a_id . '\'', $other);
					$goods['user_id'] = !empty($goods['user_id']) ? $goods['user_id'] : $adminru['ru_id'];

					if ($goods['region_promote_price']) {
						if ($goods['region_promote_price'] < $goods['region_price']) {
							$shop_price = $goods['region_promote_price'];
						}
						else {
							$shop_price = $goods['region_price'];
						}
					}
					else {
						$shop_price = $goods['region_price'];
					}

					$grade_rank = get_seller_grade_rank($goods['user_id']);
					$pay = floor($shop_price * $grade_rank['pay_integral']);

					if ($pay < $pay_integral) {
						make_json_error(sprintf($_LANG['goods_pay_integral'], $pay));
					}

					if ($res) {
						clear_cache_files();
						make_json_result($pay_integral);
					}
				}
				else if ($_REQUEST['act'] == 'edit_region_sort') {
					check_authz_json('goods_manage');
					$a_id = intval($_POST['id']);
					$region_sort = floatval($_POST['val']);
					$sql = 'update ' . $ecs->table('warehouse_area_goods') . (' set region_sort = \'' . $region_sort . '\' where a_id = \'' . $a_id . '\' ');
					$res = $db->query($sql);

					if ($res) {
						clear_cache_files();
						make_json_result($region_sort);
					}
				}
				else if ($_REQUEST['act'] == 'add_area_price') {
					$smarty->assign('menu_select', array('action' => '02_cat_and_goods', 'current' => '02_goods_add'));
					$smarty->assign('ur_here', $_LANG['area_spec_price']);
					$smarty->assign('primary_cat', $_LANG['02_cat_and_goods']);
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$attr_id = !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
					$goods_attr_name = !empty($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '';
					$action_link = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id . '&extension_code=', 'text' => $_LANG['goods_info']);
					$goods_attr_id = get_goods_attr_nameId($goods_id, $attr_id, $goods_attr_name);
					$goods_date = array('goods_name');
					$goods_info = get_table_date('goods', 'goods_id = \'' . $goods_id . '\'', $goods_date);
					$attr_date = array('attr_name');
					$attr_info = get_table_date('attribute', 'attr_id = \'' . $attr_id . '\'', $attr_date);
					$warehouse_area_list = get_fine_warehouse_area_all(0, $goods_id, $goods_attr_id);
					$smarty->assign('goods_info', $goods_info);
					$smarty->assign('attr_info', $attr_info);
					$smarty->assign('goods_attr_name', $goods_attr_name);
					$smarty->assign('warehouse_area_list', $warehouse_area_list);
					$smarty->assign('goods_id', $goods_id);
					$smarty->assign('attr_id', $attr_id);
					$smarty->assign('goods_attr_id', $goods_attr_id);
					$smarty->assign('form_action', 'insert_area_price');
					$smarty->assign('action_link', $action_link);
					assign_query_info();
					$smarty->display('goods_area_price_info.dwt');
				}
				else if ($_REQUEST['act'] == 'insert_area_price') {
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$goods_attr_id = !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0;
					$area_name = isset($_REQUEST['area_name']) ? $_REQUEST['area_name'] : array();
					$attr_id = !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
					$goods_attr_name = !empty($_REQUEST['goods_attr_name']) ? $_REQUEST['goods_attr_name'] : '';
					get_warehouse_area_attr_price_insert($area_name, $goods_id, $goods_attr_id, 'warehouse_area_attr');
					$link[] = array('href' => 'javascript:history.back(-1)', 'text' => $_LANG['go_back']);
					sys_msg($_LANG['attradd_succed'], 1, $link);
				}
				else if ($_REQUEST['act'] == 'add_warehouse_price') {
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$attr_id = !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
					$goods_attr_name = !empty($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '';
					$action_link = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id . '&extension_code=', 'text' => $_LANG['goods_info']);
					$goods_attr_id = get_goods_attr_nameId($goods_id, $attr_id, $goods_attr_name);
					$goods_date = array('goods_name');
					$goods_info = get_table_date('goods', 'goods_id = \'' . $goods_id . '\'', $goods_date);
					$attr_date = array('attr_name');
					$attr_info = get_table_date('attribute', 'attr_id = \'' . $attr_id . '\'', $attr_date);
					$warehouse_area_list = get_fine_warehouse_all(0, $goods_id, $goods_attr_id);
					$smarty->assign('goods_info', $goods_info);
					$smarty->assign('attr_info', $attr_info);
					$smarty->assign('goods_attr_name', $goods_attr_name);
					$smarty->assign('warehouse_area_list', $warehouse_area_list);
					$smarty->assign('goods_id', $goods_id);
					$smarty->assign('attr_id', $attr_id);
					$smarty->assign('goods_attr_id', $goods_attr_id);
					$smarty->assign('form_action', 'insert_warehouse_price');
					$smarty->assign('action_link', $action_link);
					assign_query_info();
					make_json_result($smarty->fetch('goods_warehouse_price_info.dwt'));
				}
				else if ($_REQUEST['act'] == 'insert_warehouse_price') {
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$goods_attr_id = !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0;
					$warehouse_name = isset($_REQUEST['warehouse_name']) ? $_REQUEST['warehouse_name'] : array();
					$attr_id = !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
					$goods_attr_name = !empty($_REQUEST['goods_attr_name']) ? $_REQUEST['goods_attr_name'] : '';
					get_warehouse_area_attr_price_insert($warehouse_name, $goods_id, $goods_attr_id, 'warehouse_attr');
					$link[] = array('href' => 'javascript:history.back(-1)', 'text' => $_LANG['go_back']);
					sys_msg($_LANG['attradd_succed'], 1, $link);
				}
				else if ($_REQUEST['act'] == 'add_attr_img') {
					check_authz_json('goods_manage');
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$attr_id = !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
					$goods_attr_name = !empty($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '';
					$action_link = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id . '&extension_code=', 'text' => $_LANG['goods_info']);
					$goods_attr_id = get_goods_attr_nameId($goods_id, $attr_id, $goods_attr_name);
					$goods_date = array('goods_name');
					$goods_info = get_table_date('goods', 'goods_id = \'' . $goods_id . '\'', $goods_date);
					$goods_attr_date = array('attr_img_flie, attr_img_site, attr_checked, attr_gallery_flie');
					$goods_attr_info = get_table_date('goods_attr', 'goods_id = \'' . $goods_id . '\' and attr_id = \'' . $attr_id . '\' and goods_attr_id = \'' . $goods_attr_id . '\'', $goods_attr_date);
					$attr_date = array('attr_name');
					$attr_info = get_table_date('attribute', 'attr_id = \'' . $attr_id . '\'', $attr_date);
					$smarty->assign('goods_info', $goods_info);
					$smarty->assign('attr_info', $attr_info);
					$smarty->assign('goods_attr_info', $goods_attr_info);
					$smarty->assign('goods_attr_name', $goods_attr_name);
					$smarty->assign('goods_id', $goods_id);
					$smarty->assign('attr_id', $attr_id);
					$smarty->assign('goods_attr_id', $goods_attr_id);
					$smarty->assign('form_action', 'insert_attr_img');
					$smarty->assign('action_link', $action_link);
					make_json_result($smarty->fetch('goods_attr_img_info.dwt'));
				}
				else if ($_REQUEST['act'] == 'insert_attr_img') {
					admin_priv('goods_manage');
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$goods_attr_id = !empty($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0;
					$attr_id = !empty($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
					$goods_attr_name = !empty($_REQUEST['goods_attr_name']) ? $_REQUEST['goods_attr_name'] : '';
					$img_url = !empty($_REQUEST['img_url']) ? $_REQUEST['img_url'] : '';
					include_once ROOT_PATH . '/includes/cls_image.php';
					$image = new cls_image($_CFG['bgcolor']);
					$allow_file_types = '|GIF|JPG|JEPG|PNG|';
					$other['attr_img_flie'] = get_upload_pic('attr_img_flie');
					get_oss_add_file(array($other['attr_img_flie']));
					$goods_attr_date = array('attr_img_flie, attr_img_site');
					$goods_attr_info = get_table_date('goods_attr', 'goods_id = \'' . $goods_id . '\' and attr_id = \'' . $attr_id . '\' and goods_attr_id = \'' . $goods_attr_id . '\'', $goods_attr_date);

					if (empty($other['attr_img_flie'])) {
						$other['attr_img_flie'] = $goods_attr_info['attr_img_flie'];
					}

					$other['attr_img_site'] = !empty($_REQUEST['attr_img_site']) ? $_REQUEST['attr_img_site'] : '';
					$other['attr_checked'] = !empty($_REQUEST['attr_checked']) ? intval($_REQUEST['attr_checked']) : 0;
					$other['attr_gallery_flie'] = $img_url;
					$db->autoExecute($ecs->table('goods_attr'), $other, 'UPDATE', 'goods_attr_id = ' . $goods_attr_id . ' and attr_id = ' . $attr_id . ' and goods_id = ' . $goods_id);
					$link[0] = array('text' => '返回商品详情页', 'href' => 'goods.php?act=edit&goods_id=' . $goods_id . '&extension_code=&properties=1');
					sys_msg($_LANG['attradd_succed'], 0, $link);
				}
				else if ($_REQUEST['act'] == 'drop_attr_img') {
					$goods_id = isset($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$goods_attr_id = isset($_REQUEST['goods_attr_id']) ? intval($_REQUEST['goods_attr_id']) : 0;
					$attr_id = isset($_REQUEST['attr_id']) ? intval($_REQUEST['attr_id']) : 0;
					$goods_attr_name = isset($_REQUEST['goods_attr_name']) ? trim($_REQUEST['goods_attr_name']) : '';
					$sql = 'select attr_img_flie from ' . $ecs->table('goods_attr') . (' where goods_attr_id = \'' . $goods_attr_id . '\'');
					$attr_img_flie = $db->getOne($sql);
					get_oss_del_file(array($attr_img_flie));
					@unlink(ROOT_PATH . $attr_img_flie);
					$other['attr_img_flie'] = '';
					$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_attr'), $other, 'UPDATE', 'goods_attr_id = \'' . $goods_attr_id . '\'');
					$link[0] = array('text' => '返回商品详情页', 'href' => 'goods.php?act=edit&goods_id=' . $goods_id . '&extension_code=');
					sys_msg($_LANG['drop_attr_img_success'], 0, $link);
				}
				else if ($_REQUEST['act'] == 'choose_attrImg') {
					check_authz_json('goods_manage');
					$goods_id = empty($_REQUEST['goods_id']) ? 0 : intval($_REQUEST['goods_id']);
					$goods_attr_id = empty($_REQUEST['goods_attr_id']) ? 0 : intval($_REQUEST['goods_attr_id']);
					$on_img_id = isset($_REQUEST['img_id']) ? intval($_REQUEST['img_id']) : 0;
					$sql = 'SELECT attr_gallery_flie FROM ' . $GLOBALS['ecs']->table('goods_attr') . (' WHERE goods_attr_id = \'' . $goods_attr_id . '\' AND goods_id = \'' . $goods_id . '\'');
					$attr_gallery_flie = $GLOBALS['db']->getOne($sql);
					$sql = 'SELECT img_id, thumb_url, img_url FROM ' . $GLOBALS['ecs']->table('goods_gallery') . (' WHERE goods_id = \'' . $goods_id . '\'');
					$img_list = $GLOBALS['db']->getAll($sql);
					$result = '<ul>';

					foreach ($img_list as $idx => $row) {
						if ($attr_gallery_flie == $row['img_url']) {
							$result .= '<li id="gallery_' . $row['img_id'] . '" onClick="gallery_on(this,' . $row['img_id'] . ',' . $goods_id . ',' . $goods_attr_id . ')" class="on"><img src="../' . $row['thumb_url'] . '" width="120" /><i><img src="images/gallery_yes.png" width="30" height="30"></i></li>';
						}
						else {
							$result .= '<li id="gallery_' . $row['img_id'] . '" onClick="gallery_on(this,' . $row['img_id'] . ',' . $goods_id . ',' . $goods_attr_id . ')"><img src="../' . $row['thumb_url'] . '" width="120" /><i><img src="images/gallery_yes.png" width="30" height="30"></i></li>';
						}
					}

					$result .= '</ul>';
					clear_cache_files();
					make_json_result($result);
				}
				else if ($_REQUEST['act'] == 'insert_gallery_attr') {
					check_authz_json('goods_manage');
					$goods_id = intval($_REQUEST['goods_id']);
					$goods_attr_id = intval($_REQUEST['goods_attr_id']);
					$gallery_id = intval($_REQUEST['gallery_id']);

					if (!empty($gallery_id)) {
						$sql = 'SELECT img_id, img_url FROM ' . $ecs->table('goods_gallery') . ('WHERE img_id=\'' . $gallery_id . '\'');
						$img = $db->getRow($sql);
						$result = $img['img_id'];
						$sql = 'UPDATE ' . $ecs->table('goods_attr') . ' SET attr_gallery_flie = \'' . $img['img_url'] . ('\' WHERE goods_attr_id = \'' . $goods_attr_id . '\' AND goods_id = \'' . $goods_id . '\'');
						$db->query($sql);
					}
					else {
						make_json_error('此相册图片不存在!');
					}

					make_json_result($result, '', array('img_url' => $img['img_url']));
				}
				else if ($_REQUEST['act'] == 'get_goods_list') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$filters = $json->decode($_GET['JSON']);
					$arr = get_goods_list($filters);
					$opt = array();

					foreach ($arr as $key => $val) {
						$opt[] = array('value' => $val['goods_id'], 'text' => $val['goods_name'], 'data' => $val['shop_price']);
					}

					make_json_result($opt);
				}
				else if ($_REQUEST['act'] == 'get_area_list') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$filters = $json->decode($_GET['JSON']);
					$arr = get_areaRegion_info_list($filters->ra_id);
					$opt = array();

					foreach ($arr as $key => $val) {
						$opt[] = array('value' => $val['region_id'], 'text' => $val['region_name'], 'data' => 0);
					}

					make_json_result($opt);
				}
				else if ($_REQUEST['act'] == 'add_link_goods') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					check_authz_json('goods_manage');
					$linked_array = $json->decode($_GET['add_ids']);
					$linked_goods = $json->decode($_GET['JSON']);
					$goods_id = $linked_goods[0];
					$is_double = $linked_goods[1] == true ? 0 : 1;

					foreach ($linked_array as $val) {
						if ($is_double) {
							$sql = 'INSERT INTO ' . $ecs->table('link_goods') . ' (goods_id, link_goods_id, is_double, admin_id) ' . ('VALUES (\'' . $val . '\', \'' . $goods_id . '\', \'' . $is_double . '\', \'' . $_SESSION['admin_id'] . '\')');
							$db->query($sql, 'SILENT');
						}

						$sql = 'INSERT INTO ' . $ecs->table('link_goods') . ' (goods_id, link_goods_id, is_double, admin_id) ' . ('VALUES (\'' . $goods_id . '\', \'' . $val . '\', \'' . $is_double . '\', \'' . $_SESSION['admin_id'] . '\')');
						$db->query($sql, 'SILENT');
					}

					$linked_goods = get_linked_goods($goods_id);
					$options = array();

					foreach ($linked_goods as $val) {
						$options[] = array('value' => $val['goods_id'], 'text' => $val['goods_name'], 'data' => '');
					}

					clear_cache_files();
					make_json_result($options);
				}
				else if ($_REQUEST['act'] == 'drop_link_goods') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					check_authz_json('goods_manage');
					$drop_goods = $json->decode($_GET['drop_ids']);
					$drop_goods_ids = db_create_in($drop_goods);
					$linked_goods = $json->decode($_GET['JSON']);
					$goods_id = $linked_goods[0];
					$is_signle = $linked_goods[1];

					if (!$is_signle) {
						$sql = 'DELETE FROM ' . $ecs->table('link_goods') . (' WHERE link_goods_id = \'' . $goods_id . '\' AND goods_id ') . $drop_goods_ids;
					}
					else {
						$sql = 'UPDATE ' . $ecs->table('link_goods') . ' SET is_double = 0 ' . (' WHERE link_goods_id = \'' . $goods_id . '\' AND goods_id ') . $drop_goods_ids;
					}

					if ($goods_id == 0) {
						$sql .= ' AND admin_id = \'' . $_SESSION['admin_id'] . '\'';
					}

					$db->query($sql);
					$sql = 'DELETE FROM ' . $ecs->table('link_goods') . (' WHERE goods_id = \'' . $goods_id . '\' AND link_goods_id ') . $drop_goods_ids;

					if ($goods_id == 0) {
						$sql .= ' AND admin_id = \'' . $_SESSION['admin_id'] . '\'';
					}

					$db->query($sql);
					$linked_goods = get_linked_goods($goods_id);
					$options = array();

					foreach ($linked_goods as $val) {
						$options[] = array('value' => $val['goods_id'], 'text' => $val['goods_name'], 'data' => '');
					}

					clear_cache_files();
					make_json_result($options);
				}
				else if ($_REQUEST['act'] == 'add_group_goods') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					check_authz_json('goods_manage');
					$fittings = $json->decode($_GET['add_ids']);
					$arguments = $json->decode($_GET['JSON']);
					$goods_id = $arguments[0];
					$price = $arguments[1];
					$group_id = $arguments[2];
					$sql = 'select count(*) from ' . $ecs->table('group_goods') . (' where parent_id = \'' . $goods_id . '\' and group_id = \'' . $group_id . '\' and admin_id = \'') . $_SESSION['admin_id'] . '\'';
					$groupCount = $db->getOne($sql);
					$message = '';

					if ($groupCount < 1000) {
						foreach ($fittings as $val) {
							$sql = 'SELECT id FROM ' . $ecs->table('group_goods') . (' WHERE parent_id = \'' . $goods_id . '\' AND goods_id = \'' . $val . '\' AND group_id = \'' . $group_id . '\'');

							if (!$db->getOne($sql)) {
								$sql = 'INSERT INTO ' . $ecs->table('group_goods') . ' (parent_id, goods_id, goods_price, admin_id, group_id) ' . ('VALUES (\'' . $goods_id . '\', \'' . $val . '\', \'' . $price . '\', \'' . $_SESSION['admin_id'] . '\', \'' . $group_id . '\')');
								$db->query($sql, 'SILENT');
							}
						}

						$error = 0;
					}
					else {
						$error = 1;
						$message = '一组配件只能添加五个商品，如需添加则删除该组其它配件商品';
					}

					$arr = get_group_goods($goods_id);
					$opt = array();

					foreach ($arr as $val) {
						$opt[] = array('value' => $val['goods_id'], 'text' => '[' . $val['group_name'] . ']' . $val['goods_name'], 'data' => '');
					}

					clear_cache_files();
					make_json_result($opt, $message, array('error' => $error));
				}
				else if ($_REQUEST['act'] == 'drop_group_goods') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					check_authz_json('goods_manage');
					$fittings = $json->decode($_GET['drop_ids']);
					$arguments = $json->decode($_GET['JSON']);
					$goods_id = $arguments[0];
					$price = $arguments[1];
					$sql = 'DELETE FROM ' . $ecs->table('group_goods') . (' WHERE parent_id=\'' . $goods_id . '\' AND ') . db_create_in($fittings, 'goods_id');

					if ($goods_id == 0) {
						$sql .= ' AND admin_id = \'' . $_SESSION['admin_id'] . '\'';
					}

					$db->query($sql);
					$arr = get_group_goods($goods_id);
					$opt = array();

					foreach ($arr as $val) {
						$opt[] = array('value' => $val['goods_id'], 'text' => '[' . $val['group_name'] . ']' . $val['goods_name'], 'data' => '');
					}

					clear_cache_files();
					make_json_result($opt);
				}
				else if ($_REQUEST['act'] == 'add_area_goods') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					check_authz_json('goods_manage');
					$fittings = $json->decode($_GET['add_ids']);
					$arguments = $json->decode($_GET['JSON']);
					$goods_id = $arguments[0];
					$region_id = $arguments[1];
					$sql = 'SELECT user_id FROM ' . $GLOBALS['ecs']->table('goods') . (' WHERE goods_id = \'' . $goods_id . '\'');
					$ru_id = $GLOBALS['db']->getOne($sql);

					foreach ($fittings as $val) {
						$sql = 'INSERT INTO ' . $ecs->table('link_area_goods') . ' (goods_id, region_id, ru_id) ' . ('VALUES (\'' . $goods_id . '\', \'' . $val . '\', \'' . $ru_id . '\')');
						$db->query($sql, 'SILENT');
					}

					$arr = get_area_goods($goods_id);
					$opt = array();

					foreach ($arr as $val) {
						$opt[] = array('value' => $val['region_id'], 'text' => $val['region_name'], 'data' => 0);
					}

					clear_cache_files();
					make_json_result($opt);
				}
				else if ($_REQUEST['act'] == 'drop_area_goods') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					check_authz_json('goods_manage');
					$drop_goods = $json->decode($_GET['drop_ids']);
					$drop_goods_ids = db_create_in($drop_goods);
					$arguments = $json->decode($_GET['JSON']);
					$goods_id = $arguments[0];
					$region_id = $arguments[1];
					$sql = 'DELETE FROM ' . $ecs->table('link_area_goods') . ' WHERE region_id' . $drop_goods_ids . (' and goods_id = \'' . $goods_id . '\'');

					if ($goods_id == 0) {
						$adminru = get_admin_ru_id();
						$ru_id = $adminru['ru_id'];
						$sql .= ' AND ru_id = \'' . $ru_id . '\'';
					}

					$db->query($sql);
					$arr = get_area_goods($goods_id);
					$opt = array();

					foreach ($arr as $val) {
						$opt[] = array('value' => $val['region_id'], 'text' => $val['region_name'], 'data' => 0);
					}

					clear_cache_files();
					make_json_result($opt);
				}
				else if ($_REQUEST['act'] == 'get_article_list') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$filters = (array) $json->decode(json_str_iconv($_GET['JSON']));
					$where = ' WHERE cat_id > 0 ';

					if (!empty($filters['title'])) {
						$keyword = trim($filters['title']);
						$where .= ' AND title LIKE \'%' . mysql_like_quote($keyword) . '%\' ';
					}

					$sql = 'SELECT article_id, title FROM ' . $ecs->table('article') . $where . 'ORDER BY article_id DESC LIMIT 50';
					$res = $db->query($sql);
					$arr = array();

					while ($row = $db->fetchRow($res)) {
						$arr[] = array('value' => $row['article_id'], 'text' => $row['title'], 'data' => '');
					}

					make_json_result($arr);
				}
				else if ($_REQUEST['act'] == 'add_goods_article') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					check_authz_json('goods_manage');
					$articles = $json->decode($_GET['add_ids']);
					$arguments = $json->decode($_GET['JSON']);
					$goods_id = $arguments[0];

					foreach ($articles as $val) {
						$sql = 'INSERT INTO ' . $ecs->table('goods_article') . ' (goods_id, article_id, admin_id) ' . ('VALUES (\'' . $goods_id . '\', \'' . $val . '\', \'' . $_SESSION['admin_id'] . '\')');
						$db->query($sql);
					}

					$arr = get_goods_articles($goods_id);
					$opt = array();

					foreach ($arr as $val) {
						$opt[] = array('value' => $val['article_id'], 'text' => $val['title'], 'data' => '');
					}

					clear_cache_files();
					make_json_result($opt);
				}
				else if ($_REQUEST['act'] == 'drop_goods_article') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					check_authz_json('goods_manage');
					$articles = $json->decode($_GET['drop_ids']);
					$arguments = $json->decode($_GET['JSON']);
					$goods_id = $arguments[0];
					$sql = 'DELETE FROM ' . $ecs->table('goods_article') . ' WHERE ' . db_create_in($articles, 'article_id') . (' AND goods_id = \'' . $goods_id . '\'');
					$db->query($sql);
					$arr = get_goods_articles($goods_id);
					$opt = array();

					foreach ($arr as $val) {
						$opt[] = array('value' => $val['article_id'], 'text' => $val['title'], 'data' => '');
					}

					clear_cache_files();
					make_json_result($opt);
				}
				else if ($_REQUEST['act'] == 'product_list') {
					admin_priv('goods_manage');
					$smarty->assign('primary_cat', $_LANG['02_cat_and_goods']);
					$smarty->assign('menu_select', array('action' => '02_cat_and_goods', 'current' => '01_goods_list'));

					if (empty($_GET['goods_id'])) {
						$link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['cannot_found_goods']);
						sys_msg($_LANG['cannot_found_goods'], 1, $link);
					}
					else {
						$goods_id = intval($_GET['goods_id']);
					}

					$sql = 'SELECT goods_sn, goods_name, goods_type, shop_price, model_attr FROM ' . $ecs->table('goods') . (' WHERE goods_id = \'' . $goods_id . '\'');
					$goods = $db->getRow($sql);

					if (empty($goods)) {
						$link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']);
						sys_msg($_LANG['cannot_found_goods'], 1, $link);
					}

					$smarty->assign('sn', sprintf($_LANG['good_goods_sn'], $goods['goods_sn']));
					$smarty->assign('price', sprintf($_LANG['good_shop_price'], $goods['shop_price']));
					$smarty->assign('goods_name', sprintf($_LANG['products_title'], $goods['goods_name']));
					$smarty->assign('goods_sn', sprintf($_LANG['products_title_2'], $goods['goods_sn']));
					$smarty->assign('model_attr', $goods['model_attr']);
					$attribute = get_goods_specifications_list($goods_id);

					if (empty($attribute)) {
						$link[] = array('href' => 'goods.php?act=edit&goods_id=' . $goods_id, 'text' => $_LANG['edit_goods']);
						sys_msg($_LANG['not_exist_goods_attr'], 1, $link);
					}

					foreach ($attribute as $attribute_value) {
						$_attribute[$attribute_value['attr_id']]['attr_values'][] = $attribute_value['attr_value'];
						$_attribute[$attribute_value['attr_id']]['attr_id'] = $attribute_value['attr_id'];
						$_attribute[$attribute_value['attr_id']]['attr_name'] = $attribute_value['attr_name'];
					}

					$attribute_count = count($_attribute);
					$smarty->assign('attribute_count', $attribute_count);
					$smarty->assign('attribute_count_5', $attribute_count + 5);
					$smarty->assign('attribute', $_attribute);
					$smarty->assign('product_sn', $goods['goods_sn'] . '_');
					$smarty->assign('product_number', $_CFG['default_storage']);
					$product = product_list($goods_id, '');
					$smarty->assign('ur_here', $_LANG['18_product_list']);
					$smarty->assign('action_link', array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']));
					$smarty->assign('product_list', $product['product']);
					$smarty->assign('product_null', empty($product['product']) ? 0 : 1);
					$smarty->assign('use_storage', empty($_CFG['use_storage']) ? 0 : 1);
					$smarty->assign('goods_id', $goods_id);
					$smarty->assign('filter', $product['filter']);
					$smarty->assign('full_page', 1);
					$smarty->assign('product_php', 'goods.php');
					assign_query_info();
					$smarty->display('product_info.dwt');
				}
				else if ($_REQUEST['act'] == 'product_query') {
					if (empty($_REQUEST['goods_id'])) {
						make_json_error($_LANG['sys']['wrong'] . $_LANG['cannot_found_goods']);
					}
					else {
						$goods_id = intval($_REQUEST['goods_id']);
					}

					$sql = 'SELECT goods_sn, goods_name, goods_type, shop_price FROM ' . $ecs->table('goods') . (' WHERE goods_id = \'' . $goods_id . '\'');
					$goods = $db->getRow($sql);

					if (empty($goods)) {
						make_json_error($_LANG['sys']['wrong'] . $_LANG['cannot_found_goods']);
					}

					$smarty->assign('sn', sprintf($_LANG['good_goods_sn'], $goods['goods_sn']));
					$smarty->assign('price', sprintf($_LANG['good_shop_price'], $goods['shop_price']));
					$smarty->assign('goods_name', sprintf($_LANG['products_title'], $goods['goods_name']));
					$smarty->assign('goods_sn', sprintf($_LANG['products_title_2'], $goods['goods_sn']));
					$attribute = get_goods_specifications_list($goods_id);

					if (empty($attribute)) {
						make_json_error($_LANG['sys']['wrong'] . $_LANG['cannot_found_goods']);
					}

					foreach ($attribute as $attribute_value) {
						$_attribute[$attribute_value['attr_id']]['attr_values'][] = $attribute_value['attr_value'];
						$_attribute[$attribute_value['attr_id']]['attr_id'] = $attribute_value['attr_id'];
						$_attribute[$attribute_value['attr_id']]['attr_name'] = $attribute_value['attr_name'];
					}

					$attribute_count = count($_attribute);
					$smarty->assign('attribute_count', $attribute_count);
					$smarty->assign('attribute', $_attribute);
					$smarty->assign('attribute_count_3', $attribute_count + 10);
					$smarty->assign('product_sn', $goods['goods_sn'] . '_');
					$smarty->assign('product_number', $_CFG['default_storage']);
					$product = product_list($goods_id, '');
					$smarty->assign('ur_here', $_LANG['18_product_list']);
					$smarty->assign('action_link', array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']));
					$smarty->assign('product_list', $product['product']);
					$smarty->assign('use_storage', empty($_CFG['use_storage']) ? 0 : 1);
					$smarty->assign('goods_id', $goods_id);
					$smarty->assign('filter', $product['filter']);
					$smarty->assign('product_php', 'goods.php');
					$sort_flag = sort_flag($product['filter']);
					$smarty->assign($sort_flag['tag'], $sort_flag['img']);
					make_json_result($smarty->fetch('product_info.dwt'), '', array('filter' => $product['filter'], 'page_count' => $product['page_count']));
				}
				else if ($_REQUEST['act'] == 'product_remove') {
					check_authz_json('remove_back');
					$id_val = $_REQUEST['id'];
					$id_val = explode(',', $id_val);
					$product_id = intval($id_val[0]);
					$warehouse_id = intval($id_val[1]);

					if (empty($product_id)) {
						make_json_error($_LANG['product_id_null']);
					}
					else {
						$product_id = intval($product_id);
					}

					$product = get_product_info($product_id, 'product_number, goods_id');
					$sql = 'DELETE FROM ' . $ecs->table('products') . (' WHERE product_id = \'' . $product_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						$url = 'goods.php?act=product_query&' . str_replace('act=product_remove', '', $_SERVER['QUERY_STRING']);
						ecs_header('Location: ' . $url . "\n");
						exit();
					}
				}
				else if ($_REQUEST['act'] == 'edit_product_sn') {
					check_authz_json('goods_manage');
					$product_id = intval($_REQUEST['id']);
					$product_sn = json_str_iconv(trim($_POST['val']));
					$product_sn = $_LANG['n_a'] == $product_sn ? '' : $product_sn;

					if (check_product_sn_exist($product_sn, $product_id, $adminru['ru_id'])) {
						make_json_error($_LANG['sys']['wrong'] . $_LANG['exist_same_product_sn']);
					}

					$changelog = !empty($_REQUEST['changelog']) ? intval($_REQUEST['changelog']) : 0;

					if ($changelog == 1) {
						$table = 'products_changelog';
					}
					else if ($goods_model == 1) {
						$table = 'products_warehouse';
					}
					else if ($goods_model == 2) {
						$table = 'products_area';
					}
					else {
						$table = 'products';
					}

					$sql = 'UPDATE ' . $ecs->table($table) . (' SET product_sn = \'' . $product_sn . '\' WHERE product_id = \'' . $product_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($product_sn);
					}
				}
				else if ($_REQUEST['act'] == 'edit_product_bar_code') {
					check_authz_json('goods_manage');
					$product_id = intval($_REQUEST['id']);
					$bar_code = json_str_iconv(trim($_POST['val']));
					$bar_code = $_LANG['n_a'] == $bar_code ? '' : $bar_code;
					$goods_model = isset($_REQUEST['goods_model']) ? intval($_REQUEST['goods_model']) : 0;

					if (!empty($bar_code)) {
						if (check_product_bar_code_exist($bar_code, $product_id, $adminru['ru_id'], $goods_model)) {
							make_json_error($_LANG['sys']['wrong'] . $_LANG['exist_same_bar_code']);
						}

						$changelog = !empty($_REQUEST['changelog']) ? intval($_REQUEST['changelog']) : 0;

						if ($changelog == 1) {
							$table = 'products_changelog';
						}
						else if ($goods_model == 1) {
							$table = 'products_warehouse';
						}
						else if ($goods_model == 2) {
							$table = 'products_area';
						}
						else {
							$table = 'products';
						}

						$sql = 'UPDATE ' . $ecs->table($table) . (' SET bar_code = \'' . $bar_code . '\' WHERE product_id = \'' . $product_id . '\'');
						$result = $db->query($sql);

						if ($result) {
							clear_cache_files();
							make_json_result($bar_code);
						}
					}
				}
				else if ($_REQUEST['act'] == 'edit_attr_price') {
					check_authz_json('goods_manage');
					$goods_attr_id = intval($_REQUEST['id']);
					$attr_price = floatval($_POST['val']);
					$sql = 'UPDATE ' . $ecs->table('goods_attr') . (' SET attr_price = \'' . $attr_price . '\' WHERE goods_attr_id = \'' . $goods_attr_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($attr_price);
					}
				}
				else if ($_REQUEST['act'] == 'edit_bar_code') {
					check_authz_json('goods_manage');
					$product_id = intval($_REQUEST['id']);
					$bar_code = json_str_iconv(trim($_POST['val']));

					if (check_product_sn_exist($bar_code, $product_id, $adminru['ru_id'], 1)) {
						make_json_error($_LANG['sys']['wrong'] . $_LANG['exist_same_bar_code']);
					}

					$sql = 'UPDATE ' . $ecs->table('products') . (' SET bar_code = \'' . $bar_code . '\' WHERE product_id = \'' . $product_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($bar_code);
					}
				}
				else if ($_REQUEST['act'] == 'edit_product_number') {
					check_authz_json('goods_manage');
					$product_id = intval($_POST['id']);
					$product_number = intval($_POST['val']);
					$changelog = !empty($_REQUEST['changelog']) ? intval($_REQUEST['changelog']) : 0;
					$product = get_product_info($product_id, 'product_number, goods_id');
					if ($product['product_number'] != $product_number && $changelog == 0) {
						if ($product_number < $product['product_number']) {
							$number = $product['product_number'] - $product_number;
							$number = '- ' . $number;
							$log_use_storage = 10;
						}
						else {
							$number = $product_number - $product['product_number'];
							$number = '+ ' . $number;
							$log_use_storage = 11;
						}

						$goods = get_admin_goods_info($product['goods_id'], array('goods_number', 'model_inventory', 'model_attr'));
						$logs_other = array('goods_id' => $product['goods_id'], 'order_id' => 0, 'use_storage' => $log_use_storage, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $goods['model_inventory'], 'model_attr' => $goods['model_attr'], 'product_id' => $product_id, 'warehouse_id' => 0, 'area_id' => 0, 'add_time' => gmtime());
						$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
					}

					if ($changelog == 1) {
						$table = 'products_changelog';
					}
					else if ($goods_model == 1) {
						$table = 'products_warehouse';
					}
					else if ($goods_model == 2) {
						$table = 'products_area';
					}
					else {
						$table = 'products';
					}

					$sql = 'UPDATE ' . $ecs->table($table) . (' SET product_number = \'' . $product_number . '\' WHERE product_id = \'' . $product_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($product_number);
					}
				}
				else if ($_REQUEST['act'] == 'edit_product_warn_number') {
					check_authz_json('goods_manage');
					$product_id = intval($_POST['id']);
					$product_warn_number = intval($_POST['val']);
					$goods_model = isset($_REQUEST['goods_model']) ? intval($_REQUEST['goods_model']) : 0;
					$changelog = !empty($_REQUEST['changelog']) ? intval($_REQUEST['changelog']) : 0;

					if ($changelog == 1) {
						$table = 'products_changelog';
					}
					else if ($goods_model == 1) {
						$table = 'products_warehouse';
					}
					else if ($goods_model == 2) {
						$table = 'products_area';
					}
					else {
						$table = 'products';
					}

					$sql = 'UPDATE ' . $ecs->table($table) . (' SET product_warn_number = \'' . $product_warn_number . '\' WHERE product_id = \'' . $product_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($product_warn_number);
					}
				}
				else if ($_REQUEST['act'] == 'edit_product_market_price') {
					check_authz_json('goods_manage');
					$product_id = intval($_REQUEST['id']);
					$market_price = floatval($_POST['val']);
					$goods_model = isset($_REQUEST['goods_model']) ? intval($_REQUEST['goods_model']) : 0;
					$changelog = !empty($_REQUEST['changelog']) ? intval($_REQUEST['changelog']) : 0;

					if ($changelog == 1) {
						$table = 'products_changelog';
					}
					else if ($goods_model == 1) {
						$table = 'products_warehouse';
					}
					else if ($goods_model == 2) {
						$table = 'products_area';
					}
					else {
						$table = 'products';
					}

					$sql = 'UPDATE ' . $ecs->table($table) . (' SET product_market_price = \'' . $market_price . '\' WHERE product_id = \'' . $product_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($market_price);
					}
				}
				else if ($_REQUEST['act'] == 'edit_product_price') {
					check_authz_json('goods_manage');
					$product_id = intval($_POST['id']);
					$product_price = floatval($_POST['val']);
					$goods_model = isset($_REQUEST['goods_model']) ? intval($_REQUEST['goods_model']) : 0;
					$changelog = !empty($_REQUEST['changelog']) ? intval($_REQUEST['changelog']) : 0;

					if ($changelog == 1) {
						$table = 'products_changelog';
					}
					else if ($goods_model == 1) {
						$table = 'products_warehouse';
					}
					else if ($goods_model == 2) {
						$table = 'products_area';
					}
					else {
						$table = 'products';
					}

					if ($GLOBALS['_CFG']['goods_attr_price'] == 1 && $changelog == 0) {
						$sql = 'SELECT goods_id FROM ' . $ecs->table($table) . (' WHERE product_id = \'' . $product_id . '\'');
						$goods_id = $db->getOne($sql, true);
						$goods_other = array('product_table' => $table, 'product_price' => $product_price);
						$db->autoExecute($ecs->table('goods'), $goods_other, 'UPDATE', 'goods_id = \'' . $goods_id . '\' AND product_id = \'' . $product_id . '\' AND product_table = \'' . $table . '\'');
					}

					$sql = 'UPDATE ' . $ecs->table($table) . (' SET product_price = \'' . $product_price . '\' WHERE product_id = \'' . $product_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($product_price);
					}
				}
				else if ($_REQUEST['act'] == 'edit_product_promote_price') {
					check_authz_json('goods_manage');
					$product_id = intval($_REQUEST['id']);
					$promote_price = floatval($_POST['val']);
					$goods_model = isset($_REQUEST['goods_model']) ? intval($_REQUEST['goods_model']) : 0;
					$changelog = !empty($_REQUEST['changelog']) ? intval($_REQUEST['changelog']) : 0;

					if ($changelog == 1) {
						$table = 'products_changelog';
					}
					else if ($goods_model == 1) {
						$table = 'products_warehouse';
					}
					else if ($goods_model == 2) {
						$table = 'products_area';
					}
					else {
						$table = 'products';
					}

					if ($GLOBALS['_CFG']['goods_attr_price'] == 1 && $changelog == 0) {
						$sql = 'SELECT goods_id FROM ' . $ecs->table($table) . (' WHERE product_id = \'' . $product_id . '\'');
						$goods_id = $db->getOne($sql, true);
						$goods_other = array('product_table' => $table, 'product_promote_price' => $promote_price);
						$db->autoExecute($ecs->table('goods'), $goods_other, 'UPDATE', 'goods_id = \'' . $goods_id . '\' AND product_id = \'' . $product_id . '\' AND product_table = \'' . $table . '\'');
					}

					$sql = 'UPDATE ' . $ecs->table($table) . (' SET product_promote_price = \'' . $promote_price . '\' WHERE product_id = \'' . $product_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($promote_price);
					}
				}
				else if ($_REQUEST['act'] == 'product_add_execute') {
					admin_priv('goods_manage');
					$product['goods_id'] = intval($_POST['goods_id']);
					$product['attr'] = $_POST['attr'];
					$product['product_sn'] = $_POST['product_sn'];
					$product['bar_code'] = $_POST['bar_code'];
					$product['product_price'] = $_POST['product_price'];
					$product['product_number'] = $_POST['product_number'];

					if (empty($product['goods_id'])) {
						sys_msg($_LANG['sys']['wrong'] . $_LANG['cannot_found_goods'], 1, array(), false);
					}

					$insert = true;

					if (0 < product_number_count($product['goods_id'])) {
						$insert = false;
					}

					$sql = 'SELECT goods_sn, goods_name, goods_type, shop_price, model_inventory, model_attr FROM ' . $ecs->table('goods') . ' WHERE goods_id = \'' . $product['goods_id'] . '\'';
					$goods = $db->getRow($sql);

					if (empty($goods)) {
						sys_msg($_LANG['sys']['wrong'] . $_LANG['cannot_found_goods'], 1, array(), false);
					}

					foreach ($product['product_sn'] as $key => $value) {
						$product['product_number'][$key] = empty($product['product_number'][$key]) ? (empty($_CFG['use_storage']) ? 0 : $_CFG['default_storage']) : trim($product['product_number'][$key]);

						foreach ($product['attr'] as $attr_key => $attr_value) {
							if (empty($attr_value[$key])) {
								continue 2;
							}

							$is_spec_list[$attr_key] = 'true';
							$value_price_list[$attr_key] = $attr_value[$key] . chr(9) . '';
							$id_list[$attr_key] = $attr_key;
						}

						$goods_attr_id = handle_goods_attr($product['goods_id'], $id_list, $is_spec_list, $value_price_list);
						$goods_attr = sort_goods_attr_id_array($goods_attr_id);
						$goods_attr = implode('|', $goods_attr['sort']);

						if (check_goods_attr_exist($goods_attr, $product['goods_id'])) {
							continue;
						}

						if (!empty($value)) {
							if (check_goods_sn_exist($value)) {
								continue;
							}

							if (check_product_sn_exist($value)) {
								continue;
							}
						}

						$sql = 'INSERT INTO ' . $GLOBALS['ecs']->table('products') . ' (goods_id, goods_attr, product_sn, bar_code, product_price, product_number)  VALUES (\'' . $product['goods_id'] . ('\', \'' . $goods_attr . '\', \'' . $value . '\', \'') . $product['bar_code'][$key] . '\', \'' . $product['product_price'][$key] . '\', \'' . $product['product_number'][$key] . '\')';

						if (!$GLOBALS['db']->query($sql)) {
							continue;
						}

						$number = '+ ' . $product['product_number'][$key];

						if ($product['product_number'][$key]) {
							$logs_other = array('goods_id' => $product['goods_id'], 'order_id' => 0, 'use_storage' => 9, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $goods['model_inventory'], 'model_attr' => $goods['model_attr'], 'product_id' => $GLOBALS['db']->insert_id(), 'warehouse_id' => 0, 'area_id' => 0, 'add_time' => gmtime());
							$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
						}

						if (empty($value)) {
							$sql = 'UPDATE ' . $GLOBALS['ecs']->table('products') . "\r\n                    SET product_sn = '" . $goods['goods_sn'] . 'g_p' . $GLOBALS['db']->insert_id() . "'\r\n                    WHERE product_id = '" . $GLOBALS['db']->insert_id() . '\'';
							$GLOBALS['db']->query($sql);
						}

						$product_count = product_number_count($product['goods_id']);
					}

					clear_cache_files();

					if ($insert) {
						$link[] = array('href' => 'goods.php?act=add', 'text' => $_LANG['02_goods_add']);
						$link[] = array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list']);
						$link[] = array('href' => 'goods.php?act=product_list&goods_id=' . $product['goods_id'], 'text' => $_LANG['18_product_list']);
					}
					else {
						$link[] = array('href' => 'goods.php?act=list&uselastfilter=1', 'text' => $_LANG['01_goods_list']);
						$link[] = array('href' => 'goods.php?act=edit&goods_id=' . $product['goods_id'], 'text' => $_LANG['edit_goods']);
						$link[] = array('href' => 'goods.php?act=product_list&goods_id=' . $product['goods_id'], 'text' => $_LANG['18_product_list']);
					}

					sys_msg($_LANG['save_products'], 0, $link);
				}
				else if ($_REQUEST['act'] == 'batch_product') {
					$link[] = array('href' => 'goods.php?act=product_list&goods_id=' . $_POST['goods_id'], 'text' => $_LANG['item_list']);

					if ($_POST['type'] == 'drop') {
						admin_priv('remove_back');
						$product_id = !empty($_POST['checkboxes']) ? join(',', $_POST['checkboxes']) : 0;
						$product_bound = db_create_in($product_id);
						$sum = 0;
						$goods_id = 0;
						$sql = 'SELECT product_id, goods_id, product_number FROM  ' . $GLOBALS['ecs']->table('products') . (' WHERE product_id ' . $product_bound);
						$product_array = $GLOBALS['db']->getAll($sql);

						if (!empty($product_array)) {
							foreach ($product_array as $value) {
								$sum += $value['product_number'];
							}

							$goods_id = $product_array[0]['goods_id'];
							$sql = 'DELETE FROM ' . $ecs->table('products') . (' WHERE product_id ' . $product_bound);

							if ($db->query($sql)) {
								admin_log('', 'delete', 'products');
							}

							if (update_goods_stock($goods_id, 0 - $sum)) {
								admin_log('', 'update', 'goods');
							}

							sys_msg($_LANG['product_batch_del_success'], 0, $link);
						}
						else {
							sys_msg($_LANG['cannot_found_products'], 1, $link);
						}
					}

					sys_msg($_LANG['no_operation'], 1, $link);
				}
				else if ($_REQUEST['act'] == 'search_cat') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$keyword = !empty($_REQUEST['seacrch_key']) ? trim($_REQUEST['seacrch_key']) : '';
					$parent_id = !empty($_GET['parent_id']) ? intval($_GET['parent_id']) : 0;
					$cat_level = !empty($_GET['cat_level']) ? intval($_GET['cat_level']) : 0;
					$res = array('error' => 0, 'message' => '');

					if (!empty($keyword)) {
						if ($adminru['ru_id'] == 0) {
							$sql = 'SELECT `cat_id`,`cat_name` FROM ' . $GLOBALS['ecs']->table('category') . ('WHERE `cat_name` like \'%' . $keyword . '%\' AND parent_id = \'' . $parent_id . '\'');
							$options = $GLOBALS['db']->getAll($sql);
						}
						else {
							$sql = 'select user_shopMain_category from ' . $GLOBALS['ecs']->table('merchants_shop_information') . ' where user_id = \'' . $adminru['ru_id'] . '\'';
							$shopMain_category = $GLOBALS['db']->getOne($sql);
							$cat_ids = explode(',', get_category_child_tree($shopMain_category));
							$sql = 'SELECT `cat_id`,`cat_name` FROM ' . $GLOBALS['ecs']->table('category') . ('WHERE `cat_name` like \'%' . $keyword . '%\' and cat_id ') . db_create_in($cat_ids) . (' AND parent_id = \'' . $parent_id . '\'');
							$options = $GLOBALS['db']->getAll($sql);
						}

						if ($options) {
							foreach ($options as $key => $row) {
								$options[0]['cat_id'] = 0;
								$options[0]['cat_name'] = '所有分类';
								$key += 1;
								$options[$key] = $row;
							}
						}
						else {
							$res['error'] = 1;
							$res['message'] = '没有查询到分类!';
						}
					}

					$res['parent_id'] = $parent_id;
					$res['cat_level'] = $cat_level + 1;
					make_json_result($options, '', $res);
				}
				else if ($_REQUEST['act'] == 'sel_cat') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$res = array('error' => 0, 'message' => '', 'cat_level' => 0, 'content' => '');
					$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
					$cat_level = !empty($_GET['cat_level']) ? intval($_GET['cat_level']) : 0;

					if (0 < $cat_id) {
						$arr = cat_list_one($cat_id, $cat_level);
					}

					$res['content'] = $arr;
					$res['parent_id'] = $cat_id;
					$res['cat_level'] = $cat_level;
					echo $json->encode($res);
					exit();
				}
				else if ($_REQUEST['act'] == 'sel_cat1') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$res = array('error' => 0, 'message' => '', 'cat_level' => 0, 'content' => '');
					$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
					$cat_level = !empty($_GET['cat_level']) ? intval($_GET['cat_level']) : 0;

					if (0 < $cat_id) {
						$arr = cat_list_one1($cat_id, $cat_level);
					}

					$res['content'] = $arr;
					$res['parent_id'] = $cat_id;
					$res['cat_level'] = $cat_level;
					echo $json->encode($res);
					exit();
				}
				else if ($_REQUEST['act'] == 'sel_cat2') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$res = array('error' => 0, 'message' => '', 'cat_level' => 0, 'content' => '');
					$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
					$cat_level = !empty($_GET['cat_level']) ? intval($_GET['cat_level']) : 0;

					if (0 < $cat_id) {
						$arr = cat_list_one2($cat_id, $cat_level);
					}

					$res['content'] = $arr;
					$res['parent_id'] = $cat_id;
					$res['cat_level'] = $cat_level;
					echo $json->encode($res);
					exit();
				}
				else if ($_REQUEST['act'] == 'sel_cat_edit') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$res = array('error' => 0, 'message' => '', 'cat_level' => 0, 'content' => '');
					$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
					$cat_level = !empty($_GET['cat_level']) ? intval($_GET['cat_level']) : 0;

					if (0 < $cat_id) {
						$arr = cat_list_one_new($cat_id, $cat_level, 'sel_cat_edit');
					}

					$res['content'] = $arr;
					$res['parent_id'] = $cat_id;
					$res['cat_level'] = $cat_level;
					echo $json->encode($res);
					exit();
				}
				else if ($_REQUEST['act'] == 'sel_cat_picture') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$res = array('error' => 0, 'message' => '', 'cat_level' => 0, 'content' => '');
					$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
					$cat_level = !empty($_GET['cat_level']) ? intval($_GET['cat_level']) : 0;

					if (0 < $cat_id) {
						$arr = cat_list_one_new($cat_id, $cat_level, 'sel_cat_picture');
					}

					$res['content'] = $arr;
					$res['parent_id'] = $cat_id;
					$res['cat_level'] = $cat_level;
					echo $json->encode($res);
					exit();
				}
				else if ($_REQUEST['act'] == 'sel_cat_goodslist') {
					include_once ROOT_PATH . 'includes/cls_json.php';
					$json = new JSON();
					$res = array('error' => 0, 'message' => '', 'cat_level' => 0, 'content' => '');
					$cat_id = !empty($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;
					$cat_level = !empty($_GET['cat_level']) ? intval($_GET['cat_level']) : 0;

					if (0 < $cat_id) {
						$arr = cat_list_one_new($cat_id, $cat_level, 'sel_cat_goodslist');
					}

					$res['content'] = $arr;
					$res['parent_id'] = $cat_id;
					$res['cat_level'] = $cat_level;
					echo $json->encode($res);
					exit();
				}
				else if ($_REQUEST['act'] == 'edit_attr_sort') {
					check_authz_json('goods_manage');
					$goods_attr_id = intval($_REQUEST['id']);
					$attr_sort = intval($_POST['val']);
					$sql = 'UPDATE ' . $ecs->table('goods_attr') . (' SET attr_sort = \'' . $attr_sort . '\' WHERE goods_attr_id = \'' . $goods_attr_id . '\'');
					$result = $db->query($sql);

					if ($result) {
						clear_cache_files();
						make_json_result($attr_sort);
					}
				}
				else if ($_REQUEST['act'] == 'addWarehouse') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('content' => '', 'error' => 0, 'massege' => '');
					$ware_name = !empty($_POST['ware_name']) ? $_POST['ware_name'] : '';
					$ware_number = !empty($_POST['ware_number']) ? intval($_POST['ware_number']) : 0;
					$ware_price = !empty($_POST['ware_price']) ? $_POST['ware_price'] : 0;
					$ware_price = floatval($ware_price);
					$ware_promote_price = !empty($_POST['ware_promote_price']) ? $_POST['ware_promote_price'] : 0;
					$ware_promote_price = floatval($ware_promote_price);
					$give_integral = !empty($_POST['give_integral']) ? intval($_POST['give_integral']) : 0;
					$rank_integral = !empty($_POST['rank_integral']) ? intval($_POST['rank_integral']) : 0;
					$pay_integral = !empty($_POST['pay_integral']) ? intval($_POST['pay_integral']) : 0;
					$goods_id = !empty($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;

					if (empty($ware_name)) {
						$result['error'] = '1';
						$result['massege'] = '请选择仓库';
					}
					else {
						$sql = 'select w_id from ' . $GLOBALS['ecs']->table('warehouse_goods') . (' where goods_id = \'' . $goods_id . '\' and region_id = \'') . $ware_name . ('\' AND user_id = \'' . $user_id . '\'');
						$w_id = $GLOBALS['db']->getOne($sql);
						$add_time = gmtime();

						if (0 < $w_id) {
							$result['error'] = '1';
							$result['massege'] = '该商品的仓库库存已存在';
						}
						else if ($ware_number == 0) {
							$result['error'] = '1';
							$result['massege'] = '仓库库存不能为0';
						}
						else if ($ware_price == 0) {
							$result['error'] = '1';
							$result['massege'] = '仓库价格不能为0';
						}
						else {
							$goodsInfo = get_admin_goods_info($goods_id, array('user_id', 'model_inventory', 'model_attr'));
							$goodsInfo['user_id'] = !empty($goodsInfo['user_id']) ? $goodsInfo['user_id'] : $adminru['ru_id'];
							$number = '+ ' . $ware_number;
							$use_storage = 13;
							$logs_other = array('goods_id' => $goods_id, 'order_id' => 0, 'use_storage' => $use_storage, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $goodsInfo['model_inventory'], 'model_attr' => $goodsInfo['model_attr'], 'product_id' => 0, 'warehouse_id' => $ware_name, 'area_id' => 0, 'add_time' => $add_time);
							$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
							$sql = 'insert into ' . $GLOBALS['ecs']->table('warehouse_goods') . '(goods_id, region_id, region_number, warehouse_price, warehouse_promote_price, give_integral, rank_integral, pay_integral, user_id, add_time)VALUES(\'' . $goods_id . '\',\'' . $ware_name . '\',\'' . $ware_number . '\',\'' . $ware_price . '\',\'' . $ware_promote_price . '\',\'' . $give_integral . '\',\'' . $rank_integral . '\',\'' . $pay_integral . '\',\'' . $goodsInfo['user_id'] . ('\',\'' . $add_time . '\')');

							if ($GLOBALS['db']->query($sql) == true) {
								$result['error'] = '2';
								$get_warehouse_goods_list = get_warehouse_goods_list($goods_id);
								$warehouse_id = '';

								if (!empty($get_warehouse_goods_list)) {
									foreach ($get_warehouse_goods_list as $k => $v) {
										$warehouse_id .= $v['w_id'] . ',';
									}
								}

								$warehouse_id = substr($warehouse_id, 0, strlen($warehouse_id) - 1);
								$smarty->assign('warehouse_id', $warehouse_id);
								$smarty->assign('warehouse_goods_list', $get_warehouse_goods_list);
								$result['content'] = $GLOBALS['smarty']->fetch('library/goods_warehouse.lbi');
							}
						}
					}

					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'addBatchWarehouse') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('content' => '', 'error' => 0, 'massege' => '');
					$ware_name = !empty($_POST['ware_name']) ? explode(',', $_POST['ware_name']) : array();
					$ware_number = !empty($_POST['ware_number']) ? explode(',', $_POST['ware_number']) : array();
					$ware_price = !empty($_POST['ware_price']) ? explode(',', $_POST['ware_price']) : array();
					$ware_promote_price = !empty($_POST['ware_promote_price']) ? explode(',', $_POST['ware_promote_price']) : array();
					$give_integral = !empty($_POST['give_integral']) ? explode(',', $_POST['give_integral']) : array();
					$rank_integral = !empty($_POST['rank_integral']) ? explode(',', $_POST['rank_integral']) : array();
					$pay_integral = !empty($_POST['pay_integral']) ? explode(',', $_POST['pay_integral']) : array();
					$goods_id = !empty($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;

					if (empty($ware_name)) {
						$result['error'] = '1';
						$result['massege'] = '请选择仓库';
					}
					else {
						$add_time = gmtime();
						$goodsInfo = get_admin_goods_info($goods_id, array('user_id', 'model_inventory', 'model_attr'));
						$goodsInfo['user_id'] = !empty($goodsInfo['user_id']) ? $goodsInfo['user_id'] : $adminru['ru_id'];

						for ($i = 0; $i < count($ware_name); $i++) {
							if (!empty($ware_name[$i])) {
								if ($ware_number[$i] == 0) {
									$ware_number[$i] = 1;
								}

								$sql = 'SELECT w_id FROM ' . $GLOBALS['ecs']->table('warehouse_goods') . (' WHERE goods_id = \'' . $goods_id . '\' AND region_id = \'') . $ware_name[$i] . '\'';
								$w_id = $GLOBALS['db']->getOne($sql, true);

								if (0 < $w_id) {
									$result['error'] = '1';
									$result['massege'] = '该商品的仓库库存已存在';
									break;
								}
								else {
									$ware_number[$i] = intval($ware_number[$i]);
									$ware_price[$i] = floatval($ware_price[$i]);
									$ware_promote_price[$i] = floatval($ware_promote_price[$i]);
									$number = '+ ' . $ware_number[$i];
									$use_storage = 13;
									$logs_other = array('goods_id' => $goods_id, 'order_id' => 0, 'use_storage' => $use_storage, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $goodsInfo['model_inventory'], 'model_attr' => $goodsInfo['model_attr'], 'product_id' => 0, 'warehouse_id' => $ware_name[$i], 'area_id' => 0, 'add_time' => $add_time);
									$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
									$sql = 'insert into ' . $GLOBALS['ecs']->table('warehouse_goods') . '(goods_id, region_id, region_number, warehouse_price, warehouse_promote_price, user_id, add_time)VALUES(\'' . $goods_id . '\',\'' . $ware_name[$i] . '\',\'' . $ware_number[$i] . '\',\'' . $ware_price[$i] . '\',\'' . $ware_promote_price[$i] . '\',\'' . $goodsInfo['user_id'] . ('\',\'' . $add_time . '\')');
									$GLOBALS['db']->query($sql);
									$get_warehouse_goods_list = get_warehouse_goods_list($goods_id);
									$warehouse_id = '';

									if (!empty($get_warehouse_goods_list)) {
										foreach ($get_warehouse_goods_list as $k => $v) {
											$warehouse_id .= $v['w_id'] . ',';
										}
									}

									$warehouse_id = substr($warehouse_id, 0, strlen($warehouse_id) - 1);
									$smarty->assign('warehouse_id', $warehouse_id);
									$smarty->assign('warehouse_goods_list', $get_warehouse_goods_list);
								}
							}
							else {
								$result['error'] = '1';
								$result['massege'] = '请选择仓库';
							}
						}
					}

					$result['content'] = $GLOBALS['smarty']->fetch('library/goods_warehouse.lbi');
					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'goods_warehouse') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('content' => '', 'error' => 0, 'massege' => '');
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$warehouse_goods_list = get_warehouse_goods_list($goods_id);
					$GLOBALS['smarty']->assign('warehouse_goods_list', $warehouse_goods_list);
					$GLOBALS['smarty']->assign('is_list', 1);
					$result['content'] = $GLOBALS['smarty']->fetch('library/goods_warehouse.lbi');
					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'goods_region') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('content' => '', 'error' => 0, 'massege' => '');
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : 0;
					$warehouse_area_goods_list = get_warehouse_area_goods_list($goods_id);
					$GLOBALS['smarty']->assign('warehouse_area_goods_list', $warehouse_area_goods_list);
					$GLOBALS['smarty']->assign('is_list', 1);
					$result['content'] = $GLOBALS['smarty']->fetch('library/goods_region.lbi');
					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'addRegion') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('content' => '', 'error' => 0, 'massege' => '');
					$warehouse_area_name = !empty($_POST['warehouse_area_name']) ? $_POST['warehouse_area_name'] : '';
					$area_name = !empty($_POST['warehouse_area_list']) ? $_POST['warehouse_area_list'] : '';
					$region_number = !empty($_POST['region_number']) ? intval($_POST['region_number']) : 0;
					$region_price = !empty($_POST['region_price']) ? floatval($_POST['region_price']) : 0;
					$region_promote_price = !empty($_POST['region_promote_price']) ? floatval($_POST['region_promote_price']) : 0;
					$give_integral = !empty($_POST['give_integral']) ? intval($_POST['give_integral']) : 0;
					$rank_integral = !empty($_POST['rank_integral']) ? intval($_POST['rank_integral']) : 0;
					$pay_integral = !empty($_POST['pay_integral']) ? intval($_POST['pay_integral']) : 0;
					$goods_id = !empty($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;

					if (empty($area_name)) {
						$result['error'] = '1';
						$result['massege'] = '请选择地区';
					}
					else if ($region_number == 0) {
						$result['error'] = '1';
						$result['massege'] = '地区库存不能为0';
					}
					else if ($region_price == 0) {
						$result['error'] = '1';
						$result['massege'] = '地区价格不能为0';
					}
					else {
						$add_time = gmtime();
						$sql = 'select a_id from ' . $GLOBALS['ecs']->table('warehouse_area_goods') . (' where goods_id = \'' . $goods_id . '\' and region_id = \'') . $area_name . '\'';
						$a_id = $GLOBALS['db']->getOne($sql);

						if (0 < $a_id) {
							$result['error'] = '1';
							$result['massege'] = '该商品的地区价格已存在';
						}
						else {
							$goodsInfo = get_admin_goods_info($goods_id, array('goods_id', 'user_id', 'model_inventory', 'model_attr'));
							$goodsInfo['user_id'] = !empty($goodsInfo['user_id']) ? $goodsInfo['user_id'] : $adminru['ru_id'];
							$number = '+ ' . $region_number;
							$use_storage = 13;
							$logs_other = array('goods_id' => $goods_id, 'order_id' => 0, 'use_storage' => $use_storage, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $goodsInfo['model_inventory'], 'model_attr' => $goodsInfo['model_attr'], 'product_id' => 0, 'warehouse_id' => 0, 'area_id' => $area_name, 'add_time' => $add_time);
							$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
							$sql = 'insert into ' . $GLOBALS['ecs']->table('warehouse_area_goods') . '(goods_id, region_id, region_number, region_price, region_promote_price, give_integral, rank_integral, pay_integral, user_id, add_time)VALUES(\'' . $goods_id . '\',\'' . $area_name . '\',\'' . $region_number . '\',\'' . floatval($region_price) . '\',\'' . floatval($region_promote_price) . '\',\'' . floatval($give_integral) . '\',\'' . floatval($rank_integral) . '\',\'' . floatval($pay_integral) . '\',\'' . $goodsInfo['user_id'] . ('\',\'' . $add_time . '\')');

							if ($GLOBALS['db']->query($sql) == true) {
								$result['error'] = '2';
								$warehouse_area_goods_list = get_warehouse_area_goods_list($goods_id);
								$warehouse_id = '';

								if (!empty($warehouse_area_goods_list)) {
									foreach ($warehouse_area_goods_list as $k => $v) {
										$warehouse_id .= $v['a_id'] . ',';
									}
								}

								$warehouse_area_id = substr($warehouse_id, 0, strlen($warehouse_id) - 1);
								$smarty->assign('warehouse_area_id', $warehouse_area_id);
								$smarty->assign('warehouse_area_goods_list', $warehouse_area_goods_list);
								$smarty->assign('goods', $goodsInfo);
								$result['content'] = $GLOBALS['smarty']->fetch('library/goods_region.lbi');
							}
						}
					}

					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'addBatchRegion') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('content' => '', 'error' => 0, 'massege' => '');
					$warehouse_area_name = !empty($_POST['warehouse_area_name']) ? explode(',', $_POST['warehouse_area_name']) : array();
					$area_name = !empty($_POST['warehouse_area_list']) ? explode(',', $_POST['warehouse_area_list']) : array();
					$region_number = !empty($_POST['region_number']) ? explode(',', $_POST['region_number']) : array();
					$region_price = !empty($_POST['region_price']) ? explode(',', $_POST['region_price']) : array();
					$region_promote_price = !empty($_POST['region_promote_price']) ? explode(',', $_POST['region_promote_price']) : array();
					$goods_id = !empty($_POST['goods_id']) ? intval($_POST['goods_id']) : 0;

					if (empty($area_name)) {
						$result['error'] = '1';
						$result['massege'] = '请选择地区';
					}
					else if (empty($region_number)) {
						$result['error'] = '1';
						$result['massege'] = '地区库存不能为0';
					}
					else if (empty($region_price)) {
						$result['error'] = '1';
						$result['massege'] = '地区价格不能为0';
					}
					else {
						$add_time = gmtime();
						$goodsInfo = get_admin_goods_info($goods_id, array('goods_id', 'user_id', 'model_inventory', 'model_attr'));
						$goodsInfo['user_id'] = !empty($goodsInfo['user_id']) ? $goodsInfo['user_id'] : $adminru['ru_id'];

						for ($i = 0; $i < count($area_name); $i++) {
							if (!empty($area_name[$i])) {
								$sql = 'select a_id from ' . $GLOBALS['ecs']->table('warehouse_area_goods') . (' where goods_id = \'' . $goods_id . '\' and region_id = \'') . $area_name[$i] . '\'';
								$a_id = $GLOBALS['db']->getOne($sql, true);

								if (0 < $a_id) {
									$result['error'] = '1';
									$result['massege'] = '该商品的地区价格已存在';
									break;
								}
								else {
									$ware_number[$i] = intval($ware_number[$i]);
									$ware_price[$i] = floatval($ware_price[$i]);
									$region_promote_price[$i] = floatval($region_promote_price[$i]);
									$number = '+ ' . $ware_number[$i];
									$use_storage = 13;
									$logs_other = array('goods_id' => $goods_id, 'order_id' => 0, 'use_storage' => $use_storage, 'admin_id' => $_SESSION['admin_id'], 'number' => $number, 'model_inventory' => $goodsInfo['model_inventory'], 'model_attr' => $goodsInfo['model_attr'], 'product_id' => 0, 'warehouse_id' => 0, 'area_id' => $area_name[$i], 'add_time' => $add_time);
									$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('goods_inventory_logs'), $logs_other, 'INSERT');
									$sql = 'insert into ' . $GLOBALS['ecs']->table('warehouse_area_goods') . '(goods_id, region_id, region_number, region_price, region_promote_price, user_id, add_time)VALUES(\'' . $goods_id . '\',\'' . $area_name[$i] . '\',\'' . $region_number[$i] . '\',\'' . $region_price[$i] . '\',\'' . $region_promote_price[$i] . '\',\'' . $goodsInfo['user_id'] . ('\',\'' . $add_time . '\')');
									$GLOBALS['db']->query($sql);
									$get_warehouse_area_goods_list = get_warehouse_area_goods_list($goods_id);
									$warehouse_id = '';

									if (!empty($get_warehouse_area_goods_list)) {
										foreach ($get_warehouse_area_goods_list as $k => $v) {
											$warehouse_id .= $v['a_id'] . ',';
										}
									}

									$warehouse_area_id = substr($warehouse_id, 0, strlen($warehouse_id) - 1);
									$smarty->assign('warehouse_area_id', $warehouse_area_id);
									$smarty->assign('warehouse_area_goods_list', $get_warehouse_area_goods_list);
									$smarty->assign('goods', $goodsInfo);
								}
							}
							else {
								$result['error'] = '1';
								$result['massege'] = '请选择地区';
								break;
							}
						}
					}

					$result['content'] = $GLOBALS['smarty']->fetch('library/goods_region.lbi');
					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'addImg') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('content' => '', 'error' => 0, 'massege' => '');
					$goods_id = !empty($_REQUEST['goods_id_img']) ? $_REQUEST['goods_id_img'] : '';
					$img_desc = !empty($_REQUEST['img_desc']) ? $_REQUEST['img_desc'] : '';
					$img_file = !empty($_REQUEST['img_file']) ? $_REQUEST['img_file'] : '';
					$php_maxsize = ini_get('upload_max_filesize');
					$htm_maxsize = '2M';

					if ($_FILES['img_url']) {
						foreach ($_FILES['img_url']['error'] as $key => $value) {
							if ($value == 0) {
								if (!$image->check_img_type($_FILES['img_url']['type'][$key])) {
									$result['error'] = '1';
									$result['massege'] = sprintf($_LANG['invalid_img_url'], $key + 1);
								}
								else {
									$goods_pre = 1;
								}
							}
							else if ($value == 1) {
								$result['error'] = '1';
								$result['massege'] = sprintf($_LANG['img_url_too_big'], $key + 1, $php_maxsize);
							}
							else if ($_FILES['img_url']['error'] == 2) {
								$result['error'] = '1';
								$result['massege'] = sprintf($_LANG['img_url_too_big'], $key + 1, $htm_maxsize);
							}
						}
					}

					handle_gallery_image_add($goods_id, $_FILES['img_url'], $img_desc, $img_file, '', '', 'ajax');
					clear_cache_files();

					if (0 < $goods_id) {
						$sql = 'SELECT * FROM ' . $ecs->table('goods_gallery') . (' WHERE goods_id = \'' . $goods_id . '\'');
					}
					else {
						$img_id = $_SESSION['thumb_img_id' . $_SESSION['admin_id']];
						$where = '';

						if ($img_id) {
							$where = 'AND img_id ' . db_create_in($img_id) . '';
						}

						$sql = 'SELECT * FROM ' . $ecs->table('goods_gallery') . (' WHERE goods_id=\'\' ' . $where . ' ORDER BY img_desc ASC');
					}

					$img_list = $db->getAll($sql);
					if (isset($GLOBALS['shop_id']) && 0 < $GLOBALS['shop_id']) {
						foreach ($img_list as $key => $gallery_img) {
							$gallery_img['img_original'] = get_image_path($gallery_img['goods_id'], $gallery_img['img_original'], true);
							$img_list[$key]['img_url'] = $gallery_img['img_original'];
							$gallery_img['thumb_url'] = get_image_path($gallery_img['goods_id'], $gallery_img['thumb_url'], true);
							$img_list[$key]['thumb_url'] = $gallery_img['thumb_url'];
						}
					}
					else {
						foreach ($img_list as $key => $gallery_img) {
							$gallery_img['thumb_url'] = get_image_path($gallery_img['goods_id'], $gallery_img['thumb_url'], true);
							$img_list[$key]['thumb_url'] = $gallery_img['thumb_url'];
						}
					}

					$goods['goods_id'] = $goods_id;
					$smarty->assign('img_list', $img_list);
					$img_desc = array();

					foreach ($img_list as $k => $v) {
						$img_desc[] = $v['img_desc'];
					}

					$img_default = min($img_desc);
					$min_img_id = $db->getOne(' SELECT img_id   FROM ' . $ecs->table('goods_gallery') . (' WHERE goods_id = \'' . $goods_id . '\' AND img_desc = \'' . $img_default . '\' ORDER BY img_desc   LIMIT 1'));
					$smarty->assign('min_img_id', $min_img_id);
					$smarty->assign('goods', $goods);
					$result['error'] = '2';
					$result['content'] = $GLOBALS['smarty']->fetch('goods_img_list.dwt');
					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'img_default') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('content' => '', 'error' => 0, 'massege' => '', 'img_id' => '');
					$admin_id = get_admin_id();
					$img_id = !empty($_REQUEST['img_id']) ? intval($_REQUEST['img_id']) : '0';

					if (0 < $img_id) {
						$goods_id = $db->getOne(' SELECT goods_id FROM' . $ecs->table('goods_gallery') . (' WHERE img_id= \'' . $img_id . '\''));
						$db->query('UPDATE' . $ecs->table('goods_gallery') . (' SET img_desc = img_desc+1 WHERE goods_id = \'' . $goods_id . '\' '));
						$sql = $db->query('UPDATE' . $ecs->table('goods_gallery') . (' SET img_desc = 1 WHERE img_id = \'' . $img_id . '\''));

						if ($sql = true) {
							$where = ' 1 ';
							if (empty($goods_id) && isset($_SESSION['thumb_img_id' . $admin_id]) && $_SESSION['thumb_img_id' . $admin_id]) {
								$where .= ' AND img_id' . db_create_in($_SESSION['thumb_img_id' . $admin_id]);
							}
							else {
								$where .= ' AND goods_id = \'' . $goods_id . '\'';
							}

							$sql = 'SELECT * FROM ' . $ecs->table('goods_gallery') . (' WHERE ' . $where . ' ORDER BY img_desc ASC');
							$img_list = $db->getAll($sql);
							if (isset($GLOBALS['shop_id']) && 0 < $GLOBALS['shop_id']) {
								foreach ($img_list as $key => $gallery_img) {
									$gallery_img['img_original'] = get_image_path($gallery_img['goods_id'], $gallery_img['img_original'], true);
									$img_list[$key]['img_url'] = $gallery_img['img_original'];
									$gallery_img['thumb_url'] = get_image_path($gallery_img['goods_id'], $gallery_img['thumb_url'], true);
									$img_list[$key]['thumb_url'] = $gallery_img['thumb_url'];
								}
							}
							else {
								foreach ($img_list as $key => $gallery_img) {
									$gallery_img['thumb_url'] = get_image_path($gallery_img['goods_id'], $gallery_img['thumb_url'], true);
									$img_list[$key]['thumb_url'] = $gallery_img['thumb_url'];
								}
							}

							$img_desc = array();

							foreach ($img_list as $k => $v) {
								$img_desc[] = $v['img_desc'];
							}

							$img_default = min($img_desc);
							$min_img_id = $db->getOne(' SELECT img_id   FROM ' . $ecs->table('goods_gallery') . (' WHERE goods_id = \'' . $goods_id . '\' AND img_desc = \'' . $img_default . '\' ORDER BY img_desc   LIMIT 1'));
							$smarty->assign('min_img_id', $min_img_id);
							$smarty->assign('img_list', $img_list);
							$result['error'] = 1;
							$result['content'] = $GLOBALS['smarty']->fetch('gallery_img.lbi');
						}
						else {
							$result['error'] = 2;
							$result['massege'] = '修改失败';
						}
					}

					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'remove_consumption') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('error' => 0, 'massege' => '', 'con_id' => '');
					$con_id = !empty($_REQUEST['con_id']) ? intval($_REQUEST['con_id']) : '0';
					$goods_id = !empty($_REQUEST['goods_id']) ? intval($_REQUEST['goods_id']) : '0';

					if (0 < $con_id) {
						$sql = 'DELETE FROM' . $ecs->table('goods_consumption') . (' WHERE id = \'' . $con_id . '\' AND goods_id = \'' . $goods_id . '\'');

						if ($db->query($sql)) {
							$result['error'] = 2;
							$result['con_id'] = $con_id;
						}
					}
					else {
						$result['error'] = 1;
						$result['massege'] = '请选择删除目标';
					}

					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'gallery_album_dialog') {
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('error' => 0, 'message' => '', 'log_type' => '', 'content' => '');
					$content = !empty($_REQUEST['content']) ? $_REQUEST['content'] : '';
					$sql = 'SELECT album_id,ru_id,album_mame,album_cover,album_desc,sort_order FROM ' . $ecs->table('gallery_album') . ' ' . (' WHERE ru_id = \'' . $adminru['ru_id'] . '\' ORDER BY sort_order');
					$gallery_album_list = $db->getAll($sql);
					$smarty->assign('gallery_album_list', $gallery_album_list);
					$log_type = !empty($_GET['log_type']) ? trim($_GET['log_type']) : 'image';
					$result['log_type'] = $log_type;
					$smarty->assign('log_type', $log_type);
					$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('pic_album') . (' WHERE ru_id = \'' . $adminru['ru_id'] . '\'');
					$res = $GLOBALS['db']->getAll($sql);
					$smarty->assign('pic_album', $res);
					$smarty->assign('content', $content);
					$result['content'] = $smarty->fetch('library/album_dialog.lbi');
					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'scan_code') {
					check_authz_json('goods_manage');
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('error' => 0, 'massege' => '', 'content' => '');
					$bar_code = empty($_REQUEST['bar_code']) ? '' : trim($_REQUEST['bar_code']);
					$config = get_scan_code_config($adminru['ru_id']);
					$data = get_jsapi(array('appkey' => $config['js_appkey'], 'barcode' => $bar_code));

					if ($data['status'] != 0) {
						$result['error'] = 1;
						$result['message'] = $data['msg'];
					}
					else {
						$goods_weight = 0;

						if (strpos($data['result']['grossweight'], '千克') !== false) {
							$goods_weight = floatval(str_replace('千克', '', $data['result']['grossweight']));
						}
						else if (strpos($data['result']['grossweight'], '克') !== false) {
							$goods_weight = floatval(str_replace('千克', '', $data['result']['grossweight'])) / 1000;
						}

						$goods_desc = '';

						if (!empty($data['result']['description'])) {
							create_html_editor('goods_desc', trim($data['result']['description']));
							$goods_desc = $smarty->get_template_vars('FCKeditor');
						}

						$goods_info = array();
						$goods_info['goods_name'] = isset($data['result']['name']) ? trim($data['result']['name']) : '';
						$goods_info['goods_name'] .= isset($data['result']['type']) ? trim($data['result']['type']) : '';
						$goods_info['shop_price'] = isset($data['result']['price']) ? floatval($data['result']['price']) : '0.00';
						$goods_info['goods_img_url'] = isset($data['result']['pic']) ? trim($data['result']['pic']) : '';
						$goods_info['goods_desc'] = $goods_desc;
						$goods_info['goods_weight'] = $goods_weight;
						$goods_info['keywords'] = isset($data['result']['keyword']) ? trim($data['result']['keyword']) : '';
						$goods_info['width'] = isset($data['result']['width']) ? trim($data['result']['width']) : '';
						$goods_info['height'] = isset($data['result']['height']) ? trim($data['result']['height']) : '';
						$goods_info['depth'] = isset($data['result']['depth']) ? trim($data['result']['depth']) : '';
						$goods_info['origincountry'] = isset($data['result']['origincountry']) ? trim($data['result']['origincountry']) : '';
						$goods_info['originplace'] = isset($data['result']['originplace']) ? trim($data['result']['originplace']) : '';
						$goods_info['assemblycountry'] = isset($data['result']['assemblycountry']) ? trim($data['result']['assemblycountry']) : '';
						$goods_info['barcodetype'] = isset($data['result']['barcodetype']) ? trim($data['result']['barcodetype']) : '';
						$goods_info['catena'] = isset($data['result']['catena']) ? trim($data['result']['catena']) : '';
						$goods_info['isbasicunit'] = isset($data['result']['isbasicunit']) ? intval($data['result']['isbasicunit']) : 0;
						$goods_info['packagetype'] = isset($data['result']['packagetype']) ? trim($data['result']['packagetype']) : '';
						$goods_info['grossweight'] = isset($data['result']['grossweight']) ? trim($data['result']['grossweight']) : '';
						$goods_info['netweight'] = isset($data['result']['netweight']) ? trim($data['result']['netweight']) : '';
						$goods_info['netcontent'] = isset($data['result']['netcontent']) ? trim($data['result']['netcontent']) : '';
						$goods_info['licensenum'] = isset($data['result']['licensenum']) ? trim($data['result']['licensenum']) : '';
						$goods_info['healthpermitnum'] = isset($data['result']['healthpermitnum']) ? trim($data['result']['healthpermitnum']) : '';
						$result['goods_info'] = $goods_info;
					}

					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'view_log') {
					admin_priv('goods_manage');
					$smarty->assign('primary_cat', $_LANG['02_cat_and_goods']);
					$smarty->assign('menu_select', array('action' => '02_cat_and_goods', 'current' => '01_goods_list'));
					$smarty->assign('ur_here', $_LANG['view_log']);
					$smarty->assign('ip_list', $ip_list);
					$smarty->assign('full_page', 1);
					$goods_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
					$action_link = array('href' => 'goods.php?act=list', 'text' => $_LANG['01_goods_list'], 'class' => 'icon-reply');
					$smarty->assign('action_link', $action_link);
					$log_list = get_goods_change_logs($goods_id);
					$page_count_arr = seller_page($log_list, $_REQUEST['page']);
					$smarty->assign('page_count_arr', $page_count_arr);
					$smarty->assign('goods_id', $goods_id);
					$smarty->assign('log_list', $log_list['list']);
					$smarty->assign('filter', $log_list['filter']);
					$smarty->assign('record_count', $log_list['record_count']);
					$smarty->assign('page_count', $log_list['page_count']);
					$sort_flag = sort_flag($log_list['filter']);
					$smarty->assign($sort_flag['tag'], $sort_flag['img']);
					assign_query_info();
					$smarty->display('goods_view_logs.dwt');
				}
				else if ($_REQUEST['act'] == 'view_detail') {
					require_once ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('error' => 0, 'message' => '', 'content' => '');
					$log_id = !empty($_REQUEST['log_id']) ? intval($_REQUEST['log_id']) : 0;
					$step = !empty($_REQUEST['step']) ? trim($_REQUEST['step']) : '';

					if ($step == 'member') {
						$res = $db->getOne(' SELECT member_price FROM ' . $ecs->table('goods_change_log') . (' WHERE log_id = \'' . $log_id . '\' '));
						$res = unserialize($res);

						if ($res) {
							foreach ($res as $k => $v) {
								$member_price[$k]['rank_name'] = $db->getOne(' SELECT rank_name FROM ' . $ecs->table('user_rank') . (' WHERE rank_id = \'' . $k . '\' '));
								$member_price[$k]['member_price'] = $v;
							}
						}

						$smarty->assign('res', $member_price);
					}
					else if ($step == 'volume') {
						$res = $db->getOne(' SELECT volume_price FROM ' . $ecs->table('goods_change_log') . (' WHERE log_id = \'' . $log_id . '\' '));
						$res = unserialize($res);

						if ($res) {
							foreach ($res as $k => $v) {
								$volume_price[$k]['volume_num'] = $k;
								$volume_price[$k]['volume_price'] = $v;
							}
						}

						$smarty->assign('res', $volume_price);
					}

					$smarty->assign('step', $step);
					$result['content'] = $GLOBALS['smarty']->fetch('library/view_detail_list.lbi');
					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'view_query') {
					$goods_id = !empty($_REQUEST['goodsId']) ? intval($_REQUEST['goodsId']) : 0;
					$log_list = get_goods_change_logs($goods_id);
					$page_count_arr = seller_page($log_list, $_REQUEST['page']);
					$smarty->assign('page_count_arr', $page_count_arr);
					$smarty->assign('log_list', $log_list['list']);
					$smarty->assign('filter', $log_list['filter']);
					$smarty->assign('record_count', $log_list['record_count']);
					$smarty->assign('page_count', $log_list['page_count']);
					$sort_flag = sort_flag($log_list['filter']);
					$smarty->assign($sort_flag['tag'], $sort_flag['img']);
					make_json_result($smarty->fetch('goods_view_logs.dwt'), '', array('filter' => $log_list['filter'], 'page_count' => $log_list['page_count']));
				}
				else if ($_REQUEST['act'] == 'edit_gorup_type') {
					check_authz_json('goods_manage');
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('error' => '', 'message' => '');
					$id = intval($_POST['id']);
					$group_id = intval($_POST['group_id']);
					$sql = 'UPDATE' . $ecs->table('group_goods') . ('SET group_id = \'' . $group_id . '\' WHERE id = \'' . $id . '\'');
					$db->query($sql);
					exit($json->encode($result));
				}
				else if ($_REQUEST['act'] == 'edit_gorup_price') {
					check_authz_json(goods_manage);
					$exc_gr = new exchange($ecs->table('group_goods'), $db, 'id', 'group_id', 'goods_price');
					$id = intval($_POST['id']);
					$sec_price = floatval($_POST['val']);

					if ($exc_gr->edit('goods_price = \'' . $sec_price . '\'', $id)) {
						clear_cache_files();
						make_json_result($sec_price);
					}
				}
				else if ($_REQUEST['act'] == 'remove_group_type') {
					check_authz_json('goods_manage');
					require ROOT_PATH . '/includes/cls_json.php';
					$json = new JSON();
					$result = array('error' => '', 'message' => '');
					$id = intval($_POST['id']);
					$sql = 'DELETE FROM' . $ecs->table('group_goods') . (' WHERE id = \'' . $id . '\'');
					$db->query($sql);
					exit($json->encode($result));
				}
			}
		}
	}


?>
