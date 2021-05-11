let id = 0;
let zip = new JSZip();
let cname;

const renderTable = () => {
	table = document.getElementById("tableElem");

	row = document.createElement("TR");
	td1 = document.createElement("TD");
	td2 = document.createElement("TD");
	td3 = document.createElement("TD");
	td1.innerHTML = id;
	td2.innerHTML = cname;
	td3.innerHTML = id + "_" + cname + ".png";
	row.appendChild(td1);
	row.appendChild(td2);
	row.appendChild(td3);
	table.appendChild(row);
}

const generateCode = () => {
	let str;
	if(document.getElementById("hint").value != "") {
		str = JSON.stringify({
			id: id,
			name: document.getElementById("name").value,
			hint: document.getElementById("hint").value
		});
	} else {
		str = JSON.stringify({
			id: id,
			name: document.getElementById("name").value
		});
	}
	cname = document.getElementById("name").value;
	document.getElementById("name").value = "";
	document.getElementById("hint").value = "";
	return str;
};

const generateQR = (code, callback) => {
	let img = new Image();
	let canvas = document.createElement("CANVAS");
	img.src = "https://chart.apis.google.com/chart?cht=qr&chs=500x500&choe=UTF-8&chl=" + encodeURIComponent(code);
	img.crossOrigin = "anonymous";
	img.onload = () => {
		let ctx = canvas.getContext("2d");
		canvas.width = img.width;
		canvas.height = img.height;
		ctx.drawImage(img, 0, 0);
		callback(canvas.toDataURL("image/png").replace("data:image/png;base64,", ""));
	};
};

document.getElementById("create").addEventListener("click", () => {
	id++;
	generateQR(generateCode(), URL => {
		zip.file(
			id + "_" + cname + ".png", URL,
			{ base64: true }
		);
		renderTable();
	});
});

document.getElementById("download").addEventListener("click", () => {
	zip.generateAsync({ type: "blob" }).then( content => {
		saveAs(content, "qr-kody.zip");
	});
});

// generate starting point QR code
window.onload = () => {
	generateQR("{\"id\":0,\"name\":\"Štart\"}", URL => {
		zip.file("0_Štart.png", URL, { base64: true })
	});
};
