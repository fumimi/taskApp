<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->script('postcode.js');
$view->heading('アドレス詳細');
if ($hash['data']['addressbook_parent'] > 0) {
	$hash['data']['addressbook_company'] = sprintf('<a href="companyview.php?id=%d">%s</a>', $hash['data']['addressbook_parent'], $hash['data']['addressbook_company']);
}
?>
<div class="contentcontrol">
	<h1>アドレス詳細</h1>
	<table class="addressbooktype" cellspacing="0"><tr>
		<td><a class="current" href="index.php">個人</a></td>
		<td><a href="company.php">法人</a></td>
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
	<li><a href="index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>">一覧に戻る</a></li>
<?php
if ($view->permitted($hash['category'], 'add') && $view->permitted($hash['data'], 'edit')) {
	echo '<li><a href="edit.php?id='.$hash['data']['id'].'">編集</a></li>';
	echo '<li><a href="delete.php?id='.$hash['data']['id'].'">削除</a></li>';
}
?>
</ul>
<table class="view" cellspacing="0">
	<tr><th>名前</th><td><?=$hash['data']['addressbook_name']?>&nbsp;</td></tr>
	<tr><th>かな</th><td><?=$hash['data']['addressbook_ruby']?>&nbsp;</td></tr>
	<tr><th>郵便番号</th><td><?=$hash['data']['addressbook_postcode']?>&nbsp;</td></tr>
	<tr><th>住所</th><td><?=$hash['data']['addressbook_address']?>&nbsp;</td></tr>
	<tr><th>住所（かな）</th><td><?=$hash['data']['addressbook_addressruby']?>&nbsp;</td></tr>
	<tr><th>電話番号</th><td><?=$hash['data']['addressbook_phone']?>&nbsp;</td></tr>
	<tr><th>FAX</th><td><?=$hash['data']['addressbook_fax']?>&nbsp;</td></tr>
	<tr><th>携帯電話番号</th><td><?=$hash['data']['addressbook_mobile']?>&nbsp;</td></tr>
	<tr><th>メールアドレス</th><td><?=$hash['data']['addressbook_email']?>&nbsp;</td></tr>
	<tr><th>会社名</th><td><?=$hash['data']['addressbook_company']?>&nbsp;</td></tr>
	<tr><th>会社名（かな）</th><td><?=$hash['data']['addressbook_companyruby']?>&nbsp;</td></tr>
	<tr><th>部署</th><td><?=$hash['data']['addressbook_department']?>&nbsp;</td></tr>
	<tr><th>役職</th><td><?=$hash['data']['addressbook_position']?>&nbsp;</td></tr>
	<tr><th>URL</th><td><?=$hash['data']['addressbook_url']?>&nbsp;</td></tr>
	<tr><th>備考</th><td><?=nl2br($hash['data']['addressbook_comment'])?>&nbsp;</td></tr>
	<tr><th>カテゴリ</th><td><?=$hash['folder']['folder_caption']?>&nbsp;</td></tr>
</table>
<?php
$view->property($hash['data']);
$view->footing();
?>