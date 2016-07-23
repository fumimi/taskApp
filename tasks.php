<?php

header("Content-Type: text/html; charset=UTF-8");

define('DB_DATABASE', 'tasks');
define('DB_USERNAME', 'taskuser');
define('DB_PASSWORD', '6w7murn7');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);

try {
  // connect
  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
  if ($db == null){ print('接続に失敗しました。'); }else{ print('接続に成功しました。'); }
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}



//insert method-------------------------
if(isset($_POST["insert"])){

  $insertId = $_POST["insertId"];

  $query = "INSERT INTO task (id, price) VALUES (:iItem, :iPrice)";

  $stmt = $db->prepare($query);
  $stmt->bindParam(":iItem", $iItem);
  $stmt->bindParam(":iPrice", $iPrice);
  $stmt->execute();

}



?>
<!DOCTYPE html>
<html lang="ja">

<head>

  <?php include_once("dist/ssi/meta.html"); ?>
  <link>

  <style>
  .block {
    display: block;
  }
  input[type=date] {
    width: 80px;
    margin-right: 10px;
    margin-left: 10px;
    display: inline;
  }
  .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    vertical-align: middle;
  }
  </style>
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
                        <h1 class="page-header">Tasks</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->



                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Taskを入力してください。
                            </div>
                            <div class="panel-body">
                              <form role="form">
                                <div class="row">
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                          <label>タスク名（orメールの件名）</label>
                                          <input class="form-control" name="task">
                                          <!-- <p class="help-block">Example block-level help text here.</p> -->
                                      </div>
                                      <div class="form-group">
                                          <label>クライアント名</label>
                                          <input class="form-control" name="client_name">
                                          <!-- <p class="help-block">Example block-level help text here.</p> -->
                                      </div>
                                      <div class="form-group">
                                          <label>スタッフ名</label>
                                          <input class="form-control" name="staff_name">
                                          <!-- <p class="help-block">Example block-level help text here.</p> -->
                                      </div>
                                      <div class="form-group">
                                          <label class="block">依頼日</label>
                                          <input class="form-control" type="date" name="requested_date">/<input class="form-control" type="date">/<input class="form-control" type="date">
                                          <!-- <p class="help-block">Example block-level help text here.</p> -->
                                      </div>
                                      <div class="form-group">
                                          <label class="block">アップ希望日</label>
                                          <input class="form-control" type="date" name="up_date">/<input class="form-control" type="date">/<input class="form-control" type="date">
                                          <!-- <p class="help-block">Example block-level help text here.</p> -->
                                      </div>
                                      <div class="form-group">
                                          <label class="block">完了日</label>
                                          <input class="form-control" type="date" name="finished_date">/<input class="form-control" type="date">/<input class="form-control" type="date">
                                          <!-- <p class="help-block">Example block-level help text here.</p> -->
                                      </div>
                                      <div class="form-group">
                                          <label>作業ページ数</label>
                                          <input class="form-control" name="pages">
                                          <!-- <p class="help-block">Example block-level help text here.</p> -->
                                      </div>
                                      <div class="form-group">
                                          <label>見積</label>
                                          <input class="form-control" name="estimate">
                                          <!-- <p class="help-block">Example block-level help text here.</p> -->
                                      </div>
                                      <div class="form-group">
                                          <label>進捗</label>
                                          <select class="form-control" name="progress">
                                              <option>未開始</option>
                                              <option>進行中</option>
                                              <option>完了</option>
                                              <option>待機中</option>
                                              <option>遅延</option>
                                          </select>
                                      </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                          <label>内容</label>
                                          <textarea class="form-control" rows="22" name="content"></textarea>
                                      </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                </div>
                                <!-- /.row (nested) -->
                              </form>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Task List
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                              <th>&nbsp;</th>
                                              <th>タスクID</th>
                                              <th>タスク（orメールの件名）</th>
                                              <th>クライアント名</th>
                                              <th>スタッフ名</th>
                                              <th>依頼日</th>
                                              <th>アップ希望日</th>
                                              <th>完了日</th>
                                              <th>作業ページ数</th>
                                              <th>見積</th>
                                              <th>進捗</th>
                                              <th>内容</th>
                                            </tr>
                                        </thead>
                                        <!-- <tbody>


                                          <?php

                                          // $data = $db->query("select * from task");
                                          //
                                          // while($items = $data->fetch()){
                                          //   $id = $items["id"];
                                          //   $task = $items["task"];
                                          //   $client_name = $items["client_name"];
                                          //   $staff_name = $items["staff_name"];
                                          //   $requested_date = $items["requested_date"];
                                          //   $up_date = $items["up_date"];
                                          //   $finished_date = $items["finished_date"];
                                          //   $pages = $items["pages"];
                                          //   $estimate = $items["estimate"];
                                          //   $progress = $items["progress"];
                                          //   $content = $items["content"];
                                          //
                                          //   echo "<tr>
                                          //     <td>
                                          //       <div class=\"form-group\">
                                          //           <label class=\"checkbox-inline\"><input type=\"checkbox\"></label>
                                          //       </div>
                                          //     </td>
                                          //     <td>{$id}</td>
                                          //     <td>{$task}</td>
                                          //     <td>{$client_name}</td>
                                          //     <td>{$staff_name}</td>
                                          //     <td>{$requested_date}</td>
                                          //     <td>{$up_date}</td>
                                          //     <td>{$finished_date}</td>
                                          //     <td>{$pages}</td>
                                          //     <td>{$estimate}</td>
                                          //     <td>{$progress}</td>
                                          //     <td>{$content}</td>
                                          //   </tr>";
                                          //
                                          // }
                                          // echo "</table><input type=\"submit\" name=\"delete\" value=\"削除\"></form>";
                                          //
                                          // // db close
                                          // $db = null;

                                          ?>

                                        </tbody> -->
                                    </table>
                                    <p>
                                      <button type="button" class="btn btn-default"><a href="edit.php">修正</a></button>
                                      <button type="button" class="btn btn-default">完了</button>
                                      <button type="button" class="btn btn-default">削除</button>
                                    </p>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
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
