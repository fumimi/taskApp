<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('プロジェクト追加');
$begin = strtotime($hash['data']['project_begin']);
$end = strtotime($hash['data']['project_end']);
$hash['folder'] = array('&nbsp;') + $hash['folder'];
?>
<h1>プロジェクト追加</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->parameter(array('folder'=>$hash['data']['folder_id']))?>">一覧に戻る</a></li>
	<li><a href="delete.php?id=<?=$hash['data']['id']?>">削除</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>タイトル<span class="necessary">(必須)</span></th><td><input type="text" name="project_title" class="inputtitle" value="<?=$hash['data']['project_title']?>" /></td></tr>
		<tr><th>開始<span class="necessary">(必須)</span></th><td>
			<select name="beginyear"><?=$helper->option(2000, 2020, date('Y', $begin))?></select>年&nbsp;
			<select name="beginmonth"><?=$helper->option(1, 12, date('n', $begin))?></select>月&nbsp;
			<select name="beginday"><?=$helper->option(1, 31, date('j', $begin))?></select>日
		</td></tr>
		<tr><th>終了<span class="necessary">(必須)</span></th><td>
			<select name="endyear"><?=$helper->option(2000, 2020, date('Y', $end))?></select>年&nbsp;
			<select name="endmonth"><?=$helper->option(1, 12, date('n', $end))?></select>月&nbsp;
			<select name="endday"><?=$helper->option(1, 31, date('j', $end))?></select>日
		</td></tr>
		<tr><th>内容</th><td><textarea name="project_comment" class="inputcomment" rows="10"><?=$hash['data']['project_comment']?></textarea></td></tr>
		<tr><th>カテゴリ</th><td><?=$helper->selector('folder_id', $hash['folder'], $hash['data']['folder_id'])?></td></tr>
		<tr><th>公開設定<?=$view->explain('public')?></th><td><?=$view->permit($hash['data'])?></td></tr>
		<tr><th>編集設定<?=$view->explain('edit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　編集　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->parameter(array('folder'=>$hash['data']['folder_id']))?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
	<input type="hidden" name="project_parent" value="<?=$hash['data']['project_parent']?>" />
</form>
<?php
$view->footing();
?>