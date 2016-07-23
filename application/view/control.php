<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
if ($_SESSION['realname']) {
	$realname = $this->escape($_SESSION['realname']).'さん';
}
if ($this->authorize('administrator', 'manager')) {
	$administration = '<a'.$current['administration'].' href="'.$root.'administration.php">管理画面</a>';
}
?>
<div class="header">
	<div class="headertitle">
		<a href="<?=$root?>index.php"><img src="<?=$root?>images/title.gif" /></a>
	</div>
	<div class="headerright">
		<a href="<?=$root?>index.php"><?=$realname?></a><?=$administration?>
		<a href="<?=$root?>logout.php">ログアウト</a>
	</div>
	<div class="control">
		<table cellspacing="0"><tr>
			<td<?=$current['top']?>><a href="<?=$root?>index.php">トップ</a></td>
			<td<?=$current['schedule']?>><a href="<?=$root?>schedule/">スケジュール</a></td>
			<td<?=$current['message']?>><a href="<?=$root?>message/">メッセージ</a></td>
			<td<?=$current['todo']?>><a href="<?=$root?>todo/">ToDo</a></td>
			<td<?=$current['forum']?>><a href="<?=$root?>forum/">フォーラム</a></td>
			<td<?=$current['storage']?>><a href="<?=$root?>storage/">ファイル</a></td>
			<td<?=$current['bookmark']?>><a href="<?=$root?>bookmark/">ブックマーク</a></td>
			<td<?=$current['project']?>><a href="<?=$root?>project/">プロジェクト</a></td>
			<td<?=$current['addressbook']?>><a href="<?=$root?>addressbook/">アドレス帳</a></td>
			<td<?=$current['member']?>><a href="<?=$root?>member/">メンバー</a></td>
			<td<?=$current['timecard']?>><a href="<?=$root?>timecard/">タイムカード</a></td>
		</tr></table>
	</div>
</div>
<div class="container">