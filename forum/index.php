<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('フォーラム');
$pagination = new Pagination(array('folder'=>$_GET['folder']));
if (strlen($_GET['folder']) <= 0 || $_GET['folder'] == 'all') {
	$current['all'] = ' class="current"';
} else {
	$current[intval($_GET['folder'])] = ' class="current"';
}
?>
<h1>フォーラム<?=$view->caption($hash['folder'], array(0=>'全般'))?></h1>
<ul class="operate">
<?php
if ($view->permitted($hash['category'], 'add')) {
	echo '<li><a href="add.php'.$view->parameter(array('folder'=>$_GET['folder'])).'">スレッド作成</a></li>';
}
?>
</ul>
<?=$view->searchform(array('folder'=>$_GET['folder']))?>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<div class="folder">
		<div class="foldercaption">カテゴリ</div>
		<ul class="folderlist">
			<li<?=$current['all']?>><a href="index.php">最新一覧</a></li>
			<li<?=$current[0]?>><a href="index.php?folder=0">全般</a></li>
<?php
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	foreach ($hash['folder'] as $key => $value) {
		echo '<li'.$current[$key].'><a href="index.php?folder='.$key.'">'.$value.'</a></li>';
	}
}
echo '</ul>';
if ($view->authorize('administrator', 'manager', 'editor')) {
	echo '<div class="folderoperate"><a href="../folder/category.php?type=forum">編集</a></div>';
}
?>
	</div>
</td><td>
	<table class="list visited" cellspacing="0">
		<tr><th><?=$pagination->sortby('forum_title', 'タイトル')?></th>
		<th><?=$pagination->sortby('forum_name', '名前')?></th>
		<th><?=$pagination->sortby('forum_node', 'コメント')?></th>
		<th><?=$pagination->sortby('forum_lastupdate', '最終更新日')?></th>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
		<tr><td><a href="view.php?id=<?=$row['id']?>"><?=$row['forum_title']?></a>&nbsp;</td>
		<td><?=$row['forum_name']?>&nbsp;</td>
		<td><?=intval($row['forum_node'])?>&nbsp;</td>
		<td><?=date('Y/m/d H:i:s', strtotime($row['forum_lastupdate']))?>&nbsp;</td></tr>
<?php
	}
}
?>
	</table>
	<?=$view->pagination($pagination, $hash['count']);?>
</td></tr></table>
<?php
$view->footing();
?>