<?php require_once( $_SERVER["DOCUMENT_ROOT"]."/Core/index.php" );
	if( $u = Login::checkUser() ) {
		$l = new Login();
		$l->logout( $u["token"] );
		header( "Location: /Signin/");
	}
?>
