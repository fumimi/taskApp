<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('ToDo詳細');
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	foreach ($hash['folder'] as $key => $value) {
		$option .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$priority = array('', '<span class="todoimportant">重要</span>', '<span class="todopriority">最重要</span>');
if ($hash['data']['todo_complete'] == 1) {
	$status = '<span class="todocomplete">完了</span>';
	$complete = '<span class="operator" onclick="App.move(\'incomplete\')">未完了</span>';
	$redirect = '?folder=complete';
	if (strlen($hash['data']['todo_completedate']) > 0) {
		$hash['data']['todo_completedate'] = date('Y年n月j日 G時i分', strtotime($hash['data']['todo_completedate']));
	}
	$completedate = '<tr><th>完了日</th><td>'.$hash['data']['todo_completedate'].'&nbsp;</td></tr>';
} else {
	$status = '<span class="todoincomplete">未完了</span>';
	if (strlen($hash['data']['todo_term']) > 0 && date('Ymd', strtotime($hash['data']['todo_term'])) < date('Ymd')) {
		$status .= '&nbsp;<span class="todoimportant">期限超過</span>';
	}
	$complete = '<span class="operator" onclick="App.move(\'complete\')">完了</span>';
}
if (strlen($hash['data']['todo_term']) > 0) {
	$hash['data']['todo_term'] = date('Y年n月j日', strtotime($hash['data']['todo_term']));
}
?>
<h1>ToDo詳細</h1>
<ul class="operate">
	<li><a href="index.php<?=$redirect?>">一覧に戻る</a></li>
	<li><?=$complete?></li>
	<li><a href="edit.php?id=<?=$hash['data']['id']?>">編集</a></li>
	<li><a href="delete.php?id=<?=$hash['data']['id']?>">削除</a></li>
	<li><select name="move" onchange="App.move(this)"><option value="">フォルダ移動</option><?=$option?><option value="0">フォルダなし</option></select></li>
</ul>
<table class="view" cellspacing="0">
	<tr><th>ステータス</th><td><?=$status?>&nbsp;</td></tr>
	<tr><th>タイトル</th><td><?=$hash['data']['todo_title']?>&nbsp;</td></tr>
	<tr><th>名前</th><td><?=$hash['data']['todo_name']?>&nbsp;</td></tr>
	<tr><th>期限</th><td><?=$hash['data']['todo_term']?>&nbsp;</td></tr>
	<?=$completedate?>
	<tr><th>重要度</th><td><?=$priority[$hash['data']['todo_priority']]?>&nbsp;</td></tr>
	<tr><th>備考</th><td><?=nl2br($hash['data']['todo_comment'])?>&nbsp;</td></tr>
	<tr><th>フォルダ</th><td><?=$hash['folder'][$hash['data']['folder_id']]?>&nbsp;</td></tr>
	<tr><th>表示先</th><td>
<?php
if (strlen($hash['data']['todo_user']) > 0) {
	$array = explode(',', str_replace(array('][', '[', ']'), array(',', '', ''), $hash['data']['todo_user']));
	if (is_array($array) && count($array) > 0) {
		echo '<table class="todouser" cellspacing="0">';
		foreach ($array as $value) {
			if (isset($hash['list'][$value])) {
				if ($hash['list'][$value] == 1) {
					$string = '<td class="todocomplete">完了</td>';
				} else {
					$string = '<td class="todoincomplete">未完了</td>';
				}
			} else {
				$string = '<td>不明</td>';
			}
			echo '<tr><td>'.$hash['user'][$value].'</td>'.$string.'</tr>';
		}
		echo '</table>';
	}
} else {
	echo '登録者';
}
?>
	</td></tr>
</table>
<?=$view->property($hash['data'])?>
<form method="post" name="checkedform" action="">
	<input type="hidden" name="checkedid[]" value="<?=$hash['data']['id']?>" />
	<input type="hidden" name="folder" value="" />
</form>
<?php
$view->footing();
?>