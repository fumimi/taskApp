<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require(dirname(__FILE__).'/controller.php');
$controller = new Controller;
$hash = $controller->dispatch();
$view = new ApplicationView($hash);
$helper = new Helper;
?>