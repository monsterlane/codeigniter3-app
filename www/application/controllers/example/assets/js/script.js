
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

	// button bindings, self is a reference to the module instance
	// do not reference the module by its name use self references

	$( '#appJsonButton' ).on( 'click', function( aEvent ) {
		aEvent.preventDefault( );
		self.handleJsonButtonClick( this );
	});

	$( '#appViewButton' ).on( 'click', function( aEvent ) {
		aEvent.preventDefault( );
		self.handleViewButtonClick( this );
	});

	$( '#appFormAButton' ).on( 'click', function( aEvent ) {
		aEvent.preventDefault( );
		self.handleFormAButtonClick( this );
	});

	$( '#appFormBButton' ).on( 'click', function( aEvent ) {
		aEvent.preventDefault( );
		self.handleFormBButtonClick( this );
	});
};

/**
 * Method: handleJsonButtonClick
 * @param {DOMelement} aButton
 */

app.ExampleModule.prototype.handleJsonButtonClick = function( aButton ) {
	var self = this;

	// by not naming the conduit, a random name is chosen
	// if you do not need the ability to abort the request
	// this is the preferred method to use a conduit

	this.getConduit( ).ajax({
		url: aButton.getAttribute( 'data-url' ),
		success: function( response ) {
			if ( response.status == true ) {
				self.alert( response.message );
			}
			else {
				self.alert( 'An error has occured.' );
			}
		}
	});
};

/**
 * Method: handleViewButtonClick
 * @param {DOMelement} aButton
 */

app.ExampleModule.prototype.handleViewButtonClick = function( aButton ) {
	var self = this;

	// by giving a conduit a name, if the same conduit is called again
	// before the first request completes it will be aborted, and
	// the second request will be sent

	this.getConduit( 'view' ).ajax({
		url: aButton.getAttribute( 'data-url' ),
		success: function( response ) {
			var div = document.getElementById( 'appViewArea' );

			if ( response.status == true ) {
				div.innerHTML = response.view;
			}
			else {
				self.alert( 'An error has occured.' );
			}
		}
	});
};

/**
 * Method: handleFormAButtonClick
 * @param {DOMelement} aButton
 */

app.ExampleModule.prototype.handleFormAButtonClick = function( aButton ) {
	var form = document.getElementById( 'appDemoForm' ),
		self = this;

	// passing a form reference to a conduit

	this.getConduit( ).ajax({
		form: form, // DOM reference not jQuery reference
		success: function( response ) {
			self.alert( 'test=' + response.test );
		}
	});
};

/**
 * Method: handleFormBButtonClick
 * @param {DOMelement} aButton
 */

app.ExampleModule.prototype.handleFormBButtonClick = function( aButton ) {
	var form = document.getElementById( 'appDemoForm' ),
		self = this;

	// this is equivalent to forma but sets each param individually

	this.getConduit( ).ajax({
		url: form.action,
		type: form.method,
		data: $( form ).serialize( ),
		success: function( response ) {
			self.alert( 'test=' + response.test );
		}
	});
};
