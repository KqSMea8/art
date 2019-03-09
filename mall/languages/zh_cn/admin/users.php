<?php

/**
 * ECSHOP 会员账号管理语言文件
 * ============================================================================
 * * 版权所有 2017-2018 深圳艺者科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecmoban.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: users.php 17217 2011-01-19 06:29:08Z liubo $
*/

$_LANG['nick_name'] = '昵称';

/* 密码找回问题 */
$_LANG['passwd_questions']['friend_birthday'] = '我最好朋友的生日？';
$_LANG['passwd_questions']['old_address']     = '我儿时居住地的地址？';
$_LANG['passwd_questions']['motto']           = '我的座右铭是？';
$_LANG['passwd_questions']['favorite_movie']  = '我最喜爱的电影？';
$_LANG['passwd_questions']['favorite_song']   = '我最喜爱的歌曲？';
$_LANG['passwd_questions']['favorite_food']   = '我最喜爱的食物？';
$_LANG['passwd_questions']['interest']        = '我最大的爱好？';
$_LANG['passwd_questions']['favorite_novel']  = '我最喜欢的小说？';
$_LANG['passwd_questions']['favorite_equipe'] = '我最喜欢的运动队？';

$_LANG['passwd_question'] = '密码提示问题';
$_LANG['sel_question'] = '请选择密码提示问题';
$_LANG['passwd_answer'] = '密码问题答案';
$_LANG['passwd_balnk'] = '密码中不能包含空格';

/* 列表页面 */
$_LANG['label_user_name'] = '会员名称';
$_LANG['label_pay_points_gt'] = '会员积分大于';
$_LANG['label_pay_points_lt'] = '会员积分小于';
$_LANG['label_rank_name'] = '会员等级';
$_LANG['all_option'] = '所有等级';

$_LANG['view_order'] = '查看订单';
$_LANG['view_deposit'] = '查看账目明细';
$_LANG['username'] = '会员名称';
$_LANG['email'] = '邮件地址';
$_LANG['is_validated'] = '验证';
$_LANG['reg_date'] = '注册日期';
$_LANG['button_remove'] = '删除会员';
$_LANG['users_edit'] = '编辑会员账号';
$_LANG['goto_list'] = '返回会员账号列表';
$_LANG['username_empty'] = '会员名称不能为空！';
$_LANG['users_note'] = "基本信息";

/* 表单相关语言项 */
$_LANG['password'] = '登录密码';
$_LANG['confirm_password'] = '确认密码';
$_LANG['newpass'] = '新密码';
$_LANG['question'] = '密码提示问题';
$_LANG['answer'] = '密码提示问题答案';
$_LANG['gender'] = '性别';
$_LANG['birthday'] = '出生日期';
$_LANG['sex'][0] = '保密';
$_LANG['sex'][1] = '男';
$_LANG['sex'][2] = '女';
$_LANG['pay_points'] = '消费积分';
$_LANG['rank_points'] = '等级积分';
$_LANG['user_money'] = '可用资金';
$_LANG['frozen_money'] = '冻结资金';
$_LANG['credit_line'] = '信用额度';
$_LANG['user_rank'] = '会员等级';
$_LANG['not_special_rank'] = '非特殊等级';
$_LANG['view_detail_account'] = '查看明细';
$_LANG['parent_user'] = '推荐人';
$_LANG['parent_remove'] = '脱离推荐关系';
$_LANG['affiliate_user'] = '推荐会员';
$_LANG['show_affiliate_users'] = '查看推荐详细名单';
$_LANG['show_affiliate_orders'] = '查看推荐订单详情';
$_LANG['affiliate_lever'] = '等级';
$_LANG['affiliate_num'] = '人数';
$_LANG['page_note'] = '此列表显示用户推荐的全部会员信息，';
$_LANG['how_many_user'] = '个会员。';
$_LANG['back_note'] = '返回会员编辑页面';
$_LANG['affiliate_level'] = '推荐等级';

$_LANG['msn'] = 'MSN';
$_LANG['qq'] = 'QQ';
$_LANG['home_phone'] = '家庭电话';
$_LANG['office_phone'] = '办公电话';
$_LANG['mobile_phone'] = '手机';

$_LANG['notice_pay_points'] = '消费积分是一种站内货币，允许用户在购物时支付一定比例的积分。';
$_LANG['notice_rank_points'] = '等级积分是一种累计的积分，系统根据该积分来判定用户的会员等级。';
$_LANG['notice_user_money'] = '用户在站内预留下的金额';
$_LANG['notice_user_email'] = '请输入常用的邮箱，将用来找回密码、接受订单通知等。';

