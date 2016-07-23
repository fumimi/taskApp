<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('フォルダ', $_GET['type']);
$pagination = new Pagination(array('type'=>$_GET['type']));
$type = array('message'=>'メッセージ', 'todo'=>'ToDo管理');
?>
<h1>フォルダ</h1>
<ul class="operate">
	<li><a href="../<?=$_GET['type']?>/"><?=$type[$_GET['type']]?>に戻る</a></li>
	<li><a href="add.php?type=<?=$_GET['type']?>">フォルダ追加</a></li>
</ul>
<table class="list" cellspacing="0" style="width:600px;">
	<tr><th><?=$pagination->sortby('folder_caption', 'フォルダ名')?></th>
	<th style="width:150px;"><?=$pagination->sortby('folder_date', '登録日')?></th>
	<th style="width:100px;"><?=$pagination->sortby('folder_order', '順序')?></th>
	<th class="listlink">&nbsp;</th><tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
	<tr><td><?=$row['folder_caption']?>&nbsp;</td>
	<td><?=date('Y/m/d H:i:s', strtotime($row['folder_date']))?>&nbsp;</td>
	<td><?=$row['folder_order']?>&nbsp;</td>
	<td><a href="edit.php?id=<?=$row['id']?>">編集</a>&nbsp;</td>
<?php
	}
}
?>
</table>
<?php
$view->pagination($pagination, $hash['count']);
$view->footing();
?>