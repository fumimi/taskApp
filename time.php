<?php

// エラー出力する場合
ini_set( 'display_errors', 1 );


// require 'calendar.php';
//
//
//
// $cal = new \MyApp\Calendar();
//
//
// // ユーザーの一覧
//
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

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Time Management</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->


                <script type="text/javascript">
                function digitalClock() {
                    var now = new Date();
                    document . getElementById( 'digital-clock' ) . innerHTML= now . toLocaleString();
                    window . setTimeout( "digitalClock()", 1000);
                }
                window . onload = digitalClock;
                </script>

                <style type="text/css">
                #digital-clock {
                  font-weight: bold;
                  font-size: 300%;
                  color: #000;
                  background-color: #ccc;
                  text-align: center;
                  width: 500px;
                  padding: 40px;
                  border: 2px #999 solid;
                  margin: 0 auto 30px;
                }
                </style>
                <script>
                function goingToWork(){
                  if(window.confirm("本当に、出勤しますか??")){
                    window.alert("出勤時間を打刻しました。");
                  } else {
                    window.alert('キャンセルされました');
                  }
                }
                function leavingWork(){
                  if(window.confirm("本当に、退勤しますか??")){
                    window.alert("退勤時間を打刻しました。");
                  } else {
                    window.alert('キャンセルされました');
                  }
                }
                var flag = 1;

                </script>

                <div id="digital-clock"></div>

                <p style="width: 150px;margin: 0 auto;">
                    <button type="button" class="btn btn-primary btn-lg" onClick="goingToWork()">出勤</button>
                    <button type="button" class="btn btn-danger btn-lg" onClick="leavingWork()">退勤</button>
                </p>
                <p style="width: 150px;margin: 0 auto;">
                    <button type="button" class="btn btn-primary btn-lg disabled">出勤</button>
                    <button type="button" class="btn btn-danger btn-lg disabled">退勤</button>
                </p>



            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

        <?php include_once("dist/ssi/js.html"); ?>

</body>

</html>
