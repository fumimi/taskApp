<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Forum extends ApplicationModel {
	
	function Forum() {
	
		$this->schema = array(
		'folder_id'=>array('カテゴリ', 'numeric', 'except'=>array('search')),
		'forum_title'=>array('タイトル', 'length:1000'),
		'forum_name'=>array('fix'=>$_SESSION['realname']),
		'forum_comment'=>array('内容', 'notnull', 'length:10000', 'line:100'),
		'forum_date'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search', 'update')),
		'forum_file'=>array(),
		'forum_parent'=>array('フォーラムID', 'numeric', 'except'=>array('search', 'update')),
		'forum_lastupdate'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search', 'update')),
		'forum_node'=>array('except'=>array('search', 'update')),
		'public_level'=>array('except'=>array('search')),
		'public_group'=>array('except'=>array('search')),
		'public_user'=>array('except'=>array('search')),
		'edit_level'=>array('fix'=>1, 'except'=>array('search')),
		'edit_group'=>array('except'=>array('search')),
		'edit_user'=>array('except'=>array('search')));
		if (intval($_POST['forum_parent']) <= 0) {
			$this->schema['forum_title'][] = 'notnull';
			$this->schema['folder_id'][] = 'notnull';
		}
		
	}
	
	function index() {
		
		$hash = $this->permitCategory('forum', $_GET['folder']);
		$this->where[] = $this->folderWhere($hash['folder'], 'all');
		$this->where[] = "(forum_parent = '0')";
		$hash += $this->permitList('forum_lastupdate', 1);
		return $hash;
	
	}

	function view() {
		
		$hash['parent'] = $this->permitFind();
		if ($hash['parent']['forum_parent'] == 0) {
			$hash += $this->permitCategory('forum', $hash['parent']['folder_id']);
			$this->where[] = "(forum_parent = ".intval($_REQUEST['id']).")";
			$hash += $this->findLimit('forum_date', 1);
			$hash += $this->findUser($hash['parent']);
			return $hash;
		} else {
			$this->died('閲覧する権限がありません。');
		}
	
	}
	
	function add() {
		
		$this->schema['forum_parent']['fix'] = 0;
		$hash = $this->permitCategory('forum', $_POST['folder_id'], 'add');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('insert');
			$this->permitValidate();
			$this->post['forum_file'] = $this->uploadfile('forum', $_SESSION['userid'].'_'.strtotime($this->post['forum_date']));
			$this->insertPost();
			$this->redirect('index.php'.$this->parameter(array('folder'=>$this->post['folder_id'])));
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function commentadd() {
		
		$parent = $this->permitFind('public', $_REQUEST['parent']);
		$hash = $this->permitCategory('forum', $parent['folder_id'], 'add');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (intval($_POST['forum_parent']) <= 0) {
				$this->error[] = 'コメントするスレッドが選択されていません。';
			}
			$this->validateSchema('insert');
			$this->permitValidate();
			$this->post['forum_file'] = $this->uploadfile('forum', $_SESSION['userid'].'_'.strtotime($this->post['forum_date']));
			$this->insertPost();
			if ($this->response && count($this->error) <= 0) {
				$node = $this->fetchCount($this->table, "WHERE forum_parent = ".intval($this->post['forum_parent']), 'id');
				$query = sprintf("UPDATE %s SET forum_lastupdate = '%s', forum_node = '%s' WHERE id = %s", $this->table, $this->post['forum_date'], $node, intval($this->post['forum_parent']));
				$this->response = $this->query($query);
				$this->redirect('view.php?id='.$this->post['forum_parent']);
			}
			$hash['data'] = $this->post;
		}
		return $hash;
		
	}

	function edit() {
		
		$hash['data'] = $this->permitOwner();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$hash += $this->permitCategory('forum', $_POST['folder_id'], 'add');
			$this->validateSchema('update');
			$this->permitValidate();
			$this->post['forum_file'] = $this->uploadfile('forum', $hash['data']['owner'].'_'.strtotime($hash['data']['forum_date']), $hash['data']['forum_file']);
			$this->updatePost();
			if ($_POST['forum_parent'] <= 0) {
				$this->redirect('view.php?id='.$_POST['id']);
			} else {
				$this->redirect('view.php?id='.$_POST['forum_parent']);
			}
			$hash['data'] = $this->post;
		} elseif ($hash['data']['forum_parent'] <= 0) {
			$hash += $this->permitCategory('forum', $hash['data']['folder_id'], 'add');
		}
		if ($hash['data']['forum_parent'] <= 0) {
			$hash += $this->findUser($hash['data']);
		}
		return $hash;
	
	}

	function delete() {
		
		$hash['data'] = $this->permitOwner();
		$node = $this->fetchCount($this->table, "WHERE forum_parent = ".intval($_REQUEST['id']), 'id');
		if ($node > 0) {
			$this->error[] = 'コメントがついているスレッドは削除できません。';
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $hash['data']['id'] == $_REQUEST['id']) {
			$this->deletePost();
			if ($this->response && count($this->error) <= 0) {
				$this->uploadfile('forum', $hash['data']['owner'].'_'.strtotime($hash['data']['forum_date']), $hash['data']['forum_file']);
				$node = $this->fetchCount($this->table, "WHERE forum_parent = ".intval($hash['data']['forum_parent']), 'id');
				$query = sprintf("UPDATE %s SET forum_node = '%s' WHERE id = %s", $this->table, $node, intval($hash['data']['forum_parent']));
				$this->response = $this->query($query);
				if ($_POST['forum_parent'] <= 0) {
					$this->redirect('index.php'.$this->parameter(array('folder'=>$hash['data']['folder_id'])));
				} else {
					$this->redirect('view.php?id='.intval($_POST['forum_parent']));
				}
			}
		}
		if ($hash['data']['forum_parent'] <= 0) {
			$hash += $this->findUser($hash['data']);
			$hash += $this->permitCategory('forum');
		}
		return $hash;

	}
	
	function download() {
		
		$data = $this->findView();
		if ($data['forum_parent'] <= 0) {
			if ($this->permitted($data, 'public')) {
				$this->permitCategory('forum', $data['folder_id']);
			} else {
				$this->died('閲覧する権限がありません。');
			}
		} else {
			$parent = $this->permitFind('public', $data['forum_parent']);
			$this->permitCategory('forum', $parent['folder_id']);
		}
		if (stristr($data['forum_file'], $_REQUEST['file'])) {
			$this->attachment('forum', $data['owner'].'_'.strtotime($data['forum_date']), $_REQUEST['file']);
		} else {
			$this->died('ファイルが見つかりません。');
		}
	
	}

}

?>