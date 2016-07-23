<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ユーザー管理', 'administration');
$pagination = new Pagination(array('group'=>$_GET['group']));
if ($_GET['group'] == 'all') {
	$caption = ' - すべて表示';
} elseif (strlen($hash['folder'][$_GET['group']]) > 0) {
	$caption = ' - '.$hash['folder'][$_GET['group']];
}
?>
<h1>ユーザー管理<?=$caption?></h1>
<ul class="operate">
<?php
if ($view->permitted($hash['parent'], 'add')) {
	echo '<li><a href="add.php'.$view->parameter(array('group'=>$_GET['group'])).'">ユーザー追加</a></li>';
}
?>
</ul>
<?=$view->searchform(array('group'=>$_GET['group']))?>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<div class="folder">
		<div class="foldercaption">グループ</div>
		<ul class="folderlist">
<?php
$current[intval($_GET['group'])] = ' class="current"';
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	foreach ($hash['folder'] as $key => $value) {
		echo '<li'.$current[$key].'><a href="index.php?group='.$key.'">'.$value.'</a></li>';
	}
}
?>
			<li<?=$current[0]?>><a href="index.php?group=all">すべて表示</a></li>
		</ul>
<?php
if ($view->authorize('administrator')) {
	echo '<div class="folderoperate"><a href="../group/">編集</a></div>';
}
?>
	</div>
</td><td>
	<?=$view->error($hash['error'])?>
	<form method="post" name="checkedform" action="">
		<table class="list" cellspacing="0">
			<tr><th><?=$pagination->sortby('userid', 'ユーザーID')?></th>
			<th><?=$pagination->sortby('realname', '名前')?></th>
			<th><?=$pagination->sortby('user_groupname', 'グループ')?></th>
			<th><?=$pagination->sortby('authority', '権限')?></th>
			<th><?=$pagination->sortby('user_order', '順序')?></th></tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	$option['authority'] = array('member'=>'メンバー', 'editor'=>'編集者', 'manager'=>'マネージャ', 'administrator'=>'管理者');
	foreach ($hash['list'] as $row) {
?>
			<tr><td><a href="view.php?id=<?=$row['id']?>"><?=$row['userid']?></a>&nbsp;</td>
			<td><?=$row['realname']?>&nbsp;</td>
			<td><?=$row['user_groupname']?>&nbsp;</td>
			<td><?=$option['authority'][$row['authority']]?>&nbsp;</td>
			<td><?=$row['user_order']?>&nbsp;</td></tr>
<?php
	}
}
?>
		</table>
		<?=$view->pagination($pagination, $hash['count'])?>
	</form>
</td></tr></table>
<?php
$view->footing();
?>