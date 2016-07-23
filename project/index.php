<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('プロジェクト');
$pagination = new Pagination(array('folder'=>$_GET['folder']));
if ($_GET['folder'] == 'all') {
	$current['all'] = ' class="current"';
} elseif (strlen($_GET['folder']) <= 0) {
	$current['top'] = ' class="current"';
} else {
	$current[intval($_GET['folder'])] = ' class="current"';
}
?>
<h1>プロジェクト<?=$view->caption($hash['folder'], array(0=>'全般', 'all'=>'すべて表示'))?></h1>
<ul class="operate">
<?php
if ($view->permitted($hash['category'], 'add')) {
	echo '<li><a href="add.php'.$view->parameter(array('folder'=>$_GET['folder'])).'">プロジェクト追加</a></li>';
}
?>
</ul>
<?=$view->searchform(array('folder'=>$_GET['folder']))?>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<div class="folder">
		<div class="foldercaption">カテゴリ</div>
		<ul class="folderlist">
			<li<?=$current['top']?>><a href="index.php">進行中一覧</a></li>
			<li<?=$current[0]?>><a href="index.php?folder=0">全般</a></li>
<?php
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	foreach ($hash['folder'] as $key => $value) {
		echo '<li'.$current[$key].'><a href="index.php?folder='.$key.'">'.$value.'</a></li>';
	}
}
?>
			<li<?=$current['all']?>><a href="index.php?folder=all">すべて表示</a></li>
		</ul>
<?php
if ($view->authorize('administrator', 'manager', 'editor')) {
	echo '<div class="folderoperate"><a href="../folder/category.php?type=project">編集</a></div>';
}
?>
	</div>
</td><td>
	<table class="list" cellspacing="0">
		<tr><th><?=$pagination->sortby('project_title', 'タイトル')?></th>
		<th><?=$pagination->sortby('project_begin', '開始')?></th>
		<th><?=$pagination->sortby('project_end', '終了')?></th>
		<th><?=$pagination->sortby('project_name', '名前')?></th></tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
		<tr><td><a href="view.php?id=<?=$row['id']?>"><?=$row['project_title']?></a>&nbsp;</td>
		<td><?=date('Y/m/d', strtotime($row['project_begin']))?>&nbsp;</td>
		<td><?=date('Y/m/d', strtotime($row['project_end']))?>&nbsp;</td>
		<td><?=$row['project_name']?>&nbsp;</td></tr>
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