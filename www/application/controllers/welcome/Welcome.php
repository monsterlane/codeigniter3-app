<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require_once( APPPATH . 'controllers/system/System.php' );

class Welcome extends System_Controller {
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

		// load a page (system document) with this controllers message view as the main content
		$this->load->page( 'message', $data );
	}
}

?>