<?php

require_once('../application/loader.php');
$view->heading('フォルダ追加');
$hash['data']['storage_folder'] = $view->initialize($hash['data']['storage_folder'], intval($_REQUEST['folder']));
$hash['data']['public_level'] = $view->initialize($hash['data']['public_level'], $hash['folder']['public_level']);
$hash['data']['public_group'] = $view->initialize($hash['data']['public_group'], $hash['folder']['public_group']);
$hash['data']['public_user'] = $view->initialize($hash['data']['public_user'], $hash['folder']['public_user']);
$hash['data']['edit_level'] = $view->initialize($hash['data']['edit_level'], $hash['folder']['edit_level']);
$hash['data']['edit_group'] = $view->initialize($hash['data']['edit_group'], $hash['folder']['edit_group']);
$hash['data']['edit_user'] = $view->initialize($hash['data']['edit_user'], $hash['folder']['edit_user']);
$hash['data']['add_level'] = $view->initialize($hash['data']['add_level'], $hash['folder']['add_level']);
$hash['data']['add_group'] = $view->initialize($hash['data']['add_group'], $hash['folder']['add_group']);
$hash['data']['add_user'] = $view->initialize($hash['data']['add_user'], $hash['folder']['add_user']);
?>
<h1>フォルダ追加</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$_GET['folder']))?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>フォルダ名<span class="necessary">(必須)</span></th><td><input type="text" name="storage_title" class="inputtitle" value="<?=$hash['data']['storage_title']?>" /></td></tr>
		<tr><th>場所</th><td><?=$hash['folder']['storage_title']?></td></tr>
		<tr><th>書き込み権限<?=$view->explain('storageadd')?></th><td><?=$view->permit($hash['data'], 'add')?></td></tr>
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