<?php

require_once('../application/loader.php');
$view->heading('ファイル共有');
$pagination = new Pagination(array('folder'=>$_GET['folder']));
$current[intval($_GET['folder'])] = ' class="current"';
if (strlen($hash['folder'][$_GET['folder']]) > 0) {
	$caption = ' - '.$hash['folder'][$_GET['folder']];
}
?>
<h1>ファイル共有<?=$caption?></h1>
<ul class="operate">
<?php
if ($view->permitted($hash['parent'], 'add')) {
	echo '<li><a href="add.php'.$view->positive(array('folder'=>$_GET['folder'])).'">ファイルアップロード</a></li>';
	echo '<li><a href="folderadd.php'.$view->positive(array('folder'=>$_GET['folder'])).'">フォルダ追加</a></li>';
}
?>
</ul>
<form method="post" class="searchform" action="<?=$_SERVER['SCRIPT_NAME']?><?=$view->positive(array('folder'=>$_GET['folder']))?>">
	<input type="text" name="search" id="search" class="inputsearch" value="<?=$view->escape($_REQUEST['search'])?>" /><input type="submit" value="検索" />
</form>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<div class="folder">
		<div class="foldercaption">フォルダ</div>
		<ul class="folderlist">
<?php
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	if ($_GET['folder'] > 0) {
		echo '<li class="storageprevious"><a href="index.php'.$view->positive(array('folder'=>$hash['parent']['storage_folder'])).'">上へ</a></li>';
	}
	foreach ($hash['folder'] as $key => $value) {
		echo sprintf('<li%s><a href="index.php?folder=%s">%s</a></li>', $current[$key], $key, $value);
	}
} else {
	echo '<li class="current"><a href="index.php">ルート</a></li>';
}
?>
		</ul>
	</div>
</td><td>
	<table class="list" cellspacing="0">
		<tr><th><?=$pagination->sortby('storage_title', 'タイトル')?></th>
		<th><?=$pagination->sortby('storage_file', 'ファイル名')?></th>
		<th><?=$pagination->sortby('storage_size', 'サイズ')?></th>
		<th><?=$pagination->sortby('storage_name', '名前')?></th>
		<th style="width:140px;"><?=$pagination->sortby('storage_date', '日時')?></th>
		<th class="listlink">&nbsp;</th></tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
		if ($row['storage_type'] == 'file') {
			$url = 'view.php?id='.$row['id'];
			$file = '<a href="download.php?id='.$row['id'].'&file='.urlencode($row['storage_file']).'">'.$row['storage_file'].'</a>';
			$property = $url;
		} else {
			$url = 'index.php?folder='.$row['id'];
			$property = 'folderview.php?id='.$row['id'];
		}
?>
		<tr><td><a class="storage<?=$row['storage_type']?>" href="<?=$url?>"><?=$row['storage_title']?></a>&nbsp;</td>
		<td><?=$file?></a>&nbsp;</td>
		<td><?=$row['storage_size']?>&nbsp;</td>
		<td><?=$row['storage_name']?>&nbsp;</td>
		<td><?=date('Y/m/d H:i:s', strtotime($row['storage_date']))?>&nbsp;</td>
		<td><a href="<?=$property?>">詳細</a>&nbsp;</td></tr>
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