<?php

phpinfo();

// エラー出力する場合
ini_set( 'display_errors', 1 );

// require 'calendar.php';
// $cal = new \MyApp\Calendar();

// echo __DIR__;

// ユーザーの一覧

// require_once(__DIR__ . '/config/config.php');



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

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->






            <div class="row">
                <div class="col-lg-12">
                          <div class="panel panel-default">
                              <div class="panel-heading">
                                  NEWS
                              </div>
                              <!-- /.panel-heading -->
                              <div class="panel-body">
                                  <div class="table-responsive">
                                      <table class="table table-striped table-bordered table-hover" width="100%">
                                          <!-- <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>First Name</th>
                                              </tr>
                                          </thead> -->
                                          <tbody>
                                            <tr>
                                                <td>2016.02.07</td>
                                                <td style="text-align: left;">ver. 1.0.2をリリースしました。<br>
                                                ・Programmed Learning Appを追加しました。<br>
                                                  任意のプログラミング問題を投稿します。<br>
                                                  投稿は編集・削除ができます。<br>
                                                  問題ができたら「正解」ボタン、できなかったら「不正解」ボタンを押します。<br>
                                                  問題の正解、不正解の数はグラフで確認できます。</td>
                                            </tr>
                                            <tr>
                                                <td>2016.01.31</td>
                                                <td style="text-align: left;">ver. 1.0.1をリリースしました。<br>
                                                ・カテゴリにダッシュボードを追加しました。<br>
                                                ・カテゴリにタスクを追加しました。<br>
                                                ・カテゴリにスケジューラを追加しました。<br>
                                                ・カテゴリにタイムマネージメントを追加しました。<br>
                                                ・カテゴリにコンタクトを追加しました。<br>
                                                ・ログイン機能を追加しました。</td>
                                            </tr>

                                          </tbody>
                                      </table>
                                  </div>
                                  <!-- /.table-responsive -->
                              </div>
                              <!-- /.panel-body -->
                          </div>
                          <!-- /.panel -->
                      </div>
                      <!-- /.col-lg-12 -->
                  </div>





                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->






        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include_once("dist/ssi/js.html"); ?>

</body>

</html>
