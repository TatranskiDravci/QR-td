const table = $("#tableElem");

const update = setInterval( () => {
	table.load("php/table.php");
}, 5000);

window.onload = () => {
	setTimeout( () => {
		clearInterval();
		update();
	}, 240000);
};
