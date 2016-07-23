<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('タスク詳細');
if (strlen($hash['user'][$hash['data']['editor']]) > 0) {
	$editor = '<tr><td>編集者：</td><td>'.$hash['user'][$hash['data']['editor']].'&nbsp;('.date('Y/m/d H:i:s', strtotime($hash['data']['updated'])).')</td></tr>';
}
?>
<h1>タスク詳細</h1>
<ul class="operate">
	<li><a href="view.php?id=<?=intval($hash['data']['project_parent'])?>">タスク一覧に戻る</a></li>
<?php
if ($view->permitted($hash['parent'], 'edit')) {
	echo '<li><a href="taskedit.php?id='.$hash['data']['id'].'">編集</a></li>';
	echo '<li><a href="taskdelete.php?id='.$hash['data']['id'].'">削除</a></li>';
}
?>
</ul>
<table class="view" cellspacing="0">
	<tr><th>プロジェクト</th><td><?=$hash['parent']['project_title']?>&nbsp;</td></tr>
	<tr><th>タスク</th><td><?=$hash['data']['project_title']?>&nbsp;</td></tr>
	<tr><th>開始</th><td><?=date('Y/m/d', strtotime($hash['data']['project_begin']))?>&nbsp;</td></tr>
	<tr><th>終了</th><td><?=date('Y/m/d', strtotime($hash['data']['project_end']))?>&nbsp;</td></tr>
	<tr><th>進捗</th><td><form method="post" action="">
<?php
if ($view->permitted($hash['category'], 'add') && $view->permitted($hash['parent'], 'edit')) {
	$option = array(0=>0, 10=>10, 20=>20, 30=>30, 40=>40, 50=>50, 60=>60, 70=>70, 80=>80, 90=>90, 100=>100);
	echo $helper->selector('project_progress', $option, $hash['data']['project_progress'], ' onchange="this.parentNode.submit()"').'&nbsp;％';
} else {
	echo intval($hash['data']['project_progress']).'&nbsp;％';
}
?>
	</form></td></tr>
	<tr><th>内容</th><td>
		<?=nl2br($hash['data']['project_comment'])?>
		<?=$view->attachment($hash['data']['id'], 'project', $hash['data']['owner'].'_'.strtotime($hash['data']['project_date']), $hash['data']['project_file'])?>
	&nbsp;</td></tr>
</table>
<table class="property" cellspacing="0">
	<tr><td>登録者：</td><td><?=$hash['user'][$hash['data']['owner']]?>&nbsp;(<?=date('Y/m/d H:i:s', strtotime($hash['data']['created']))?>)</td></tr>
	<?=$editor?>
</table>
<?php
$view->footing();
?>