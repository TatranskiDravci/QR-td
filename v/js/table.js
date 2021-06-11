let tId = window.location.search.slice(5,);
const timeline = document.getElementById(tId);

const update = setInterval( () => {
	const xhr = new XMLHttpRequest();
	xhr.open("GET", "php/table.php?tId=" + encodeURI(tId), true)


	xhr.responseType = "text";
	xhr.onload = () => {
		if(xhr.readyState == xhr.DONE && xhr.status == 200) {
			timeline.children[0].innerHTML = xhr.response;
		}
	};

	xhr.send(null);
}, 3000);

window.addEventListener("DOMContentLoaded", () => {
	timeline.style.display = "";
	if(tId != "") {
		const xhr = new XMLHttpRequest();
		xhr.open("GET", "php/table.php?tId=" + encodeURI(tId), true)

		xhr.responseType = "text";
		xhr.onload = () => {
			if(xhr.readyState == xhr.DONE && xhr.status == 200) {
				timeline.children[0].innerHTML = xhr.response;
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