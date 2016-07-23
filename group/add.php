<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('グループ追加', 'administration');
?>
<h1>グループ追加</h1>
<ul class="operate">
	<li><a href="index.php">グループ一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>グループ名<span class="necessary">(必須)</span></th><td><input type="text" name="group_name" class="inputvalue" value="<?=$hash['data']['group_name']?>" /></td></tr>
		<tr><th>順序</th><td><input type="text" name="group_order" class="inputnumeric" value="<?=$hash['data']['group_order']?>" /></td></tr>
		<tr><th>書き込み権限<?=$view->explain('groupadd')?></th><td><?=$view->permit($hash['data'], 'add')?></td></tr>
		<tr><th>編集設定<?=$view->explain('groupedit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php'" />
	</div>
</form>
<?php
$view->footing();
?>