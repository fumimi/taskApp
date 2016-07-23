<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class ApplicationModel extends Model {
	
	function authorize() {
		
		$this->connect();
		$authorized = false;
		$argument = func_get_args();
		if (is_array($argument) && count($argument) > 0) {
			$data = $this->fetchOne("SELECT authority FROM ".DB_PREFIX."user WHERE userid = '".$this->quote($_SESSION['userid'])."'");
			foreach ($argument as $value) {
				if (strlen($value) > 0 && $value === $data['authority']) {
					$authorized = true;
				}
			}
		}
		if ($authorized !== true) {
			$this->died('権限がありません。');
		}
		return $authorized;
	
	}
	
	function permitList($sort = 'id', $desc = 1) {
		
		$this->where[] = $this->permitWhere();
		return $this->findLimit($sort, $desc);
	
	}
	
	function permitWhere($level = '') {
		
		$query = "(public_level = 0 OR owner = '%s' OR ";
		$query .= "(public_level = 2 AND (public_group LIKE '%%[%s]%%' OR public_user LIKE '%%[%s]%%')))";
		$where = sprintf($query, $this->quote($_SESSION['userid']), $this->quote($_SESSION['group']), $this->quote($_SESSION['userid']));
		if ($level == 'add') {
			$query = "AND (add_level = 0 OR owner = '%s' OR ";
			$query .= "(add_level = 2 AND (add_group LIKE '%%[%s]%%' OR add_user LIKE '%%[%s]%%')))";
			$where .= sprintf($query, $this->quote($_SESSION['userid']), $this->quote($_SESSION['group']), $this->quote($_SESSION['userid']));
		}
		return $where;
		
	}
	
	function permitFind($level = 'public', $id = 0) {
		
		if ($id <= 0) {
			$id = $_REQUEST['id'];
		}
		if ($id > 0) {
			$field = implode(',', $this->schematize());
			$data = $this->fetchOne("SELECT ".$field." FROM ".$this->table." WHERE id = ".intval($id));
			if ($this->permitted($data, 'public')) {
				if ($level == 'edit' && !$this->permitted($data, 'edit')) {
					$this->died('編集する権限がありません。');
				} else {
					return $data;
				}
			} else {
				$this->died('閲覧する権限がありません。');
			}
		}
		
	}
	
	function permitted($data, $level = 'public') {
		
		$permission = false;
		if ($data[$level.'_level'] == 0) {
			$permission = true;
		} elseif (strlen($data['owner']) > 0 && $data['owner'] == $_SESSION['userid']) {
			$permission = true;
		} elseif ($data[$level.'_level'] == 2 && (stristr($data[$level.'_group'], '['.$_SESSION['group'].']') || stristr($data[$level.'_user'], '['.$_SESSION['userid'].']'))) {
			$permission = true;
		}
		return $permission;
	
	}
	
	function permitInsert($redirect = 'index.php') {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('insert');
			$this->permitValidate();
			if (method_exists($this, 'validate')) {
				$this->validate();
			}
			$this->insertPost();
			$this->redirect($redirect);
		}
		return $this->post;
	
	}
	
	function permitUpdate($redirect = 'index.php') {
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('update');
			$this->permitValidate();
			if (method_exists($this, 'validate')) {
				$this->validate();
			}
			$this->updatePost();
			$this->redirect($redirect);
			return $this->post;
		}
		
	}
	
	function permitValidate() {
	
		$array = array('public'=>'公開', 'edit'=>'編集を許可', 'add'=>'書き込みを許可');
		foreach ($array as $key => $value) {
			if (isset($_POST[$key.'_level'])) {
				$this->post[$key.'_level'] = intval($_POST[$key.'_level']);
				if ($_POST[$key.'_level'] == 2) {
					if (count($_POST[$key]['group']) <= 0 && count($_POST[$key]['user']) <= 0) {
						$this->error[] = $value.'するグループ・ユーザーを選択してください。';
					} else {
						$this->post[$key.'_group'] = $this->permitParse($_POST[$key]['group']);
						$this->post[$key.'_user'] = $this->permitParse($_POST[$key]['user']);
					}
				} else {
					$this->post[$key.'_group'] = '';
					$this->post[$key.'_user'] = '';
				}
			}
		}
	
	}
	
	function permitParse($array) {
	
		if (is_array($array) && count($array) > 0) {
			$array = array_unique(array_keys($array));
			$string = '['.implode('][', $array).']';
			if (!preg_match('/^[-_a-zA-Z0-9\.\[\]]*$/', $string)) {
				$this->error[] = '権限の設定が無効です。';
			}
		}
		return $string;
	
	}
	
	function permitOwner($id = 0) {
		
		if ($id <= 0) {
			$id = $_REQUEST['id'];
		}
		if ($id > 0) {
			$field = implode(',', $this->schematize());
			$data = $this->fetchOne("SELECT ".$field." FROM ".$this->table." WHERE (id = ".intval($id).") AND (owner = '".$this->quote($_SESSION['userid'])."')");
			return $data;
		}
		
	}
	
	function findGroup() {
		
		$data = $this->fetchAll("SELECT id,group_name FROM ".DB_PREFIX."group ORDER BY group_order,id");
		$array = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$array[$row['id']] = $row['group_name'];
			}
		}
		return $array;
	
	}
	
	function findUser() {
		
		$group = $this->findGroup();
		$argument = func_get_args();
		$array = array();
		foreach ($argument as $row) {
			if (isset($row['owner']) && strlen($row['owner']) > 0) {
				$array[] = $this->quote($row['owner']);
			}
			if (isset($row['editor']) && strlen($row['editor']) > 0) {
				$array[] = $this->quote($row['editor']);
			}
			if (is_array($row) && count($row) > 0) {
				foreach ($row as $key => $value) {
					if (strlen($value) > 0 && stristr($key, '_user') && stristr($value, '[')) {
						$string .= $value;
					}
				}
			}
		}
		if (strlen($string) > 0) {
			$data = explode(',', str_replace(array('][', '[', ']'), array(',', '', ''), $string));
			$data = array_unique($data);
			if (is_array($data) && count($data) > 0) {
				foreach ($data as $value) {
					if (strlen($value) > 0) {
						$array[] = $this->quote($value);
					}
				}
			}
		}
		$array = array_unique($array);
		$user = array();
		if (is_array($array) && count($array) > 0) {
			$query = "SELECT userid, realname FROM ".DB_PREFIX."user WHERE userid IN ('".implode("','", $array)."') ORDER BY user_order,id";
			$data = $this->fetchAll($query);
			if (is_array($data) && count($data) > 0) {
				foreach ($data as $row) {
					$user[$row['userid']] = $row['realname'];
				}
			}
		}
		return array('group'=>$group, 'user'=>$user);
	
	}
	
	function permitCategory($type, $id = 0, $level = 'public') {
		
		$query = sprintf("SELECT folder_id,folder_caption FROM %sfolder WHERE (folder_type = '%s') AND %s ORDER BY folder_order,folder_name", DB_PREFIX, $type, $this->permitWhere($level));
		$data = $this->fetchAll($query);
		$result['folder'] = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$result['folder'][$row['folder_id']] = $row['folder_caption'];
			}
		}
		if ($id > 0) {
			$query = sprintf("SELECT * FROM %sfolder WHERE (folder_type = '%s') AND (folder_id = '%s')", DB_PREFIX, $type, intval($id));
			$data = $this->fetchOne($query);
			if ($this->permitted($data, 'public')) {
				if ($level == 'add' && !$this->permitted($data, 'add')) {
					$this->died('このカテゴリへの書き込み権限がありません。');
				} else {
					$result['category'] = $data;
				}
			} else {
				$this->died('閲覧する権限がありません。');
			}
		}
		return $result;
		
	}
	
	function folderWhere($folder, $default = '0') {
		
		if (strlen($_GET['folder']) > 0) {
			$id = $_GET['folder'];
		} else {
			$id = $default;
		}
		if ($id === 'all') {
			if (is_array($folder) && count($folder) > 0) {
				$array = array_keys($folder);
			}
			$array[] = '0';
			return "(folder_id IN (".implode(",", $array)."))";
		} else {
			return "(folder_id = ".intval($id).")";
		}
	
	}
	
	function findFolder($type) {
		
		$query = sprintf("SELECT folder_id,folder_caption FROM %sfolder WHERE (folder_type = '%s') AND (owner = '%s') ORDER BY folder_order,folder_name", DB_PREFIX, $type, $_SESSION['userid']);
		$data = $this->fetchAll($query);
		$result = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$result[$row['folder_id']] = $row['folder_caption'];
			}
		}
		return $result;
		
	}
	
	function parameter($array) {
		
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $key => $value) {
				if ($value > 0) {
					$result[] = $key.'='.intval($value);
				}
			}
		}
		if (is_array($result) && count($result) > 0) {
			return '?'.implode('&', $result);
		}
		
	}

}

?>