<?php

require_once('../application/loader.php');
$view->heading('ファイル情報');
?>
<h1>ファイル情報</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['storage_folder']))?>">一覧に戻る</a></li>
<?php
if ($view->permitted($hash['folder'], 'add') && $view->permitted($hash['data'], 'edit')) {
	echo '<li><a href="edit.php?id='.$hash['data']['id'].'">編集</a></li>';
	echo '<li><a href="delete.php?id='.$hash['data']['id'].'">削除</a></li>';
}
?>
</ul>
<table class="view" cellspacing="0">
	<tr><th>タイトル</th><td><?=$hash['data']['storage_title']?>&nbsp;</td></tr>
	<tr><th>ファイル名</th><td>
		<a href="download.php?id=<?=$hash['data']['id']?>&file=<?=urlencode($hash['data']['storage_file'])?>">
		<?=$hash['data']['storage_file']?>&nbsp;[ダウンロード]</a>
	</td></tr>
	<tr><th>ファイルサイズ</th><td><?=$hash['data']['storage_size']?>&nbsp;</td></tr>
	<tr><th>内容</th><td><?=nl2br($hash['data']['storage_comment'])?>&nbsp;</td></tr>
	<tr><th>場所</th><td><?=$hash['folder']['storage_title']?>&nbsp;</td></tr>
	<tr><th>名前</th><td><?=$hash['data']['storage_name']?>&nbsp;</td></tr>
	<tr><th>日時</th><td><?=date('Y/m/d H:i:s', strtotime($hash['data']['storage_date']))?>&nbsp;</td></tr>
</table>
<?php
$view->property($hash['data']);
$view->footing();
?>