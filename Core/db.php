<?php
	define('MYSQL_BOTH',MYSQLI_BOTH);
	define('MYSQL_NUM',MYSQLI_NUM);
	define('MYSQL_ASSOC',MYSQLI_ASSOC);
	
	function connectDB($tb = 'yearbook') {
		$db = new mysqli('localhost', 'root', 'Berlingo1998', $tb);
		if( $db->connect_errno ) {
			error_log( $db->connect_error );
			return False;
		}
		return $db;
	}
?>
