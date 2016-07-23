<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Project extends ApplicationModel {
	
	function Project() {
	
		$this->schema = array(
		'folder_id'=>array('カテゴリ', 'numeric', 'except'=>array('search')),
		'project_parent'=>array('プロジェクトID', 'numeric', 'except'=>array('search', 'update')),
		'project_title'=>array('タイトル', 'notnull', 'length:1000'),
		'project_name'=>array('fix'=>$_SESSION['realname']),
		'project_progress'=>array('進捗', 'numeric', 'except'=>array('search', 'insert', 'update')),
		'project_comment'=>array('内容', 'length:10000', 'line:100'),
		'project_date'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search', 'update')),
		'project_begin'=>array('except'=>array('search')),
		'project_end'=>array('except'=>array('search')),
		'project_file'=>array(),
		'public_level'=>array('except'=>array('search')),
		'public_group'=>array('except'=>array('search')),
		'public_user'=>array('except'=>array('search')),
		'edit_level'=>array('except'=>array('search')),
		'edit_group'=>array('except'=>array('search')),
		'edit_user'=>array('except'=>array('search')));
		
	}
	
	function validate() {
		
		$this->post['project_begin'] = date('Y-m-d', mktime(0, 0, 0, intval($_POST['beginmonth']), intval($_POST['beginday']), intval($_POST['beginyear'])));
		$this->post['project_end'] = date('Y-m-d', mktime(0, 0, 0, intval($_POST['endmonth']), intval($_POST['endday']), intval($_POST['endyear'])));
		if ($this->post['project_begin'] > $this->post['project_end']) {
			$this->error[] = '開始日は終了日より後の日付を入力してください。';
		}
	}
	
	function index() {
		
		$hash = $this->permitCategory('project', $_GET['folder']);
		if (strlen($_GET['folder']) <= 0) {
			$this->where[] ="(project_end >= '".date('Y-m-d')."')";
		} else {
		}
		$this->where[] = $this->folderWhere($hash['folder'], 'all');
		$this->where[] = "(project_parent = '0')";
		$hash += $this->permitList('project_begin', 0);
		return $hash;
	
	}

	function view() {
		
		$hash['data'] = $this->permitFind();
		if ($hash['data']['project_parent'] == 0) {
			$hash += $this->permitCategory('project', $hash['data']['folder_id'], 'add');
			$field = implode(',', $this->schematize());
			$hash['list'] = $this->fetchAll("SELECT ".$field." FROM ".$this->table." WHERE project_parent = ".intval($_REQUEST['id'])." ORDER BY project_begin,project_end,id");
			$hash += $this->findUser($hash['data']);
			return $hash;
		} else {
			$this->died('閲覧する権限がありません。');
		}
	
	}
	
	function add() {
		
		$this->schema['folder_id'][] = 'notnull';
		$this->schema['project_parent']['fix'] = 0;
		$hash = $this->permitCategory('project', $_POST['folder_id'], 'add');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('insert');
			$this->permitValidate();
			$this->validate();
			$this->insertPost();
			$this->redirect('index.php'.$this->parameter(array('folder'=>$this->post['folder_id'])));
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function edit() {
		
		$this->schema['folder_id'][] = 'notnull';
		$hash['data'] = $this->permitFind('edit');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$hash += $this->permitCategory('project', $_POST['folder_id'], 'add');
			$hash['data'] = $this->permitUpdate('view.php?id='.intval($_POST['id']));
		} else {
			$hash += $this->permitCategory('project', $hash['data']['folder_id'], 'add');
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function delete() {
		
		$hash['data'] = $this->permitFind('edit');
		$hash += $this->permitCategory('project', $hash['data']['folder_id'], 'add');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->deletePost();
			if ($this->response && count($this->error) <= 0) {
				$data = $this->fetchAll("SELECT project_file FROM ".$this->table." WHERE project_parent = ".intval($_POST['id']));
				if (is_array($data) && count($data) > 0) {
					foreach ($data as $row) {
						$this->removefile('project', $row['owner'].'_'.strtotime($row['project_date']), $row['project_file']);
					}
				}
				$this->response = $this->query("DELETE FROM ".$this->table." WHERE project_parent = ".intval($_POST['id']));
				$this->redirect('index.php'.$this->parameter(array('folder'=>$hash['data']['folder_id'])));
			}
		}
		$hash += $this->findUser($hash['data']);
		return $hash;

	}

	function taskview() {
		
		$hash['data'] = $this->findView();
		$hash['parent'] = $this->permitFind('public', $hash['data']['project_parent']);
		$hash += $this->permitCategory('project', $hash['parent']['folder_id']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['project_progress'])) {
			if ($this->permitted($hash['category'], 'add') && $this->permitted($hash['parent'], 'edit')) {
				$query = sprintf("UPDATE %s SET project_progress = %d, editor = '%s', updated = '%s' WHERE id = %d", $this->table, intval($_POST['project_progress']), $this->quote($_SESSION['userid']), date('Y-m-d H:i:s'), intval($_GET['id']));
				$this->response = $this->query($query);
				if ($this->response) {
					$this->redirect('view.php?id='.intval($hash['data']['project_parent']));
				}
			}
		}
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function taskadd() {
		
		$hash['parent'] = $this->permitFind('edit', $_REQUEST['parent']);
		$hash += $this->permitCategory('project', $parent['folder_id']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_POST['project_parent'] <= 0) {
				$this->error[] = 'タスクを追加するプロジェクトが選択されていません。';
			}
			$this->validateSchema('insert');
			$this->validate();
			if ($this->post['project_begin'] < $hash['parent']['project_begin'] || $this->post['project_end'] > $hash['parent']['project_end']) {
				$this->error[] = 'タスクの期間は'.date('Y年n月j日', strtotime($hash['parent']['project_begin'])).'～'.date('Y年n月j日', strtotime($hash['parent']['project_end'])).'以内で入力してください。';
			}
			$this->post['project_file'] = $this->uploadfile('project', $_SESSION['userid'].'_'.strtotime($this->post['project_date']));
			$this->insertPost();
			$this->redirect('view.php?id='.$this->post['project_parent']);
			$hash['data'] = $this->post;
		}
		return $hash;
		
	}

	function taskedit() {
		
		$hash['data'] = $this->findView();
		$hash['parent'] = $this->permitFind('edit', $hash['data']['project_parent']);
		$hash += $this->permitCategory('project', $hash['parent']['folder_id']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('update');
			$this->validate();
			if ($this->post['project_begin'] < $hash['parent']['project_begin'] || $this->post['project_end'] > $hash['parent']['project_end']) {
				$this->error[] = 'タスクの期間は'.date('Y年n月j日', strtotime($hash['parent']['project_begin'])).'～'.date('Y年n月j日', strtotime($hash['parent']['project_end'])).'以内で入力してください。';
			}
			$this->post['project_file'] = $this->uploadfile('project', $hash['data']['owner'].'_'.strtotime($hash['data']['project_date']), $hash['data']['project_file']);
			$this->updatePost();
			$this->redirect('view.php?id='.intval($hash['data']['project_parent']));
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function taskdelete() {
		
		$hash['data'] = $this->findView();
		$hash['parent'] = $this->permitFind('edit', $hash['data']['project_parent']);
		$hash += $this->permitCategory('project', $hash['parent']['folder_id']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->deletePost();
			if ($this->response && count($this->error) <= 0) {
				$this->removefile('project', $hash['data']['owner'].'_'.strtotime($hash['data']['project_date']), $hash['data']['project_file']);
				$this->redirect('view.php?id='.intval($hash['data']['project_parent']));
			}
		}
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function download() {
		
		$data = $this->findView();
		$parent = $this->permitFind('public', $data['project_parent']);
		$this->permitCategory('project', $parent['folder_id']);
		if (stristr($data['project_file'], $_REQUEST['file'])) {
			$this->attachment('project', $data['owner'].'_'.strtotime($data['project_date']), $_REQUEST['file']);
		} else {
			$this->died('ファイルが見つかりません。');
		}
	
	}

}

?>