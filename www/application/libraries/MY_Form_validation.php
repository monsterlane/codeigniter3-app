<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Form_validation extends CI_Form_validation {
	/**
	 * Method: __construct
	 * Sets the default error deliminators and adds the date language file
	 */

	public function __construct( ) {
		parent::__construct( );

		$this->set_error_delimiters( '<p class="error">', '</p>' );

		$ci =& get_instance( );
		$ci->lang->load( 'form_validation_lang.php', 'english' );
	}

	/**
	 * Method: valid_date
	 * @param {String}
	 * Returns true if $str is a valid date
	 */

	public function valid_date( $str ) {
		if ( preg_match( '/([0-9]{2})\/([0-9]{2})\/([0-9]{4})\Z/', $str ) ) {
			$arr = explode( '/', $str );

			$mm = $arr[ 0 ];
			$dd = $arr[ 1 ];
			$yy = $arr[ 2 ];

			return checkdate( $mm, $dd, $yy );
		}
		else {
			return FALSE;
		}
	}
}

?>