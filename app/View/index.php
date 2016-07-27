<?php

// エラー出力する場合
ini_set('display_errors', 1);

require(dirname(__FILE__).'/view.php');
use App\View as View;

$view = new View();
$view->setValue('hoge', 'テスト');
echo $view->render('Template.php');



// require_once 'lib1.php';
// $foo = new Foo\Bar\Baz\Lib1\Foo();
// $foo2 = new Foo\Bar\Baz\Lib1\Foo2();
// $foo3 = new Foo\Bar\Baz\Lib1\Foo3();
