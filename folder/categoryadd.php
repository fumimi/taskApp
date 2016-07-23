<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('カテゴリ追加', $_GET['type']);
$hash['data']['folder_type'] = $view->initialize($hash['data']['folder_type'], $_GET['type']);
?>
<h1>カテゴリ追加</h1>
<ul class="operate">
	<li><a href="category.php?type=<?=$_GET['type']?>">カテゴリ一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>カテゴリ名<span class="necessary">(必須)</span></th><td><input type="text" name="folder_caption" class="inputtitle" value="<?=$hash['data']['folder_caption']?>" /></td></tr>
		<tr><th>順序</th><td><input type="text" name="folder_order" class="inputnumeric" value="<?=$hash['data']['folder_order']?>" /></td></tr>
		<tr><th>書き込み権限<?=$view->explain('add')?></th><td><?=$view->permit($hash['data'], 'add', array('許可', '登録者のみ', '許可するグループ・ユーザーを設定'))?></td></tr>
		<tr><th>公開設定<?=$view->explain('categorypublic')?></th><td><?=$view->permit($hash['data'], 'public', array(0=>'公開', 2=>'公開するグループ・ユーザーを設定'))?></td></tr>
		<tr><th>編集設定<?=$view->explain('categoryedit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='category.php?type=<?=$_GET['type']?>'" />
	</div>
	<input type="hidden" name="folder_type" value="<?=$hash['data']['folder_type']?>" />
</form>
<?php
$view->footing();
?>