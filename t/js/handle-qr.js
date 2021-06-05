QrScanner.WORKER_PATH = "js/qr-scanner/qr-scanner-worker.min.js";

const scanner = new QrScanner(
	document.getElementById("videoElem"),
	id => {
		const openRequest = indexedDB.open("qrDB", 1);
		openRequest.onsuccess = () => {
			const db = openRequest.result;
			const transaction = db.transaction("QR", "readonly");
			const QR = transaction.objectStore("QR");

			const request = QR.get(id);
			request.onsuccess = () => {
				// TODO: Display QR code data
				// TODO: Send id to v
				console.log(request.result);
			};
		}
	}
);

scanner.start();