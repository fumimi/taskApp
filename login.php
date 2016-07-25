<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

ini_set( 'display_errors', 1 );

require_once('application/loader.php');
$authority = new Authority;
$error = $authority->login();
$caption = APP_TYPE;
$onload = ' onload="document.forms[\'login\'].elements[\'userid\'].focus()"';

require_once(DIR_VIEW.'header.php');
?>

<div class="container">
		<div class="row">
				<div class="col-md-4 col-md-offset-4">
						<div class="login-panel panel panel-default">
								<div class="panel-heading">
										<h3 class="panel-title">Please Sign In</h3>
								</div>
								<div class="panel-body">




										<form role="form" class="" method="post" name="login" action="login.php">
											<?=$view->error($error)?>
												<fieldset>
														<div class="form-group">
																<input class="form-control" placeholder="E-mail" name="userid" type="text" autofocus  value="<?=$view->escape($_POST['userid'])?>">
														</div>
														<div class="form-group">
																<input class="form-control" placeholder="Password" name="password" type="password" type="password" value="">
														</div>
														<!-- <div class="checkbox">
																<label>
																		<input name="remember" type="checkbox" value="Remember Me">Remember Me
																</label>
														</div> -->
														<!-- Change this to a button or input when using this as a form -->
														<!-- <a href="index.html">Login</a> -->
														<div class="loginsubmit"><input type="submit" value="　Login　"  class="btn btn-lg btn-success btn-block"></div>
												</fieldset>
										</form>
								</div>
						</div>
				</div>
		</div>
</div>

<?php
// require_once(DIR_VIEW.'footer.php');
?>
