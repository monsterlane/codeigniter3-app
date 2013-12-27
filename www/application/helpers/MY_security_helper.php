<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

/**
 * create_password
 *    Mask Rules
 *    # - digit
 *    C - Caps Character (A-Z)
 *    c - Small Character (a-z)
 *    X - Mixed Case Character (a-zA-Z)
 *    ! - Custom Extended Characters
 */

function create_password( $mask = 'XXXXX###' ) {
	$extended_chars = "!@#$%^&*()";
	$length = strlen( $mask );
	$pwd = '';

	for ( $c = 0; $c < $length; $c++ ) {
		$ch = $mask[ $c ];

		switch ($ch) {
			case '#':
				$p_char = rand( 0, 9 );
				break;
			case 'C':
				$p_char = chr( rand( 65, 90 ) );
				break;
			case 'c':
				$p_char = chr( rand( 97, 122 ) );
				break;
			case 'X':
				do {
					$p_char = rand( 65, 122 );
				}
				while ( $p_char > 90 && $p_char < 97 );

				$p_char = chr( $p_char );
				break;
			case '!':
				$p_char = $extended_chars[ rand( 0, strlen( $extended_chars ) - 1 ) ];
				break;
		}

		$pwd .= $p_char;
	}

	return $pwd;
}

/**
 * Translates a number to a short alphanumeric version
 * @author	Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @author	Simon Franz
 * @author	Deadfish
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
 * @link	  http://kevin.vanzonneveld.net/
 *
 * @param mixed   $in	  String or long input to translate
 * @param boolean $to_num  Reverses translation when true
 * @param mixed   $pad_up  Number or boolean pads the result up to a specified length
 * @param string  $passKey Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 */

function alpha_id( $in, $to_num = false, $pad_up = 10, $passKey = null ) {
	$index = "bcdfghjklmnpqrstvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	if ( $passKey !== null ) {
		for ( $n = 0; $n < strlen( $index ); $n++ ) {
			$i[ ] = substr( $index, $n, 1 );
		}

		$passhash = hash( 'sha256', $passKey );
		$passhash = ( strlen( $passhash ) < strlen( $index ) ) ? hash( 'sha512', $passKey ) : $passhash;

		for ( $n = 0; $n < strlen( $index ); $n++ ) {
			$p[ ] =  substr( $passhash, $n, 1 );
		}

		array_multisort( $p, SORT_DESC, $i );
		$index = implode( $i );
	}

	$base = strlen( $index );

	if ( $to_num ) {
		$in  = strrev( $in );
		$len = strlen( $in ) - 1;
		$out = 0;

		for ( $t = 0; $t <= $len; $t++ ) {
			$bcpow = pow( $base, $len - $t );
			$out = $out + strpos( $index, substr( $in, $t, 1 ) ) * $bcpow;
		}

		if ( is_numeric( $pad_up ) ) {
			$pad_up--;

			if ( $pad_up > 0 ) {
				$out -= pow( $base, $pad_up );
			}
		}

		$out = sprintf( '%F', $out );
		$out = substr( $out, 0, strpos( $out, '.' ) );
	}
	else {
		if ( is_numeric( $pad_up ) ) {
			$pad_up--;

			if ( $pad_up > 0 ) {
				$in += pow( $base, $pad_up );
			}
		}

		$out = "";
		for ( $t = floor( log( $in, $base ) ); $t >= 0; $t-- ) {
			$bcp = pow( $base, $t );
			$a   = floor( $in / $bcp ) % $base;
			$out = $out . substr( $index, $a, 1 );
			$in  = $in - ( $a * $bcp );
		}
		$out = strrev( $out );
	}

	return $out;
}

?>