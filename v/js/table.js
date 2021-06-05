const timeline = document.getElementById("timeline");
let tId = window.location.search.slice(5,);

const update = setInterval( () => {
	const xhr = new XMLHttpRequest();
	xhr.open("GET", "php/table.php?tId=" + encodeURI(tId), true)

	xhr.responseType = "text";
	xhr.onload = () => {
		if(xhr.readyState == xhr.DONE && xhr.status == 200) {
			timeline.innerHTML = xhr.response;
		}
	};

	xhr.send(null);
}, 10000);

window.addEventListener("DOMContentLoaded", () => {
	if(tId != "") {
		const xhr = new XMLHttpRequest();
		xhr.open("GET", "php/table.php?tId=" + encodeURI(tId), true)

		xhr.responseType = "text";
		xhr.onload = () => {
			if(xhr.readyState == xhr.DONE && xhr.status == 200) {
				timeline.innerHTML = xhr.response;
			}
		};

		xhr.send(null);
	} else {
		const as = document.getElementsByClassName("expeditions");
		window.location.href = as[0].href;
	}
	setTimeout( () => {
		clearInterval();
		update;
	}, 50000);
});