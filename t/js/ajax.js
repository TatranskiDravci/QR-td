const send = location => {
	let xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = () => {};
	xmlhttp.open(
		"GET",
		"/team/php/addR.php?name=" + encodeURIComponent(location.name) + "&id=" + encodeURIComponent(location.id),
		true
	);
	xmlhttp.send();
}
