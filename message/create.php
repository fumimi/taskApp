<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('メッセージ作成');
if (is_array($hash['to']) && count($hash['to']) > 0) {
	foreach ($hash['to'] as $key => $value) {
		$string .= '<div><input type="checkbox" name="to[user]['.$key.']" id="to'.$key.'" value="'.$value.'" checked="checked" /><label for="to'.$key.'">'.$value.'</label></div>';
	}
}
?>
<h1>メッセージ作成</h1>
<ul class="operate">
	<li><a href="index.php">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="" enctype="multipart/form-data">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>宛先<span class="necessary">(必須)</span></th><td id="tolist"><?=$string?><span class="operator" id="tosearch" onclick="App.permitlevel(this, 'to', 1)">検索</span></td></tr>
		<tr><th>件名<span class="necessary">(必須)</span></th><td><input type="text" name="message_title" class="inputtitle" value="<?=$hash['data']['message_title']?>" /></td></tr>
		<tr><th>内容<span class="necessary">(必須)</span></th><td><textarea name="message_comment" class="inputcomment" rows="20"><?=$hash['data']['message_comment']?></textarea></td></tr>
		<tr><th>&nbsp;</th><td><?=$view->uploadfile($hash['data']['message_file'])?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　送信　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php'" />
	</div>
</form>
<?php
$view->footing();
?>