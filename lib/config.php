<?php

define("DSN", "mysql:dbhost=localhost;dbname=sns_php");
define("DB_USERNAME", "snsuser");
define("DB_PASSWORD", "6w7murn7");

define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

require_once('/var/www/html/task.fumimi.jp/lib/functions.php');
// require_once(__DIR__ . '/lib/functions.php');

require_once(__DIR__ . 'autoload.php');

session_start();
