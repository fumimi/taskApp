<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('application/loader.php');
$view->heading('管理画面', 'administration');
?>
<h1>管理画面</h1>
<?php
if (file_exists('setup.php')) {
	echo $view->error($hash['error']);
?>
<form class="content" method="post" action="">
	<input type="submit" value="　削除　" />
</form>
<?php
}
?>
<ul class="itemlink" style="padding-top:20px;">
	<li><a href="user/"><img src="images/arrownext.gif" />ユーザー管理</a></li>
<?php
if ($view->authorize('administrator')) {
	echo '<li><a href="group/"><img src="images/arrownext.gif" />グループ管理</a></li>';
}
?>
	<li><a href="folder/category.php"><img src="images/arrownext.gif" />カテゴリ管理</a></li>
	<li><a href="timecard/group.php"><img src="images/arrownext.gif" />タイムカード管理</a></li>
<?php
if ($view->authorize('administrator') && file_exists('administration')) {
	echo '<li><a href="administration/"><img src="images/arrownext.gif" />データベース管理</a></li>';
	echo '<li><a href="administration/upload.php"><img src="images/arrownext.gif" />アップロードファイル管理</a></li>';
}
?>
</ul>
<?php
$view->footing();
?>