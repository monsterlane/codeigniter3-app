
/*
===============================================================================
Class: app
===============================================================================
*/

if ( window.hasOwnProperty( 'app' ) == false ) window.app = { };

$.ajaxSetup({ cache: false });

/**
 * Method: serializeObject
 * Mimics jQuery's serializeArray for objects
 */

$.fn.serializeObject = function( ) {
	var o = { },
		a = this.serializeArray( );

	$.each( a, function( ) {
		if ( o[ this.name ] !== undefined ) {
			if ( !o[ this.name ].push ) {
				o[ this.name ] = [ o[ this.name ] ];
			}

			o[ this.name ].push( this.value || '' );
		}
		else {
			o[ this.name ] = this.value || '';
		}
	});

	return o;
};

/**
 * Method: extend
 * Mimics classical inheritance
 * @param {Class} aSubClass
 * @param {Class} aSuperClass
 */

app.extend = function( aSubClass, aSuperClass ) {
	aSubClass.prototype = new aSuperClass( aSuperClass );
	aSubClass.prototype.constructor = aSubClass;
	aSubClass._superClass = aSuperClass;
	aSubClass._superProto = aSuperClass.prototype;
};

/**
 * Method: arrayIndexOf
 * @param {Array} aHaystack
 * @param {Object} aNeedle
 */

app.arrayIndexOf = function( aHaystack, aNeedle ) {
	if ( typeof Array.prototype.indexOf === 'function' ) {
		return aHaystack.indexOf( aNeedle );
	}
	else {
		var i = aHaystack.length;
		var n = -1;

		while ( i-- ) {
			if ( aHaystack[ i ] === aNeedle ) {
				n = i;
				break;
			}
		}

		return n;
	}
};

/**
 * Method: pad
 * Pads a string with leading characters
 * @param {String} aString
 * @param {Int} aLength
 * @param {String} aCharacter
 */

app.pad = function( aString, aLength, aCharacter ) {
	var c = aCharacter || 0,
		s = aString + '';

	return ( s.length >= aLength ) ? s : new Array( aLength - s.length + 1 ).join( c ) + s;
};

/**
 * Method: pregQuote
 * Quotes regular expression characters in a string
 */

app.pregQuote = function( aString ) {
	return aString.replace( /([.?*+^$[\]\\(){}|-])/g, "\\$1" );
};
