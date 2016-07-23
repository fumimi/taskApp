<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('タイムカード編集');
$open = explode(':', $hash['data']['timecard_open']);
$close = explode(':', $hash['data']['timecard_close']);
?>
<h1>タイムカード編集</h1>
<ul class="operate">
	<li><a href="index.php?year=<?=$_GET['year']?>&month=<?=$_GET['month']?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>出社</th><td>
			<select name="openhour"><option value="">&nbsp;</option><?=$helper->option(0, 23, $open[0])?></select>時&nbsp;
			<select name="openminute"><option value="">&nbsp;</option><?=$helper->option(0, 59, $open[1])?></select>分&nbsp;
		</td></tr>
		<tr><th>外出</th><td>
<?php
$array = explode(' ', $hash['data']['timecard_interval']);
foreach ($array as $value) {
	list($intervalopen, $intervalclose) = explode('-', $value);
	list($openhour, $openminute) = explode(':', $intervalopen);
	list($closehour, $closeminute) = explode(':', $intervalclose);
?>
			<div><select name="intervalopenhour[]"><option value="">&nbsp;</option><?=$helper->option(0, 23, $openhour)?></select>時&nbsp;
			<select name="intervalopenminute[]"><option value="">&nbsp;</option><?=$helper->option(0, 59, $openminute)?></select>分&nbsp;-&nbsp;
			<select name="intervalclosehour[]"><option value="">&nbsp;</option><?=$helper->option(0, 23, $closehour)?></select>時&nbsp;
			<select name="intervalcloseminute[]"><option value="">&nbsp;</option><?=$helper->option(0, 59, $closeminute)?></select>分&nbsp;
			<span class="operator" onclick="Timecard.remove(this)">削除</span></div>
<?php
}
?>
		<span class="operator" onclick="Timecard.interval(this)">追加</span></td></tr>
		<tr><th>退社</th><td>
			<select name="closehour"><option value="">&nbsp;</option><?=$helper->option(0, 23, $close[0])?></select>時&nbsp;
			<select name="closeminute"><option value="">&nbsp;</option><?=$helper->option(0, 59, $close[1])?></select>分&nbsp;
		</td></tr>
		<tr><th>備考</th><td><textarea name="timecard_comment" class="inputcomment" rows="5"><?=$hash['data']['timecard_comment']?></textarea></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　編集　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php?year=<?=$_GET['year']?>&month=<?=$_GET['month']?>'" />
	</div>
</form>
<?php
$view->footing();
?>