<?php

require_once('application/loader.php');

$view->script('general.js');
$view->heading('Dashboard', 'top');
$hash['group'] = array('グループ') + $hash['group'];
$calendar = new Calendar;
$previous = mktime(0, 0, 0, $hash['month'], $hash['day'] - 7, $hash['year']);
$next = mktime(0, 0, 0, $hash['month'], $hash['day'] + 7, $hash['year']);
$week = array('日', '月', '火', '水', '木', '金', '土');
$caption = $hash['year'].'年'.$hash['month'].'月'.$hash['day'].'日('.$week[$hash['weekday']].')';

?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard</h1>
	</div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
					<div class="panel-heading">
							<i class="fa fa-calendar fa-fw"></i> Schedule
							<div class="pull-right">
									<div class="btn-group">
											<button data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle" type="button">
													Actions
													<span class="caret"></span>
											</button>
											<ul role="menu" class="dropdown-menu pull-right">
													<li><a href="#">Action</a>
													</li>
													<li><a href="#">Another action</a>
													</li>
													<li><a href="#">Something else here</a>
													</li>
													<li class="divider"></li>
													<li><a href="#">Separated link</a>
													</li>
											</ul>
									</div>
							</div>
					</div>
            <div class="panel-body">
                <div class="row show-grid">

									<table class="wrapper" cellspacing="0">
										<tr>
											<td class="schedulecaption">
												<a href="schedule/groupweek.php<?=$calendar->parameter(date('Y', $previous), date('n', $previous), date('j', $previous))?>"><img src="images/arrowprevious.gif" class="schedulearrow" /></a>
												<a href="schedule/groupweek.php<?=$calendar->parameter($hash['year'], $hash['month'], $hash['day'])?>"><?=$caption?></a>
												<a href="schedule/groupweek.php<?=$calendar->parameter(date('Y', $next), date('n', $next), date('j', $next))?>"><img src="images/arrownext.gif" class="schedulearrow" /></a>
											</td>
										</tr>
									</table>

									<table class="schedulegroup paragraph" cellspacing="0">
										<tr>
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

									?>
									</tr></table>

									<!-- <button type="button" class="btn btn-primary">
										<a href="schedule/add.php<?=$calendar->parameter($hash['year'], $hash['month'], $hash['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>">予定追加</a>
									</button> -->

									<p><a class="btn btn-primary" href="schedule/add.php<?=$calendar->parameter($hash['year'], $hash['month'], $hash['day'], array('group'=>'', 'member'=>'', 'facility'=>''))?>"><i class="fa fa-plus fa-fw"></i> Add</a></p>





									<div class="form-group">
										<?=$helper->selector('groupweek', $hash['group'], '', ' onchange="General.redirect(this,'.$hash['year'].','.$hash['month'].','.$hash['day'].')"')?>
									</div>




                </div>



            </div>
        </div>
    </div>
		<!-- /.col-lg-12 -->
</div>
<!-- /.row -->



<!-- /.row -->
<div class="row">
		<div class="col-lg-6">
				<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-check-square-o fa-fw"></i> Task
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">

							<form method="post" class="" name="checkedform" action="">
								<!-- topcaption start -->
								<!-- <div class="topcaption">
									<ul>
										<li><span class="operator" onclick="App.move('complete')">完了</span></li>
									</ul>
								</div> -->
								<!-- topcaption end -->

								<div class="clearer"></div>

								<table class="table table-hover" cellspacing="0">
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
									<tr>
										<td style="width:20px;"><input type="checkbox" name="checkedid[]" value="<?=$row['id']?>" /></td>
										<td><a<?=$classshare?> href="todo/view.php?id=<?=$row['id']?>"><?=$row['todo_title']?></a>&nbsp;</td>
										<td><?=$row['todo_term']?>&nbsp;</td>
										<td><?=$priority[$row['todo_priority']]?>&nbsp;</td>
									</tr>
									<?php
										}
									} else {
										echo '<tr><td colspan="4">ToDoはありません。</td></tr>';
									}
									?>
								</table>
								<p>
									<a href="todo/add.php" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add</a>
									<span class="operator btn btn-success" onclick="App.move('complete')"><i class="fa fa-check  fa-fw"></i> Complete</span>
									<?=$complete?>
								</p>

							</form>



							<!-- <form method="post" class="toplist" name="checkedform" action="">
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
							</form> -->





						</div>
						<!-- .panel-body -->
				</div>
				<!-- /.panel -->
		</div>
		<!-- /.col-lg-6 -->
		<div class="col-lg-6">
				<div class="panel panel-default">
						<div class="panel-heading">
							<i class="glyphicon glyphicon-time"></i> Timecard
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">

							<form method="post" class="" action="">
								<!-- <div class="topcaption">
									<h2><a href="timecard/">タイムカード</a></h2>
									<ul>
										<li><a href="timecard/edit.php">編集</a></li>
									</ul>
								</div> -->
								<div class="clearer"></div>

								<table class="table table-hover" cellspacing="0">
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

								<p><a href="timecard/edit.php" class="btn btn-success"><i class="fa fa-refresh fa-fw"></i> Update</a></p>

							</form>




						</div>
						<!-- .panel-body -->
				</div>
				<!-- /.panel -->
		</div>
		<!-- /.col-lg-6 -->
</div>
<!-- /.row -->
<div class="row">
		<div class="col-lg-6">
				<div class="panel panel-default">
						<div class="panel-heading">
								<i class="fa fa-bookmark fa-fw"></i> Bookmark
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">

							<!-- <div class="topcaption">
								<ul>
									<li><a href="bookmark/add.php" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add</a></li>
								</ul>
								<div class="clearer"></div>
							</div> -->
							<table class="table table-hover" cellspacing="0">
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
							<p><a href="bookmark/add.php" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add</a></p>



						</div>
						<!-- .panel-body -->
				</div>
				<!-- /.panel -->
		</div>
		<!-- /.col-lg-6 -->
		<div class="col-lg-6">
				<div class="panel panel-default">
						<div class="panel-heading">
								<i class="fa fa-comments fa-fw"></i> Comments
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">

							<!-- <div class="topcaption">
								<ul>
									<li><a href="forum/add.php" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add</a></li>
								</ul>
								<div class="clearer"></div>
							</div> -->
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
							<p><a href="forum/add.php" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add</a></p>

						</div>
						<!-- .panel-body -->
				</div>
				<!-- /.panel -->
		</div>
		<!-- /.col-lg-6 -->
</div>
<!-- /.row -->










<table class="wrapper" cellspacing="0">
	<tr>
		<td>
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

			<?php
			if (is_array($hash['project']) && count($hash['project']) > 0) {
			?>

		<div class="toplist">
			<div class="topcaption">
				<h2><a href="project/">プロジェクト</a></h2>
				<ul>
					<li><a href="project/add.php" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add</a></li>
				</ul>
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
		}
		?>
		</table>
		</div>
	</td>
	</tr>
</table>





<?php
$view->footing();
?>
