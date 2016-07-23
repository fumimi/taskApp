/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

function Schedule() {}

Schedule.repeat = function (object) {
	
	try {
		var element = document.forms['schedule'].elements['schedule_type'];
		if (element.value == 1) {
			document.getElementById('repeat').style.display = 'none';
			document.getElementById('default').style.display = 'block';
			object.innerHTML = '繰り返しの設定';
			element.value = 0;
		} else {
			document.getElementById('default').style.display = 'none';
			document.getElementById('repeat').style.display = 'block';
			object.innerHTML = '日付を指定';
			element.value = 1;
		}
	} catch(e) {
		alert('エラーが発生しました。\n' + e.message);
	}

}

Schedule.redirect = function (object, year, month, day) {
	
	if (day > 0) {
		var parameter = '&day=' + day;
	}
	var element = object.options[object.selectedIndex];
	if (element.parentNode.label == 'ユーザー') {
		if (object.name == 'groupweek') {
			location.href = 'index.php?year=' + year + '&month=' + month + parameter + '&member=' + element.value;
		} else {
			location.href = 'view.php?year=' + year + '&month=' + month + parameter + '&member=' + element.value;
		}
	} else {
		if (object.name == 'groupweek') {
			location.href = 'groupweek.php?year=' + year + '&month=' + month + parameter + '&group=' + element.value;
		} else {
			location.href = 'groupday.php?year=' + year + '&month=' + month + parameter + '&group=' + element.value;
		}
	}

}

Schedule.facility = function (object, year, month) {
	
	location.href = 'facilitymonth.php?year=' + year + '&month=' + month + '&facility=' + object.options[object.selectedIndex].value;

}