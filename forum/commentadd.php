<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('コメント追加');
?>
<h1>コメント追加</h1>
<ul class="operate">
	<li><a href="view.php?id=<?=$hash['data']['forum_parent']?>">スレッドに戻る</a></li>
</ul>
<form class="content" method="post" action="" enctype="multipart/form-data">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><td><textarea name="forum_comment" class="inputcomment" rows="20"><?=$hash['data']['forum_comment']?></textarea></td></tr>
		<tr><td><?=$view->uploadfile($hash['data']['forum_file'])?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='view.php?id=<?=$hash['data']['forum_parent']?>'" />
	</div>
	<input type="hidden" name="forum_parent" value="<?=$hash['data']['forum_parent']?>" />
</form>
<?php
$view->footing();
?>