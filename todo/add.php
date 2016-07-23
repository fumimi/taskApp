<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ToDo追加');
if (strlen($hash['data']['todo_term']) > 0) {
	$timestamp = strtotime($hash['data']['todo_term']);
} else {
	$timestamp = time();
}
if ($hash['data']['todo_noterm'] == 1) {
	$disabled = ' disabled="disabled"';
}
?>
<h1>ToDo追加</h1>
<ul class="operate">
	<li><a href="index.php">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>タイトル<span class="necessary">(必須)</span></th><td><input type="text" name="todo_title" class="inputtitle" value="<?=$hash['data']['todo_title']?>" /></td></tr>
		<tr><th>期限</th><td>
			<select name="todo_year"<?=$disabled?>><?=$helper->option(2000, 2020, date('Y', $timestamp))?></select>年&nbsp;
			<select name="todo_month"<?=$disabled?>><?=$helper->option(1, 12, date('n', $timestamp))?></select>月&nbsp;
			<select name="todo_day"<?=$disabled?>><?=$helper->option(1, 31, date('j', $timestamp))?></select>日&nbsp;
			<?=$helper->checkbox('todo_noterm', 1, $hash['data']['todo_noterm'], 'todo_noterm', '期限なし', 'onclick="Todo.noterm(this)"')?>
		</td></tr>
		<tr><th>重要度</th><td><?=$helper->selector('todo_priority', array('', '重要', '最重要'), $hash['data']['todo_priority'])?></td></tr>
		<tr><th>備考</th><td><textarea name="todo_comment" class="inputcomment" rows="3"><?=$hash['data']['todo_comment']?></textarea></td></tr>
		<tr><th>表示先<?=$view->explain('todolevel')?></th><td><?=$view->permit($hash['data'], 'todo', array(1=>'登録者', 2=>'表示するユーザーを設定'), 1)?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php'" />
	</div>
</form>
<?php
$view->footing();
?>