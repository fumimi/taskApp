<?php

require_once('../application/loader.php');

$view->heading('ToDo編集');
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
		<h1 class="page-header">ToDo編集</h1>
	</div>
</div>





<ul class="list-inline">
	<li><a href="index.php" class="btn btn-default">一覧に戻る</a></li>
	<li><a href="delete.php?id=<?=$hash['data']['id']?>" class="btn btn-default">削除</a></li>
</ul>



<div class="row">
			<div class="col-lg-12">
					<div class="panel panel-default">
							<div class="panel-heading">
									Basic Form Elements
							</div>
							<div class="panel-body">
									<div class="row">
											<div class="col-lg-12">



												<form class="content" method="post" name="todo" action="">

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


															<?php
															if ($hash['data']['todo_complete'] == 1) {
																if(strlen($hash['data']['todo_completedate']) > 0) {
																	$completedate = strtotime($hash['data']['todo_completedate']);
																	$array = array(date('Y', $completedate), date('n', $completedate), date('j', $completedate), date('G', $completedate), date('i', $completedate));
																}
															?>
														<tr>


															<th>完了日</th>
															<td>
															<select name="completeyear"><option value="">&nbsp;</option><?=$helper->option(2000, 2020, $array[0])?></select>年&nbsp;
															<select name="completemonth"><option value="">&nbsp;</option><?=$helper->option(1, 12, $array[1])?></select>月&nbsp;
															<select name="completeday"><option value="">&nbsp;</option><?=$helper->option(1, 31, $array[2])?></select>日&nbsp;
															<select name="completehour"><option value="">&nbsp;</option><?=$helper->option(0, 23, $array[3])?></select>時&nbsp;
															<select name="completeminute"><option value="">&nbsp;</option><?=$helper->option(0, 59, $array[4])?></select>分&nbsp;
															</td>


														</tr>
															<?php
															}
															?>
														<tr>
															<th>重要度</th><td><?=$helper->selector('todo_priority', array('', '重要', '最重要'), $hash['data']['todo_priority'])?></td>
														</tr>




														<div class="form-group">
																<label>Text area 備考</label>
																<textarea name="todo_comment" class="form-control" rows="20"><?=$hash['data']['todo_comment']?></textarea>

														</div>



													</table>


													<div class="submit">
														<input type="submit" value="　編集　" class="btn btn-default">&nbsp;
														<input type="button" value="キャンセル" onclick="location.href='index.php'" class="btn btn-default">
													</div>
													<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />


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








<?php
$view->footing();
?>
