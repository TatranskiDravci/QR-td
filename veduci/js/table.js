window.onload = () => {
	let table = $("#tableElem");
	setInterval( () => {
		table.load("php/table.php");
	}, 5000);
};
