
/*
===============================================================================
Module: System
===============================================================================
*/

if ( window.hasOwnProperty( 'app' ) == false ) window.app = { };

app.SystemModule = function( ) { };
app.extend( app.SystemModule, app.Module );

/**
 * Method: bindMainFormEventListeners
 */

app.SystemModule.prototype.bindEventListeners = function( ) {
	var self = this;

	$( '#appHeaderText' ).on( 'click', function( aEvent ) {
		aEvent.preventDefault( );
		self.handleTitleClick( this );
	});
};

/**
 * Method: handleTitleClick
 * @param {DOMelement} aElement
 */

app.SystemModule.prototype.handleTitleClick = function( aElement ) {
	alert( aElement.innerHTML );
};
