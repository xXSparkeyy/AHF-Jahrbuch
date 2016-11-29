<?php
	function connectDB($tb = 'yearbook') {
		$db = new mysqli('localhost', 'root', 'Berlingo1998', $tb);
		if( $db->connect_errno ) {
			error_log( $db->connect_error );
			return False;
		}
		return $db;
	}
?>
