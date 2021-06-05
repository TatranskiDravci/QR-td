const timeline = document.getElementById("timeline");
let tIdCurrent = null;

const update = setInterval( () => {
	if(tIdCurrent != null) {
		const xhr = new XMLHttpRequest();
		xhr.open("GET", "php/table.php?tId=" + encodeURI(tIdCurrent), true)

		xhr.responseType = "text";
		xhr.onload = () => {
			if(xhr.readyState == xhr.DONE && xhr.status == 200) {
				timeline.innerHTML = xhr.response;
			}
		};

		xhr.send(null);
	}
}, 10000);



window.addEventListener("DOMContentLoaded", () => {
	const buttons = document.getElementsByClassName("expeditions");
	for(button of buttons) {
		button.addEventListener("click", event => {
			tIdCurrent = event.currentTarget.getAttribute("tid");
			const xhr = new XMLHttpRequest();
			xhr.open("GET", "php/table.php?tId=" + encodeURI(tIdCurrent), true)

			xhr.responseType = "text";
			xhr.onload = () => {
				if(xhr.readyState == xhr.DONE && xhr.status == 200) {
					timeline.innerHTML = xhr.response;
				}
			};

			xhr.send(null);
		});
	}

	setTimeout( () => {
		clearInterval();
		update();
	}, 50000);
});