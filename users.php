<?php

// ユーザーの一覧

require_once(__DIR__ . '/config/config.php');

// var_dump($_SESSION['me']);

// $app = new MyApp\Controller\Index();

// $app->run();

// $app->me()
// $app->getValues()->users

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php include_once("dist/ssi/meta.html"); ?>

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
                        <h1 class="page-header">Users</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->


                <form action="logout.php" method="post" id="logout">
                  <?= h($app->me()->email); ?> <input type="submit" value="Log Out">
                  <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
                </form>
                <h1>Users <span class="fs12">(<?= count($app->getValues()->users); ?>)</span></h1>
                <ul>
                  <?php foreach ($app->getValues()->users as $user) : ?>
                    <li><?= h($user->email); ?></li>
                  <?php endforeach; ?>
                </ul>



            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include_once("dist/ssi/js.html"); ?>

</body>

</html>
