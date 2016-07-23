<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ブックマーク編集');
$hash['folder'] = array('&nbsp;') + $hash['folder'];
?>
<h1>ブックマーク編集</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>">一覧に戻る</a></li>
	<li><a href="delete.php?id=<?=$hash['data']['id']?>">削除</a></li>
</ul>
<form class="content" method="post" name="bookmark" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>タイトル<span class="necessary">(必須)</span></th><td><input type="text" name="bookmark_title" class="inputtitle" value="<?=$hash['data']['bookmark_title']?>" /></td></tr>
		<tr><th>URL<span class="necessary">(必須)</span></th><td><input type="text" name="bookmark_url" class="inputtitle" value="<?=$hash['data']['bookmark_url']?>" /></td></tr>
		<tr><th>備考</th><td><textarea name="bookmark_comment" class="inputcomment" rows="5"><?=$hash['data']['bookmark_comment']?></textarea></td></tr>
		<tr><th>順序</th><td><input type="text" name="bookmark_order" class="inputnumeric" value="<?=$hash['data']['bookmark_order']?>" /></td></tr>
		<tr><th>カテゴリ</th><td><?=$helper->selector('folder_id', $hash['folder'], $hash['data']['folder_id'])?></td></tr>
		<tr><th>公開設定<?=$view->explain('public')?></th><td><?=$view->permit($hash['data'])?></td></tr>
		<tr><th>編集設定<?=$view->explain('edit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　編集　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>