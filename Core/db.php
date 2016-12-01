<?php
	if( !defined(MYSQL_BOTH ) ) define('MYSQL_BOTH', MYSQLI_BOTH );
	if( !defined(MYSQL_NUM  ) ) define('MYSQL_NUM',  MYSQLI_NUM  );
	if( !defined(MYSQL_ASSOC) ) define('MYSQL_ASSOC',MYSQLI_ASSOC);
	
	function connectDB($tb = 'yearbook') {
		$db = new mysqli('localhost', 'root', 'Sparky2000', $tb);
		if( $db->connect_errno ) {
			error_log( $db->connect_error );
			return False;
		}
		return $db;
	}
?>
