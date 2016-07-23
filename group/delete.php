<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('グループ削除', 'administration');
$add = array('許可', '登録者のみ');
if ($hash['data']['add_level'] == 2) {
	$add[2] = $view->permitlist($hash['data'], 'add');
}
?>
<h1>グループ削除</h1>
<ul class="operate">
	<li><a href="index.php">グループ一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記のグループを削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>グループ名</th><td><?=$hash['data']['group_name']?>&nbsp;</td></tr>
		<tr><th>順序</th><td><?=$hash['data']['group_order']?>&nbsp;</td></tr>
		<tr><th>書き込み権限</th><td><?=$add[$hash['data']['add_level']]?>&nbsp;</td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>