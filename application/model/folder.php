<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Folder extends ApplicationModel {
	
	function Folder() {
		
		$type = array('message', 'forum', 'addressbook', 'bookmark', 'facility', 'project', 'todo');
		if (isset($_GET['type']) && !in_array($_GET['type'], $type)) {
			$this->died('URLが無効です。');
		}
		$this->schema = array(
		'folder_type'=>array('分類', 'notnull', 'alphaNumeric', 'except'=>array('search', 'update')),
		'folder_id'=>array('except'=>array('search', 'update')),
		'folder_caption'=>array('カテゴリ名', 'notnull', 'length:100'),
		'folder_name'=>array('fix'=>$_SESSION['realname']),
		'folder_date'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search', 'update')),
		'folder_order'=>array('順序', 'numeric', 'except'=>array('search')),
		'add_level'=>array('except'=>array('search')),
		'add_group'=>array('except'=>array('search')),
		'add_user'=>array('except'=>array('search')),
		'public_level'=>array('except'=>array('search')),
		'public_group'=>array('except'=>array('search')),
		'public_user'=>array('except'=>array('search')),
		'edit_level'=>array('except'=>array('search')),
		'edit_group'=>array('except'=>array('search')),
		'edit_user'=>array('except'=>array('search')));
		
	}
	
	function validate() {
	
		if (count($this->error) <= 0) {
			if ($_GET['type'] == 'message' || $_GET['type'] == 'todo') {
				$where = " AND (owner = '".$this->quote($_SESSION['userid'])."')";
			}
			$query = "SELECT MAX(folder_id) AS folder_id FROM ".$this->table." WHERE (folder_type = '".$this->quote($_GET['type'])."')".$where;
			$data = $this->fetchOne($query);
			if ($data['folder_id'] > 0) {
				$this->post['folder_id'] = intval($data['folder_id']) + 1;
			} else {
				$this->post['folder_id'] = 1;
			}
		}
	
	}
	
	function index() {
		
		if (strlen($_GET['type']) > 0) {
			$this->where[] = "(folder_type = '".$this->quote($_GET['type'])."')";
			$this->where[] = "(owner = '".$this->quote($_SESSION['userid'])."')";
			$hash = $this->findLimit('folder_order, folder_id', 0);
		}
		return $hash;
	
	}

	function view() {
	
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE (id = %s) AND (owner = '%s')", $field, $this->table, intval($_GET['id']), $this->quote($_SESSION['userid']));
		$hash['data'] = $this->fetchOne($query);
		return $hash;

	}
	
	function add() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->schema['folder_caption'][0] = 'フォルダ名';
			$this->validateSchema('insert');
			$this->validate();
			$this->insertPost();
			$this->redirect('index.php?type='.$_GET['type']);
		}
		$hash['data'] = $this->post;
		return $hash;
	
	}
	
	function edit() {
		
		$hash = $this->view();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['id'] == $hash['data']['id']) {
			$this->schema['folder_caption'][0] = 'フォルダ名';
			$this->validateSchema('update');
			$this->updatePost();
			$this->redirect('index.php?type='.$hash['data']['folder_type']);
			$this->post['folder_type'] = $hash['data']['folder_type'];
			$hash['data'] = $this->post;
		}
		return $hash;
	
	}

	function delete() {
	
		$hash = $this->view();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['id'] > 0) {
			$query = sprintf("DELETE FROM %s WHERE (id = %s) AND (owner = '%s')", $this->table, intval($_POST['id']), $this->quote($_SESSION['userid']));
			$this->response = $this->query($query);
			if ($this->response) {
				$query = sprintf("DELETE FROM %s WHERE (folder_id = %s) AND (owner = '%s')", DB_PREFIX.$this->quote($hash['data']['folder_type']), intval($hash['data']['folder_id']), $this->quote($_SESSION['userid']));
				$this->response = $this->query($query);
				$this->redirect('index.php?type='.$hash['data']['folder_type']);
			}
		}
		if ($hash['data']['folder_id'] > 0) {
			$node = $this->fetchCount(DB_PREFIX.$this->quote($hash['data']['folder_type']), "WHERE (folder_id = ".intval($hash['data']['folder_id']).") AND (owner = '".$this->quote($_SESSION['userid'])."')", 'id');
			if ($node > 0) {
				$this->error[] = 'このフォルダには'.intval($node).'件のデータが存在します。<br />フォルダを削除するとフォルダ内のデータは削除されます。';
			}
		}
		return $hash;

	}
	
	function category() {
		
		$this->authorize('administrator', 'manager', 'editor');
		$this->where[] = "(folder_type = '".$this->quote($_GET['type'])."')";
		$hash = $this->permitList('folder_order, folder_id', 0);
		return $hash;
	
	}

	function categoryview() {
	
		$this->authorize('administrator', 'manager', 'editor');
		$hash['data'] = $this->permitFind();
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function categoryadd() {
		
		$this->authorize('administrator', 'manager', 'editor');
		$hash['data'] = $this->permitInsert('category.php?type='.$_GET['type']);
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function categoryedit() {
		
		$this->authorize('administrator', 'manager', 'editor');
		$hash['data'] = $this->permitFind('edit');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('update');
			$this->permitValidate();
			$this->updatePost();
			$this->redirect('category.php?type='.$hash['data']['folder_type']);
			$this->post['folder_type'] = $hash['data']['folder_type'];
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function categorydelete() {
	
		$this->authorize('administrator', 'manager', 'editor');
		$hash['data'] = $this->permitFind('edit');
		$node = $this->fetchCount(DB_PREFIX.$hash['data']['folder_type'], "WHERE folder_id = ".intval($hash['data']['folder_id']), 'id');
		if ($node > 0) {
			$this->error[] = 'データが存在するカテゴリは削除できません。';
		}
		$this->deletePost();
		$this->redirect('category.php?type='.$hash['data']['folder_type']);
		$hash += $this->findUser($hash['data']);
		return $hash;

	}

}

?>