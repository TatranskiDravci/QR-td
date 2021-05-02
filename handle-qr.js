QrScanner.WORKER_PATH = "include/qr-scanner/qr-scanner-worker.min.js";

let previous;
let distance = 0;
let locations = [];

const lookup = ( loc1, loc2 ) => {
	let dist;
	if( loc1.id in distances ) {
		if( loc2.id in distances[loc1.id] ) {
			return distances[loc1.id][loc2.id];
		}
	} else if( loc2.id in distances ) {
		if( loc1.id in distances[loc2.id] ) {
			return distances[loc2.id][loc1.id];
		}
	}
};

const scanner = new QrScanner(
	document.getElementById( "videoElem" ),
	result => {
		if( result.localeCompare( previous ) ) {
			let location = JSON.parse( result );
			document.getElementById( "location" ).innerHTML = "Current location: " + location.name;
			locations.push( location );
			previous = result;
			console.log( locations );
			if( locations.length > 1 ) {
				distance += lookup(
					location,
					locations[locations.length - 2]
				);
				document.getElementById( "distance" ).innerHTML = "Distance travelled: " + distance + "km";
			}
		}
	}
);

scanner.start();