/* 提示信息 */
$_LANG['username_exists'] = '已经存在一个相同的用户名。';
$_LANG['email_exists'] = '该邮件地址已经存在。';
$_LANG['edit_user_failed'] = '修改会员资料失败。';
$_LANG['invalid_email'] = '输入了非法的邮件地址。';
$_LANG['update_success'] = '编辑用户信息已经成功。';
$_LANG['still_accounts'] = '该会员有余额或欠款\n';
$_LANG['remove_confirm'] = '您确定要删除该会员账号吗？';
$_LANG['list_still_accounts'] = '选中的会员账户中仍有余额或欠款\n';
$_LANG['list_remove_confirm'] = '您确定要删除所有选中的会员账号吗？';
$_LANG['remove_order_confirm'] = '该会员账号已经有订单存在，删除该会员账号的同时将清除订单数据。<br />您确定要删除吗？';
$_LANG['remove_order'] = '是，我确定要删除会员账号及其订单数据';
$_LANG['remove_cancel'] = '不，我不想删除该会员账号了。';
$_LANG['remove_success'] = '会员账号 %s 已经删除成功。';
$_LANG['add_success'] = '会员账号 %s 已经添加成功。';
$_LANG['batch_remove_success'] = '已经成功删除了 %d 个会员账号。';
$_LANG['no_select_user'] = '您现在没有需要删除的会员！';
$_LANG['register_points'] = '注册送积分';
$_LANG['username_not_allow'] = '用户名不允许注册';
$_LANG['username_invalid'] = '无效的用户名';
$_LANG['email_invalid'] = '无效的email地址';
$_LANG['email_not_allow'] = '邮件不允许';
$_LANG['remove_fail'] = '只有超级管理员才能删除该会员：%s！';
$_LANG['remove_seller_fail'] = "%s 会员是入驻商家，不能删除。<br/>(说明：可以先在 <a href='merchants_users_list.php?act=list&merchant_id=%s&store_search=1'>商家列表</a> 中删除该会员商家)";

/* 地址列表 */
$_LANG['address_list'] = '收货地址';
$_LANG['consignee'] = '收货人';
$_LANG['address'] = '地址';
$_LANG['link'] = '联系方式';
$_LANG['other'] = '其他';
$_LANG['tel'] = '电话';
$_LANG['mobile'] = '手机';
$_LANG['best_time'] = '最佳送货时间';
$_LANG['sign_building'] = '地址别名';
$_LANG['zipcode'] = '邮政编码';

/* JS 语言项 */
$_LANG['js_languages']['no_username'] = '没有输入用户名。';
$_LANG['js_languages']['invalid_email'] = '没有输入邮件地址或者输入了一个无效的邮件地址。';
$_LANG['js_languages']['no_password'] = '没有输入密码。';
$_LANG['js_languages']['less_password'] = '输入的密码不能少于六位。';
$_LANG['js_languages']['passwd_balnk'] = '密码中不能包含空格';
$_LANG['js_languages']['no_confirm_password'] = '没有输入确认密码。';
$_LANG['js_languages']['password_not_same'] = '输入的密码和确认密码不一致。';
$_LANG['js_languages']['invalid_pay_points'] = '消费积分数不是一个整数。';
$_LANG['js_languages']['invalid_rank_points'] = '等级积分数不是一个整数。';
$_LANG['js_languages']['password_len_err'] = '新密码和确认密码的长度不能小于6';


$_LANG['mall_user'] = '商城会员';
$_LANG['user'] = '会员';
$_LANG['email_phone'] = '手机/邮箱';
$_LANG['not_phone'] = '未验证手机';
$_LANG['not_email'] = '未验证邮箱';
$_LANG['not_rank'] = '无等级';
$_LANG['users_log'] = '操作记录';
$_LANG['change_type'] = '操作类型';
$_LANG['ip_address'] = "IP地址";
$_LANG['change_city'] = "参考地点";
$_LANG['logon_service'] = "登录业务";

$_LANG['change_type_user'][1] = '会员登录';
$_LANG['change_type_user'][2] = '修改会员头像';
$_LANG['change_type_user'][3] = '修改会员信息';
$_LANG['change_type_user'][4] = '会员实名认证';
$_LANG['change_type_user'][5] = '会员支付密码';
$_LANG['change_type_user'][6] = '修改会员手机';
$_LANG['change_type_user'][7] = '修改会员邮箱';
$_LANG['change_type_user'][8] = '修改会员登录密码';
$_LANG['change_type_user'][9] = '修改会员信用额度';
$_LANG['no_record_selected'] = "请选择删除项";
$_LANG['batch_drop_ok'] = "批量删除成功";
$_LANG['js_languages']['remove_log_confirm'] = '您确定要删除该会员操作日志吗？';
?>
