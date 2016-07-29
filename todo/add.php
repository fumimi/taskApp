<?php

require_once('../application/loader.php');

$view->heading('ToDo追加');
if (strlen($hash['data']['todo_term']) > 0) {
	$timestamp = strtotime($hash['data']['todo_term']);
} else {
	$timestamp = time();
}
if ($hash['data']['todo_noterm'] == 1) {
	$disabled = ' disabled="disabled"';
}
?>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Task Add</h1>
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
													<form class="content" method="post" action="">

															<?=$view->error($hash['error'])?>


															<div class="form-group">
																	<label>タイトル<span class="necessary">(必須)</span></label>
																	<input type="text" name="todo_title" class="form-control" value="<?=$hash['data']['todo_title']?>" />
																	<!-- <p class="help-block">Example block-level help text here.</p> -->
															</div>

															<div class="form-group">
																	<label>期限</label>
																	<select name="todo_year"<?=$disabled?>><?=$helper->option(2000, 2020, date('Y', $timestamp))?></select>年&nbsp;
																	<select name="todo_month"<?=$disabled?>><?=$helper->option(1, 12, date('n', $timestamp))?></select>月&nbsp;
																	<select name="todo_day"<?=$disabled?>><?=$helper->option(1, 31, date('j', $timestamp))?></select>日&nbsp;
																	<?=$helper->checkbox('todo_noterm', 1, $hash['data']['todo_noterm'], 'todo_noterm', '期限なし', 'onclick="Todo.noterm(this)"')?>
															</div>

															<div class="form-group">
																	<label>重要度</label>
																	<?=$helper->selector('todo_priority', array('', '重要', '最重要'), $hash['data']['todo_priority'])?>
															</div>


																<div class="form-group">
																		<label>Text area 備考</label>
																		<textarea name="todo_comment" class="form-control" rows="20"><?=$hash['data']['todo_comment']?></textarea>
																</div>


																<div class="form-group">
																		<label>表示先<?=$view->explain('todolevel')?></label>
																		<?=$view->permit($hash['data'], 'todo', array(1=>'登録者', 2=>'表示するユーザーを設定'), 1)?>
																</div>


															<div class="submit">
																<input type="submit" value="　追加　" class="btn btn-default" />&nbsp;
																<input type="button" value="キャンセル" class="btn btn-default" onclick="location.href='index.php'" />
															</div>





													</form>
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






<p><a href="index.php" class="btn btn-primary">一覧に戻る</a></p>



<?php
$view->footing();
?>
