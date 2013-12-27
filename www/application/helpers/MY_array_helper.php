<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

/**
 * Function: trim_array
 * @param {Array} $arr
 * @return {Array}
 * Returns the array with all values trimmed
 */

function trim_array( $arr ) {
	foreach ( $arr as $k => $v ) {
		if ( is_scalar( $v ) ) {
			$arr[ $k ] = trim( $v );
		}
		else if ( is_array( $v ) ) {
			$arr[ $k ] = trim_array( $v );
		}
		else {
			$arr[ $k ] = $v;
		}
	}

	return $arr;
}

/**
 * Function: merge_array
 * @param {Array} 1-n
 * @return {Array}
 * Mimics array_merge but checks for valid arrays
 */

function merge_array( ) {
	$args = func_get_args( );
	$result = array( );

	foreach ( $args as $arr ) {
		$arr = ( is_array( $arr ) ) ? trim_array( $arr ) : array( );

		$result = array_merge( $result, $arr );
	}

	return $result;
}

/**
 * Function: clean_array
 * @param {Array} $arr
 * @return {Array}
 * Cleans weird values from jQuery when posting JSON
 */

function clean_array( $arr ) {
	if ( !is_array( $arr ) ) $arr = array( );

	foreach ( $arr as &$param ) {
		if ( $param == 'null' || $param == '' ) $param = null;
	}
	unset( $param );

	return $arr;
}

/**
 * Function: extract_array
 * @param {Array} $arr
 * @param {Array} $keys
 * Returns an array with $keys from $arr
 */

function extract_array( $arr, $keys ) {
	if ( !is_array( $arr ) ) $arr = array( );
	$result = array( );

	foreach ( $arr as $key => $val ) {
		if ( in_array( $key, $keys ) ) {
			$result[ $key ] = $val;
		}
		else {
			$result[ $key ] = null;
		}
	}

	return $result;
}

/**
 * Function: array_changes
 * @param {Array} $old
 * @param {Array} $new
 * Returns the diff between two arrays
 */

function array_changes( $old, $new ) {
	$result = array(
		'add' => array_diff( $new, $old ),
		'delete' => array_diff( $old, $new ),
	);

	return $result;
}

?>
