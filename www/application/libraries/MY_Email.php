<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Email extends CI_Email {
	/**
	 * Method: __construct
	 * Sets the default from address
	 */

	public function __construct( ) {
		parent::__construct( );

		$ci =& get_instance( );
		$this->from( $ci->config->item( 'mail_from_address' ), $ci->config->item( 'mail_from_name' ) );
	}

	/**
	 * Method: clear
	 * @param {Bool} $clear_attachments
	 * Sets the default from address
	 */

	public function clear( $clear_attachments = false ) {
		parent::clear( $clear_attachments );

		$ci =& get_instance( );
		$this->from( $ci->config->item( 'mail_from_address' ), $ci->config->item( 'mail_from_name' ) );

		return $this;
	}

	/**
	 * Method: template
	 * @param {String} $view
	 * @param {Array} $data
	 * Compiles $view with $data and wraps in the header/footer template (replaces message)
	 */

	public function template( $view, $data = array( ) ) {
		$ci =& get_instance( );

		$header = $ci->load->view( 'emails/_header.php', null, true );
		$body = $ci->load->view( $view, $data, true );
		$footer = $ci->load->view( 'emails/_footer.php', null, true );

		$this->set_mailtype( 'html' );
		$this->message( $header . $body . $footer );
	}
}

?>