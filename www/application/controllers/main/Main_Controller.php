<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require_once( APPPATH . 'controllers/system/System_Controller.php' );

// main is your default index page (http://localhost/)
// a route has been added to block direct access (http://localhost/main)

class Main_Controller extends System_Controller {
	/* public routes */

	public function index( ) {
		$data = array(
			'page_title' => 'Main',
		);

		$this->load->page( 'message', $data );
	}
}

?>