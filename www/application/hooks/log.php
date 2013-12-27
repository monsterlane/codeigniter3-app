<?php

function check_db( ) {
	$ci =& get_instance( );
	$ci->log->to_database( true );
}

?>