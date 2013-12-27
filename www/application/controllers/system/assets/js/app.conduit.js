
/*
===============================================================================
Class: Conduit
===============================================================================
*/

if ( window.hasOwnProperty( 'app' ) == false ) window.app = { };

app.Conduit = function( aParent ) {
	this._parent = aParent;
	this._xhr = null;
};

/**
 * Method: getParent
 * @return {Object}
 */

app.Conduit.prototype.getParent = function( ) {
	return this._parent;
};

/**
 * Method: ajax
 * @param {Object} aData
 */

app.Conduit.prototype.ajax = function( aData ) {
	var ncb, ocb,
		self = this;

	if ( !aData.hasOwnProperty( 'checkResponse' ) ) {
		aData.checkResponse = true;
	}

	if ( aData.hasOwnProperty( 'form' ) ) {
		aData.url = aData.form.action;
		aData.type = aData.form.method;
		aData.data = $( aData.form ).serialize( );
	}

	if ( aData.hasOwnProperty( 'success' ) == true ) {
		ocb = aData.success;

		ncb = function( aResponse ) {
			var r;

			if ( aData.checkResponse == false || ( r = self.parse( aResponse ) ) !== false ) {
				ocb( r );
			}
			else {
				self.getParent( ).alert( 'An error has occured. Please refresh the page, if the problem persits please contact <a href="mailto:support@domain.com">support</a>.' );
			}
		};
	}
	else {
		ncb = function( aResponse ) {
			if ( aData.checkResponse == false || self.parse( aResponse ) === false ) {
				self.getParent( ).alert( 'An error has occured. Please refresh the page, if the problem persits please contact <a href="mailto:support@domain.com">support</a>.' );
			}
		};
	}

	aData.success = ncb;

	this.abort( );
	this._xhr = $.ajax( aData );
};

/**
 * Method: abort
 */

app.Conduit.prototype.abort = function( ) {
	if ( this._xhr != null ) {
		this._xhr.abort( );
	}
};

/**
 * Method: parse
 * @param {String} aResponse
 */

app.Conduit.prototype.parse = function( aResponse ) {
	var r;

	try {
		r = $.parseJSON( aResponse );
	}
	catch( err ) {
		r = false;
	}

	return r;
};
