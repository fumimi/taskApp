<?php

// エラー出力する場合
ini_set('display_errors', 1);

// $url = dirname(__FILE__).'/../app/View/Core.php';
// echo $url;

// require('/home/fumimi-jp/www/taskapp/taskapp/app/config.php');
// echo 'DIR_PATH';

require('/home/fumimi-jp/www/taskapp/taskapp/app/View/Core.php');
use App\View as View;

$view = new App\View\View();
$view->setValue('hoge', 'テスト');
echo $view->render('/home/fumimi-jp/www/taskapp/taskapp/app/View/Template/index.php');
