<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/json.php');
if (is_array($hash['error']) && count($hash['error']) > 0) {
	echo $view->error($hash['error']);
} elseif (is_array($hash['list']) && count($hash['list']) > 0) {
?>
<table class="list" cellspacing="0"><tr><th style="width:100px;">郵便番号</th><th>住所</th></tr>
<?php
	foreach ($hash['list'] as $row) {
?>
	<tr><td><span class="operator" onclick="Postcode.set('<?=$row[0]?>','<?=$row[1]?>','<?=$row[2]?>')"><?=$row[0]?></span>&nbsp;</td>
	<td><span class="operator" onclick="Postcode.set('<?=$row[0]?>','<?=$row[1]?>','<?=$row[2]?>')"><?=$row[1]?></span>&nbsp;</td></tr>
<?php
	}
	echo '</table>';
	if (count($hash['list']) < 50) {
		echo '検索結果 '.count($hash['list']).' 件';
	} else {
		echo '50件以上のデータが見つかりました。<br />検索条件を絞り込んでください。';
	}
} else {
	echo '検索条件に一致するデータは見つかりませんでした。';
}
?>