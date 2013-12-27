<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class System_Controller extends MY_Controller {
	/**
	 * Method: _meta_tags
	 * Add system wide meta tags
	 */

	 protected function _meta_tags( ) {
		$this->_meta( 'author', $this->config->item( 'app_author' ) );
		$this->_meta( 'description', $this->config->item( 'app_description' ) );
		$this->_meta( 'robots', 'index,follow' );
		$this->_meta( 'viewport', 'initial-scale=1.0,width=device-width' );
	}

	/**
	 * Method: _includes
	 * Add system wide assets
	 */

	protected function _includes( ) {
		$options = array( 'group' => 1 );

		$this->_include( 'reset.css', $options );
		$this->_include( 'style.css', $options );

		$this->_include( 'jquery.ui.min.js', $options );
		$this->_include( 'app.js', $options );
		$this->_include( 'app.conduit.js', $options );
		$this->_include( 'app.module.js', $options );
	}
}

?>