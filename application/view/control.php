<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
// if ($_SESSION['realname']) {
// 	$realname = $this->escape($_SESSION['realname']).'さん';
// }
// if ($this->authorize('administrator', 'manager')) {
// 	$administration = '<a'.$current['administration'].' href="'.$root.'administration.php">管理画面</a>';
// }
?>
<!-- <div class="header">
	<div class="headertitle">
		<a href="<?=$root?>index.php"><img src="<?=$root?>images/title.gif" /></a>
	</div>
	<div class="headerright">
		<a href="<?=$root?>index.php"><?=$realname?></a><?=$administration?>
		<a href="<?=$root?>logout.php">ログアウト</a>
	</div>
	<div class="control">
		<table cellspacing="0"><tr>
			<td<?=$current['top']?>><a href="<?=$root?>index.php">トップ</a></td>
			<td<?=$current['schedule']?>><a href="<?=$root?>schedule/">スケジュール</a></td>
			<td<?=$current['message']?>><a href="<?=$root?>message/">メッセージ</a></td>
			<td<?=$current['todo']?>><a href="<?=$root?>todo/">ToDo</a></td>
			<td<?=$current['forum']?>><a href="<?=$root?>forum/">フォーラム</a></td>
			<td<?=$current['storage']?>><a href="<?=$root?>storage/">ファイル</a></td>
			<td<?=$current['bookmark']?>><a href="<?=$root?>bookmark/">ブックマーク</a></td>
			<td<?=$current['project']?>><a href="<?=$root?>project/">プロジェクト</a></td>
			<td<?=$current['addressbook']?>><a href="<?=$root?>addressbook/">アドレス帳</a></td>
			<td<?=$current['member']?>><a href="<?=$root?>member/">メンバー</a></td>
			<td<?=$current['timecard']?>><a href="<?=$root?>timecard/">タイムカード</a></td>
		</tr></table>
	</div>
</div>
<div class="container"> -->




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
          <a class="navbar-brand" href="<?=$root?>index.php">Task App - ver. 0.0.3</a>
      </div>
      <!-- /.navbar-header -->

      <?php // include_once("dist/ssi/navbar-right.html"); ?>
      <?php

      // if ($_SESSION['realname']) {
      // 	$realname = $this->escape($_SESSION['realname']).'さん';
      // }
      // if ($this->authorize('administrator', 'manager')) {
      // 	$administration = '<a'.$current['administration'].' href="'.$root.'administration.php">管理画面</a>';
      // }

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
                  <li><a href="<?=$root?>index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                  <li><a href="<?=$root?>schedule/"><i class="fa fa-calendar fa-fw"></i> Schedule</a></li>
                  <li><a href="<?=$root?>message/"><i class="fa fa-envelope-o fa-fw"></i> Message</a></li>
                  <li><a href="<?=$root?>todo/"><i class="fa fa-check-square-o fa-fw"></i> ToDo</a></li>
                  <li><a href="<?=$root?>forum/"><i class="fa fa-comments fa-fw"></i> Comments</a></li>
                  <li><a href="<?=$root?>storage/"><i class="fa fa-file-text-o fa-fw"></i> Storage</a></li>
                  <li><a href="<?=$root?>bookmark/"><i class="fa fa-bookmark fa-fw"></i> Bookmark</a></li>
                  <li><a href="<?=$root?>project/"><i class="fa fa-inbox fa-fw"></i> Project</a></li>
                  <li><a href="<?=$root?>addressbook/"><i class="fa fa-home fa-fw"></i> Addressbook</a></li>
                  <li><a href="<?=$root?>member/"><i class="fa fa-users fa-fw"></i> Member</a></li>
                  <li><a href="<?=$root?>timecard/"><i class="glyphicon glyphicon-time"></i> Timecard</a></li>



              </ul>
          </div>
          <!-- /.sidebar-collapse -->
      </div>
      <!-- /.navbar-static-side -->


      <!-- 左ナビ end -->


    </nav>

    <div id="page-wrapper">
