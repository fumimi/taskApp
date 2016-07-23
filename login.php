<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('application/loader.php');
$authority = new Authority;
$error = $authority->login();
$caption = APP_TYPE;
$onload = ' onload="document.forms[\'login\'].elements[\'userid\'].focus()"';
require_once(DIR_VIEW.'header.php');
?>
<div class="header">
	<div class="headertitle">
		<a href="<?=$root?>index.php"><img src="<?=$root?>images/title.gif" /></a>
	</div>
	<div class="clearer"></div>
</div>
<form class="login" method="post" name="login" action="login.php">
	<h1>ログイン</h1>
	<?=$view->error($error)?>
	<table cellspacing="0">
		<tr><th>ユーザー名</th><td><input type="text" name="userid" class="logininput" value="<?=$view->escape($_POST['userid'])?>" /></td></tr>
		<tr><th>パスワード</th><td><input type="password" name="password" class="logininput" value="" /></td></tr>
	</table>
	<div class="loginsubmit"><input type="submit" value="　ログイン　" /></div>
</form>
<?php
require_once(DIR_VIEW.'footer.php');
?>