/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

function App() {}

App.loader = function (url, parameter, id) {
	
	if (!id) {
		id = 'layer';
	}
	if (App.layercaption) {
		caption = App.layercaption;
	} else {
		caption = '検索結果';
	}
	var string = '<div class="layer"><div class="handle"><div class="layercaption">' + caption + '</div>';
	string += '<div class="layerclose"></div><div class="clearer"></div></div>';
	string += '<div class="layercontent"><img src="../images/indicator.gif" style="vertical-align:middle;" />&nbsp;';
	string += 'データを読み込んでいます。しばらくお待ちください。</div></div>';
	if (document.getElementById(id)) {
		var element = $('#' + id);
		element.html(string);
	} else {
		var element = $('<div id="' + id + '" class="layerwrapper">' + string + '</div>');
		var top  = Math.floor((document.documentElement.clientHeight - 300) / 2 + document.documentElement.scrollTop);
		var left = Math.floor((document.documentElement.clientWidth - 500) / 2 + document.documentElement.scrollLeft);
		element.appendTo(document.body);
		element.css({'top': top, 'left': left, 'visibility': 'visible'});
	}
	element.draggable({handle: 'div.handle'});
	$('div.layerclose', element).click(function(){
		element.remove();
	});
	var object = $('div.layercontent', element);
	object.ajaxError(function(){
		object.html('<div class="error">データファイルへのアクセスに失敗しました。</div>');
	});
	object.load(url, parameter);
	
}

App.limit = function (sortby, desc, parameter) {
	
	try {
		var array = new Array();
		if (sortby) {
			array.push('sort=' + sortby);
		}
		if (desc) {
			array.push('desc=' + desc);
		}
		var object = document.getElementById('limit');
		if (object) {
			array.push('limit=' + object.options[object.selectedIndex].value);
		}
		var object = document.getElementById('search');
		if (object && object.value.length > 0) {
			array.push('search=' + object.value);
		}
		if (parameter) {
			array.push(parameter);
		}
		location.href = '?' + array.join('&');
	} catch(e) {
		alert('エラーが発生しました。\n' + e.message);
	}

}

App.deleteChecked = function () {
	
	try {
		var checked = false;
		var element = document.forms['checkedform'].getElementsByTagName('input');
		for (var i = 0; i < element.length; i++) {
			if (element[i].type == 'checkbox' && element[i].checked == true) {
				checked = true;
			}
		}
		if (!checked) {
			alert('削除するデータを選択してください。');
		} else if (window.confirm('選択したデータを削除します。')) {
			document.forms['checkedform'].submit();
		}
	} catch(e) {
		alert('エラーが発生しました。\n' + e.message);
	}
	
}

App.checkall = function (object, form) {

	try {
		if (!form) {
			form = 'checkedform';
		}
		var element = document.forms[form].getElementsByTagName('input');
		if (element && element.length) {
			if (object && object.type == 'checkbox') {
				var condition = object.checked;
				for (var i = 0; i < element.length; i++) {
					if (element[i].type == 'checkbox') {
						element[i].checked = condition;
					}
				}
			} else {
				var condition = true;
				for (var i = 0; i < element.length; i++) {
					if (element[i].type == 'checkbox' && element[i].checked == false) {
						condition = false;
						element[i].checked = true;
					}
				}
				if (condition == true) {
					for (var i = 0; i < element.length; i++) {
						if (element[i].type == 'checkbox') {
							element[i].checked = false;
						}
					}
				}
			}
		}
	} catch(e) {
		alert('エラーが発生しました。\n' + e.message);
	}

}

App.move = function (object, form) {
	
	try {
		if (!form) {
			form = 'checkedform';
		}
		if (object.options) {
			var integer = object.options[object.selectedIndex].value;
		} else {
			var integer = object;
		}
		var element = document.forms[form].elements;
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
			alert('データを選択してください。');
		} else if (element['folder']) {
			element['folder'].value = integer;
			document.forms[form].submit();
		}
		object.selectedIndex = '';
	} catch(e) {
		alert('エラーが発生しました。\n' + e.message);
	}
	
}

