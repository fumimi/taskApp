<?php
/**
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * @link http://fumimi.jp/
 *
 * @package taskapp
 * @subpackage taska
 * @since taska 0.0.1
 */



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$caption?></title>
<link href="<?=$root?>css/default.css" rel="stylesheet" type="text/css" />
<link href="<?=$root?>css/control.css" rel="stylesheet" type="text/css" />
<link href="<?=$root?>css/application.css" rel="stylesheet" type="text/css" />
<link href="<?=$root?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$root?>js/library/jquery.js"></script>
<script type="text/javascript" src="<?=$root?>js/library/ui.core.js"></script>
<script type="text/javascript" src="<?=$root?>js/library/ui.draggable.js"></script>
<script type="text/javascript" src="<?=$root?>js/application.js"></script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Task App - ver. 1.0.2</title>

<!-- Bootstrap Core CSS -->
<link href="<?=$root?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="<?=$root?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?=$root?>dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="<?=$root?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

<!-- calendar style start -->
<link href="<?=$root?>dist/css/calendar.css" rel="stylesheet" type="text/css">

<!-- Custom CSS -->
<link href="<?=$root?>dist/css/drawer.css" rel="stylesheet">

<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->



<?=$javascript?>
</head>
<body<?=$onload?>>


<div id="wrapper">


    <?php include_once("dist/ssi/header.html"); ?>


    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

      <?php include_once("dist/ssi/navbar-header.html"); ?>

      <?php include_once("dist/ssi/navbar-right.html"); ?>

      <?php // include_once("dist/ssi/side-menu.html"); ?>

    </nav>
  </div>
