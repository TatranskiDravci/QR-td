QrScanner.WORKER_PATH = "js/qr-scanner/qr-scanner-worker.min.js";
let scannedId;
let scanner;


// FIXME: Scuffed solution, should be done through /t/worker.js
const sendToServer = qr => {
	// TODO: Implement *this* function
	// TODO: *this* function **should** postpone the post request until internet is available (in case it's used offline)

	const xhr = new XMLHttpRequest();
	xhr.open("GET", "php/qrSend.php?trId=" + encodeURIComponent(qr.trId));
	xhr.send(null);
};

// FIXME: Scuffed solution, should be done through /t/worker.js
const fetchFromServer = () => {
	const openRequest = indexedDB.open("qrDB", 1);

	openRequest.onupgradeneeded = () => {
		const db = openRequest.result;
		if (!db.objectStoreNames.contains('QR')) {
			db.createObjectStore('QR', {keyPath: 'id'});
			console.log("create IDB");
		}
	};

	openRequest.onsuccess = () => {
		const db = openRequest.result;
		db.transaction("QR", "readwrite").objectStore("QR").clear();
		console.log("clear IDB");

		const xhr = new XMLHttpRequest();
		xhr.open("GET", "php/qrRequest.php");
		
		xhr.responseType = "text";
		xhr.onload = () => {
			if(xhr.readyState == xhr.DONE && xhr.status == 200) {
				const qrs = JSON.parse(xhr.response);
				for(qr of qrs) {
					console.log("load to IDB");
					const transaction = db.transaction("QR", "readwrite");
					transaction.objectStore("QR").add({
						id: qr.trQrId,
						name: qr.dMeno,
						hint: qr.dSprava,
						trId: qr.trId,
						trPlace: qr.trPoradie
					});
				}
			}
		};
		xhr.send(null);
	};
};

const drawTable = qr => {
	const location = document.getElementById("location");
	location.innerHTML = qr.name;

	if(qr.hint != null) {
		const hint = document.getElementById("hint");
		hint.innerHTML = qr.name;
	}

	// let rowName = document.createElement("TR");
	// let colName1 = document.createElement("TH");
	// let colName2 = document.createElement("TD");

	// colName1.textContent = "Lokalita";
	// colName2.textContent = ;
	// rowName.appendChild(colName1);
	// rowName.appendChild(colName2);
	// table.appendChild(rowName);

	// if(qr.hint != null) {
	// 	let rowHint = document.createElement("TR");
	// 	let colHint1 = document.createElement("TH");
	// 	let colHint2 = document.createElement("TD");

	// 	colHint1.textContent = "Správa";
	// 	colHint2.textContent = qr.hint;
	// 	rowHint.appendChild(colHint1);
	// 	rowHint.appendChild(colHint2);
	// 	table.appendChild(rowHint);
	// }
};

const closeScanner = () => {
	document.getElementById("qrScannerDiv").style.display = "none";
	document.getElementById("qrButtonDiv").style.display = "";
	scanner.destroy();
};

fetchFromServer();

document.getElementById("buttonElem").addEventListener("click", () => {
	document.getElementById("qrButtonDiv").style.display = "none";
	document.getElementById("qrScannerDiv").style.display = "";
	scanner = new QrScanner(
		document.getElementById("videoElem"),
		id => {
			if(id != scannedId) {
				scannedId = id;
				const openRequest = indexedDB.open("qrDB", 1);
				openRequest.onsuccess = () => {
					const db = openRequest.result;
					const transaction = db.transaction("QR", "readonly");
					const QR = transaction.objectStore("QR");
	
					const request = QR.get(id);
					request.onsuccess = () => {
						const result = request.result; 
						console.log(result);
						drawTable(result);
						sendToServer(result);
						closeScanner();
					};
				}
			}
		}
	);
	scanner.start();
});
