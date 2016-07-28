<?php

require_once('../application/loader.php');

$view->heading('Task');
$pagination = new Pagination(array('folder'=>$_GET['folder']));

if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	foreach ($hash['folder'] as $key => $value) {
		$option .= '<option value="'.$key.'">'.$value.'</option>';
	}
}

if ($_GET['folder'] == 'complete') {
	$complete = '<span class="operator" onclick="App.move(\'incomplete\')">未完了</span>';
	$current['complete'] = ' class="current"';
} else {
	$complete = '<span class="operator" onclick="App.move(\'complete\')">完了</span>';
	if (strlen($_GET['folder']) <= 0) {
		$current['top'] = ' class="current"';
	} else {
		$current[intval($_GET['folder'])] = ' class="current"';
	}
}
?>



<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Task List <?=$view->caption($hash['folder'], array(0=>'全般', 'complete'=>'完了一覧'))?></h1>
	</div>
</div>






<div class="row">
			<div class="col-lg-12">
					<div class="panel panel-default">
							<div class="panel-heading">
									Basic Form Elements
							</div>
							<div class="panel-body">
									<div class="row">
											<div class="col-lg-12">



												<div class="foldercaption">Task</div>
												<ul>
													<li<?=$current['top']?>><a href="index.php"><i class="fa fa-folder fa-fw"></i> 未完了一覧</a></li>
													<li<?=$current['complete']?>><a href="index.php?folder=complete"><i class="fa fa-folder fa-fw"></i> 完了一覧</a></li>
												</ul>

												<div class="foldercaption">Folder</div>

													<ul>
														<li<?=$current[0]?>><a href="index.php?folder=0"><i class="fa fa-folder fa-fw"></i> 全般</a></li>
															<?php
															if (is_array($hash['folder']) && count($hash['folder']) > 0) {
																foreach ($hash['folder'] as $key => $value) {
																	echo sprintf('<li%s><a href="index.php?folder=%s">%s</a></li>', $current[$key], $key, $value);
																}
															}
															?>
												</ul>

												<div class="folderoperate"><a href="../folder/?type=todo">編集</a></div>



											</div>

									</div>
									<!-- /.row (nested) -->
							</div>
							<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->


	<div class="row">
				<div class="col-lg-12">
						<div class="panel panel-default">
								<div class="panel-heading">
										Basic Form Elements
								</div>
								<div class="panel-body">
										<div class="row">
												<div class="col-lg-12">







													<form method="post" name="checkedform" action="">
														<table class="table table-hover" cellspacing="0">
															<!-- タイトルエリア　start -->
															<tr>
																<th class="listcheck"><input type="checkbox" value="" onclick="App.checkall(this)" /></th>
																<th colspan="2"><?=$pagination->sortby('todo_title', 'ToDo')?></th>
																<th><?=$pagination->sortby('todo_term', '期限')?></th>
																	<?php
																	if (strlen($_GET['folder']) > 0) {
																		echo '<th>'.$pagination->sortby('todo_completedate', '完了日').'</th>';
																	}
																	?>
																<th><?=$pagination->sortby('todo_priority', '重要度')?></th>
																<th><?=$pagination->sortby('folder_id', 'フォルダ')?></th>
															</tr>
															<!-- タイトルエリア　end -->


																<?php

																if (is_array($hash['list']) && count($hash['list']) > 0) {
																	$priority = array('', '<span class="todoimportant">重要</span>', '<span class="todopriority">最重要</span>');

																	foreach ($hash['list'] as $row) {

																		$classrow = '';
																		$completedate = '';

																		if ($row['todo_complete'] == 1) {
																			$string = '<span class="todocomplete">完了</span>';
																			$classrow = ' class="todocompleterow"';
																			$completedate = date('Y/m/d H:i', strtotime($row['todo_completedate']));
																		} elseif (strlen($row['todo_term']) > 0 && date('Ymd', strtotime($row['todo_term'])) < date('Ymd')) {
																			$string = '<span class="todoimportant">期限超過</span>';
																		} else {
																			$string = '<span class="todoincomplete">未完了</span>';
																		}

																		if (strlen($row['todo_term']) > 0) {
																			$row['todo_term'] = date('Y/m/d', strtotime($row['todo_term']));
																		}

																		if (strlen($row['todo_user']) > 0) {
																			$classshare = ' class="share"';
																		} else {
																			$classshare = '';
																		}

																		if($row['todo_priority'] == 1){
																			$classrow = ' class="warning"';
																		} else if($row['todo_priority'] == 2){
																			$classrow = ' class="danger"';
																		} else {
																		}

																?>
															<tr<?=$classrow?>>
																<td class="listcheck"><input type="checkbox" name="checkedid[]" value="<?=$row['id']?>" /></td>
																<td class="todocomplete"><?=$string?>&nbsp;</td>
																<td class="todo_title"><a<?=$classshare?> href="view.php?id=<?=$row['id']?>"><?=$row['todo_title']?></a>&nbsp;</td>
																<td class="completedate"><?=$row['todo_term']?>&nbsp;</td>
																	<?php
																			if (strlen($_GET['folder']) > 0) {
																				echo '<td>'.$completedate.'&nbsp;</td>';
																			}
																	?>
																<td><?=$priority[$row['todo_priority']]?>&nbsp;</td>
																<td><?=$hash['folder'][$row['folder_id']]?>&nbsp;</td>
															</tr>

																<?php
																	}
																}
																?>
														</table>
														<?=$view->pagination($pagination, $hash['count']);?>
														<input type="hidden" name="folder" value="" />
													</form>




													<ul class="list-inline">
														<li class="btn btn-default"><a href="add.php">ToDo追加</a></li>
														<li class="btn btn-default"><?=$complete?></li>
														<li class="btn btn-default"><span class="operator" onclick="App.move(-1)">削除</span></li>
														<li><select name="move" onchange="App.move(this)">
															<option value="">フォルダ移動</option>
															<?=$option?>
															<option value="0">なし</option></select>
														</li>
													</ul>


													<div class="form-group input-group">
														<?=$view->searchform(array('folder'=>$_GET['folder']))?>
													</div>













												</div>

										</div>
										<!-- /.row (nested) -->
								</div>
								<!-- /.panel-body -->
						</div>
						<!-- /.panel -->
				</div>
				<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->






<?php
$view->footing();
?>
