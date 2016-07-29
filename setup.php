<?php

mb_internal_encoding('UTF-8');
$config = 'application/config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (get_magic_quotes_gpc() && is_array($_POST) && count($_POST) > 0) {
		foreach ($_POST as $key => $value) {
			$_POST[$key] = stripslashes($value);
		}
	}
	if (is_writable($config)) {
		if ($_POST['database_storage'] != 'sqlite2') {
			if (strlen($_POST['database_host']) <= 0) {
				$error[] = 'データベースのホスト名を入力してください。';
			}
			if (strlen($_POST['database_database']) <= 0) {
				$error[] = 'データベース名を入力してください。';
			}
			if (strlen($_POST['database_username']) <= 0) {
				$error[] = 'データベースのユーザー名を入力してください。';
			}
			if (strlen($_POST['database_password']) <= 0) {
				$error[] = 'データベースのパスワードを入力してください。';
			}
			if (strlen($_POST['database_prefix']) <= 0) {
				$error[] = 'データベースのテーブル接頭辞を入力してください。';
			}
		}
		if (count($error) <= 0) {
			if ($document = file_get_contents($config)) {
				$document = preg_replace("/define\('DB_STORAGE', '.*'\);/", "define('DB_STORAGE', '".str_replace("'", "", $_POST['database_storage'])."');", $document);
				if ($_POST['database_storage'] == 'sqlite2') {
					$document = preg_replace("/define\('DB_PREFIX', '.*'\);/", "define('DB_PREFIX', 'groupware_');", $document);
				} else {
					$document = preg_replace("/define\('DB_HOSTNAME', '.*'\);/", "define('DB_HOSTNAME', '".str_replace("'", "", $_POST['database_host'])."');", $document);
					$document = preg_replace("/define\('DB_DATABASE', '.*'\);/", "define('DB_DATABASE', '".str_replace("'", "", $_POST['database_database'])."');", $document);
					$document = preg_replace("/define\('DB_USERNAME', '.*'\);/", "define('DB_USERNAME', '".str_replace("'", "", $_POST['database_username'])."');", $document);
					$document = preg_replace("/define\('DB_PASSWORD', '.*'\);/", "define('DB_PASSWORD', '".str_replace("'", "", $_POST['database_password'])."');", $document);
					$document = preg_replace("/define\('DB_PREFIX', '.*'\);/", "define('DB_PREFIX', '".str_replace("'", "", $_POST['database_prefix'])."');", $document);
				}
				$pointer = fopen($config, 'w');
				if ($pointer && flock($pointer, LOCK_EX)) {
					fwrite($pointer, $document);
					flock($pointer, LOCK_UN);
				}
				fclose($pointer);
			}
		}
	}
	require_once($config);
	if (DB_STORAGE == 'mysql' || DB_STORAGE == 'postgresql') {
		require_once(DIR_LIBRARY.'connection'.DB_STORAGE.'.php');
	} else {
		require_once(DIR_LIBRARY.'connection.php');
	}
	require_once(DIR_LIBRARY.'validation.php');
	$connection = new Connection;
	if (!$connection->handler) {
		$error[] = 'データベースに接続できません。<br />データベースへの接続情報を確認してください。';
	} elseif ($_POST['setup_type'] != 'update') {
		$table = $connection->table();
		if (is_array($table) && in_array(DB_PREFIX.'user', $table)) {
			$count = $connection->fetchCount(DB_PREFIX.'user', "WHERE authority = 'administrator'", 'id');
		}
		if ($count > 0) {
			$result[] = '管理者権限を持ったユーザーがすでに存在します。<br />新しい管理者は作成できません。';
		} else {
			if (strlen($_POST['userid']) <= 0) {
				$error[] = 'ユーザーIDを入力してください。';
			} else {
				if ($string = Validation::userid('userid', 'ユーザーID')) {
					$error[] = $string;
				}
				if ($string = Validation::length('userid', 'ユーザーID', 100)) {
					$error[] = $string;
				}
			}
			if (count($error) <= 0 && is_array($table) && in_array(DB_PREFIX.'user', $table)) {
				$count = $connection->fetchCount(DB_PREFIX.'user', "WHERE userid = '".$connection->quote($_POST['userid'])."'", 'id');
				if ($count > 0) {
					$error[] = 'そのユーザーIDはすでに存在します。<br />別のユーザーIDを入力してください。';
				}
			}
			$_POST['password'] = trim($_POST['password']);
			if (strlen($_POST['password']) <= 0) {
				$error[] = 'パスワードを入力してください。';
			} else {
				if ($string = Validation::alphaNumeric('password', 'パスワード')) {
					$error[] = $string;
				}
				if ($string = Validation::length('password', 'パスワード', 4, 32)) {
					$error[] = $string;
				}
			}
			if (strlen($_POST['realname']) <= 0) {
				$error[] = '名前を入力してください。';
			} elseif ($string = Validation::length('realname', '名前', 100)) {
				$error[] = $string;
			}
			if (strlen($_POST['user_groupname']) <= 0) {
				$error[] = 'グループ名を入力してください。';
			} else {
				if ($string = Validation::length('user_groupname', 'グループ名', 100)) {
					$error[] = $string;
				}
			}
		}
		if (count($error) <= 0) {
			if ($document = file_get_contents(DIR_PATH.'database/table.sql')) {
				$document = str_replace(array("\r\n","\r","\n"), "", $document);
				$document = str_replace('prefix_', DB_PREFIX, $document);
				$array = explode(';', $document);
			}
			if (is_array($array) && count($array) > 0) {
				foreach ($array as $value) {
					preg_match('/CREATE TABLE (.+) \(.*\)/i', $value, $matches);
					if (strlen($matches[1]) > 0 && is_array($table) && in_array($matches[1], $table)) {
						if (DB_STORAGE != 'sqlite2') {
							$result[] = 'テーブル '.$matches[1].' はすでに存在します。';
						}
					} elseif (strlen($value) > 0) {
						if (DB_STORAGE == 'sqlite2') {
							$value = str_replace(' auto_increment', '', $value);
							$value = str_replace('(255)', '', $value);
						}
						$response = @$connection->query($value);
						if (strlen($matches[1]) > 0) {
							if ($response) {
								$result[] = 'テーブル '.$matches[1].' を作成しました。';
							} else {
								$error[] = 'テーブル '.$matches[1].' の作成に失敗しました。';
							}
						}
					}
				}
			} else {
				$error[] = 'テーブル情報の取得に失敗しました。';
			}
			if ($count <= 0) {
				if (is_array($table) && in_array(DB_PREFIX.'group', $table)) {
					$group = $connection->fetchOne("SELECT * FROM ".DB_PREFIX."group WHERE group_name = '".$connection->quote($_POST['user_groupname'])."'");
				}
				if (!is_array($group) || $group['id'] <= 0) {
					$query = "INSERT INTO %sgroup (group_name, add_level, owner, created) VALUES ('%s', 0, '%s', '%s')";
					$query = sprintf($query, DB_PREFIX, $connection->quote($_POST['user_groupname']), $connection->quote($_POST['userid']), date('Y-m-d H:i:s'));
					if ($connection->query($query)) {
						$group = $connection->fetchOne("SELECT * FROM ".DB_PREFIX."group WHERE group_name = '".$connection->quote($_POST['user_groupname'])."'");
					}
				}
				if (is_array($group) && $group['id'] > 0) {
					$query = "INSERT INTO %suser (userid, password, password_default, realname, authority, user_group, user_groupname, owner, created) VALUES ('%s', '%s', '%s', '%s', 'administrator', %d, '%s', '%s', '%s')";
					$query = sprintf($query, DB_PREFIX, $connection->quote($_POST['userid']), md5($_POST['password']), md5($_POST['password']), $connection->quote($_POST['realname']), intval($group['id']), $connection->quote($_POST['user_groupname']), $connection->quote($_POST['userid']), date('Y-m-d H:i:s'));
					if ($connection->query($query)) {
						$result[] = '管理者を作成しました。';
					} else {
						$error[] = '管理者の作成に失敗しました。';
					}
				} else {
					$error[] = 'グループの作成に失敗しました。';
				}
			}
		}
	}
	if (is_array($_POST) && count($_POST) > 0) {
		foreach ($_POST as $key => $value) {
			$_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
		}
	}
} elseif (!is_writable($config)) {
	$result[] = '設定ファイルに書き込み権限がありません。<br />すでに設定している場合は書き込み権限を与える必要はありません。<br />このセットアップから設定ファイルに書き込む場合は「application/config.php」のパーミションを<br />「606」または「666」にしてください。';
}
require_once($config);
$caption = 'group セットアップ';
require_once('application/view/header.php');
?>
<div class="header">
	<div class="headertitle">
		<a href="<?=$root?>index.php"><img src="<?=$root?>images/title.gif" /></a>
	</div>
	<div class="clearer"></div>
