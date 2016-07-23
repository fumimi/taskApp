<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->script('postcode.js');
$view->heading('アドレス帳');
$pagination = new Pagination(array('folder'=>$_GET['folder']));
?>
<div class="contentcontrol">
	<h1>アドレス帳<?=$view->caption($hash['folder'], array('all'=>'すべて表示'))?></h1>
	<table class="addressbooktype" cellspacing="0"><tr>
		<td><a class="current" href="index.php">個人</a></td>
		<td><a href="company.php">法人</a></td>
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
<?php
if ($view->permitted($hash['category'], 'add')) {
	echo '<li><a href="add.php'.$view->parameter(array('folder'=>$_GET['folder'])).'">アドレス追加</a></li>';
}
if (count($hash['list']) <= 0) {
	$attribute = ' onclick="alert(\'出力するデータがありません。\');return false;"';
}
?>
	<li><a href="csv.php<?=$view->parameter(array('sort'=>$_GET['sort'], 'desc'=>$_GET['desc'], 'search'=>$_GET['search'], 'folder'=>$_GET['folder'], 'type'=>0))?>"<?=$attribute?>>CSV出力</a></li>
</ul>
<?=$view->searchform(array('folder'=>$_GET['folder']))?>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<?=$view->category($hash['folder'], 'addressbook')?>
</td><td>
	<table class="list" cellspacing="0">
		<tr><th><?=$pagination->sortby('addressbook_name', '名前')?></th>
		<th><?=$pagination->sortby('addressbook_postcode', '郵便番号')?></th>
		<th><?=$pagination->sortby('addressbook_address', '住所')?></th>
		<th><?=$pagination->sortby('addressbook_phone', '電話番号')?></th></tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
		<tr><td><a href="view.php?id=<?=$row['id']?>"><?=$row['addressbook_name']?></a>&nbsp;</td>
		<td><?=$row['addressbook_postcode']?>&nbsp;</td>
		<td><?=$row['addressbook_address']?>&nbsp;</td>
		<td><?=$row['addressbook_phone']?>&nbsp;</td></tr>
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