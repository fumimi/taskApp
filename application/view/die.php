<?php

$view = new ApplicationView;
$view->heading('エラー');
?>
<h1>エラー</h1>
<ul class="operate">
	<li><span class="operator" onclick="history.back()">戻る</span></li>
</ul>
<div class="die">
<?php
echo $message;
?>
</div>
<?php
$view->footing();
?>