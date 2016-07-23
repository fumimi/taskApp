<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('メッセージ');
$pagination = new Pagination;
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	foreach ($hash['folder'] as $key => $value) {
		$option .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
?>
<h1>メッセージ - ゴミ箱</h1>
<ul class="operate">
	<li><a href="create.php">メッセージ作成</a></li>
	<li><span class="operator" onclick="Message.move('trash')">完全に削除</span></li>
	<li><span class="operator" onclick="Message.empty()">空にする</span></li>
	<li><select name="move" onchange="Message.move(this)"><option value="">フォルダ移動</option><option value="0">受信箱/送信済み</option><?=$option?></select></li>
</ul>
<?=$view->searchform()?>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<div class="folder paragraph">
		<div class="foldercaption">メッセージ</div>
		<ul class="folderlist">
			<li><a href="index.php">受信箱</a></li>
			<li><a href="index.php?folder=all">すべて表示</a></li>
			<li><a href="sent.php">送信済み</a></li>
			<li class="current"><a href="trash.php">ゴミ箱</a></li>
		</ul>
	</div>
	<div class="folder">
		<div class="foldercaption">フォルダ</div>
		
<?php
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	echo '<ul class="folderlist">';
	foreach ($hash['folder'] as $key => $value) {
		echo sprintf('<li%s><a href="index.php?folder=%s">%s</a></li>', $current[$key], $key, $value);
	}
	echo '</ul><div class="folderoperate"><a href="../folder/?type=message">編集</a></div>';
} else {
	echo '<ul><li><a href="../folder/add.php?type=message">フォルダ追加</a></ul>';
}
?>
	</div>
</td><td>
	<form method="post" name="checkedform" action="">
		<table class="list visited" cellspacing="0">
			<tr><th class="listcheck"><input type="checkbox" value="" onclick="App.checkall(this)" /></th>
			<th><?=$pagination->sortby('message_fromname', '差出人')?></th>
			<th><?=$pagination->sortby('message_title', '件名')?></th>
			<th style="width:140px;"><?=$pagination->sortby('message_date', '日時')?></th>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
			<tr><td class="listcheck"><input type="checkbox" name="checkedid[]" value="<?=$row['id']?>" /></td>
			<td><?=$row['message_fromname']?>&nbsp;</td>
			<td><a href="view.php?id=<?=$row['id']?>"><?=$row['message_title']?></a>&nbsp;</td>
			<td><?=date('Y/m/d H:i:s', strtotime($row['message_date']))?>&nbsp;</td></tr>
<?php
	}
}
?>
		</table>
		<?=$view->pagination($pagination, $hash['count']);?>
		<input type="hidden" name="folder" value="" />
	</form>
</td></tr></table>
<?php
$view->footing();
?>