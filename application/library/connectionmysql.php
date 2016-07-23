<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コードUTF-8
 */

class Connection {

	var $handler;
	
	function Connection() {
		
		$this->handler = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
		if ($this->handler) {
			$response = mysql_select_db(DB_DATABASE);
			if (defined('DB_CHARSET') && DB_CHARSET) {
				if (version_compare(PHP_VERSION, '5.2.3', '>=') && function_exists('mysql_set_charset')) {
					mysql_set_charset('utf8', $this->handler);
				} else {
					mysql_query("SET NAMES utf8", $this->handler);
				}
			}
			return $response;
		}
		return $this->handler;
	
	}
	
	function close() {
		
		if ($this->handler) {
			return mysql_close($this->handler);
		} else {
			die('データベースハンドラが見つかりません。');
		}
	
	}
	
	function query($query) {
		
		if ($this->handler) {
			return mysql_query($query, $this->handler);
		} else {
			die('データベースハンドラが見つかりません。');
		}
		
	}
	
	function fetchAll($query) {
	
		if ($this->handler) {
			$response = mysql_query($query, $this->handler);
			$data = array();
			if ($response) {
				while ($row = mysql_fetch_assoc($response)) {
					$data[] = $row;
				}
			}
			return $data;
		} else {
			die('データベースハンドラが見つかりません。');
		}
	
	}
	
	function fetchLimit($query, $offset = 0, $limit = 20) {

		$query .= sprintf(" LIMIT %d, %d", $offset, $limit);
		return $this->fetchAll($query);

	}

	function fetchOne($query) {

		if ($this->handler) {
			$response = mysql_query($query, $this->handler);
			if ($response) {
				$data = mysql_fetch_assoc($response);
			}
			if (is_array($data)) {
				return $data;
			} else {
				return array();
			}
		} else {
			die('データベースハンドラが見つかりません。');
		}
	
	}
	
	function fetchCount($table, $where = "", $field = "*") {

		if ($this->handler) {
			$query = sprintf("SELECT COUNT(%s) AS count FROM %s %s", $field, $table, $where);
			$response = mysql_query($query, $this->handler);
			if ($response) {
				$row = mysql_fetch_assoc($response);
				return $row["count"];
			} else {
				return false;
			}
		} else {
			die('データベースハンドラが見つかりません。');
		}
		
	}
	
	function insertid() {
		
		if ($this->handler) {
			return mysql_insert_id($this->handler);
		} else {
			die('データベースハンドラが見つかりません。');
		}
		
	}
	
	function table() {

		if ($this->handler) {
			$query = "SHOW TABLES FROM ".DB_DATABASE;
			$response = mysql_query($query, $this->handler);
			if ($response) {
				while ($row = mysql_fetch_assoc($response)) {
					$array[] = $row["Tables_in_".DB_DATABASE];
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
			return mysql_real_escape_string($string, $this->handler);
		} else {
			die('データベースハンドラが見つかりません。');
		}
	
	}

}
?>