let zip = new JSZip();
let QR = [];
let expedition = {};

new Sortable(document.getElementById("table"), {
    animation: 150,
    ghostClass: '' 
});

const sendToServer = data => {
	return new Promise( (resolve, reject) => {
		const xhr = new XMLHttpRequest();
		xhr.open("POST", "php/getJSON.php");
		xhr.setRequestHeader("Content-Type", "application/json");
	
		xhr.responseType = "text";
		xhr.onload = () => {
			if(xhr.readyState == xhr.DONE && xhr.status == 200) {
				resolve(xhr.response);
			}
		};
		xhr.send(JSON.stringify(data));
	});
}

const generateQR = code => {
	return new Promise( (resolve, reject) => {
		let img = new Image();
		let canvas = document.createElement("CANVAS");
		img.src = "https://chart.apis.google.com/chart?cht=qr&chs=500x500&choe=UTF-8&chl=" + encodeURIComponent(code);
		img.crossOrigin = "anonymous";
		img.onload = () => {
			let ctx = canvas.getContext("2d");
			canvas.width = img.width;
			canvas.height = img.height;
			ctx.drawImage(img, 0, 0);
			resolve(canvas.toDataURL("image/png").replace("data:image/png;base64,", ""));
		};
	});
};

document.getElementById("register").addEventListener("click", () => {
	const name = document.getElementById("ename").value;
	const uname = document.getElementById("euname").value;
	const pass = document.getElementById("epass").value;
	if(name != "" && uname != "" && pass != "") {
		expedition.tMeno = name;
		expedition.tPrihlasovacieMeno = uname;
		expedition.tHeslo = pass;
		document.getElementById("firstStep").style.display = "none";
		document.getElementById("secondStep").style.display = "";
	}
});

document.getElementById("create").addEventListener("click", () => {
    const name = document.getElementById("name").value;
    if(name != "") {
        const hint = document.getElementById("hint").value;
        const id = uuid();
        let code = {
            dMeno: name,
            dId: id
        };

		if(hint != "") {
            code.dSprava = hint;
		}

		QR.push(code)

		const table = document.getElementById("table");
        const slab = document.createElement("DIV");
		slab.setAttribute("class", "list-group-item");
        slab.draggable = true;
        slab.dId = id;
		slab.innerHTML = name;
        table.appendChild(slab);
    }
    document.getElementById("name").value = "";
    document.getElementById("hint").value = "";
	document.getElementById("download").style.display = "";
});

const getHistory = () => {
    const table = document.getElementById("table");
    const slabs = table.children;
    let history = []
    for(let i = 0; i < slabs.length; i++) {
        history.push({
            trQrId: slabs[i].dId,
            trPoradie: String(i)
		});
    }
    return history;
}

document.getElementById("download").addEventListener("click", async () => {
	const history = getHistory();
	const data = {
		expedition,
		QR,
		History: history
	};

	const response = await sendToServer(data);
	if(response.slice(0, 9) != "Ospravedl") {
		$("body").html("<p>Vytváram QR kódy...</p>");
		for(let i = 0; i < history.length; i++) {
			let name;
			for(let qr of QR) {
				if(qr.dId == history[i].trQrId) {
					name = qr.dMeno;
					break;
				}
			}
			const URL = await generateQR(history[i].trQrId);
			const place = String(Number(history[i].trPoradie) + 1)
			zip.file(place + "_" + name + ".png", URL, { base64: true });
		}
		zip.generateAsync({ type: "blob" }).then( content => {
			saveAs(content, expedition.tMeno + ".zip");
			window.location.href = "/v/index.php?tId=" + encodeURIComponent(response);
		});
		
	} else {
		$("body").html("<p>" + response + "</p>");
	}
});


