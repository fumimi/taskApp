<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('フォルダ編集', $hash['data']['folder_type']);
?>
<h1>フォルダ編集</h1>
<ul class="operate">
	<li><a href="index.php?type=<?=$hash['data']['folder_type']?>">フォルダ一覧に戻る</a></li>
	<li><a href="delete.php?id=<?=$hash['data']['id']?>">削除</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>フォルダ名<span class="necessary">(必須)</span></th><td><input type="text" name="folder_caption" class="inputtitle" value="<?=$hash['data']['folder_caption']?>" /></td></tr>
		<tr><th>順序</th><td><input type="text" name="folder_order" class="inputnumeric" value="<?=$hash['data']['folder_order']?>" /></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　編集　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php?type=<?=$hash['data']['folder_type']?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>