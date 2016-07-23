<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('施設予約');
$calendar = new Calendar;
$weekday = date('w', mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']));
$begin = mktime(0, 0, 0, $_GET['month'], $_GET['day'] - $weekday, $_GET['year']);
$end = mktime(0, 0, 0, $_GET['month'], $_GET['day'] + 6 - $weekday, $_GET['year']);
$previous = mktime(0, 0, 0, $_GET['month'], $_GET['day'] - 7, $_GET['year']);
$next = mktime(0, 0, 0, $_GET['month'], $_GET['day'] + 7, $_GET['year']);
$caption = date('Y', $begin).'年'.date('n', $begin).'月'.date('j', $begin).'日&nbsp;-&nbsp;';
$caption .= date('Y', $end).'年'.date('n', $end).'月'.date('j', $end).'日';
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
		<li><a href="add.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('facility'=>intval($_GET['facility'])))?>">予約</a></li>
<?php
if ($view->authorize('administrator', 'manager', 'editor')) {
	echo '<li><a href="facility.php">施設設定</a></li>';
}
?>
	</ul>
	<div class="clearer"></div>
</td><td class="schedulecaption">
	<a href="facilityweek.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>"><img src="../images/arrowprevious.gif" class="schedulearrow" /></a>
	<a href="facilityweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>"><?=$caption?></a>
	<a href="facilityweek.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>"><img src="../images/arrownext.gif" class="schedulearrow" /></a>
</td><td class="scheduleheaderright">
</td></tr></table>
<?php
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	$data = array();
	if (is_array($hash['list']) && count($hash['list']) > 0) {
		foreach ($hash['list'] as $row) {
			$data[$row['schedule_facility']][] = $row;
		}
	}
	echo '<table class="schedulegroup" cellspacing="0"><tr><th>&nbsp;</th>';
	$week = array('日', '月', '火', '水', '木', '金', '土');
	$style = array(0=>' class="sunday"', 6=>' class="saturday"');
	$timestamp = $begin;
	for ($i = 0; $i <= 6; $i++) {
		$day = date('j', $timestamp);
		$month = '';
		if ($i <= 0 || $day == 1) {
			$month = date('n/', $timestamp);
		}
		echo '<th'.$style[$i].'><a href="facilityday.php'.$calendar->parameter(date('Y', $timestamp), date('n', $timestamp), $day).'">'.$month.$day.'&nbsp;'.$week[$i].'</a></th>';
		$timestamp = strtotime('+1 day', $timestamp);
	}
	echo '</tr>';
	foreach ($hash['folder'] as $facility) {
		$key = $facility['folder_id'];
		$data[$key] = $calendar->prepare($data[$key], date('Y', $begin), date('n', $begin), date('j', $begin), date('Y', $end), date('n', $end), date('j', $end));
		echo '<tr><td><a href="facilitymonth.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('facility'=>intval($key))).'">'.$facility['folder_caption'].'</a><br />';
		if ($view->permitted($facility, 'add')) {
			echo '<a href="add.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('facility'=>intval($key))).'" class="direction">[予約]</a>';
		}
		echo '</td>';
		$timestamp = $begin;
		for ($i = 0; $i <= 6; $i++) {
			$day = date('j', $timestamp);
			echo '<td'.$calendar->style(date('Y', $timestamp), date('n', $timestamp), $day, $i).'>';
			if (is_array($data[$key][$day]) && count($data[$key][$day]) > 0) {
				foreach ($data[$key][$day] as $row) {
					if ($row['schedule_allday'] == 1) {
						$row['schedule_time'] = '終日&nbsp;';
					}
					if ($view->permitted($row, 'public')) {
						$parameter = $calendar->parameter(date('Y', $timestamp), date('n', $timestamp), $day, array('facility'=>$key));
						echo sprintf('<a href="facilityday.php%s"%s>%s%s</a><br />', $parameter, $calendar->share($row), $row['schedule_time'], $row['schedule_title']);
					} else {
						echo $row['schedule_time'].$row['schedule_name'].'<br />';
					}
				}
			}
			echo '&nbsp;</td>';
			$timestamp = strtotime('+1 day', $timestamp);
		}
		echo '</tr>';
	}
	echo '</table>';
} else {
	echo '<div>スケジュールはありません。</div>';
}
?>
<div class="schedulenavigation"><a href="facilityweek.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>">前の週</a><span class="separator">|</span>
<a href="facilityweek.php<?=$calendar->parameter()?>">今週</a><span class="separator">|</span>
<a href="facilityweek.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>">次の週</a></div>
<?php
$view->footing();
?>