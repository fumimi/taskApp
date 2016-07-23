<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('タイムカード');
$calendar = new Calendar;
if (count($hash['list']) <= 0) {
	$attribute = ' onclick="alert(\'出力するデータがありません。\');return false;"';
}
if (strlen($hash['owner']['realname']) > 0 && (isset($_GET['member']) || $hash['owner']['userid'] != $_SESSION['userid'])) {
	$caption = ' - '.$hash['owner']['realname'];
}
?>
<h1>タイムカード<?=$caption?></h1>
<ul class="operate">
	<li><a href="csv.php<?=$view->positive(array('year'=>$_GET['year'], 'month'=>$_GET['month']))?>"<?=$attribute?>>CSV出力</a></li>
<?php
if ($hash['owner']['userid'] == $_SESSION['userid']) {
	echo '<li><a href="index.php'.$view->positive(array('year'=>$_GET['year'], 'month'=>$_GET['month'], 'recalculate'=>1)).'">再計算</a></li>';
}
if ($view->authorize('administrator', 'manager')) {
	echo '<li><a href="group.php">管理</a></li>';
}
?>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="timecard" cellspacing="0">
		<tr><td colspan="8" class="timecardcaption">
			<select name="year" onchange="Timecard.redirect(this)"><?=$helper->option(2000, 2020, $_GET['year'])?></select>年&nbsp;
			<select name="month" onchange="Timecard.redirect(this)"><?=$helper->option(1, 12, $_GET['month'])?></select>月
		</td></tr>
		<tr><th>日付</th><th>出社</th><th>外出</th><th>退社</th><th>勤務時間</th><th>外出時間</th><th>備考</th><th>&nbsp;</th></tr>
<?php
$timestamp = mktime(0, 0, 0, $_GET['month'], 1, $_GET['year']);
$lastday = date('t', $timestamp);
$weekday = date('w', $timestamp);
$week = array('日', '月', '火', '水', '木', '金', '土');
$today = array('year'=>date('Y'), 'month'=>date('n'), 'day'=>date('j'));
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
		$data[$row['timecard_day']] = $row;
	}
}
$sum = 0;
for ($i = 1; $i <= $lastday; $i++) {
	$class = $calendar->style($_GET['year'], $_GET['month'], $i, $weekday, $lastday);
	$type = array('open', 'close', 'interval');
	foreach ($type as $value) {
		$key = 'timecard_'.$value;
		$original = 'timecard_original'.$value;
		if ($data[$i][$key] != $data[$i][$original]) {
			if (strlen($data[$i][$key]) > 0) {
				$data[$i][$key] = '<span class="timecardupdated">'.$data[$i][$key].'</span>';
			}
			if ($_GET['original'] == 1) {
				if ($data[$i][$original]) {
					$data[$i][$key] = $data[$i][$original].'<br />'.$data[$i][$key];
				} else {
					$data[$i][$key] = '-<br />'.$data[$i][$key];
				}
			}
		}
	}
	if ($_GET['month'] == $today['month'] && $i == $today['day'] && $_GET['year'] == $today['year'] && $hash['owner']['userid'] == $_SESSION['userid']) {
		if (!$data[$i] && !$data[$i]['timecard_open']) {
			$data[$i]['timecard_open'] = '<input type="submit" name="timecard_open" value="出社" />';
		} elseif (!$data[$i]['timecard_close']) {
			$data[$i]['timecard_close'] = '<input type="submit" name="timecard_close" value="退社" />';
			if (strlen($data[$i]['timecard_interval']) <= 0 || preg_match('/.*-[0-9]+:[0-9]+$/', $data[$i]['timecard_interval'])) {
				$data[$i]['timecard_interval'] .= '&nbsp;<input type="submit" name="timecard_interval" value="外出" />';
			} else {
				$data[$i]['timecard_interval'] .= '&nbsp;<input type="submit" name="timecard_interval" value="復帰" />';
			}
		}
	}
	if (strlen($data[$i]['timecard_time']) > 0) {
		$array = explode(':', $data[$i]['timecard_time']);
		$sum += intval($array[0]) * 60 + intval($array[1]);
	}
	if ($hash['owner']['userid'] == $_SESSION['userid']) {
		$edit = '<a href="edit.php?year='.$_GET['year'].'&month='.$_GET['month'].'&day='.$i.'">編集</a>';
	} else {
		$edit = '<span class="unlink">編集</span>';
	}
?>
		<tr<?=$class?>><td><?=$i?>(<?=$week[$weekday]?>)</td>
		<td><?=$data[$i]['timecard_open']?>&nbsp;</td>
		<td><?=$data[$i]['timecard_interval']?>&nbsp;</td>
		<td><?=$data[$i]['timecard_close']?>&nbsp;</td>
		<td><?=$data[$i]['timecard_time']?>&nbsp;</td>
		<td><?=$data[$i]['timecard_timeinterval']?>&nbsp;</td>
		<td><?=$data[$i]['timecard_comment']?>&nbsp;</td>
		<td style="white-space:nowrap;"><?=$edit?></td></tr>
<?php
	$weekday = ($weekday + 1) % 7;
}
$sum = sprintf('%d:%02d', (($sum - ($sum % 60)) / 60), ($sum % 60));
?>
		<tr><td colspan="4" class="timecardtotal">勤務時間合計</td><td colspan="4" class="timecardtotal"><?=$sum?>&nbsp;</td></tr>
	</table>
	<div class="property">
<?php
if ($hash['config']['lunchclosehour'] > 0 || $hash['config']['lunchcloseminute'] > 0) {
	$lunchtime = sprintf('%d:%02d-%d:%02d', $hash['config']['lunchopenhour'], $hash['config']['lunchopenminute'], $hash['config']['lunchclosehour'], $hash['config']['lunchcloseminute']);
	echo '外出時間には'.$lunchtime.'が含まれます。<br />';
}
if ($_GET['original'] == 1) {
	echo '<a href="index.php'.$view->positive(array('year'=>$_GET['year'], 'month'=>$_GET['month'])).'">編集前の時刻を表示しない</a>';
} else {
	echo '<a href="index.php'.$view->positive(array('year'=>$_GET['year'], 'month'=>$_GET['month'], 'original'=>1)).'">編集前の時刻を表示する</a>';
}
?>
	</div>
</form>
<?php
$view->footing();
?>