<?php

require_once('../application/loader.php');

$view->heading('ToDo削除');
$priority = array('', '<span class="todoimportant">重要</span>', '<span class="todopriority">最重要</span>');
if ($hash['data']['todo_complete'] == 1) {
	$status = '<span class="todocomplete">完了</span>';
	$complete = '<span class="operator" onclick="App.move(\'incomplete\')">未完了</span>';
	$redirect = '?folder=complete';
	if (strlen($hash['data']['todo_completedate']) > 0) {
		$hash['data']['todo_completedate'] = date('Y年n月j日 G時i分', strtotime($hash['data']['todo_completedate']));
	}
	$completedate = '<tr><th>完了日</th><td>'.$hash['data']['todo_completedate'].'&nbsp;</td></tr>';
} else {
	$status = '<span class="todoincomplete">未完了</span>';
	if (strlen($hash['data']['todo_term']) > 0 && date('Ymd', strtotime($hash['data']['todo_term'])) < date('Ymd')) {
		$status .= '&nbsp;<span class="todoimportant">期限超過</span>';
	}
	$complete = '<span class="operator" onclick="App.move(\'complete\')">完了</span>';
}
if (strlen($hash['data']['todo_term']) > 0) {
	$hash['data']['todo_term'] = date('Y年n月j日', strtotime($hash['data']['todo_term']));
}
if (strlen($hash['data']['todo_user']) > 0) {
	$hash['data']['todo_level'] = 2;
	$string = $view->permitlist($hash['data'], 'todo');
}
?>


<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">ToDo削除</h1>
	</div>
</div>



<ul class="operate">
	<li><a href="index.php<?=$redirect?>">一覧に戻る</a></li>
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



												<form class="content" method="post" action="">
													<?=$view->error($hash['error'], '下記のToDoを削除します。')?>
													<table class="view" cellspacing="0">
														<tr><th>ステータス</th><td><?=$status?>&nbsp;</td></tr>
														<tr><th>タイトル</th><td><?=$hash['data']['todo_title']?>&nbsp;</td></tr>
														<tr><th>名前</th><td><?=$hash['data']['todo_name']?>&nbsp;</td></tr>
														<tr><th>期限</th><td><?=$hash['data']['todo_term']?>&nbsp;</td></tr>
														<?=$completedate?>
														<tr><th>重要度</th><td><?=$priority[$hash['data']['todo_priority']]?>&nbsp;</td></tr>
														<tr><th>備考</th><td><?=nl2br($hash['data']['todo_comment'])?>&nbsp;</td></tr>
														<tr><th>フォルダ</th><td><?=$hash['folder'][$hash['data']['folder_id']]?>&nbsp;</td></tr>
														<tr><th>表示先</th><td><?=$string?>&nbsp;</td></tr>
													</table>
													<div class="submit">
														<input type="submit" value="　削除　" />&nbsp;
														<input type="button" value="キャンセル" onclick="location.href='index.php'" />
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
