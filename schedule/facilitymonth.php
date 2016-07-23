<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('施設予約');
$calendar = new Calendar;
$data = $calendar->prepare($hash['list'], $_GET['year'], $_GET['month'], 1, $_GET['year'], $_GET['month'], date('t', mktime(0, 0, 0, $_GET['month'], 1, $_GET['year'])));
$timestamp = mktime(0, 0, 0, $_GET['month'], 1, $_GET['year']);
$previous = mktime(0, 0, 0, $_GET['month']-1, 1, $_GET['year']);
$next = mktime(0, 0, 0, $_GET['month']+1, 1, $_GET['year']);
if (strlen($hash['folder'][$_GET['facility']]) > 0) {
	$caption = ' - '.$hash['folder'][$_GET['facility']];
}
?>
<div class="contentcontrol">
	<h1>施設予約<?=$caption?></h1>
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
	<a href="facilitymonth.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous))?>"><img src="../images/arrowprevious.gif" class="schedulearrow" /></a>
	<a href="facilitymonth.php<?=$calendar->parameter($_GET['year'], $_GET['month'])?>"><?=$_GET['year']?>年<?=$_GET['month']?>月</a>
	<a href="facilitymonth.php<?=$calendar->parameter(date('Y', $next), date('n', $next))?>"><img src="../images/arrownext.gif" class="schedulearrow" /></a>
</td><td class="scheduleheaderright">
	<?=$helper->selector('facility', $hash['folder'], $_GET['facility'], ' onchange="Schedule.facility(this,'.$_GET['year'].','.$_GET['month'].')"')?>
</td></tr></table>
<table class="schedule" cellspacing="0">
<tr><th class="sunday">日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th class="saturday">土</th></tr>
<?php
$lastday = date('t', $timestamp);
for ($i = 0; $i <= 5; $i++) {
	echo '<tr>';
	for ($j = 0; $j <= 6; $j++) {
		$day = $i * 7 + $j - date('w', $timestamp) + 1;
		if ($day < 1 || $day > $lastday) {
			$schedule = '&nbsp;';
		} else {
			$schedule = sprintf('<a href="facilityday.php%s">%s</a>', $calendar->parameter($_GET['year'], $_GET['month'], $day), $day);
			if (is_array($data[$day]) && count($data[$day]) > 0) {
				foreach ($data[$day] as $row) {
					if ($row['schedule_allday'] == 1) {
						$row['schedule_time'] = '終日&nbsp;';
					}
					if ($view->permitted($row, 'public')) {
						$parameter = $calendar->parameter($_GET['year'], $_GET['month'], $day);
						$schedule .= sprintf('<br /><a href="facilityday.php%s"%s>%s%s</a>', $parameter, $calendar->share($row), $row['schedule_time'], $row['schedule_title']);
					} else {
						$schedule .= '<br />'.$row['schedule_time'].$row['schedule_name'];
					}
				}
			}
		}
		echo '<td'.$calendar->style($_GET['year'], $_GET['month'], $day, $j, $lastday).'>'.$schedule.'</td>';
	}
	echo '</tr>';
	if ($day >= $lastday) {
		break;
	}
}
?>
</table>
<div class="schedulenavigation"><a href="facilitymonth.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous))?>">前の月</a><span class="separator">|</span>
<a href="facilitymonth.php<?=$calendar->parameter()?>">今月</a><span class="separator">|</span>
<a href="facilitymonth.php<?=$calendar->parameter(date('Y', $next), date('n', $next))?>">次の月</a></div>
<?php
$view->footing();
?>