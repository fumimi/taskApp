<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('グループスケジュール');
$calendar = new Calendar;
$hash['list'] = $calendar->prepare($hash['list'], $_GET['year'], $_GET['month'], $_GET['day'], $_GET['year'], $_GET['month'], $_GET['day']);
$hash['list'] = $hash['list'][$_GET['day']];
$week = array('日', '月', '火', '水', '木', '金', '土');
$previous = mktime(0, 0, 0, $_GET['month'], $_GET['day']-1, $_GET['year']);
$next = mktime(0, 0, 0, $_GET['month'], $_GET['day']+1, $_GET['year']);
?>
<div class="contentcontrol">
	<h1>グループスケジュール - <?=$hash['group'][$hash['groupid']]?></h1>
	<table cellspacing="0"><tr>
		<td><a href="index.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">カレンダー</a></td>
		<td><a class="current" href="groupweek.php">グループ</a></td>
		<td><a href="facilityweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">施設</a></td>
	</tr></table>
	<div class="clearer"></div>
</div>
<table class="wrapper" cellspacing="0"><tr><td class="scheduleheader">
	<ul class="operate">
		<li><a href="groupweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>">週一覧に戻る</a></li>
		<li><a href="add.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">予定追加</a></li>
	</ul>
	<div class="clearer"></div>
</td><td class="schedulecaption">
	<a href="groupday.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>"><img src="../images/arrowprevious.gif" class="schedulearrow" /></a>
	<a href="groupday.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>">
		<?=$_GET['year']?>年<?=$_GET['month']?>月<?=$_GET['day']?>日(<?=$week[date('w', mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']))]?>)
	</a>
	<a href="groupday.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>"><img src="../images/arrownext.gif" class="schedulearrow" /></a>
</td><td class="scheduleheaderright">
	<?=$helper->selector('groupday', $hash['group'], $hash['groupid'], ' onchange="Schedule.redirect(this,'.$_GET['year'].','.$_GET['month'].','.$_GET['day'].')"')?>
</td></tr></table>
<?php
if (is_array($hash['user']) && count($hash['user']) > 0) {
	$data = array();
	$beginhour = 9;
	$endhour = 18;
	if (is_array($hash['list']) && count($hash['list']) > 0) {
		foreach ($hash['list'] as $row) {
			if ($row['schedule_level'] == 1) {
				$data[$row['owner']][] = $row;
			} elseif ($row['schedule_level'] == 0 || ($row['schedule_level'] == 2 && stristr($row['schedule_group'], '['.$hash['groupid'].']'))) {
				foreach ($hash['user'] as $key => $value) {
					$data[$key][] = $row;
				}
			} elseif ($row['schedule_level'] == 2) {
				foreach ($hash['user'] as $key => $value) {
					if (stristr($row['schedule_user'], '['.$key.']')) {
						$data[$key][] = $row;
					}
				}
			}
			if ($row['schedule_allday'] <= 0) {
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
	echo '<table class="timetablegroup" cellspacing="0">';
	foreach ($hash['user'] as $key => $value) {
		echo '<tr><td class="timetablegroupuser">';
		echo '<a href="index.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('member'=>$key)).'">'.$value.'</a>';
		echo '</td><td class="timetablegrouplist">';
		$calendar->timetable($data[$key], $beginhour, $endhour, $key);
		echo '</td></tr>';
	}
	echo '</table>';
} else {
	echo '<div>スケジュールはありません。</div>';
}
?>
<div class="schedulenavigation">
	<a href="groupday.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>">前の日</a><span class="separator">|</span>
	<a href="groupday.php<?=$calendar->parameter()?>">今日</a><span class="separator">|</span>
	<a href="groupday.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>">次の日</a>
</div>
<?php
$view->footing();
?>