<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('メンバー詳細');
?>
<h1>メンバー詳細</h1>
<ul class="operate">
	<li><a href="index.php?group=<?=$hash['data']['user_group']?>">一覧に戻る</a></li>
<?php if ($hash['data']['userid'] == $_SESSION['userid']) { ?>
	<li><a href="edit.php">個人設定</a></li>
<?php } ?>
</ul>
<table class="view" cellspacing="0">
	<tr><th>名前</th><td><?=$hash['data']['realname']?>&nbsp;</td></tr>
	<tr><th>かな</th><td><?=$hash['data']['user_ruby']?>&nbsp;</td></tr>
	<tr><th>グループ</th><td><?=$hash['data']['user_groupname']?>&nbsp;</td></tr>
	<tr><th>郵便番号</th><td><?=$hash['data']['user_postcode']?>&nbsp;</td></tr>
	<tr><th>住所</th><td><?=$hash['data']['user_address']?>&nbsp;</td></tr>
	<tr><th>住所（かな）</th><td><?=$hash['data']['user_addressruby']?>&nbsp;</td></tr>
	<tr><th>電話番号</th><td><?=$hash['data']['user_phone']?>&nbsp;</td></tr>
	<tr><th>携帯電話</th><td><?=$hash['data']['user_mobile']?>&nbsp;</td></tr>
	<tr><th>メールアドレス</th><td><a href="mailto:<?=$hash['data']['user_email']?>"><?=$hash['data']['user_email']?></a>&nbsp;</td></tr>
	<tr><th>スカイプID</th><td><?=$hash['data']['user_skype']?>&nbsp;</td></tr>
</table>
<?php
$view->footing();
?>