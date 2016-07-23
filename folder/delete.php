<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('フォルダ削除', $hash['data']['folder_type']);
?>
<h1>フォルダ削除</h1>
<ul class="operate">
	<li><a href="index.php?type=<?=$hash['data']['folder_type']?>">フォルダ一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記のフォルダを削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>フォルダ名</th><td><?=$hash['data']['folder_caption']?>&nbsp;</td></tr>
		<tr><th>順序</th><td><?=$hash['data']['folder_order']?>&nbsp;</td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php?type=<?=$hash['data']['folder_type']?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>