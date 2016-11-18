<?php require_once( "db.php" );
	
	
	public static function msg( $name, $content ) {
		$db = $connectDB();
		$db->query( "INSERT INTO `log` ( `name`, `content` ) VALUES ( '$name', '$content' )" );
	}
	public static function err( $name, $content ) {
		$db = $connectDB();
		$db->query( "INSERT INTO `log` ( `name`, `content` ) VALUES ( 'ERROR: $name', '$content' )" );
	}
	
?>
