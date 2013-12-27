<?php

/**
 * Function: check_db
 * Sets a flag the in the logging class when the database class is available
 */

function check_db( ) {
	$ci =& get_instance( );
	$ci->log->to_database( true );
}

?>