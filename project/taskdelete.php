<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('タスク削除');
if (strlen($hash['user'][$hash['data']['editor']]) > 0) {
	$editor = '<tr><td>編集者：</td><td>'.$hash['user'][$hash['data']['editor']].'&nbsp;('.date('Y/m/d H:i:s', strtotime($hash['data']['updated'])).')</td></tr>';
}
?>
<h1>タスク削除</h1>
<ul class="operate">
	<li><a href="view.php?id=<?=intval($hash['data']['project_parent'])?>">タスク一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記のタスクを削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>プロジェクト</th><td><?=$hash['parent']['project_title']?>&nbsp;</td></tr>
		<tr><th>タスク</th><td><?=$hash['data']['project_title']?>&nbsp;</td></tr>
		<tr><th>開始</th><td><?=date('Y/m/d', strtotime($hash['data']['project_begin']))?>&nbsp;</td></tr>
		<tr><th>終了</th><td><?=date('Y/m/d', strtotime($hash['data']['project_end']))?>&nbsp;</td></tr>
		<tr><th>内容</th><td><?=nl2br($hash['data']['project_comment'])?>&nbsp;</td></tr>
	</table>
	<table class="property" cellspacing="0">
		<tr><td>登録者：</td><td><?=$hash['user'][$hash['data']['owner']]?>&nbsp;(<?=date('Y/m/d H:i:s', strtotime($hash['data']['created']))?>)</td></tr>
		<?=$editor?>
	</table>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='view.php?id=<?=intval($hash['data']['project_parent'])?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>