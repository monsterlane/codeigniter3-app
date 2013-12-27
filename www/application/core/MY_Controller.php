<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Controller extends CI_Controller {
	protected $_meta;
	protected $_assets;

	public function __construct( ) {
		parent::__construct( );

		if ( ENVIRONMENT != 'development' ) {
			$this->db->save_queries = false;
		}

		$this->_meta = array( );
		$this->_meta_tags( );

		$this->_assets = array( 'css' => array( ), 'js' => array( ) );
		$this->_includes( );
	}

	/**
	 * Method: _meta_tags
	 * Placeholder method, controllers are expected to overload (system controller defines)
	 */

	protected function _meta_tags( ) { }

	/**
	 * Method: _meta_tag
	 * @param {String} $name
	 * @param {String} $value
	 */

	protected function _meta( $name, $value ) {
		$this->_meta[ $name ] = $value;
	}

	/**
	 * Method: _includes
	 * Placeholder method, controllers are expected to overload (system controller defines)
	 */

	protected function _includes( ) { }

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
	 * Method: get_meta_tags
	 * Returns the meta tags array
	 */

	public function get_meta_tags( ) {
		return $this->_meta;
	}

	/**
	 * Method: _get_includes
	 * @param {String} $key
	 * Returns the assets array for the given key
	 */

	public function get_includes( $key ) {
		$ci =& get_instance( );

		if ( array_key_exists( $key, $this->_assets ) == true ) {
			$data = $this->_assets[ $key ];
			$data[ 1 ][ ] = '/application/controllers/system/assets/js/script.js';

			$path = 'application/controllers/' . $ci->router->class . '/assets/js/script.js';
			if ( file_exists( FCPATH . $path ) == true && is_file( FCPATH . $path ) == true ) {
				$data[ 2 ][ ] = '/' . $path;
			}
		}
		else {
			$data = array( );
		}

		return $data;
	}
}

?>