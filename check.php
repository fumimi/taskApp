<?php

// 現在の言語を設定あるいは取得する
mb_language("Japanese");

// 新しいセッションを開始、あるいは既存のセッションを再開する
session_start();

// エラー出力する場合
ini_set( 'display_errors', 1 );


$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];


//サニタイジング
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$message = htmlspecialchars($message);

//入力されていないときの処理
if($name == ""){
    $nameCheck = "名前が入力されていません";
  } else {
    $nameCheck = $name;
}
if($email == ""){
    $emailCheck = "メールアドレスが入力されていません";
  } else {
    $emailCheck = $email;
}
if($message == ""){
    $messageCheck = "ご意見が入力されていません";
  } else {
    $messageCheck = $message;
}
if($name == "" || $email == "" || $message == ""){
    // $btn = '<input type="button" onclick="history.back()" value="戻る">';
    $btn = "<input type=\"button\" onclick=\"history.back()\" value=\"戻る\">";
  } else {
    // $btn = '<input type="button" onclick="history.back()" value="戻る">'
    // . '<input type="submit" value="OK">';
    $btn = "<input name=\"name\" type=\"hidden\" value=\"" . $name . "\">"
    . "<input name=\"email\" type=\"hidden\" value=\"" . $email . "\">"
    . "<input name=\"message\" type=\"hidden\" value=\"" . $message . "\">"
    . "<input type=\"button\" onclick=\"history.back()\" value=\"戻る\">"
    . "<input type=\"submit\" value=\"OK\">";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <?php include_once("dist/ssi/meta.html"); ?>

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
                        <h1 class="page-header">Confirm</h1>




                        <form method="post" action="thanks.php">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                内容を確認して下さい。
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <!-- <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                            </tr>
                                        </thead> -->
                                        <tbody>
                                            <tr>
                                                <td>名前</td>
                                                <td><?php echo $nameCheck;?></td>
                                            </tr>
                                            <tr>
                                                <td>メールアドレス</td>
                                                <td><?php echo $emailCheck;?></td>
                                            </tr>
                                            <tr>
                                                <td>ご意見</td>
                                                <td><?php echo $messageCheck;?></td>
                                            </tr>
                                            <tr>
                                              <td>&nbsp;</td>
                                              <td><?php echo $btn;?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                            <button type="submit" class="btn btn-primary">Submit Button</button>
                            <button type="reset" class="btn btn-default">Reset Button</button>

                        </div>
                        <!-- /.panel -->
                        </form>


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

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
