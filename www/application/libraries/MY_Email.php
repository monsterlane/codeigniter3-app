<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Email extends CI_Email {
	private $_ci;

	public function __construct( ) {
		parent::__construct( );

		$this->_ci =& get_instance( );
		$this->from( $this->_ci->config->item( 'mail_from_address' ), $this->_ci->config->item( 'mail_from_name' ) );
	}

	public function clear( $clear_attachments = false ) {
		parent::clear( $clear_attachments );
		$this->from( $this->_ci->config->item( 'mail_from_address' ), $this->_ci->config->item( 'mail_from_name' ) );

		return $this;
	}

	public function template( $view, $data = array( ) ) {
		$header = $this->_ci->load->view( 'emails/_header.php', null, true );
		$footer = $this->_ci->load->view( 'emails/_footer.php', null, true );

		$body = $this->_ci->load->view( $view, $data, true );

		$this->set_mailtype( 'html' );
		$this->message( $header . $body . $footer );
	}
}

?>