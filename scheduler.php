<?php

// エラー出力する場合
ini_set( 'display_errors', 1 );

require 'Calendar.php';

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$cal = new \MyApp\Calendar();

// ユーザーの一覧

// require_once(__DIR__ . 'config/config.php');

// $app = new MyApp\Controller\Index();

// $app->run();

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php include_once("dist/ssi/meta.html"); ?>

</head>

<body class="drawer drawer--right">

    <div id="wrapper">

      <?php include_once("dist/ssi/header.html"); ?>

      <!-- Navigation -->
      <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <?php include_once("dist/ssi/navbar-header.html"); ?>

        <?php include_once("dist/ssi/navbar-right.html"); ?>

        <?php // include_once("dist/ssi/side-menu.html"); ?>

      </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Scheduler</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                      <table width="100%">
                        <thead>
                          <tr>
                            <th><a href="/taskapp/scheduler.php?t=<?php echo h($cal->prev); ?>">&laquo;</a></th>
                            <th colspan="5"><?php echo h($cal->yearMonth); ?></th>
                            <th><a href="/taskapp/scheduler.php?t=<?php echo h($cal->next); ?>">&raquo;</a></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td width="14%">Sun</td>
                            <td width="14%">Mon</td>
                            <td width="14%">Tue</td>
                            <td width="14%">Wed</td>
                            <td width="14%">Thu</td>
                            <td width="14%">Fri</td>
                            <td width="14%">Sat</td>
                          </tr>
                          <?php $cal->show(); ?>
                        </tbody>
                        <tfoot>
                          <tr>
                            <th colspan="7"><a href="/taskapp/scheduler.php">Today</a></th>
                          </tr>
                        </tfoot>
                      </table>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->



            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include_once("dist/ssi/js.html"); ?>

</body>

</html>
