<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require_once( APPPATH . 'controllers/system/System_Controller.php' );

class Example_Controller extends System_Controller {
	/* public routes */

	public function index( ) {
		$data = array(
			'page_title' => 'Examples',
		);

		$this->load->page( 'examples', $data );
	}
}

?>