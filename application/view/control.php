<?php

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
          <a class="navbar-brand" href="<?=$root?>index.php"><?php echo APP_NAME ?> - ver <?php echo SINCE ?></a>
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
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-envelope fa-fw"></i><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu dropdown-messages">
            <li><a href="#">
              <div><strong>John Smith</strong><span class="pull-right text-muted"><em>Yesterday</em></span></div>
              <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div><strong>John Smith</strong><span class="pull-right text-muted"><em>Yesterday</em></span></div>
              <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div><strong>John Smith</strong><span class="pull-right text-muted"><em>Yesterday</em></span></div>
              <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
              </a></li>
            <li class="divider"></li>
            <li><a class="text-center" href="#"><strong>Read All Messages</strong><i class="fa fa-angle-right"></i></a></li>
          </ul>
          <!-- /.dropdown-messages -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-tasks fa-fw"></i><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu dropdown-tasks">
            <li><a href="#">
              <div>
                <p><strong>Project 1</strong><span class="pull-right text-muted">40% Complete</span></p>
                <div class="progress progress-striped active">
                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"><span class="sr-only">40% Complete (success)</span></div>
                </div>
              </div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div>
                <p><strong>Project 2</strong><span class="pull-right text-muted">20% Complete</span></p>
                <div class="progress progress-striped active">
                  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"><span class="sr-only">20% Complete</span></div>
                </div>
              </div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div>
                <p><strong>Project 3</strong><span class="pull-right text-muted">60% Complete</span></p>
                <div class="progress progress-striped active">
                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"><span class="sr-only">60% Complete (warning)</span></div>
                </div>
              </div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div>
                <p><strong>Project 4</strong><span class="pull-right text-muted">80% Complete</span></p>
                <div class="progress progress-striped active">
                  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"><span class="sr-only">80% Complete (danger)</span></div>
                </div>
              </div>
              </a></li>
            <li class="divider"></li>
            <li><a class="text-center" href="#"><strong>See All Tasks</strong><i class="fa fa-angle-right"></i></a></li>
          </ul>
          <!-- /.dropdown-tasks -->
        </li>
        <!-- /.dropdown -->
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-bell fa-fw"></i><i class="fa fa-caret-down"></i></a>
          <ul class="dropdown-menu dropdown-alerts">
            <li><a href="#">
              <div><i class="fa fa-comment fa-fw"></i>New Comment <span class="pull-right text-muted small">4 minutes ago</span></div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div><i class="fa fa-twitter fa-fw"></i>3 New Followers <span class="pull-right text-muted small">12 minutes ago</span></div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div><i class="fa fa-envelope fa-fw"></i>Message Sent <span class="pull-right text-muted small">4 minutes ago</span></div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div><i class="fa fa-tasks fa-fw"></i>New Task <span class="pull-right text-muted small">4 minutes ago</span></div>
              </a></li>
            <li class="divider"></li>
            <li><a href="#">
              <div><i class="fa fa-upload fa-fw"></i>Server Rebooted <span class="pull-right text-muted small">4 minutes ago</span></div>
              </a></li>
            <li class="divider"></li>
            <li><a class="text-center" href="#"><strong>See All Alerts</strong><i class="fa fa-angle-right"></i></a></li>
          </ul>
          <!-- /.dropdown-alerts -->
        </li>
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
                  <li><a href="<?=$root?>todo/"><i class="fa fa-check-square-o fa-fw"></i> Task</a></li>
                  <li><a href="<?=$root?>forum/"><i class="fa fa-comments fa-fw"></i> Comments</a></li>
                  <li><a href="<?=$root?>storage/"><i class="fa fa-file-text-o fa-fw"></i> Storage</a></li>
                  <li><a href="<?=$root?>bookmark/"><i class="fa fa-bookmark fa-fw"></i> Bookmark</a></li>
                  <li><a href="<?=$root?>project/"><i class="fa fa-tasks fa-fw"></i> Project</a></li>
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
