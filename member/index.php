<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('メンバー情報');
$pagination = new Pagination(array('group'=>$_GET['group']));
if ($_GET['group'] == 'all') {
	$caption = ' - すべて表示';
} elseif (strlen($hash['group'][$_GET['group']]) > 0) {
	$caption = ' - '.$hash['group'][$_GET['group']];
}
?>
<h1>メンバー情報<?=$caption?></h1>
<ul class="operate">
	<li><a href="edit.php">個人設定</a></li>
</ul>
<?=$view->searchform(array('group'=>$_GET['group']))?>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<div class="folder">
		<div class="foldercaption">グループ</div>
		<ul class="folderlist">
<?php
$current[intval($_GET['group'])] = ' class="current"';
if (is_array($hash['group']) && count($hash['group']) > 0) {
	foreach ($hash['group'] as $key => $value) {
		echo '<li'.$current[$key].'><a href="index.php?group='.$key.'">'.$value.'</a></li>';
	}
}
?>
			<li<?=$current[0]?>><a href="index.php?group=all">すべて表示</a></li>
		</ul>
	</div>
</td><td>
	<table class="list" cellspacing="0">
		<tr><th><?=$pagination->sortby('realname', '名前')?></th>
		<th><?=$pagination->sortby('user_groupname', 'グループ')?></th>
		<th><?=$pagination->sortby('user_email', 'メールアドレス')?></th>
		<th><?=$pagination->sortby('user_skype', 'スカイプID')?></th>
		<th><?=$pagination->sortby('user_mobile', '携帯電話')?></th></tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
		<tr><td><a href="view.php?id=<?=$row['id']?>"><?=$row['realname']?></a>&nbsp;</td>
		<td><?=$row['user_groupname']?>&nbsp;</td>
		<td><a href="mailto:<?=$row['user_email']?>"><?=$row['user_email']?></a>&nbsp;</td>
		<td><?=$row['user_skype']?>&nbsp;</td>
		<td><?=$row['user_mobile']?>&nbsp;</td></tr>
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