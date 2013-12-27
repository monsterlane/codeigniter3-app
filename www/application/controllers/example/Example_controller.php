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

	public function data( ) {
		// array of data to send back to the client
		$result = array(
			'status' => true,
			'message' => 'Hello from data.',
		);

		// output as json
		$this->output->json( $result );
	}

	public function view( ) {
		// array of data to send back to the client
		$result = array(
			'status' => true,
			'view' => $this->load->view( 'ajax', null, true ),
		);

		// output as json
		$this->output->json( $result );
	}

	public function form( ) {
		// pass the post data back to the client
		$result = $this->input->post( );

		$this->output->json( $result );
	}
}

?>