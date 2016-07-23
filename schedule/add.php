<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('スケジュール追加');
$calendar = new Calendar;
$hash['data'] = $calendar->initialize($hash['data']);
$hash['data']['schedule_facility'] = $view->initialize($hash['data']['schedule_facility'], $_GET['facility']);
$hash['folder'] = array('&nbsp;') + $hash['folder'];
for ($i = 1; $i <= 31; $i++) {
	$option[$i] = $i;
}
$option['lastday'] = '末';
$repeat = array('繰り返しの設定', '日付を指定');
?>
<h1>スケジュール追加</h1>
<ul class="operate">
	<li><a href="index.php<?=$calendar->parameter($_GET['year'], $_GET['month'], '', array('group'=>'', 'member'=>'', 'facility'=>''))?>">カレンダーに戻る</a></li>
	<li><span class="operator" onclick="Schedule.repeat(this)"><?=$repeat[$hash['data']['schedule_type']]?></span></li>
</ul>
<form class="content" method="post" id="schedule" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>日付<span class="necessary">(必須)</span></th><td>
			<div id="default"<?=$view->style($hash['data']['schedule_type'], 0)?>>
				<select name="schedule_year"><?=$helper->option(2000, 2020, $hash['data']['schedule_year'])?></select>年&nbsp;
				<select name="schedule_month"><?=$helper->option(1, 12, $hash['data']['schedule_month'])?></select>月&nbsp;
				<select name="schedule_day"><?=$helper->option(1, 31, $hash['data']['schedule_day'])?></select>日
			</div>
			<div id="repeat"<?=$view->style($hash['data']['schedule_type'], 1)?>>
				<?=$helper->radio('schedule_repeat', 'everyweek', $hash['data']['schedule_repeat'], 'radioweek', '毎週', $hash['style']['disabled'])?>&nbsp;
				<?=$helper->selector('schedule_everyweek', array(1=>'月曜日', 2=>'火曜日', 3=>'水曜日', 4=>'木曜日', 5=>'金曜日', 6=>'土曜日', 0=>'日曜日'), $hash['data']['schedule_everyweek'])?><br />
				<?=$helper->radio('schedule_repeat', 'everymonth', $hash['data']['schedule_repeat'], 'radiomonth', '毎月', $hash['style']['disabled'])?>&nbsp;
				<?=$helper->selector('schedule_everymonth', $option, $hash['data']['schedule_everymonth'])?>日<br />
				<?=$helper->radio('schedule_repeat', 'everyday', $hash['data']['schedule_repeat'], 'radioday', '毎日', $hash['style']['disabled'])?><br />
				<?=$helper->radio('schedule_repeat', 'everyweekday', $hash['data']['schedule_repeat'], 'radioweekday', '毎日（平日）', $hash['style']['disabled'])?><br />
				繰り返し期間：&nbsp;<select name="beginyear"><?=$helper->option(2000, 2020, $hash['data']['beginyear'])?></select>年&nbsp;
				<select name="beginmonth"><?=$helper->option(1, 12, $hash['data']['beginmonth'])?></select>月&nbsp;
				<select name="beginday"><?=$helper->option(1, 31, $hash['data']['beginday'])?></select>日&nbsp;～&nbsp;
				<select name="endmonth"><?=$helper->option(1, 12, $hash['data']['endmonth'])?></select>月&nbsp;
				<select name="endday"><?=$helper->option(1, 31, $hash['data']['endday'])?></select>日&nbsp;
			</div>
		</td></tr>
		<tr><th>時間<span class="necessary">(必須)</span></th><td>
			<select name="beginhour"><?=$helper->option(0, 23, $hash['data']['beginhour'])?></select>時&nbsp;
			<?=$helper->selector('beginminute', array('0'=>'00', '10'=>'10', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50'), $hash['data']['beginminute'])?>分&nbsp;
			～&nbsp;
			<select name="endhour"><?=$helper->option(0, 23, $hash['data']['endhour'])?></select>時&nbsp;
			<?=$helper->selector('endminute', array('0'=>'00', '10'=>'10', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50'), $hash['data']['endminute'])?>分&nbsp;
			<?=$helper->checkbox('schedule_allday', 1, $hash['data']['schedule_allday'], 'schedule_allday', '終日')?>
		</td></tr>
		<tr><th>タイトル<span class="necessary">(必須)</span></th><td><input type="text" name="schedule_title" class="inputtitle" value="<?=$hash['data']['schedule_title']?>" /></td></tr>
		<tr><th>コメント</th><td><textarea name="schedule_comment" class="inputcomment" rows="5"><?=$hash['data']['schedule_comment']?></textarea></td></tr>
		<tr><th>施設</th><td><?=$helper->selector('schedule_facility', $hash['folder'], $hash['data']['schedule_facility'])?></td></tr>
		<tr><th>表示先<?=$view->explain('schedulelevel')?></th><td><?=$view->permit($hash['data'], 'schedule', array(1=>'登録者', 0=>'全体', 2=>'表示するグループ・ユーザーを設定'))?></td></tr>
		<tr><th>公開設定<?=$view->explain('public')?></th><td><?=$view->permit($hash['data'])?></td></tr>
		<tr><th>編集設定<?=$view->explain('scheduleedit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$calendar->parameter($_GET['year'], $_GET['month'], '', array('group'=>'', 'member'=>'', 'facility'=>''))?>'" />
	</div>
	<input type="hidden" name="schedule_type" value="<?=$hash['data']['schedule_type']?>" />
</form>
<?php
$view->footing();
?>