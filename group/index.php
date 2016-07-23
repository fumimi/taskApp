<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('グループ', 'administration');
$pagination = new Pagination;
?>
<h1>グループ</h1>
<ul class="operate">
	<li><a href="../user/">ユーザー管理に戻る</a></li>
	<li><a href="add.php">グループ追加</a></li>
</ul>
<?=$view->searchform()?>
<table class="list" cellspacing="0" style="width:500px;">
	<tr><th><?=$pagination->sortby('group_name', 'グループ名')?></th>
	<th><?=$pagination->sortby('group_order', '順序')?></th>
	<th class="listlink">&nbsp;</th></tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
	<tr><td><a href="view.php?id=<?=$row['id']?>"><?=$row['group_name']?></a>&nbsp;</td>
	<td><?=$row['group_order']?>&nbsp;</td>
	<td><a href="edit.php?id=<?=$row['id']?>">編集</a></td></tr>
<?php
	}
}
?>
</table>
<?php
$view->pagination($pagination, $hash['count']);
$view->footing();
?>