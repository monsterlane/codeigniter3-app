<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

require_once( APPPATH . 'third_party/minify/min/lib/JSMin.php' );
require_once( APPPATH . 'third_party/minify/min/lib/CSSmin.php' );

class MY_Loader extends CI_Loader {
	public function __construct( ) {
		parent::__construct( );

		// add hmvc style view paths
		$ci =& get_instance( );
		$path = strtolower( substr( $ci->router->class, 0, strpos( $ci->router->class, '_' ) ) );
		$this->_ci_view_paths[ APPPATH . 'controllers/' ] = true;
		$this->_ci_view_paths[ APPPATH . 'controllers/' . $path . '/views/' ] = true;
	}

	/**
	 * Method: _favicon
	 * @return {String/null}
	 * Returns a path if a favicon is found in the root directory or null if not
	 */

	private function _favicon( ) {
		$icon = null;

		if ( file_exists( FCPATH . 'favicon.ico' ) == true && is_file( FCPATH . 'favicon.ico' ) == true ) {
			$icon = '<link rel="shortcut icon" href="/favicon.ico" />';
		}

		return $icon;
	}

	/**
	 * Method: _meta_tags
	 * @param {Array} $data
	 * @return {String}
	 * Returns a string of meta tags
	 */

	private function _meta_tags( $data = array( ) ) {
		$result = array( );

		foreach ( $data as $name => $value ) {
			$result[ ] = '<meta name="' . form_prep( $name ) . '" content="' . form_prep( $value ) . '" />';
		}

		return implode( "\n", $result );
	}

	/**
	 * Method: _last_modified
	 * @param {Array} $files
	 * @return {DateTime}
	 * Returns the most recent last modified date/time of items in input array
	 */

	private function _last_modified( $files = array( ) ) {
		$last_mod = 0;

		foreach ( $files as $file ) {
			if ( !$mtime = @filemtime( '.' . $file ) ) {
				$mtime = time( );
			}

			if ( $last_mod < $mtime) {
				$last_mod = $mtime;
			}
		}

		return $last_mod;
	}

	/**
	 * Method: _block_cache
	 * @param {String} $key
	 * @param {Array} $assets
	 * @return {String}
	 * Returns a string of asset include statements with a timer appended to each filename (date modified)
	 */

	private function _block_cache( $type, $assets = array( ) ) {
		$result = array( );

		if ( $type == 'css' ) {
			$html = '<link href="%s" type="text/css" rel="stylesheet" media="screen" />';
		}
		else {
			$html = '<script src="%s" type="text/javascript"></script>';
		}

		foreach ( $assets as $group => $files ) {
			foreach ( $files as $file ) {
				if ( $group > 0 ) {
					$file .= '?t=' . @filemtime( '.' . $file );
				}

				$result[ ] = sprintf( $html, $file );
			}
		}

		return implode( "\n", $result );
	}

	/**
	 * Method: _check_cache
	 * @param {String} $key
	 * @param {Array} $assets
	 * @return {String}
	 * Returns a string of external and cached asset include statements
	 * All files in a group are combined into a single minified file named controller.datestamp.min.type
	 */

	private function _check_cache( $type, $assets = array( ) ) {
		$ci =& get_instance( );
		$css = new CSSmin( );
		$result = array( );

		if ( $type == 'css' ) {
			$html = '<link href="%s" type="text/css" rel="stylesheet" media="screen" />';
		}
		else {
			$html = '<script src="%s" type="text/javascript"></script>';
		}

		foreach ( $assets as $group => $files ) {
			if ( $group > 0 ) {
				$cache_name = ( $group > 1 ) ? strtolower( substr( $ci->router->class, 0, strpos( $ci->router->class, '_' ) ) ) : 'system';
				$cache_file = $cache_name . '.' . $this->_last_modified( $files ) . '.min.' . $type;
				$cache_path = $ci->config->item( 'cache_file_path' );

				if ( file_exists( $cache_path . $cache_file ) == false ) {
					$old = glob( $cache_path . $cache_name . '.*.min.' . $type );
					if ( is_array( $old ) && count( $old ) > 0 ) array_map( 'unlink', $old );

					$data = array( );
					foreach ( $files as $file ) {
						$content = file_get_contents( '.' . $file );

						if ( preg_match( '/(.min|-min|.pack|-pack)/', $file ) ) {
							$data[ ] = $content;
						}
						else if ( $type == 'js' ) {
							$data[ ] = JSMin::minify( $content );
						}
						else {
							$data[ ] = $css->run( $content );
						}
					}

					file_put_contents( $cache_path . $cache_file, implode( "\n", $data ) );
				}

				$result[ ] = sprintf( $html, $ci->config->item( 'cache_web_path' ) . $cache_file );
			}
			else {
				foreach ( $files as $file ) {
					$result[ ] = sprintf( $html, $file );
				}
			}
		}

		return implode( "\n", $result );
	}

	/**
	 * Method: page
	 * @param {String} $view
	 * @param {Array} $vars
	 * @param {Bool} $return
	 * Compiles $view with data $vars into system view
	 */

	public function page( $view, $vars = array( ), $return = false ) {
		$ci =& get_instance( );

		$icon = $this->_favicon( );
		$meta = $this->_meta_tags( $ci->get_meta_tags( ) );
		$module = ucfirst( substr( $ci->router->class, 0, strpos( $ci->router->class, '_' ) ) ) . 'Module';

		if ( $ci->config->item( 'cache_assets' ) === true ) {
			$css = $this->_check_cache( 'css', $ci->get_includes( 'css' ) );
			$js = $this->_check_cache( 'js', $ci->get_includes( 'js' ) );
		}
		else {
			$css = $this->_block_cache( 'css', $ci->get_includes( 'css' ) );
			$js = $this->_block_cache( 'js', $ci->get_includes( 'js' ) );
		}

		$data = array_merge( array(
			'page_icon' => $icon,
			'page_title' => null,
			'page_meta' => $meta,
			'page_css' => $css,
			'page_js' => $js,
			'page_module' => $module,
			'page_nav' => true,
			'page_section' => $ci->uri->segment( 1 ),
			'page_tab' => $ci->uri->segment( 2 ),
		), $vars );

		$data[ 'page_title' ] = ( $data[ 'page_title' ].'' != '' ) ? $data[ 'page_title' ] . ' | ' . $ci->config->item( 'app_name' ) : $ci->config->item( 'app_name' );
		$data[ 'page_content' ] = parent::view( $view, $data, true );

		return parent::view( 'system/views/document.php', $data, $return );
	}
}

?>