

function Timecard() {}

Timecard.redirect = function (object, group) {
	
	var element = object.parentNode.getElementsByTagName('select');
	var year = element[0].options[element[0].selectedIndex].value;
	var month = element[1].options[element[1].selectedIndex].value;
	if (group == 'group') {
		var group = element[2].options[element[2].selectedIndex].value;
		location.href = 'group.php?year=' + year + '&month=' + month + '&group=' + group;
	} else {
		location.href = 'index.php?year=' + year + '&month=' + month;
	}

}

Timecard.interval = function (object) {
	
	if (object.parentNode) {
		var parent = object.parentNode;
		var element = document.createElement('div');
		element.innerHTML = '<select name="intervalopenhour[]"><option value="">&nbsp;</option>' + Timecard.option(0, 23) + '</select>時&nbsp;\n';
		element.innerHTML += '<select name="intervalopenminute[]"><option value="">&nbsp;</option>' + Timecard.option(0, 59) + '</select>分&nbsp;-&nbsp;\n';
		element.innerHTML += '<select name="intervalclosehour[]"><option value="">&nbsp;</option>' + Timecard.option(0, 23) + '</select>時&nbsp;\n';
		element.innerHTML += '<select name="intervalcloseminute[]"><option value="">&nbsp;</option>' + Timecard.option(0, 59) + '</select>分&nbsp;\n';
		element.innerHTML += '<span class="operator" onclick="Timecard.remove(this)">削除</span>';
		parent.insertBefore(element, object);
	}
	
}
	
Timecard.option = function (begin, end) {
	
	var option = '';
	for (var i = begin; i <= end; i++) {
		option += '<option value="' + i + '"%s>' + i + '</option>';
	}
	return option;
	
}

Timecard.remove = function (object) {
	
	if (object.parentNode) {
		var element = object.parentNode;
		var parent = element.parentNode;
		parent.removeChild(element);
	}
	
}