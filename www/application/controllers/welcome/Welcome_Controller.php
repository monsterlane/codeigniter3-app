<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require_once( APPPATH . 'controllers/system/System_Controller.php' );

class Welcome_Controller extends System_Controller {
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