</div>
<form class="setup" method="post" name="setup" action="setup.php">
	<h1>セットアップ</h1>
<?php
if (is_array($result) && count($result) > 0) {
	echo '<div class="setupdescription">'.implode('<br />', $result).'</div>';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && count($error) <= 0) {
?>
	<p>
		セットアップが完了しました。
	</p>
	<p>
		「application/config.php」のパーミションを「604」または「644」に戻し、<br />
		「setup.php」をサーバーから削除してください。
	</p>
	<a href="login.php">ログイン</a>
<?php
} else {
	if (is_array($error) && count($error) > 0) {
		echo '<div class="error">'.implode('<br />', $error).'</div>';
	}
	$selected[DB_STORAGE] = ' selected="selected"';
	$selected[$_POST['setup_type']] = ' selected="selected"';
?>
	<h2>セットアップの種類</h2>
	<p>
		<select name="setup_type" id="type" onchange="disable()">
			<option value="new"<?=$selected['new']?>>新規セットアップ</option>
			<option value="update"<?=$selected['update']?>>アップデート</option>
		</select>
	</p>
	<h2>データベースの設定</h2>
	<p>
		データベースへの接続情報を入力してください。
	</p>
	<table class="form paragraph" cellspacing="0">
		<tr><th style="width:180px">データベースの種類</th><td>
			<select name="database_storage" id="storage" onchange="disable()">
				<option value="sqlite2"<?=$selected['sqlite2']?>>SQLite2</option>
				<option value="mysql"<?=$selected['mysql']?>>MySQL</option>
			</select>
		</td></tr>
		<tr><th>データベースのホスト名</th><td><input type="text" name="database_host" value="<?=DB_HOSTNAME?>" class="inputvalue" /></td></tr>
		<tr><th>データベース名</th><td><input type="text" name="database_database" value="<?=DB_DATABASE?>" class="inputvalue" /></td></tr>
		<tr><th>データベースのユーザー名</th><td><input type="text" name="database_username" value="<?=DB_USERNAME?>" class="inputvalue" /></td></tr>
		<tr><th>データベースのパスワード</th><td><input type="password" name="database_password" value="<?=DB_PASSWORD?>" class="inputvalue" /></td></tr>
		<tr><th>テーブル接頭辞</th><td><input type="text" name="database_prefix" value="<?=DB_PREFIX?>" class="inputvalue" /></td></tr>
	</table>
	<h2>管理者の設定</h2>
	<p>
		グループウェアの管理者となるユーザーIDとパスワードを設定してください。
	</p>
	<table class="form paragraph" cellspacing="0">
		<tr><th>ユーザーID</th><td><input type="text" name="userid" value="<?=$_POST['userid']?>" class="inputvalue" /></td></tr>
		<tr><th>パスワード</th><td><input type="password" name="password" value="<?=$_POST['password']?>" class="inputvalue" /></td></tr>
		<tr><th>名前</th><td><input type="text" name="realname" value="<?=$_POST['realname']?>" class="inputvalue" /></td></tr>
		<tr><th>グループ名</th><td><input type="text" name="user_groupname" value="<?=$_POST['user_groupname']?>" class="inputvalue" /></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　実行　" />
	</div>
<?php
}
?>
</form>
<script type="text/javascript">
	function disable() {
		var form = document.forms['setup'];
		var status = false;
		var object = document.getElementById('type');
		if (object.options[object.selectedIndex].value == 'update') {
			status = true;
		}
		form.elements['userid'].disabled = status;
		form.elements['password'].disabled = status;
		form.elements['realname'].disabled = status;
		form.elements['user_groupname'].disabled = status;
		status = false;
		object = document.getElementById('storage');
		if (object.options[object.selectedIndex].value == 'sqlite2') {
			status = true;
		}
		form.elements['database_host'].disabled = status;
		form.elements['database_database'].disabled = status;
		form.elements['database_username'].disabled = status;
		form.elements['database_password'].disabled = status;
		form.elements['database_prefix'].disabled = status;
	}
	window.onload = disable;
</script>
<?php
require_once('application/view/footer.php');
?>