<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('施設予約');
$calendar = new Calendar;
$hash['list'] = $calendar->prepare($hash['list'], $_GET['year'], $_GET['month'], $_GET['day'], $_GET['year'], $_GET['month'], $_GET['day']);
$hash['list'] = $hash['list'][$_GET['day']];
$week = array('日', '月', '火', '水', '木', '金', '土');
$previous = mktime(0, 0, 0, $_GET['month'], $_GET['day']-1, $_GET['year']);
$next = mktime(0, 0, 0, $_GET['month'], $_GET['day']+1, $_GET['year']);
?>
<div class="contentcontrol">
	<h1>施設予約</h1>
	<table cellspacing="0"><tr>
		<td><a href="index.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">カレンダー</a></td>
		<td><a href="groupweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">グループ</a></td>
		<td><a class="current" href="facilityweek.php">施設</a></td>
	</tr></table>
	<div class="clearer"></div>
</div>
<table class="wrapper" cellspacing="0"><tr><td class="scheduleheader">
	<ul class="operate">
		<li><a href="facilityweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>">週一覧に戻る</a></li>
<?php
if ($view->permitted($hash['category'], 'add')) {
	echo '<li><a href="add.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('facility'=>intval($_GET['facility']))).'">予約</a></li>';
}
?>
	</ul>
	<div class="clearer"></div>
</td><td class="schedulecaption">
	<a href="facilityday.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>"><img src="../images/arrowprevious.gif" class="schedulearrow" /></a>
	<a href="facilityday.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>">
		<?=$_GET['year']?>年<?=$_GET['month']?>月<?=$_GET['day']?>日(<?=$week[date('w', mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']))]?>)
	</a>
	<a href="facilityday.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>"><img src="../images/arrownext.gif" class="schedulearrow" /></a>
</td><td class="scheduleheaderright">
</td></tr></table>
<?php
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	$data = array();
	$beginhour = 9;
	$endhour = 18;
	if (is_array($hash['list']) && count($hash['list']) > 0) {
		foreach ($hash['list'] as $row) {
			$data[$row['schedule_facility']][] = $row;
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
	echo '<table class="timetablegroup" cellspacing="0">';
	foreach ($hash['folder'] as $facility) {
		$key = $facility['folder_id'];
		echo '<tr><td class="timetablegroupuser"><a href="facilitymonth.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('facility'=>intval($key))).'">'.$facility['folder_caption'].'</a><br />';
		if ($view->permitted($facility, 'add')) {
			echo '<a href="add.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('facility'=>intval($key))).'" class="direction">[予約]</a>';
		}
		echo '</td><td class="timetablegrouplist">';
		$calendar->timetable($data[$key], $beginhour, $endhour);
		echo '</td></tr>';
	}
	echo '</table>';
} else {
	echo '<div>スケジュールはありません。</div>';
}
?>
<div class="schedulenavigation">
	<a href="facilityday.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>">前の日</a><span class="separator">|</span>
	<a href="facilityday.php<?=$calendar->parameter()?>">今日</a><span class="separator">|</span>
	<a href="facilityday.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>">次の日</a>
</div>
<?php
$view->footing();
?>