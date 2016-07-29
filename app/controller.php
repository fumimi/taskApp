<?php

class Controller {

	function dispatch() {

		$this->requiring();

	}

	function requiring()
	{

		mb_internal_encoding('UTF-8');
		require_once(dirname(__FILE__) . '/config.php');

		// require_once(dirname(__FILE__) . '/config.php');
		// if (DB_STORAGE == 'mysql') {
		// 	require_once(DIR_LIBRARY . 'connection' . DB_STORAGE . '.php');
		// } else {
		// 	require_once(DIR_LIBRARY . 'connection.php');
		// }
		// require_once(DIR_LIBRARY . 'validation.php');
		// require_once(DIR_LIBRARY . 'helper.php');
		// require_once(DIR_LIBRARY . 'pagination.php');
		// require_once(DIR_LIBRARY . 'authority.php');
		// require_once(DIR_LIBRARY . 'filing.php');
		// require_once(DIR_LIBRARY . 'postcode.php');
		// require_once(DIR_MODEL . 'model.php');
		// require_once(DIR_MODEL . 'applicationmodel.php');
		// require_once(DIR_MODEL . 'config.php');
		// require_once(DIR_VIEW . 'view.php');
		// require_once(DIR_VIEW . 'applicationview.php');
		// require_once(DIR_VIEW . 'calendar.php');
		// require_once(DIR_VIEW . 'explanation.php');
		// if (get_magic_quotes_gpc()) {
		// 	if (is_array($_POST)) {
		// 		$_POST = $this->strip($_POST);
		// 	}
		// 	if (is_array($_GET)) {
		// 		$_GET = $this->strip($_GET);
		// 	}
		// }

	}

}

?>
