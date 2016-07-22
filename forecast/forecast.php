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
                        <h1 class="page-header">weather forecast</h1>
                    </div>
                    <!-- /.col-lg-12 -->

                    <?php

                      $url = "http://weather.livedoor.com/forecast/webservice/json/v1?city=130010";
                      $json = file_get_contents($url, true);
                      $json = json_decode($json, true);

                      // Pubric
                      $title = $json['title'];                                                    // 市区町村
                      $description = $json['description']['text'];                                // 詳細情報
                      $publicTime = $json['publicTime'];                                          // 更新時間

                      // Location
                      $city = $json['location']['city'];                                          // 東京
                      $area = $json['location']['area'];                                          // 関東
                      $prefecture = $json['location']['prefecture'];                              // 東京都
                      $link = $json['link'];                                                      // URL



                      foreach ($json['forecasts'] as $entry) {
                          $dateLabel = $entry['dateLabel'];                                       // 今日･明日･明後日
                          $telop = $entry['telop'];                                               // 天気
                          $date = $entry['date'];                                                 // 日付
                          $min = $entry['temperature']['min'];                                    // 最低気温
                          $max = $entry['temperature']['max'];                                    // 最高気温
                          $mincelsius = $entry['temperature']['min']["celsius"];                  // 摂氏
                          $minfahrenheit = $entry['temperature']['min']["fahrenheit"];            // 華氏
                          $maxcelsius = $entry['temperature']['max']["celsius"];                  // 摂氏
                          $maxfahrenheit = $entry['temperature']['max']["fahrenheit"];            // 華氏
                          $image = $entry['image']["url"];                                        // アイコン

                          // NULL
                          if (!isset($min)) { $mincelsius = "--"; }
                          if (!isset($max)) { $maxcelsius = "--"; }
                          if (!isset($celsius)) { $min = "--"; }
                          if (!isset($fahrenheit)) { $min = "--"; }
                      }

                    ?>
                    <table border="1">

                      <tr>
                        <th>市区町村</th>
                        <td><?=$title?></td>
                      </tr>
                      <tr>
                        <th>詳細情報</th>
                        <td><?=$description?></td>
                      </tr>
                      <tr>
                        <th>更新時間</th>
                        <td><?=$publicTime?></td>
                      </tr>
                      <tr>
                        <th>URL</th>
                        <td><a href="<?=$link?>"><?=$prefecture?> <?=$city?>(<?=$area?>地方)の天気</a></td>
                      </tr>
                      <tr>
                        <th>今日･明日･明後日</th>
                        <td><?=$dateLabel?></td>
                      </tr>
                      <tr>
                        <th>天気</th>
                        <td><?=$telop?></td>
                      </tr>
                      <tr>
                        <th>日付</th>
                        <td><?=$date?></td>
                      </tr>
                      <tr>
                        <th>最低気温</th>
                        <td><?=$min?></td>
                      </tr>
                      <tr>
                        <th>最高気温</th>
                        <td><?=$max?></td>
                      </tr>
                      <tr>
                        <th>摂氏</th>
                        <td><?=$mincelsius?></td>
                      </tr>
                      <tr>
                        <th>華氏</th>
                        <td><?=$minfahrenheit?></td>
                      </tr>
                      <tr>
                        <th>摂氏</th>
                        <td><?=$maxcelsius?></td>
                      </tr>
                      <tr>
                        <th>華氏</th>
                        <td><?=$maxfahrenheit?></td>
                      </tr>
                      <tr>
                        <th>アイコン</th>
                        <td><img src="<?=$image?>"></td>
                      </tr>
                    </table>

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
