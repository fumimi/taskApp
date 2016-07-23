<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->script('addressbook.js', 'postcode.js');
$view->heading('個人設定');
?>
<h1>個人設定</h1>
<ul class="operate">
	<li><a href="index.php">一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>名前<span class="necessary">(必須)</span></th><td><input type="text" name="realname" class="inputvalue" value="<?=$hash['data']['realname']?>" /></td></tr>
		<tr><th>かな</th><td><input type="text" name="user_ruby" class="inputvalue" value="<?=$hash['data']['user_ruby']?>" /></td></tr>
		<tr><th>郵便番号</th><td>
			<input type="text" name="user_postcode" id="postcode" class="inputalpha" value="<?=$hash['data']['user_postcode']?>" />&nbsp;
			<input type="button" value="検索" onclick="Postcode.feed(this)" />
		</td></tr>
		<tr><th>住所</th><td>
			<input type="text" name="user_address" id="address" class="inputtitle" value="<?=$hash['data']['user_address']?>" />&nbsp;
			<input type="button" value="検索" onclick="Postcode.feed(this, 'address')" />
		</td></tr>
		<tr><th>住所（かな）</th><td><input type="text" name="user_addressruby" id="addressruby" class="inputtitle" value="<?=$hash['data']['user_addressruby']?>" /></td></tr>
		<tr><th>電話番号</th><td><input type="text" name="user_phone" class="inputalpha" value="<?=$hash['data']['user_phone']?>" /></td></tr>
		<tr><th>携帯電話</th><td><input type="text" name="user_mobile" class="inputalpha" value="<?=$hash['data']['user_mobile']?>" /></td></tr>
		<tr><th>メールアドレス</th><td><input type="text" name="user_email" class="inputvalue" value="<?=$hash['data']['user_email']?>" /></td></tr>
		<tr><th>スカイプID</th><td><input type="text" name="user_skype" class="inputalpha" value="<?=$hash['data']['user_skype']?>" /></td></tr>
	</table>
	<h2>パスワードの変更</h2>
	<table class="form" cellspacing="0">
		<tr><th>現在のパスワード</th><td><input type="password" name="password" class="inputvalue" /></td></tr>
		<tr><th>新しいパスワード<?=$view->explain('userpassword')?></th><td><input type="password" name="newpassword" class="inputvalue" /></td></tr>
		<tr><th>新しいパスワード（確認）</th><td><input type="password" name="confirmpassword" class="inputvalue" /></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　編集　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php'" />
	</div>
</form>
<?php
$view->footing();
?>