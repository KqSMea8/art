<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：wxpay.php
 * ----------------------------------------------------------------------------
 * 功能描述：微信支付插件
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */

/* 访问控制 */
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/llpay.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}

/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE) {
    $i = isset($modules) ? count($modules) : 0;
    /* 代码 */
    $modules[$i]['code'] = basename(__FILE__, '.php');
    /* 描述对应的语言项 */
    $modules[$i]['desc'] = 'llpay_desc';
    /* 是否支持货到付款 */
    $modules[$i]['is_cod'] = '0';
    /* 是否支持在线支付 */
    $modules[$i]['is_online'] = '1';
    /* 作者 */
    $modules[$i]['author'] = 'ECTOUCH TEAM';
    /* 网址 */
    $modules[$i]['website'] = 'http://open.lianlianpay.com';
    /* 版本号 */
    $modules[$i]['version'] = '1.2';
    /* 配置信息 */
    $modules[$i]['config'] = array(
        array('name' => 'version','type' => 'text','value' => '1.2'),//版本号
        array('name' => 'oid_partner', 'type' => 'text', 'value' => ''),//商户编号是商户在连连钱包支付平台上开设的商户号码，为18位数字，
        array('name' => 'RSA_PRIVATE_KEY','type' => 'textarea','value' => '' ),//秘钥格式注意不能修改（左对齐，右边有回车符）
        array('name' => 'key','type' => 'text','value' => ''),//安全检验码，以数字和字母组成的字符
        array( 'name' => 'valid_order','type' => 'text','value' => '10080'),//订单有效时间  分钟为单位，默认为10080分钟（7天）
        array( 'name' => 'app_request','type' => 'text','value' => '3'),//请求应用标识 为wap版本，不需修改
        array( 'name' => 'sign_type','type' => 'text','value' => 'RSA'),//签名方式 不需修改
        array( 'name' => 'input_charset','type' => 'text','value' => 'utf-8'),//字符编码格式 目前支持 gbk 或 utf-8
        array( 'name' => 'transport','type' => 'text','value' => 'https'),//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    );

    return;
}

/**
 * 连连支付类
 */
class llpay
{

    var $parameters; // cft 参数
    var $payment; // 配置信息
    /**
     * 生成支付代码
     *
     * @param array $order
     * 订单信息
     * @param array $payment
     * 支付方式信息
     */
    function get_code($order, $payment)
    {

    }

    /**
     * 响应操作
     */
    function respond()
    {
        if($_GET['status'] == 1){
            return true;
        }
        else{
            return false;
        }
    }




}