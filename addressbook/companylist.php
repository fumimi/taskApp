<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/json.php');
if (is_array($hash['list']) && count($hash['list']) > 0) {
?>
<table class="list" cellspacing="0"><tr><th>会社名</th><th>郵便番号</th><th>住所</th><th>電話番号</th><th>部署</th></tr>
<?php
	foreach ($hash['list'] as $row) {
?>
	<tr><td>
		<span class="operator" onclick="Addressbook.set('<?=$row['id']?>', '<?=$row['addressbook_company']?>', '<?=$row['addressbook_companyruby']?>', '<?=$row['addressbook_department']?>', '<?=$row['addressbook_url']?>')">
		<?=$row['addressbook_company']?></span>&nbsp;
	</td>
	<td><?=$row['addressbook_postcode']?>&nbsp;</td>
	<td><?=$row['addressbook_address']?>&nbsp;</td>
	<td><?=$row['addressbook_phone']?>&nbsp;</td>
	<td><?=$row['addressbook_department']?>&nbsp;</td></tr>
<?php
	}
	echo '</table>';
	if ($hash['count'] <= 50) {
		echo '検索結果 '.$hash['count'].' 件';
	} else {
		echo '50件以上のデータが見つかりました。<br />検索条件を絞り込んでください。';
	}
} else {
	echo '検索条件に一致するデータは見つかりませんでした。';
}
?>