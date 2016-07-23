<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Todo extends ApplicationModel {
	
	function Todo() {
		
		$this->table = DB_PREFIX.'todo';
		$this->schema = array(
		'folder_id'=>array('fix'=>0, 'except'=>array('search', 'update')),
		'todo_parent'=>array('except'=>array('search', 'update')),
		'todo_title'=>array('タイトル', 'notnull', 'length:1000'),
		'todo_name'=>array('fix'=>$_SESSION['realname'], 'update'),
		'todo_term'=>array('except'=>array('search')),
		'todo_noterm'=>array('numeric', 'except'=>array('search')),
		'todo_priority'=>array('numeric', 'notnull', 'except'=>array('search')),
		'todo_comment'=>array('備考', 'length:10000', 'line:100'),
		'todo_complete'=>array('fix'=>0, 'except'=>array('search', 'update')),
		'todo_completedate'=>array('except'=>array('search')),
		'todo_user'=>array('except'=>array('search', 'update')));
	
	}
	
	function validate() {
	
		if ($_POST['folder_id'] <= 0) {
			$this->post['folder_id'] = 0;
		}
		if ($_POST['todo_year'] > 2000 && $_POST['todo_month'] > 0 && $_POST['todo_day'] > 0) {
			$this->post['todo_term'] = date('Y-m-d', mktime(0, 0, 0, $_POST['todo_month'], $_POST['todo_day'], $_POST['todo_year']));
		}
		if ($_POST['todo_noterm'] <= 0) {
			$this->post['todo_noterm'] = 0;
		}
		if ($_POST['completeyear'] > 2000 && $_POST['completemonth'] > 0 && $_POST['completeday'] > 0) {
			$this->post['todo_completedate'] = date('Y-m-d H:i:s', mktime($_POST['completehour'], $_POST['completeminute'], 0, $_POST['completemonth'], $_POST['completeday'], $_POST['completeyear']));
		}
		if (is_array($_POST['todo']['user']) && count($_POST['todo']['user']) > 0) {
			$this->post['todo_user'] = $this->permitParse($_POST['todo']['user']);
		}
		
	}
	
	function index() {
		
		if (isset($_POST['folder'])) {
			if ($_POST['folder'] >= 0) {
				$this->move();
			} elseif ($_POST['folder'] == -1) {
				$this->deleteChecked();
			}
		}
		$this->where[] = "(owner = '".$this->quote($_SESSION['userid'])."')";
		if ($_GET['folder'] == 'complete') {
			$this->where[] = "(todo_complete = 1)";
			$sort = 'todo_completedate';
			$desc = 1;
		} elseif (strlen($_GET['folder']) > 0 && $_GET['folder'] >= 0) {
			$this->where[] = "(folder_id = '".intval($_GET['folder'])."')";
			$sort = 'todo_complete, todo_completedate DESC, todo_noterm, todo_term';
			$desc = 1;
		} else {
			$this->where[] = "(todo_complete = 0)";
			$sort = 'todo_noterm, todo_term';
			$desc = 0;
		}
		$hash = $this->findLimit($sort, $desc);
		$hash['folder'] = $this->findFolder('todo');
		return $hash;
	
	}

	function view() {
	
		$hash['data'] = $this->permitOwner();
		if (isset($_POST['folder'])) {
			$this->move('index.php');
		}
		if (strlen($hash['data']['todo_user']) > 0) {
			if ($hash['data']['todo_parent'] > 0) {
				$parent = $hash['data']['todo_parent'];
			} else {
				$parent = $hash['data']['id'];
			}
			$field = implode(',', $this->schematize());
			$data = $this->fetchAll("SELECT ".$field.",owner FROM ".$this->table." WHERE (id = ".intval($parent).") OR (todo_parent = ".intval($parent).")");
			if (is_array($data) && count($data) > 0) {
				foreach ($data as $row) {
					$hash['list'][$row['owner']] = $row['todo_complete'];
				}
			}
		}
		$hash['folder'] = $this->findFolder('todo');
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function add() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('insert');
			$this->validate();
			if (count($this->error) <= 0 && count($this->post) > 0) {
				$field = $this->schematize('insert');
				if (is_array($field) && count($field) > 0) {
					$this->post['created'] = date('Y-m-d H:i:s');
					foreach ($field as $key) {
						if (isset($this->post[$key])) {
							$keys[] = $key;
							$values[] = $this->quote($this->post[$key]);
						}
					}
					$query = "INSERT INTO ".$this->table." (".implode(",", $keys).", todo_parent, owner) VALUES ('".implode("','", $values)."', %d, '%s')";
					$this->response = $this->query(sprintf($query, 0, $this->quote($_SESSION['userid'])));
					if (is_array($_POST['todo']['user']) && count($_POST['todo']['user']) > 0) {
						$data = $this->fetchOne("SELECT id FROM ".$this->table." WHERE (created = '".$this->post['created']."') AND (owner = '".$this->quote($_SESSION['userid'])."')");
						if ($data['id'] > 0) {
							foreach ($_POST['todo']['user'] as $key => $value) {
								if (strlen($key) > 0 && $key != $_SESSION['userid']) {
									$this->post['folder_id'] = 0;
									$this->response = $this->query(sprintf($query, intval($data['id']), $key));
								}
							}
						}
					}
				}
				$this->redirect();
			}
		}
		$hash['data'] = $this->post;
		return $hash;
	
	}

	function edit() {
	
		$hash['data'] = $this->permitOwner();
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $hash['data']['id'] == $_REQUEST['id']) {
			$this->validateSchema('update');
			$this->validate();
			$this->updatePost();
			$this->redirect();
			$hash['data'] = $this->post;
		}
		return $hash;
	
	}

	function delete() {
		
		$hash['data'] = $this->permitOwner();
		$this->deleteChecked('index.php'.$this->parameter(array('folder'=>$hash['data']['folder_id'])));
		return $hash;

	}

	function move($redirect = null) {
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['folder'] >= 0 && is_array($_POST['checkedid']) && count($_POST['checkedid']) > 0) {
			foreach ($_POST['checkedid'] as $value) {
				$array[] = intval($value);
			}
			if ($_POST['folder'] == 'complete') {
				$query = sprintf("UPDATE %s SET todo_complete = 1, todo_completedate = '%s' WHERE (id IN (%s)) AND (owner = '%s')", $this->table, date('Y-m-d H:i:s'), implode(",", $array), $this->quote($_SESSION['userid']));
			} elseif ($_POST['folder'] == 'incomplete') {
				$query = sprintf("UPDATE %s SET todo_complete = 0, todo_completedate = '' WHERE (id IN (%s)) AND (owner = '%s')", $this->table, implode(",", $array), $this->quote($_SESSION['userid']));
			} else {
				$query = sprintf("UPDATE %s SET folder_id = '%s' WHERE (id IN (%s)) AND (owner = '%s')", $this->table, intval($_REQUEST['folder']), implode(",", $array), $this->quote($_SESSION['userid']));
			}
			$this->response = $this->query($query);
			if ($redirect) {
				$this->redirect($redirect);
			}
		}
	
	}

	function deleteChecked($redirect = null) {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_POST['folder'] == -1 && is_array($_POST['checkedid']) && count($_POST['checkedid']) > 0) {
				foreach ($_POST['checkedid'] as $value) {
					$array[] = intval($value);
				}
				$where = "(id IN (".implode(",", $array)."))";
			} elseif ($_POST['id'] > 0) {
				$where = "(id = ".intval($_REQUEST['id']).")";
			}
			if (strlen($where) > 0) {
				$query = sprintf("DELETE FROM %s WHERE %s AND (owner = '%s')", $this->table, $where, $this->quote($_SESSION['userid']));
				$this->response = $this->query($query);
				if ($redirect) {
					$this->redirect($redirect);
				}
			}
		}

	}
	
}

?>