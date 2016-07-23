<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('施設削除');
$add = array('許可', '登録者のみ');
if ($hash['data']['add_level'] == 2) {
	$add[2] = $view->permitlist($hash['data'], 'add');
}
?>
<h1>施設削除</h1>
<ul class="operate">
	<li><a href="facility.php">施設一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記の施設を削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>施設名</th><td><?=$hash['data']['folder_caption']?>&nbsp;</td></tr>
		<tr><th>名前</th><td><?=$hash['data']['folder_name']?>&nbsp;</td></tr>
		<tr><th>日付</th><td><?=date('Y/m/d H:i:s', strtotime($hash['data']['folder_date']))?>&nbsp;</td></tr>
		<tr><th>順序</th><td><?=$hash['data']['folder_order']?>&nbsp;</td></tr>
		<tr><th>予約権限</th><td><?=$add[$hash['data']['add_level']]?>&nbsp;</td></tr>
	</table>
	<?=$view->property($hash['data'])?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='facility.php'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>