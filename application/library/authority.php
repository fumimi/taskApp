<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Authority {
	
	function Authority() {
		
		session_name(APP_TYPE.'sid');
		session_start();

	}

	function check() {
	
		$authorized = $this->authorize();
		if ($authorized !== true) {
			if (basename($_SERVER['SCRIPT_NAME']) != 'login.php') {
				$_SESSION['referer'] = $_SERVER['REQUEST_URI'];
				if (!file_exists('login.php')) {
					$root = '../';
				}
				header('Location:'.$root.'login.php');
				exit();
			}
		}

	}

	function authorize() {
	
		$authorized = false;
		if (isset($_SESSION['authorized'])) {
			if ($_SESSION['authorized'] === md5(__FILE__.$_SESSION['logintime'])) {
				if (APP_EXPIRE > 0 && (time() - $_SESSION['logintime']) > APP_EXPIRE) {
					$_SESSION = array();
					$_SESSION['status'] = 'expire';
				} else {
					if (APP_IDLE > 0 && (time() - $_SESSION['accesstime']) > APP_IDLE) {
						$_SESSION = array();
						$_SESSION['status'] = 'idle';
					} else {
						$authorized = true;
						$_SESSION['accesstime'] = time();
					}
				}
			}
		}
		return $authorized;

	}

	function login() {
	
		$authorized = false;
		$error = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (strlen($_POST['userid']) > 0) {
				if (preg_match('/^[-_\.a-zA-Z0-9]+$/', $_POST['userid'])) {
					$postuserid = trim($_POST['userid']);
				} else {
					$error[] = 'ユーザー名は半角英数字で入力してください。';
				}
				if (preg_match('/^[a-zA-Z0-9]*$/', $_POST['password'])) {
					$password = md5(trim($_POST['password']));
				} else {
					$error[] = 'パスワードは半角英数字で入力してください。';
				}
				if ($postuserid != '' && count($error) <= 0) {
					$connection = new Connection;
					$query = sprintf("SELECT id,userid,password,realname,user_group,authority FROM %suser WHERE userid = '%s'", DB_PREFIX, $connection->quote($postuserid));
					$data = $connection->fetchOne($query);
					$connection->close();
					if (count($data) > 0 && $data['userid'] === $postuserid && $data['password'] === $password) {
						$authorized = true;
					} else {
						$error[] = 'ユーザー名もしくはパスワードが<br />異なります。';
					}
				}
			} else {
				$error[] = 'ユーザー名を入力してください。';
			}
		} elseif (isset($_SESSION['status'])) {
			if ($_SESSION['status'] == 'idle') {
				$error[] = '自動的にログアウトしました。<br />ログインしなおしてください。';
			} elseif ($_SESSION['status'] == 'expire') {
				$error[] = 'ログインの有効期限が切れました。<br />ログインしなおしてください。';
			}
			session_unregister('status');
		}
		if ($authorized === true && count($error) <= 0) {
			session_regenerate_id();
			$_SESSION['logintime'] = time();
			$_SESSION['accesstime'] = $_SESSION['logintime'];
			$_SESSION['authorized'] = md5(__FILE__.$_SESSION['logintime']);
			$_SESSION['userid'] = $data['userid'];
			$_SESSION['realname'] = $data['realname'];
			$_SESSION['group'] = $data['user_group'];
			$_SESSION['authority'] = $data['authority'];
			if (isset($_SESSION['referer'])) {
				header('Location: '.$_SESSION['referer']);
				session_unregister('referer');
			} else {
				header('Location: index.php');
			}
			exit();
		} else {
			return $error;
		}

	}

	function logout() {

		$this->sessionDestroy();
		if (!file_exists('login.php')) {
			$root = '../';
		}
		header('Location:'.$root.'login.php');
		exit();

	}

	function sessionDestroy() {
	
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time() - 42000, '/');
		}
		session_destroy();

	}

}

?>