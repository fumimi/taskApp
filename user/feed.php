<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/json.php');
if ($_REQUEST['type'] == 1) {
	$attribute = ' onchange="App.permitlist(this, 1)"';
	$option = $hash['group'];
} else {
	$attribute = ' onchange="App.permitlist(this)"';
	$option = array('グループ') + $hash['group'];
}
?>
<form class="layerlist" name="userlist" onsubmit="return false">
	<div class="layerlistcaption">
		<?=$helper->selector('group', $option, $_REQUEST['group'], $attribute)?>&nbsp;
		<span class="operator" onclick="App.checkall(null, 'userlist')">すべて選択</span>
	</div>
	<ul>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
		<li><input type="checkbox" name="<?=$row['userid']?>" value="<?=$row['realname']?>" />
		<span class="operator" onclick="App.permit(this)"><?=$row['realname']?></span></li>
<?php
	}
} elseif ($_REQUEST['type'] != 1 && $_REQUEST['group'] <= 0 && is_array($hash['group']) && count($hash['group']) > 0) {
	foreach ($hash['group'] as $key => $value) {
?>
		<li><input type="checkbox" name="group:<?=$key?>" value="<?=$value?>" />
		<span class="operator" onclick="App.permit(this)"><?=$value?></span></li>
<?php
	}
} else {
	echo '<li>ユーザー情報はありません。</li>';
}
?>
	</ul>
	<div class="layerlistsubmit"><input type="button" value="　選択　" onclick="App.permit()" /></div>
</form>