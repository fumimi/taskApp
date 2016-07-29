

function Todo() {}

Todo.noterm = function (object) {
	
	var element = object.parentNode.getElementsByTagName('select');
	for (var i = 0; i < element.length; i++) {
		element[i].disabled = object.checked;
	}
	
}