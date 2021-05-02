QrScanner.WORKER_PATH = "include/qr-scanner/qr-scanner-worker.min.js";

let previous;
let distance = 0;
let locations = [];
const pathElem = document.getElementById( "path" );
let rendered = 0;

const lookup = ( loc1, loc2 ) => {
	let dist;
	if( loc1.id in distances ) {
		if( loc2.id in distances[ loc1.id ] ) {
			return distances[ loc1.id ][loc2.id ];
		}
	} else if( loc2.id in distances ) {
		if( loc1.id in distances[ loc2.id ] ) {
			return distances[ loc2.id ][ loc1.id ];
		}
	}
};

const getCookie = name => {
	name = name + "=";
	let ca = document.cookie.split( ';' );
	for( let i = 0; i < ca.length; i++ ) {
		let c = ca[ i ];
		while( c.charAt( 0 ) == ' ' ) {
			c = c.substring( 1 );
		}
		if( c.indexOf( name ) == 0 ) {
			return c.substring( name.length, c.length );
		}
	}
	return "";
};

const updateCookie = locations => {
	let loc = {
		path: locations
	};
	document.cookie = "path=" + JSON.stringify( loc );
};

const fillFromCookie = cookie => {
	let locsObj = JSON.parse( cookie );
	locations = locsObj.path;
};

const renderLocations = () => {
	for( let i = rendered; i < locations.length; i++ ) {
		let x = document.createElement( "P" );
		x.setAttribute( "id", "location" );
		path.appendChild( x );
	}
	rendered = locations.length - 1;
};

const scanner = new QrScanner(
	document.getElementById( "videoElem" ),
	result => {
		if( result.localeCompare( previous ) ) {
			let location = JSON.parse( result );
			locations.push( location );
			previous = result;
			console.log( locations );
			updateCookie( locations );
			renderLocations();
		}
	}
);

let path = getCookie( "path" );
console.log( path );
if( path == "" ) {
	scanner.start();
} else {
	fillFromCookie( path );
	renderLocations();
	scanner.start();
}
