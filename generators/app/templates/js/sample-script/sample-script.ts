import domReady from '@wordpress/dom-ready';

function printMessage( message: string ) {
	console.log( message );
}

domReady( () => {
	printMessage( 'Hello world!' );
} );
