
/*
===============================================================================
Class: Module
===============================================================================
*/

if ( window.hasOwnProperty( 'app' ) == false ) window.app = { };

app.Module = function( ) {
	this._conduit = null;
	this._ie = null;
};

/**
 * Method: hookUp
 * Acts as a constructor and should be called to create a global instance
 */

app.Module.prototype.hookUp = function( ) {
	var undef,
		v = 3,
		div = document.createElement( 'div' ),
		all = document.createElement( 'i' );

    while (
        div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
        all[ 0 ]
    );
	if ( v > 4 ) this._ie = v;

	this._conduit = [ ];
};

/**
 * Method: getConduit
 * @param {Object} aName
 */

app.Module.prototype.getConduit = function( aName ) {
	var name = aName || Math.random( ).toString( 36 ).substr( 2 );

	if ( !this._conduit.hasOwnProperty( name ) ) {
		this._conduit[ name ] = new app.Conduit( this );
	}

	return this._conduit[ name ];
};

/**
 * Method: disableButton
 * @param {DOMelement} aButton
 */

app.Module.prototype.disableButton = function( aButton ) {
	aButton.disabled = true;
	aButton.setAttribute( 'data-label', aButton.innerHTML );
	aButton.innerHTML = 'Saving';

	$( aButton ).addClass( 'disabled' );
};

/**
 * Method: enableButton
 * @param {DOMelement} aButton
 */

app.Module.prototype.enableButton = function( aButton ) {
	aButton.disabled = false;
	aButton.innerHTML = aButton.getAttribute( 'data-label' );

	$( aButton ).removeClass( 'disabled' );
};

/**
 * Method: alert
 * The purpose of this method is to allow you to use a module method as a bridge
 * to other notification libraries (jqueryui, bootstrap, etc) all notifications
 * should be called through the bridge, if you ever change the plugin you only
 * update this method. you can add more methods like this for confirm boxes,
 * popup forms, etc
 * @param {String} aMessage
 */

app.Module.prototype.alert = function( aMessage ) {
	alert( aMessage );
};
