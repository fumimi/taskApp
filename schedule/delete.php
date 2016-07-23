<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('スケジュール削除');
$calendar = new Calendar;
$date = $calendar->dated($hash['data']);
$time = $calendar->tick($hash['data']['schedule_allday'], $hash['data']['schedule_time'], $hash['data']['schedule_endtime'], '&nbsp;-&nbsp;');
$level = array('全体', '登録者');
if ($hash['data']['schedule_level'] == 2) {
	$level[2] = $view->permitlist($hash['data'], 'schedule');
}
?>
<h1>スケジュール削除</h1>
<ul class="operate">
	<li><a href="index.php<?=$calendar->parameter($hash['data']['schedule_year'], $hash['data']['schedule_month'], '', array('group'=>'', 'member'=>'', 'facility'=>''))?>">カレンダーに戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記のスケジュールを削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>日付</th><td><?=$date?>&nbsp;</td></tr>
		<tr><th>時間</th><td><?=$time?>&nbsp;</td></tr>
		<tr><th>タイトル</th><td><?=$hash['data']['schedule_title']?>&nbsp;</td></tr>
		<tr><th>詳細</th><td><?=$hash['data']['schedule_comment']?>&nbsp;</td></tr>
		<tr><th>施設</th><td><?=$hash['facility']['folder_caption']?>&nbsp;</td></tr>
		<tr><th>表示先</th><td><?=$level[$hash['data']['schedule_level']]?>&nbsp;</td></tr>
	</table>
	<?=$view->property($hash['data'])?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$calendar->parameter($hash['data']['schedule_year'], $hash['data']['schedule_month'], '', array('group'=>'', 'member'=>'', 'facility'=>''))?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>