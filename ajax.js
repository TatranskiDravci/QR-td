const toAjax = () => {
	let xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = () => {};
	let locs = "";
	for(let i = 0; i < locations.length; i++) {
		locs += locations[ i ].name;
		if((i + 1) != locations.length) {
			locs += " - ";
		}
	}
	xmlhttp.open("GET", "php/addR.php?c=" + encodeURIComponent( locs ) + "&km=" + distance.toString(), true);
	xmlhttp.send();
}

document.getElementById("send").addEventListener("click", () => {
	if(window.navigator.onLine) {
		toAjax(locations, distance);
		scanner.stop();
		document.cookie = "path=";
	}
});
