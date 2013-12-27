
/*
===============================================================================
Module: Main
===============================================================================
*/

if ( window.hasOwnProperty( 'app' ) == false ) window.app = { };

app.MainModule = function( ) { };
app.extend( app.MainModule, app.SystemModule );

/**
 * Method: bindMainFormEventListeners
 */

app.MainModule.prototype.bindEventListeners = function( ) {
	this.constructor._superProto.bindEventListeners.apply( this, arguments );
	var self = this;

};
