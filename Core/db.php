<?php
	if( isset($_GET["debug"]) ) ini_set( "display_errors", "1" );
	else ini_set( "display_errors", "0" );
	function connectDB($tb = 'DB2787277') {
		$db = new mysqli('rdbms.strato.de', 'U2787277', 'Berlingo1998', $tb);
		if( $db->connect_errno ) {
			error_log( $db->connect_error );
			return False;
		}
		$result = $db->query("SET SQL_BIG_SELECTS=1");
		return $db;
	}
	function matchedRows( $mysqli ) {
		preg_match_all ('/(\S[^:]+): (\d+)/', $mysqli->info, $matches); 
    	$info = array_combine ($matches[1], $matches[2]);
    	return $info["Rows matched"];
	}
?>
