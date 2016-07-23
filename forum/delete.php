<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
if ($hash['data']['forum_parent'] <= 0) {
	$redirect = 'view.php?id='.$hash['data']['id'];
	$caption = 'スレッド';
	if ($hash['data']['public_level'] == 2) {
		$statuspublic = $view->permitlist($hash['data'], 'public');
	} else {
		$statuspublic = '公開';
	}
} else {
	$redirect = 'view.php?id='.$hash['data']['forum_parent'];
	$caption = 'コメント';
}
$view->heading($caption.'削除');
?>
<h1><?=$caption?>削除</h1>
<ul class="operate">
	<li><a href="<?=$redirect?>">スレッドに戻る</a></li>
</ul>
<form class="content" method="post" action="">
<?php
echo $view->error($hash['error'], '下記の'.$caption.'を削除します。');
if ($hash['data']['forum_parent'] <= 0) {
?>
	<div class="forum">
		<div class="forumtitle"><?=$hash['data']['forum_title']?></div>
		<div class="forumproperty">
			<span>投稿者：<?=$hash['data']['forum_name']?></span>
			<span><?=date('Y/m/d H:i:s', strtotime($hash['data']['forum_date']))?></span>
			<span>公開設定：<?=$statuspublic?></span>
		</div>
		<div class="forumcontent">
			<div><?=nl2br($hash['data']['forum_comment'])?></div>
			<?=$view->attachment($hash['data']['id'], 'forum', $hash['data']['owner'].'_'.strtotime($hash['data']['forum_date']), $hash['data']['forum_file'])?>
		</div>
	</div>
<?php
} else {
?>
	<div class="forum">
		<div class="forumtitle"><?=$hash['data']['forum_name']?></div>
		<div class="forumproperty"><?=date('Y/m/d H:i:s', strtotime($hash['data']['forum_date']))?></div>
		<div class="forumcontent">
			<div><?=nl2br($hash['data']['forum_comment'])?></div>
			<?=$view->attachment($hash['data']['id'], 'forum', $hash['data']['owner'].'_'.strtotime($hash['data']['forum_date']), $hash['data']['forum_file'])?>
		</div>
	</div>
<?php
}
?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='<?=$redirect?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
	<input type="hidden" name="forum_parent" value="<?=$hash['data']['forum_parent']?>" />
</form>
<?php
$view->footing();
?>