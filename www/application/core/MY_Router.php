<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Router extends CI_Router {
	// suffix to faux name-space controllers
	private $_suffix = '_controller';

	public function __construct( ) {
		parent::__construct( );
	}

	/**
	 * Method: _set_request
	 * @param {Array} $segments
	 * Modified core method to suffix controllers, check for changes when updating CI
	 */

	protected function _set_request( $segments = array( ) ) {
		$segments = $this->_validate_request( $segments );

		if (count( $segments ) === 0 ) {
			return $this->_set_default_controller( );
		}

		if ( $this->translate_uri_dashes === TRUE ) {
			$segments[ 0 ] = str_replace( '-', '_', $segments[ 0 ] );

			if ( isset( $segments[ 1 ] ) ) {
				$segments[ 1 ] = str_replace( '-', '_', $segments[ 1 ] );
			}
		}

		$this->set_class( ucfirst( $segments[ 0 ] ) . $this->_suffix );
		isset( $segments[ 1 ] ) OR $segments[ 1 ] = 'index';
		$this->set_method( $segments[ 1 ] );
		$this->uri->rsegments = $segments;
	}

	/**
	 * Method: _validate_request
	 * @param {Array} $segments
	 * Modified core method to suffix controllers, check for changes when updating CI
	 */

	protected function _validate_request( $segments ) {
		if ( count( $segments ) === 0 ) {
			return $segments;
		}

		$test = ucfirst( $this->translate_uri_dashes === TRUE ? str_replace( '-', '_', $segments[ 0 ] ) : $segments[ 0 ] );

		if ( file_exists( APPPATH . 'controllers/' . $test . $this->_suffix . '.php' ) ) {
			return $segments;
		}

		if ( is_dir( APPPATH . 'controllers/' . $segments[ 0 ] ) ) {
			$this->set_directory( array_shift( $segments ) );

			if ( count( $segments ) > 0 ) {
				$test = ucfirst( $this->translate_uri_dashes === TRUE ? str_replace( '-', '_', $segments[ 0 ] ) : $segments[ 0 ] );

				if ( !file_exists( APPPATH . 'controllers/' . $this->directory . $test . $this->_suffix . '.php' ) ) {
					if ( !empty( $this->routes[ '404_override' ] ) ) {
						$this->directory = '';

						return explode( '/', $this->routes[ '404_override' ], 2 );
					}
					else {
						show_404( $this->directory . $segments[ 0 ] );
					}
				}
			}
			else {
				$segments = explode( '/', $this->default_controller );

				if ( !file_exists( APPPATH . 'controllers/' . $this->directory . ucfirst( $segments[ 0 ] ) . $this->_suffix . '.php' ) ) {
					$this->directory = '';
				}
			}

			return $segments;
		}

		if ( !empty( $this->routes[ '404_override' ] ) ) {
			if (sscanf( $this->routes[ '404_override' ], '%[^/]/%s', $class, $method ) !== 2 ) {
				$method = 'index';
			}

			return array( $class, $method );
		}

		show_404( $segments[ 0 ] );
	}
}

?>