App.permitlevel = function (object, level, type) {
	
	try {
		if (!level) {
			App.level = 'public';
		} else {
			App.level = level;
		}
		if (object.options && object.options[object.selectedIndex].value != 2) {
			document.getElementById(level + 'search').style.display = 'none';
		} else {
			document.getElementById(level + 'search').style.display = 'inline';
			App.permitlist(null, type);
		}
	} catch(e) {
		alert(e.message);
	}
	
}

App.permitlist = function (object, type) {
	
	try {
		if (object) {
			var integer = object.options[object.selectedIndex].value;
		}
		App.loader('../user/feed.php', {'group': integer, 'type': type}, 'userlist');
	} catch(e) {
		alert(e.message);
	}
	
}

App.permit = function (object) {
	
	try {
		if (object) {
			var element = object.parentNode.getElementsByTagName('input');
			App.permitAppend(element[0].name, element[0].value);
		} else {
			var element = document.forms['userlist'].getElementsByTagName('input');
			if (element && element.length > 0) {
				for (var i = 0; i < element.length; i++) {
					if (element[i].type == 'checkbox' && element[i].checked == true) {
						App.permitAppend(element[i].name, element[i].value);
					}
				}
			}
		}
		$('#userlist').remove();
	} catch(e) {
		alert(e.message);
	}
	
}

App.permitAppend = function (userid, realname) {
	
	try {
		if (userid.match(/group:/)) {
			var type = 'group';
			userid = userid.replace(/group:/, '');
		} else {
			var type = 'user';
		}
		var id = App.level + type + userid;
		if (document.getElementById(id) && document.getElementById(id).type == 'checkbox') {
			document.getElementById(id).checked = true;
		} else {
			var element = document.createElement('div');
			var string = '<div><input type="checkbox" name="' + App.level + '[' + type + '][' + userid + ']" ';
			string += 'id="' + id + '" value="' + realname + '" checked="checked" />';
			string += '<label for="' + id + '">' + realname + '</label></div>';
			element.innerHTML = string;
			var parent = document.getElementById(App.level + 'search').parentNode;
			if (parent.getElementsByTagName('select').length > 0) {
				parent.appendChild(element);
			} else {
				parent.insertBefore(element, document.getElementById(App.level + 'search'));
			}
			
		}
	} catch(e) {
		alert(e.message);
	}
	
}

App.json = function (httpObject) {
	
	try {
		var json = eval('(' + httpObject.responseText + ')');
		if (json['error']) {
			alert(json['error']);
			return false;
		}
		return json;
	} catch(e) {
		alert(e.message);
	}
	
}

App.uploadfile = function (object) {
	
	if (object.parentNode) {
		var parent = object.parentNode;
		var element = document.createElement('div');
		element.innerHTML = '<input type="file" name="uploadfile[]" class="inputfile" size="70" />&nbsp;<span class="operator" onclick="App.removefile(this)">削除</span>';
		parent.insertBefore(element, object);
	}
	
}

App.removefile = function (object) {
	
	if (object.parentNode) {
		var element = object.parentNode;
		var parent = element.parentNode;
		parent.removeChild(element);
	}
	
}

App.explain = function (object) {
	
	try {
		if (object) {
			var element = $('div.explanation', object.parentNode);
			if (element.css('display') == 'block') {
				element.css('display', 'none');
			} else {
				element.css('display', 'block');
				var position = $(object).position();
				element.css({'top': (position.top + 17) + 'px', 'left': (position.left + 5) + 'px'});
				element.draggable();
				$('span.operator', element).click(function(){
					element.css('display', 'none');
				});
			}
		}
	} catch(e) {
		alert(e.message);
	}

}