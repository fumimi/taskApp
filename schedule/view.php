<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('スケジュール');
$calendar = new Calendar;
$data = $calendar->prepare($hash['list'], $_GET['year'], $_GET['month'], $_GET['day'], $_GET['year'], $_GET['month'], $_GET['day']);
$data = $data[$_GET['day']];
$week = array('日', '月', '火', '水', '木', '金', '土');
$previous = mktime(0, 0, 0, $_GET['month'], $_GET['day'] - 1, $_GET['year']);
$next = mktime(0, 0, 0, $_GET['month'], $_GET['day'] + 1, $_GET['year']);
if (strlen($hash['owner']['realname']) > 0 && (isset($_GET['member']) || $hash['owner']['userid'] != $_SESSION['userid'])) {
	$caption = ' - '.$hash['owner']['realname'];
}
?>
<div class="contentcontrol">
	<h1>スケジュール<?=$caption?></h1>
	<table cellspacing="0"><tr>
		<td><a href="index.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>">カレンダー</a></td>
		<td><a href="groupweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>">グループ</a></td>
		<td><a href="facilityweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>">施設</a></td>
	</tr></table>
	<div class="clearer"></div>
</div>
<table class="wrapper" cellspacing="0"><tr><td class="scheduleheader">
	<ul class="operate">
		<li><a href="index.php<?=$calendar->parameter($_GET['year'], $_GET['month'], '', array('group'=>'', 'member'=>'', 'facility'=>''))?>">カレンダーに戻る</a></li>
		<li><a href="add.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">予定追加</a></li>
	</ul>
	<div class="clearer"></div>
</td><td class="schedulecaption">
	<a href="view.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>"><img src="../images/arrowprevious.gif" class="schedulearrow" /></a>
	<a href="view.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>">
		<?=$_GET['year']?>年<?=$_GET['month']?>月<?=$_GET['day']?>日(<?=$week[date('w', mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']))]?>)
	</a>
	<a href="view.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>"><img src="../images/arrownext.gif" class="schedulearrow" /></a>
</td><td class="scheduleheaderright">
	<?=$calendar->selector('groupday', $hash['owner']['groupuser'], $hash['group'], $hash['owner']['userid'])?>
</td></tr></table>
<?php
$beginhour = 9;
$endhour = 18;
if (is_array($data) && count($data) > 0) {
	foreach ($data as $row) {
		if ($row['schedule_allday'] != 1) {
			$hour = intval(substr($row['schedule_time'], 0, 2));
			if ($hour < $beginhour && $hour >= 0) {
				$beginhour = $hour;
			}
			$hour = intval(substr($row['schedule_endtime'], 0, 2));
			if ($endhour < $hour && $hour <= 23) {
				$endhour = $hour;
			}
		}
	}
}
$calendar->timetable($data, $beginhour, $endhour, $_GET['member'], 'スケジュールはありません。');
?>
<div class="schedulenavigation paragraph">
	<a href="view.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>">前の日</a><span class="separator">|</span>
	<a href="view.php<?=$calendar->parameter()?>">今日</a><span class="separator">|</span>
	<a href="view.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>">次の日</a>
</div>
<?php
if (is_array($hash['data']) && count($hash['data']) > 0) {
	$date = $calendar->dated($hash['data']);
	$time = $calendar->tick($hash['data']['schedule_allday'], $hash['data']['schedule_time'], $hash['data']['schedule_endtime'], '&nbsp;-&nbsp;');
	$level = array('全体', '登録者');
	if ($hash['data']['schedule_level'] == 2) {
		$level[2] = $view->permitlist($hash['data'], 'schedule');
	}
	if ($view->permitted($hash['data'], 'schedule') && $view->permitted($hash['data'], 'edit')) {
		echo '<div class="operate"><ul>';
		echo '<li><a href="edit.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('id'=>$hash['data']['id'])).'">編集</a></li>';
		echo '<li><a href="delete.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('id'=>$hash['data']['id'])).'">削除</a></li>';
		echo '</ul><div class="clearer"></div></div>';
	}
?>
<table class="view" cellspacing="0">
	<tr><th>日付</th><td><?=$date?>&nbsp;</td></tr>
	<tr><th>時間</th><td><?=$time?>&nbsp;</td></tr>
	<tr><th>タイトル</th><td><?=$hash['data']['schedule_title']?>&nbsp;</td></tr>
	<tr><th>詳細</th><td><?=$hash['data']['schedule_comment']?>&nbsp;</td></tr>
	<tr><th>施設</th><td><?=$hash['facility']['folder_caption']?>&nbsp;</td></tr>
	<tr><th>表示先</th><td><?=$level[$hash['data']['schedule_level']]?>&nbsp;</td></tr>
</table>
<?php
	$view->property($hash['data']);
}
$view->footing();
?>