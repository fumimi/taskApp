<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
if ($hash['data']['forum_parent'] <= 0) {
	$redirect = 'view.php?id='.$hash['data']['id'];
	$caption = 'スレッド';
} else {
	$redirect = 'view.php?id='.$hash['data']['forum_parent'];
	$caption = 'コメント';
}
$view->heading($caption.'編集');
?>
<h1><?=$caption?>編集</h1>
<ul class="operate">
	<li><a href="<?=$redirect?>">スレッドに戻る</a></li>
	<li><a href="delete.php?id=<?=$hash['data']['id']?>">削除</a></li>
</ul>
<form class="content" method="post" action="" enctype="multipart/form-data">
<?php
echo $view->error($hash['error']);
if ($hash['data']['forum_parent'] <= 0) {
	$hash['folder'] = array('&nbsp;') + $hash['folder'];
?>
	<table class="form" cellspacing="0">
		<tr><th>タイトル<span class="necessary">(必須)</span></th><td><input type="text" name="forum_title" class="inputtitle" value="<?=$hash['data']['forum_title']?>" /></td></tr>
		<tr><th>内容<span class="necessary">(必須)</span></th><td><textarea name="forum_comment" class="inputcomment" rows="20"><?=$hash['data']['forum_comment']?></textarea></td></tr>
		<tr><th>&nbsp;</th><td><?=$view->uploadfile($hash['data']['forum_file'])?></td></tr>
		<tr><th>カテゴリ</th><td><?=$helper->selector('folder_id', $hash['folder'], $hash['data']['folder_id'])?></td></tr>
		<tr><th>公開設定<?=$view->explain('categorypublic')?></th><td><?=$view->permit($hash['data'], 'public', array(0=>'公開', 2=>'公開するグループ・ユーザーを設定'))?></td></tr>
	</table>
<?php
} else {
?>
	<table class="form" cellspacing="0">
		<tr><th>内容<span class="necessary">(必須)</span></th><td><textarea name="forum_comment" class="inputcomment" rows="20"><?=$hash['data']['forum_comment']?></textarea></td></tr>
		<tr><th>&nbsp;</th><td><?=$view->uploadfile($hash['data']['forum_file'])?></td></tr>
	</table>
<?php
}
?>
	<div class="submit">
		<input type="submit" value="　編集　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='<?=$redirect?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
	<input type="hidden" name="forum_parent" value="<?=$hash['data']['forum_parent']?>" />
</form>
<?php
$view->footing();
?>