<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ブックマーク詳細');
?>
<h1>ブックマーク詳細</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>">一覧に戻る</a></li>
<?php
if ($view->permitted($hash['category'], 'add') && $view->permitted($hash['data'], 'edit')) {
	echo '<li><a href="edit.php?id='.$hash['data']['id'].'">編集</a></li>';
	echo '<li><a href="delete.php?id='.$hash['data']['id'].'">削除</a></li>';
}
?>
</ul>
<table class="view" cellspacing="0">
	<tr><th>タイトル</th><td><a href="<?=$hash['data']['bookmark_url']?>" target="_blank"><?=$hash['data']['bookmark_title']?></a>&nbsp;</td></tr>
	<tr><th>URL</th><td><a href="<?=$hash['data']['bookmark_url']?>" target="_blank"><?=$hash['data']['bookmark_url']?></a>&nbsp;</td></tr>
	<tr><th>備考</th><td><?=nl2br($hash['data']['bookmark_comment'])?>&nbsp;</td></tr>
	<tr><th>順序</th><td><?=$hash['data']['bookmark_order']?>&nbsp;</td></tr>
	<tr><th>カテゴリ</th><td><?=$hash['folder'][$hash['data']['folder_id']]?>&nbsp;</td></tr>
</table>
<?php
$view->property($hash['data']);
$view->footing();
?>