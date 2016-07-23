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

//insert
if(isset($_POST["insert"])){

  $task_name = $_POST["task_name"];
    if($task_name == null){
      echo "入力して下さい。";
    } else {
      $query = "INSERT INTO problems (problem_number, problem_title, problem_detail) VALUES (:insert_problem_number, :insert_problem_title, :insert_problem_detail)";
    }

  $query = "INSERT INTO task (id, task_name) VALUES (:id, :task_name)";

  $stmt = $db->prepare($query);
  $stmt->bindParam(":id", $id);
  $stmt->bindParam(":task_name", $task_name);
  $stmt->execute();

}

?>
<!DOCTYPE html>
<html lang="ja">

<head>

  <?php include_once("dist/ssi/meta.html"); ?>
  <link href="/taskapp/dist/css/task.css" rel="stylesheet">

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
                              <div class="col-lg-12">
                                  <form role="form" action="tasks.php" method="post">
                                    <!-- <input type="hidden" name="edit_id" value="<?=$id?>"> -->
                                      <div class="form-group">
                                          <label>タスク</label>
                                          <input class="form-control" name="task_name">
                                      </div>
                                      <p><?php
                                      if(isset($_POST["edit"])) {
                                        echo "<button type=\"submit\" class=\"btn btn-primary btn-lg btn-block\" name=\"edit_result\">編集</button>";
                                      } else {
                                        echo "<button type=\"submit\" class=\"btn btn-primary btn-lg btn-block\" name=\"insert\">登録</button>";
                                      }
                                      ?></p>
                                  </form>
                              </div>
                              <!-- /.col-lg-12 (nested) -->
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
                                              <th>タスク</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <?php

                                          $data = $db->query("select * from task");

                                          while($items = $data->fetch()){
                                            $id = $items["id"];
                                            $task_name = $items["task_name"];

                                            echo "<tr>
                                              <td>
                                                <div class=\"form-group\">
                                                    <label class=\"checkbox-inline\"><input type=\"checkbox\"></label>
                                                </div>
                                              </td>
                                              <td>{$id}</td>
                                              <td>{$task_name}</td>
                                            </tr>";

                                          }

                                          // db close
                                          $db = null;

                                          ?>

                                        </tbody>
                                    </table>
                                    <p>
                                      <button type="button" class="btn btn-default">修正</button>
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
