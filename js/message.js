/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

function Message() {}

Message.move = function (object) {
	
	try {
		if (object == 'trash') {
			var integer = '-1';
		} else {
			var integer = object.options[object.selectedIndex].value;
		}
		var element = document.forms['checkedform'].elements;
		if (element['checkedid[]'] && element['checkedid[]'].type == 'hidden' && element['checkedid[]'].value > 0) {
			var checked = true;
		} else {
			for (var i = 0; i < element.length; i++) {
				if (element[i].type == 'checkbox' && element[i].checked == true) {
					var checked = true;
				}
			}
		}
		if (!checked) {
			alert('メッセージを選択してください。');
		} else if (integer.length > 0) {
			element['folder'].value = integer;
			document.forms['checkedform'].submit();
		}
		object.selectedIndex = '';
	} catch(e) {
		alert('エラーが発生しました。\n' + e.message);
	}
	
}

Message.empty = function () {
	
	try {
		var object = document.forms['checkedform'];
		object.innerHTML += '<input type="hidden" name="empty" value="empty" />';
		object.submit();
	} catch(e) {
		alert(e.message);
	}
	
}