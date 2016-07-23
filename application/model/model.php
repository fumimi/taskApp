<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Model extends Connection {
	
	var $table;
	var $schema = array();
	var $where = array();
	var $post = array();
	var $error = array();
	var $response;
	var $validation;
	
	function connect() {
		
		if (!$this->handler) {
			$this->Connection();
			if (!$this->handler) {
				$this->died('データベースの接続に失敗しました。');
			} elseif (!$this->table) {
				$this->table = DB_PREFIX.basename(dirname($_SERVER['SCRIPT_NAME']));
			}
		}

	}
	
	function findLimit($sort = null, $desc = 0, $searchfield = null) {
		
		$field = $this->schematize();
		if ($_REQUEST['page'] <= 0) {
			$page = 1;
		} else {
			$page = intval($_REQUEST['page']);
		}
		if ($_REQUEST['limit'] > 0 && $_REQUEST['limit'] < APP_LIMITMAX) {
			$limit = intval($_REQUEST['limit']);
		} else {
			$limit = APP_LIMIT;
		}
		$offset = ($page - 1) * $limit;
		if (isset($_REQUEST['sort']) && strlen($_REQUEST['sort']) > 0) {
			$order = " ORDER BY ".$this->quote($_REQUEST['sort']);
		} elseif ($sort) {
			$order = " ORDER BY ".$this->quote($sort);
		}
		if ($order && ($_REQUEST['desc'] > 0 || (!isset($_REQUEST['desc']) && $desc > 0))) {
			$order .= " DESC";
			$_REQUEST['desc'] = 1;
		}
		$array = $this->where;
		$searchWhere = $this->searchWhere($searchfield);
		if (strlen($searchWhere) > 0) {
			$array[] = $searchWhere;
		}
		if (is_array($array) && count($array) > 0) {
			$where = "WHERE ".implode(" AND ", $array);
		}
		if (is_array($field) && count($field) > 0) {
			$string = implode(',', $field);
		} else {
			$string = '*';
		}
		$query = sprintf("SELECT %s FROM %s %s %s", $string, $this->table, $where, $order);
		$result['list'] = $this->fetchLimit($query, $offset, $limit);
		$result['count'] = $this->fetchCount($this->table, $where, 'id');
		return $result;
	
	}
	
	function searchWhere($searchfield = null) {
		
		if (isset($_REQUEST['search']) && strlen($_REQUEST['search']) > 0) {
			if (!$searchfield) {
				$searchfield = $this->schematize('search');
			}
			$keyword = explode(' ', str_replace('　', ' ', $_REQUEST['search']));
			if (is_array($keyword) && count($keyword) > 0 && is_array($searchfield) && count($searchfield) > 0) {
				foreach ($keyword as $value) {
					$row = array();
					foreach ($searchfield as $key) {
						$row[] = sprintf("(%s LIKE '%%%s%%')", $key, $this->quote($value));
					}
					$array[] = "(".implode(" OR ", $row).")";
				}
			}
		}
		if (is_array($array) && count($array) > 0) {
			return implode(" AND ", $array);
		}
	
	}
	
	function findView($id = 0) {
		
		if ($id <= 0) {
			$id = $_REQUEST['id'];
		}
		if ($id > 0) {
			$field = implode(',', $this->schematize());
			return $this->fetchOne("SELECT ".$field." FROM ".$this->table." WHERE id = ".intval($id));
		}
		
	}
	
	function schematize($string = '') {
		
		if ($string) {
			foreach ($this->schema as $key => $row) {
				if (!isset($row['except']) || !in_array($string, $row['except'])) {
					$array[] = $key;
				}
			}
		} else {
			$array = array_keys($this->schema);
		}
		if ($string == 'insert') {
			$array[] = 'owner';
			$array[] = 'created';
		} elseif ($string == 'update') {
			$array[] = 'editor';
			$array[] = 'updated';
		} elseif (!$string) {
			$array[] = 'id';
			$array[] = 'owner';
			$array[] = 'editor';
			$array[] = 'created';
			$array[] = 'updated';
		}
		if (is_array($array) && count($array) > 0) {
			$array = array_unique($array);
		}
		return $array;
		
	}
	
	function insertPost() {
		
		$this->response = false;
		if (count($this->error) <= 0 && count($this->post) > 0) {
			$field = $this->schematize('insert');
			if (is_array($field) && count($field) > 0) {
				$this->post['owner'] = $_SESSION['userid'];
				$this->post['created'] = date('Y-m-d H:i:s');
				foreach ($field as $key) {
					if (array_key_exists($key, $this->post)) {
						$keys[] = $key;
						$values[] = $this->quote($this->post[$key]);
					}
				}
				$query = "INSERT INTO ".$this->table." (".implode(",", $keys).") VALUES ('".implode("','", $values)."')";
				$this->response = $this->query($query);
				return $this->response;
			}
		}

	}

	function updatePost() {
	
		$this->response = false;
		if (count($this->error) <= 0 && count($this->post) > 0 && $_POST['id'] > 0) {
			$field = $this->schematize('update');
			if (is_array($field) && count($field) > 0) {
				$this->post['editor'] = $_SESSION['userid'];
				$this->post['updated'] = date('Y-m-d H:i:s');
				foreach ($field as $key) {
					if (array_key_exists($key, $this->post)) {
						$array[] = $key." = '".$this->quote($this->post[$key])."'";
					}
				}
				$query = "UPDATE ".$this->table." SET ".implode(",", $array)." WHERE id = ".intval($_POST['id']);
				$this->response = $this->query($query);
				return $this->response;
			}
		}
		
	}

	function deletePost() {
	
		$this->response = false;
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && count($this->error) <= 0) {
			if (isset($_POST['id']) && $_POST['id'] > 0) {
				$query = "DELETE FROM ".$this->table." WHERE id = ".intval($_POST['id']);
				$this->response = $this->query($query);
				return $this->response;
			} else {
				$this->error[] = '削除するデータを選択してください。';
			}
		}
		
	}

	function deleteChecked() {
	
		$this->response = false;
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && count($this->error) <= 0) {
			if (is_array($_POST['checkedid']) && count($_POST['checkedid']) > 0) {
				foreach ($_POST['checkedid'] as $value) {
					$array[] = intval($value);
				}
				$query = "DELETE FROM ".$this->table." WHERE id IN (".implode(",", $array).")";
				$this->response = $this->query($query);
				return $this->response;
			} else {
				$this->error[] = '削除するデータを選択してください。';
			}
		}
		
	}

	function redirect($redirect = 'index.php') {
	
		if ($this->response && $redirect) {
			header('Location:'.$redirect);
			exit();
		}
		
	}
	
	function validateSchema($string = '') {
		
		if (isset($_POST['id'])) {
			if ($_POST['id'] > 0) {
				$this->post['id'] = intval($_POST['id']);
			} else {
				$this->error[] = 'IDが取得できません。';
			}
		}
		foreach ($this->schema as $field => $row) {
			if (is_array($row) && (!isset($row['except']) || !in_array($string, $row['except']))) {
				if (isset($row['fix']) && strlen($row['fix']) > 0) {
					$this->post[$field] = $row['fix'];
				} else {
					$caption = array_shift($row);
					$this->validator($field, $caption, $row);
				}
			}
		}
		
	}
	
	function validator($field, $caption, $rule) {
		
		if (!isset($this->post[$field])) {
			if (is_array($rule) && count($rule) > 0) {
				foreach ($rule as $value) {
					if ($value == 'distinct') {
						$this->distinct($field, $caption);
					} elseif (!is_array($value)) {
						$array = array($field, $caption);
						if (stristr($value, ':')) {
							$parameter = explode(':', $value);
							$method = array_shift($parameter);
							$array = array_merge($array, $parameter);
						} else {
							$method = $value;
						}
						if (!$this->validation) {
							$this->validation = new Validation;
						}
						if (method_exists($this->validation, $method)) {
							$error = call_user_func_array(array($this->validation, $method), $array);
							if ($error && strlen($error) > 0) {
								$this->error[] = $error;
							}
						} else {
							$this->died('Validationクラスに'.$method.'は存在しません。');
						}
					}
				}
			}
			$this->post[$field] = $_POST[$field];
		}
		
	}
	
	function distinct($field, $caption, $message = null) {
	
		if (strlen($_POST[$field]) > 0) {
			if (isset($_POST['id']) && $_POST['id'] > 0) {
				$where = sprintf("WHERE (id <> %d) AND (%s = '%s')", intval($_POST['id']), $field, $this->quote($_POST[$field]));
			} else {
				$where = sprintf("WHERE %s = '%s'", $field, $this->quote($_POST[$field]));
			}
			$count = $this->fetchCount($this->table, $where, 'id');
			if ($count > 0) {
				if (!$message) {
					$message = $caption.'はすでに存在します。別の'.$caption.'を入力してください。';
				}
				$this->error[] = $message;
			}
		}
		
	}

	function sanitize($data) {
	
		if (is_array($data)) {
			return array_map(array($this, 'sanitize'), $data);
		} else {
			return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		}
		
	}
	
	function uploadfile($directory, $prefix, $filelist = '') {
	
		$upload = DIR_UPLOAD.$directory.'/'.$prefix.'_';
		$temporary = DIR_UPLOAD.'temporary/'.$_SESSION['userid'].'_';
		if (count($_FILES) > 0 && (!is_writable(DIR_UPLOAD.$directory.'/') || !is_writable(DIR_UPLOAD.'temporary/'))) {
			$this->error[] = 'ファイルを保存するディレクトリに書き込み権限がありません。';
		}
		if (is_array($_POST['uploadedfile']) && count($_POST['uploadedfile']) > 0) {
			foreach ($_POST['uploadedfile'] as $key => $value) {
				if (strlen($value) > 0) {
					$value = $this->uploadencode($value);
					if (file_exists($temporary.$value) || file_exists($upload.$value)) {
						$uploadedfile[] = $_POST['uploadedfile'][$key];
					} else {
						$this->error[] = $_POST['uploadedfile'][$key].'が取得できません。';
					}
				}
			}
		}
		if (is_array($_FILES['uploadfile']['name']) && count($_FILES['uploadfile']['name']) > 0) {
			for ($i = 0; $i < count($_FILES['uploadfile']['name']); $i++) {
				if (isset($_FILES['uploadfile']['name'][$i]) && strlen($_FILES['uploadfile']['name'][$i]) > 0) {
					$filename = $_FILES['uploadfile']['name'][$i];
					$message = '';
					if (preg_match('/.+\.('.APP_EXTENSION.')$/i', $filename)) {
						$message = $filename.'はアップロードできない種類のファイルです。';
					} elseif (stristr($filename, ' ')) {
						$message = 'ファイル名に半角スペースは使用できません。('.$filename.')';
					} elseif ($_FILES['uploadfile']['size'][$i] <= 0) {
						$message = $filename.'のファイルサイズを確認してください。';
					} elseif ($_FILES['uploadfile']['size'][$i] > APP_FILESIZE) {
						$message = $filename.'のファイルサイズが制限を超えています。';
					} elseif (!is_uploaded_file($_FILES['uploadfile']['tmp_name'][$i])) {
						$message = $filename.'のアップロードに失敗しました。';
					}
					if (strlen($message) > 0) {
						$this->error[] = $message;
						$_FILES['uploadfile']['tmp_name'][$i] = null;
					}
				}
			}
		}
		$result = array();
		if (count($this->error) <= 0) {
			if (is_array($uploadedfile) && count($uploadedfile) > 0) {
				foreach ($uploadedfile as $key => $value) {
					$response = true;
					$value = $this->uploadencode($value);
					if (file_exists($temporary.$value)) {
						$response = @rename($temporary.$value, $upload.$value);
					}
					if ($response) {
						$result[] = $uploadedfile[$key];
					}
				}
			}
			if (is_array($_FILES['uploadfile']['name']) && count($_FILES['uploadfile']['name']) > 0) {
				for ($i = 0; $i < count($_FILES['uploadfile']['name']); $i++) {
					if (strlen($_FILES['uploadfile']['name'][$i]) > 0 && is_uploaded_file($_FILES['uploadfile']['tmp_name'][$i])) {
						$value = $this->uploadencode($_FILES['uploadfile']['name'][$i]);
						if (@move_uploaded_file($_FILES['uploadfile']['tmp_name'][$i], $upload.$value)) {
							$result[] = $_FILES['uploadfile']['name'][$i];
							@chmod($upload.$value, 0606);
						}
					}
				}
			}
			if (strlen($filelist) > 0) {
				$array = explode(',', $filelist);
				if (is_array($array) && count($array) > 0) {
					foreach ($array as $value) {
						if (!in_array($value, $result)) {
							$value = $this->uploadencode($value);
							if (file_exists($upload.$value)) {
								@unlink($upload.$value);
							}
						}
					}
				}
			}
			$this->temporary();
		} else {
			if (is_array($uploadedfile) && count($uploadedfile) > 0) {
				$result = $uploadedfile;
			}
			if (is_array($_FILES['uploadfile']['name']) && count($_FILES['uploadfile']['name']) > 0) {
				for ($i = 0; $i < count($_FILES['uploadfile']['name']); $i++) {
					if (strlen($_FILES['uploadfile']['name'][$i]) > 0 && is_uploaded_file($_FILES['uploadfile']['tmp_name'][$i])) {
						$value = $this->uploadencode($_FILES['uploadfile']['name'][$i]);
						if (@move_uploaded_file($_FILES['uploadfile']['tmp_name'][$i], $temporary.$value)) {
							$result[] = $_FILES['uploadfile']['name'][$i];
							@chmod($temporary.$value, 0606);
						}
					}
				}
			}
			$this->temporary($result);
		}
		return implode(',', $result);
	
	}
	
	function removefile($directory, $prefix, $filelist) {
	
		$upload = DIR_UPLOAD.$directory.'/'.$prefix.'_';
		if (!is_writable(DIR_UPLOAD.$directory.'/')) {
			$this->died('ファイルを削除するディレクトリに書き込み権限がありません。');
		}
		if (count($this->error) <= 0 && strlen($filelist) > 0) {
			$array = explode(',', $filelist);
			if (is_array($array) && count($array) > 0) {
				foreach ($array as $value) {
					$value = $this->uploadencode($value);
					if (file_exists($upload.$value)) {
						@unlink($upload.$value);
					}
				}
			}
		}
	
	}
	
	function temporary($array = null) {
		
		$temporary = DIR_UPLOAD.'temporary/';
		$filing = new Filing;
		$filelist = $filing->filelist($temporary);
		if (is_array($filelist) && count($filelist) > 0) {
			foreach ($filelist as $value) {
				if (file_exists($temporary.$value) && $value != 'empty') {
					$filename = $this->uploaddecode($value);
					if (preg_match('/^'.$_SESSION['userid'].'_/', $filename)) {
						$filename = str_replace($_SESSION['userid'].'_', '', $filename);
						if (!is_array($array) || !in_array($filename, $array)) {
							@unlink($temporary.$value);
						}
					}
				}
			}
		}
		
	}
	
	function attachment($directory, $prefix, $filename, $type = '') {
		
		$file = DIR_UPLOAD.$directory.'/'.$prefix.'_'.$this->uploadencode($filename);
		if (file_exists($file)) {
			$filing = new Filing;
			if (preg_match('/.+\.(jpeg|jpg|gif|png)$/', $filename) && $type != 'attachment') {
				$filing->image($file, $filename);
			} else {
				$filing->attachment($file, $filename);
			}
		} else {
			$this->died('ファイル'.$filename.'が見つかりません。');
		}
		
	}
	
	function uploadencode($string) {
		
		if (stristr(PHP_OS, 'win')) {
			$string = mb_convert_encoding($string, 'SJIS', 'SJIS, UTF-8');
		}
		return $string;
		
	}
	
	function uploaddecode($string) {
		
		if (stristr(PHP_OS, 'win')) {
			$string = mb_convert_encoding($string, 'UTF-8', 'UTF-8, SJIS');
		}
		return $string;
		
	}
	
	function uploadfilesize($filename, $directory) {
	
		if (strlen($filename) > 0) {
			$file = DIR_UPLOAD.$directory.'/'.$this->uploadencode($filename);
			if (file_exists($file)) {
				$size = @filesize($file);
				if ($size > 1024) {
					$size = floor($size / 1024);
				} elseif ($size <= 0) {
					$size = 0;
				} else {
					$size = 1;
				}
				return number_format($size).'K';
			}
		}
	
	}
	
	function died($message) {
		
		require_once(DIR_VIEW.'die.php');
		exit();
		
	}

}

?>