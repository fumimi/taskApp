<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('スレッド作成');
$hash['data']['folder_id'] = $view->initialize($hash['data']['folder_id'], intval($_REQUEST['folder']));
$hash['folder'] = array('&nbsp;') + $hash['folder'];
?>
<h1>スレッド作成</h1>
<ul class="operate">
	<li><a href="index.php<?=$view->parameter(array('folder'=>$_GET['folder']))?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="" enctype="multipart/form-data">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>タイトル<span class="necessary">(必須)</span></th><td><input type="text" name="forum_title" class="inputtitle" value="<?=$hash['data']['forum_title']?>" /></td></tr>
		<tr><th>内容<span class="necessary">(必須)</span></th><td><textarea name="forum_comment" class="inputcomment" rows="20"><?=$hash['data']['forum_comment']?></textarea></td></tr>
		<tr><th>&nbsp;</th><td><?=$view->uploadfile($hash['data']['forum_file'])?></td></tr>
		<tr><th>カテゴリ</th><td><?=$helper->selector('folder_id', $hash['folder'], $hash['data']['folder_id'])?></td></tr>
		<tr><th>公開設定<?=$view->explain('categorypublic')?></th><td><?=$view->permit($hash['data'], 'public', array(0=>'公開', 2=>'公開するグループ・ユーザーを設定'))?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->parameter(array('folder'=>$_GET['folder']))?>'" />
	</div>
</form>
<?php
$view->footing();
?>