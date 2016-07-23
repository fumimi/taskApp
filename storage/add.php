<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ファイルアップロード');
?>
<h1>ファイルアップロード</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$_GET['folder']))?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="" enctype="multipart/form-data">
	<input name="MAX_FILE_SIZE" value="<?=APP_FILESIZE?>" type="hidden" />
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>ファイル<span class="necessary">(必須)</span></th><td>
<?php
if (strlen($hash['data']['storage_file']) > 0) {
	echo '<input type="checkbox" name="uploadedfile[]" id="uploadedfile" value="'.$hash['data']['storage_file'].'" checked="checked" onclick="Storage.uploadfile(this)" /><label for="uploadedfile">'.$hash['data']['storage_file'].'</label>';
} else {
	echo '<input type="file" name="uploadfile[]" class="inputfile" size="70" />';
}
?>
		</td></tr>
		<tr><th>タイトル<span class="necessary">(必須)</span></th><td><input type="text" name="storage_title" class="inputtitle" value="<?=$hash['data']['storage_title']?>" /></td></tr>
		<tr><th>内容</th><td><textarea name="storage_comment" class="inputcomment" rows="5"><?=$hash['data']['storage_comment']?></textarea></td></tr>
		<tr><th>場所</th><td><?=$hash['folder']['storage_title']?></td></tr>
		<tr><th>公開設定<?=$view->explain('public')?></th><td><?=$view->permit($hash['data'])?></td></tr>
		<tr><th>編集設定<?=$view->explain('edit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->positive(array('folder'=>$_GET['folder']))?>'" />
	</div>
</form>
<?php
$view->footing();
?>