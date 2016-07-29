<?php

require(dirname(__FILE__).'/controller.php');

$controller = new Controller;
$hash = $controller->dispatch();
// $view = new ApplicationView($hash);
// $helper = new Helper;

?>
