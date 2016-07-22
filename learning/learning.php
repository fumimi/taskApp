<?php

require_once("config.php");
require_once("ModelBase.php");

$ModelBase = new ModelBase();

$sql = "select * from problems";
$result = $ModelBase->query($sql);

class problemList extends ModelBase {
  
}


// $data = array(
//   "problem_number" => "insert_problem_number",
//   "problem_title" => "insert_problem_title",
//   "problem_detail" => "insert_problem_detail"
// );
// $insert = $ModelBase->insert($data);
//
//
// $sql = "DELETE FROM problems where id = :id";
// $result = $ModelBase->delete($sql);
//
//
//
// //insert method-------------------------
// if(isset($_POST["insert"])){
//
//   $insert_problem_number = $_POST["insert_problem_number"];
//   $insert_problem_title = $_POST["insert_problem_title"];
//   $insert_problem_detail = $_POST["insert_problem_detail"];
//   $insert_problem_detail = nl2br($insert_problem_detail);
//
//   if($insert_problem_number == "" || $insert_problem_title == "" || $insert_problem_detail ==""){
//     echo "入力して下さい。";
//   } else {
//     $query = "INSERT INTO problems (problem_number, problem_title, problem_detail) VALUES (:insert_problem_number, :insert_problem_title, :insert_problem_detail)";
//   }
//
//
//   // $query = "INSERT INTO problems (problem_number, problem_title, problem_detail) VALUES (:insert_problem_number, :insert_problem_title, :insert_problem_detail)";
//
//   $stmt = $db->prepare($query);
//   $stmt->bindParam(":insert_problem_number", $insert_problem_number);
//   $stmt->bindParam(":insert_problem_title", $insert_problem_title);
//   $stmt->bindParam(":insert_problem_detail", $insert_problem_detail);
//   $stmt->execute();
//
//
// }
//
//
//
// //delete method-------------------------
// if(isset($_POST["delete"])) {
//
//   $id = $_POST["id"];
//
//   $query = "DELETE FROM problems where id = :id";
//
//   $stmt = $db->prepare($query);
//   $stmt->bindParam(":id", $id);
//   $stmt->execute();
//
// }
//
//
//
//
//
// //edit method------------------------------------------------------------------------------------------------------------------------------
// if(isset($_POST["edit"])) {
//
//   $id = $_POST["id"];
//
//   $stmt = $db->query("SELECT * FROM problems where id = $id");
//   $problems = $stmt->fetch(PDO::FETCH_ASSOC);
//
//   $edit_problem_number = $problems["problem_number"];
//   $edit_problem_title = $problems["problem_title"];
//   $edit_problem_detail = $problems["problem_detail"];
//
// }
//
// //edit_result method-----------------------------------------------------------------------------------------------------------------------
// if(isset($_POST["edit_result"])) {
//
//   $id = $_POST["edit_id"];
//   $insert_problem_number = $_POST["insert_problem_number"];
//   $insert_problem_title = $_POST["insert_problem_title"];
//   $insert_problem_detail = $_POST["insert_problem_detail"];
//   $insert_problem_detail = nl2br($insert_problem_detail);
//
//   $query = "UPDATE problems SET problem_number =:insert_problem_number, problem_title =:insert_problem_title, problem_detail =:insert_problem_detail WHERE  id = $id";
//
//   $stmt = $db->prepare($query);
//   $stmt->bindParam(":insert_problem_number", $insert_problem_number);
//   $stmt->bindParam(":insert_problem_title", $insert_problem_title);
//   $stmt->bindParam(":insert_problem_detail", $insert_problem_detail);
//   $stmt->execute();
//
// }





?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php include_once("dist/ssi/meta.html"); ?>

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
    text-align: left;
  }
  </style>

</head>

<body>

    <div id="wrapper">

      <!-- Navigation -->
      <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <?php include_once("dist/ssi/navbar-header.html"); ?>

        <?php include_once("dist/ssi/navbar-right.html"); ?>

        <?php include_once("dist/ssi/side-menu.html"); ?>

      </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Programmed Learning App</h1>
                    </div>
                    <!-- /.col-lg-12 -->




                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                PHP Problem Input
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" action="learning.php" method="post">

                                          <input type="hidden" name="edit_id" value="<?=$id?>">

                                            <div class="form-group">
                                                <label>問題番号</label>
                                                <input class="form-control" placeholder="Enter text" name="insert_problem_number" value="<?=$edit_problem_number?>">
                                            </div>
                                            <div class="form-group">
                                                <label>タイトル</label>
                                                <input class="form-control" placeholder="Enter text" name="insert_problem_title" value="<?=$edit_problem_title?>">
                                            </div>
                                            <div class="form-group">
                                                <label>詳細</label>
                                                <textarea class="form-control" rows="3" name="insert_problem_detail"><?=$edit_problem_detail?></textarea>
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
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->







                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                PHP Problem List
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                              <form role="form" action="learning.php" method="post">

                                <div class="table-responsive">

                                  <p>
                                      <button type="submit" class="btn btn-default" name="edit">編集</button>
                                      <button type="submit" class="btn btn-default" name="delete">削除</button>
                                      <button type="submit" class="btn btn-primary">正解</button>
                                      <button type="submit" class="btn btn-danger">不正解</button>
                                  </p>

                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>問題番号</th>
                                                <th>タイトル</th>
                                                <th>詳細</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <?php

                                          foreach ($result as $key => $val):
                                            $id = $result[$key]["id"];
                                            $problem_number = $result[$key]["problem_number"];
                                            $problem_title = $result[$key]["problem_title"];
                                            $problem_detail = $result[$key]["problem_detail"];

                                          ?>

                                            <tr>
                                            <td><div class="form-group">
                                            <label class="checkbox-inline"><input type="checkbox" name="id" value="<?=$id?>"></label>
                                            </div></td>
                                            <td><?=$problem_number?></td>
                                            <td><?=$problem_title?></td>
                                            <td><?=$problem_detail?></td>
                                            </tr>

                                          <?php

                                          endforeach;

                                          ?>
                                          <?php $ModelBase->closeDb(); ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                              </form>



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

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>

</body>

</html>
