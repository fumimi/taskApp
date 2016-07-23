<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('グループスケジュール');
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
		<li><a href="add.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">予定追加</a></li>
	</ul>
	<div class="clearer"></div>
</td><td class="schedulecaption">
	<a href="groupweek.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>"><img src="../images/arrowprevious.gif" class="schedulearrow" /></a>
	<a href="groupweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'])?>"><?=$caption?></a>
	<a href="groupweek.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>"><img src="../images/arrownext.gif" class="schedulearrow" /></a>
</td><td class="scheduleheaderright">
	<?=$helper->selector('groupweek', $hash['group'], $hash['groupid'], ' onchange="Schedule.redirect(this,'.$_GET['year'].','.$_GET['month'].','.$_GET['day'].')"')?>
</td></tr></table>
<?php
if (is_array($hash['user']) && count($hash['user']) > 0) {
	$data = array();
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
		echo '<th'.$style[$i].'><a href="groupday.php'.$calendar->parameter(date('Y', $timestamp), date('n', $timestamp), $day).'">'.$month.$day.'&nbsp;'.$week[$i].'</a></th>';
		$timestamp = strtotime('+1 day', $timestamp);
	}
	echo '</tr>';
	foreach ($hash['user'] as $key => $value) {
		$data[$key] = $calendar->prepare($data[$key], date('Y', $begin), date('n', $begin), date('j', $begin), date('Y', $end), date('n', $end), date('j', $end));
		echo '<tr><td><a href="index.php'.$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('member'=>$key)).'">'.$value.'</a>&nbsp;</td>';
		$timestamp = $begin;
		for ($i = 0; $i <= 6; $i++) {
			$day = date('j', $timestamp);
			echo '<td'.$calendar->style(date('Y', $timestamp), date('n', $timestamp), $day, $i).'>';
			if (is_array($data[$key][$day]) && count($data[$key][$day]) > 0) {
				foreach ($data[$key][$day] as $row) {
					$parameter = $calendar->parameter(date('Y', $timestamp), date('n', $timestamp), $day, array('member'=>$key));
					echo sprintf('<a href="groupday.php%s"%s>%s%s</a><br />', $parameter, $calendar->share($row), $row['schedule_time'], $row['schedule_title']);
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
<div class="schedulenavigation"><a href="groupweek.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>">前の週</a><span class="separator">|</span>
<a href="groupweek.php<?=$calendar->parameter()?>">今週</a><span class="separator">|</span>
<a href="groupweek.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>">次の週</a></div>
<?php
$view->footing();
?>