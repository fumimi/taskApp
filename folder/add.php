<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('フォルダ追加', $_GET['type']);
$hash['data']['folder_type'] = $view->initialize($hash['data']['folder_type'], $_GET['type']);
?>
<h1>フォルダ追加</h1>
<ul class="operate">
	<li><a href="index.php?type=<?=$_GET['type']?>">フォルダ一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>フォルダ名<span class="necessary">(必須)</span></th><td><input type="text" name="folder_caption" class="inputtitle" value="<?=$hash['data']['folder_caption']?>" /></td></tr>
		<tr><th>順序</th><td><input type="text" name="folder_order" class="inputnumeric" value="<?=$hash['data']['folder_order']?>" /></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php?type=<?=$_GET['type']?>'" />
	</div>
	<input type="hidden" name="folder_type" value="<?=$hash['data']['folder_type']?>" />
</form>
<?php
$view->footing();
?>