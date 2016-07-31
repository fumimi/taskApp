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
	$complete = '<span class="operator btn btn-warning" onclick="App.move(\'incomplete\')">未完了</span>';
	$current['complete'] = ' class="current"';
} else {
	$complete = '<span class="operator btn btn-success" onclick="App.move(\'complete\')"><i class="fa fa-check fa-fw"></i> Complete</span>';
	if (strlen($_GET['folder']) <= 0) {
		$current['top'] = ' class="current"';
	} else {
		$current[intval($_GET['folder'])] = ' class="current"';
	}
}

?>

<style>
.list-inline li {
	margin-bottom: 5px;
}
@media screen and (max-width: 640px) {
	.pc {
		display: none;
	}
}
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Task List <?=$view->caption($hash['folder'], array(0=>'全般', 'complete'=>'完了一覧'))?></h1>
	</div>
</div>






<div class="row">
			<div class="col-lg-12">
					<div class="panel panel-default">
							<div class="panel-heading">
									Task or Folder
							</div>
							<div class="panel-body">
									<div class="row">
											<div class="col-lg-12">
												<h3>Task</h3>

												<!-- <div class="foldercaption">Task</div> -->
												<ul class="list-inline">
													<li<?=$current['top']?>><a href="index.php" class="btn btn-default"><i class="fa fa-folder-open-o fa-fw"></i> 未完了一覧</a></li>
													<li<?=$current['complete']?>><a href="index.php?folder=complete" class="btn btn-default"><i class="fa fa-folder-open-o fa-fw"></i> 完了一覧</a></li>
												</ul>

												<h3>Folder</h3>

												<ul class="list-inline">
													<li<?=$current[0]?>><a href="index.php?folder=0" class="btn btn-default"><i class="fa fa-folder-open-o fa-fw"></i> All</a></li>
													<?php
													if (is_array($hash['folder']) && count($hash['folder']) > 0) {
														foreach ($hash['folder'] as $key => $value) {
															echo sprintf('<li%s><a href="index.php?folder=%s" class="btn btn-default"><i class="fa fa-folder-open-o fa-fw"></i> %s</a></li>', $current[$key], $key, $value);
														}
													}
													?>
												</ul>

												<div class="folderoperate btn btn-default"><a href="../folder/?type=todo">編集</a></div>

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
										Task List
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
																<th class="pc"><?=$pagination->sortby('todo_term', '期限')?></th>
																	<?php
																	if (strlen($_GET['folder']) > 0) {
																		echo '<th class="pc">'.$pagination->sortby('todo_completedate', '完了日').'</th>';
																	}
																	?>
																<th class="pc"><?=$pagination->sortby('todo_priority', '重要度')?></th>
																<th class="pc"><?=$pagination->sortby('folder_id', 'フォルダ')?></th>
															</tr>
															<!-- タイトルエリア　end -->


																<?php

																if (is_array($hash['list']) && count($hash['list']) > 0) {
																	$priority = array('', '<span>重要</span>', '<span>最重要</span>');

																	foreach ($hash['list'] as $row) {

																		$classrow = '';
																		$completedate = '';

																		if ($row['todo_complete'] == 1) {
																			$string = '<span class="todocomplete">完了</span>';
																			$classrow = ' class="todocompleterow"';
																			$completedate = date('Y/m/d H:i', strtotime($row['todo_completedate']));
																		} elseif (strlen($row['todo_term']) > 0 && date('Ymd', strtotime($row['todo_term'])) < date('Ymd')) {
																			$string = '<span>期限超過</span>';
																		} else {
																			$string = '<span>未完了</span>';
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
																<td class="pc"><?=$string?></td>
																<td class=""><a<?=$classshare?> href="view.php?id=<?=$row['id']?>"><?=$row['todo_title']?></a></td>
																<td class="pc"><?=$row['todo_term']?></td>
																	<?php
																			if (strlen($_GET['folder']) > 0) {
																				echo '<td class="pc">'.$completedate.'</td>';
																			}
																	?>
																<td class="pc"><?=$priority[$row['todo_priority']]?></td>
																<td class="pc"><?=$hash['folder'][$row['folder_id']]?></td>
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
														<li><a href="add.php" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Add</a></li>
														<li><?=$complete?></li>
														<li><span class="operator btn btn-danger" onclick="App.move(-1)"><i class="fa fa-times fa-fw"></i> Delete</span></li>
														<li>
															<select name="move" onchange="App.move(this)" class="form-control">
															<option value="">フォルダ移動</option>
															<?=$option?>
															<option value="0">なし</option></select>
														</li>
													</ul>

														<?=$view->searchform(array('folder'=>$_GET['folder']))?>

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
