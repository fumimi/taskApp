<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ブックマーク追加');
$hash['data']['edit_level'] = $view->initialize($hash['data']['edit_level'], 0);
$hash['data']['folder_id'] = $view->initialize($hash['data']['folder_id'], $_GET['folder']);
$hash['folder'] = array('&nbsp;') + $hash['folder'];
?>
<h1>ブックマーク追加</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->parameter(array('folder'=>$_GET['folder']))?>">一覧に戻る</a></li>
</ul>
<?php
if (!isset($_GET['url'])) {
	if ($_GET['folder'] > 0) {
		$string = '<input type="hidden" name="folder" value="'.intval($_GET['folder']).'" />';
	}
?>
<form class="content" method="get" name="bookmark" action="">
	<table class="form" cellspacing="0">
		<tr><th style="width:80px;">URL</th><td><input type="text" name="url" class="inputtitle" value="" /></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　次へ　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->parameter(array('folder'=>$_GET['folder']))?>'" />
	</div>
	<?=$string?>
</form>
<?php
} else {
?>
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
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->parameter(array('folder'=>$_GET['folder']))?>'" />
	</div>
</form>
<?php
}
$view->footing();
?>