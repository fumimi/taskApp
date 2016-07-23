<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('施設詳細');
$add = array('許可', '登録者のみ');
if ($hash['data']['add_level'] == 2) {
	$add[2] = $view->permitlist($hash['data'], 'add');
}
?>
<h1>施設詳細</h1>
<ul class="operate">
	<li><a href="facility.php">施設一覧に戻る</a></li>
<?php
if ($view->permitted($hash['data'], 'edit')) {
	echo '<li><a href="facilityedit.php?id='.$hash['data']['id'].'">編集</a></li>';
	echo '<li><a href="facilitydelete.php?id='.$hash['data']['id'].'">削除</a></li>';
}
?>
</ul>
<table class="view" cellspacing="0">
	<tr><th>施設名</th><td><?=$hash['data']['folder_caption']?>&nbsp;</td></tr>
	<tr><th>名前</th><td><?=$hash['data']['folder_name']?>&nbsp;</td></tr>
	<tr><th>日付</th><td><?=date('Y/m/d H:i:s', strtotime($hash['data']['folder_date']))?>&nbsp;</td></tr>
	<tr><th>順序</th><td><?=$hash['data']['folder_order']?>&nbsp;</td></tr>
	<tr><th>予約権限</th><td><?=$add[$hash['data']['add_level']]?>&nbsp;</td></tr>
</table>
<?php
$view->property($hash['data']);
$view->footing();
?>