<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Controller {
	
	function dispatch() {
		
		$this->requiring();
		$authority = new Authority;
		$authority->check();
		return $this->execute();

	}

	function json() {
		
		$this->requiring();
		$authority = new Authority;
		$authorized = $authority->authorize();
		if ($authorized !== true) {
			die('認証に失敗しました。ログインし直してください。');
		} else {
			return $this->execute();
		}

	}
	
	function execute() {
		
		if (!file_exists('application')) {
			$directory = basename(dirname($_SERVER['SCRIPT_NAME']));
		} else {
			$directory = 'general';
		}
		$modelfile = DIR_MODEL.$directory.'.php';
		$class = ucfirst($directory);
		$method = str_replace('.php', '', basename($_SERVER['SCRIPT_NAME']));
		$hash = array();
		if (file_exists($modelfile)) {
			require_once($modelfile);
			if (class_exists($class)) {
				$model = new $class;
				if (method_exists($model, $method)) {
					$model->connect();
					$hash = $model->$method();
					$hash = $model->sanitize($hash);
					$model->close();
					if (isset($model->error) && count($model->error) > 0) {
						$hash['error'] = $model->error;
					}
				}
			}
		}
		return $hash;

	}

	function requiring() {
	
		mb_internal_encoding('UTF-8');
		require_once(dirname(__FILE__).'/config.php');
		if (DB_STORAGE == 'mysql') {
			require_once(DIR_LIBRARY.'connection'.DB_STORAGE.'.php');
		} else {
			require_once(DIR_LIBRARY.'connection.php');
		}
		require_once(DIR_LIBRARY.'validation.php');
		require_once(DIR_LIBRARY.'helper.php');
		require_once(DIR_LIBRARY.'pagination.php');
		require_once(DIR_LIBRARY.'authority.php');
		require_once(DIR_LIBRARY.'filing.php');
		require_once(DIR_LIBRARY.'postcode.php');
		require_once(DIR_MODEL.'model.php');
		require_once(DIR_MODEL.'applicationmodel.php');
		require_once(DIR_MODEL.'config.php');
		require_once(DIR_VIEW.'view.php');
		require_once(DIR_VIEW.'applicationview.php');
		require_once(DIR_VIEW.'calendar.php');
		require_once(DIR_VIEW.'explanation.php');
		if (get_magic_quotes_gpc()) {
			if (is_array($_POST)) {
				$_POST = $this->strip($_POST);
			}
			if (is_array($_GET)) {
				$_GET = $this->strip($_GET);
			}
		}

	}

	function strip($data) {
	
		if (get_magic_quotes_gpc()) {
			if (is_array($data)) {
				return array_map(array($this, 'strip'), $data);
			} else {
				return stripslashes($data);
			}
		}
		
	}

}

?>