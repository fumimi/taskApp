<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('プロジェクト');
$begin = strtotime($hash['data']['project_begin']);
$end = strtotime($hash['data']['project_end']);
?>
<h1>プロジェクト</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>">一覧に戻る</a></li>
<?php
if ($view->permitted($hash['data'], 'edit')) {
	echo '<li><a href="taskadd.php?parent='.$hash['data']['id'].'">タスク追加</a></li>';
	echo '<li><a href="edit.php?id='.$hash['data']['id'].'">編集</a></li>';
	echo '<li><a href="delete.php?id='.$hash['data']['id'].'">削除</a></li>';
}
?>
</ul>
<div class="projectcaption"><?=$hash['data']['project_title']?></div>
<table class="projecttask paragraph" cellspacing="0">
	<tr><th class="projecttaskheader">&nbsp;</th>
<?php
$day = floor(($end - $begin) / (60*60*24) + 1);
$timestamp = $begin;
if ($day <= 31) {
	for ($i = 0; $i < $day; $i++) {
		$date = date('j', $timestamp);
		if ($i <= 0 || $date == 1) {
			$date = date('n/j', $timestamp);
		}
		echo '<th>'.$date.'</th>';
		$timestamp = strtotime('+1 day', $timestamp);
	}
} elseif ($day <= 91) {
	$count = ($day - ($day % 7)) / 7;
	for ($i = 0; $i <= $count; $i++) {
		$date = date('j', $timestamp);
		if ($i <= 0 || $month != date('n', $timestamp)) {
			$date = date('n/j', $timestamp);
			$month = date('n', $timestamp);
		}
		if ($i < $count) {
			echo '<th colspan="7">'.$date.'</th>';
		} elseif ($day % 7 > 0) {
			echo '<th colspan="'.($day % 7).'">'.$date.'</th>';
		}
		$timestamp = strtotime('+7 day', $timestamp);
	}
} else {
	$beginyear = date('Y', $begin);
	$beginmonth = date('n', $begin);
	$count = (date('Y', $end) * 12 + date('n', $end)) - ($beginyear * 12 + $beginmonth);
	for ($i = 0; $i <= $count; $i++) {
		$date = date('n/j', $timestamp);
		if ($i <= 0) {
			$colspan = date('t', $begin) - date('j', $begin) + 1;
		} elseif ($i >= $count) {
			$colspan = date('j', $end);
		} else {
			$colspan = date('t', $timestamp);
		}
		echo '<th colspan="'.$colspan.'">'.$date.'</th>';
		$timestamp = mktime(0, 0, 0, $beginmonth + $i + 1, 1, $beginyear);
	}
}
echo '</tr>';
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
		$taskbegin = strtotime($row['project_begin']);
		$taskend = strtotime($row['project_end']);
		echo '<tr><td class="projecttaskcaption"><a href="taskview.php?id='.$row['id'].'">'.$row['project_title'].'</a></td>';
		if ($taskbegin >= $end) {
			$colspan = floor(($end - $begin) / (60*60*24));
		} else {
			$colspan = floor(($taskbegin - $begin) / (60*60*24));
		}
		if ($colspan > 0) {
			echo '<td colspan="'.$colspan.'">&nbsp;</td>';
		}
		if ($taskend < $end) {
			$colspan = floor(($taskend - $taskbegin) / (60*60*24) + 1);
		} else {
			$colspan = floor(($end - $taskbegin) / (60*60*24) + 1);
		}
		if ($colspan > 0) {
			if ($row['project_progress'] > 0 && $row['project_progress'] <= 100) {
				$progress = '<span class="projectprogress" style="width:'.intval($row['project_progress']).'%">&nbsp;</span>';
			} else {
				$progress = '&nbsp;';
			}
			echo '<td colspan="'.$colspan.'"><a class="task" href="taskview.php?id='.$row['id'].'">'.$progress.'</a></td>';
		}
		$colspan = floor(($end - $taskend) / (60*60*24));
		if ($colspan > 0) {
			echo '<td colspan="'.$colspan.'">&nbsp;</td>';
		}
		echo '</tr>';
	}
} elseif ($view->permitted($hash['data'], 'edit')) {
	echo '<tr><td class="projecttaskcaption" colspan="'.($day + 1).'" style="border-right:0px;">';
	echo '<a href="taskadd.php?parent='.$hash['data']['id'].'">タスクを追加する</a></td></tr>';
}
?>
</table>
<table class="view" cellspacing="0">
	<tr><th>プロジェクト</th><td><?=$hash['data']['project_title']?>&nbsp;</td></tr>
	<tr><th>開始</th><td><?=date('Y/m/d', $begin)?>&nbsp;</td></tr>
	<tr><th>終了</th><td><?=date('Y/m/d', $end)?>&nbsp;</td></tr>
	<tr><th>内容</th><td><?=nl2br($hash['data']['project_comment'])?>&nbsp;</td></tr>
	<tr><th>カテゴリ</th><td><?=$hash['category']['folder_caption']?>&nbsp;</td></tr>
</table>
<?php
$view->property($hash['data']);
$view->footing();
?>