<?php

require_once('../application/loader.php');
$view->heading('フォルダ削除');
$add = array('許可', '登録者のみ');
if ($hash['data']['add_level'] == 2) {
	$add[2] = $view->permitlist($hash['data'], 'add');
}
?>
<h1>フォルダ削除</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['storage_folder']))?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記のフォルダを削除します。<br />フォルダを削除するとフォルダ内のデータはすべて削除されます。')?>
	<table class="view" cellspacing="0">
		<tr><th>フォルダ名</th><td><?=$hash['data']['storage_title']?>&nbsp;</td></tr>
		<tr><th>場所</th><td><?=$hash['folder']['storage_title']?>&nbsp;</td></tr>
		<tr><th>名前</th><td><?=$hash['data']['storage_name']?>&nbsp;</td></tr>
		<tr><th>日時</th><td><?=date('Y/m/d H:i:s', strtotime($hash['data']['storage_date']))?>&nbsp;</td></tr>
		<tr><th>書き込み権限</th><td><?=$add[$hash['data']['add_level']]?>&nbsp;</td></tr>
	</table>
	<?=$view->property($hash['data'])?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='<?=$view->positive(array('folder'=>$hash['data']['storage_folder']))?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>