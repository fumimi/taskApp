<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コードUTF-8
 */

class Connection {

	var $handler;
	
	function Connection() {
		
		if (file_exists(DB_FILE)) {
			$this->handler = sqlite_open(DB_FILE, 0666, $sqliteerror);
		}
		return $this->handler;
	
	}
	
	function close() {
		
		if ($this->handler) {
			return sqlite_close($this->handler);
		} else {
			die('データベースハンドラが見つかりません。');
		}
	
	}
	
	function query($query) {
		
		if ($this->handler) {
			return sqlite_query($this->handler, $query);
		} else {
			die('データベースハンドラが見つかりません。');
		}
		
	}
	
	function fetchAll($query) {
	
		if ($this->handler) {
			$response = sqlite_query($this->handler, $query);
			if ($response) {
				return sqlite_fetch_all($response, SQLITE_ASSOC);
			} else {
				return false;
			}
		} else {
			die('データベースハンドラが見つかりません。');
		}
	
	}
	
	function fetchLimit($query, $offset = 0, $limit = 20) {

		$query .= sprintf(" LIMIT %d OFFSET %d", $limit, $offset);
		return $this->fetchAll($query);

	}

	function fetchOne($query) {

		$data = $this->fetchLimit($query, 0, 1);
		if (is_array($data) && is_array($data[0])) {
			return $data[0];
		} else {
			return array();
		}
	
	}
	
	function fetchCount($table, $where = "", $field = "*") {

		if ($this->handler) {
			$query = sprintf("SELECT COUNT(%s) AS count FROM %s %s", $field, $table, $where);
			$response = sqlite_query($this->handler, $query);
			if ($response) {
				$row = sqlite_fetch_array($response, SQLITE_ASSOC);
				return $row['count'];
			} else {
				return false;
			}
		} else {
			die('データベースハンドラが見つかりません。');
		}
		
	}
	
	function insertid() {
		
		if ($this->handler) {
			$response = sqlite_query($this->handler, 'SELECT last_insert_rowid()');
			if ($response) {
				return sqlite_fetch_single($response);
			} else {
				return false;
			}
		} else {
			die('データベースハンドラが見つかりません。');
		}
		
	}
	
	function table() {

		if ($this->handler) {
			$query = "SELECT name FROM sqlite_master WHERE type='table' UNION ALL SELECT name FROM sqlite_temp_master WHERE type='table' ORDER BY name";
			$response = sqlite_query($this->handler, $query);
			if ($response) {
				while ($row = sqlite_fetch_array($response, SQLITE_ASSOC)) {
					$array[] = $row["name"];
				}
				return $array;
			} else {
				return false;
			}
		} else {
			die('データベースハンドラが見つかりません。');
		}

	}
	
	function quote($string) {
	
		if ($this->handler) {
			return sqlite_escape_string($string);
		} else {
			die('データベースハンドラが見つかりません。');
		}
	
	}

}
?>