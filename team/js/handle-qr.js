QrScanner.WORKER_PATH = "js/qr-scanner/qr-scanner-worker.min.js";

let loc = { id: -1 };

const getCookie = name => {
	name = name + "=";
	let ca = document.cookie.split(";");
	for(let i = 0; i < ca.length; i++) {
		let c = ca[i];
		while(c.charAt(0) == " ") {
			c = c.substring(1);
		}
		if(c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
};

const updateCookie = location => {
	document.cookie = "current=" + JSON.stringify(location);
};

const parseCookie = cookie => {
	return JSON.parse(cookie);
};

const renderCurrent = location => {
	table = document.getElementById("tableElem");
	table.innerHTML = "";

	row1 = document.createElement("TR");
	th1 = document.createElement("TH");
	th1.innerHTML = "Poloha";
	td1 = document.createElement("TD");
	td1.innerHTML = location.name;
	row1.appendChild(th1);
	row1.appendChild(td1);
	table.appendChild(row1);

	if("hint" in location) {
		row2 = document.createElement("TR");
		th2 = document.createElement("TH");
		td2 = document.createElement("TD");
		th2.innerHTML = "Indícia";
		td2.innerHTML = location.hint;
		row2.appendChild(th2);
		row2.appendChild(td2);
		table.appendChild(row2);
	}
};

const scanner = new QrScanner(
	document.getElementById("videoElem"),
	result => {
		let nloc = JSON.parse(result);
		if(loc.id != nloc.id) {
			loc = nloc;
			console.log(loc);
			updateCookie(loc);
			send(loc);
			renderCurrent(loc);
		}
	}
);

let current = getCookie("current");
console.log(current);

if( current == "{}" || current == "" ) {
	scanner.start();
} else {
	loc = parseCookie(current);
	renderCurrent(loc);
	scanner.start();
}
