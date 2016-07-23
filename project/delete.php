<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('プロジェクト削除');
?>
<h1>プロジェクト削除</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記のプロジェクトを削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>タイトル</th><td><?=$hash['data']['project_title']?>&nbsp;</td></tr>
		<tr><th>開始</th><td><?=date('Y/m/d', strtotime($hash['data']['project_begin']))?>&nbsp;</td></tr>
		<tr><th>終了</th><td><?=date('Y/m/d', strtotime($hash['data']['project_end']))?>&nbsp;</td></tr>
		<tr><th>内容</th><td><?=nl2br($hash['data']['project_comment'])?>&nbsp;</td></tr>
		<tr><th>カテゴリ</th><td><?=$hash['folder'][$hash['data']['folder_id']]?>&nbsp;</td></tr>
	</table>
	<?=$view->property($hash['data'])?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>