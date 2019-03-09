<?php
/**
 * 跳转衔接
 */

$url = $_GET['redirect'];
echo '<script type="text/javascript"> window.location.href="'.urldecode($url).'"; </script>';
