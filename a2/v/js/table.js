const table = $("#tableElem");

const update = setInterval( () => {
	table.load("/v/php/table.php");
}, 5000);

setTimeout( () => {
	clearInterval();
	update();
}, 240000);
