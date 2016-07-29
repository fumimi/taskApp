<?php

require_once('../application/loader.php');
$add = array('許可', '登録者のみ');
if ($hash['data']['add_level'] == 2) {
	$add[2] = $view->permitlist($hash['data'], 'add');
}
$view->heading('フォルダ情報');
?>
<h1>フォルダ情報</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['storage_folder']))?>">一覧に戻る</a></li>
<?php
if ($view->permitted($hash['folder'], 'add') && $view->permitted($hash['data'], 'edit')) {
	echo '<li><a href="folderedit.php?id='.$hash['data']['id'].'">編集</a></li>';
	echo '<li><a href="folderdelete.php?id='.$hash['data']['id'].'">削除</a></li>';
}
?>
</ul>
<table class="view" cellspacing="0">
	<tr><th>フォルダ名</th><td><?=$hash['data']['storage_title']?>&nbsp;</td></tr>
	<tr><th>場所</th><td><?=$hash['folder']['storage_title']?>&nbsp;</td></tr>
	<tr><th>名前</th><td><?=$hash['data']['storage_name']?>&nbsp;</td></tr>
	<tr><th>日時</th><td><?=date('Y/m/d H:i:s', strtotime($hash['data']['storage_date']))?>&nbsp;</td></tr>
	<tr><th>書き込み権限</th><td><?=$add[$hash['data']['add_level']]?>&nbsp;</td></tr>
</table>
<?php
$view->property($hash['data']);
$view->footing();
?>