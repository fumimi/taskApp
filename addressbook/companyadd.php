<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->script('postcode.js');
$view->heading('アドレス追加');
$hash['data']['edit_level'] = $view->initialize($hash['data']['edit_level'], 0);
$hash['data']['folder_id'] = $view->initialize($hash['data']['folder_id'], intval($_GET['folder']));
$hash['folder'] = array('&nbsp;') + $hash['folder'];
?>
<div class="contentcontrol">
	<h1>アドレス追加</h1>
	<table class="addressbooktype" cellspacing="0"><tr>
		<td><a href="index.php">個人</a></td>
		<td><a class="current" href="company.php">法人</a></td>
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
	<li><a href="company.php<?=$view->parameter(array('folder'=>$_GET['folder']))?>">一覧に戻る</a></li>
</ul>
<form class="content" method="post" name="addressbook" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>会社名<span class="necessary">(必須)</span></th><td><input type="text" name="addressbook_company" class="inputvalue" value="<?=$hash['data']['addressbook_company']?>" /></td></tr>
		<tr><th>会社名（かな）</th><td><input type="text" name="addressbook_companyruby" class="inputvalue" value="<?=$hash['data']['addressbook_companyruby']?>" /></td></tr>
		<tr><th>部署</th><td><input type="text" name="addressbook_department" class="inputvalue" value="<?=$hash['data']['addressbook_department']?>" /></td></tr>
		<tr><th>郵便番号</th><td>
			<input type="text" name="addressbook_postcode" id="postcode" class="inputalpha" value="<?=$hash['data']['addressbook_postcode']?>" />&nbsp;
			<input type="button" value="検索" onclick="Postcode.feed(this)" />
		</td></tr>
		<tr><th>住所</th><td class="addressbookrelative">
			<input type="text" name="addressbook_address" id="address" class="inputtitle" value="<?=$hash['data']['addressbook_address']?>" />&nbsp;
			<input type="button" value="検索" onclick="Postcode.feed(this, 'address')" />
		</td></tr>
		<tr><th>住所（かな）</th><td><input type="text" name="addressbook_addressruby" id="addressruby" class="inputtitle" value="<?=$hash['data']['addressbook_addressruby']?>" /></td></tr>
		<tr><th>電話番号</th><td><input type="text" name="addressbook_phone" class="inputalpha" value="<?=$hash['data']['addressbook_phone']?>" /></td></tr>
		<tr><th>FAX</th><td><input type="text" name="addressbook_fax" class="inputalpha" value="<?=$hash['data']['addressbook_fax']?>" /></td></tr>
		<tr><th>メールアドレス</th><td><input type="text" name="addressbook_email" class="inputvalue" value="<?=$hash['data']['addressbook_email']?>" /></td></tr>
		<tr><th>URL</th><td><input type="text" name="addressbook_url" class="inputvalue" value="<?=$hash['data']['addressbook_url']?>" /></td></tr>
		<tr><th>備考</th><td><textarea name="addressbook_comment" class="inputcomment" rows="5"><?=$hash['data']['addressbook_comment']?></textarea></td></tr>
		<tr><th>カテゴリ</th><td><?=$helper->selector('folder_id', $hash['folder'], $hash['data']['folder_id'])?></td></tr>
		<tr><th>公開設定<?=$view->explain('public')?></th><td><?=$view->permit($hash['data'])?></td></tr>
		<tr><th>編集設定<?=$view->explain('edit')?></th><td><?=$view->permit($hash['data'], 'edit')?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='company.php<?=$view->parameter(array('folder'=>$_GET['folder']))?>'" />
	</div>
	<input type="hidden" name="addressbook_type" value="1" />
</form>
<?php
$view->footing();
?>