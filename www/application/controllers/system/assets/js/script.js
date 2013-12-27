
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

	// put any binding you want on every page in here
	// ex: a search form at the top of every page

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
	// see app.module for description of alert method
	self.alert( aElement.innerHTML );
};
