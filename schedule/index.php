<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('スケジュール');
$calendar = new Calendar;
$data = $calendar->prepare($hash['list'], $_GET['year'], $_GET['month'], 1, $_GET['year'], $_GET['month'], date('t', mktime(0, 0, 0, $_GET['month'], 1, $_GET['year'])));
$timestamp = mktime(0, 0, 0, $_GET['month'], 1, $_GET['year']);
$previous = mktime(0, 0, 0, $_GET['month']-1, 1, $_GET['year']);
$next = mktime(0, 0, 0, $_GET['month']+1, 1, $_GET['year']);
if (strlen($hash['owner']['realname']) > 0 && (isset($_GET['member']) || $hash['owner']['userid'] != $_SESSION['userid'])) {
	$caption = ' - '.$hash['owner']['realname'];
}
?>
<div class="contentcontrol">
	<h1>スケジュール<?=$caption?></h1>
	<table cellspacing="0"><tr>
		<td><a class="current" href="index.php">カレンダー</a></td>
		<td><a href="groupweek.php<?=$calendar->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">グループ</a></td>
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
	<a href="index.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous))?>"><img src="../images/arrowprevious.gif" class="schedulearrow" /></a>
	<a href="index.php<?=$calendar->parameter($_GET['year'], $_GET['month'])?>"><?=$_GET['year']?>年<?=$_GET['month']?>月</a>
	<a href="index.php<?=$calendar->parameter(date('Y', $next), date('n', $next))?>"><img src="../images/arrownext.gif" class="schedulearrow" /></a>
</td><td class="scheduleheaderright">
	<?=$calendar->selector('groupweek', $hash['owner']['groupuser'], $hash['group'], $hash['owner']['userid'])?>
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
			$schedule = sprintf('<a href="view.php%s">%s</a>', $calendar->parameter($_GET['year'], $_GET['month'], $day), $day);
			if (is_array($data[$day]) && count($data[$day]) > 0) {
				foreach ($data[$day] as $row) {
					$parameter = $calendar->parameter($_GET['year'], $_GET['month'], $day, array('id'=>$row['id']));
					$schedule .= sprintf('<br /><a href="view.php%s"%s>%s%s</a>', $parameter, $calendar->share($row), $row['schedule_time'], $row['schedule_title']);
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
<div class="schedulenavigation"><a href="index.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous))?>">前の月</a><span class="separator">|</span>
<a href="index.php<?=$calendar->parameter()?>">今月</a><span class="separator">|</span>
<a href="index.php<?=$calendar->parameter(date('Y', $next), date('n', $next))?>">次の月</a></div>
<?php
$view->footing();
?>