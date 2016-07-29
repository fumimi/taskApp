<?php

require_once('../application/loader.php');

$view->heading('ToDo詳細');
if (is_array($hash['folder']) && count($hash['folder']) > 0) {
	foreach ($hash['folder'] as $key => $value) {
		$option .= '<option value="'.$key.'">'.$value.'</option>';
	}
}
$priority = array('', '<span class="btn btn-default">重要</span>', '<span class="btn btn-default">最重要</span>');

if ($hash['data']['todo_complete'] == 1) {
	$status = '<span class="btn btn-default">完了</span>';
	$complete = '<span class="btn btn-default" onclick="App.move(\'incomplete\')">未完了</span>';
	$redirect = '?folder=complete';
	if (strlen($hash['data']['todo_completedate']) > 0) {
		$hash['data']['todo_completedate'] = date('Y年n月j日 G時i分', strtotime($hash['data']['todo_completedate']));
	}
	$completedate = '<tr><th>完了日</th><td>'.$hash['data']['todo_completedate'].'&nbsp;</td></tr>';
} else {
	$status = '<span>未完了</span>';
	if (strlen($hash['data']['todo_term']) > 0 && date('Ymd', strtotime($hash['data']['todo_term'])) < date('Ymd')) {
		$status .= '&nbsp;<span class="btn btn-default">期限超過</span>';
	}
	$complete = '<span class="btn btn-default" onclick="App.move(\'complete\')">完了</span>';
}
if (strlen($hash['data']['todo_term']) > 0) {
	$hash['data']['todo_term'] = date('Y年n月j日', strtotime($hash['data']['todo_term']));
}
?>


<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Task</h1>
	</div>
</div>



<ul class="list-inline">
	<li><a href="index.php<?=$redirect?>" class="btn btn-default">一覧に戻る</a></li>
	<li><?=$complete?></li>
	<li><a href="edit.php?id=<?=$hash['data']['id']?>" class="btn btn-default">編集</a></li>
	<li><a href="delete.php?id=<?=$hash['data']['id']?>" class="btn btn-default">削除</a></li>
	<li>
		<select name="move" onchange="App.move(this)" class="form-control">
			<option value="">フォルダ移動</option>
			<?=$option?>
			<option value="0">フォルダなし</option>
		</select>
	</li>
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



												<table class="table table-hover" cellspacing="0">
													<tr><th>ステータス</th><td><?=$status?>&nbsp;</td></tr>
													<tr><th>タイトル</th><td><?=$hash['data']['todo_title']?>&nbsp;</td></tr>
													<tr><th>名前</th><td><?=$hash['data']['todo_name']?>&nbsp;</td></tr>
													<tr><th>期限</th><td><?=$hash['data']['todo_term']?>&nbsp;</td></tr>
													<?=$completedate?>
													<tr><th>重要度</th><td><?=$priority[$hash['data']['todo_priority']]?>&nbsp;</td></tr>
													<tr><th>備考</th><td><?=nl2br($hash['data']['todo_comment'])?>&nbsp;</td></tr>
													<tr><th>フォルダ</th><td><?=$hash['folder'][$hash['data']['folder_id']]?>&nbsp;</td></tr>
													<tr><th>表示先</th><td>
												<?php
												if (strlen($hash['data']['todo_user']) > 0) {
													$array = explode(',', str_replace(array('][', '[', ']'), array(',', '', ''), $hash['data']['todo_user']));
													if (is_array($array) && count($array) > 0) {
														echo '<table class="todouser" cellspacing="0">';
														foreach ($array as $value) {
															if (isset($hash['list'][$value])) {
																if ($hash['list'][$value] == 1) {
																	$string = '<td class="todocomplete">完了</td>';
																} else {
																	$string = '<td class="todoincomplete">未完了</td>';
																}
															} else {
																$string = '<td>不明</td>';
															}
															echo '<tr><td>'.$hash['user'][$value].'</td>'.$string.'</tr>';
														}
														echo '</table>';
													}
												} else {
													echo '登録者';
												}
												?>
													</td></tr>
												</table>




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



												<?=$view->property($hash['data'])?>
												<form method="post" name="checkedform" action="">
													<input type="hidden" name="checkedid[]" value="<?=$hash['data']['id']?>" />
													<input type="hidden" name="folder" value="" />
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
