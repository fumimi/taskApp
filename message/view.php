<?php

require_once('../application/loader.php');
$view->heading('メッセージ');
if ($hash['data']['folder_id'] > 0) {
	$redirect = 'index.php?folder='.intval($hash['data']['folder_id']);
	if (strlen($hash['folder'][$hash['data']['folder_id']]) > 0) {
		$caption = ' - '.$hash['folder'][$hash['data']['folder_id']];
	}
} elseif ($hash['data']['folder_id'] < 0) {
	$redirect = 'trash.php';
	$caption = ' - ゴミ箱';
} elseif ($hash['data']['message_type'] == 'sent') {
	$redirect = 'sent.php';
	$caption = ' - 送信済み';
} else {
	$redirect = 'index.php';
	$caption = ' - 受信箱';
}
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	if ($hash['data']['message_type'] == 'sent') {
		$option = '<option value="0">送信済み</option>';
	} else {
		$option = '<option value="0">受信箱</option>';
	}
	foreach ($hash['folder'] as $key => $value) {
		$option .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
?>
<h1>メッセージ<?=$caption?></h1>
<ul class="operate">
	<li><a href="<?=$redirect?>">一覧に戻る</a></li>
<?php
if ($hash['data']['message_type'] == 'received') {
?>
	<li><a href="create.php?id=<?=$hash['data']['id']?>">返信</a></li>
	<li><a href="create.php?id=<?=$hash['data']['id']?>&type=all">全員に返信</a></li>
	<li><a href="create.php?id=<?=$hash['data']['id']?>&type=forward">転送</a></li>
<?php
}
if ($hash['data']['folder_id'] < 0) {
	echo '<li><span class="operator" onclick="Message.move(\'trash\')">完全に削除</span></li>';
} else {
	echo '<li><span class="operator" onclick="Message.move(\'trash\')">削除</span></li>';
}
?>
	<li><select name="move" onchange="Message.move(this)"><option value="">フォルダ移動</option><?=$option?></select></li>
</ul>
<table class="view" cellspacing="0">
	<tr><th>差出人</th><td><?=$hash['data']['message_fromname']?>&nbsp;</td></tr>
	<tr><th>宛先</th><td><?=$hash['data']['message_toname']?>&nbsp;</td></tr>
	<tr><th>日時</th><td><?=date('Y/m/d H:i:s', strtotime($hash['data']['message_date']))?>&nbsp;</td></tr>
	<tr><th>件名</th><td><?=$hash['data']['message_title']?>&nbsp;</td></tr>
	<tr><td colspan="2" class="messagecontent">
		<?=nl2br($hash['data']['message_comment'])?>
		<?=$view->attachment($hash['data']['id'], 'message', $hash['data']['owner'].'_'.strtotime($hash['data']['message_date']), $hash['data']['message_file'])?>
	</td></tr>
</table>
<form method="post" name="checkedform" action="">
	<input type="hidden" name="checkedid[]" value="<?=$hash['data']['id']?>" />
	<input type="hidden" name="folder" value="" />
</form>
<?php
$view->footing();
?>