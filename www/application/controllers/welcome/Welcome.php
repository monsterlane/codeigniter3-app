<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Welcome extends MY_Controller {
	/* internal methods */

	protected function _includes( ) {
		// call the parent method
		parent::_includes( );

		// include controller level assets
		$this->_include( 'style.css' );
	}

	/* public routes */

	public function index( ) {
		$data = array(
			'page_title' => 'Welcome',
		);

		$this->load->page( 'message', $data );
	}
}

?>