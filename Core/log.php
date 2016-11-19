<?php require_once( "db.php" );

class Log{

	public static function msg( $name, $content ) {
		if(!($db = connectDB()) ) return false;
		$db->query( "INSERT INTO `log` ( `name`, `content` ) VALUES ( '$name', '$content' )" );
	}
	public static function err( $name, $content ) {
		if(!($db = connectDB()) ) return false;
		$db->query( "INSERT INTO `log` ( `name`, `content` ) VALUES ( 'ERROR: $name', '$content' )" );
	}
	public static function getMessages( ) {
		if(!($db = connectDB()) ) return false;
		if(!($result = $db->query( "SELECT * FROM `Log` ORDER BY DATE DESC" ) ) ) return false;
		$ret = []; while(($e = $result->fetch_array(MYSQL_ASSOC))) { $ret[] = $e; }
		return $ret;
	}

}
?>
