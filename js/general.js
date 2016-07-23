/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

function General() {}

General.redirect = function (object, year, month, day) {
	
	location.href = 'schedule/groupweek.php?year=' + year + '&month=' + month + '&day=' + day + '&group=' + object.options[object.selectedIndex].value;

}