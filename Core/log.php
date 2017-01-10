<?php require_once( "db.php" );

class Log{

	public static function msg( $name, $content ) {
		if(!($db = new DB()) ) return false;
		$db->query( "INSERT INTO `log` ( `name`, `content` ) VALUES ( '§0', '§1' )",[$name,$content] );
	}
	public static function err( $name, $content ) {
		if(!($db = new DB()) ) return false;
		$db->query( "INSERT INTO `log` ( `name`, `content` ) VALUES ( 'ERROR: §0', '§1' )",[$name,$content] );
	}
	public static function getMessages() {
		if(!($db = new DB()) ) return false;
		if(!($result = $db->query( "SELECT `name`, `content`, `date` FROM `log` ORDER BY `date` DESC LIMIT 100" ) ) ) return false;
		$ret = []; while(($e = $result->fetch_array(MYSQL_ASSOC))) { $ret[] = $e; }
		return $ret;
	}

}
?>
