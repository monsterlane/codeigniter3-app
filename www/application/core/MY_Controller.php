<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Controller extends CI_Controller {
	protected $_assets;

	public function __construct( ) {
		parent::__construct( );

		if ( $this->config->item( 'maintenance_mode' ) == true && $this->router->class != 'maintenance_controller' ) {
			redirect( 'maintenance' );
		}

		if ( ENVIRONMENT != 'development' ) {
			$this->db->save_queries = false;
		}

		$this->_assets = array(
			'css' => array( ),
			'js' => array( ),
		);

		$this->_includes( );
	}

	protected function _includes( ) {
		$options = array( 'group' => 1 );

		$this->_include( 'reset.css', $options );
		$this->_include( 'style.css', $options );

		$this->_include( 'jquery.ui.min.js', $options );
		$this->_include( 'app.js', $options );
		$this->_include( 'app.conduit.js', $options );
		$this->_include( 'app.module.js', $options );
	}

	/**
	 * Method: _include
	 * @param {String} $file
	 * @param {Array} options
	 * Adds a css/js file to the internal assets array thats used to build include statements in load->page
	 * group 0 = external assets
	 * group 1 = system assets (every page)
	 * group 2 = controller assets
	 */

	protected function _include( $file, $options = array( ) ) {
		$key = substr( $file, strrpos( $file, '.' ) + 1 );

		if ( substr( $file, 0, 2 ) == '//' ) {
			$this->_assets[ $key ][ 0 ] = $file;
		}
		else {
			$group = ( array_key_exists( 'group', $options ) == true ) ? (int)$options[ 'group' ] : 2;
			$web_path = ( $group > 1 ) ? '/application/controllers/' . $this->router->class . '/assets/' . $key . '/' . $file : '/application/controllers/system/assets/' . $key . '/' . $file;
			$file_path = realpath( '.' . $web_path );

			if ( $file_path !== false && file_exists( $file_path ) == true && is_file( $file_path ) == true ) {
				$this->_assets[ $key ][ $group ][ ] = $web_path;
			}
		}
	}

	/**
	 * Method: _get_includes
	 * @param {String} $key
	 * Returns the assets array for the given key
	 */

	public function get_includes( $key ) {
		return ( array_key_exists( $key, $this->_assets ) == true ) ? $this->_assets[ $key ] : array( );
	}
}

?>