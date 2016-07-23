<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('施設編集');
?>
<h1>施設編集</h1>
<ul class="operate">
	<li><a href="facility.php">施設一覧に戻る</a></li>
	<li><a href="facilitydelete.php?id=<?=$hash['data']['id']?>">削除</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>施設名<span class="necessary">(必須)</span></th><td><input type="text" name="folder_caption" class="inputtitle" value="<?=$hash['data']['folder_caption']?>" /></td></tr>
		<tr><th>順序</th><td><input type="text" name="folder_order" class="inputnumeric" value="<?=$hash['data']['folder_order']?>" /></td></tr>
		<tr><th>予約権限<?=$view->explain('facilityadd')?></th><td><?=$view->permit($hash['data'], 'add', array('許可', '登録者のみ', '許可するグループ・ユーザーを設定'))?></td></tr>
		<tr><th>公開設定<?=$view->explain('public')?></th><td><?=$view->permit($hash['data'], 'public', array(0=>'公開', 2=>'公開するグループ・ユーザーを設定'))?></td></tr>
		<tr><th>編集設定<?=$view->explain('facilityedit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　編集　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='facility.php'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>