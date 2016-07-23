<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Config extends ApplicationModel {
	
	function Config($handler = null) {
		
		$this->table = DB_PREFIX.'config';
		$this->schema = array(
		'config_type'=>array(),
		'config_key'=>array(),
		'config_value'=>array());
		if ($handler && !$this->handler) {
			$this->handler = $handler;
		}
		
	}
	
	function edit($type) {
		
		$data = $this->configure($type);
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_array($_POST[$type]) && count($_POST[$type]) > 0) {
			foreach ($_POST[$type] as $key => $value) {
				if (preg_match('/^[a-zA-Z0-9]+$/', $key) && preg_match('/^[a-zA-Z0-9]*$/', $value)) {
					if (is_array($data) && array_key_exists($key, $data)) {
						$query = sprintf("UPDATE %s SET config_value='%s', editor='%s', updated='%s' WHERE (config_key = '%s') AND (config_type = '%s')", $this->table, $this->quote($value), $this->quote($_SESSION['userid']), date('Y-m-d H:i:s'), $this->quote($key), $this->quote($type));
						$this->response = $this->query($query);
					} else {
						$this->post['config_type'] = $type;
						$this->post['config_key'] = $key;
						$this->post['config_value'] = $value;
						$this->insertPost();
					}
					$data[$key] = $value;
				}
			}
			if ($this->response) {
				$this->error[] = '設定を保存しました。';
			}
		}
		return $data;
	
	}
	
	function configure($type) {
		
		$query = sprintf("SELECT %s FROM %sconfig WHERE (config_type = '%s')", implode(',', $this->schematize()), DB_PREFIX, $this->quote($type));
		$data = $this->fetchAll($query);
		$result = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$result[$row['config_key']] = $row['config_value'];
			}
		}
		return $result;
	
	}

}

?>