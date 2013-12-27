
/*
===============================================================================
Module: Example
===============================================================================
*/

if ( window.hasOwnProperty( 'app' ) == false ) window.app = { };

app.ExampleModule = function( ) { };
app.extend( app.ExampleModule, app.SystemModule );

/**
 * Method: bindMainFormEventListeners
 */

app.ExampleModule.prototype.bindEventListeners = function( ) {
	this.constructor._superProto.bindEventListeners.apply( this, arguments );
	var self = this;

};
