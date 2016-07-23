<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ブックマーク');
$pagination = new Pagination(array('folder'=>$_GET['folder']));
?>
<h1>ブックマーク<?=$view->caption($hash['folder'], array('all'=>'すべて表示'))?></h1>
<ul class="operate">
<?php
if ($view->permitted($hash['category'], 'add')) {
	echo '<li><a href="add.php'.$view->parameter(array('folder'=>$_GET['folder'])).'">ブックマーク追加</a></li>';
}
?>
</ul>
<?=$view->searchform(array('folder'=>$_GET['folder']))?>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<?=$view->category($hash['folder'], 'bookmark')?>
</td><td>
	<table class="list visited" cellspacing="0">
		<tr><th><?=$pagination->sortby('bookmark_title', 'タイトル')?></th>
		<th><?=$pagination->sortby('bookmark_name', '名前')?></th>
		<th><?=$pagination->sortby('bookmark_date', '日時')?></th>
		<th class="listlink">&nbsp;</th></tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
		<tr><td><a href="<?=$row['bookmark_url']?>" target="_blank"><?=$row['bookmark_title']?></a>&nbsp;</td>
		<td><?=$row['bookmark_name']?>&nbsp;</td>
		<td><?=date('Y/m/d H:i:s', strtotime($row['bookmark_date']))?>&nbsp;</td>
		<td><a href="view.php?id=<?=$row['id']?>">詳細</a>&nbsp;</td></tr>
<?php
	}
}
?>
	</table>
	<?=$view->pagination($pagination, $hash['count'])?>
</td></tr></table>
<?php
$view->footing();
?>