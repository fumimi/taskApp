<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ユーザー編集', 'administration');
$option['authority'] = array('member'=>'メンバー', 'editor'=>'編集者', 'manager'=>'マネージャ', 'administrator'=>'管理者');
?>
<h1>ユーザー編集</h1>
<ul class="operate">
	<li><a href="index.php?group=<?=$hash['data']['user_group']?>">一覧に戻る</a></li>
	<li><a href="delete.php?id=<?=$hash['data']['id']?>">削除</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>ユーザーID<?=$view->explain('userid')?><span class="necessary">(必須)</span></th><td><input type="text" name="userid" class="inputvalue" value="<?=$hash['data']['userid']?>" /></td></tr>
		<tr><th>名前<span class="necessary">(必須)</span></th><td><input type="text" name="realname" class="inputvalue" value="<?=$hash['data']['realname']?>" /></td></tr>
		<tr><th>グループ<span class="necessary">(必須)</span></th><td><?=$helper->selector('user_group', $hash['folder'], $hash['data']['user_group'])?></td></tr>
		<tr><th>権限<?=$view->explain('userauthority')?><span class="necessary">(必須)</span></th><td><?=$helper->selector('authority', $option['authority'], $hash['data']['authority'])?></td></tr>
		<tr><th>順序</th><td><input type="text" name="user_order" class="inputnumeric" value="<?=$hash['data']['user_order']?>" /></td></tr>
		<tr><th>編集設定<?=$view->explain('useredit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<h2>パスワードの変更</h2>
	<table class="form" cellspacing="0">
		<tr><th>現在のパスワード</th><td><input type="password" name="password" class="inputvalue" /></td></tr>
		<tr><th>新しいパスワード<?=$view->explain('userpassword')?></th><td><input type="password" name="newpassword" class="inputvalue" /></td></tr>
		<tr><th>新しいパスワード（確認）&nbsp;</th><td><input type="password" name="confirmpassword" class="inputvalue" /></td></tr>
		<tr><th>&nbsp;</th><td><?=$helper->checkbox('resetpassword', 1, $hash['data']['resetpassword'], 'resetpassword', '初期登録時のパスワードに戻す')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　編集　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php?group=<?=$hash['data']['user_group']?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>