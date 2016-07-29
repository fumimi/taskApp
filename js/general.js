

function General() {}

General.redirect = function (object, year, month, day) {
	
	location.href = 'schedule/groupweek.php?year=' + year + '&month=' + month + '&day=' + day + '&group=' + object.options[object.selectedIndex].value;

}