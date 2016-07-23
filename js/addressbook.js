/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

function Addressbook() {}

Addressbook.companylist = function (object) {
	
	try {
		var string = document.forms['addressbook'].elements['addressbook_company'].value;
		if (string && string.length > 0) {
			App.loader('companylist.php', {search: string}, 'companylist');
		} else {
			alert('検索する会社名を入力してください。');
		}
	} catch(e) {
		alert(e.message);
	}
	
}

Addressbook.set = function (id, company, companyruby, department, url) {
	
	try {
		var element = document.forms['addressbook'].elements;
		element['addressbook_company'].value = company;
		element['addressbook_companyruby'].value = companyruby;
		element['addressbook_department'].value = department;
		element['addressbook_url'].value = url;
		document.getElementById('belong').innerHTML = '<input type="checkbox" name="addressbook_parent" id="addressbook_parent" value="' + id + '" checked="checked" /><label for="addressbook_parent">リンク</label>';
		$('#companylist').remove();
	} catch(e) {
		alert(e.message);
	}
	
}