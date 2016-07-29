

function Postcode() {}
Postcode.json;

Postcode.feed = function (object, type) {
	
	try {
		if (type == 'address') {
			var string = document.getElementById('address').value;
			if (string.length >= 3) {
				var parameter = {address: string};
			} else {
				alert('住所は3文字以上入力してください。');
			}
		} else {
			var string = document.getElementById('postcode').value.replace(/\-/g,'');
			if (string.match(/^[0-9]+$/) && string.length >= 3) {
				var parameter = {postcode: string};
			} else {
				alert('郵便番号は3桁以上の数字で入力してください。');
			}
		}
		if (parameter) {
			App.loader('../addressbook/postcode.php', parameter, 'codelist');
		}
	} catch(e) {
		alert(e.message);
	}
	
}

Postcode.set = function (code, address, addressruby) {
	
	try {
		if (code && address && addressruby) {
			document.getElementById('postcode').value = code.substring(0,3) + '-' + code.substring(3,7);
			document.getElementById('address').value = address;
			document.getElementById('addressruby').value = addressruby;
		}
		$('#codelist').remove();
	} catch(e) {
		alert(e.message);
	}
	
}