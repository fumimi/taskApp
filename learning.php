<?php

require_once("config.php");
// require_once("ModelBase.php");

class ModelBase {

    protected $db;
    public $tableName = "problems";

    // It is automatically connected to when generating an instance(インスタンスの生成時に自動的に接続される)
    public function __construct(){
        $this->initDb();
    }

    //DB connect
    public function initDb(){
      try {
        // connect
        $this->db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        // if ($this->db == null){ print('接続に失敗しました。<br>'); }else{ print('接続に成功しました。<br>'); }
      } catch (PDOException $e) {
        // errer
        $e->getMessage();
        exit;
      }
    }

    // クエリ結果を取得
    public function query($sql, array $params = array()){
      $stmt = $this->db->prepare($sql);
      if ($params != null) {
          foreach ($params as $key => $val) {
              $stmt->bindValue(':' . $key, $val);
          }
      }
      $stmt->execute();
      $rows = $stmt->fetchAll();
      return $rows;
    }


    // INSERTを実行
    public function insert($data){
        $fields = array();
        $values = array();
        foreach ($data as $key => $val) {
            $fields[] = $key;
            $values[] = ':' . $val;
        }
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->tableName,
            implode(', ', $fields),
            implode(', ', $values)
        );
        $stmt = $this->db->prepare($sql);
        foreach ($data as $key => $val) {
            $stmt->bindValue(':' . $val, $val);
        }
        $res  = $stmt->execute();
        return $res;
    }

    // DELETEを実行
    public function delete($where, $params = null){
        $sql = sprintf("DELETE FROM %s", $this->tableName);
        if ($where != "") {
            $sql .= " WHERE " . $where;
        }
        $stmt = $this->db->prepare($sql);
        if ($params != null) {
            foreach ($params as $key => $val) {
                $stmt->bindParam(':' . $key, $val);
            }
        }
        $res = $stmt->execute();
        return $res;
    }

    // UPDATEを実行
    public function update($data, $where, array $params = array()){
      $fields = array();
      $values = array();
      foreach ($data as $key => $val) {
          $fields[] = $key;
          $values[] = ':' . $val;
      }
      $sql = sprintf(
          "UPDATE %s SET (%s)",
          $this->tableName,
          implode(', ', $fields)
      );
      if ($where != "") {
          $sql .= " WHERE " . $where;
      }

      print_r($sql);

      $stmt = $this->db->prepare($sql);
      if ($params != null) {
          foreach ($params as $key => $val) {
              $stmt->bindParam(':' . $key, $val);
          }
      }

      $stmt = $this->db->prepare($sql);
      foreach ($data as $key => $val) {
          $stmt->bindValue(':' . $val, $val);
      }

      $res  = $stmt->execute();
      return $res;

    }

    // DB close
    public function closeDb(){
      $db = null;
    }

}


// class Fetch extends ModelBase {
//
//     protected $db;
//     public $tableName = "problems";
//
//     // クエリ結果を取得
//     public function query($sql, array $params = array()){
//       $stmt = $this->db->prepare($sql);
//       if ($params != null) {
//           foreach ($params as $key => $val) {
//               $stmt->bindValue(':' . $key, $val);
//           }
//       }
//       $stmt->execute();
//       $rows = $stmt->fetch();
//       return $rows;
//     }
// }




// $ModelBase = new ModelBase();
// $Fetch = new Fetch();
//
//
// // 問題の一覧を作成するクラスを作成する
// $sql = "select * from problems";
// $result = $ModelBase->query($sql);
//
//
// //insert method-------------------------
// // 問題を挿入するクラス作成する
// if(isset($_POST["insert"])){
//
//   $insert_problem_number = $_POST["insert_problem_number"];
//   $insert_problem_title = $_POST["insert_problem_title"];
//   $insert_problem_detail = $_POST["insert_problem_detail"];
//   $insert_problem_detail = nl2br($insert_problem_detail);
//
//   $data = array(
//     "problem_number" => $insert_problem_number,
//     "problem_title" => $insert_problem_title,
//     "problem_detail" => $insert_problem_detail
//   );
//
//   $ModelBase->insert($data);
//   $result = $ModelBase->query($sql);
//
//   if($insert_problem_number == "" || $insert_problem_title == "" || $insert_problem_detail ==""){ echo "入力して下さい。"; }
//
// }
//
// //delete method-------------------------
// // 問題を削除するクラスを作成する
// if(isset($_POST["delete"])) {
//
//   $id = $_POST["id"];
//
//   $where = "id = :id";
//   $params = array("id" => $id);
//
//   $ModelBase->delete($where, $params);
//   $result = $ModelBase->query($sql);
//
// }
//
//
//
// //edit method------------------------------------------------------------------------------------------------------------------------------
// if(isset($_POST["edit"])) {
//
//   $id = $_POST["id"];
//
//   // $data = array(
//   //   "problem_number" => $insert_problem_number,
//   //   "problem_title" => $insert_problem_title,
//   //   "problem_detail" => $insert_problem_detail
//   // );
//
//   $sql = "SELECT * FROM problems where id = " . $id;
//   print_r($sql);
//
//   // $result = $Fetch->query($sql);
//   $result = $ModelBase->query($sql);
//
//   print_r($result);
//
//   $result = $ModelBase->query($sql);
//
//   // print_r($result);
//
//
//   // try {
//   //   // connect
//   //   $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
//   // } catch (PDOException $e) {
//   //   echo $e->getMessage();
//   //   exit;
//   // }
//   // $stmt = $db->query("SELECT * FROM problems where id = $id");
//   // $problems = $stmt->fetch(PDO::FETCH_ASSOC);
//   //
//   // print_r($problems);
//   //
//   // Array (
//   //   [id] => 7
//   //   [problem_number] => 003
//   //   [problem_title] => ccc
//   //   [problem_detail] => ccc
//   //   [created_at] => 2016-02-12 10:49:32
//   //   [updated_at] => 2016-02-12 10:49:32
//   // )
//
//
//
//
//   // $edit_problem_number = $problems["problem_number"];
//   // $edit_problem_title = $problems["problem_title"];
//   // $edit_problem_detail = $problems["problem_detail"];
//
// }
//
// $edit_problem_number = NULL;
// $edit_problem_title = NULL;
// $edit_problem_detail = NULL;
//
//
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

<body class="drawer drawer--right">

    <div id="wrapper">

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


                                            <!-- <div class="form-group">
                                                <label>問題番号</label>
                                                <input class="form-control" placeholder="Enter text" name="insert_problem_number">
                                            </div>
                                            <div class="form-group">
                                                <label>タイトル</label>
                                                <input class="form-control" placeholder="Enter text" name="insert_problem_title">
                                            </div>
                                            <div class="form-group">
                                                <label>詳細</label>
                                                <textarea class="form-control" rows="3" name="insert_problem_detail"></textarea>
                                            </div> -->


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
                                      <button type="submit" class="btn btn-primary" name="correct">正解</button>
                                      <button type="submit" class="btn btn-danger" name="incorrect">不正解</button>
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

        <?php include_once("dist/ssi/js.html"); ?>

</body>

</html>
