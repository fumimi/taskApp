<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ユーザー削除', 'administration');
$option['authority'] = array('member'=>'メンバー', 'editor'=>'編集者', 'manager'=>'マネージャ', 'administrator'=>'管理者');
?>
<h1>ユーザー削除</h1>
<ul class="operate">
	<li><a href="index.php?group=<?=$hash['data']['user_group']?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記のユーザーを削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>ユーザーID</th><td><?=$hash['data']['userid']?>&nbsp;</td></tr>
		<tr><th>名前</th><td><?=$hash['data']['realname']?>&nbsp;</td></tr>
		<tr><th>グループ</th><td><?=$hash['data']['user_groupname']?>&nbsp;</td></tr>
		<tr><th>権限</th><td><?=$option['authority'][$hash['data']['authority']]?>&nbsp;</td></tr>
		<tr><th>順序</th><td><?=$hash['data']['user_order']?>&nbsp;</td></tr>
	</table>
	<?=$view->property($hash['data'])?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php?group=<?=$hash['data']['user_group']?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>