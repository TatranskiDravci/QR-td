QrScanner.WORKER_PATH = "js/qr-scanner/qr-scanner-worker.min.js";
let scannedId;

const sendToServer = qr => {
	// TODO: Implement *this* function
	// TODO: *this* function **should** postpone the post request until internet is available (in case it's used offline)
}

const drawTable = qr => {
	const table = document.getElementById("tableElem");

	let rowName = document.createElement("TR");
	let colName1 = document.createElement("TH");
	let colName2 = document.createElement("TD");

	colName1.textContent = "Lokalita";
	colName2.textContent = qr.name;
	rowName.appendChild(colName1);
	rowName.appendChild(colName2);
	table.appendChild(rowName);

	if("hint" in qr) {
		let rowHint = document.createElement("TR");
		let colHint1 = document.createElement("TH");
		let colHint2 = document.createElement("TD");

		colHint1.textContent = "Správa";
		colHint2.textContent = qr.hint;
		rowHint.appendChild(colName1);
		rowHint.appendChild(colName2);
		table.appendChild(rowHint);
	}
};

const scanner = new QrScanner(
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

					// TODO: implement this:
					sendToServer(result);
				};
			}
		}
	}
);

scanner.start();
