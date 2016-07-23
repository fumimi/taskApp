<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Message extends ApplicationModel {
	
	function Message() {
	
		$this->schema = array(
		'folder_id'=>array('fix'=>'0', 'except'=>array('search')),
		'message_type'=>array('except'=>array('search')),
		'message_to'=>array('except'=>array('search')),
		'message_from'=>array('fix'=>$_SESSION['userid'], 'except'=>array('search')),
		'message_toname'=>array(),
		'message_fromname'=>array('fix'=>$_SESSION['realname']),
		'message_title'=>array('件名', 'notnull', 'length:1000'),
		'message_comment'=>array('内容', 'notnull', 'length:10000', 'line:100'),
		'message_date'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search')),
		'message_file'=>array());
	
	}
	
	function index() {
		
		$this->move();
		$this->where[] = "(owner = '".$this->quote($_SESSION['userid'])."')";
		if ($_GET['folder'] == 'all') {
			$this->where[] = "(message_type = 'received') AND (folder_id >= 0)";
		} elseif ($_GET['folder'] > 0) {
			$this->where[] = "(folder_id = '".intval($_GET['folder'])."')";
		} else {
			$this->where[] = "(message_type = 'received') AND (folder_id = 0)";
		}
		$hash = $this->findLimit('message_date', 1);
		$hash['folder'] = $this->findFolder('message');
		return $hash;
	
	}
	
	function sent() {
		
		$this->move();
		$this->where[] = "(message_type = 'sent') AND (owner = '".$this->quote($_SESSION['userid'])."') AND (folder_id = 0)";
		$hash = $this->findLimit('message_date', 1);
		$hash['folder'] = $this->findFolder('message');
		return $hash;
	
	}
	
	function trash() {
		
		$this->move();
		$this->delete();
		$this->where[] = "(owner = '".$this->quote($_SESSION['userid'])."') AND (folder_id < 0)";
		$hash = $this->findLimit('message_date', 1);
		$hash['folder'] = $this->findFolder('message');
		return $hash;
	
	}

	function view() {
	
		$hash['data'] = $this->permitOwner();
		if (isset($_POST['folder'])) {
			if ($hash['data']['folder_id'] < 0) {
				if ($_POST['folder'] == -1) {
					$this->delete();
				} else {
					$redirect = 'trash.php';
				}
			} elseif ($hash['data']['folder_id'] > 0) {
				$redirect = 'index.php?folder='.intval($hash['data']['folder_id']);
			} elseif ($hash['data']['message_type'] == 'sent') {
				$redirect = 'sent.php';
			} else {
				$redirect = 'index.php';
			}
			$this->move($redirect);
		}
		$hash['folder'] = $this->findFolder('message');
		return $hash;
	
	}
	
	function create() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (count($_POST['to']['user']) <= 0) {
				$this->error[] = '宛先を選択してください。';
			}
			$this->validateSchema('insert');
			if (is_array($_POST['to']['user']) && count($_POST['to']['user']) > 0) {
				$array = array();
				foreach ($_POST['to']['user'] as $key => $value) {
					if (!preg_match('/^[-_\.a-zA-Z0-9]*$/', $key)){
						$this->error[] = '宛先が無効です。';
						break;
					} else {
						$array[$key] = $this->quote($value);
					}
				}
				$this->post['message_to'] = implode(',', array_keys($array));
				$this->post['message_toname'] = implode(',', $array);
			}
			$this->post['message_file'] = $this->uploadfile('message', $this->post['message_from'].'_'.strtotime($this->post['message_date']));
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
					$query = "INSERT INTO ".$this->table." (".implode(",", $keys).", message_type, owner) VALUES ('".implode("','", $values)."', '%s', '%s')";
					$this->response = $this->query(sprintf($query, 'sent', $this->quote($_SESSION['userid'])));
					foreach ($array as $key => $value) {
						$this->response = $this->query(sprintf($query, 'received', $key));
					}
				}
			}
			$this->redirect();
			$hash['data'] = $this->post;
			$hash['to'] = $_POST['to']['user'];
			$hash['folder'] = $this->findFolder('message');
		} else {
			$hash = $this->view();
			if ($hash['data']['id'] > 0) {
				$hash['to'] = array();
				if ($_GET['type'] == 'forward') {
					$hash['data']['message_title'] = 'Fwd: '.$hash['data']['message_title'];
					$this->copyUploadfile($hash['data']['message_from'].'_'.strtotime($hash['data']['message_date']), $hash['data']['message_file']);
				} else {
					if ($_GET['type'] == 'all') {
						$key = explode(',', $hash['data']['message_to']);
						$value = explode(',', $hash['data']['message_toname']);
						for ($i = 0; $i < count($key); $i++) {
							if ($key[$i] != $_SESSION['userid']) {
								$hash['to'][$key[$i]] = $value[$i];
							}
						}
					}
					if (!array_key_exists($hash['data']['message_from'], $hash['to'])) {
						$hash['to'][$hash['data']['message_from']] = $hash['data']['message_fromname'];
					}
					$hash['data']['message_title'] = 'Re: '.$hash['data']['message_title'];
					$hash['data']['message_file'] = '';
				}
				$hash['data']['message_comment'] = str_replace(array("\r\n", "\r"), "\n", $hash['data']['message_comment']);
				$hash['data']['message_comment'] = '> '.str_replace("\n", "\n> ", $hash['data']['message_comment']);
			}
		}
		return $hash;
	
	}

	function move($redirect = null) {
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['folder']) && is_array($_POST['checkedid']) && count($_POST['checkedid']) > 0) {
			foreach ($_POST['checkedid'] as $value) {
				$array[] = intval($value);
			}
			$query = sprintf("UPDATE %s SET folder_id = '%s' WHERE (id IN (%s)) AND (owner = '%s')", $this->table, intval($_REQUEST['folder']), implode(",", $array), $this->quote($_SESSION['userid']));
			$this->response = $this->query($query);
			if ($redirect) {
				$this->redirect($redirect);
			}
		}
	
	}

	function delete() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($_POST['folder'] == -1 && is_array($_POST['checkedid']) && count($_POST['checkedid']) > 0) {
				foreach ($_POST['checkedid'] as $value) {
					$array[] = intval($value);
				}
				$where = sprintf("(id IN (%s)) AND (owner = '%s') AND (folder_id = -1)", implode(",", $array), $this->quote($_SESSION['userid']));
			} elseif ($_POST['empty'] == 'empty') {
				$where = sprintf("(owner = '%s') AND (folder_id = -1)", $this->quote($_SESSION['userid']));
			}
			if (strlen($where) > 0) {
				$field = implode(',', $this->schematize());
				$query = sprintf("SELECT %s FROM %s WHERE %s", $field, $this->table, $where);
				$data = $this->fetchAll($query);
				$query = sprintf("DELETE FROM %s WHERE %s", $this->table, $where);
				$this->response = $this->query($query);
				if ($this->response && is_array($data) && count($data) > 0) {
					foreach ($data as $row) {
						if (strlen($row['message_file']) > 0) {
							$count = $this->fetchCount($this->table, "WHERE (message_file = '".$this->quote($row['message_file'])."') AND (message_date = '".$this->quote($row['message_date'])."') AND (message_from = '".$this->quote($row['message_from'])."')", 'id');
							if ($count <= 0) {
								$array = explode(',', $row['message_file']);
								if (is_array($array) && count($array) > 0) {
									$prefix = $row['message_from'].'_'.strtotime($row['message_date']);
									foreach ($array as $value) {
										if (file_exists(DIR_UPLOAD.'message/'.$prefix.'_'.$value)) {
											@unlink(DIR_UPLOAD.'message/'.$prefix.'_'.$value);
										}
									}
								}
							}
						}
					}
				}
				$this->redirect('trash.php');
			}
		}
		return $hash;

	}
	
	function feed() {
		
		if ($_REQUEST['group'] <= 0) {
			$_REQUEST['group'] = $_SESSION['group'];
		}
		$query = "SELECT userid, realname FROM ".DB_PREFIX."user WHERE (user_group = '".intval($_REQUEST['group'])."') ORDER BY user_order,id";
		$hash['list'] = $this->fetchAll($query);
		$hash['group'] = $this->findGroup();
		return $hash;
		
	}
	
	function download() {
		
		$data = $this->findView();
		if ($data['owner'] != $_SESSION['userid']) {
			$this->died('閲覧する権限がありません。');
		} elseif (stristr($data['message_file'], $_REQUEST['file'])) {
			$this->attachment('message', $data['message_from'].'_'.strtotime($data['message_date']), $_REQUEST['file']);
		} else {
			$this->died('ファイルが見つかりません。');
		}
	
	}
	
	function copyUploadfile($prefix, $filelist) {
	
		if (strlen($filelist) > 0) {
			if (!is_writable(DIR_UPLOAD.'temporary/')) {
				$this->died('temporaryディレクトリに書き込み権限がありません。');
			}
			$upload = DIR_UPLOAD.'message/'.$prefix.'_';
			$temporary = DIR_UPLOAD.'temporary/'.$_SESSION['userid'].'_';
			$array = explode(',', $filelist);
			$result = array();
			if (is_array($array) && count($array) > 0) {
				foreach ($array as $value) {
					$uploadedfile = $this->uploadencode($value);
					if (file_exists($upload.$uploadedfile)) {
						$response = @copy($upload.$uploadedfile, $temporary.$uploadedfile);
						if ($response) {
							$result[] = $value;
						}
					}
				}
			}
			return implode(',', $result);
		}
	
	}
	
}

?>