<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('カテゴリ', $_GET['type']);
$pagination = new Pagination(array('type'=>$_GET['type']));
$type = array('forum'=>'フォーラム', 'addressbook'=>'アドレス帳', 'bookmark'=>'ブックマーク', 'facility'=>'施設予約', 'project'=>'プロジェクト');
if (strlen($_GET['type']) > 0) {
?>
<h1>カテゴリ</h1>
<ul class="operate">
	<li><a href="../<?=$_GET['type']?>/"><?=$type[$_GET['type']]?>に戻る</a></li>
	<li><a href="categoryadd.php?type=<?=$_GET['type']?>">カテゴリ追加</a></li>
</ul>
<table class="list" cellspacing="0">
	<tr><th><?=$pagination->sortby('folder_caption', 'カテゴリ名')?></th>
	<th><?=$pagination->sortby('folder_name', '登録者')?></th>
	<th><?=$pagination->sortby('folder_date', '登録日')?></th>
	<th><?=$pagination->sortby('folder_order', '順序')?></th>
	<th class="listlink">&nbsp;</th><tr>
<?php
	if (is_array($hash['list']) && count($hash['list']) > 0) {
		foreach ($hash['list'] as $row) {
?>
	<tr><td><a href="categoryview.php?id=<?=$row['id']?>"><?=$row['folder_caption']?></a>&nbsp;</td>
	<td><?=$row['folder_name']?>&nbsp;</td>
	<td><?=date('Y/m/d H:i:s', strtotime($row['folder_date']))?>&nbsp;</td>
	<td><?=$row['folder_order']?>&nbsp;</td>
	<td><a href="categoryedit.php?id=<?=$row['id']?>">編集</a>&nbsp;</td>
<?php
		}
	}
	echo '</table>';
	$view->pagination($pagination, $hash['count']);
} else {
$type = array('forum'=>'フォーラム', 'addressbook'=>'アドレス帳', 'bookmark'=>'ブックマーク', 'facility'=>'施設予約', 'project'=>'プロジェクト');
?>
<h1>カテゴリ管理</h1>
<ul class="operate">
	<li><a href="../administration.php">管理画面トップに戻る</a></li>
</ul>
<ul class="itemlink">
	<li><a href="category.php?type=forum"><img src="../images/arrownext.gif" />フォーラム</a></li>
	<li><a href="category.php?type=bookmark"><img src="../images/arrownext.gif" />ブックマーク</a></li>
	<li><a href="category.php?type=project"><img src="../images/arrownext.gif" />プロジェクト</a></li>
	<li><a href="category.php?type=addressbook"><img src="../images/arrownext.gif" />アドレス帳</a></li>
</ul>
<?php
}
$view->footing();
?>