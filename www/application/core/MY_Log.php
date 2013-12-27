<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Log extends CI_Log {
	protected $_log_db;

	/**
	 * Method: to_database
	 * @param {Bool} $status
	 * Sets the internal flag used to know if the database library is available and an error can be logged
	 */

	public function to_database( $status = false ) {
		$this->_log_db = $status;
	}

	/**
	 * Method: write_log
	 * @param {String} $level
	 * @param {String} $msg
	 * Parses and inserts error messages into the error database
	 */

	public function write_log( $level, $msg ) {
		parent::write_log( $level, $msg );

		$level = strtoupper( $level );
		if ( ( !isset( $this->_levels[ $level ] ) || ( $this->_levels[ $level ] > $this->_threshold ) ) && !isset( $this->_threshold_array[ $this->_levels[ $level ] ] ) ) {
			return false;
		}

		if ( $this->_log_db == true ) {
			$ci =& get_instance( );
			$ci->load->database( );

			$s = array( 'Severity: ', 'Notice  -->', 'Warning  -->', 'Error  -->', 'Query error:' );
			$r = array( '', '', '', '', '' );
			$msg = trim( str_replace( $s, $r, $msg ) );

			$line = trim( substr( $msg, strrpos( $msg, ' ' ) ) );
			$re = preg_match( '/\/[^ ]+/', $msg, $path );

			if ( count( $path ) > 0 ) {
				$msg = trim( substr( $msg, 0, strpos( $msg, '/' ) ) );
				$path = $path[ 0 ];
			}
			else if ( strpos( $msg, 'Invalid query:' ) !== false ) {
				$msg = str_replace( 'Invalid query: ', '', $msg );
				$path = 'database';
				$line = 0;
			}
			else {
				$msg = 'unknown';
				$path = 'unknown';
			}

			$data = array(
				'code' => 500,
				'message' => $msg,
				'file_path' => $path,
				'line_number' => $line,
				'ip_address' => $_SERVER[ 'REMOTE_ADDR' ],
				'created_datetime' => date( 'Y-m-d H:i:s' ),
			);

			$ci->db->insert( 'error', $data );
		}
	}
}

?>