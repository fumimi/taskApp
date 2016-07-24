<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$caption?></title>
<!-- <link href="<?=$root?>css/default.css" rel="stylesheet" type="text/css" /> -->
<link href="<?=$root?>css/control.css" rel="stylesheet" type="text/css" />
<link href="<?=$root?>css/application.css" rel="stylesheet" type="text/css" />
<link href="<?=$root?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$root?>js/library/jquery.js"></script>
<script type="text/javascript" src="<?=$root?>js/library/ui.core.js"></script>
<script type="text/javascript" src="<?=$root?>js/library/ui.draggable.js"></script>
<script type="text/javascript" src="<?=$root?>js/application.js"></script>
<?=$javascript?>


<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap Core CSS -->
<link href="<?=$root?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- MetisMenu CSS -->
<link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="dist/css/sb-admin-2.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->


<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


</head>
<body<?=$onload?>>


<div id="wrapper">

    <?php // include_once("dist/ssi/header.html"); ?>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

      <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=$root?>index.php">Task App - ver. 1.0.2</a>
      </div>
      <!-- /.navbar-header -->

      <?php // include_once("dist/ssi/navbar-right.html"); ?>
      <?php

      if ($_SESSION['realname']) {
      	$realname = $this->escape($_SESSION['realname']).'さん';
      }
      if ($this->authorize('administrator', 'manager')) {
      	$administration = '<a'.$current['administration'].' href="'.$root.'administration.php">管理画面</a>';
      }

      ?>


      <ul class="nav navbar-top-links navbar-right">
          <!-- /.dropdown -->
          <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
              </a>
              <ul class="dropdown-menu dropdown-user">
                  <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    <a href="<?=$root?>index.php"><?=$realname?></a>

                  </li>
                  <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    <?=$administration?>

                  </li>
                  <li class="divider"></li>
                  <li><a href="<?=$root?>logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                  </li>
              </ul>
              <!-- /.dropdown-user -->
          </li>
          <!-- /.dropdown -->
      </ul>
      <!-- /.navbar-top-links -->





      <!-- 左ナビ start -->
      <div class="navbar-default sidebar" role="navigation">
          <div class="sidebar-nav navbar-collapse">
              <ul class="nav" id="side-menu">
                  <li class="sidebar-search">
                      <div class="input-group custom-search-form">
                          <input type="text" class="form-control" placeholder="Search...">
                          <span class="input-group-btn">
                          <button class="btn btn-default" type="button">
                              <i class="fa fa-search"></i>
                          </button>
                      </span>
                      </div>
                      <!-- /input-group -->
                  </li>
                  <li><a href="<?=$root?>index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                  <li><a href="<?=$root?>schedule/"><i class="fa fa-calendar fa-fw"></i> スケジュール</a></li>
                  <li><a href="<?=$root?>message/"><i class="fa fa-envelope-o fa-fw"></i> メッセージ</a></li>
                  <li><a href="<?=$root?>todo/"><i class="fa fa-check-square-o fa-fw"></i> ToDo</a></li>
                  <li><a href="<?=$root?>forum/"><i class="fa fa-dashboard fa-fw"></i> フォーラム</a></li>
                  <li><a href="<?=$root?>storage/"><i class="fa fa-file-text-o fa-fw"></i> ファイル</a></li>
                  <li><a href="<?=$root?>bookmark/"><i class="fa fa-bookmark fa-fw"></i> ブックマーク</a></li>
                  <li><a href="<?=$root?>project/"><i class="fa fa-inbox fa-fw"></i> プロジェクト</a></li>
                  <li><a href="<?=$root?>addressbook/"><i class="fa fa-home fa-fw"></i> アドレス帳</a></li>
                  <li><a href="<?=$root?>member/"><i class="fa fa-users fa-fw"></i> メンバー</a></li>
                  <li><a href="<?=$root?>timecard/"><i class="glyphicon glyphicon-time"></i> タイムカード</a></li>



              </ul>
          </div>
          <!-- /.sidebar-collapse -->
      </div>
      <!-- /.navbar-static-side -->


      <!-- 左ナビ end -->


    </nav>

    <div id="page-wrapper">
