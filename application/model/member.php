<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Member extends ApplicationModel {
	
	function Member() {
		
		$this->table = DB_PREFIX.'user';
		$this->schema = array(
		'userid'=>array('except'=>array('search', 'update')),
		'user_group'=>array('except'=>array('search', 'update')),
		'user_groupname'=>array('except'=>array('update')),
		'realname'=>array('名前', 'notnull', 'length:100'),
		'user_ruby'=>array('かな', 'length:100'),
		'user_postcode'=>array('郵便番号', 'postcode', 'length:8'),
		'user_address'=>array('住所', 'length:1000'),
		'user_addressruby'=>array('住所(かな)', 'length:1000'),
		'user_phone'=>array('電話番号', 'phone', 'length:20'),
		'user_mobile'=>array('携帯電話', 'phone', 'length:20'),
		'user_email'=>array('メールアドレス', 'email', 'length:1000'),
		'user_skype'=>array('スカイプID', 'userid', 'length:1000'));
		
	}
	
	function validate() {
		
		if (strlen($_POST['password']) > 0 || strlen($_POST['newpassword']) > 0 || strlen($_POST['confirmpassword']) > 0) {
			$this->validator('password', 'パスワード', array('alphaNumeric', 'length:4:32'));
			$this->validator('newpassword', '新しいパスワード', array('alphaNumeric', 'length:4:32'));
			$this->validator('confirmpassword', '新しいパスワード(確認)', array('alphaNumeric', 'length:4:32'));
			$_POST['password'] = trim($_POST['password']);
			$_POST['newpassword'] = trim($_POST['newpassword']);
			$_POST['confirmpassword'] = trim($_POST['confirmpassword']);
			if ($_POST['newpassword'] != $_POST['confirmpassword']) {
				$this->error[] = '新しいパスワードと確認用パスワードが違います。';
			} else {
				$data = $this->fetchOne("SELECT password FROM ".$this->table." WHERE userid = '".$this->quote($_SESSION['userid'])."'");
				if (is_array($data) && count($data) > 0) {
					if ($data['password'] === md5($_POST['password'])) {
						$this->schema['password']['except'] = array('search');
						$this->post['password'] = md5($_POST['newpassword']);
					} else {
						$this->error[] = '現在のパスワードが違います。';
					}
				} else {
					$this->error[] = 'パスワード確認時にエラーが発生しました。';
				}
			}
		}
	
	}
	
	function index() {
	
		if ($_GET['group'] != 'all') {
			if ($_GET['group'] <= 0) {
				$_GET['group'] = $_SESSION['group'];
			}
			$this->where[] = "(user_group = '".intval($_GET['group'])."')";
		}
		$hash = $this->findLimit('user_order', 0);
		$hash['group'] = $this->findGroup();
		return $hash;
	
	}
	
	function view() {
		
		$hash['data'] = $this->findView();
		return $hash;
		
	}

	function edit() {
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('update');
			$this->validate();
			$this->post['editor'] = $_SESSION['userid'];
			$this->post['updated'] = date('Y-m-d H:i:s');
			if (count($this->error) <= 0) {
				$field = $this->schematize('update');
				foreach ($field as $key) {
					if (isset($this->post[$key])) {
						$array[] = $key." = '".$this->quote($this->post[$key])."'";
					}
				}
				$query = sprintf("UPDATE %s SET %s WHERE userid = '%s'", $this->table, implode(",", $array), $this->quote($_SESSION['userid']));
				$this->response = $this->query($query);
			}
			$this->redirect();
			$hash['data'] = $this->post;
		} else {
			$field = implode(',', $this->schematize());
			$hash['data'] = $this->fetchOne("SELECT ".$field." FROM ".$this->table." WHERE userid = '".$this->quote($_SESSION['userid'])."'");
		}
		return $hash;
	
	}

}

?>