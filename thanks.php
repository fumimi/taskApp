<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>サンキュー画面</title>
</head>
<body>
<?php

mb_language("Japanese");
mb_internal_encoding("UTF-8");

// エラー出力する場合
ini_set( "display_errors", 1 );


$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

//サニタイジング
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$message = htmlspecialchars($message);


print $name . "様<br>";
print"ご意見ありがとうございました。<br>";
print"頂いたご意見『" . $message . "』<br>";
print $email . "にメールを送りましたのでご確認ください。";


$mail_sub = "アンケート受け付けました。";
$mail_body = $name . "様へ\nアンケートご協力ありがとうございました。";
// $mail_body = html_entity_decode($mail_body, ENT_QOTES, "UTF-8");
$mail_head = "From: xxx@xxx.co.jp";

mb_send_mail($email, $mail_sub, $mail_body, $mail_head);

?>
</body>
</html>
