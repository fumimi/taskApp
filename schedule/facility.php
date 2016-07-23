<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('施設');
$pagination = new Pagination;
?>
<h1>施設設定</h1>
<ul class="operate">
	<li><a href="../schedule/facilityweek.php">施設予約に戻る</a></li>
	<li><a href="facilityadd.php">施設追加</a></li>
</ul>
<table class="list" cellspacing="0">
	<tr><th><?=$pagination->sortby('folder_caption', '施設名')?></th>
	<th><?=$pagination->sortby('folder_name', '登録者')?></th>
	<th><?=$pagination->sortby('folder_date', '登録日')?></th>
	<th><?=$pagination->sortby('folder_order', '順序')?></th>
	<th class="listlink">&nbsp;</th><tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
	<tr><td><a href="facilityview.php?id=<?=$row['id']?>"><?=$row['folder_caption']?></a>&nbsp;</td>
	<td><?=$row['folder_name']?>&nbsp;</td>
	<td><?=date('Y/m/d H:i:s', strtotime($row['folder_date']))?>&nbsp;</td>
	<td><?=$row['folder_order']?>&nbsp;</td>
	<td><a href="facilityedit.php?id=<?=$row['id']?>">編集</a>&nbsp;</td>
<?php
	}
}
?>
</table>
<?php
$view->pagination($pagination, $hash['count']);
$view->footing();
?>