QrScanner.WORKER_PATH = "include/qr-scanner/qr-scanner-worker.min.js";

let previous = { id: 0 };
let distance = 0;
let locations = [];
let rendered = 0;
let calculated = 1;

const lookup = ( loc1, loc2 ) => {
	let dist;
	if( loc1.id in distances ) {
		if( loc2.id in distances[ loc1.id ] ) {
			return distances[ loc1.id ][ loc2.id ];
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
		let x = document.createElement( "TR" );
		let y = document.createElement( "TD" );
		//x.setAttribute( "class", "table-primary" );
		//y.setAttribute( "class", "table-primary" );
		y.innerHTML = locations[ i ].name;
		x.appendChild( y );
		document.getElementById( "path" ).appendChild( x );
	}
	rendered = locations.length;
};

const computeDistance = () => {
	for( let i = calculated; i < locations.length; i++ ) {
		distance += lookup( locations[ i ], locations[ i - 1 ] );
	}
	document.getElementById( "distance" ).innerHTML = distance.toString() + "km";
	calculated = locations.length;
};

const scanner = new QrScanner(
	document.getElementById( "videoElem" ),
	result => {
		let location = JSON.parse( result );
		if( location.id != previous.id ) {
			locations.push( location );
			previous = location;
			console.log( locations );
			updateCookie( locations );
			renderLocations();
			computeDistance();
		}
	}
);

let path = getCookie( "path" );
console.log( path );

if( path == "{[]}" || path == "" ) {
	scanner.start();
} else {
	fillFromCookie( path );
	previous = locations[ locations.length - 1 ];
	renderLocations();
	computeDistance();
	scanner.start();
}
