<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('application/loader.php');

$view->script('general.js');
$view->heading('トップページ', 'top');
$hash['group'] = array('グループ') + $hash['group'];
$calendar = new Calendar;
$previous = mktime(0, 0, 0, $hash['month'], $hash['day'] - 7, $hash['year']);
$next = mktime(0, 0, 0, $hash['month'], $hash['day'] + 7, $hash['year']);
$week = array('日', '月', '火', '水', '木', '金', '土');
$caption = $hash['year'].'年'.$hash['month'].'月'.$hash['day'].'日('.$week[$hash['weekday']].')';
?>

<h1> Dashboard</h1>


<table class="wrapper" cellspacing="0"><tr><td class="scheduleheader">
	<ul class="operate">
		<li><a href="schedule/add.php<?=$calendar->parameter($hash['year'], $hash['month'], $hash['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">予定追加</a></li>
	</ul>
	<div class="clearer"></div>
</td><td class="schedulecaption">
	<a href="schedule/groupweek.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>"><img src="images/arrowprevious.gif" class="schedulearrow" /></a>
	<a href="schedule/groupweek.php<?=$calendar->parameter($hash['year'], $hash['month'], $hash['day'])?>"><?=$caption?></a>
	<a href="schedule/groupweek.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>"><img src="images/arrownext.gif" class="schedulearrow" /></a>
</td><td class="scheduleheaderright">
	<?=$helper->selector('groupweek', $hash['group'], '', ' onchange="General.redirect(this,'.$hash['year'].','.$hash['month'].','.$hash['day'].')"')?>
</td></tr></table>




<table class="schedulegroup paragraph" cellspacing="0"><tr>
<?php
$timestamp = $hash['begin'];
$style = array(0=>' class="sunday"', 6=>' class="saturday"');
for ($i = 0; $i <= 6; $i++) {
	$day = date('j', $timestamp);
	$month = '';
	if ($i <= 0 || $day == 1) {
		$month = date('n/', $timestamp);
	}
	echo '<th'.$style[$i].'><a href="schedule/view.php'.$calendar->parameter(date('Y', $timestamp), date('n', $timestamp), $day).'">'.$month.$day.'&nbsp;'.$week[$i].'</a></th>';
	$timestamp = strtotime('+1 day', $timestamp);
}
echo '</tr><tr>';
$data = $calendar->prepare($hash['schedule'], date('Y', $hash['begin']), date('n', $hash['begin']), date('j', $hash['begin']), date('Y', $hash['end']), date('n', $hash['end']), date('j', $hash['end']));
$timestamp = $hash['begin'];
for ($i = 0; $i <= 6; $i++) {
	$day = date('j', $timestamp);
	echo '<td'.$calendar->style(date('Y', $timestamp), date('n', $timestamp), $day, $i).'>';
	if (is_array($data[$day]) && count($data[$day]) > 0) {
		foreach ($data[$day] as $row) {
			$parameter = $calendar->parameter(date('Y', $timestamp), date('n', $timestamp), $day, array('id'=>$row['id']));
			echo sprintf('<a href="schedule/view.php%s"%s>%s%s&nbsp;</a><br />', $parameter, $calendar->share($row), $row['schedule_time'], $row['schedule_title']);
		}
	}
	echo '&nbsp;</td>';
	$timestamp = strtotime('+1 day', $timestamp);
}
echo '</tr></table>';
?>








<table class="wrapper" cellspacing="0"><tr><td class="topcontentfolder">
	<form method="post" class="toplist" name="checkedform" action="">
		<div class="topcaption">
			<h2><a href="todo/">ToDo管理</a></h2>
			<ul><li><span class="operator" onclick="App.move('complete')">完了</span></li><li><a href="todo/add.php">追加</a></li></ul>
			<div class="clearer"></div>
		</div>
		<table class="wrapper" cellspacing="0">
<?php
if (is_array($hash['todo']) && count($hash['todo']) > 0) {
	$priority = array('', '<span class="todoimportant">重要</span>', '<span class="todopriority">最重要</span>');
	foreach ($hash['todo'] as $row) {
		if (strlen($row['todo_term']) > 0) {
			$row['todo_term'] = date('n/j', strtotime($row['todo_term']));
		}
		if (strlen($row['todo_user']) > 0) {
			$classshare = ' class="share"';
		} else {
			$classshare = '';
		}
?>
			<tr><td style="width:20px;"><input type="checkbox" name="checkedid[]" value="<?=$row['id']?>" /></td>
			<td><a<?=$classshare?> href="todo/view.php?id=<?=$row['id']?>"><?=$row['todo_title']?></a>&nbsp;</td>
			<td><?=$row['todo_term']?>&nbsp;</td>
			<td><?=$priority[$row['todo_priority']]?>&nbsp;</td></tr>
<?php
	}
} else {
	echo '<tr><td colspan="4">ToDoはありません。</td></tr>';
}
?>
		</table>




		
		<input type="hidden" name="folder" value="" />
	</form>
	<form method="post" class="toplist" action="">
		<div class="topcaption">
			<h2><a href="timecard/">タイムカード</a></h2>
			<ul><li><a href="timecard/edit.php">編集</a></li></ul>
			<div class="clearer"></div>
		</div>
		<table class="toptimecard" cellspacing="0">
			<tr><th>出社</th><th>外出</th><th style="border-right:0px;">退社</th></tr>
