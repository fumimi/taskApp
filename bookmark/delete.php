<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ブックマーク削除');
?>
<h1>ブックマーク削除</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記のブックマークを削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>タイトル</th><td><?=$hash['data']['bookmark_title']?></td></tr>
		<tr><th>URL</th><td><?=$hash['data']['bookmark_url']?></td></tr>
		<tr><th>備考</th><td><?=nl2br($hash['data']['bookmark_comment'])?></td></tr>
		<tr><th>順序</th><td><?=$hash['data']['bookmark_order']?>&nbsp;</td></tr>
		<tr><th>カテゴリ</th><td><?=$hash['folder'][$hash['data']['folder_id']]?></td></tr>
	</table>
	<?=$view->property($hash['data'])?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>