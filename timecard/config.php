<?php

require_once('../application/loader.php');
$view->heading('タイムカード設定');
$array = array('0'=>'00', '10'=>'10', '20'=>'20', '30'=>'30', '40'=>'40', '50'=>'50');
?>
<h1>タイムカード設定</h1>
<ul class="operate">
	<li><a href="group.php">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>出社時刻<?=$view->explain('timecardopen')?></th><td>
			<select name="timecard[openhour]"><?=$helper->option(0, 23, $hash['data']['openhour'])?></select>時&nbsp;
			<?=$helper->selector('timecard[openminute]', $array, $hash['data']['openminute'])?>分&nbsp;
		</td></tr>
		<tr><th>最終時刻<?=$view->explain('timecardclose')?></th><td>
			<select name="timecard[closehour]"><?=$helper->option(0, 23, $hash['data']['closehour'])?></select>時&nbsp;
			<?=$helper->selector('timecard[closeminute]', $array, $hash['data']['closeminute'])?>分&nbsp;
		</td></tr>
		<tr><th>出退社計算単位<?=$view->explain('timecardround')?></th><td>
			<?=$helper->radio('timecard[timeround]', 0, $hash['data']['timeround'], 'timeround0', '1分単位')?>
			<?=$helper->radio('timecard[timeround]', 1, $hash['data']['timeround'], 'timeround1', '10分単位')?>
		</td></tr>
		<tr><th>固定外出時刻<?=$view->explain('timecardlunch')?></th><td>
			<select name="timecard[lunchopenhour]"><?=$helper->option(0, 23, $hash['data']['lunchopenhour'])?></select>時&nbsp;
			<?=$helper->selector('timecard[lunchopenminute]', $array, $hash['data']['lunchopenminute'])?>分&nbsp;
			-&nbsp;
			<select name="timecard[lunchclosehour]"><?=$helper->option(0, 23, $hash['data']['lunchclosehour'])?></select>時&nbsp;
			<?=$helper->selector('timecard[lunchcloseminute]', $array, $hash['data']['lunchcloseminute'])?>分&nbsp;
		</td></tr>
		<tr><th>外出時間計算単位<?=$view->explain('timecardlunchround')?></th><td>
			<?=$helper->radio('timecard[intervalround]', 0, $hash['data']['intervalround'], 'intervalround0', '1分単位')?>
			<?=$helper->radio('timecard[intervalround]', 1, $hash['data']['intervalround'], 'intervalround1', '10分単位')?>
		</td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　設定　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php'" />
	</div>
</form>
<?php
$view->footing();
?>