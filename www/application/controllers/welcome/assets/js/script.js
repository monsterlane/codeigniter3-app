
/*
===============================================================================
Module: Welcome
===============================================================================
*/

if ( window.hasOwnProperty( 'app' ) == false ) window.app = { };

app.WelcomeModule = function( ) { };
app.extend( app.WelcomeModule, app.SystemModule );

/**
 * Method: bindMainFormEventListeners
 */

app.WelcomeModule.prototype.bindEventListeners = function( ) {
	this.constructor._superProto.bindEventListeners.apply( this, arguments );
	var self = this;

	$( '#appWelcomeText' ).on( 'click', function( aEvent ) {
		aEvent.preventDefault( );
		self.handleMessageClick( this );
	});
};

/**
 * Method: handleMessageClick
 * @param {DOMelement} aElement
 */

app.WelcomeModule.prototype.handleMessageClick = function( aElement ) {
	alert( aElement.innerHTML );
};
