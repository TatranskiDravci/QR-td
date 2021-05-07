let id = 0;
let zip = new JSZip();
let cname = "";

const imageToBase64 = (URL) => {
    let image;
    image = new Image();
    image.crossOrigin = 'Anonymous';
    image.addEventListener('load', function() {
        let canvas = document.createElement('canvas');
        let context = canvas.getContext('2d');
        canvas.width = image.width;
        canvas.height = image.height;
        context.drawImage(image, 0, 0);
        try {
            localStorage.setItem('saved-image-example', canvas.toDataURL('image/png'));
        } catch (err) {
            console.error(err)
        }
    });
    image.src = URL;
};

const generateCode = () => {
	let string = JSON.stringify({
		id: id,
		name: document.getElementById("name").value,
		hint: document.getElementById("hint").value
	});
	cname = document.getElementById("name").value;
	return string;
};

document.getElementById("create").addEventListener("click", () => {
	new QRCode(document.getElementById("qrcode"), generateCode());
	let qrset = document.getElementById("qrcode");
	let canvas = qrset.children[qrset.childElementCount - 2];
	let fname = id + "_" + cname + ".png";
	zip.file(fname, imageToBase64(canvas.toDataURL), { base64: true });
	id++
});

document.getElementById("download").addEventListener("click", () => {
	zip.generateAsync({ type: "blob" }).then( content => {
		saveAs(content, "qr-kody.zip");
	});
});
