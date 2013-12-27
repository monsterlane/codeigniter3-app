<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

require_once( APPPATH . 'controllers/system/System_Controller.php' );

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