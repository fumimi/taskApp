<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Storage extends ApplicationModel {
	
	function Storage() {
	
		$this->schema = array(
		'storage_folder'=>array('fix'=>intval($_GET['folder']), 'except'=>array('search', 'update')),
		'storage_type'=>array('fix'=>'file'),
		'storage_title'=>array('タイトル', 'notnull', 'length:1000'),
		'storage_name'=>array('fix'=>$_SESSION['realname']),
		'storage_comment'=>array('内容', 'length:10000', 'line:100'),
		'storage_date'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search', 'update')),
		'storage_file'=>array('except'=>array('update')),
		'storage_size'=>array('except'=>array('search', 'update')),
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
	
	function index() {
		
		$hash['parent'] = $this->permitFind('public', $_GET['folder']);
		$this->where[] = "(storage_folder = '".intval($_GET['folder'])."')";
		$hash += $this->permitList('storage_type DESC, storage_date', 1);
		if ($_GET['folder'] > 0) {
			$query = sprintf("SELECT id, storage_title FROM %s WHERE (storage_folder = %d) AND (storage_type = 'folder') AND %s ORDER BY storage_title", $this->table, intval($folder['storage_folder']), $this->permitWhere());
			$data = $this->fetchAll($query);
			$hash['folder'] = array();
			if (is_array($data) && count($data) > 0) {
				foreach ($data as $row) {
					$hash['folder'][$row['id']] = $row['storage_title'];
				}
			}
		}
		return $hash;
	
	}

	function view() {
		
		$hash['data'] = $this->permitFind();
		if ($hash['data']['storage_folder'] > 0) {
			$hash['folder'] = $this->permitFind('public', $hash['data']['storage_folder']);
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function add() {
	
		$hash['folder'] = $this->permitFolder($_GET['folder']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (strlen($_FILES['uploadfile']['name'][0]) <= 0 && strlen($_POST['uploadedfile'][0]) <= 0) {
				$this->error[] = 'アップロードするファイルを選択してください。';
			}
			$this->validateSchema('insert');
			$this->permitValidate();
			$prefix = $_SESSION['userid'].'_'.strtotime($this->post['storage_date']);
			$this->post['storage_file'] = $this->uploadfile('storage', $prefix);
			$this->post['storage_size'] = $this->uploadfilesize($prefix.'_'.$this->post['storage_file'], 'storage');
			$this->insertPost();
			$this->redirect('index.php'.$this->parameter(array('folder'=>$_GET['folder'])));
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function edit() {
		
		$hash['data'] = $this->permitFind('edit');
		$this->type($hash['data'], 'file');
		$hash['folder'] = $this->permitFolder($hash['data']['storage_folder']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (strlen($_FILES['uploadfile']['name'][0]) > 0 || strlen($_POST['uploadedfile'][0]) > 0) {
				$this->schema['storage_file']['except'] = array();
				$this->schema['storage_size']['except'] = array();
			}
			$this->validateSchema('update');
			$this->permitValidate();
			if (strlen($_FILES['uploadfile']['name'][0]) > 0 || strlen($_POST['uploadedfile'][0]) > 0) {
				$prefix = $hash['data']['owner'].'_'.strtotime($hash['data']['storage_date']);
				$this->post['storage_file'] = $this->uploadfile('storage', $prefix, $hash['data']['storage_file']);
				$this->post['storage_size'] = $this->uploadfilesize($prefix.'_'.$this->post['storage_file'], 'storage');
			}
			$this->updatePost();
			$this->redirect('index.php'.$this->parameter(array('folder'=>$hash['data']['storage_folder'])));
			$this->post['storage_date'] = $hash['data']['storage_date'];
			$this->post['storage_file'] = $hash['data']['storage_file'];
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function delete() {
		
		$hash['data'] = $this->permitFind('edit');
		$this->type($hash['data'], 'file');
		$hash['folder'] = $this->permitFolder($hash['data']['storage_folder']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->deletePost();
			if ($this->response && count($this->error) <= 0) {
				$this->uploadfile('storage', $hash['data']['owner'].'_'.strtotime($hash['data']['storage_date']), $hash['data']['storage_file']);
				$this->redirect('index.php'.$this->parameter(array('folder'=>$hash['data']['storage_folder'])));
			}
		}
		$hash += $this->findUser($hash['data']);
		return $hash;

	}

	function folderview() {
		
		return $this->view();
	
	}
	
	function folderadd() {
	
		$hash['folder'] = $this->permitFolder($_GET['folder']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->schema['storage_type']['fix'] = 'folder';
			$this->schema['storage_title'][0] = 'フォルダ名';
			$this->validateSchema('insert');
			$this->permitValidate();
			$this->insertPost();
			$this->redirect('index.php'.$this->parameter(array('folder'=>$_GET['folder'])));
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function folderedit() {
		
		$hash['data'] = $this->permitFind('edit');
		$this->type($hash['data'], 'folder');
		$hash['folder'] = $this->permitFolder($hash['data']['storage_folder']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->schema['storage_type']['fix'] = 'folder';
			$this->schema['storage_title'][0] = 'フォルダ名';
			$hash['data'] = $this->permitUpdate('index.php'.$this->parameter(array('folder'=>$hash['data']['storage_folder'])));
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function folderdelete() {
		
		$hash['data'] = $this->permitFind('edit');
		$this->type($hash['data'], 'folder');
		$hash['folder'] = $this->permitFolder($hash['data']['storage_folder']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$query = "SELECT ".implode(',', $this->schematize())." FROM ".$this->table." WHERE storage_folder = ".intval($_POST['id']);
			$data = $this->fetchAll($query);
			if (is_array($data) && count($data) > 0) {
				foreach ($data as $row) {
					if ($row['storage_type'] == 'folder') {
						$this->error[] = 'サブフォルダが存在するフォルダは削除できません。<br />サブフォルダを削除してください。';
						break;
					} elseif (!$this->permitted($row, 'public') || !$this->permitted($row, 'edit')) {
						$this->error[] = '編集権限のないファイルが存在します。<br />フォルダを削除できませんでした。';
						break;
					}
				}
			}
			$this->deletePost();
			if ($this->response && count($this->error) <= 0) {
				$query = "DELETE FROM ".$this->table." WHERE storage_folder = ".intval($_POST['id']);
				$this->response = $this->query($query);
				if ($this->response && is_array($data) && count($data) > 0) {
					foreach ($data as $row) {
						$this->removefile('storage', $row['owner'].'_'.strtotime($row['storage_date']), $row['storage_file']);
					}
				}
				$this->redirect('index.php'.$this->parameter(array('folder'=>$hash['data']['storage_folder'])));
			}
		}
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function permitFolder($id) {
	
		if ($id > 0) {
			$data = $this->permitFind('public', $id);
			if ($this->permitted($data, 'add')) {
				return $data;
			} else {
				$this->died('このフォルダへの書き込み権限がありません。');
			}
		}
	
	}
	
	function type($data, $type) {
		
		if ($type == 'file' && $data['storage_type'] == 'folder') {
			header('Location:folder'.basename($_SERVER['SCRIPT_NAME']).'?id='.$data['id']);
			exit();
		} elseif ($type == 'folder' && $data['storage_type'] == 'file') {
			header('Location:'.str_replace('folder', '', basename($_SERVER['SCRIPT_NAME'])).'?id='.$data['id']);
			exit();
		}
	
	}
	
	function download() {
		
		$data = $this->permitFind();
		if ($data['storage_folder'] > 0) {
			$hash['folder'] = $this->permitFind('public', $data['storage_folder']);
		}
		if (stristr($data['storage_file'], $_REQUEST['file'])) {
			$this->attachment('storage', $data['owner'].'_'.strtotime($data['storage_date']), $_REQUEST['file'], 'attachment');
		} else {
			$this->died('ファイルが見つかりません。');
		}
	
	}

}

?>