/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

function Todo() {}

Todo.noterm = function (object) {
	
	var element = object.parentNode.getElementsByTagName('select');
	for (var i = 0; i < element.length; i++) {
		element[i].disabled = object.checked;
	}
	
}