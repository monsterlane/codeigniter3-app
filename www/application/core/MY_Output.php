<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Output extends CI_Output {
	public function __construct( ) {
		parent::__construct( );
	}

	/**
	 * Method: _get_request_headers
	 * Returns modified headers used when outputting images
	 */

	private function _get_request_headers( ) {
		if ( function_exists( 'apache_request_headers' ) ) {
			if ( $headers = apache_request_headers( ) ) {
				return $headers;
			}
		}

		$headers = array( );

		if ( isset( $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ] ) ) {
			$headers[ 'If-Modified-Since' ] = $_SERVER[ 'HTTP_IF_MODIFIED_SINCE' ];
		}

		return $headers;
	}

	/**
	 * Method: buffer
	 * Shorthand method to output buffer contents
	 */

	public function buffer( ) {
		$this->set_output( $this->get_output( ) );
	}

	/**
	 * Method: string
	 * Shorthand method to output a string
	 */

	public function string( $data ) {
		$this->set_output( $data );
	}

	/**
	 * Method: json
	 * Shorthand method to output as json
	 */

	public function json( $data ) {
		$this->set_output( json_encode( $data ) );
	}

	/**
	 * Method: image
	 * Shorthand method to output an image (w/ modified headers)
	 */

	public function image( $path, $type = 'image/png' ) {
		$headers = $this->_get_request_headers( );
		$modified = filemtime( $path );

		if ( isset( $headers[ 'If-Modified-Since' ] ) && strtotime( $headers[ 'If-Modified-Since' ] ) == $modified ) {
			header( 'Last-Modified: '. gmdate( 'D, d M Y H:i:s', $modified ) . ' GMT', true, 304 );
		}
		else {
			header( 'Last-Modified: '. gmdate( 'D, d M Y H:i:s', $modified ) . ' GMT', true, 200 );
			header( 'Content-type: ' . $type );
			header( 'Content-transfer-encoding: binary' );
			header( 'Content-length: '. filesize( $path ) );

			readfile( $path );
			exit;
		}
	}

	/**
	 * Method: minify
	 * @param {String} $output
	 * @param {String} $type
	 * Minifies content using an alternative regex better suited for inline-block layouts
	 */

	public function minify( $output, $type = 'text/html' ) {
		if ( $type == 'text/html' ) {
			if ( strlen( $output ) === 0 ) {
				return '';
			}

			$size_before = strlen( $output );

			if ( $output[ 0 ] == '{' || $output[ 0 ] == '[' ) {
				$json = json_decode( $output );

				if ( json_last_error( ) == JSON_ERROR_NONE ) {
					if ( property_exists( $json, 'view' ) === true ) {
						$json->view = preg_replace( '/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $json->view );
					}

					$output = json_encode( $json );
				}
				else {
					$output = preg_replace( '/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $output );
				}
			}
			else {
				$output = preg_replace( '/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $output );
			}

			$size_removed = $size_before - strlen( $output );
			$savings_percent = round( ( $size_removed / $size_before ) * 100 );

			log_message( 'debug', 'Minifier shaved ' . ( $size_removed / 1000 ) . 'KB (' . $savings_percent . '%) off final HTML output.' );

			return $output;
		}
		else {
			return parent::minify( $output, $type );
		}
	}
}

?>