<?php
if ($hash['timecard']['timecard_open'] != $hash['timecard']['timecard_originalopen'] && strlen($hash['timecard']['timecard_open']) > 0) {
	$hash['timecard']['timecard_open'] = '<span class="timecardupdated">'.$hash['timecard']['timecard_open'].'</span>';
}
if ($hash['timecard']['timecard_close'] != $hash['timecard']['timecard_originalclose'] && strlen($hash['timecard']['timecard_close']) > 0) {
	$hash['timecard']['timecard_close'] = '<span class="timecardupdated">'.$hash['timecard']['timecard_close'].'</span>';
}
if ($hash['timecard']['timecard_interval'] != $hash['timecard']['timecard_originalinterval'] && strlen($hash['timecard']['timecard_interval']) > 0) {
	$hash['timecard']['timecard_interval'] = '<span class="timecardupdated">'.$hash['timecard']['timecard_interval'].'</span>';
}
if (!$hash['timecard'] && !$hash['timecard']['timecard_open']) {
	$hash['timecard']['timecard_open'] = '<input type="submit" name="timecard_open" value="出社" />';
} elseif (!$hash['timecard']['timecard_close']) {
	$hash['timecard']['timecard_close'] = '<input type="submit" name="timecard_close" value="退社" />';
	if (strlen($hash['timecard']['timecard_interval']) <= 0 || preg_match('/.*-[0-9]+:[0-9]+$/', $hash['timecard']['timecard_interval'])) {
		$hash['timecard']['timecard_interval'] .= '&nbsp;<input type="submit" name="timecard_interval" value="外出" />';
	} else {
		$hash['timecard']['timecard_interval'] .= '&nbsp;<input type="submit" name="timecard_interval" value="復帰" />';
	}
}
?>
			<tr><td><?=$hash['timecard']['timecard_open']?>&nbsp;</td>
			<td><?=$hash['timecard']['timecard_interval']?>&nbsp;</td>
			<td style="border-right:0px;"><?=$hash['timecard']['timecard_close']?>&nbsp;</td></tr>
		</table>
	</form>
	<div class="toplist">
		<div class="topcaption">
			<h2><a href="bookmark/">ブックマーク</a></h2>
			<ul><li><a href="bookmark/add.php">追加</a></li></ul>
			<div class="clearer"></div>
		</div>
		<table class="wrapper visited" cellspacing="0">
<?php
if (is_array($hash['bookmark']) && count($hash['bookmark']) > 0) {
	foreach ($hash['bookmark'] as $row) {
?>
			<tr><td><a href="<?=$row['bookmark_url']?>" target="_blank"><?=$row['bookmark_title']?></a>&nbsp;</td></tr>
<?php
	}
} else {
	echo '<tr><td>ブックマークはありません。</td></tr>';
}
?>
		</table>
	</div>
</td><td>
	<div class="toplist">
		<div class="topcaption">
			<h2><a href="message/">メッセージ</a></h2>
			<ul><li><a href="message/create.php">作成</a></li></ul>
			<div class="clearer"></div>
		</div>
		<table class="wrapper visited" cellspacing="0">
<?php
if (is_array($hash['message']) && count($hash['message']) > 0) {
	foreach ($hash['message'] as $row) {
?>
			<tr><td><?=$row['message_fromname']?>&nbsp;</td>
			<td><a href="message/view.php?id=<?=$row['id']?>"><?=$row['message_title']?></a>&nbsp;</td>
			<td><?=date('Y/m/d', strtotime($row['message_date']))?>&nbsp;</td></tr>
<?php
	}
} else {
	echo '<tr><td colspan="3">新しいメッセージはありません。</td></tr>';
}
?>
		</table>
	</div>
	<div class="toplist">
		<div class="topcaption">
			<h2><a href="forum/">フォーラム</a></h2>
			<ul><li><a href="forum/add.php">追加</a></li></ul>
			<div class="clearer"></div>
		</div>
		<table class="wrapper visited" cellspacing="0">
<?php
if (is_array($hash['forum']) && count($hash['forum']) > 0) {
	foreach ($hash['forum'] as $row) {
?>
			<tr><td><a href="forum/view.php?id=<?=$row['id']?>"><?=$row['forum_title']?></a>&nbsp;</td>
			<td><?=$row['forum_name']?>&nbsp;</td></tr>
<?php
	}
} else {
	echo '<tr><td colspan="2">新しい投稿はありません。</td></tr>';
}
?>
		</table>
	</div>
<?php
if (is_array($hash['project']) && count($hash['project']) > 0) {
?>
	<div class="toplist">
		<div class="topcaption">
			<h2><a href="project/">プロジェクト</a></h2>
			<ul><li><a href="project/add.php">追加</a></li></ul>
			<div class="clearer"></div>
		</div>
		<table class="wrapper" cellspacing="0">
<?php
	foreach ($hash['project'] as $row) {
?>
			<tr><td><a href="project/view.php?id=<?=$row['id']?>"><?=$row['project_title']?></a>&nbsp;</td>
			<td><?=date('Y/m/d', strtotime($row['project_begin']))?>&nbsp;-&nbsp;<?=date('Y/m/d', strtotime($row['project_end']))?></td></tr>
<?php
	}
	echo '</table></div>';
}
?>
</td></table>


<?php
$view->footing();
?>
